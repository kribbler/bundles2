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
 * This util produces random strings.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Util_Html {
	
	private $baseUrl = NULL;
	private $baseDomain = NULL;
	
	private function __construct() {}
	
	public static function convertSpecialCharacterToEntities($output) {
		if (stristr($output, 'charset=iso-8859-15')) {
			$output = htmlentities(utf8_encode($output), ENT_NOQUOTES, 'UTF-8', false);
		}
		else {
			$output = htmlentities($output, ENT_NOQUOTES, 'UTF-8', false);
		}
		$output = str_replace(array('&lt;','&gt;', '&amp;'),array('<','>', '&'), $output);
		return $output;
	}
	
	public static function replaceRelativeUrls($content, $baseUrl) {
		$object = new Customweb_Util_Html();
		$url = new Customweb_Http_Url($baseUrl);
		$object->baseUrl = $baseUrl;
		$object->baseDomain = $url->getBaseUrl();
	
		$patterns = array(
			'/(href=")([^"]*)(")/',
			'/(href=\')([^\']*)(\')/',
			'/(src=")([^"]*)(")/',
			'/(src=\')([^\']*)(\')/',
		);
		
		foreach($patterns as $pattern) {
			$content = preg_replace_callback($pattern, array($object, 'replaceRelativeUrl'), $content);
		}
	
		return $content;
	}
	
	private function replaceRelativeUrl($matches) {
		$url = $matches[2];
	
		// If the URL does not contain a ':' it is not a fully qualified URL.
		if (strstr($url, ':') === false && !substr($url, 0, 2) == '//' && !substr($url, 0, 5) != 'data:') {
			if (substr($url, 0, 1) == '/') {
				$url = $this->baseDomain . $url;
			}
			else {
				$url = $this->baseUrl . $url;
			}
		}
	
		return $matches[1] . $url . $matches[3];
	}
	
	
	
	
}