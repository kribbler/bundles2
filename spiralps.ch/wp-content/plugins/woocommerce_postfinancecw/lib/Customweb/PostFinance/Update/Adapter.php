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

class Customweb_PostFinance_Update_Adapter extends Customweb_PostFinance_AbstractAdapter
implements Customweb_Payment_Update_IAdapter
{

	public function preprocessTransactionUpdate(){
		// We support only pull and not push. Hence we do not implement anything here.
	}


	public function pullTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_Payment_BackendOperation_IAdapterFactory $adapterFactory){
		
		
		
		
	}

	public function batchUpdate(DateTime $lastSuccessFullUpdate) {
		return array();
	}

	public function processTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters, Customweb_Payment_BackendOperation_IAdapterFactory $adapterFactory){
		// We support only pull and not push. Hence we do not implement anything here.
	}

	public function confirmTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction){
		// We support only pull and not push. Hence we do not implement anything here.
	}

	public function confirmFailedTransactionUpdate($transaction, $error){
		// We support only pull and not push. Hence we do not implement anything here.
	}

}