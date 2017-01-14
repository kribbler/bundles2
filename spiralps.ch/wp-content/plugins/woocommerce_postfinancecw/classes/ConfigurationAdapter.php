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

library_load_class_by_name('Customweb_Payment_IConfigurationAdapter');

class PostFinanceCw_ConfigurationAdapter implements Customweb_Payment_IConfigurationAdapter{
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IConfigurationAdapter::getConfigurationValue()
	 */
	public function getConfigurationValue($key, $languageCode = null) {
		return get_option('woocommerce_postfinancecw_' . $key);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IConfigurationAdapter::getDefaultTemplateUrl()
	 */
	public function getDefaultTemplateUrl() {
		return PostFinanceCwUtil::getPluginUrl('template.php');
	}
	
	public static function isAliasMangerActive() {
		return strtolower(get_option('woocommerce_postfinancecw_alias_manager')) == 'active';
	}
	
	public static function isReviewFormInputActive() {
		$value = get_option('woocommerce_postfinancecw_review_input_form', null);
		if ($value == 'active') {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function existsConfiguration($key, $language = null) {
		$value = get_option('woocommerce_postfinancecw_' . $key, null);
		if ($value === null) {
			return false;
		}
		else {
			return true;
		}
	}
	
	
}