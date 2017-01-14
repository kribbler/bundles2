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

PostFinanceCwUtil::includeClass('PostFinanceCw_AbstractPaymentMethod');

/**           	 		    			 
 * This class handlers the main payment interaction with the
 * PostFinanceCw server.
 */
class PostFinanceCw_PaymentMethod extends PostFinanceCw_AbstractPaymentMethod {

	public function __construct() {
		
		$this->class_name = substr(get_class($this), 0, 39);
		
		$this->id = $this->class_name;
		$this->method_title = $this->admin_title;
		
		// Load the form fields.
		$this->form_fields = $this->createMethodFormFields();
		
		// Load the settings.
		$this->init_settings();
		
		parent::__construct();
		
		// Workaround: When some setting is stored all PostFinanceCw methods are
		// deactivated. With this check we allow the storage only in case the class
		// is called from the payment_gateways tab.
		if (stristr($_SERVER['QUERY_STRING'], 'tab=payment_gateways')) {
			if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.0.0') >= 0) {
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			}
			else {
				add_action('woocommerce_update_options', array(&$this, 'process_admin_options'));
			}
		}
		
		
		if ($this->getPaymentMethodConfigurationValue('enabled') == 'yes') {
			$adapter = $this->getAdapterFactory()->getAdapterByAuthorizationMethod(Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME);
			if ($adapter->isPaymentMethodSupportingRecurring($this)) {
				$this->supports = array(
					'subscriptions',
					'products',
					'subscription_cancellation',
					'subscription_reactivation',
					'subscription_suspension',
					'subscription_amount_changes',
					'subscription_date_changes',
					'product_variation'
				);
			}
		}
		add_action('scheduled_subscription_payment_' . $this->id, array(&$this, 'scheduledSubscriptionPayment'), 10, 3);
		
	}
	
	
	public function getPaymentMethodConfigurationValue($key, $languageCode = null) {
		return $this->settings[$key];
	}
	
	public function existsPaymentMethodConfigurationValue($key, $languageCode = null) {
		if (isset($this->settings[$key])) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Generate the HTML output for the settings form.
	 */
	public function admin_options() {
		$output = '<h3>' . __($this->admin_title, 'woocommerce_postfinancecw') . '</h3>';
		$output .= '<p>' . $this->getBackendDescription() . '</p>';
	
		$output .= '<table class="form-table">';
	
		echo $output;
	
		$this->generate_settings_html();
	
		echo '</table>';
	}
	
	function generate_select_html ( $key, $data ) {
		// We need to override this method, because we need to get
		// the order status, after we defined the form fields. The
		// terms are not accessible before.
		if (isset($data['is_order_status']) && $data['is_order_status'] == true) {
			if (isset($data['options']) && is_array($data['options'])) {
				$data['options'] = $this->getOrderStatusOptions($data['options']);
			}
			else {
				$data['options'] = $this->getOrderStatusOptions();
			}
		}
		return parent::generate_select_html($key, $data);
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
	
	
}
