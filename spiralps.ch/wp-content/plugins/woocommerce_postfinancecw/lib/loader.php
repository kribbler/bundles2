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
 * This file can be used to include all required files. This is only
 * required if you do not setup a autoloader which loads automatically
 * the classes depending on their names.
 */

$pathToLib = dirname(__FILE__);

set_include_path(implode(PATH_SEPARATOR, array(
		get_include_path(),
		realpath($pathToLib),
)));


if (!function_exists("library_load_class_by_name")) {

	/**
	 * This function loads a class from the library. It resolves the path and
	 * checks if the given class does not already exists in the program
	 * space.
	 *
	 * @param string $className The name of the class
	 * @throws Exception When the given class could not be resolved to a file.
	 * @return boolean True if the class was loaded newly. False if the class
	 * already exists.
	 */
	function library_load_class_by_name($className) {
		if (!in_array($className, get_declared_classes()) && !in_array($className, get_declared_interfaces())) {
// 		if (!class_exists($className) && !interface_exists($className)) {
					
			$fileName = str_replace('_', '/', $className);
			$fileName .= '.php';
				
			if (!library_load_check_if_file_exists_on_include_path($fileName)) {
				throw new Exception(sprintf("The class '%s' was not found on the include path. (file path: %s)", $className, $fileName));
			}
			
			require_once $fileName;
			
			return true;			
		}
		else {
			return false;
		}
	}

	/**
	 * This function checks if a given file exists in the include path or not.
	 * 
	 * @param string $fileName
	 * @return boolean True if the file exists. False if the file does not exists.
	 */
	function library_load_check_if_file_exists_on_include_path($fileName) {
		if(function_exists('stream_resolve_include_path')) {
			return stream_resolve_include_path($fileName);
		}
		else {

			$include_path = explode(PATH_SEPARATOR, get_include_path());
			foreach($include_path as $path) {
				if(@file_exists($path . '/' . $fileName)) {
					return true;
				}
			}
			return false;
		}
	}
}
