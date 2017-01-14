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
 * This interface defines the interaction with the capturing service. The capturing service 
 * may change the transaction object. Hence it must be stored after the invokation.
 * 
 * The state of the transaction is change during the processing accordingly to the input parameters and the 
 * result of the request.
 * 
 * A transaction may be captured partially and leave it open for further partial captures. 
 * 
 * @author Thomas Hunziker
 * @deprecated Use instead Customweb_Payment_BackendOperation_Adapter_ICapturingAdapter
 */
interface Customweb_Payment_Capturing_IAdapter{
	
	/**
	 * The invocation of this method capture the given transaction (whole amount).
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction The transaction object on which a capture should be executed.
	 * @throws Exception In case the capturing fails, this method may throw an exception.
	 * @return boolean
	 */
	public function capture(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * The invocation of this method capture the given transaction and the given 
	 * amount. The amount must be smaller than the authorized amount. 
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction The transaction object on which a capture should be executed.
	 * @param double $amount Amount to capture.
	 * @param boolean $close Close the transaction or leave it open. If this feature is not supported, the transaction may be closed automatically.
	 * @throws Exception In case the capturing fails, this method may throw an exception.
	 * @return boolean
	 */
	public function partialCapture(Customweb_Payment_Authorization_ITransaction $transaction, $amount, $close);
	
}
