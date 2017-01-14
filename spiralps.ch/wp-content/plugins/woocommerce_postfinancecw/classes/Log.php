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

class PostFinanceCw_Log {
	
	private $logId;
	private $message;
	
	public function __construct($logId, $message) {
		$this->logId = $logId;
		$this->message = $message;
	}
	
	public function getLogId() {
		return $this->logId;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public static function add($message) {
		global $wpdb;
		$data = array(
			'message' => $message,
			'created_on' => date("Y-m-d H:i:s")
		);
		$wpdb->insert(self::getTableName(), $data);
		self::checkMySqlError();
	}
	
	
	public static function installTable() {
		$table_name = self::getTableName();
	
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			`log_id` bigint(20) NOT NULL AUTO_INCREMENT,
			`message` text default NULL,
			`created_on` datetime NOT NULL,
			PRIMARY KEY  (`log_id`)
			) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
	
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		self::checkMySqlError();		
			
	}
	
	/**
	 * This method throws an exception if the last executed query contains an error.
	 *
	 * @throws Exception
	 */
	private static function checkMySqlError() {
		$error = mysql_error();
		if (!empty($error)) {
			throw new Exception($error);
		}
	}
	
	protected static function getTableName() {
		global $wpdb;
		return $wpdb->prefix . "postfinancecw_logs";
	}
	
	
}