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

class Customweb_PostFinance_Method_DirectEbankingMethod extends Customweb_PostFinance_Method_DefaultMethod {
	
	/**
	 * (non-PHPdoc)          	 		    			 
	 * @see Customweb_PostFinance_Method_DefaultMethod::getPaymentMethodBrandAndMethod()
	 */
	public function getPaymentMethodBrandAndMethod(Customweb_PostFinance_Authorization_Transaction $transaction) {
		
		$billingCountry = strtoupper($transaction->getTransactionContext()->getOrderContext()->getBillingCountryIsoCode());
		
		// In case the merchant and the customer are from Germany, do not add anything
		if (strtolower($this->getPaymentMethodConfigurationValue('merchant_origin')) == 'de' && $billingCountry == 'DE') {
			return parent::getPaymentMethodBrandAndMethod($transaction);
		}
		
		$params = $this->getPaymentMethodParameters();
		return array(
				'pm' => $params['pm'] . $billingCountry,
				'brand' => $params['brand'] . $billingCountry,
		);
	}
	
	
	
}