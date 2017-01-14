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

interface Customweb_Payment_IConfigurationAdapter {

	/**
	 * This method returns the configuration value by the given key. The language 
	 * must be the same as the one given by the shop system in the 
	 * IOrderContext::getLanguage().
	 *
	 * @param string $key The configuraiton key.
	 * @param string $languageCode [optional] The language of the configuraiton value. Only required for 
	 *                             language dependend configuration values.
	 * @return string Configuration Value
	 *           	 		    			 
	 */
	public function getConfigurationValue($key, $language = null);
	
	/**
	 * This method allows to check whether a configuration exists or not.
	 * 
	 * @param string $key The configuraiton key.
	 * @param string $language [optional] The language of the configuraiton value. Only required for 
	 *                         language dependend configuration values.
	 * @return boolean Either true when it exists or false, when it does not exists.
	 */
	public function existsConfiguration($key, $language = null);
	
	/**
	 * This method returns an URL which points to a HTML file in the layout of the store
	 * which contains the tag '$$$PAYMENT ZONE$$$'. The tag is replaced with the payment
	 * form.
	 * 
	 * @return string URL to a generic template file.
	 */
	public function getDefaultTemplateUrl();


}