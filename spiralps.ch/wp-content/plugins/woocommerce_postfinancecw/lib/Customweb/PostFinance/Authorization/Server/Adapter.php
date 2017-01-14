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

require_once 'Customweb/Payment/Authorization/Server/IAdapter.php';
require_once 'Customweb/Payment/IConfigurationAdapter.php';
require_once 'Customweb/Payment/Authorization/ITransaction.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/Server/ITransactionContext.php';

require_once 'Customweb/PostFinance/Authorization/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Authorization/Server/ParameterBuilder.php';
require_once 'Customweb/PostFinance/Authorization/Transaction.php';
require_once 'Customweb/PostFinance/Configuration.php';
require_once 'Customweb/PostFinance/Util.php';

class Customweb_PostFinance_Authorization_Server_Adapter extends Customweb_PostFinance_Authorization_AbstractAdapter
implements Customweb_Payment_Authorization_Server_IAdapter {
	
	public function getAuthorizationMethodName() {
		return self::AUTHORIZATION_METHOD_NAME;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IAdapter::validate()
	 */
	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext,
			Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext) {
		return true;
	}
	
	/**
	 * (non-PHPdoc)          	 		    			 
	 * @see Customweb_Payment_Authorization_Server_IAdapter::createTransaction()
	 */
	public function createTransaction(Customweb_Payment_Authorization_Server_ITransactionContext $transactionContext, $failedTransaction) {
		$transaction = new Customweb_PostFinance_Authorization_Transaction($transactionContext);
		$transaction->setAuthorizationMethod(self::AUTHORIZATION_METHOD_NAME);
		return $transaction;
	}
	
	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $customerPaymentContext) {
		$paymentMethod = Customweb_PostFinance_Method_Factory::getMethod($orderContext->getPaymentMethod(), $this->getConfiguration());
		return $paymentMethod->getFormFields($orderContext, $aliasTransaction, $failedTransaction, self::AUTHORIZATION_METHOD_NAME, false);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_Server_IAdapter::processAuthorization()
	 */
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters) {
		$this->authorize($transaction, $parameters);
	}

}
