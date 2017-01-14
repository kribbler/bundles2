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

require_once 'Customweb/Payment/AbstractBaseConfiguration.php';

/**
 * This class implements all basic configuration interfaces. The conrete class
 * has only to implement the getConfigurationValue() method which provides access
 * to the configuration storage facility.
 *           	 		    			 
 * @see Customweb_Payment_AbstractBaseConfiguration::getConfigurationValue()
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_PostFinance_Configuration extends Customweb_Payment_AbstractBaseConfiguration {
	
	/**
	 *           	 		    			 
	 * @var Customweb_Payment_IConfigurationAdapter
	 */
	private $configurationAdapter = null;
	
	public function __construct(Customweb_Payment_IConfigurationAdapter $configurationAdapter) {
		$this->configurationAdapter = $configurationAdapter;
	}
	
	public function getConfigurationAdapter() {
		return $this->configurationAdapter;
	}
	
	public function getConfigurationValue($key) {
		return $this->configurationAdapter->getConfigurationValue($key);
	}
	
	public function isTestMode() {
		if (strtolower($this->getConfigurationValue('operation_mode')) == 'live') {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function getPspId() {
		return $this->configurationAdapter->getConfigurationValue('pspid');
	}
	
	public function getTestPspId() {
		return $this->configurationAdapter->getConfigurationValue('test_pspid');
	}
	
	public function getLiveShaPassphraseIn() {
		return $this->configurationAdapter->getConfigurationValue('live_sha_passphrase_in');
	}
	
	public function getLiveShaPassphraseOut() {
		return $this->configurationAdapter->getConfigurationValue('live_sha_passphrase_out');
	}
	
	public function getTestShaPassphraseIn() {
		return $this->configurationAdapter->getConfigurationValue('test_sha_passphrase_in');
	}
	
	public function getTestShaPassphraseOut() {
		return $this->configurationAdapter->getConfigurationValue('test_sha_passphrase_out');
	}
	
	public function getHashMethod() {
		return $this->configurationAdapter->getConfigurationValue('hash_method');
	}
	
	public function getOrderIdSchema() {
		return $this->configurationAdapter->getConfigurationValue('order_id_schema');
	}
	
	
	public function getAliasUsageMessage($language) {
		return $this->configurationAdapter->getConfigurationValue('alias_usage_message', $language);
	}
	
	public function getApiUserId() {
		return $this->configurationAdapter->getConfigurationValue('api_user_id');
	}
	
	public function getApiPassword() {
		return $this->configurationAdapter->getConfigurationValue('api_password');
	}
	
	public function getShopId() {
		return $this->configurationAdapter->getConfigurationValue('shop_id');
	}
	
	public function getTemplateUrl() {
		if ($this->configurationAdapter->getConfigurationValue('template') == 'default') {
			return $this->configurationAdapter->getDefaultTemplateUrl();
		}
		elseif ($this->configurationAdapter->getConfigurationValue('template') == 'custom') {
			return $this->configurationAdapter->getConfigurationValue('template_url');
		}
		else {
			return '';
		}
	}
	
	public function getShaPassphraseIn() {
		if($this->isTestMode()) {
			return $this->getTestShaPassphraseIn();
		} else {
			return $this->getLiveShaPassphraseIn();
		}
	}
	
	public function getShaPassphraseOut() {
		if($this->isTestMode()) {
			return $this->getTestShaPassphraseOut();
		} else {
			return $this->getLiveShaPassphraseOut();
		}
	}
	
	
	
	
}