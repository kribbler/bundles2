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

PostFinanceCwUtil::includeClass('PostFinanceCw_TransactionContext');
PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');
PostFinanceCwUtil::includeClass('PostFinanceCw_RecurringOrderContext');

library_load_class_by_name('Customweb_Payment_Authorization_Recurring_ITransactionContext');

class PostFinanceCw_RecurringTransactionContext extends PostFinanceCw_TransactionContext implements Customweb_Payment_Authorization_Recurring_ITransactionContext
{
	protected $initialTransactionId;
	
	private $initialTransaction;
	
	public function __construct(PostFinanceCw_Transaction $transaction, $order, $paymentMethod, $amountToCharge, $productId) {
		parent::__construct($transaction, $order, $paymentMethod);
		$initialTransaction = PostFinanceCw_Transaction::getInitialTransactionByOrderId($order->id);
		if ($initialTransaction === NULL) {
			throw new Exception(sprintf("No initial transaction found for order %s.", $order->id));
		}
		
		$this->initialTransactionId = $initialTransaction->getTransactionId();
		$this->orderContext = new PostFinanceCw_RecurringOrderContext($order, $paymentMethod, $amountToCharge, $productId);
	}
	
	public function __sleep() {
		$fields = parent::__sleep();
		$fields[] = 'initialTransactionId';
		return $fields;
	}
	
	public function getInitialTransaction() {
		if ($this->initialTransaction === NULL) {
			$this->initialTransaction = PostFinanceCw_Transaction::loadById($this->initialTransactionId);
		}
		return $this->initialTransaction->getTransactionObject();
	}
}