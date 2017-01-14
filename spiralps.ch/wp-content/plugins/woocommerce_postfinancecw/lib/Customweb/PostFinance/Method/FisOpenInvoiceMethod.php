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

require_once 'Customweb/PostFinance/Method/AbstractOpenInvoiceMethod.php';
require_once 'Customweb/I18n/Translation.php';


class Customweb_PostFinance_Method_FisOpenInvoiceMethod extends Customweb_PostFinance_Method_AbstractOpenInvoiceMethod {

	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto) {
		$elements = parent::getFormFields($orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto);
		$this->addShippingBirthdateFormFields($elements, $orderContext, $failedTransaction);
		$this->addGenderFormFields($elements, $orderContext, $failedTransaction);
		return $elements;
	}
	
	public function getAuthorizationParameters(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = parent::getAuthorizationParameters($transaction, $formData, $authorizationMethod);
	
		// Add default invoice data
		return array_merge(
			$parameters,
			$this->getShippingBirthdateParameter($transaction, $formData),
			$this->getCustomerIdParameter($transaction),
			$this->getCustomerGenderParameter($transaction, $formData)
		);
	}
	
	
	
}