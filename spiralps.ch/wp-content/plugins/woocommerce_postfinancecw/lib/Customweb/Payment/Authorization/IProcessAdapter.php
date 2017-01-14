<?php 

interface Customweb_Payment_Authorization_IProcessAdapter 
{
	
	/**
	 * This method process an authorization request. The caller has to make
	 * sure that he stores the $transaction and the $paymentContext after the
	 * call of this method. This method should never thrown an exception. If an
	 * error occurs it should be written to the $transaction error log.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * 		The transaction to be processed.
	 * @param array $parameters
	 * 		The current HTTP parameters (Key/Value pair). Normally the $_REQUEST should be used.
	 * @return void
	 */
	public function processAuthorization(Customweb_Payment_Authorization_ITransaction $transaction, array $parameters);
	
	/**
	 * <p>This method does further processing of the authorization. After executing
	 * this method not further processing happens. The callerr must terminate the
	 * process after calling this method. No further output should be produced by
	 * this method. However the caller is allowed to record the HTTP response changes
	 * (content and headers) and send the response to the browser later in the code.</p>
	 *
	 * <p>The client has to make sure, that the method is completely in charge of the
	 * script output(i.e. can set headers). This method has to be called always when the method processAuthorization() was
	 * called.</p>
	 *
	 * Sample reactions are:
	 * <ul>
	 * 	 <li>Verify the transaction with 3D secure.</li>
	 *   <li>Set a HTTP Header to indicate if the action was successful.</li>
	 *   <li>A HTTP Location is set</li>
	 *   <li>The whole output buffer is cleared and some status message is produced.</li>
	 *   <li>Nothing is done.</li>
	 * </ul>
	 *
	 * In case the client sends any output to the output buffer before calling
	 * this method, the client must invoke the ob_start before starting any output
	 * to the output buffer. This is required, because a the HTTP response may contain
	 * also a body.
	 *
	 * @param Customweb_Payment_Authorization_ITransaction $transaction
	 * @return void
	 */
	public function finalizeAuthorizationRequest(Customweb_Payment_Authorization_ITransaction $transaction);
	
}