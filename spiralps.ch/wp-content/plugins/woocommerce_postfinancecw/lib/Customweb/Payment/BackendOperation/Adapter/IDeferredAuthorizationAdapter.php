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
 * In some cases it is necessary that the authorization is done not synchronous to 
 * the order process. Means the authorization of the transaction occours later in 
 * the process. Reasons for that are systems failure.
 * 
 * Deferred authorization means that the authorization is done by a server action and 
 * without any user context (e.g. session id).
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_BackendOperation_Adapter_IDeferredAuthorizationAdapter {

	/**
	 * This method authorize a given transaction. 
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @throws Exception 
	 */
	public function authorize(Customweb_Payment_Authorization_ITransaction $transaction);
	
}