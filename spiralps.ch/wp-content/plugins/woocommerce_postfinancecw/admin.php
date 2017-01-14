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

// Make sure we don't expose any info if called directly           	 		    			 
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}


// Add some CSS for admin           	 		    			 
if (is_admin()) {
	add_action( 'admin_init', 'woocommerce_postfinancecw_admin_add_scripts' );
	function woocommerce_postfinancecw_admin_add_scripts() {
		wp_register_style('woocommerce_postfinancecw_admin_styles', plugins_url('assets/admin.css', __FILE__) );
		wp_enqueue_style('woocommerce_postfinancecw_admin_styles');
		
		wp_register_script('woocommerce_postfinancecw_admin_js', plugins_url('assets/admin.js', __FILE__) );
		wp_enqueue_script('woocommerce_postfinancecw_admin_js');
		if (!session_id()) {
			session_start();
		}
	}
	
	function woocommerce_postfinancecw_admin_notice_handler() {
		if (isset($_SESSION['woocommerce_postfinancecw__messages']) && count($_SESSION['woocommerce_postfinancecw__messages']) > 0) {
			
			foreach ($_SESSION['woocommerce_postfinancecw__messages'] as $message) {
				$cssClass = '';
				if (strtolower($message['type']) == 'error') {
					$cssClass = 'error';
				}
				else if (strtolower($message['type']) == 'info') {
					$cssClass = 'updated';
				}
				
				echo '<div class="' . $cssClass . '">';
					echo '<p>PostFinance: ' . $message['message'] . '</p>';
				echo '</div>';
			}
			
			$_SESSION['woocommerce_postfinancecw__messages'] = array();
		}
	}
	add_action('admin_notices', 'woocommerce_postfinancecw_admin_notice_handler');
}

function woocommerce_postfinancecw_admin_show_message($message, $type) {
	if (!session_id()) {
		session_start();
	}
	
	if (!isset($_SESSION['woocommerce_postfinancecw__messages'])) {
		$_SESSION['woocommerce_postfinancecw__messages'] = array();
	}
	$_SESSION['woocommerce_postfinancecw__messages'][] = array(
		'message' => $message,
		'type' => $type,
	);
}


function woocommerce_postfinancecw_meta_boxes() {
	global $post;
	
	PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');
	$transactions = PostFinanceCw_Transaction::getTransactionsByOrderId($post->ID);
	if (count($transactions) > 0) {
		add_meta_box( 'woocommerce-postfinancecw-information', __('PostFinance Transactions', 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_transactions', 'shop_order', 'normal', 'default');
	}
}
add_action( 'add_meta_boxes', 'woocommerce_postfinancecw_meta_boxes' );

function woocommerce_postfinancecw_transactions($post) {

	PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');
	$transactions = PostFinanceCw_Transaction::getTransactionsByOrderId($post->ID);
	
	echo '<table class="wp-list-table widefat table postfinancecw-transaction-table">';
	echo '<thead><tr>';
		echo '<th>#</th>';
		echo '<th>' . __('Transaction Number', 'woocommerce_postfinancecw') . '</th>';
		echo '<th>' . __('Date', 'woocommerce_postfinancecw') . '</th>';
		echo '<th>' . __('Payment Method', 'woocommerce_postfinancecw') . '</th>';
		echo '<th>' . __('Is Authorized', 'woocommerce_postfinancecw') . '</th>';
		echo '<th>' . __('Amount', 'woocommerce_postfinancecw') . '</th>';
		echo '<th>&nbsp;</th>';
	echo '</tr></thead>';
	
	foreach ($transactions as $transaction) {
		echo '<tr class="postfinancecw-main-row"  id="postfinancecw-main_row_' . $transaction->getTransactionId() .'">';
			echo '<td>' . $transaction->getTransactionId() . '</td>';
			echo '<td>' . $transaction->getTransactionNumber() . '</td>';
			echo '<td>' . $transaction->getCreatedOn() . '</td>';
			echo '<td>';
				if ($transaction->getTransactionObject() != NULL) {
					echo $transaction->getTransactionObject()->getPaymentMethod()->getPaymentMethodDisplayName();
				}
				else {
					echo '--';
				}
			echo '</td>';
			echo '<td>';
				if ($transaction->getTransactionObject() != NULL && $transaction->getTransactionObject()->isAuthorized()) {
					echo __('Yes');
				}
				else {
					echo __('No');
				}
			echo '</td>';
			echo '<td>';
				if ($transaction->getTransactionObject() != NULL) {
					echo number_format($transaction->getTransactionObject()->getAuthorizationAmount(), 2);
				}
				else {
					echo '--';
				}
			echo '</td>';
			echo '<td>
				<a class="postfinancecw-more-details-button button">' . __('More Details', 'woocommerce_postfinancecw') . '</a>
				<a class="postfinancecw-less-details-button button">' . __('Less Details', 'woocommerce_postfinancecw') . '</a>
			</td>';
			echo '</tr>';
			echo '<tr class="postfinancecw-details-row" id="postfinancecw_details_row_' . $transaction->getTransactionId() .'">';
				echo '<td colspan="7">';
					echo '<div class="postfinancecw-box-labels">';
					if ($transaction->getTransactionObject() !== NULL) {
						foreach ($transaction->getTransactionObject()->getTransactionLabels() as $label) {
							echo '<div class="label-box">';
								echo '<div class="label-title">' . $label['label'] . ' ';
								if (isset($label['description']) && !empty($label['description'])) {
									echo woocommerce_postfinancecw_get_help_box(__($label['description'], 'woocommerce_postfinancecw'));
								}
								echo '</div>';
								echo '<div class="label-value">' . $label['value'] . '</div>';
							echo '</div>';
						}
					}
					else {
						echo __("No more details available.", 'woocommerce_postfinancecw');
					}
					echo '</div>';
			
					if ($transaction->getTransactionObject() !== NULL) {
							
						
						if ($transaction->getTransactionObject()->isCapturePossible()) {
							echo '<div class="capture-box box">';
							echo '<h4>' . __('Capture Transaction', 'woocommerce_postfinancecw') . '</h4>';
							echo '<p>' . __('Amount to capture', 'woocommerce_postfinancecw');
							if ($transaction->getTransactionObject()->isPartialCapturePossible()) {
								echo '<input type="text" size="5" name="capture_amount[' . $transaction->getTransactionId() . ']" value="' . round($transaction->getTransactionObject()->getCapturableAmount(), 2) . '" />';
								echo __('Maximal Capturable Amount', 'woocommerce_postfinancecw') . ':';
								echo round($transaction->getTransactionObject()->getCapturableAmount(), 2);
							} 
							else {
								echo round($transaction->getTransactionObject()->getCapturableAmount(), 2);
							}
							echo '</p>';
							echo '<p>';
							if ($transaction->getTransactionObject()->isCaptureClosable()) {
								echo '<input type="checkbox" name="close[' . $transaction->getTransactionId() . ']" value="1" id="close-captures-' . $transaction->getTransactionId() . '" />';
								echo '<label for="close-captures-' . $transaction->getTransactionId() . '">';
								echo __('Close transaction for further captures.', 'woocommerce_postfinancecw') . '</label>';
							}
							else {
								echo __('The capture will automatically close the transaction for further captures.', 'woocommerce_postfinancecw');
							}
							echo '</p>';
							echo '<p><input type="submit" class="button" name="submitPostFinanceCwCapture[' . $transaction->getTransactionId() . ']" value="' . __('Capture', 'woocommerce_postfinancecw') . '" />';
							
							if ($transaction->getTransactionObject()->isCancelPossible()) {
								echo '<input type="submit" class="button" name="submitPostFinanceCwCancel[' . $transaction->getTransactionId() . ']" value="' . __('Cancel Transaction', 'woocommerce_postfinancecw') . '" />';
							}
							echo '</p>';
							echo '</div>';
						}
						
						if (count($transaction->getTransactionObject()->getCaptures())) {
							echo '<div class="capture-history-box box">';
							echo '<h4>' . __('Captures', 'woocommerce_postfinancecw') . '</h4>';
							echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
							echo '<thead>';
							echo '<tr>';
							echo '<th>' . __('Date', 'woocommerce_postfinancecw') . '</th>';
							echo '<th>' . __('Amount', 'woocommerce_postfinancecw') . '</th>';
							echo '<th>' . __('Status', 'woocommerce_postfinancecw') . '</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
							foreach ($transaction->getTransactionObject()->getCaptures() as $capture) {
								echo '<tr>';
								echo '<td>' . $capture->getCaptureDate()->format("Y-m-d H:i:s") . '</td>';
								echo '<td>' . $capture->getAmount() . '</td>';
								echo '<td>' . $capture->getStatus() . '</td>';
								echo '</tr>';
							}
							echo '</tbody>';
							echo '</table>';
							echo '</div>';
						}
						
	
						
						
						if ($transaction->getTransactionObject()->isRefundPossible()) {
							echo '<div class="refund-box box">';
							echo '<h4>' . __('Refund Transaction', 'woocommerce_postfinancecw') . '</h4>';
							echo '<p>' . __('Amount to refund', 'woocommerce_postfinancecw') . ': ';
								if ($transaction->getTransactionObject()->isPartialRefundPossible()) {
									echo '<input type="text" size="5" name="refund_amount[' . $transaction->getTransactionId() . ']" value="' . round($transaction->getTransactionObject()->getRefundableAmount(), 2) . '" /> ';
									echo __('Maximal Refundable Amount', 'woocommerce_postfinancecw') . ': ';
									echo round($transaction->getTransactionObject()->getRefundableAmount(), 2);
								}
								else {
									echo round($transaction->getTransactionObject()->getRefundableAmount(), 2);
								}
							echo '</p>';
							echo '<p>';
							if ($transaction->getTransactionObject()->isRefundClosable()) {
								echo '<input type="checkbox" name="close[' . $transaction->getTransactionId() . ']" value="1" id="close-refunds-' . $transaction->getTransactionId() . '" />';
								echo '<label for="close-refunds-' . $transaction->getTransactionId() . '">';
								echo __('Close transaction for further refunds.', 'woocommerce_postfinancecw') . '</label>';
							}
							echo '</p>';
							echo '<p>';
								echo '<input type="submit" class="button" name="submitPostFinanceCwRefund[' . $transaction->getTransactionId() . ']" value="' . __('Refund', 'woocommerce_postfinancecw') . '" />';
							echo '</p>';
							echo '</div>';
						}					
						
						if (count($transaction->getTransactionObject()->getRefunds())) {
							echo '<div class="refund-history-box box">';
							echo '<h4>' . __('Refunds', 'woocommerce_postfinancecw') . '</h4>';
							echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
							echo '<thead>';
							echo '<tr>';
								echo '<th>' . __('Date', 'woocommerce_postfinancecw') . '</th>';
								echo '<th>' . __('Amount', 'woocommerce_postfinancecw') . '</th>';
								echo '<th>' . __('Status', 'woocommerce_postfinancecw') . '</th>';
							echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
							foreach ($transaction->getTransactionObject()->getRefunds() as $refund) {
								echo '<tr>';
								echo '<td>' . $refund->getRefundedDate()->format("Y-m-d H:i:s") . '</td>';
								echo '<td>' . $refund->getAmount() . '</td>';
								echo '<td>' . $refund->getStatus() . '</td>';
								echo '</tr>';
							}
							echo '</tbody>';
							echo '</table>';
							echo '</div>';
						}
						
						
						
						if (count($transaction->getTransactionObject()->getHistoryItems())) {
							echo '<div class="previous-actions box">';
								echo '<h4>' . __('Previous Actions',  'woocommerce_postfinancecw') . '</h4>';
								echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
								echo '<thead>';
									echo '<tr>';
										echo '<th>' . __('Date', 'woocommerce_postfinancecw') . '</th>';
										echo '<th>' . __('Action', 'woocommerce_postfinancecw') . '</th>';
										echo '<th>' . __('Message', 'woocommerce_postfinancecw') . '</th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
								foreach ($transaction->getTransactionObject()->getHistoryItems() as $historyItem) {
									echo '<tr>';
										echo '<td>' . $historyItem->getCreationDate()->format("Y-m-d H:i:s") . '</td>';
										echo '<td>' . $historyItem->getActionPerformed() . '</td>';
										echo '<td>' . $historyItem->getMessage() . '</td>';
									echo '</tr>';
								}
								echo '</tbody>';
								echo '</table>';
							echo '</div>';
						}
					}
				echo '</td>';
			echo '</tr>';
				
	}
	echo '</table>';
	
	
	if (class_exists('WC_Subscriptions_Order') && WC_Subscriptions_Order::order_contains_subscription($post->ID)) {
		echo '<div class="postfinancecw-renewal">';
		echo '<span>' . __('Subscriptions: Add Manual Renewal', 'woocommerce_postfinancecw') . '</span>';
		echo ' <input type="submit" class="button button-primary tips" 
			name="postfinancecw_manual_renewal" 
			value="' . __('Add manual renewal', 'woocommerce_postfinancecw') . '" 
			data-tip="' . __('A manual renewal debits the customer directly for this subscription. This by pass any time restriction of the automatic subscription plugin.', 'woocommerce_postfinancecw') . '" />';
		echo '</div>';
	}
	
	
}


function woocommerce_postfinancecw_get_help_box($text) {
		return '<img class="help_tip" data-tip="' . $text . '" src="' . PostFinanceCwUtil::getAssetsUrl('help.png') . '" height="16" width="16" />';
}


function woocommerce_postfinancecw_transactions_process($orderId, $post) {
	if ($post->post_type == 'shop_order') {
		global $postfinancecw_processing;
		try {
			
			if (isset($_POST['postfinancecw_manual_renewal']) && $postfinancecw_processing == NULL) {
				$postfinancecw_processing = true;
				
				$initialTransaction = PostFinanceCw_Transaction::getInitialTransactionByOrderId($orderId);
				if ($initialTransaction === NULL) {
					throw new Exception("This order has no initial transaction, hence no new renewal can be created.");
				}
				$order = $initialTransaction->getTransactionObject()->getTransactionContext()->getOrderContext()->getOrderObject();
				$userId = $order->customer_user;
				$subscriptionKey = WC_Subscriptions_Manager::get_subscription_key($orderId);
				WC_Subscriptions_Payment_Gateways::gateway_scheduled_subscription_payment($userId, $subscriptionKey);
				global $postfinancecw_recurring_process_failure;
				if ($postfinancecw_recurring_process_failure === NULL) {
					woocommerce_postfinancecw_admin_show_message(__("Successfully add a manual renewal payment.", 'woocommerce_postfinancecw'), 'info');
				}
				else {
					woocommerce_postfinancecw_admin_show_message($postfinancecw_recurring_process_failure, 'error');
				}
			}
			
			
			
			if (isset($_POST['submitPostFinanceCwRefund'])) {
				reset($_POST['submitPostFinanceCwRefund']);
				$transactionId = key($_POST['submitPostFinanceCwRefund']);
				$amount = null;
				if (isset($_POST['refund_amount'])) {
					$amount = $_POST['refund_amount'][$transactionId];
				}
			
				$close = false;
				if (isset($_POST['close'][$transactionId]) && $_POST['close'][$transactionId] == '1') {
					$close = true;
				}
				PostFinanceCwUtil::refundTransaction($transactionId, $amount, $close);
				woocommerce_postfinancecw_admin_show_message(__("Successfully add a new refund.", 'woocommerce_postfinancecw'), 'info');
			}
			
				
			
			if (isset($_POST['submitPostFinanceCwCancel'])) {
				reset($_POST['submitPostFinanceCwCancel']);
				$transactionId = key($_POST['submitPostFinanceCwCancel']);
				PostFinanceCwUtil::cancelTransaction($transactionId);
				woocommerce_postfinancecw_admin_show_message(__("Successfully cancel transaction.", 'woocommerce_postfinancecw'), 'info');
			}
			
				
			
			if (isset($_POST['submitPostFinanceCwCapture'])) {
				reset($_POST['submitPostFinanceCwCapture']);
				$transactionId = key($_POST['submitPostFinanceCwCapture']);
				$amount = null;
				if (isset($_POST['capture_amount'][$transactionId])) {
					$amount = $_POST['capture_amount'][$transactionId];
				}
			
				$close = false;
				if (isset($_POST['close'][$transactionId]) && $_POST['close'][$transactionId] == '1') {
					$close = true;
				}
				PostFinanceCwUtil::captureTransaction($transactionId, $amount, $close);
				woocommerce_postfinancecw_admin_show_message(__("Successfully add a new capture.", 'woocommerce_postfinancecw'), 'info');
			}
			
		} 
		catch(Exception $e) {
			woocommerce_postfinancecw_admin_show_message($e->getMessage(), 'error');
		}
	}
}
add_action( 'save_post', 'woocommerce_postfinancecw_transactions_process', 1, 2 );




/**
 * Add the configuration menu
 */
function woocommerce_postfinancecw_menu() {
	add_options_page('PostFinance Settings', __('PostFinance Settings', 'woocommerce_postfinancecw'), 'manage_options', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw_options');
}
add_action('admin_menu', 'woocommerce_postfinancecw_menu');


/**
 * Setup the configuration page with the callbacks to the configuration API.
 */
function woocommerce_postfinancecw_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
	echo '<div id="icon-options-general" class="icon32"><br /></div>';
	echo '<h2>' . __('PostFinance Settings', 'woocommerce_postfinancecw') . '</h2>';
	
	echo '<form method="post" action="options.php">';
	settings_fields('woocommerce-postfinancecw');
	do_settings_sections( 'woocommerce-postfinancecw' );
	
	echo '<p class="submit">';
		echo '<input type="submit" name="submit" id="submit" class="button-primary" value="' .  __('Save Changes') . '" />';
	echo '</p>';
	

	echo '</div>';
	
	
	PostFinanceCwUtil::includeClass('PostFinanceCw_ConfigurationAdapter');
	echo '<div class="wrap"><h3>' . __('PostFinance Information', 'woocommerce_postfinancecw') . '</h3>';
	$config = new PostFinanceCw_ConfigurationAdapter();
	echo '<p><div style="width:200px;padding:10px;float:left;">';
	echo 'Dynamic Template URL:</div><div style="padding:10px">'. $config->getDefaultTemplateUrl();
	echo '</div></p>';
	
	
	echo '</div>';
}


/**
 * Register Settings
 */
function woocommerce_postfinancecw_admin_init() {
	
	// Append order status for pending payments
	if (!term_exists('postfinancecw-pending', 'shop_order_status')) {
		wp_insert_term(
			'PostFinance Pending',
			'shop_order_status',
			array(
				'description'=> 'Orders with that order status are currently in the checkout of PostFinance.',
				'slug' => 'postfinancecw-pending',
			)
		);
	}
	// ##conditional(isFeatureUpdateActive)####
	add_settings_section('woocommerce_postfinancecw', 'PostFinance Basics', 'woocommerce_postfinancecw_section_callback', 'woocommerce-postfinancecw');
	add_settings_field('woocommerce_postfinancecw_operation_mode', __("Operation Mode", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_operation_mode', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_operation_mode');
	
	add_settings_field('woocommerce_postfinancecw_pspid', __("Live PSPID", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_pspid', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_pspid');
	
	add_settings_field('woocommerce_postfinancecw_test_pspid', __("Test PSPID", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_test_pspid', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_test_pspid');
	
	add_settings_field('woocommerce_postfinancecw_live_sha_passphrase_in', __("SHA-IN Passphrase", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_live_sha_passphrase_in', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_live_sha_passphrase_in');
	
	add_settings_field('woocommerce_postfinancecw_live_sha_passphrase_out', __("SHA-OUT Passphrase", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_live_sha_passphrase_out', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_live_sha_passphrase_out');
	
	add_settings_field('woocommerce_postfinancecw_test_sha_passphrase_in', __("Test Account SHA-IN Passphrase", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_test_sha_passphrase_in', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_test_sha_passphrase_in');
	
	add_settings_field('woocommerce_postfinancecw_test_sha_passphrase_out', __("Test Account SHA-OUT Passphrase", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_test_sha_passphrase_out', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_test_sha_passphrase_out');
	
	add_settings_field('woocommerce_postfinancecw_hash_method', __("Hash calculation method", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_hash_method', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_hash_method');
	
	add_settings_field('woocommerce_postfinancecw_alias_manager', __("Alias Manager", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_alias_manager', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_alias_manager');
	
	add_settings_field('woocommerce_postfinancecw_order_id_schema', __("Order prefix", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_order_id_schema', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_order_id_schema');
	
	add_settings_field('woocommerce_postfinancecw_template', __("Dynamic Template", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_template', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_template');
	
	add_settings_field('woocommerce_postfinancecw_template_url', __("Template URL for own template", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_template_url', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_template_url');
	
	add_settings_field('woocommerce_postfinancecw_shop_id', __("Shop ID", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_shop_id', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_shop_id');
	
	add_settings_field('woocommerce_postfinancecw_api_user_id', __("API Username", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_api_user_id', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_api_user_id');
	
	add_settings_field('woocommerce_postfinancecw_api_password', __("API Password", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_api_password', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_api_password');
	
	add_settings_field('woocommerce_postfinancecw_alias_usage_message', __("Intended purpose of alias", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_alias_usage_message', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_alias_usage_message');
	
	add_settings_field('woocommerce_postfinancecw_review_input_form', __("Review Input Form", 'woocommerce_postfinancecw'), 'woocommerce_postfinancecw_option_callback_review_input_form', 'woocommerce-postfinancecw', 'woocommerce_postfinancecw');
	register_setting('woocommerce-postfinancecw', 'woocommerce_postfinancecw_review_input_form');
	
	
}
add_action('admin_init', 'woocommerce_postfinancecw_admin_init');

function woocommerce_postfinancecw_section_callback() {
	echo '';
}

function woocommerce_postfinancecw_option_callback_operation_mode() {
	echo '<select name="woocommerce_postfinancecw_operation_mode">';
		echo '<option value="test"';
		 if (get_option('woocommerce_postfinancecw_operation_mode', "test") == "test"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Test Mode", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="live"';
		 if (get_option('woocommerce_postfinancecw_operation_mode', "test") == "live"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Live Mode", 'woocommerce_postfinancecw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("If the test mode is selected the test PSPID is used and the test SHA passphrases.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_pspid() {
	echo '<input type="text" name="woocommerce_postfinancecw_pspid" value="' . get_option('woocommerce_postfinancecw_pspid', "") . '" />';
	
	echo '<br />';
	echo __("The PSPID as given by the PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_test_pspid() {
	echo '<input type="text" name="woocommerce_postfinancecw_test_pspid" value="' . get_option('woocommerce_postfinancecw_test_pspid', "") . '" />';
	
	echo '<br />';
	echo __("The test PSPID as given by the PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_live_sha_passphrase_in() {
	echo '<input type="text" name="woocommerce_postfinancecw_live_sha_passphrase_in" value="' . get_option('woocommerce_postfinancecw_live_sha_passphrase_in', "") . '" />';
	
	echo '<br />';
	echo __("Enter the live SHA-IN passphrase. This value must be identical to the one in the back-end of PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_live_sha_passphrase_out() {
	echo '<input type="text" name="woocommerce_postfinancecw_live_sha_passphrase_out" value="' . get_option('woocommerce_postfinancecw_live_sha_passphrase_out', "") . '" />';
	
	echo '<br />';
	echo __("Enter the live SHA-OUT passphrase. This value must be identical to the one in the back-end of PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_test_sha_passphrase_in() {
	echo '<input type="text" name="woocommerce_postfinancecw_test_sha_passphrase_in" value="' . get_option('woocommerce_postfinancecw_test_sha_passphrase_in', "") . '" />';
	
	echo '<br />';
	echo __("Enter the test SHA-IN passphrase. This value must be identical to the one in the back-end of PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_test_sha_passphrase_out() {
	echo '<input type="text" name="woocommerce_postfinancecw_test_sha_passphrase_out" value="' . get_option('woocommerce_postfinancecw_test_sha_passphrase_out', "") . '" />';
	
	echo '<br />';
	echo __("Enter the test SHA-OUT passphrase. This value must be identical to the one in the back-end of PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_hash_method() {
	echo '<select name="woocommerce_postfinancecw_hash_method">';
		echo '<option value="sha1"';
		 if (get_option('woocommerce_postfinancecw_hash_method', "sha512") == "sha1"){
			echo ' selected="selected" ';
		}
	echo '>' . __("SHA-1", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="sha256"';
		 if (get_option('woocommerce_postfinancecw_hash_method', "sha512") == "sha256"){
			echo ' selected="selected" ';
		}
	echo '>' . __("SHA-256", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="sha512"';
		 if (get_option('woocommerce_postfinancecw_hash_method', "sha512") == "sha512"){
			echo ' selected="selected" ';
		}
	echo '>' . __("SHA-512", 'woocommerce_postfinancecw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Select the hash calculation method to use. This value must correspond with the selected value in the back-end of PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_alias_manager() {
	echo '<select name="woocommerce_postfinancecw_alias_manager">';
		echo '<option value="active"';
		 if (get_option('woocommerce_postfinancecw_alias_manager', "inactive") == "active"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Active", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="inactive"';
		 if (get_option('woocommerce_postfinancecw_alias_manager', "inactive") == "inactive"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Inactive", 'woocommerce_postfinancecw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("The alias manager allows the customer to select from a credit card previously stored. The credit card data is stored by PostFinance.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_order_id_schema() {
	echo '<input type="text" name="woocommerce_postfinancecw_order_id_schema" value="' . get_option('woocommerce_postfinancecw_order_id_schema', "order_{id}") . '" />';
	
	echo '<br />';
	echo __("Here you can insert an order prefix. The prefix allows you to change the order number that is transmitted to PostFinance . The prefix must contain the tag {id}. It will then be replaced by the order number (e.g. name_{id}).", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_template() {
	echo '<select name="woocommerce_postfinancecw_template">';
		echo '<option value="default"';
		 if (get_option('woocommerce_postfinancecw_template', "default") == "default"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Use shop template", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="custom"';
		 if (get_option('woocommerce_postfinancecw_template', "default") == "custom"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Use own template", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="none"';
		 if (get_option('woocommerce_postfinancecw_template', "default") == "none"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Don't change the layout of the payment page", 'woocommerce_postfinancecw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("With the Dynamic Template you can design the layout of the payment page yourself. For the option 'Own template' the URL to the template file must be entered into the following box.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_template_url() {
	echo '<input type="text" name="woocommerce_postfinancecw_template_url" value="' . get_option('woocommerce_postfinancecw_template_url', "") . '" />';
	
	echo '<br />';
	echo __("The URL indicated here is rendered as Template. For this you must select option 'Use own template'. The URL must point to an HTML page that contains the string '\$\$\$PAYMENT ZONE\$\$\$'. This part of the HTML file is replaced with the form for the credit card input.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_shop_id() {
	echo '<input type="text" name="woocommerce_postfinancecw_shop_id" value="' . get_option('woocommerce_postfinancecw_shop_id', "") . '" />';
	
	echo '<br />';
	echo __("Here you can define a Shop ID. This is only necessary if you wish to operate several shops with one PSPID. In order to use this module, an additional module is required.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_api_user_id() {
	echo '<input type="text" name="woocommerce_postfinancecw_api_user_id" value="' . get_option('woocommerce_postfinancecw_api_user_id', "") . '" />';
	
	echo '<br />';
	echo __("You can create an API username in the back-end of PostFinance . The API user is necessary for the direct communication between the shop and the service of PostFinance .", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_api_password() {
	echo '<input type="text" name="woocommerce_postfinancecw_api_password" value="' . get_option('woocommerce_postfinancecw_api_password', "") . '" />';
	
	echo '<br />';
	echo __("Password for the API user.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_alias_usage_message() {
	echo '<textarea name="woocommerce_postfinancecw_alias_usage_message">' . get_option('woocommerce_postfinancecw_alias_usage_message', "") . '</textarea>';
	
	echo '<br />';
	echo __("If the Alias Manager is used, the intended purpose is shown to the customer on the payment page. Through this the customer knows why his data is saved.", 'woocommerce_postfinancecw');
}

function woocommerce_postfinancecw_option_callback_review_input_form() {
	echo '<select name="woocommerce_postfinancecw_review_input_form">';
		echo '<option value="active"';
		 if (get_option('woocommerce_postfinancecw_review_input_form', "active") == "active"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Activate input form in review pane.", 'woocommerce_postfinancecw'). '</option>';
	echo '<option value="deactivate"';
		 if (get_option('woocommerce_postfinancecw_review_input_form', "active") == "deactivate"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Deactivate input form in review pane.", 'woocommerce_postfinancecw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Should the input form for credit card data rendered in the review pane? To work the user must have JavaScript activated. In case the browser does not support JavaScript a fallback is provided. This feature is not supported by all payment methods.", 'woocommerce_postfinancecw');
}




