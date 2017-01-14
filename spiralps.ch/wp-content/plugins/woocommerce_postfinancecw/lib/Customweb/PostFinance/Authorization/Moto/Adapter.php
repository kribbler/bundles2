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

require_once 'Customweb/PostFinance/Authorization/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/Server/Adapter.php';
require_once 'Customweb/PostFinance/Authorization/PaymentPage/Adapter.php';
require_once 'Customweb/PostFinance/Authorization/Hidden/Adapter.php';
require_once 'Customweb/Payment/Authorization/Moto/IAdapter.php';


class Customweb_PostFinance_Authorization_Moto_Adapter extends Customweb_PostFinance_Authorization_AbstractAdapter implements Customweb_Payment_Authorization_Moto_IAdapter{
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_PaymentPage_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Moto_ITransactionContext $transactionContext, $failedTransaction){
		$adapter = $this->getAdapterInstanceByPaymentMethod($transactionContext->getOrderContext()->getPaymentMethod());
		$transaction = $adapter->createTransaction($transactionContext, $failedTransaction);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);	
		return $transaction;
	}
	
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $customerPaymentContext) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($orderContext->getPaymentMethod());
		return Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration())->getFormFields($orderContext, $aliasTransaction, $failedTransaction, $adapter->getAuthorizationMethodName(), true);
	}
	
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getPaymentMethod());
		if ($adapter instanceof Customweb_PostFinance_Authorization_Hidden_Adapter) {
			return $adapter->getFormActionUrl($transaction);
		}
		else {
			return $transaction->getTransactionContext()->getNotificationUrl();
		}
	}
	
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getPaymentMethod());
		if ($adapter instanceof Customweb_PostFinance_Authorization_Hidden_Adapter) {
			return $adapter->getHiddenFormFields($transaction);
		}
		else {
			return $transaction->getTransactionContext()->getCustomParameters();
		}
	}

	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		global $postfinance_form_url, $postfinance_form_parameters;
		
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getPaymentMethod());
		if ($adapter instanceof Customweb_PostFinance_Authorization_Hidden_Adapter) {
			return $adapter->processAuthorization($transaction, $parameters);
		}
		else {
			// Check if this is a callback
			if (isset($parameters['STATUS'])) {
				return $adapter->processAuthorization($transaction, $parameters);
			}
			else {
				$postfinance_form_url = $adapter->getFormActionUrl($transaction, $parameters);
				$postfinance_form_parameters = $adapter->getParameters($transaction, $parameters);
				return;
			}
		}
		
	}
	
	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction) {
		$adapter = $this->getAdapterInstanceByPaymentMethod($transaction->getPaymentMethod());
		if ($adapter instanceof Customweb_PostFinance_Authorization_Hidden_Adapter) {
			$adapter->finalizeAuthorizationRequest($transaction);
		}
		else {
			global $postfinance_form_url, $postfinance_form_parameters;
			
			if (isset($postfinance_form_url) && !empty($postfinance_form_url)) {
				echo '<html><body>';
					echo '<form name="redirectionform" action="' . $postfinance_form_url . '" method="POST">';
						foreach ($postfinance_form_parameters as $key => $value) {
							echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
						}
						echo '<noscript>';
							echo '<input type="submit" name="complete" value="' . Customweb_I18n_Translation::__('Continue') . '" />';
						echo '</noscript>';
					echo '</form>';
				
					echo '<script type="text/javascript"> ' . "\n";
						echo ' document.redirectionform.submit(); ' . "\n";
					echo '</script>';
				echo '</body></html>';
				die();
			}
			else {
				$adapter->finalizeAuthorizationRequest($transaction);
			}
		}
	}
	
	protected function getAdapterInstanceByPaymentMethod(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$configuredAuthorizationMethod = $paymentMethod->getPaymentMethodConfigurationValue('authorizationMethod');
		switch (strtolower($configuredAuthorizationMethod)) {
			
			// In case the server mode is choosen, we stick to the hidden, for simplicity.
			case strtolower(Customweb_PostFinance_Authorization_Server_Adapter::AUTHORIZATION_METHOD_NAME):
			case strtolower(Customweb_PostFinance_Authorization_Hidden_Adapter::AUTHORIZATION_METHOD_NAME):
			
			// Payment Page is not supported for MoTo. This may be different in future.
			case strtolower(Customweb_PostFinance_Authorization_PaymentPage_Adapter::AUTHORIZATION_METHOD_NAME):
				return new Customweb_PostFinance_Authorization_Hidden_Adapter($this->getConfiguration()->getConfigurationAdapter());
			default:
				throw new Exception(Customweb_I18n_Translation::__("Could not find an adapter for the authoriztion method !methodName.", array('!methodName' => $configuredAuthorizationMethod)));
		}
	}
	
	
}