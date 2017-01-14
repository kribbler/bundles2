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

require_once 'Customweb/Payment/Authorization/AbstractPaymentMethodWrapper.php';

class Customweb_PostFinance_Method_DefaultMethod extends Customweb_Payment_Authorization_AbstractPaymentMethodWrapper {

	/**
	 * This map contains all supported payment methods.
	 *          	 		    			 
	 * @var array
	 */
	protected static $paymentMapping = array(
		'creditcard' => array(
			'machine_name' => 'CreditCard',
 			'method_name' => 'Credit Card',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => '',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 				1 => 'Moto',
 				2 => 'Recurring',
 			),
 		),
 		'acceptgiro' => array(
			'machine_name' => 'Acceptgiro',
 			'method_name' => 'Acceptgiro',
 			'parameters' => array(
				'pm' => 'Acceptgiro',
 				'brand' => 'Acceptgiro',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'airplus' => array(
			'machine_name' => 'AirPlus',
 			'method_name' => 'AirPlus',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'AIRPLUS',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'americanexpress' => array(
			'machine_name' => 'AmericanExpress',
 			'method_name' => 'American Express',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'American Express',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 			),
 		),
 		'aurore' => array(
			'machine_name' => 'Aurore',
 			'method_name' => 'Aurore',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Aurore',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'AliasManager',
 			),
 		),
 		'cartebleue' => array(
			'machine_name' => 'CarteBleue',
 			'method_name' => 'Carte Bleue',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'CB',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'cofinoga' => array(
			'machine_name' => 'Cofinoga',
 			'method_name' => 'Cofinoga',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Cofinoga',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 			),
 		),
 		'dankort' => array(
			'machine_name' => 'Dankort',
 			'method_name' => 'Dankort',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Dankort',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'diners' => array(
			'machine_name' => 'Diners',
 			'method_name' => 'Diners Club',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Diners Club',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 			),
 		),
 		'jcb' => array(
			'machine_name' => 'Jcb',
 			'method_name' => 'JCB',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'JCB',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'lasercard' => array(
			'machine_name' => 'LaserCard',
 			'method_name' => 'Laser Card',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Laser',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'maestrouk' => array(
			'machine_name' => 'MaestroUK',
 			'method_name' => 'Maestro UK',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'MaestroUK',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'mastercard' => array(
			'machine_name' => 'MasterCard',
 			'method_name' => 'MasterCard',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'MasterCard',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 			),
 		),
 		'solocard' => array(
			'machine_name' => 'SoloCard',
 			'method_name' => 'Solo Card',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Solo',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'uatp' => array(
			'machine_name' => 'Uatp',
 			'method_name' => 'Universal Air Travel Plan (UATP) Card',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'UATP',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'visa' => array(
			'machine_name' => 'Visa',
 			'method_name' => 'Visa',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'VISA',
 			),
 			'not_supported_features' => array(
				0 => 'ServerAuthorization',
 			),
 		),
 		'bcmc' => array(
			'machine_name' => 'Bcmc',
 			'method_name' => 'Bancontact / Mister Cash',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'BCMC',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'Refund',
 			),
 		),
 		'uneurocom' => array(
			'machine_name' => 'UnEuroCom',
 			'method_name' => '1Euro.com',
 			'parameters' => array(
				'pm' => 'UNEUROCOM',
 				'brand' => 'UNEUROCOM',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'maestro' => array(
			'machine_name' => 'Maestro',
 			'method_name' => 'Maestro',
 			'parameters' => array(
				'pm' => 'CreditCard',
 				'brand' => 'Maestro',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'ServerAuthorization',
 			),
 		),
 		'postfinancecard' => array(
			'machine_name' => 'PostFinanceCard',
 			'method_name' => 'PostFinance Card',
 			'parameters' => array(
				'pm' => 'PostFinance Card',
 				'brand' => 'PostFinance Card',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Moto',
 			),
 		),
 		'amazoncheckout' => array(
			'machine_name' => 'AmazonCheckout',
 			'method_name' => 'Amazon Checkout',
 			'parameters' => array(
				'pm' => 'Amazon Checkout',
 				'brand' => 'Amazon Checkout',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'belfiusdirectnet' => array(
			'machine_name' => 'BelfiusDirectNet',
 			'method_name' => 'Belfius Direct Net',
 			'parameters' => array(
				'pm' => 'Belfius Direct Net',
 				'brand' => 'Belfius Direct Net',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'cashticket' => array(
			'machine_name' => 'CashTicket',
 			'method_name' => 'Cash-Ticket',
 			'parameters' => array(
				'pm' => 'cashticket',
 				'brand' => 'cashticket',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'cbconline' => array(
			'machine_name' => 'CbcOnline',
 			'method_name' => 'CBC Online',
 			'parameters' => array(
				'pm' => 'CBC Online',
 				'brand' => 'CBC Online',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'centeaonline' => array(
			'machine_name' => 'CenteaOnline',
 			'method_name' => 'CENTEA Online',
 			'parameters' => array(
				'pm' => 'CENTEA Online',
 				'brand' => 'CENTEA Online',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'edankort' => array(
			'machine_name' => 'EDankort',
 			'method_name' => 'eDankort',
 			'parameters' => array(
				'pm' => 'eDankort',
 				'brand' => 'eDankort',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'eps' => array(
			'machine_name' => 'Eps',
 			'method_name' => 'EPS',
 			'parameters' => array(
				'pm' => 'EPS',
 				'brand' => 'EPS',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'fidorpay' => array(
			'machine_name' => 'FidorPay',
 			'method_name' => 'FidorPay',
 			'parameters' => array(
				'pm' => 'FidorPay',
 				'brand' => 'FidorPay',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'giropay' => array(
			'machine_name' => 'Giropay',
 			'method_name' => 'giropay',
 			'parameters' => array(
				'pm' => 'giropay',
 				'brand' => 'giropay',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'ideal' => array(
			'machine_name' => 'IDeal',
 			'method_name' => 'iDEAL',
 			'parameters' => array(
				'pm' => 'iDEAL',
 				'brand' => 'iDEAL',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'inghomepay' => array(
			'machine_name' => 'IngHomePay',
 			'method_name' => 'ING HomePay',
 			'parameters' => array(
				'pm' => 'ING HomePay',
 				'brand' => 'ING HomePay',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'kbconline' => array(
			'machine_name' => 'KbcOnline',
 			'method_name' => 'KBC Online',
 			'parameters' => array(
				'pm' => 'KBC Online',
 				'brand' => 'KBC Online',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'mpass' => array(
			'machine_name' => 'Mpass',
 			'method_name' => 'mpass',
 			'parameters' => array(
				'pm' => 'MPASS',
 				'brand' => 'MPASS',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'paysafecard' => array(
			'machine_name' => 'Paysafecard',
 			'method_name' => 'paysafecard',
 			'parameters' => array(
				'pm' => 'paysafecard',
 				'brand' => 'paysafecard',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'postfinanceefinance' => array(
			'machine_name' => 'PostFinanceEFinance',
 			'method_name' => 'PostFinance E-Finance',
 			'parameters' => array(
				'pm' => 'PostFinance e-finance',
 				'brand' => 'PostFinance e-finance',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'directdebits' => array(
			'machine_name' => 'DirectDebits',
 			'method_name' => 'Direct Debits',
 			'parameters' => array(
				'pm' => 'Direct Debits',
 				'brand' => 'Direct Debits',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'AliasManager',
 				2 => 'Moto',
 			),
 			'supported_countries' => array(
				0 => 'AT',
 				1 => 'DE',
 				2 => 'NL',
 			),
 		),
 		'intersolve' => array(
			'machine_name' => 'InterSolve',
 			'method_name' => 'InterSolve',
 			'parameters' => array(
				'pm' => 'InterSolve',
 				'brand' => 'InterSolve',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'pingping' => array(
			'machine_name' => 'PingPing',
 			'method_name' => 'PingPing',
 			'parameters' => array(
				'pm' => 'PingPing',
 				'brand' => 'PingPing',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'tunz' => array(
			'machine_name' => 'Tunz',
 			'method_name' => 'TUNZ',
 			'parameters' => array(
				'pm' => 'TUNZ',
 				'brand' => 'TUNZ',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 		),
 		'cashex' => array(
			'machine_name' => 'CashEx',
 			'method_name' => 'cashEX',
 			'parameters' => array(
				'pm' => 'cashEX',
 				'brand' => 'cashEX',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'cashu' => array(
			'machine_name' => 'CashU',
 			'method_name' => 'cashU',
 			'parameters' => array(
				'pm' => 'cashU',
 				'brand' => 'cashU',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'cashudirect' => array(
			'machine_name' => 'CashUDirect',
 			'method_name' => 'cashU Direct',
 			'parameters' => array(
				'pm' => 'cashU Direct',
 				'brand' => 'cashU Direct',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'paypal' => array(
			'machine_name' => 'PayPal',
 			'method_name' => 'PayPal',
 			'parameters' => array(
				'pm' => 'PAYPAL',
 				'brand' => 'PAYPAL',
 			),
 			'not_supported_features' => array(
				0 => 'AliasManager',
 				1 => 'HiddenAuthorization',
 				2 => 'ServerAuthorization',
 				3 => 'Moto',
 			),
 		),
 		'directebanking' => array(
			'machine_name' => 'DirectEBanking',
 			'method_name' => 'Direct E-Banking',
 			'parameters' => array(
				'pm' => 'DirectEBanking',
 				'brand' => 'DirectEBanking',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Moto',
 				4 => 'Recurring',
 			),
 			'supported_countries' => array(
				0 => 'AT',
 				1 => 'BE',
 				2 => 'CH',
 				3 => 'DE',
 				4 => 'FR',
 				5 => 'GB',
 				6 => 'IT',
 				7 => 'NL',
 			),
 			'supported_currencies' => array(
				0 => 'EUR',
 			),
 		),
 		'banktransfer' => array(
			'machine_name' => 'BankTransfer',
 			'method_name' => 'Bank Transfer',
 			'parameters' => array(
				'pm' => 'Bank transfer',
 				'brand' => 'Bank transfer',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Capturing',
 				4 => 'Refund',
 				5 => 'Moto',
 				6 => 'Recurring',
 			),
 		),
 		'cashondelivery' => array(
			'machine_name' => 'CashOnDelivery',
 			'method_name' => 'Cash on Delivery',
 			'parameters' => array(
				'pm' => 'Payment on Delivery',
 				'brand' => 'Payment on Delivery',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 		'fisopeninvoice' => array(
			'machine_name' => 'FisOpenInvoice',
 			'method_name' => 'PostFinance FIS Open Invoice',
 			'parameters' => array(
				'pm' => 'Open Invoice CH',
 				'brand' => 'Open Invoice CH',
 			),
 			'not_supported_features' => array(
				0 => 'HiddenAuthorization',
 				1 => 'ServerAuthorization',
 				2 => 'AliasManager',
 				3 => 'Refund',
 				4 => 'Moto',
 				5 => 'Recurring',
 			),
 		),
 	);

	private $globalConfiguration = null;
	
	public function __construct(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, Customweb_PostFinance_Configuration $config) {
		parent::__construct($paymentMethod);
		$this->globalConfiguration = $config;
	}
	
	/**
	 *           	 		    			 
	 * @return Customweb_PostFinance_Configuration
	 */
	protected function getGlobalConfiguration() {
		return $this->globalConfiguration;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_AbstractPaymentMethodWrapper::getPaymentInformationMap()
	 */
	protected function getPaymentInformationMap() {
		return self::$paymentMapping;
	}
	
	/**
	 * This method returns a list of form elements. This form elements are used to generate the user input. 
	 * Sub classes may override this method to provide their own form fields.
	 * 
	 * @return array List of form elements
	 */
	public function getFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $authorizationMethod, $isMoto) {
		return array();
	}
	
	/**
	 * This method returns the parameters to add for processing an authorization request for this payment method. Sub classes
	 * may override this method. But they should call the parent and merge in their own parameters.
	 *
	 * @param Customweb_PostFinance_Authorization_Transaction $transaction
	 * @param array $formData
	 * @return array
	 */
	public function getAuthorizationParameters(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = $this->getPaymentMethodBrandAndMethod($transaction);
		
		return $parameters;
	}
	
	public function getAliasGatewayAuthorizationParameters(Customweb_PostFinance_Authorization_Transaction $transaction, array $formData, $authorizationMethod) {
		$parameters = $this->getPaymentMethodBrandAndMethod($transaction);
		return $parameters;
	}
	
	/**
	 * This method returns a map which contains the payment method and brand for the given payment method and transaction.
	 * The map has the following shape:
	 * array (
	 *    'pm' => 'Payment Method Name',
	 *    'brand' => 'Brand of the Payment Method',
	 * )
	 *
	 * @param Customweb_PostFinance_Authorization_Transaction $transaction
	 * @return array Brand and Payment Method
	 */
	public function getPaymentMethodBrandAndMethod(Customweb_PostFinance_Authorization_Transaction $transaction) {
		$params = $this->getPaymentMethodParameters();
		return array(
				'pm' => $params['pm'],
				'brand' => $params['brand'],
		);
	}
}