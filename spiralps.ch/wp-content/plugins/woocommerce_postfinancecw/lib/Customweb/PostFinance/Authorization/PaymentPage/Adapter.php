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

require_once 'Customweb/Payment/Authorization/PaymentPage/IAdapter.php';
require_once 'Customweb/Payment/IConfigurationAdapter.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/I18n/Translation.php';

require_once 'Customweb/PostFinance/Authorization/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/PaymentPage/ParameterBuilder.php';
require_once 'Customweb/PostFinance/Util.php';
require_once 'Customweb/PostFinance/Authorization/Transaction.php';
require_once 'Customweb/PostFinance/Method/Factory.php';
require_once 'Customweb/Util/Url.php';

/**
 * This class implements the Customweb_Payment_Authorization_PaymentPage_IAdapter interface 
 * with the PostFinance payment page service.
 *           	 		    			 
 * @author Thomas Hunziker
 *
 */
class Customweb_PostFinance_Authorization_PaymentPage_Adapter extends Customweb_PostFinance_Authorization_AbstractAdapter 
	implements Customweb_Payment_Authorization_PaymentPage_IAdapter {
	
	private static $cache = array();
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_PaymentPage_ITransactionContext $transactionContext, $failedTransaction) {
		$transaction = new Customweb_PostFinance_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		return $transaction;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getVisibleFormFields()
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $customerPaymentContext) {
		$paymentMethod = Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration());
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, self::AUTHORIZATION_METHOD_NAME, false);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::isHeaderRedirectionSupported()
	 */
	public function isHeaderRedirectionSupported(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		$url = $this->getRedirectionUrl($transaction, $formData);
		
		// The max length can be up to 2000 chars. The limiting factor is here the user's browser and not
		// the server on which this API runs on!
		if (strlen($url) > 2000) {
			return false;
		}
		else {
			return true;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getRedirectionUrl()
	 */
	public function getRedirectionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		$url = $this->getPaymentPageUrl($transaction) . '?';
		$parameters = $this->getParameters($transaction, $formData);
		foreach ($parameters as $key => $value) {
			$url .= $key . '=' . urlencode($value) . '&';
		}
		
		$url = utf8_encode($url);
		return $url;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getParameters()
	 */
	public function getParameters(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		$builder = new Customweb_PostFinance_Authorization_PaymentPage_ParameterBuilder($transaction, $this->getConfiguration(), $formData);
		return $builder->buildParameters();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::getFormActionUrl()
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction, array $formData) {
		return $this->getPaymentPageUrl($transaction);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_PaymentPage_IAdapter::processNotification()
	 */
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		
		// In case the authorization failed, we stop processing here
		if ($transaction->isAuthorizationFailed()) {
			return;
		}
		
		// In case the transaction is authorized, we do not have to do anything here.           	 		    			 
		if ($transaction->isAuthorized()) {
			return;
		}
		
		
		$transaction->setAuthorizationParameters($parameters);
		$parameters = array_change_key_case($parameters, CASE_UPPER);
		if (!$this->validateResponse($parameters)) {
			$transaction->setAuthorizationFailed(
				Customweb_I18n_Translation::__(
					'The notification failed because the SHA signature seems not to be valid.'
				)
			);
		}
		else {
			$this->setTransactionAuthorizationState($transaction, $parameters);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::finalizeAuthorizationRequest()
	 */
	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction) {
		if ($transaction->isAuthorized()) {
			$url = $transaction->getTransactionContext()->getSuccessUrl();
		}
		else {
			$url = $transaction->getTransactionContext()->getFailedUrl();
		}
		
		$url = Customweb_Util_Url::appendParameters(
				$url,
				$transaction->getTransactionContext()->getCustomParameters()
		);
		
		header('Location: ' . $url);
		die();
	}
	
}


