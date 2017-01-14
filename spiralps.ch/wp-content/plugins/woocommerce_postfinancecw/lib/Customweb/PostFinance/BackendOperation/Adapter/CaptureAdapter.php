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

require_once 'Customweb/PostFinance/AbstractAdapter.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/ICaptureAdapter.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/PostFinance/Capturing/Adapter.php';

class Customweb_PostFinance_BackendOperation_Adapter_CaptureAdapter extends Customweb_PostFinance_AbstractAdapter implements Customweb_Payment_BackendOperation_Adapter_ICaptureAdapter {

	/**
	 * @return Customweb_Payment_Capturing_IAdapter
	 */
	protected function getAmountCaptureAdapter() {
		return new Customweb_PostFinance_Capturing_Adapter($this->getConfiguration()->getConfigurationAdapter());
	}

	public function capture(Customweb_Payment_Authorization_ITransaction $transaction){
		return $this->getAmountCaptureAdapter()->capture($transaction);
	}
	
	public function partialCapture(Customweb_Payment_Authorization_ITransaction $transaction, $items, $close){

		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		return $this->getAmountCaptureAdapter()->partialCapture($transaction, $amount, $close);
	}
		
}