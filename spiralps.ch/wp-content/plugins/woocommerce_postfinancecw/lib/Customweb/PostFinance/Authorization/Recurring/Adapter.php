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

require_once 'Customweb/Payment/Authorization/Recurring/IAdapter.php';
require_once 'Customweb/PostFinance/Method/Factory.php';
require_once 'Customweb/PostFinance/Authorization/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/Recurring/ParameterBuilder.php';


class Customweb_PostFinance_Authorization_Recurring_Adapter extends Customweb_PostFinance_Authorization_AbstractAdapter implements Customweb_Payment_Authorization_Recurring_IAdapter
{
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	public function isPaymentMethodSupportingRecurring(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod) {
		$wrappedPaymentMethod = Customweb_PostFinance_Method_Factory::getMethod($paymentMethod, $this->getConfiguration());
		return $wrappedPaymentMethod->isRecurringPaymentSupported();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Recurring_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Recurring_ITransactionContext $transactionContext) {
		$transaction = new Customweb_PostFinance_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		return $transaction;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Recurring_IAdapter::process()
	 */
	public function process(Customweb_Payment_Authorization_ITransaction $transaction) {
		$builder = new Customweb_PostFinance_Authorization_Recurring_ParameterBuilder($transaction, $this->getConfiguration());
		$parameters = $builder->buildParameters();
		$response = $this->sendDirectRequest($this->getDirectOrderUrl(), $parameters);
		
		// In any case dont save the CVC           	 		    			 
		unset($parameters['CVC']);
		
		$transaction->setDirectLinkCreationParameters($parameters);
		$transaction->setAuthorizationParameters($response);
			
		// Check whether a 3D secure redirection is required or not.
		$this->setTransactionAuthorizationState($transaction, $response);
	}
	
}