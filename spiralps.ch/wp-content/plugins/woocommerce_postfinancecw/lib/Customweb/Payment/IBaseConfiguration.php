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
 * This interface defines the data used for the transactions. 
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_IBaseConfiguration {
	
	/**
	 * Returns whether the gateway is in test mode or in live mode.
	 * 
	 * @return boolean True if the system is in test mode. Else return false. 
	 */
	public function isTestMode();
	
}
