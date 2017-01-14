<?php

/**
 * Plugin Name: WooCommerce PostFinanceCw
 * Plugin URI: http://www.customweb.ch
 * Description: This plugin adds the PostFinanceCw payment gateway to your WooCommerce.
 * Version: 2.1.38
 * Author: customweb GmbH
 * Author URI: http://www.customweb.ch
 */

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

// Load Language Files
load_plugin_textdomain('woocommerce_postfinancecw', false, basename( dirname( __FILE__ ) ) . '/translations' );

require_once dirname( __FILE__ ) . '/lib/loader.php';
require_once 'PostFinanceCwUtil.php';

// Add translation Adapter
PostFinanceCwUtil::includeClass('TranslationResolver');

// Get all admin functionality
require_once PostFinanceCwUtil::getBasePath() . '/admin.php';

register_activation_hook( __FILE__, array('PostFinanceCwUtil', 'installPlugin'));
add_filter('woocommerce_payment_gateways', array('PostFinanceCwUtil', 'addPaymentMethods'));

if (!is_admin()) {
	function woocommerce_postfinancecw_add_frontend_css() {
		wp_register_style('woocommerce_postfinancecw_frontend_styles', plugins_url('assets/frontend.css', __FILE__));
		wp_enqueue_style('woocommerce_postfinancecw_frontend_styles');
		
		wp_register_script(
			'postfinancecw_frontend_script',
			plugins_url('assets/frontend.js', __FILE__),
			array('jquery')
		);
		wp_enqueue_script( 'postfinancecw_frontend_script' );
	}
	add_action('wp_enqueue_scripts', 'woocommerce_postfinancecw_add_frontend_css');
}

// Log Errors
function woocommerce_postfinancecw_add_errors() {
	if (isset($_GET['postfinancecw_failed_transaction_id'])) {
		global $woocommerce;
		PostFinanceCwUtil::includeClass('PostFinanceCw_Transaction');
		$dbTransaction = PostFinanceCw_Transaction::loadById($_GET['postfinancecw_failed_transaction_id']);
		$woocommerce->add_error(current($dbTransaction->getTransactionObject()->getErrorMessages()));
	}
	
}
add_action('init', 'woocommerce_postfinancecw_add_errors');

add_action('woocommerce_before_checkout_billing_form', array('PostFinanceCwUtil', 'actionBeforeCheckoutBillingForm'));
add_action('woocommerce_before_checkout_shipping_form', array('PostFinanceCwUtil', 'actionBeforeCheckoutShippingForm'));





add_action('wp_ajax_woocommerce_postfinancecw_update_payment_form', 'woocommerce_postfinancecw_ajax_update_payment_form');
add_action('wp_ajax_nopriv_woocommerce_postfinancecw_update_payment_form', 'woocommerce_postfinancecw_ajax_update_payment_form');

function woocommerce_postfinancecw_ajax_update_payment_form() {
	if (!isset($_POST['payment_method'])) {
		echo 'no payment method provided.';
		die();
	}
	$paymentMethod = PostFinanceCwUtil::getPaymentMehtodInstance($_POST['payment_method']);
	$paymentMethod->payment_fields();
	die();
}


