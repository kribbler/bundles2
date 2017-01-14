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

$dbTransaction = PostFinanceCw_Transaction::loadById(intval($_REQUEST['cw_transaction_id']));

$redirectionUrl = '';
if ($dbTransaction->getTransactionObject()->isAuthorizationFailed()) {
	$redirectionUrl = Customweb_Util_Url::appendParameters(
		$dbTransaction->getTransactionObject()->getTransactionContext()->getFailedUrl(),
		$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
	);
}
else if ($dbTransaction->getTransactionObject()->isAuthorized()) {
	$redirectionUrl = Customweb_Util_Url::appendParameters(
		$dbTransaction->getTransactionObject()->getTransactionContext()->getSuccessUrl(),
		$dbTransaction->getTransactionObject()->getTransactionContext()->getCustomParameters()
	);
}
else {
	die("Invalid transaction state (it must be either authorized or failed).");
}

$vars = array();
$vars['url'] = $redirectionUrl;
PostFinanceCwUtil::includeTemplateFile('iframe_break_out', $vars);

