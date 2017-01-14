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
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionRefund.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionCapture.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionCancel.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/IErrorMessage.php';
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/Util/Invoice.php';

/**
 * This is a default implemenation of a transaction. In most cases this class
 * should be usable by the implementors.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Authorization_DefaultTransaction implements Customweb_Payment_Authorization_ITransaction {

	/**
	 * @var Customweb_Payment_Authorization_ITransactionContext
	 */
	private $transactionContext;

	private $transactionId;

	private $paymentId;

	private $authorizationAmount;

	private $currencyCode;

	private $historyItems = array();

	private $alias = null;

	private $aliasForDisplay = null;

	private $authorizationMethod = null;

	/**
	 * @var Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	private $paymentCustomerContext = null;

	/**
	 * @var boolean
	 */
	private $authorized = false;

	/**
	 * @var boolean
	 */
	private $authorizationFailed = false;

	/**
	 * @var boolean
	 */
	private $authorizationUncertain = false;

	/**
	 * @var boolean
	 */
	private $captured = false;

	/**
	 * @var boolean
	 */
	private $cancelled = false;

	/**
	 * List of parameters sent by the payment service provider for the
	 * authorization confirmation.
	 *
	 * @var array
	 */
	private $parameters;

	private $capturedAmount = 0;

	private $refundedAmount = 0;

	private $captureClosed = false;

	private $refundClosed = false;

	private $refunds = array();

	private $captures = array();

	private $cancels = array();

	private $errorMessages = array();

	private $updatable = false;

	/**
	 * @var boolean
	 */
	private $paid = false;

	const STATE_3D_SECURE_NOT_APPLICABLE = '3d-secure-not-applicable';
	const STATE_3D_SECURE_FAILED = '3d-secure-failed';
	const STATE_3D_SECURE_SUCCESS = '3d-secure-success';

	private $state3DSecure = self::STATE_3D_SECURE_NOT_APPLICABLE;

	public function __construct(Customweb_Payment_Authorization_ITransactionContext $transactionContext) {
		$this->transactionContext = $transactionContext;
		$this->transactionId = $transactionContext->getTransactionId();
		$this->authorizationAmount = $transactionContext->getOrderContext()->getOrderAmountInDecimals();
		$this->currencyCode = $transactionContext->getOrderContext()->getCurrencyCode();
		$this->paymentCustomerContext = $transactionContext->getPaymentCustomerContext();

		$skus = array();
		foreach($this->getTransactionContext()->getOrderContext()->getInvoiceItems() as	$item) {
			if (isset($skus[$item->getSku()])) {
				throw new Exception("Could not start transaction because there are multiple line items with the same SKU.");
			}
			$skus[$item->getSku()] = $item->getSku();
		}
	}

	/**
	 * @return Customweb_Payment_Authorization_ITransactionContext
	 */
	public function getTransactionContext() {
		return $this->transactionContext;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getTransactionId()
	 */
	public function getTransactionId() {
		return $this->transactionId;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getPaymentId()
	 */
	public function getPaymentId() {
		return $this->paymentId;
	}

	/**
	 * This method sets the paymentID.
	 *
	 * @param String $paymentId
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function setPaymentId($paymentId) {
		$this->paymentId = $paymentId;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getAuthorizationMethod()
	 */
	public function getAuthorizationMethod() {
		return $this->authorizationMethod;
	}

	/**
	 * This method sets the authorization method.
	 *
	 * @param string $method Method name
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function setAuthorizationMethod($method) {
		$this->authorizationMethod = $method;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getAuthorizationAmount()
	 */
	public function getAuthorizationAmount() {
		return $this->authorizationAmount;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getCurrencyCode()
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getPaymentMethod()
	 */
	public function getPaymentMethod() {
		return $this->transactionContext->getOrderContext()->getPaymentMethod();
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isAuthorizationFailed()
	 */
	public function isAuthorizationFailed() {
		return $this->authorizationFailed;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isAuthorizationUncertain()
	 */
	public function isAuthorizationUncertain() {
		return $this->authorizationUncertain;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getHistoryItems()
	 */
	public function getHistoryItems() {
		return $this->historyItems;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getErrorMessages()
	 */
	public function getErrorMessages(){
		return $this->errorMessages;
	}

	/**
	 * Add a message to the list of error messages.
	 *
	 * @param Customweb_Payment_Authorization_IErrorMessage $message
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 * @deprecated Use instead addErrorMessage()
	 */
	public function addErrorMessages($message){
		return $this->addErrorMessage($message);
	}

	/**
	 * Add a message to the list of error messages.
	 *
	 * @param Customweb_Payment_Authorization_IErrorMessage $message
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function addErrorMessage($message){

		if ($message instanceof Customweb_Payment_Authorization_IErrorMessage) {
			$this->errorMessages[] = $message;
		}
		else {
			$this->errorMessages[] = new Customweb_Payment_Authorization_ErrorMessage($message);
		}

		return $this;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_ITransactionHistoryItem $item
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function addHistoryItem(Customweb_Payment_Authorization_ITransactionHistoryItem $item) {
		$this->historyItems[] = $item;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isAuthorized()
	 */
	public function isAuthorized() {
		return $this->authorized;
	}

	/**
	 *
	 * @param Customweb_I18n_LocalizableString $reason
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function setAuthorizationFailed($reason) {
		if (is_string($reason)) {
			$reason = new Customweb_I18n_LocalizableString($reason);
		}
		if ($this->isAuthorized()) {
			throw new Exception(Customweb_I18n_Translation::__("A authorized transaction cannot be marked as failed."));
		}

		if ($this->isCancelled()) {
			throw new Exception(Customweb_I18n_Translation::__("A cancelled transaction cannot  be marked as failed."));
		}

		if ($this->isCaptured()) {
			throw new Exception(Customweb_I18n_Translation::__("A captured transaction cannot  be marked as failed."));
		}
		$this->addErrorMessage(new Customweb_Payment_Authorization_ErrorMessage($reason));

		$this->createHistoryItem(
				$reason,
				Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_AUTHORIZATION
		);
		$this->authorizationFailed = true;

		return $this;
	}

	/**
	 * This method sets an authorization to uncertain. A uncertain payment is one
	 * that may be successful, but it is not absolutly for sure.
	 *
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function setAuthorizationUncertain() {
		$this->authorizationUncertain = true;
		return $this;
	}

	/**
	 * This methdo runs a authorize action, but without change the state.
	 *
	 * @param string $additionalInformation
	 * @param boolean $paid
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function authorizeDry($additionalInformation = '', $paid = true) {
		if ($this->isAuthorizationFailed()) {
			throw new Exception(Customweb_I18n_Translation::__("A failed authorization cannot be authorized."));
		}

		if ($this->isAuthorized()) {
			throw new Exception(Customweb_I18n_Translation::__("A authorized transaction cannot be authorized again."));
		}

		if ($this->isCancelled()) {
			throw new Exception(Customweb_I18n_Translation::__("A cancelled transaction cannot be authorized."));
		}

		if ($this->isCaptured()) {
			throw new Exception(Customweb_I18n_Translation::__("A captured transaction cannot be authorized."));
		}
		return $this;
	}

	/**
	 * This method authorize this transaction.
	 *
	 * @param string $additionalInformation [optional] A message which gives more information about the authorization.
	 * @param boolean $paid
	 * @throws Exception In case some constraints are not fulfield.
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function authorize($additionalInformation = '', $paid = true) {
		$this->authorizeDry($additionalInformation, $paid);

		$historyMessage = Customweb_I18n_Translation::__(
			"The amount of !amount is authorized.",
			array('!amount' => Customweb_Util_Currency::formatAmount($this->getAuthorizationAmount(), $this->getCurrencyCode()))
		);
		if (!empty($additionalInformation)) {
			$historyMessage .= ' (' . $additionalInformation . ')';
		}

		$this->createHistoryItem(
				$historyMessage,
				Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_AUTHORIZATION
		);

		if ($paid) {
			$this->setPaid();
		}

		$this->authorized = true;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isCaptured()
	 */
	public function isCaptured() {
		return $this->captured;
	}

	/**
	 * This method sets the transaction as captured. The whole authorized amount is set as
	 * captured.
	 *
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_ITransactionCapture
	 */
	public function capture($additionalMessage = '') {
		return $this->partialCapture($this->getAuthorizationAmount(), true, $additionalMessage);
	}

	/**
	 * This method sets the state to capture, but wihtout changing the inner state of the transaction. The whole
	 * authorized amount is set as captured.
	 *
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_ITransactionCapture
	 */
	public function captureDry($additionalMessage = '') {
		return $this->partialCaptureDry($this->getAuthorizationAmount(), true, $additionalMessage);
	}

	/**
	 * This method executes a partial capture, without changing the transaction state.
	 *
	 * @param double $amount The amount that should be captured.
	 * @param boolean $close Close the transaction or not.
	 * @param string $additionalMessage
	 * @throws Exception If something is not allowed to do.
	 */
	public function partialCaptureDry($amount, $close = false, $additionalMessage = '') {
		$items = $amount;
		if (!is_array($items)) {
			$items = Customweb_Util_Invoice::getItemsByReductionAmount($this->getUncapturedLineItems(), $amount, $this->getCurrencyCode());
		}
		return $this->partialCaptureByLineItemsDry($items, $close, $additionalMessage);
	}

	public function partialCaptureByLineItemsDry($items, $close = false, $additionalMessage = '') {

		// TODO: check each single line item if it does not capture more as the corresponding one in the original order context

		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		if (!$this->isAuthorized()) {
			throw new Exception(Customweb_I18n_Translation::__("Only authorized transaction can be captured."));
		}

		if ($this->captureClosed) {
			throw new Exception(Customweb_I18n_Translation::__("This transaction is already closed for further captures."));
		}

		if ($this->isCancelled()) {
			throw new Exception(Customweb_I18n_Translation::__("A cancelled transaction cannot be captured."));
		}

		if (round(($this->getCapturedAmount() + $amount), 2) > round($this->getAuthorizationAmount(), 2)) {
			throw new Exception(Customweb_I18n_Translation::__(
				"The capture amount (!captureAmount) cannot be greater than the authorized amount (!authorizedAmount).",
				array(
					'!captureAmount' => $amount,
					'!authorizedAmount' => $this->getAuthorizationAmount(),
				)
			));
		}
		return $this;
	}

	/**
	 * @param unknown $items
	 * @param string $close
	 * @param string $additionalMessage
	 * @return Customweb_Payment_Authorization_DefaultTransactionCapture
	 */
	public function partialCaptureByLineItems($items, $close = false, $additionalMessage = '') {

		$this->partialCaptureByLineItemsDry($items, $close, $additionalMessage);
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		$historyMessage = Customweb_I18n_Translation::__(
			"The amount of !amount is captured.",
			array('!amount' => Customweb_Util_Currency::formatAmount($amount, $this->getCurrencyCode()))
		);
		if (!empty($additionalMessage)) {
			$historyMessage .= ' (' . $additionalMessage . ')';
		}

		$captureItem = $this->createCaptureItem($amount);
		$captureItem->setCaptureItems($items);
		$this->createHistoryItem(
			$historyMessage,
			Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_CAPTURING
		);

		$this->captured = true;
		if ($this->getCapturedAmount() >= $this->getAuthorizationAmount()) {
			$close = true;
		}
		$this->captureClosed = $close;

		return $captureItem;
	}

	/**
	 * This method marks this transaction as partial captured.
	 *
	 * @param double $amount The amount that should be captured.
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_ITransactionCapture
	 */
	public function partialCapture($amount, $close = false, $additionalMessage = '') {
		$items = $amount;
		if (!is_array($items)) {
			$items = Customweb_Util_Invoice::getItemsByReductionAmount($this->getUncapturedLineItems(), $amount, $this->getCurrencyCode());
		}
		return $this->partialCaptureByLineItems($items, $close, $additionalMessage);
	}

	/**
	 * This method returns a list of line items with the residual amount to capture.
	 *
	 * @return Customweb_Payment_Authorization_ITransactionCapture[]
	 */
	public function getUncapturedLineItems() {

		$resultinItems = $this->getTransactionContext()->getOrderContext()->getInvoiceItems();
		foreach ($this->getCaptures() as $capture) {
			$items = $capture->getCaptureItems();
			if ($items === null) {
				$items = Customweb_Util_Invoice::getItemsByReductionAmount($resultinItems, $capture->getAmount(), $this->getCurrencyCode());
			}
			$resultinItems = Customweb_Util_Invoice::getResultingLineItemsByDeltaItems($resultinItems, $items);
		}

		return $resultinItems;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getCapturedAmount()
	 */
	public function getCapturedAmount() {
		return $this->capturedAmount;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isCancelled()
	 */
	public function isCancelled() {
		return $this->cancelled;
	}

	/**
	 * This method cancels the transaction without changing the inner state. This method can be used
	 * to check the constraints for this action.
	 *
	 * @param string $additionalMessage
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_ITransactionCapture
	 */
	public function cancelDry($additionalMessage = '') {
		if ($this->isCaptured()) {
			throw new Exception(Customweb_I18n_Translation::__("A captured transaction cannot be cancelled."));
		}

		if (!$this->isAuthorized()) {
			throw new Exception(Customweb_I18n_Translation::__("Only authorized transaction can be cancelled."));
		}

		if ($this->isCancelled()) {
			throw new Exception(Customweb_I18n_Translation::__("A cancelled transaction cannot be cancelled again."));
		}
		return $this;
	}

	/**
	 *
	 * @param boolean $close
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_ITransactionCancel
	 */
	public function cancel($additionalMessage = '') {
		$this->cancelDry($additionalMessage);

		$historyMessage = Customweb_I18n_Translation::__("The whole transaction is cancelled.");
		if (!empty($additionalMessage)) {
			$historyMessage .= ' (' . $additionalMessage . ')';
		}
		$cancelItem = $this->createCancelItem();

		$this->createHistoryItem(
			$historyMessage,
			Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_CANCELLATION
		);

		$this->cancelled = true;
		return $cancelItem;
	}

	public function getAuthorizationParameters() {
		return $this->parameters;
	}

	public function setAuthorizationParameters(array $parameters) {
		$this->parameters = $parameters;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getRefundedTotalAmount()
	 */
	public function getRefundedTotalAmount() {
		return $this->refundedAmount;
	}

	/**
	 * This method creates a new refund and creates a new history item, but without changing the state. This method
	 * can be used to check if a given refund, will be accepted by this transaction.
	 *
	 * @param double $amount
	 * @param boolean $close
	 * @param string $additionalMessage
	 * @throws Exception
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function refundDry($amount, $close = false, $additionalMessage = '') {
		$items = $amount;
		if (!is_array($items)) {
			$items = Customweb_Util_Invoice::getItemsByReductionAmount($this->getNonRefundedLineItems(), $amount, $this->getCurrencyCode());
		}
		return $this->refundByLineItemsDry($items, $close, $additionalMessage);
	}

	public function refundByLineItemsDry(array $items, $close = false, $additionalMessage = '') {

		// TODO: check each single line item if it does not refund more as the corresponding one in the original order context
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);

		if (!$this->isAuthorized()) {
			throw new Exception(Customweb_I18n_Translation::__("Only authorized transaction can be refunded."));
		}

		if ($this->refundClosed) {
			throw new Exception(Customweb_I18n_Translation::__("This transaction is already closed for further refunds."));
		}

		if ($this->isCancelled()) {
			throw new Exception(Customweb_I18n_Translation::__("A cancelled transaction cannot be refunded."));
		}

		if (!$this->isCaptured()) {
			throw new Exception(Customweb_I18n_Translation::__("Only captured transaction can be refunded."));
		}

		$newTotalRefundedAmount = $amount + $this->getRefundedTotalAmount();
		if (round($newTotalRefundedAmount, 2) > round($this->getCapturedAmount(), 2)) {
			throw new Exception(Customweb_I18n_Translation::__(
					"The total refund amount (!totalRefundedAmount) cannot be greater than the captured amount (!capturedAmount).",
					array(
							'!totalRefundedAmount' => $newTotalRefundedAmount,
							'!capturedAmount' => $this->getCapturedAmount(),
					)
			));
		}
		return $this;
	}

	/**
	 * This method creates a new refund and creates a new history item.
	 *
	 * @param double $amount The amount to refund
	 * @param boolean $close Close the transaction for further refunds
	 * @return Customweb_Payment_Authorization_ITransactionRefund
	 */

	public function refund($amount, $close = false, $additionalMessage = '') {
		$items = $amount;
		if (!is_array($items)) {
			$items = Customweb_Util_Invoice::getItemsByReductionAmount($this->getNonRefundedLineItems(), $amount, $this->getCurrencyCode());
		}
		return $this->refundByLineItems($items, $close, $additionalMessage);
	}


	public function refundByLineItems($items, $close = false, $additionalMessage = '') {

		$this->refundByLineItemsDry($items, $close, $additionalMessage);
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);

		$historyMessage = Customweb_I18n_Translation::__(
			"A refund was added over !amount.",
			array('!amount' => Customweb_Util_Currency::formatAmount($amount, $this->getCurrencyCode()))
		);
		if (!empty($additionalMessage)) {
			$historyMessage .= ' (' . $additionalMessage . ')';
		}

		$refundItem = $this->createRefundItem($amount);
		$refundItem->setRefundItems($items);
		$this->createHistoryItem(
			$historyMessage,
			Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_REFUND
		);

		if ($this->getRefundedTotalAmount() >= $this->getCapturedAmount()) {
			$close = true;
		}
		$this->refundClosed = $close;

		return $refundItem;
	}


	/**
	 * This method returns a list of line items with the residual amount to refund.
	 *
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public function getNonRefundedLineItems() {

		$resultingItems = $this->getTransactionContext()->getOrderContext()->getInvoiceItems();

		foreach ($this->getRefunds() as $refund){
			$items = $refund->getRefundItems();
			if($items === null){
				$items = Customweb_Util_Invoice::getItemsByReductionAmount($resultingItems, $refund->getAmount(), $this->getCurrencyCode());
			}
			$resultingItems = Customweb_Util_Invoice::getResultingLineItemsByDeltaItems($resultingItems, $items);
		}
		return $resultingItems;
	}

	/**
	 * This method adds a refund object to the list of refunds. To add a refund
	 * the method self::refund() should be used.
	 *
	 * @param Customweb_Payment_Authorization_ITransactionRefund $refund
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function addRefund(Customweb_Payment_Authorization_ITransactionRefund $refund) {
		$this->refunds[] = $refund;
		return $this;
	}

	/**
	 * This method adds a capture object to the list of refunds. To add a capture
	 * the method self::setPartialCapture() should be used.
	 *
	 * @param Customweb_Payment_Authorization_ITransactionCapture $refund
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function addCapture(Customweb_Payment_Authorization_ITransactionCapture $capture) {
		$this->captures[] = $capture;
		return $this;
	}

	/**
	 * This method adds a cancel object to the list of cancels. To add a cancel
	 * the method self::cancel() should be used.
	 *
	 * @param Customweb_Payment_Authorization_ITransactionCancel $cancel
	 * @return Customweb_Payment_Authorization_AbstractTransaction
	 */
	public function addCancel(Customweb_Payment_Authorization_ITransactionCancel $cancel) {
		$this->cancels[] = $cancel;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getRefunds()
	 */
	public function getRefunds() {
		return $this->refunds;
	}

	public function getCaptures() {
		return $this->captures;
	}

	public function getCancels() {
		return $this->cancels;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isPartialRefundPossible()
	 */
	public function isPartialRefundPossible() {
		if ($this->refundClosed) {
			return false;
		}

		if (!$this->isCaptured()) {
			return false;
		}

		if ($this->getRefundedTotalAmount() >= $this->getCapturedAmount()) {
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isRefundPossible()
	 */
	public function isRefundPossible() {
		return $this->isPartialRefundPossible();
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isRefundClosable()
	 */
	public function isRefundClosable() {
		return !$this->refundClosed;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getRefundableAmount()
	 */
	public function getRefundableAmount() {
		return max($this->getCapturedAmount() - $this->getRefundedTotalAmount(), 0);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isPartialCapturePossible()
	 */
	public function isPartialCapturePossible() {
		if ($this->captureClosed) {
			return false;
		}

		if ($this->isCancelled()) {
			return false;
		}

		if (!$this->isAuthorized()) {
			return false;
		}

		if ($this->getCapturedAmount() >= $this->getAuthorizationAmount()) {
			return false;
		}
		else {
			return true;
		}
	}

	public function isCapturePossible() {
		return $this->isPartialCapturePossible();
	}

	public function isCaptureClosable() {
		return !$this->captureClosed;
	}

	public function isUpdatable(){
		return $this->updatable;
	}

	public function setUpdatable($updatable = true){
		$this->updatable = $updatable;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getCapturableAmount()
	 */
	public function getCapturableAmount() {
		return max($this->getAuthorizationAmount() - $this->getCapturedAmount(), 0);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isCancelPossible()
	 */
	public function isCancelPossible() {
		if (!$this->isAuthorized()) {
			return false;
		}

		if ($this->isCancelled()) {
			return false;
		}

		if ($this->isCaptured()) {
			return false;
		}

		return true;
	}

	/**
	 * This method creates a new history item. The item is automatically added
	 * to the list of history items and then returned.
	 *
	 * @param Customweb_I18n_LocalizableString $message The history message.
	 * @param string $action The action performed.
	 * @return Customweb_Payment_Authorization_ITransactionHistoryItem
	 */
	protected function createHistoryItem($message, $action) {
		$item = $this->buildNewHistoryObject($message, $action);
		$this->addHistoryItem($item);
		return $item;
	}

	protected function buildNewHistoryObject($message, $action) {
		return new Customweb_Payment_Authorization_DefaultTransactionHistoryItem($message, $action);
	}

	/**
	 * This method creates a refund item. The item is automatically added
	 * to the list of refunds and then returned.
	 *
	 * @param double $amount The refund amount.
	 * @return Customweb_Payment_Authorization_ITransactionRefund
	 */
	protected function createRefundItem($amount, $status = NULL, $refundId = NULL) {
		if ($refundId === NULL) {
			$number = count($this->getRefunds());
			$refundId = $this->getTransactionId() . '_r_' . ($number+1);
		}
		$item = $this->buildNewRefundObject($refundId, $amount, $status);
		$this->refundedAmount += $item->getAmount();
		$this->addRefund($item);
		return $item;
	}

	protected function buildNewRefundObject($refundId, $amount, $status = NULL) {
		return new Customweb_Payment_Authorization_DefaultTransactionRefund($refundId, $amount, $status);
	}


	/**
	 * This method creates a cancel item. The item is automatically added
	 * to the list of cancels and then returned.
	 *
	 * @return Customweb_Payment_Authorization_ITransactionCancel
	 */
	protected function createCancelItem($status = NULL, $cancelId = NULL) {
		if ($cancelId === NULL) {
			$number = count($this->getCancels());
			$cancelId = $this->getTransactionId() . '_a_' . ($number+1);
		}
		$item = $this->buildNewCancelObject($cancelId, $status);
		$this->addCancel($item);
		return $item;
	}

	protected function buildNewCancelObject($cancelId, $status = NULL) {
		return new Customweb_Payment_Authorization_DefaultTransactionCancel($cancelId, $status);
	}


	/**
	 * This method creates a capture item. The item is automatically added
	 * to the list of captures and then returned.
	 *
	 * @param double $amount The refund amount.
	 * @return Customweb_Payment_Authorization_ITransactionCapture
	 */
	protected function createCaptureItem($amount, $status = NULL, $captureId = NULL) {
		if ($captureId === NULL) {
			$number = count($this->getCaptures());
			$captureId = $this->getTransactionId() . '_c_' . ($number+1);
		}
		$item = $this->buildNewCaptureObject($captureId, $amount, $status);
		$this->capturedAmount += $item->getAmount();
		$this->addCapture($item);
		return $item;
	}

	protected function buildNewCaptureObject($captureId, $amount, $status = NULL) {
		return new Customweb_Payment_Authorization_DefaultTransactionCapture($captureId, $amount, $status);
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getAlias()
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * Sets the alias (overwrites existing alias wihtout check).
	 *
	 * @param string $alias
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function setAlias($alias) {
		$this->alias = $alias;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getAliasForDisplay()
	 */
	public function getAliasForDisplay() {
		return $this->aliasForDisplay;
	}

	/**
	 * Sets the alias for display (overwrites existing alias wihtout check).
	 *
	 * @param string $aliasForDisplay
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function setAliasForDisplay($aliasForDisplay) {
		$this->aliasForDisplay = $aliasForDisplay;
		return $this;
	}

	/**
	 * Returns the state of 3D secure for the transaction.
	 *
	 * @return STATE_3D_SECURE_NOT_APPLICABLE | STATE_3D_SECURE_FAILED | STATE_3D_SECURE_SUCCESS
	 */
	public function getState3DSecure(){
		return $this->state3DSecure;
	}

	/**
	 * Sets the state of 3D secure for the transaction.
	 *
	 * @param string $state STATE_3D_SECURE_NOT_APPLICABLE | STATE_3D_SECURE_FAILED | STATE_3D_SECURE_SUCCESS
	 */
	public function setState3DSecure($state){
		$this->state3DSecure = $state;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getPaymentCustomerContext()
	 */
	public function getPaymentCustomerContext() {
		return $this->paymentCustomerContext;
	}

	/**
	 * Sets the payment customer context.
	 *
	 * @param Customweb_Payment_Authorization_IPaymentCustomerContext $context
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function setPaymentCustomerContext(Customweb_Payment_Authorization_IPaymentCustomerContext $context) {
		$this->paymentCustomerContext = $context;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::isPaid()
	 */
	public function isPaid() {
		return $this->paid;
	}

	/**
	 * By invoking this method the transaction is marked as paid. The effect of
	 * this method is not invertable.
	 *
	 * @return Customweb_Payment_Authorization_DefaultTransaction
	 */
	public function setPaid() {
		$this->paid = true;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_ITransaction::getTransactionInformation()
	 */
	public function getTransactionLabels() {
		return array_merge(
			$this->getBasicLabels(),
			$this->getStateLabels(),
			$this->getAliasLabels(),
			$this->getTransactionSpecificLabels(),
			$this->getState3DSecureLabel()
		);
	}

	/**
	 * This method returns a list of labels which reflects some basic informations about
	 * the transactions. Such as the amount and currency.
	 */
	protected function getBasicLabels() {
		$labels = array();
		$labels['authorization_amount'] = array(
			'label' => Customweb_I18n_Translation::__('Authorization Amount'),
			'value' => $this->getAuthorizationAmount()
		);

		$labels['currency'] = array(
			'label' => Customweb_I18n_Translation::__('Currency'),
			'value' => $this->getCurrencyCode()
		);

		$labels['payment_method'] = array(
			'label' => Customweb_I18n_Translation::__('Payment Method'),
			'value' => $this->getPaymentMethod()->getPaymentMethodDisplayName()
		);

		$paymentId = $this->getPaymentId();
		if (!empty($paymentId)) {
			$labels['payment_id'] = array(
				'label' => Customweb_I18n_Translation::__('Payment ID'),
				'value' => $paymentId
			);
		}

		if ($this->getCapturedAmount() > 0) {
			$labels['captured_amount'] = array(
				'label' => Customweb_I18n_Translation::__('Captured Amount'),
				'value' => $this->getCapturedAmount()
			);
		}

		if ($this->getRefundedTotalAmount() > 0) {
			$labels['refunded_amount'] = array(
				'label' => Customweb_I18n_Translation::__('Refunded Amount'),
				'value' => $this->getRefundedTotalAmount()
			);
		}

		return $labels;
	}

	protected function getAliasLabels() {
		$labels = array();

		if ($this->getAliasForDisplay() !== null) {
			$labels['alias_for_display'] = array(
				'label' => Customweb_I18n_Translation::__('Alias'),
				'value' => $this->getAliasForDisplay(),
			);
		}

		return $labels;
	}

	/**
	 * This method is intended for overriding by a subclass. It provides
	 * the opportunity for the subclass to provide own labels.
	 *
	 * @return array(
	 * 	  array(
	 * 	     'label' => 'Translated label',
	 *       'value' => 'Value to display',
	 *    )
	 * )
	 */
	protected function getTransactionSpecificLabels() {
		return array();
	}

	/**
	 * This method returns a list of labes which refelcts the current
	 * state of this transaction.
	 *
	 */
	protected function getStateLabels() {
		$labels = array();

		if ($this->isAuthorizationFailed()) {
			$labels['failed_authorization'] = array(
				'label' => Customweb_I18n_Translation::__('Authorization Failed'),
				'value' => Customweb_I18n_Translation::__('Yes')
			);
		}
		else if ($this->isAuthorized()) {
			$labels['authorized'] = array(
				'label' => Customweb_I18n_Translation::__('Transaction Authorized'),
				'value' => Customweb_I18n_Translation::__('Yes')
			);

			$labels['uncertain'] = array(
				'label' => Customweb_I18n_Translation::__('Transaction Uncertain'),
				'description' => Customweb_I18n_Translation::__('A transaction may be uncertain, when the payment is not guaranteed. For example in case the credit card does not participate in the 3D procedure.'),
			);
			if ($this->isAuthorizationUncertain()) {
				$labels['uncertain']['value'] = Customweb_I18n_Translation::__('Yes');
			}
			else {
				$labels['uncertain']['value'] = Customweb_I18n_Translation::__('No');
			}

			if ($this->isCancelled()) {
				$labels['cancelled'] = array(
					'label' => Customweb_I18n_Translation::__('Transaction Cancelled'),
					'value' => Customweb_I18n_Translation::__('Yes')
				);
			}

			if ($this->isCaptured()) {
				$labels['captured'] = array(
					'label' => Customweb_I18n_Translation::__('Transaction Captured'),
					'value' => Customweb_I18n_Translation::__('Yes')
				);
			}

			if ($this->isPaid()) {
				$labels['paid'] = array(
						'label' => Customweb_I18n_Translation::__('Transaction Paid'),
						'value' => Customweb_I18n_Translation::__('Yes')
				);
			}
		}

		return $labels;
	}

	/**
	 * This method returns labels that reflect the state of the 3d secure process,
	 * if available.
	 *
	 * @return array
	 */
	protected function getState3DSecureLabel(){
		$labels = array();
		if($this->getState3DSecure() == self::STATE_3D_SECURE_FAILED){
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Failed')
			);
		}
		elseif($this->getState3DSecure() == self::STATE_3D_SECURE_SUCCESS){
			$labels['3DSecure'] = array(
					'label' => Customweb_I18n_Translation::__('3D Secure'),
					'value' => Customweb_I18n_Translation::__('Successful')
			);
		}
		return $labels;
	}

	public function getOrderStatus() {
		$method = $this->getPaymentMethod();

		$status = $method->getPaymentMethodConfigurationValue('status_authorized');
		if ($this->isCaptured()) {
			$capturedState = $method->getPaymentMethodConfigurationValue('status_captured');
			// 'none' check is backward compatibility
			if ($capturedState != 'no_status_change' && $capturedState != 'none') {
				$status = $capturedState;
			}
		}

		if ($this->isAuthorizationUncertain()) {
			$status = $method->getPaymentMethodConfigurationValue('status_uncertain');
		}

		if ($this->isCancelled()) {
			$cancelledStatus = $method->getPaymentMethodConfigurationValue('status_cancelled');
			if ($cancelledStatus != 'no_status_change' && $cancelledStatus != 'none') {
				$status = $cancelledStatus;
			}
		}

		$status = $this->getCustomOrderStatus($status);
		return $status;
	}

	/**
	 * This method can be used to define the order status on custom constraines in sub classes.
	 * For example if an order should be marked as paid in case of an invoice.
	 *
	 * @param mixed $status The current order status
	 * @return mixed The order status to use
	 */
	protected function getCustomOrderStatus($status) {
		return $status;
	}


}
