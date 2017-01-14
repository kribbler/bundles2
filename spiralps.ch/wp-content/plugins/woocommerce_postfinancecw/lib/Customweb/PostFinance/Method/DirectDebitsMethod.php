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

require_once 'Customweb/PostFinance/Method/DefaultMethod.php';
require_once 'Customweb/PostFinance/Authorization/Server/Adapter.php';

class Customweb_PostFinance_Method_DirectDebitsMethod extends Customweb_PostFinance_Method_DefaultMethod {

	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_PostFinance_Method_DefaultMethod::getFormFields()
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto) {
		$elements = array();
		
		if (Customweb_PostFinance_Authorization_Server_Adapter::AUTHORIZATION_METHOD_NAME == $authorizationMethod) {
				
			$cardHolder = $orderContext->getBillingFirstName() . ' ' . $orderContext->getBillingLastName();
				
			$elements[] = Customweb_Form_ElementFactory::getAccountOwnerNameElement("account_owner", $cardHolder);
			$elements[] = Customweb_Form_ElementFactory::getAccountNumberElement('account_number');
			
			// For NL we do not require a bank code
			$billingCountry = strtoupper($orderContext->getBillingCountryIsoCode());
			if ($billingCountry != 'NL') {
				$elements[] = Customweb_Form_ElementFactory::getBankCodeElement("bank_code");
			}
			
			$elements[] = Customweb_Form_ElementFactory::getExpirationElement('expiry_month', 'expiry_year');
		}
	
		return $elements;
	}
	
	public function getPaymentMethodBrandAndMethod(Customweb_PostFinance_Authorization_Transaction $transaction) {
		$billingCountry = strtoupper($transaction->getTransactionContext()->getOrderContext()->getBillingCountryIsoCode());
		$params = $this->getPaymentMethodParameters();
		return array(
				'pm' => $params['pm'] . ' ' . $billingCountry,
				'brand' => $params['brand'] . ' ' .  $billingCountry,
		);
	}
	
	public function getAuthorizationParameters(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = parent::getAuthorizationParameters($transaction, $formData, $authorizationMethod);

		// Since the country is crucial we check it here again.
		$billingCountry = strtoupper($transaction->getTransactionContext()->getOrderContext()->getBillingCountryIsoCode());
		$this->isCountrySupported($billingCountry);
		
		
		if (Customweb_PostFinance_Authorization_Server_Adapter::AUTHORIZATION_METHOD_NAME == $authorizationMethod) {
			
			if (!isset($formData['account_owner']) || empty($formData['account_owner'])) {
				throw new Exception(Customweb_I18n_Translation::__("The 'account owner' field cannot be empty."));
			}
			
			if (!isset($formData['account_number']) || empty($formData['account_number'])) {
				throw new Exception(Customweb_I18n_Translation::__("The 'account number' field cannot be empty."));
			}
			
			if (empty($formData['expiry_month'])) {
				throw new Exception(Customweb_I18n_Translation::__("An expiry month must be selected."));
			}
			
			if (empty($formData['expiry_year'])) {
				throw new Exception(Customweb_I18n_Translation::__("An expiry year must be selected."));
			}
				
			
			if ($billingCountry == 'AT') {
				if (strlen($formData['account_number']) != 11) {
					throw new Exception(Customweb_I18n_Translation::__("The 'account_number' field must be 11 digits long."));
				}
				if (!isset($formData['bank_code']) || empty($formData['bank_code']) || strlen($formData['bank_code']) != 5) {
					throw new Exception(Customweb_I18n_Translation::__("The 'bank code' field cannot be empty and it must be 5 digits long."));
				}
				
			}
			if ($billingCountry == 'DE') {
				if (strlen($formData['account_number']) > 10) {
					throw new Exception(Customweb_I18n_Translation::__("The 'account_number' field cannot be longer than 10 digits."));
				}
				if (!isset($formData['bank_code']) || empty($formData['bank_code']) || strlen($formData['bank_code']) != 8) {
					throw new Exception(Customweb_I18n_Translation::__("The 'bank code' field cannot be empty and it must be 8 digits long."));
				}
			}
			
			$accountInformation = $formData['account_number'] . 'BLZ' . $formData['bank_code'];
			if ($billingCountry == 'NL') {
				if (strlen($formData['account_number']) > 10) {
					throw new Exception(Customweb_I18n_Translation::__("The 'account_number' field cannot be longer than 10 digits."));
				}
				
				$accountInformation = $formData['account_number'];
				if (strlen($accountInformation) < 10) {
					$accountInformation = str_repeat("0", (10 - strlen($accountInformation)) ) . $accountInformation;
				}
			}
			
			$parameters['CN'] = strip_tags($formData['account_owner']);
			$parameters['CARDNO'] = strip_tags($accountInformation);
			$parameters['ED'] = $formData['expiry_month'] . substr($formData['expiry_year'], 2,2);
			
		}
	
		return $parameters;
	}
	
	
}