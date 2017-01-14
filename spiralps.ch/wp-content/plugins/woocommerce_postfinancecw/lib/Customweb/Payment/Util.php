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

require_once 'Customweb/Util/String.php';

/**
 * This util class some basic functions for PostFinance.
 * 
 * @author Thomas Hunziker
 *
 */
final class Customweb_Payment_Util {	
	
	
	private function __construct() {
		// prevent any instantiation of this class	
	}
	
	/**
	 * This method extracts the expiry date (month, year) from a single string.
	 *           	 		    			 
	 * @param string $expriyDate
	 * @return array 
	 */
	public static function extractExpiryDate($expriyDate) {
		$month = null;
		$year = null;
		if (strlen($expriyDate) == 4) {
			$month = substr($expriyDate, 0, 2);
			$year = substr($expriyDate, 2, 2);
		}
		else if (strlen($expriyDate) == 6) {
			$month = substr($expriyDate, 0, 2);
			$year = substr($expriyDate, 2, 4);
		}
		
		return array(
			'month' => $month,
			'year' => $year,
		);
	}
	
	/**
	 * This method checks if two given amounts equals. 
	 * 
	 * @param double $amount1
	 * @param double $amount2
	 * @param int $decimalPlaces
	 * @return boolean
	 */
	public static function amountEqual($amount1, $amount2, $decimalPlaces = 2) {
		$amount1String = number_format($amount1, $decimalPlaces);
		$amount2String = number_format($amount2, $decimalPlaces);
		
		if ($amount1String == $amount2String) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * This method takes a language identifier and converts it to a ISO 639-1 
	 * (and ISO 3166-1) code. An array of supported languages (ISO 639-1/ISO 3166-1) 
	 * has to be provided, if the given language string could not be matched against
	 *  one of the patterns or if the pattern does not belong to a supported language 
	 *  the method returns per default "en_US".
	 *
	 * @param string $lang An arbitrary language identifier.
	 * @param array $supportedLanguages Array of ISO 639-1 code of languages to support
	 * @return string ISO 639-1 code of the given language
	 */
	public static function getCleanLanguageCode($lang, $supportedLanguages) {
		$isoCode = Customweb_Payment_Util::matchLanguagePattern($lang);
		if(in_array($isoCode,$supportedLanguages)){
			return $isoCode;
		}
		else {
			return "en_US";
		}
	}
	
	private static function matchLanguagePattern($lang)
	{
		$lang = preg_replace('/[^a-z]+/i', '_', strtolower($lang));
		
		switch($lang)
		{
			case 'de_de':
			case 'de':
			case 'de_ch':
			case 'german':
				return 'de_DE';
		
		
			case 'it_it':
			case 'it_ch':
			case 'it':
			case 'italian':
				return 'it_IT';
		
			case 'fr_fr':
			case 'fr_ch':
			case 'fr':
			case 'french':
				return 'fr_FR';
		
			case 'ar':
			case 'ar_ar':
				return 'ar_AR';
		
			case 'cs':
			case 'cs_cz':
				return 'cs_CZ';
		
			case 'dk_dk':
			case 'dk':
				return 'dk_DK';
		
			case 'el':
			case 'el_gr':
				return 'el_GR';
		
			case 'es_es':
			case 'es':
			case 'espanol':
				return 'es_ES';
		
			case 'fi_fi':
			case 'fi':
				return 'fi_FI';
		
			case 'he_il':
			case 'he':
				return 'he_IL';
		
			case 'hu_hu':
			case 'hu':
				return 'hu_HU';
		
			case 'ja_jp':
			case 'ja':
				return 'ja_JP';
		
			case 'ko_kr':
			case 'ko':
				return 'ko_KR';
		
			case 'nl_be':
				return 'nl_BE';
		
			case 'nl_nl':
			case 'nl':
				return 'nl_NL';
		
			case 'no_no':
			case 'no':
				return 'no_NO';
		
			case 'pl_pl':
			case 'pl':
				return 'pl_PL';
		
			case 'pt_pt':
			case 'pt':
				return 'pt_PT';
		
			case 'ru_ru':
			case 'ru':
				return 'ru_RU';
		
			case 'se_se':
			case 'se':
				return 'se_SE';
		
			case 'sk_sk':
			case 'sk':
				return 'sk_SK';
		
			case 'tr_tr':
			case 'tr':
				return 'tr_TR';
		
			case 'zh_cn':
			case 'zh':
				return 'zh_CN';
		
			case 'en':
			case 'en_gb':
			case 'en_us':
			case 'english':
			default:
				return 'en_US';
		}
	}
	
	public static function applyOrderSchema($orderSchema, $transactionId, $maxLength) {
		$id = (string)$transactionId;
	
		if(!empty($orderSchema)) {
			$totalLength = strlen($id) + strlen($orderSchema);
			if ($totalLength > $maxLength ) {
				$lengthToReduce = ($totalLength - $maxLength) ;
				$orderSchema = Customweb_Util_String::substrUtf8($orderSchema, min($lengthToReduce, strlen($orderSchema)), strlen($orderSchema));
			}
	
			if (strstr($orderSchema, '{id}')) {
				$id = str_replace('{id}', $id, $orderSchema);
			}
			else {
				$id = $orderSchema . $id;
			}
	
		}
		return Customweb_Util_String::substrUtf8($id, 0, $maxLength);
	}
	
}
	