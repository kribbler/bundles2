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

require_once 'Customweb/Payment/Authorization/Hidden/IAdapter.php';
require_once 'Customweb/Payment/IConfigurationAdapter.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/IOrderContext.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Form/ElementFactory.php';

require_once 'Customweb/PostFinance/Authorization/Server/Adapter.php';
require_once 'Customweb/PostFinance/Authorization/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/Hidden/AliasGatewayParameterBuilder.php';
require_once 'Customweb/PostFinance/Configuration.php';
require_once 'Customweb/PostFinance/Util.php';
require_once 'Customweb/PostFinance/Authorization/Transaction.php';
require_once 'Customweb/PostFinance/Authorization/Hidden/AuthorizationParameterBuilder.php';

class Customweb_PostFinance_Authorization_Hidden_Adapter extends Customweb_PostFinance_Authorization_AbstractAdapter 
	implements Customweb_Payment_Authorization_Hidden_IAdapter {
	
	public function __construct(Customweb_Payment_IConfigurationAdapter $configuration) {
		parent::__construct($configuration);
	}
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Hidden_ITransactionContext $transactionContext, $failedTransaction) {
		$transaction = new Customweb_PostFinance_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		
		// Keep the same alias transaction id over multiple transactions, to prevent the customer to renter all the data 
		// on multiple tries           	 		    			 
		if ($failedTransaction !== null) {
			$aliasTransactionId = $failedTransaction->getAliasTransactionId();
			if ($aliasTransactionId == null) {
				$transaction->setAliasTransactionId($failedTransaction->getTransactionContext()->getTransactionId());
			}
			else {
				$transaction->setAliasTransactionId($aliasTransactionId);
			}
			$transaction->setAliasGatewayAlias($failedTransaction->getAliasGatewayAlias());
			
			$rs = $failedTransaction->getAliasCreationResponse();
			$transaction->setAliasCreationResponse($rs);
		}
		
		return $transaction;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getHiddenFormFields()
	 */
	public function getHiddenFormFields(Customweb_Payment_Authorization_ITransaction $transaction) {
		$builder = new Customweb_PostFinance_Authorization_Hidden_AliasGatewayParameterBuilder($transaction, $this->getConfiguration());
		return $builder->buildParameters();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getFormActionUrl()
	 */
	public function getFormActionUrl(Customweb_Payment_Authorization_ITransaction $transaction) {
		return $this->getHiddenAuthorizationUrl();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Hidden_IAdapter::getVisibleFormFields()
	 */
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $customerPaymentContext) {
		$paymentMethod = Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration());
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, self::AUTHORIZATION_METHOD_NAME, false);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::processAuthorization()
	 */
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		
		// Check if it is required to check the validation response           	 		    			 
		if (!$transaction->isAuthorizationFailed() && !$transaction->isAuthorized() && !$transaction->is3dRedirectionRequired()) {
			
			$parameters = array_change_key_case($parameters, CASE_UPPER);
			
			$paramsToStore = $parameters;
			
			// If we have already some data for this alias, we merge in the new values.
			if (is_array($transaction->getAliasCreationResponse())) {
				$paramsToStore = $transaction->getAliasCreationResponse();
				foreach ($parameters as $key => $value) {
					if (!empty($value)) {
						$paramsToStore[$key] = $value;
					}
				}
			}
			$transaction->setAliasCreationResponse($paramsToStore);
			
			if (isset($parameters['ALIAS'])) {
				$transaction->setAliasGatewayAlias($parameters['ALIAS']);
			}
			
			// Check status first, because the SHA OUT is not set in error case:
			if ($parameters['STATUS'] == '1') {
				$message = Customweb_I18n_Translation::__("Some input was invalid.");
				if ($parameters['NCERROR'] == '50001184') {
					$message = Customweb_I18n_Translation::__("SAH IN signature is wrong.");
				}
				else if ($parameters['NCERROR'] == '5555554') {
					$message = Customweb_I18n_Translation::__("The transaction id is incorrect.");
				}
				else if ($parameters['NCERROR'] == '50001186') {
					$message = Customweb_I18n_Translation::__("Operation is not supported.");
				}
				else if ($parameters['NCERROR'] == '50001187') {
					$message = Customweb_I18n_Translation::__("Operation is not allowed.");
				}
				else if ($parameters['NCERROR'] == '50001300') {
					$message = Customweb_I18n_Translation::__("Wrong 'BRAND' was specified.");
				}
				else if ($parameters['NCERROR'] == '50001301') {
					$message = Customweb_I18n_Translation::__("Wrong bank account format.");
				}
				
				$transaction->setAuthorizationFailed($message);
				return;
			}
			
			// Validate input
			if (!$this->validateResponse($parameters)) {
				$transaction->setAuthorizationFailed(Customweb_I18n_Translation::__("The SHA signatures do not match."));
				return;
			}
		}
		
		$this->authorize($transaction, $parameters);
		
	}

}