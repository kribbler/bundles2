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

require_once 'Customweb/Http/Url.php';

/**
 * This util produces random strings.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Util_Url {
	
	private function __construct() {}
	
	public static function appendParameters($url, array $parameters) {
		$url = new Customweb_Http_Url($url);
		foreach ($parameters as $key => $value) {
			$url->appendQueryParameter($key, $value);
		}
		return $url->toString();		
	}
	
}