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

library_load_class_by_name('Customweb_Payment_Authorization_PaymentPage_ITransactionContext');
library_load_class_by_name('Customweb_Payment_Authorization_Hidden_ITransactionContext');
library_load_class_by_name('Customweb_Payment_Authorization_Server_ITransactionContext');
library_load_class_by_name('Customweb_Payment_Authorization_Iframe_ITransactionContext');
library_load_class_by_name('Customweb_Payment_Authorization_DefaultInvoiceItem');
library_load_class_by_name('Customweb_Payment_Authorization_Ajax_ITransactionContext');

PostFinanceCwUtil::includeClass('PostFinanceCw_PaymentCustomerContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_OrderContext');

class PostFinanceCw_TransactionContext implements Customweb_Payment_Authorization_PaymentPage_ITransactionContext, 
Customweb_Payment_Authorization_Hidden_ITransactionContext, Customweb_Payment_Authorization_Server_ITransactionContext,
Customweb_Payment_Authorization_Iframe_ITransactionContext, Customweb_Payment_Authorization_Ajax_ITransactionContext
{
	protected $capturingMode;
	protected $aliasTransactionId = NULL;
	protected $paymentCustomerContext = null;
	protected $orderContext;
	protected $databaseTransactionId = NULL;
	protected $userId = NULL;
	
	private $databaseTransaction = NULL;

	public function __construct(PostFinanceCw_Transaction $transaction, $order, $paymentMethod, $aliasTransactionId = NULL) {
		
		if (isset($order->customer_user)) {
			$this->userId = $order->customer_user;
		}
		else {
			$this->userId = $order->user_id;
		}
		
		$aliasTransactionIdCleaned = NULL;
		$userId = intval($this->userId);
		if (PostFinanceCw_ConfigurationAdapter::isAliasMangerActive() && $userId > 0) {
			if ($aliasTransactionId === NULL || $aliasTransactionId === 'new') {
				$aliasTransactionIdCleaned = 'new';
			}
			else {
				$aliasTransactionIdCleaned = intval($aliasTransactionId);
			}
		}
		
		$this->aliasTransactionId = $aliasTransactionIdCleaned;
		
		$this->paymentCustomerContext = new PostFinanceCw_PaymentCustomerContext($this->userId);
		$this->orderContext = new PostFinanceCw_OrderContext($order, $paymentMethod, $this->userId);
		$this->databaseTransaction = $transaction;
		$this->databaseTransactionId = $transaction->getTransactionId();
		$this->capturingMode = $this->getOrderContext()->getPaymentMethod()->getPaymentMethodConfigurationValue("capturing");
	}
	
	/**
	 * @return PostFinanceCw_Transaction
	 */
	public function getDatabaseTransaction() {
		if ($this->databaseTransaction === NULL) {
			$this->databaseTransaction = PostFinanceCw_Transaction::loadById($this->databaseTransactionId);
		}
		
		return $this->databaseTransaction;
	}
	
	public function __sleep() {
		return array('capturingMode', 'aliasTransactionId', 'paymentCustomerContext', 'orderContext', 'databaseTransactionId', 'userId');
	}
	
	public function getOrderContext() {
		return $this->orderContext;
	}

	public function getTransactionId() {
		return $this->getDatabaseTransaction()->getTransactionNumber();
	}

	public function getCapturingMode() {
		if ($this->capturingMode == 'direct') {
			return Customweb_Payment_Authorization_PaymentPage_ITransactionContext::CAPTURING_MODE_DIRECT;
		}
		else {
			return Customweb_Payment_Authorization_PaymentPage_ITransactionContext::CAPTURING_MODE_DEFERRED;
		}
	}
	
	public function createRecurringAlias() {
		if ($this->getOrderContext()->isSubscription()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function getAlias() {
		if ($this->aliasTransactionId === 'new') {
			return 'new';
		}
		
		if ($this->aliasTransactionId !== null) {
			$transcation = PostFinanceCw_Transaction::loadById($this->aliasTransactionId);
			if ($transcation !== null && $transcation->getTransactionObject() !== null && $transcation->getUserId() == $this->userId) {
				return $transcation->getTransactionObject();
			}
		}

		return null;
	}

	public function getCustomParameters() {
		$params = array(
			'cw_transaction_id' => $this->getDatabaseTransaction()->getTransactionId(),
		);
		
		$params = apply_filters('postfinancecw_custom_parameters', $params);
		return $params;
	}

	public function getSuccessUrl() {
		$order = $this->getOrderContext()->getOrderObject();
		$checkout_redirect = apply_filters( 'woocommerce_get_checkout_redirect_page_id', get_option( 'woocommerce_thanks_page_id' ) );
		return add_query_arg('key', $order->order_key, add_query_arg('order', $order->id, get_permalink( $checkout_redirect )));
	}

	public function getFailedUrl() {
		return PostFinanceCwUtil::getPluginUrl('payment.php');
	}

	public function getPaymentCustomerContext() {
		return $this->paymentCustomerContext;
	}

	public function getNotificationUrl() {
		return PostFinanceCwUtil::getPluginUrl('notification.php');
	}
	
	public function getIframeBreakOutUrl() {
		return PostFinanceCwUtil::getPluginUrl('iframe_breakout.php');
	}
	
	
	public function getJavaScriptSuccessCallbackFunction() {
		return '
		function (redirectUrl) {
			window.location = redirectUrl
		}';
	}
	
	public function getJavaScriptFailedCallbackFunction() {
		return '
		function (redirectUrl) {
			window.location = redirectUrl
		}';
	}
		

}