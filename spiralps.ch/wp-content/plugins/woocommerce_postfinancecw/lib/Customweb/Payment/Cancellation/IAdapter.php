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

/**
 * This interface defines a payment service gateway as capable to cancel a transaction.
 * 
 * @author Thomas Hunziker
 * @deprecated Use instead Customweb_Payment_BackendOperation_Adapter_ICancellationAdapter
 *
 */
interface Customweb_Payment_Cancellation_IAdapter{
	
	/**
	 * The invocation of this method cancels the given transaction.
	 *
	 * @throws Exception In case the cancellation fails, this method may throw an exception.
	 * @return boolean
	 */
	public function cancel(Customweb_Payment_Authorization_ITransaction $transaction);

}
