<?php
/**
  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2013 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.customweb.ch/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.customweb.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

library_load_class_by_name('Customweb_Payment_Authorization_PaymentPage_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Recurring_IAdapter');
library_load_class_by_name('Customweb_Util_Url');

PostFinanceCwUtil::includeClass('PostFinanceCw_OrderContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_PaymentMethodWrapper');
PostFinanceCwUtil::includeClass('PostFinanceCw_AdapterFactory');
PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');
PostFinanceCwUtil::includeClass('PostFinanceCw_TransactionContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_ConfigurationAdapter');
PostFinanceCwUtil::includeClass('PostFinanceCw_RecurringTransactionContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_CartOrderContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_PaymentGatewayProxy');

/**           	 		    			 
 * This class handlers the main payment interaction with the
 * PostFinanceCw server.
 */
abstract class PostFinanceCw_AbstractPaymentMethod extends PostFinanceCw_PaymentGatewayProxy implements Customweb_Payment_Authorization_IPaymentMethod{

	public $class_name;
	public $id;
	public $title;
	public $chosen;
	public $has_fields = FALSE;
	public $countries;
	public $availability;
	public $enabled = 'no';
	public $icon;
	public $description;
	
	
	public function __construct() {
		$this->class_name = substr(get_class($this), 0, 39);
	
		$this->id = $this->class_name;
		$this->method_title = $this->admin_title;
		
		parent::__construct();
	
		$title = $this->getPaymentMethodConfigurationValue('title');
		if (!empty($title)) {
			$this->title = $title;
		}
		
		$this->description = $this->getPaymentMethodConfigurationValue('description');
	}

	/**
	 * @var PostFinanceCw_AdapterFactory
	 */
	private $adapterFactory = NULL;


	public function getPaymentMethodName() {
		return $this->machineName;
	}

	public function getPaymentMethodDisplayName() {
		return $this->title;
	}

	public function receipt_page( $order ) {
	}
	
	public function getBackendDescription() {
		return __('The configuration values for PostFinance can be set under:', 'woocommerce_postfinancecw') .
		' <a href="options-general.php?page=woocommerce-postfinancecw">' . __('PostFinance Settings', 'woocommerce_postfinancecw') . '</a>';
	}

	/**
	 * This method is called when the payment is submitted.
	 *
	 * @param int $order_id
	 */
	public function process_payment($order_id) {
		global $woocommerce;

		if (strtolower($this->getPaymentMethodConfigurationValue('validation')) == 'after') {
			try {
				$this->validateByOrder($order_id);
			}
			catch(Exception $e) {
				$this->showError($e->getMessage());
			}
		}
		
		// Bugfix to prevent the deletion of the cart, when the user goes back to the shop.
		unset($_SESSION['order_awaiting_payment']);
		if (isset($woocommerce)) {
			unset($woocommerce->session->order_awaiting_payment);
		}
		

		// Update order
		$order = PostFinanceCwUtil::loadOrderObjectById($order_id);
		$pendingStatus = 'postfinancecw-pending';
		$order->update_status($pendingStatus, __('The customer is now in the payment process of PostFinance.', 'woocommerce_postfinancecw'));
		$aliasTransactionId = $this->getCurrentSelectedAlias();
		if (is_ajax()) {
			try {
				$rs = $this->getPaymentForm($order_id, $aliasTransactionId);
				if (is_array($rs)) {
					return $rs;
				}
				echo "<script type=\"text/javascript\"> jQuery('form.checkout').replaceWith(jQuery('#postfinancecw-payment-container')); jQuery('.woocommerce-info').remove(); </script>";
				die(0);
			}
			catch(Exception $e) {
				$this->showError($e->getMessage());
			}
		}
		else {
			return array(
				'result' => 'success',
				'redirect' => PostFinanceCwUtil::getPluginUrl("payment.php", array('order_id' => $order_id, 'payment_method_class' => get_class($this), 'alias_transaction_id' => $aliasTransactionId)),
			);
		}
	}
	
	public function getCurrentSelectedAlias() {
		$aliasTransactionId = null;
		
		if (isset($_REQUEST[$this->getAliasHTMLFieldName()])) {
			$aliasTransactionId = $_REQUEST[$this->getAliasHTMLFieldName()];
		}
		else if (isset($_POST['post_data'])) {
			parse_str($_POST['post_data'], $data);
			if (isset($data[$this->getAliasHTMLFieldName()])) {
				$aliasTransactionId = $data[$this->getAliasHTMLFieldName()];
			}
		}
		
		return $aliasTransactionId;
	}
	
	private function showError($errorMessage) {
		echo '<div class="woocommerce-error">' . $errorMessage . '</div>';
		die();
	}

	public function validateByOrder($orderId) {
		$order = PostFinanceCwUtil::loadOrderObjectById($orderId);
		$orderContext = new PostFinanceCw_OrderContext($order, new PostFinanceCw_PaymentMethodWrapper($this));
		return $this->validate($orderContext);
	}
	
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		$paymentContext = new PostFinanceCw_PaymentCustomerContext($orderContext->getCustomerId());
		
		$adapter = $this->getAdapterFactory()->getAdapterByOrderContext($orderContext);
		
		// Validate transaction
		$errorMessage = null;
		try {
			$result = $adapter->validate($orderContext, $paymentContext);
		}
		catch(Exception $e) {
			$errorMessage = $e->getMessage();
		}
		$paymentContext->persist();
		
		if ($errorMessage !== null) {
			throw new Exception($errorMessage);
		}
		return true;
	}
	
	public function getPaymentForm($orderId, $aliasTransactionId = NULL, $failedTransactionId = NULL) {

		$order = PostFinanceCwUtil::loadOrderObjectById($orderId);
		$dbTransaction = $this->newDatabaseTransaction($order);
		$transactionContext = $this->getTransactionContext($dbTransaction, $order, $aliasTransactionId);
		$adapter = $this->getAdapterFactory()->getAdapterByOrderContext($transactionContext->getOrderContext());
		
		$failedTransaction = NULL;
		if ($failedTransactionId !== NULL) {
			$dbFailedTransaction = PostFinanceCw_Transaction::loadById($failedTransactionId);
			$failedTransaction = $dbFailedTransaction->getTransactionObject();
			if ($dbFailedTransaction->getUserId() !== $order->customer_user) {
				throw new Exception("Access to this transaction is not allowed for you.");
			}
		}
		$transaction = $adapter->createTransaction($transactionContext, $failedTransaction);
		$dbTransaction->setTransactionObject($transaction);
		$dbTransaction->save();

		$vars = $adapter->getCheckoutFormVaiables($dbTransaction, $failedTransaction);
		
		// In case the adapter provides already a result, we can return this directly.
		if (isset($vars['result'])) {
			return $vars;
		}
		
		if ($failedTransaction !== NULL) {
			$vars['error_message'] = current($failedTransaction->getErrorMessages());
		}

		if (!isset($vars['template_file'])) {
			throw new Exception("No template file provided by the authorization adapter.");
		}

		$template = $vars['template_file'];
		$vars['paymentMethod'] = $this;

		// In case we use the payment page and we have no additional fields, we should directly
		// send the customer to the redirection page:
		if (empty($vars['visible_fields']) && $failedTransaction !== NULL) {
			$payment_page = Customweb_Util_Url::appendParameters(
				get_permalink(get_option('woocommerce_checkout_page_id')), 
				array('postfinancecw_failed_transaction_id' => $failedTransactionId)
			);
			return array(
				'result' => 'success',
				'redirect' => $payment_page,
			);
		}
		
		if ($failedTransaction === NULL && $adapter instanceof Customweb_Payment_Authorization_PaymentPage_IAdapter && empty($vars['visible_fields'])) {
			return array(
				'result' => 'success',
				'redirect' => PostFinanceCwUtil::getPluginUrl("redirection.php", array('cw_transaction_id' => $dbTransaction->getTransactionId())),
			);
		}

		PostFinanceCwUtil::includeTemplateFile(str_replace('.php', '', $template), $vars);

		return null;
	}

	/**
	 * This method is invoked to check if the payment method is available for checkout.
	 */
	public function is_available() {
		
		global $woocommerce;
		
		$available = parent::is_available();
		
		if ($available !== true) {
			return null;
		}
		
		if (isset($woocommerce)) {
			$woocommerce->cart->calculate_totals();
			
			$orderTotal = $woocommerce->cart->total;
			if ($orderTotal < $this->getPaymentMethodConfigurationValue('min_total')) {
				return null;
			}
			if ($this->getPaymentMethodConfigurationValue('max_total') > 0 && $this->getPaymentMethodConfigurationValue('max_total') < $orderTotal) {
				return null;
			}
			
			// TODO: How to handle this?
			if (strtolower($this->getPaymentMethodConfigurationValue('validation')) == 'before') {
				$orderContext = $this->getCartOrderContext();
				if ($orderContext !== null) {
					try {
						$this->validate($orderContext);
					}
					catch(Exception $e) {
						return null;
					}
				}
			}
		}
		

		return true;
	}
	
	/**
	 * @return PostFinanceCw_CartOrderContext
	 */
	private function getCartOrderContext() {
		if (!isset($_POST['post_data'])) {
			return null;
		}
		
		parse_str($_POST['post_data'], $data);
		
		return new PostFinanceCw_CartOrderContext($data, new PostFinanceCw_PaymentMethodWrapper($this));
	}
	
	public function payment_fields() {
		parent::payment_fields();
		
		if (PostFinanceCw_ConfigurationAdapter::isAliasMangerActive()) {
			$userId = get_current_user_id();
			$aliases = PostFinanceCw_Transaction::getAliasTransactions($userId, $this->getPaymentMethodName());
				
			if (count($aliases) > 0) {
				$selectedAlias = $this->getCurrentSelectedAlias();
				
				echo '<div class="postfinancecw-alias-input-box"><div class="alias-field-description">' . __('You can choose a previous used card:', 'woocommerce_postfinancecw') . '</div>';
				echo '<select name="' . $this->getAliasHTMLFieldName() . '">';
				echo '<option value="new"> -' . __('Select card', 'woocommerce_postfinancecw') . '- </option>';
				foreach ($aliases as $aliasTransaction) {
					echo '<option value="' . $aliasTransaction->getTransactionId() . '"';
					if ($selectedAlias == $aliasTransaction->getTransactionId()) {
						echo ' selected="selected" ';
					}
					echo '>' . $aliasTransaction->getAliasForDisplay() . '</option>';
				}
				echo '</select></div>';
			}
		}
		
	
		$orderContext = $this->getCartOrderContext();
		if ($orderContext !== null) {
			$adapter = $this->getAdapterFactory()->getAdapterByOrderContext($orderContext);
			
			$aliasTransactionObject = null;
			$selectedAlias = $this->getCurrentSelectedAlias();
			
			if ($selectedAlias !== null) {
				$aliasTransaction = PostFinanceCw_Transaction::loadById($selectedAlias);
				if ($aliasTransaction !== null && $aliasTransaction->getUserId() == get_current_user_id()) {
					$aliasTransactionObject = $aliasTransaction->getTransactionObject();
				}
			}
			
			echo $adapter->getReviewFormFields($orderContext, $aliasTransactionObject);
		}
	
	}
	
	
	public function getAliasHTMLFieldName() {
		return 'postfinancecw_alias_' . $this->getPaymentMethodName();
	}
	

	/**
	 * @param WooComemrceOrder $order
	 * @return PostFinanceCw_Transaction
	 */
	protected function newDatabaseTransaction($order) {
		$transaction = new PostFinanceCw_Transaction();
		
		if (isset($order->customer_user)) {
			$userId = $order->customer_user;
		}
		else {
			$userId = $order->user_id;
		}
		
		return $transaction->setOrderId($order->id)->setUserId($userId)->setPaymentClassName(get_class($this))->save();
	}

	/**
	 *
	 * @param PostFinanceCw_Transaction $transaction
	 * @param WooCommerceOrder $order
	 * @param int $aliasTransactionId
	 * @return PostFinanceCw_TransactionContext
	 */
	private function getTransactionContext(PostFinanceCw_Transaction $transaction, $order, $aliasTransactionId = NULL) {
		return new PostFinanceCw_TransactionContext($transaction, $order, new PostFinanceCw_PaymentMethodWrapper($this), $aliasTransactionId);
	}

	public function getAdapterFactory() {
		if ($this->adapterFactory === NULL) {
			$this->adapterFactory = new PostFinanceCw_AdapterFactory();
		}

		return $this->adapterFactory;
	}

	public function processNotification(PostFinanceCw_Transaction $dbTransaction) {
		$authorizationMethod = $dbTransaction->getTransactionObject()->getAuthorizationMethod();
		$transaction = $dbTransaction->getTransactionObject();
		$adapter = $this->getAdapterFactory()->getAdapterByAuthorizationMethod($authorizationMethod);

		// Process the request and store the result
		$adapter->processAuthorization($transaction, $_REQUEST);
		$dbTransaction->save();

		// Produce the response to the client
		$this->updateOrderStatus($dbTransaction);
		$adapter->finalizeAuthorizationRequest($transaction);
		die();
	}

	protected function updateOrderStatus(PostFinanceCw_Transaction $dbTransaction) {
		global $woocommerce;

		if ($dbTransaction->getTransactionObject() === NULL) {
			throw new Exception("The transaction object is not set.");
		}

		if ($dbTransaction->getTransactionObject()->isAuthorized()) {
			// Ensure that the mail is send to the administrator
			$dbTransaction->getOrder()->update_status('pending');
				
			// Mark the transaction as completed
			$dbTransaction->getOrder()->payment_complete();
			
			
			if (class_exists('WC_Subscriptions_Order') && WC_Subscriptions_Order::order_contains_subscription($dbTransaction->getOrderId())) {
				WC_Subscriptions_Manager::activate_subscriptions_for_order($dbTransaction->getOrder());
			}
			
			
			// Remove cart
			if (isset($woocommerce)) {
				$woocommerce->cart->empty_cart();
			}
				
			// Update status
			$status = $dbTransaction->getTransactionObject()->getOrderStatus();
			$dbTransaction->getOrder()->update_status($status, __('Payment Notification', 'woocommerce_postfinancecw'));
				
			// Bugfix to ensure that the cart is emptied, when the customer returns to the shop
			$_SESSION['order_awaiting_payment'] = true;
			if (isset($woocommerce)) {
				$woocommerce->session->order_awaiting_payment = true;
			}
		}
		else if ($dbTransaction->getTransactionObject()->isAuthorizationFailed()) {
			$order = $dbTransaction->getOrder();
			$message = current($dbTransaction->getTransactionObject()->getErrorMessages());
			$order->add_order_note(__('Error Message: ', 'woocommerce_postfinancecw') . $message);
			$order->cancel_order();
		}
	}
	
	
	public function scheduledSubscriptionPayment($amountToCharge, $order, $productId) {
		global $postfinancecw_recurring_process_failure;
		$postfinancecw_recurring_process_failure = NULL;
		try {
			$adapter = $this->getAdapterFactory()->getAdapterByAuthorizationMethod(Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME);
			
			$dbTransaction = $this->newDatabaseTransaction($order);
			$transactionContext = new PostFinanceCw_RecurringTransactionContext($dbTransaction, $order, $this, $amountToCharge, $productId);
			$transaction = $adapter->createTransaction($transactionContext);
			$dbTransaction->setTransactionObject($transaction);
			$dbTransaction->save();
			$adapter->process($transaction);
			$dbTransaction->save();
			
			if (!$transaction->isAuthorized()) {
				$message = current($transaction->getErrorMessages());
				throw new Exception($message);
			}
			
			WC_Subscriptions_Manager::process_subscription_payments_on_order($order);
		}
		catch(Exception $e) {
			$errorMessage = __('Subscription Payment Failed with error:', 'woocommerce_postfinancecw') . $e->getMessage();
			$postfinancecw_recurring_process_failure = $errorMessage;
			$order->add_order_note($errorMessage);
			WC_Subscriptions_Manager::process_subscription_payment_failure_on_order($order, $product_id);
		}
	}
	

	/**
	 * This method generates a HTML form for each payment method.
	 */
	public function createMethodFormFields() {
		return array(
			'enabled' => array(
				'title' => __('Enable/Disable', 'woocommerce_postfinancecw'),
				'type' => 'checkbox',
				'label' => sprintf(__('Enable %s', 'woocommerce_postfinancecw'), $this->admin_title),
				'default' => 'no'
			),
			'title' => array(
				'title' => __('Title', 'woocommerce_postfinancecw'),
				'type' => 'text',
				'description' => __('This controls the title which the user sees during checkout.', 'woocommerce_postfinancecw'),
				'default' => __($this->title, 'woocommerce_postfinancecw')
			),
			'description' => array(
				'title' => __('Description', 'woocommerce_postfinancecw'),
				'type' => 'textarea',
				'description' => __('This controls the description which the user sees during checkout.', 'woocommerce_postfinancecw'),
				'default' => sprintf(__("Pay with %s over the interface of PostFinance.", 'woocommerce_postfinancecw'), $this->title)
			),
			'min_total' => array(
				'title' => __('Minimal Order Total', 'woocommerce_postfinancecw'),
				'type' => 'text',
				'description' => __('Set here the minimal order total for which this payment method is available. If it is set to zero, it is always available.', 'woocommerce_postfinancecw'),
				'default' => 0,
			),
			'max_total' => array(
				'title' => __('Maximal Order Total', 'woocommerce_postfinancecw'),
				'type' => 'text',
				'description' => __('Set here the maximal order total for which this payment method is available. If it is set to zero, it is always available.', 'woocommerce_postfinancecw'),
				'default' => 0,
			),
			'validation' => array(
				'title' => __('Validation', 'woocommerce_postfinancecw'),
				'type' => 'select',
				'description' => __('The validation of the payment can be carried out at various points during the order process. The validation can be controlled with this option.', 'woocommerce_postfinancecw'),
				'options' => array(
					'before' => __('Before selection of payment method', 'woocommerce_postfinancecw'),
					'after' => __('After selection of payment method', 'woocommerce_postfinancecw'),
					'authorization' => __('During the authorization', 'woocommerce_postfinancecw'),
				),
				'default' => 'after',
			),
		);
	}
	
	protected function getOrderStatusOptions($statuses = array()) {
		$terms = get_terms('shop_order_status', array('hide_empty' => 0, 'orderby' => 'id'));
			
		foreach ($statuses as $k => $value) {
			$statuses[$k] =  __($value, 'woocommerce_postfinancecw');
		}
		
		foreach ($terms as $term) {
			$statuses[$term->slug] = $term->name;
		}
		return $statuses;
	}

	public static function refundTransaction(PostFinanceCw_Transaction $dbTransaction, $amount, $close) {
		$adapter = PostFinanceCw_AdapterFactory::getRefundAdapter();
		$items = Customweb_Util_Invoice::getItemsByReductionAmount($dbTransaction->getTransactionObject()->getTransactionContext()->getOrderContext()->getInvoiceItems(), 
					$amount,
					$dbTransaction->getTransactionObject()->getCurrencyCode()
		);
		$rs = $adapter->partialRefund($dbTransaction->getTransactionObject(), $items, $close);
		$dbTransaction->save();
		return $rs;
	}
	
	public static function cancelTransaction(PostFinanceCw_Transaction $dbTransaction) {
		$adapter = PostFinanceCw_AdapterFactory::getCancellationAdapter();
		$rs = $adapter->cancel($dbTransaction->getTransactionObject());
		$dbTransaction->save();
		
		$status = $dbTransaction->getTransactionObject()->getOrderStatus();
		$dbTransaction->getOrder()->update_status($status, __('Payment Cancelled', 'woocommerce_postfinancecw'));
		return $rs;
	}
	
	public static function captureTransaction(PostFinanceCw_Transaction $dbTransaction, $amount, $close) {
		$adapter = PostFinanceCw_AdapterFactory::getCapturingAdapter();
		$items = Customweb_Util_Invoice::getItemsByReductionAmount($dbTransaction->getTransactionObject()->getTransactionContext()->getOrderContext()->getInvoiceItems(),
				$amount,
				$dbTransaction->getTransactionObject()->getCurrencyCode()
		);
		$rs = $adapter->partialCapture($dbTransaction->getTransactionObject(), $items, $close);
		$dbTransaction->save();
		
		$status = $dbTransaction->getTransactionObject()->getOrderStatus();
		$dbTransaction->getOrder()->update_status($status, __('Payment Captured', 'woocommerce_postfinancecw'));
		return $rs;
	}

}
