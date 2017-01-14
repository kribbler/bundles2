<?php

/*********************************************************
 * Utility Methods for Webservice Barcode Client Examples
 *********************************************************/

/**
 * A simple helper-Method for getting multiple elements (=objects or values) from SOAP Responses as an array
 * and also treating a single element as if it was an array. 
 * Passing null results in an empty array. 
 * @param $root the element data (=either a single object or value or an array of mutliple values or null)
 * @return an array containing the passed element(s) (or an empty array if the passed value was null)
 */
function getElements($root) {
	if ($root==null) {
		return array();
	}
	if (is_array($root)) {
		return $root;
	}	
	else {
		// simply wrap a single value or object into an array		
		return array($root);
	}
}

/**
 * A simple helper method to transform an array of strings to a concatenated string with comma separation.
 * @param $strings an array containing string elements
 * @return a string with concatenated string elements separated by comma
 */
function toCommaSeparatedString($strings) {
	$res = "";
	$delimiter = "";
	foreach ($strings as $str) {
		$res .= $delimiter.$str;		
		$delimiter = ", ";
	}
	return $res;
}  

?>