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
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Util/Address.php';
require_once 'Customweb/Util/Rand.php';

class Customweb_PostFinance_Method_AbstractOpenInvoiceMethod extends Customweb_PostFinance_Method_DefaultMethod {

	
	public function getAuthorizationParameters(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = parent::getAuthorizationParameters($transaction, $formData, $authorizationMethod);

		// Add default invoice data
		return array_merge(
			$parameters,
			$this->getBillingAddressParameters($transaction),
			$this->getShihippinAddressParameters($transaction),
			$this->getLineItemParameters($transaction)
		);
	}
	
	protected function getBillingAddressParameters(Customweb_PostFinance_Authorization_Transaction $transaction) {
		$parameters = array();
		$orderContext = $transaction->getTransactionContext()->getOrderContext();
		$splits = Customweb_Util_Address::splitStreet($orderContext->getBillingStreet(), $orderContext->getBillingCountryIsoCode(), $orderContext->getBillingPostCode());
		
		$parameters['ECOM_BILLTO_POSTAL_NAME_FIRST'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingFirstName(), 0, 50);
		$parameters['ECOM_BILLTO_POSTAL_NAME_LAST'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingLastName(), 0, 50);
		$parameters['OWNERADDRESS'] = Customweb_PostFinance_Util::substrUtf8($splits['street'], 0, 35);
 		$parameters['OWNERADDRESS2'] = 'not present';
		$parameters['ECOM_BILLTO_POSTAL_STREET_NUMBER'] = Customweb_PostFinance_Util::substrUtf8($splits['street-number'], 0, 10);
		$parameters['OWNERZIP'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingPostCode(), 0, 10);
		$parameters['OWNERTOWN'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingCity(), 0, 25);
		$parameters['OWNERCTY'] = $orderContext->getBillingCountryIsoCode();
		$parameters['EMAIL'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingEMailAddress(), 0, 50);
		if ($orderContext->getBillingPhoneNumber() !== null) {
			$parameters['OWNERTELNO'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingPhoneNumber(), 0, 30);
		}
		if ($orderContext->getBillingMobilePhoneNumber() !== null) {
			$parameters['OWNERTELNO2'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getBillingMobilePhoneNumber(), 0, 30);
		}
		
		if ($orderContext->getBillingGender() == 'male') {
			$parameters['ECOM_CONSUMER_GENDER'] = 'M';
		}
		if ($orderContext->getBillingGender() == 'female') {
			$parameters['ECOM_CONSUMER_GENDER'] = 'F';
		}
		
		return $parameters;
	}
	
	protected function getShihippinAddressParameters(Customweb_PostFinance_Authorization_Transaction $transaction) {
		$parameters = array();
		$orderContext = $transaction->getTransactionContext()->getOrderContext();
		$splits = Customweb_Util_Address::splitStreet($orderContext->getShippingStreet(), $orderContext->getShippingCountryIsoCode(), $orderContext->getShippingPostCode());
		
		$parameters['ECOM_SHIPTO_POSTAL_NAME_FIRST'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getShippingFirstName(), 0, 50);
		$parameters['ECOM_SHIPTO_POSTAL_NAME_LAST'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getShippingLastName(), 0, 50);
		$parameters['ECOM_SHIPTO_POSTAL_STREET_LINE1'] = Customweb_PostFinance_Util::substrUtf8($splits['street'], 0, 35);
		$parameters['ECOM_SHIPTO_POSTAL_STREET_LINE2'] = '';
		$parameters['ECOM_SHIPTO_POSTAL_STREET_NUMBER'] = Customweb_PostFinance_Util::substrUtf8($splits['street-number'], 0, 10);
		$parameters['ECOM_SHIPTO_POSTAL_POSTALCODE'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getShippingPostCode(), 0, 10);
		$parameters['ECOM_SHIPTO_POSTAL_CITY'] = Customweb_PostFinance_Util::substrUtf8($orderContext->getShippingCity(), 0, 25);
		$parameters['ECOM_SHIPTO_POSTAL_COUNTRYCODE'] = $orderContext->getShippingCountryIsoCode();
		
		$shippingCompany = $orderContext->getShippingCompanyName();
		if (!empty($shippingCompany)) {
			$parameters['ECOM_SHIPTO_COMPANY'] = Customweb_PostFinance_Util::substrUtf8($shippingCompany, 0, 50);
		}
		
		return $parameters;
		
	}
	
	protected function getLineItemParameters(Customweb_PostFinance_Authorization_Transaction $transaction) {
		
		$items = $transaction->getTransactionContext()->getOrderContext()->getInvoiceItems();
		$parameters = array();
		$count = 1;
		foreach ($items as $item) {
			$parameters = array_merge($parameters, $this->getParametersPerLineItem($item, $count, $transaction));
			$count++;
		}
		return $parameters;
	}
	
	protected function getParametersPerLineItem(Customweb_Payment_Authorization_IInvoiceItem $item, $count, Customweb_PostFinance_Authorization_Transaction $transaction) {
		$parameters = array();
		$currency = $transaction->getTransactionContext()->getOrderContext()->getCurrencyCode();
		$parameters['ITEMID' . $count] = $count;
		$parameters['ITEMNAME' . $count] = Customweb_PostFinance_Util::substrUtf8($item->getName(), 0, 40);
		$parameters['ITEMQUANT' . $count] = $item->getQuantity();
		$parameters['ITEMVATCODE' . $count] = $item->getTaxRate() . "%";
		
		if ($item->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
// 			$parameters['ITEMVAT' . $count] = Customweb_Util_Currency::formatAmount($item->getTaxAmount() / $item->getQuantity() * -1, $currency);
			$parameters['ITEMPRICE' . $count] = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax() / $item->getQuantity() * -1, $currency);
		}
		else {
// 			$parameters['ITEMVAT' . $count] = Customweb_Util_Currency::formatAmount($item->getTaxAmount() / $item->getQuantity(), $currency);
			$parameters['ITEMPRICE' . $count] = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax() / $item->getQuantity(), $currency);
		}
		
		return $parameters;
	}
	
	protected function getShippingBirthdateParameter(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData) {
		$dateOfBirth = $transaction->getTransactionContext()->getOrderContext()->getShippingDateOfBirth();
		
		if ($dateOfBirth === null) {
			if (!isset($formData['date_of_birth_year'])) {
				throw new Exception(Customweb_I18n_Translation::__("No year set in the date of birth field."));
			}
			if (!isset($formData['date_of_birth_month'])) {
				throw new Exception(Customweb_I18n_Translation::__("No month set in the date of birth field."));
			}
			if (!isset($formData['date_of_birth_day'])) {
				throw new Exception(Customweb_I18n_Translation::__("No day set in the date of birth field."));
			}
			
			$year = $formData['date_of_birth_year'];
			$month = $formData['date_of_birth_month'];
			$day = $formData['date_of_birth_day'];
			$dateOfBirth = new DateTime();
			$dateOfBirth->setDate(intval($year), intval($month), intval($day));
		}
		
		return array(
			'ECOM_SHIPTO_DOB' => $dateOfBirth->format('d/m/Y'),
		);
	}
	
	protected function getCustomerIdParameter(Customweb_PostFinance_Authorization_Transaction $transaction) {
		
		$id = $transaction->getTransactionContext()->getOrderContext()->getCustomerId();
		if (empty($id)) {
			$id = Customweb_Util_Rand::getUuid();
		}
		
		$id = Customweb_PostFinance_Util::substrUtf8($id, 0, 50);
		
		return array(
			'REF_CUSTOMERID' => $id,
		);
	}
	
	protected function addShippingBirthdateFormFields(array &$elements, Customweb_Payment_Authorization_IOrderContext $orderContext, $failedTransaction) {
		if ($orderContext->getShippingDateOfBirth() === null) {
			$elements[] = Customweb_Form_ElementFactory::getDateOfBirthElement('date_of_birth_year', 'date_of_birth_month', 'date_of_birth_day');
		}
	}
	
	protected function getCustomerGenderParameter(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData) {
		$orderContext = $transaction->getTransactionContext()->getOrderContext();
		
		$parameters = array();
		if ($orderContext->getBillingGender() != 'male' && $orderContext->getBillingGender() != 'female') {
			if (!isset($formData['customer_gender']) || $formData['customer_gender'] == 'none') {
				throw new Exception(Customweb_I18n_Translation::__("You must define your gender."));
			}
			$gender = strtoupper($formData['customer_gender']);
			if ($gender != 'M' && $gender != 'F') {
				throw new Exception("Invalid gender selected.");
			}
			$parameters['ECOM_CONSUMER_GENDER'] = $gender;
		}
		else {
			if ($orderContext->getBillingGender() == 'male') {
				$parameters['ECOM_CONSUMER_GENDER'] = 'M';
			}
			else if ($orderContext->getBillingGender() == 'female') {
				$parameters['ECOM_CONSUMER_GENDER'] = 'F';
			}
		}
		
		return $parameters;
	}
	
	
	
	protected function addGenderFormFields(array &$elements, Customweb_Payment_Authorization_IOrderContext $orderContext, $failedTransaction) {
		if ($orderContext->getBillingGender() != 'male' && $orderContext->getBillingGender() != 'female') {
			$genders = array(
				'none' => Customweb_I18n_Translation::__('Select your gender'),
				'f' => Customweb_I18n_Translation::__('Female'),
				'm' => Customweb_I18n_Translation::__('Male'),
			);
			$genderControl = new Customweb_Form_Control_Select('customer_gender', $genders);
			$genderControl->addValidator(new Customweb_Form_Validator_NotEmpty($genderControl, Customweb_I18n_Translation::__("Please select your gender.")));
			
			$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Gender'),
				$genderControl,
				Customweb_I18n_Translation::__('Please select your gender.')
			);
			
			$elements[] = $element;
		}
	}
	
}