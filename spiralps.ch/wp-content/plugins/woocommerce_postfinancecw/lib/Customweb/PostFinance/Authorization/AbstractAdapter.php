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

require_once 'Customweb/PostFinance/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/Server/ParameterBuilder.php';

abstract class Customweb_PostFinance_Authorization_AbstractAdapter extends Customweb_PostFinance_AbstractAdapter {

	abstract public function getAuthorizationMethodName();
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::validate()
	 */
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext,
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext) {
		$paymentMethod = Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration());
		$paymentMethod->validate($orderContext, $paymentContext);
		return true;
	}
	
	public function isDeferredCapturingSupported(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext) {
		return $orderContext->getPaymentMethod()->existsPaymentMethodConfigurationValue('capturing');
	}
	
	
	/**
	 * (non-PHPdoc)           	 		    			 
	 * @see Customweb_Payment_Authorization_IAdapter::isAuthorizationMethodSupported()
	 */
	public function isAuthorizationMethodSupported(Customweb_Payment_Authorization_IOrderContext $orderContext) {
		$paymentMethod = Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration());
		return $paymentMethod->isAuthorizationMethodSupported($this->getAuthorizationMethodName());
	}
	
	public function authorize(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
	
		// In case the authorization failed, we stop processing here
		if ($transaction->isAuthorizationFailed()) {
			return;
		}
	
		// In case the transaction is authorized, we do not have to do anything here.           	 		    			 
		if ($transaction->isAuthorized()) {
			return;
		}
	
		// In case we have authorized the transaction at the remote side, but we have not already processed the
		// 3D response, we have to do it now
		if ($transaction->is3dRedirectionRequired()) {
				
			$parameters = array_change_key_case($parameters, CASE_UPPER);
			if (!isset($parameters['SHASIGN'])) {
				$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__("The request does not contain a 'SHASIGN' parameter. The cause is that the callback in the background is not executed."));
			}
			else if ($this->validateResponse($parameters)) {
				$this->setTransactionAuthorizationState($transaction, $parameters);
			}
			else {
				$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__("The SHA signature of the 3D Secure callback was not valid."));
			}
		}
	
		// In all other cases we have to send the authorization request to the remote side
		else {
			try {
				$builder = new Customweb_PostFinance_Authorization_Hidden_AuthorizationParameterBuilder($transaction, $this->getConfiguration(), $parameters);
				$parameters = $builder->buildParameters();
				$response = $this->sendDirectRequest($this->getDirectOrderUrl(), $parameters);
				
				// In any case dont save the CVC           	 		    			 
				unset($parameters['CVC']);
				
				$transaction->setDirectLinkCreationParameters($parameters);
				$transaction->setAuthorizationParameters($response);
					
				// Check whether a 3D secure redirection is required or not.
				if (!$transaction->is3dRedirectionRequired()) {
					$this->setTransactionAuthorizationState($transaction, $response);
				}
			}
			catch(Exception $e) {
				$transaction->setAuthorizationFailed($e->getMessage());
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::finalizeAuthorizationRequest()
	 */
	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction) {
	
		if ($transaction->isAuthorizationFailed()) {
			if (Customweb_Payment_Authorization_Moto_IAdapter::AUTHORIZATION_METHOD_NAME == $transaction->getAuthorizationMethod()) {
				header('Location: ' . $transaction->getBackendFailedUrl());
			}
			else {
				header('Location: ' . $transaction->getFailedUrl());
			}
			die();
		}
	
		if ($transaction->isAuthorized()) {
			if (Customweb_Payment_Authorization_Moto_IAdapter::AUTHORIZATION_METHOD_NAME == $transaction->getAuthorizationMethod()) {
				header('Location: ' . $transaction->getBackendSuccessUrl());
			}
			else {
				header('Location: ' . $transaction->getSuccessUrl());
			}
			die();
		}
	
		// Handle 3D secure case
		if (!$transaction->isAuthorized()) {
			if ($transaction->is3dRedirectionRequired()) {
				$parameters = $transaction->getAuthorizationParameters();
				@ob_end_clean();
				echo base64_decode($parameters['HTML_ANSWER']);
				exit;
			}
		}
	
		die("The transaction is in a bad state.");
	}
	
}