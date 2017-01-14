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

require_once 'Customweb/Payment/Authorization/ITransaction.php';

/**
 * This interface defines the way how the status of transaction are propaged by
 * the payment service provider. 
 * 
 * In case the transaction is marked as updatable (see method isUpdatable()), the 
 * shop system will invoke the update process in regular cycles. This means the shop 
 * system willselect all transaction from the databases, which may receive any update 
 * and process by invoking updateTransaction(). (The update is pulled from the server
 * of the payment service provider.)
 * 
 * On the other hand, the shop system provides the option to be invoked by the
 * payment service provider over a HTTP request. In case such a request was 
 * sent the method processTransactionUpdate() is invoked. To be able to load the
 * transaction from the database the shop system requires to receives the parameter
 * 'transaction_id'. The URL to call on is provided in the TransactionContext.
 * 
 * @see Customweb_Payment_Authorization_ITransaction
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Payment_Update_IAdapter {
	
	/**
	 * This method provides a list of payment ids (see ITransaction), which may be updated. The caller should take
	 * the list of payment ids, load them and the method self::processTransactionUpdate(). The
	 * parameter '$parameters' should be filled by the data of the payment id provided by this
	 * method.
	 *
	 * @param DateTime $lastSuccessFullUpdate The date time when the last batch was completly successful processed.
	 * @return array A map with transaction parameters. The keys of the map are the transaction ids. The data associated
	 *         with these keys are the input for the $parameters of the method self::processTransactionUpdate()
	 *
	 */
	public function batchUpdate(DateTime $lastSuccessFullUpdate);
	
	
	/**
	 * This method is invoked, whenever a transaction is updated. The changed transaction 
	 * state is automatically reflected to the action of the store.
	 * 
	 * This is the pull case, where the shop collects the data from PSP.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function pullTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_Payment_BackendOperation_IAdapterFactory $adapterFactory);
	
	/**
	 * This method is invoked, when a notification is received. This methods returns the transactionId or the paymentId of the transaction,
	 * that needs to be loaded. The return value is a map with either transactionId or paymentId as key and the corresponding id as value.
	 * 
	 * This method may kill the process to deliver an answer to the requestor. The shop system must handle this situation.
	 * 
	 * @return array
	 */
	public function preprocessTransactionUpdate();
	
	/**
	 * This method is invoked when a update HTPP request is received or by the batch update method. The changed transaction 
	 * state is automatically reflected to the action of the store.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function processTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters, Customweb_Payment_BackendOperation_IAdapterFactory $adapterFactory);
	
	
	/**
	 * This method is called after the methods pullTransactionUpdate() and processTransactionUpdate() to give the API
	 * the chance to confirm the update. This is useful in case the PSP supports the option to confirm an update. The 
	 * advantage of a confirmation is that no update get lost in case of a failure of one system.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function confirmTransactionUpdate(Customweb_Payment_Authorization_ITransaction $transaction);
	
	/**
	 * This method is called whenever a transaction update fails. The adapter may kill the 
	 * process and response with a response to the requestor.
	 * 
	 * @param Customweb_Payment_Authorization_ITransaction $transaction The transaction which is affected by the update. This may be null, in case the transaction could not even be loaded.
	 * @param string $errorMessage The shop may provide some error message. This value can be empty or null.
	 * @return void
	 */
	public function confirmFailedTransactionUpdate($transaction, $errorMessage);
	
}




