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

PostFinanceCwUtil::includeClass('PostFinanceCw_OrderContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_PaymentMethodWrapper');
PostFinanceCwUtil::includeClass('PostFinanceCw_AdapterFactory');
PostFinanceCwUtil::includeClass('PostFinanceCw_TransactionContext');
/**
 * This class represents a transaction.
 * 
 * @author Thomas Hunziker
 *
 */
class PostFinanceCw_Transaction
{
	private $transaction_id = NULL;
	private $transaction_number = NULL;
	private $order_id;
	private $alias_for_display = null;
	private $alias_active = 'y';
	private $payment_method;
	private $payment_class;
	private $transaction_object;
	private $authorization_type;
	private $user_id;
	private $updated_on;
	private $created_on;
	private $payment_id;
	private $updatable = 'n';
	
	/**
	 * Reference to the transaction object of the API.
	 * 
	 * @var Customweb_Payment_Authorization_ITransaction
	 */
	private $transaction_object_reference = null;
	
	private static $FIELDS = array(
		'transaction_id',
		'transaction_number',
		'order_id',
		'alias_for_display',
		'alias_active',
		'payment_method',
		'payment_class',
		'transaction_object',
		'authorization_type',
		'user_id',
		'updated_on',
		'created_on',
		'payment_id',
		'updatable',
	);
	
	public function __construct() {
		$this->updated_on = date("Y-m-d H:i:s");
		$this->created_on = date("Y-m-d H:i:s");
	}
	
	private function setData($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$this->{$key} = $value;
			}
		}
	}
	
	private function getData() {
		foreach (self::$FIELDS as $field) {
			$data[$field] = $this->{$field};
		}
		return $data;
	}

	public static function loadById($id) {
		global $wpdb;
		$tableName = self::getTableName();
		
		if (empty($id) || $id === NULL) {
			throw new Exception("The given transaction id is empty.");
		}
		
		$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tableName WHERE transaction_id = %d", intval($id)), ARRAY_A);
		self::checkMySqlError();
		$transaction = new PostFinanceCw_Transaction();
		$transaction->setData($data);
		
		return $transaction;
	}
	
	public static function getTransactionByPaymentId($paymentId)
	{
		global $wpdb;
		$tableName = self::getTableName();
		
		if (empty($paymentId)) {
			throw new Exception("The given payment id is empty.");
		}
		$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tablename WHERE payment_id = %s", $paymentId), ARRAY_A);
		self::checkMySqlError();
		$transaction = new PostFinanceCw_Transaction();
		$transaction->setData($data);
		
		return $transaction;
	}
	/**
	 * Returns all updatable transactions
	 * 
	 *@return _PostFinanceCw_Transaction[] The transaction which have the updatable set to yes
	 */
	public static function getUpdatableTransactions() 
	{
		global $wpdb;
		$tableName = self::getTableName();
		
		$transactions = array();
		$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE updatable = 'y'"), ARRAY_A);
		self::checkMySqlError();
		
		foreach($rows as $data) {
			$t = new PostFinanceCw_Transaction();
			$t->setData($data);
			$transactions[$t->getTransactionId()] = $t;
		}
		return $transactions;
		
	}
	
	/**
	 * Return all transactions given by the order id
	 *
	 * @param integer $orderId The id of the order
	 * @return PostFinanceCw_Transaction[] The matching transactions for the given order id
	 */
	public static function getTransactionsByOrderId($orderId)
	{
		global $wpdb;
		$tableName = self::getTableName();
	
		$transactions = array();
		$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE order_id = %d ORDER BY created_on ASC", $orderId), ARRAY_A);
		self::checkMySqlError();
	
		foreach($rows as $data) {
			$t = new PostFinanceCw_Transaction();
			$t->setData($data);
			$transactions[$t->getTransactionId()] = $t;
		}
		return $transactions;
	}
	
	
	/**
	 * Retruns the first authorized transaction in series of recurring transactions.
	 *
	 * @param integer $orderId The id of the order
	 * @return PostFinanceCw_Transaction The initial transaction for the given order id
	 */
	public static function getInitialTransactionByOrderId($orderId)
	{
		global $wpdb;
		$tableName = self::getTableName();
	
		$transactions = array();
		$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName WHERE order_id = %d ORDER BY created_on ASC", $orderId), ARRAY_A);
		self::checkMySqlError();
		foreach($rows as $data) {
			$t = new PostFinanceCw_Transaction();
			$t->setData($data);
			if ($t->getTransactionObject()->isAuthorized()) {
				return $t;
			}
		}
		return NULL;
	}
	
	
	public static function getAliasTransactions($userId, $paymentMethod)
	{
		global $wpdb;
		$tableName = self::getTableName();
		
		$transactions = array();
		$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tableName 
			WHERE 
				`user_id` = '%s' AND 
				`payment_method` = '%s' AND 
				`alias_active` = 'y' AND 
				`alias_for_display` is not NULL AND 
				`alias_for_display` != ''
			ORDER BY created_on DESC
			LIMIT 0,30", $userId, $paymentMethod), ARRAY_A);
		self::checkMySqlError();
		
		$aliases = array();
		foreach($rows as $data)
		{
			if (!isset($aliases[$data['alias_for_display']])) {
				$aliases[$data['alias_for_display']] = $data;
			}
		}
		foreach ($aliases as $data) {
			$transaction = new PostFinanceCw_Transaction();
			$transaction->setData($data);
			
			// Skip transaction, which have no order associated anymore.
			if ($transaction->getOrder() !== NULL) {
				$transactions[$transaction->getTransactionId()] = $transaction;
			}
		}
		return $transactions;
	}
	
	
	public function getTransactionId() {
		return $this->transaction_id;
	}
	
	public function getTransactionNumber() {
		return $this->transaction_number;
	}
	
	public function getOrderId() {
		return $this->order_id;
	}
	
	public function getOrder() {
		// We load the order object always fresh from the database, to make sure,
		// that no old status is shared between the different usages.
		return PostFinanceCwUtil::loadOrderObjectById($this->getOrderId());
	}
	
	public function setOrderId($orderId) {
		$this->order_id = $orderId;
		return $this;
	}
	
	public function setUserId($userId) {
		$this->user_id = $userId;
		return $this;
	}
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function getAuthorizationType() {
		return $this->authorization_type;
	}
	
	public function setAuthorizationType($authorization_type) {
		$this->authorization_type = $authorization_type;
		return $this;
	}
	
	public function getUpdatedOn() {
		return $this->updated_on;
	}
	
	public function getCreatedOn() {
		return $this->created_on;
	}
	
	public function getPaymentId() {
		return $this->payment_id;
	}
	
	public function getPaymentClassName() {
		return $this->payment_class;
	}
	
	public function setPaymentClassName($className) {
		$this->payment_class = $className;
		return $this;
	}
	
	/**
	 * This method returns true, if this transaction may change in the future by
	 * invoking the update service. This is required to filter out the transactions
	 * which may not change in the future.
	 * 
	 * @return boolean
	 */
	public function isUpdatable() {
		return $this->updatable;
	}
	
	public function setPaymentId($paymentId) {
		$this->payment_id = $paymentId;
		return $this;
	}
	
	public function isAliasActive() {
		return $this->alias_active == 'y' ? true : false;
	}
	
	public function setAliasActive($active) {
		if ($active) {
			$this->alias_active = 'y';
		}
		else {
			$this->alias_active = 'n';
		}
		return $this;
	}
	
	/**
	 * This method returns the display name as it should be shown to the customer.
	 *
	 * @return string Alias Display Name
	 */
	public function getAliasForDisplay() {
		return $this->alias_for_display;
	}
	
	/**
	 * This method sets the display name. The display name is the value shown to
	 * the customer to represent this alias.
	 *
	 * @param string $displayName
	 * @return PostFinanceCw_Alias
	 */
	public function setAliasForDisplay($displayName) {
		$this->alias_for_display = $displayName;
		return $this;
	}
	
	/**
	 * This method returns the payment method name by which this
	 * transaction was created by.
	 *
	 * @return string
	 */
	public function getPaymentMethodName() {
		return $this->payment_method;
	}
	
	/**
	 * This method sets the payment method usedd to create this alias.
	 *
	 * @param string $methodName
	 * @return PostFinanceCw_Transaction
	 */
	public function setPaymentMethodName($methodName) {
		$this->payment_method = $methodName;
		return $this;
	}
	
	public function save() {
		global $wpdb;
		$this->updated_on = date("Y-m-d H:i:s");
		
		if ($this->getOrderId() === NULL) {
			throw new Exception("Could not store the transaction. The field 'order_id' is required.");
		}
		
		if ($this->getUserId() === NULL) {
			throw new Exception("Could not store the transaction. The field 'user_id' is required.");
		}
		
		
		if ($this->transaction_object_reference != null) {
			$this->transaction_object = base64_encode(serialize($this->transaction_object_reference));
			$this->setPaymentId($this->transaction_object_reference->getPaymentId());
			$userId = intval($this->getUserId());
			if ($this->transaction_object_reference->getAliasForDisplay() != null && $this->transaction_object_reference->getAliasForDisplay() != '' && $userId > 0) {
				$this->setAliasForDisplay($this->transaction_object_reference->getAliasForDisplay());
			}
			$this->setAuthorizationType($this->transaction_object_reference->getAuthorizationMethod());
			$this->setPaymentMethodName($this->transaction_object_reference->getPaymentMethod()->getPaymentMethodName());
				
			if ($this->transaction_object_reference->getPaymentCustomerContext() !== null) {
				$this->transaction_object_reference->getPaymentCustomerContext()->persist();
			}
			
			if ($this->transaction_object_reference->isUpdatable()) {
				$this->updatable = 'y';
			}
			else {
				$this->updatable = 'n';
			}
		}
		
		$data = $this->getData();
		if ($this->transaction_id === NULL) {
			$wpdb->insert(self::getTableName(), $data);
			self::checkMySqlError();
			$this->transaction_id = $wpdb->insert_id;
			$this->transaction_number = $this->getOrderId() . '_' . $this->transaction_id;
		}
		
		// Update in any case, because the transaction number has changed!
		$data = $this->getData();
		$wpdb->update(self::getTableName(), $data, array('transaction_id' => $this->getTransactionId()));
		self::checkMySqlError();
		
		return $this;
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
	
	/**
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transactionObject
	 * @return PostFinanceCw_Transaction
	 */
	public function setTransactionObject(Customweb_Payment_Authorization_ITransaction $transactionObject) {
		$this->transaction_object_reference = $transactionObject;
		return $this;
	}

	/**
	 * 
	 * @return Customweb_Payment_Authorization_ITransaction
	 */
	public function getTransactionObject() {
		if ($this->transaction_object_reference === null && !empty($this->transaction_object)) {
			// Load the adapter that was used to create this transaction. This is
			// required to load all classes on which the seralized class depends on.
			$factory = new PostFinanceCw_AdapterFactory();
			$factory->getAdapterByAuthorizationMethod($this->getAuthorizationType());
			
			$this->transaction_object_reference = unserialize(base64_decode($this->transaction_object));
		}
		return $this->transaction_object_reference;
	}
	
	public static function installTable() {
		global $wpdb;
		$table_name = self::getTableName();
		
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			`transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
			`transaction_number` varchar(255) default NULL,
			`order_id` bigint(20) NOT NULL,
			`alias_for_display` varchar(255) default NULL,
			`alias_active` char(1) default 'y',
			`payment_method` varchar(255) NOT NULL,
			`payment_class` varchar(255) NOT NULL,
			`transaction_object` text default '',
			`authorization_type` varchar(255) NOT NULL,
			`user_id` varchar(255) default NULL,
			`updated_on` datetime NOT NULL,
			`created_on` datetime NOT NULL,
			`payment_id` varchar(255) NOT NULL,
			`updatable` char(1) default 'n',
			PRIMARY KEY  (`transaction_id`)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		self::checkMySqlError();		
	}
	
	protected static function getTableName() {
		global $wpdb;
		return $wpdb->prefix . "postfinancecw_transactions";
	}
		
	
}

