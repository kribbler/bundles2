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


if (!isset($_REQUEST['cw_transaction_id'])) {
	die("No transaction_id provided.");
}

if (!isset($_REQUEST['payment_method_class'])) {
	die("No payment_method_class provided.");
}

$paymentMethod = PostFinanceCwUtil::getPaymentMehtodInstance(strip_tags($_REQUEST['payment_method_class']));
$dbTransaction = PostFinanceCw_Transaction::loadById(intval($_REQUEST['cw_transaction_id']));
$adapter = $paymentMethod->getAdapterFactory()->getAdapterByAuthorizationMethod($dbTransaction->getTransactionObject()->getAuthorizationMethod());
$variables = $adapter->getCheckoutFormVaiables($dbTransaction , null);

if (!isset($variables['template_file'])) {
	die("The authorization adapter has to provide the template file to use for the authorization.");
}

ob_start();
PostFinanceCwUtil::includeTemplateFile($variables['template_file'], $vars);
$vars['form'] = ob_get_contents();
ob_end_clean();

PostFinanceCwUtil::includeTemplateFile('payment', $vars);
