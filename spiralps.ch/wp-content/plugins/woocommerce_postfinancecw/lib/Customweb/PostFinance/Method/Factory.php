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
require_once 'Customweb/PostFinance/Method/BankTransferMethod.php';
require_once 'Customweb/PostFinance/Method/DirectDebitsMethod.php';
require_once 'Customweb/PostFinance/Method/DirectEbankingMethod.php';
require_once 'Customweb/PostFinance/Method/FisOpenInvoiceMethod.php';
require_once 'Customweb/PostFinance/Method/CreditCardMethod.php';

final class Customweb_PostFinance_Method_Factory {
	
	private function __construct() {}
	
	/**
	 * 
	 * @return Customweb_PostFinance_Method_DefaultMethod
	 */
	public static function getMethod(Customweb_Payment_Authorization_IPaymentMethod $method, Customweb_PostFinance_Configuration $config) {
		$paymentMethodName = $method->getPaymentMethodName();
		switch(strtolower($paymentMethodName)) {
			
			case 'banktransfer':
				return new Customweb_PostFinance_Method_BankTransferMethod($method, $config);
				
			case 'directdebits':
				return new Customweb_PostFinance_Method_DirectDebitsMethod($method, $config);
			
			case 'directebanking':	
				return new Customweb_PostFinance_Method_DirectEbankingMethod($method, $config);
				
			case 'fisopeninvoice':
				return new Customweb_PostFinance_Method_FisOpenInvoiceMethod($method, $config);
					
			case 'diners':
			case 'mastercard':
			case 'cofinoga':
			case 'visa':
			case 'americanexpress':
			case 'maestro':
			case 'maestrouk':
			case 'jcb':
			case 'cartebleu':
			case 'aurore':
			case 'solo':
			case 'bcmc':
			case 'uatp':
			case 'creditcard':
				return new Customweb_PostFinance_Method_CreditCardMethod($method, $config);
				
			default:
				return new Customweb_PostFinance_Method_DefaultMethod($method, $config);
		}
	}
	
}