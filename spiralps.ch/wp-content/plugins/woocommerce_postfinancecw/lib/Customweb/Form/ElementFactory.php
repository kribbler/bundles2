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

require_once 'Customweb/I18n/Translation.php';

require_once 'Customweb/Form/Element.php';
require_once 'Customweb/Form/Control/Html.php';
require_once 'Customweb/Form/Control/MultiCheckbox.php';
require_once 'Customweb/Form/Control/MultiControl.php';
require_once 'Customweb/Form/Control/MultiSelect.php';
require_once 'Customweb/Form/Control/Password.php';
require_once 'Customweb/Form/Control/Radio.php';
require_once 'Customweb/Form/Control/Select.php';
require_once 'Customweb/Form/Control/SingleCheckbox.php';
require_once 'Customweb/Form/Control/Textarea.php';
require_once 'Customweb/Form/Control/TextInput.php';
require_once 'Customweb/Form/Validator/OneNotEmptyFirst.php';
require_once 'Customweb/Form/Validator/OneNotEmptyLast.php';
require_once 'Customweb/Form/Validator/NotEmpty.php';
require_once 'Customweb/Form/Intention/Factory.php';

/**
 * This class provides static method for creating default elements often 
 * used. The element
 * 
 * @author hunziker
 *
 */
final class Customweb_Form_ElementFactory {
	
	private function __construct() { }
	
	private static function getMonthArray() {
		return array(
			'none' => Customweb_I18n_Translation::__('Month'),
			'01' => '01', '02' => '02', '03' => '03', '04' => '04',
			'05' => '05', '06' => '06', '07' => '07', '08' => '08',
			'09' => '09', '10' => '10', '11' => '11', '12' => '12',
		);
	}
	
	/**
	 * This method creates a card holder name field. The $fieldName is the name
	 * of the input field. The $defaultCardHolderName can be used to set the
	 * name of the customer.
	 * 
	 * @param string $fieldName
	 * @param string $defaultCardHolderName
	 * @return Customweb_Form_IElement
	 */
	public static function getCardHolderElement($fieldName, $defaultCardHolderName = '', $errorMessage = null) {
		$control = new Customweb_Form_Control_TextInput($fieldName, $defaultCardHolderName);
		$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter the card holder name on the card.")));
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Holder Name'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the card holder name on the card.')
		);
		$element->setElementIntention(Customweb_Form_Intention_Factory::getCardHolderNameIntention())
				->setErrorMessage($errorMessage);
		
		return $element;
	}
	
	/**
	 * This method creates a bank account owner name field. The $fieldName is the name
	 * of the input field. The $defaultAccountOwnerName can be used to set the
	 * name of the customer.
	 *
	 * @param string $fieldName
	 * @param string $defaultCardHolderName
	 * @return Customweb_Form_IElement
	 */
	public static function getAccountOwnerNameElement($fieldName, $defaultAccountOwnerName = '', $errorMessage = null) {
		$control = new Customweb_Form_Control_TextInput($fieldName, $defaultAccountOwnerName);
		$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter the name of the account owner.")));
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Account owner name.'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the name of the account owner.')
		);
		$element->setElementIntention(Customweb_Form_Intention_Factory::getAccountOwnerNameIntention())
				->setErrorMessage($errorMessage);
	
		return $element;
	}
	
	/**
	 * This method creates a card number form element. The $fieldName is the 
	 * name of the input field. If $alias is set not a input field is shown, 
	 * instead a HTML field is shown with the alias. 
	 * 
	 * @param string $fieldName
	 * @param string $alias
	 * @return Customweb_Form_IElement
	 */
	public static function getCardNumberElement($fieldName, $alias = '', $errorMessage = null, $defaultCard = null) {
		$control = null;
		if (empty($alias)) {
			$control = new Customweb_Form_Control_TextInput($fieldName, $defaultCard);
			$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter a card number.")));
			$control->setAutocomplete(false);
		}
		else {
			$control = new Customweb_Form_Control_Html($fieldName, $alias);
		}
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Number'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the number on your card.')
		);
		$element->setElementIntention(Customweb_Form_Intention_Factory::getCardNumberIntention())
				->setErrorMessage($errorMessage);
		
		return $element;
	}
	
	/**
	 * This method creates a expiration element. A expiration date consists of 
	 * two controls for the month and the year. 
	 * 
	 * @param string $monthFieldName The field name for the month field.
	 * @param string $yearFieldName The field name for the year field.
	 * @param string $defaultMonth The preselected month. Example '05'
	 * @param string $defaultYear The preselected year. Example '2016'
	 * @return Customweb_Form_IElement
	 */
	public static function getExpirationElement($monthFieldName, $yearFieldName, $defaultMonth = '', $defaultYear = '', $errorMessage = null, $yearLength = 4) {
		
		$months = self::getMonthArray();
		
		$years = array('none' => Customweb_I18n_Translation::__('Year'));
		$current = intval(date('Y'));
		for($i = 0; $i < 15; $i++) {
			if ($yearLength == 4) {
				$years[$current] = $current;
			}
			else if ($yearLength == 2) {
				$years[substr($current, 2, 2)] = $current;
			}
			else {
				throw new Exception("Invalid year length defined for the expiration element.");
			}
			
			$current++;
		}
			
		if (strlen($defaultYear) == 2 && $yearLength == 4) {
			// Add the leading year numbers in case it is only 2 chars long
			$defaultYear = '20' . $defaultYear;
		}
		
		$monthControl = new Customweb_Form_Control_Select($monthFieldName, $months, $defaultMonth);
		$monthControl->addValidator(new Customweb_Form_Validator_NotEmpty($monthControl, Customweb_I18n_Translation::__("Please select the expiry month on your card.")));
		
		$yearControl = new Customweb_Form_Control_Select($yearFieldName, $years, $defaultYear);
		$yearControl->addValidator(new Customweb_Form_Validator_NotEmpty($yearControl, Customweb_I18n_Translation::__("Please select the expiry year on your card.")));
		
		$control = new Customweb_Form_Control_MultiControl('expiration', array(
				$monthControl,
				$yearControl,
		));
		
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Card Expiration'),
				$control,
				Customweb_I18n_Translation::__('Select the date on which your card expires.')
		);
		$element->setElementIntention(Customweb_Form_Intention_Factory::getExpirationDateIntention())
				->setErrorMessage($errorMessage);
		
		return $element;
	}
	
	/**
	 * This method creates a CVC element. 
	 * 
	 * @param string $fieldName The field name of the CVC field.
	 * @return Customweb_Form_IElement
	 */
	public static function getCVCElement($fieldName, $errorMessage = null, $required = true) {
		$control = new Customweb_Form_Control_TextInput($fieldName);
	
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(
			Customweb_I18n_Translation::__('CVC Code'),
			$control,
			Customweb_I18n_Translation::__('Please enter here the CVC code from your card. You find the code on the back of the card.')
		);
	
		if ($required) {
			$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter the CVC code from your card.")));
			$element->setRequired(true);
		}
		else {
			$element->setRequired(false);
		}
	
		$element->setElementIntention(Customweb_Form_Intention_Factory::getCvcIntention())
		->setErrorMessage($errorMessage);
	
		return $element;
	}
	
	
	/**
	 * This method creates a account number element.
	 *
	 * @param string $fieldName The field name of the account number element
	 * @return Customweb_Form_IElement
	 */
	public static function getAccountNumberElement($fieldName, $errorMessage = null) {
		$control = new Customweb_Form_Control_TextInput($fieldName);
		$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter your bank account number.")));
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Bank account number'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the account number of your bank account.')
		);
	
		$element->setElementIntention(Customweb_Form_Intention_Factory::getAccountNumberIntention())
				->setErrorMessage($errorMessage);
	
		return $element;
	}
	
	/**
	 * This method creates a bank code element.
	 *
	 * @param string $fieldName The field name of the bank code element
	 * @return Customweb_Form_IElement
	 */
	public static function getBankCodeElement($fieldName, $errorMessage = null) {
		$control = new Customweb_Form_Control_TextInput($fieldName);
		$control->addValidator(new Customweb_Form_Validator_NotEmpty($control, Customweb_I18n_Translation::__("You have to enter bank code of your bank.")));
		$control->setAutocomplete(false);
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Bank code number'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the bank code of your bank.')
		);
	
		$element->setElementIntention(Customweb_Form_Intention_Factory::getAccountNumberIntention())
				->setErrorMessage($errorMessage);
	
		return $element;
	}
	
	public static function getDateOfBirthElement($yearFieldName, $monthFieldName, $dayFieldName, $defaultYear = null, $defaultMonth = null, $defaultDay = null, $errorMessage = null) {
		
		$days = array('none' => Customweb_I18n_Translation::__('Day'));
		for ($i = 1; $i <= 31; $i++) {
			$days[$i] = $i;
		}
		$dayControl = new Customweb_Form_Control_Select($dayFieldName, $days, $defaultDay);
		$dayControl->addValidator(new Customweb_Form_Validator_NotEmpty($dayControl, Customweb_I18n_Translation::__("Please select the day of your birth.")));
		
		
		$months = self::getMonthArray();
		$monthControl = new Customweb_Form_Control_Select($monthFieldName, $months, $defaultMonth);
		$monthControl->addValidator(new Customweb_Form_Validator_NotEmpty($monthControl, Customweb_I18n_Translation::__("Please select the month of your birth.")));
		
		
		$years = array('none' => Customweb_I18n_Translation::__('Year'));
		$current = intval(date('Y'));
		for($i = 0; $i < 100; $i++) {
			$years[$current] = $current;
			$current--;
		}
		$yearControl = new Customweb_Form_Control_Select($yearFieldName, $years, $defaultYear);
		$yearControl->addValidator(new Customweb_Form_Validator_NotEmpty($yearControl, Customweb_I18n_Translation::__("Please select the the year of your birth.")));
		
		
		$control = new Customweb_Form_Control_MultiControl('date_of_birth', array(
			$yearControl,
			$monthControl,
			$dayControl,
		));
		
		$element = new Customweb_Form_Element(
			Customweb_I18n_Translation::__('Date of Birth'),
			$control,
			Customweb_I18n_Translation::__('Select the date of your birth.')
		);
		$element->setElementIntention(Customweb_Form_Intention_Factory::getDateOfBirthIntention())
		->setErrorMessage($errorMessage);
		
		return $element;
	}
	
	public static function getPaymentMethodLogosElement($elementLabel, array $images) {
		
		$html = '<div class="payment-logos">';
		foreach ($images as $image) {
			$html .= '<img src="' . $image['src'] . '" title="' . $image['title'] . '" class="payment-logo" /> ';
		}
		$html .= '</div>';
		
		$control = new Customweb_Form_Control_Html('payment-logos', $html);
		$element = new Customweb_Form_Element(
			$elementLabel,
			$control
		);
		$element->setRequired(false);
		
		return $element;
		
	}
	
	/**
	 * This method creates a CVC element for Maestro UK, this element must be created befor the corresponnding issue number field.
	 *
	 * @param string $fieldName The field name of the CVC field.
	 * @return Customweb_Form_IElement
	 */
	public static function getCVCElementOfCVCandINPair($fieldName) {
		$control = new Customweb_Form_Control_TextInput($fieldName);
		$control->setAutocomplete(false);
		$control->addValidator(new Customweb_Form_Validator_OneNotEmptyFirst($control, 'cwCVCandINControl'));
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('CVC Code'),
				$control,
				Customweb_I18n_Translation::__('Please enter here the CVC code from your card. You find the code on the back of the card.')
		);
	
		$element->setElementIntention(Customweb_Form_Intention_Factory::getCvcIntention());
	
		return $element;
	}
	
	/**
	 * This method creates a Issue Number element for Maestro UK, this element must be created after the corresponnding CVC number field.
	 * This field checks if either the cvc or the issue number is not empty.
	 *
	 * @param string $fieldName The field name of the Issue Number field.
	 * @return Customweb_Form_IElement
	 */
	public static function getINElementOfCVCandINPair($fieldName, $errorMessage = null) {
		$control = new Customweb_Form_Control_TextInput($fieldName);
		$control->setAutocomplete(false);
		$control->addValidator(new Customweb_Form_Validator_OneNotEmptyLast($control, Customweb_I18n_Translation::__('You have to enter either the CVC code or the issue number of your card.'), 'cwCVCandINControl'));
	
		$element = new Customweb_Form_Element(
				Customweb_I18n_Translation::__('Issue Number'),
				$control,
				Customweb_I18n_Translation::__('Please enter your issue number, if there is no CVC code on your card.')
		);
	
		$element->setElementIntention(Customweb_Form_Intention_Factory::getCvcIntention())
		->setErrorMessage($errorMessage);
	
		return $element;
	}
	
	
}