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

if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
	class Customweb_Date_DateTime extends DateTime {

	}
}
else {
	/**
	 * In PHP 5.2.x DateTime object can not be serialized.
	 * This class is a wrapper, which allows the
	 * serialization of the DateTime also prior to version 5.3. 
	 * The date is stored as a String.
	 *
	 * @author Thomas Hunziker
	 *        
	 */
	class Customweb_Date_DateTime extends DateTime {
		/**
		 *
		 * @var DateTime
		 */
		private $dateTime = null;
		private $dateTimeAsString = '';
		public function __construct($time = null, $timezone = null) {
			if ($timezone === null) {
				$this->dateTime = new DateTime ( $time );
			} else {
				$this->dateTime = new DateTime ( $time, $timezone );
			}
		}
		public function __sleep() {
			$this->dateTimeAsString = $this->dateTime->format ( 'Y-m-d H:i:sP' );
			return array (
					'dateTimeAsString'
			);
		}
	
		public function __wakeup() {
			$this->dateTime = new DateTime ( $this->dateTimeAsString );
		}
	
		public function format($format) {
			return $this->dateTime->format ( $format );
		}
	
		public function modify($modify) {
			return $this->dateTime->modify ( $modify );
		}
	
		public function add($interval) {
			return $this->dateTime->add ( $interval );
		}
	
		public function sub($interval) {
			return $this->dateTime->sub ( $interval );
		}
	
		public function getTimezone() {
			return $this->dateTime->getTimezone ();
		}
	
		public function setTimezone($timezone) {
			return $this->dateTime->setTimezone ( $timezone );
		}
	
		public function getOffset() {
			return $this->dateTime->getOffset ();
		}
	
		public function setTime($hour, $minute, $second = null) {
			if ($second === null) {
				return $this->dateTime->setTime ( $hour, $minute);
			}
			else {
				return $this->dateTime->setTime ( $hour, $minute, $second );
			}
		}
	
		public function setDate($year, $month, $day) {
			return $this->dateTime->setDate ( $year, $month, $day );
		}
	
		public function setISODate($year, $week, $day = null) {
			if ($day === null) {
				return $this->dateTime->setISODate ( $year, $week );
			}
			else {
				return $this->dateTime->setISODate ( $year, $week, $day );
			}
		}
	
		public function setTimestamp($unixtimestamp) {
			return $this->dateTime->setTimestamp ( $unixtimestamp );
		}
	
		public function getTimestamp() {
			return $this->dateTime->getTimestamp ();
		}
	
		public function diff($datetime2, $absolute = null) {
			if ($absolute == null) {
				return $this->dateTime->diff($datetime2);
			}
			else {
				return $this->dateTime->diff($datetime2, $absolute);
			}
		}
	}
}



