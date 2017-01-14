<?php
/*
Plugin Name:    Jigoshop Authorize.net PRO Gateway
Plugin URI:     https://www.jigoshop.com/product/authorize-net-pro/
Description:    Extends Jigoshop with an <a href="https://www.authorize.net" target="_blank">Authorize.net</a>  gateway. An Authorize.net Merchant account -is- required. Although not required, a server with SSL support and an SSL certificate is needed for security reasons for full PCI compliance and the Authorize.net AIM integration method will be used if the Jigoshop SSL setting is enabled.  Without Jigoshop SSL enabled, then the Authorize.net SIM or DPM integration methods can be used used to ensure maximum PCI complicance for those servers without SSL.
Version:        1.2.1
Author:         Jigoshop
Author URI:     http://www.jigoshop.com
*/

// Define required version of Jigoshop
if (!defined('JIGOSHOP_AUTHORIZE_PRO_REQUIRED_VERSION')) {
	define('JIGOSHOP_AUTHORIZE_PRO_REQUIRED_VERSION', '1.9.6');
}
// Define plugin name
if (!defined('JIGOSHOP_AUTHORIZE_PRO_NAME')) {
	define('JIGOSHOP_AUTHORIZE_PRO_NAME', 'Jigoshop Authorize Pro Gateway');
}
// Define plugin directory for inclusions
if (!defined('JIGOSHOP_AUTHORIZE_PRO_DIR')) {
	define('JIGOSHOP_AUTHORIZE_PRO_DIR', dirname(__FILE__));
}
// Define plugin URL for assets
if (!defined('JIGOSHOP_AUTHORIZE_PRO_URL')) {
	define('JIGOSHOP_AUTHORIZE_PRO_URL', plugins_url('', __FILE__));
}
// Define required version of Jigoshop
if (!defined('JIGOSHOP_AUTHORIZE_PRO_GATEWAY_REQUIRED_VERSION')) {
	define('JIGOSHOP_AUTHORIZE_PRO_GATEWAY_REQUIRED_VERSION', '1.9.6');
}

function jigoshop_authorize_pro_required_version_notice()
{
	echo '<div class="error"><p>';
	printf(__('Your Jigoshop version is not compatible. Your version of Jigoshop is: %s and %s requires al least: %s'), jigoshop::jigoshop_version(), JIGOSHOP_AUTHORIZE_PRO_NAME, JIGOSHOP_AUTHORIZE_PRO_REQUIRED_VERSION);
	echo '</p></div>';
}

add_action('plugins_loaded', 'init_authorize_pro_gateway');
function init_authorize_pro_gateway()
{
	if (!class_exists('jigoshop')) {
		return;
	}

	if (version_compare(jigoshop::jigoshop_version(), JIGOSHOP_AUTHORIZE_PRO_REQUIRED_VERSION, '<')) {
		add_action('admin_notices', 'jigoshop_authorize_pro_required_version_notice');

		return;
	}

	$licence = new jigoshop_licence_validator(__FILE__, '19967', 'http://www.jigoshop.com');
	if (!$licence->is_licence_active()) {
		return;
	}

	add_filter('jigoshop_payment_gateways', function ($methods){
		$methods[] = '\\Jigoshop\\Gateway\\AuthorizePro';

		return $methods;
	});

	// load our text domains first for translations (constructor is called on the 'init' action hook)
	load_textdomain('jigoshop-authorize-pro', WP_LANG_DIR.'/jigoshop-authorize-pro/jigoshop-authorize-pro-'.get_locale().'.mo');
	load_plugin_textdomain('jigoshop-authorize-pro', false, JIGOSHOP_AUTHORIZE_PRO_DIR.'/languages/');
	require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/src/Jigoshop/Gateway/AuthorizePro.php');
}
