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

require_once 'Customweb/Payment/BackendOperation/Adapter/IRefundAdapter.php';


class Customweb_Payment_BackendOperation_Adapter_DefaultRefundAdapter implements Customweb_Payment_BackendOperation_Adapter_IRefundAdapter {

	public function getConfiguration() {
	
	}
	public function refund(Customweb_Payment_Authorization_ITransaction $transaction){
		
	}
	public function partialRefund(Customweb_Payment_Authorization_ITransaction $transaction, $items, $close){
		
	}
}