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

require_once 'Customweb/Payment/Authorization/ITransaction.php';

/**
 * This interface the interaction for refunding a transaction or a part of the transaction. During the processing
 * of the refund the transaction object may be modifed. Hence after invoking the refund service the transaction must 
 * be stored again into the database.
 * 
 * The processing change the state of transaction according to the input and the result of the request.
 * 
 * @author Thomas Hunziker
 * @deprecated Use instead Customweb_Payment_BackendOperation_Adapter_IRefundAdapter
 */
interface Customweb_Payment_Refund_IAdapter{
	
	/**
	 * The invocation of this method refund the given order.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction The transaction to refund.
	 * @throws Exception If some error occours during the processing.
	 * @return boolean
	 */
	public function refund(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * The invocation of this method refund the given order.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction The transaction to refund.
	 * @param double $amount The amount to refund.
	 * @param boolean $close
	 * @throws Exception If some error occours during the processing.
	 * @return boolean
	 */
	public function partialRefund(Customweb_Payment_Authorization_ITransaction $transaction, $amount, $close);
	
}
