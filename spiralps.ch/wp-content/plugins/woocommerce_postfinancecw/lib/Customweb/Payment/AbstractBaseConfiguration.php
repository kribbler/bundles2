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

require_once 'Customweb/Payment/IBaseConfiguration.php';

/**
 * This class implements a basic skeleton for a configuration.
 *          	 		    			 
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Payment_AbstractBaseConfiguration implements Customweb_Payment_IBaseConfiguration {

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IBaseConfiguration::isTestMode()
	 */
	public function isTestMode() {
		if (strtolower($this->getConfigurationValue('mode')) == 'live') {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function isAliasManagerActive() {
		if (strtolower($this->getConfigurationValue('alias_manager')) == 'active') {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * This method returns the configuration value for the given key.
	 * 
	 * @param string $key The configuration key to retrieve.
	 * @return String The value of the configuration given by the key
	 */
	abstract public function getConfigurationValue($key);
	
}
