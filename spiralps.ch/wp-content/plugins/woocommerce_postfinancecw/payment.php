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

$base_dir = dirname(dirname(dirname(dirname(__FILE__))));

require_once $base_dir . '/wp-load.php';
PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');

if (isset($GLOBALS['woocommerce'])) {
	$GLOBALS['woocommerce']->frontend_scripts();
}

$aliasTransactionId = NULL;
$failedTransactionId = NULL;
if (isset($_REQUEST['cw_transaction_id'])) {
	$failedTransactionId = $_REQUEST['cw_transaction_id'];
	$failedTransaction = PostFinanceCw_Transaction::loadById($failedTransactionId);
	if (!$failedTransaction->getTransactionObject()->isAuthorizationFailed()) {
		header('Location: ' . get_permalink(get_option('woocommerce_checkout_page_id')));
		die("Invalid transaction state.");
	}
	$orderId = $failedTransaction->getOrderId();
	$paymentMethodClass = $failedTransaction->getPaymentClassName();
	
}
else {
	if (!isset($_REQUEST['order_id'])) {
		die("No order_id provided.");
	}
	$orderId = $_REQUEST['order_id'];
	
	if (!isset($_REQUEST['payment_method_class'])) {
		die("No payment_method_class provided.");
	}
	$paymentMethodClass = $_REQUEST['payment_method_class'];
	
	if (!isset($_REQUEST['alias_transaction_id'])) {
		$aliasTransactionId = $_REQUEST['alias_transaction_id'];
	}
}

$paymentMethod = PostFinanceCwUtil::getPaymentMehtodInstance(strip_tags($paymentMethodClass));
$vars = array();

ob_start();
$response = $paymentMethod->getPaymentForm($orderId, $aliasTransactionId, $failedTransactionId, false);
$vars['form'] = ob_get_contents();
ob_end_clean();

if (is_array($response) && isset($response['redirect'])) {
	header('Location: ' . $response['redirect']);
	die();
}

PostFinanceCwUtil::includeTemplateFile('payment', $vars);
