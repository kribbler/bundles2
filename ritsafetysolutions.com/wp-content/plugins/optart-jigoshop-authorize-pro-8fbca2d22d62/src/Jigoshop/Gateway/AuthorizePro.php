<?php

namespace Jigoshop\Gateway;

require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/src/Jigoshop/Gateway/AuthorizePro/DTIAuthorizePROException.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_SIM_Form.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_Response.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_SIM_Response.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_AIM_Response.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_Request.php');
require_once(JIGOSHOP_AUTHORIZE_PRO_DIR.'/vendor/DTI_ANet_AIM_Request.php');

class AuthorizePro extends \jigoshop_payment_gateway
{
	private $merchant_countries = array('US', 'CA', 'GB');
	private $allowed_currency = array('USD', 'CAD', 'GBP');

	public function __construct()
	{
		parent::__construct();

		$options = \Jigoshop_Base::get_options();

		// and initialize all our variables based on settings here
		$this->id = 'authorize_pro';
		$this->icon = JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/authorize_logo.png';
		$this->has_fields = false;

		$this->enabled = $options->get_option('jigoshop_authorize_enabled');
		$this->title = $options->get_option('jigoshop_authorize_title');
		$this->description = $options->get_option('jigoshop_authorize_description');
		$this->apilogin = $options->get_option('jigoshop_authorize_apilogin');
		$this->transkey = $options->get_option('jigoshop_authorize_transkey');
		$this->md5hash = $options->get_option('jigoshop_authorize_md5hash');
		$this->testmode = $options->get_option('jigoshop_authorize_testmode');
		$this->transtype = $options->get_option('jigoshop_authorize_transtype');
		$this->cardtypes = $options->get_option('jigoshop_authorize_cardtypes');
		$this->email_receipt = $options->get_option('jigoshop_authorize_email_receipt') == 'yes';
		$this->certificate = $options->get_option('jigoshop_authorize_certificate');
		$this->debuglog = $options->get_option('jigoshop_authorize_debugon');
		$this->emaillogs = $options->get_option('jigoshop_authorize_receive_log_emails');
		$this->emailaddress = ($options->get_option('jigoshop_authorize_logs_emailto') == '')
			? $options->get_option('jigoshop_email')
			: $options->get_option('jigoshop_authorize_logs_emailto');

		// strip out the state if there is one and get the Shop country code
		$this->shop_base_country = (
			strpos($options->get_option('jigoshop_default_country'), ':') !== false)
			? substr($options->get_option('jigoshop_default_country'), 0,
				strpos($options->get_option('jigoshop_default_country'), ':'))
			: $options->get_option('jigoshop_default_country');

		$this->currency = $options->get_option('jigoshop_currency');

		// determine the authorize server to use
		$this->server_url = ($this->testmode == 'no') ? \DTI_ANet_AIM_Request::LIVE_URL : \DTI_ANet_AIM_Request::SANDBOX_URL;

		// set this for AIM, for now
		define('DTI_AUTHORIZENET_SANDBOX', $this->testmode == 'yes');
		define('DTI_AUTHORIZENET_LOG_FILE', $this->debuglog == 'on' ? JIGOSHOP_AUTHORIZE_PRO_DIR.'/log/authorize_pro_debug.log' : false);

		$this->connect_method = $options->get_option('jigoshop_authorize_connect_method');
		$this->sim_enabled = $options->get_option('jigoshop_authorize_connect_method') == 'sim';
		$this->dpm_enabled = $options->get_option('jigoshop_authorize_connect_method') == 'dpm';
		$this->aim_enabled = $options->get_option('jigoshop_force_ssl_checkout') == 'yes'
			|| $options->get_option('jigoshop_authorize_connect_method') == 'aim';

		// SIM connection methods will use the 'pay' page, hook it up
		if ($this->sim_enabled) {
			add_action('receipt_authorize_pro', array($this, 'receiptPage'));
		}

		add_action('init', array($this, 'checkResponse'), 99);
		add_action('admin_notices', array($this, 'notices'));
		add_action('wp_enqueue_scripts', array($this, 'frontAssets'));
	}

	public function frontAssets()
	{
		jigoshop_add_script('jigoshop_authorize_pro', JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/js/script.js', array('jquery'), array('page' => JIGOSHOP_CHECKOUT));
	}

	/**
	 *  Default Option settings for WordPress Settings API using the Jigoshop_Options class
	 *  These will be installed on the Jigoshop_Options 'Payment Gateways' tab by the parent class 'jigoshop_payment_gateway'
	 */
	protected function get_default_options()
	{
		$defaults = array();

		// Define the Section name for the Jigoshop_Options
		$defaults[] = array(
			'name' => sprintf(__('Authorize.net PRO %s', 'jigoshop-authorize-pro'), '<img style="vertical-align:middle;margin-top:-4px;margin-left:10px;" src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/authorize_logo.png" alt="Authorize.net">'),
			'type' => 'title',
			'desc' => __('Authorize.net PRO allows merchants to accept credit card payments on their Shop securely using a variety of connection methods to your Authorize.net Merchant account.  With the Jigoshop SSL setting enabled, the most secure and PCI compliant AIM integration is used, but an SSL installation is required on your server.  Otherwise the SIM and DPM methods are used to still ensure maximim PCI compliance.  SIM will redirect the user to the Authorize.net SSL secured servers to enter Credit Card information.  DPM will post credit card information directly from the customer to the secured Authorize servers bypassing the Shop server.', 'jigoshop-authorize-pro')
		);

		// List each option in order of appearance with details
		$defaults[] = array(
			'name' => __('Enable Authorize.net PRO', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => '',
			'id' => 'jigoshop_authorize_enabled',
			'std' => 'no',
			'type' => 'checkbox',
			'choices' => array(
				'no' => __('No', 'jigoshop-authorize-pro'),
				'yes' => __('Yes', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Method Title', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('This controls the title which the user sees during checkout and also appears as the Payment Method on final Orders.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_title',
			'std' => __('Credit Card via Authorize.net', 'jigoshop-authorize-pro'),
			'type' => 'text'
		);

		$defaults[] = array(
			'name' => __('Description', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('This controls the description which the user sees during checkout.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_description',
			'std' => __('Pay securely using your credit card with Authorize.net.  (Your Billing Address above must match that used on your Credit Card)', 'jigoshop-authorize-pro'),
			'type' => 'textarea'
		);

		$defaults[] = array(
			'name' => __('Use Test Server', 'jigoshop-authorize-pro'),
			'desc' => __('Requires a <a href="https://developer.authorize.net/testaccount/">developer account</a> on the Authorize.net testing servers.', 'dti-autorize-pro'),
			'tip' => __('Transactions are sent to the Authorize.net testing server which require <strong>different</strong> <em>API Login ID\'s</em> and <em>Transaction Key\'s</em> than an actual Merchant account.  Turn this off or disable it to go LIVE and use the production servers.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_testmode',
			'std' => 'no',
			'type' => 'checkbox',
			'choices' => array(
				'no' => __('No', 'jigoshop-authorize-pro'),
				'yes' => __('Yes', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Connection Method', 'jigoshop-authorize-pro'),
			'desc' => __('If the Jigoshop General tab setting has SSL enabled, AIM will <strong>always</strong> be used.', 'jigoshop-authorize-pro'),
			'tip' => __('<strong>SIM</strong> - No SSL required, transfers customer to Authorize.net secured SSL servers to accept credit card Information.<br><strong>DPM</strong> - No SSL required.  Uses unique transaction "fingerprint" for security.  Customers stay on your Server, but credit card info is sent directly from the customer to the secured Authorize servers.<br><strong>AIM</strong> - SSL IS required, maximum security and full PCI compliance.  Customers stay on your Server.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_connect_method',
			'std' => 'sim',
			'type' => 'radio',
			'choices' => array(
				'sim' => __('Server Integration Method (SIM)', 'jigoshop-authorize-pro'),
				'dpm' => __('Direct Post Method (DPM)', 'jigoshop-authorize-pro'),
				'aim' => __('Advanced Integration Method (AIM)', 'jigoshop-authorize-pro')
			),
			'extra' => array('vertical')
		);

		$defaults[] = array(
			'name' => __('Merchant API Login ID', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('This is your Authorize.net API Login ID supplied by Authorize.net and available from within your Merchant Account.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_apilogin',
			'std' => '',
			'type' => 'text'
		);

		$defaults[] = array(
			'name' => __('Transaction Key', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('This is the Transaction Key supplied by Authorize.net and available within your Merchant Account.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_transkey',
			'std' => '',
			'type' => 'text'
		);

		$defaults[] = array(
			'name' => __('MD5 Hash', 'jigoshop-authorize-pro'),
			'desc' => __('Optional - not used if using SSL and AIM.', 'jigoshop-authorize-pro'),
			'tip' => __('This is the optional MD5 Hash you may have entered on your Authorize.net Merchant Account for additional security with DPM and SIM transactions.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_md5hash',
			'std' => '',
			'type' => 'text'
		);

		$defaults[] = array(
			'name' => __('Transaction Type', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('<em>Authorize Only</em> will <strong>not</strong> actually capture funds for the Order, only Authorize the credit card for the amount.  You will have to manually capture the funds via your Merchant account when ready to do so.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_transtype',
			'std' => 'capture',
			'type' => 'radio',
			'choices' => array(
				'capture' => __('Authorize and Capture', 'jigoshop-authorize-pro'),
				'authorize' => __('Authorize Only', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Credit Card Types Accepted', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('Select which credit card types to accept and display logos for on the Checkout.  These should match the settings within your Authorize.net Merchant account.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_cardtypes',
			'type' => 'multicheck',
			'std' => array('amex' => '', 'diners' => '', 'discover' => '', 'jcb' => '', 'mastercard' => '1', 'visa' => '1'),
			'choices' => array(
				'amex' => __('American Express', 'jigoshop-authorize-pro'),
				'diners' => __('Diners Club', 'jigoshop-authorize-pro'),
				'discover' => __('Discover', 'jigoshop-authorize-pro'),
				'jcb' => __('JCB', 'jigoshop-authorize-pro'),
				'mastercard' => __('MasterCard', 'jigoshop-authorize-pro'),
				'visa' => __('Visa', 'jigoshop-authorize-pro')
			),
			'extra' => array('vertical')
		);

		$defaults[] = array(
			'name' => __('Email Authorize.net Receipt', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('In addition to Jigoshop emails, allow Authorize.net to also email successful payment receipts to customers.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_email_receipt',
			'std' => 'no',
			'type' => 'checkbox',
			'choices' => array(
				'no' => __('No', 'jigoshop-authorize-pro'),
				'yes' => __('Yes', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Debug Logging', 'jigoshop-authorize-pro'),
			'desc' => '',
			'tip' => __('Transactions between the Shop and Authorize.net are logged into a file here: <em>wp-content/plugins/jigoshop-authorize-net-pro/log/authorize_pro_debug.log</em>.  This file must have server write permissions.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_debugon',
			'std' => 'off',
			'type' => 'radio',
			'choices' => array(
				'off' => __('Off', 'jigoshop-authorize-pro'),
				'on' => __('On', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Receive Error Log Emails?', 'jigoshop'),
			'desc' => '',
			'tip' => __('Do you want to receive emails for the error logs if a problem occurs during a transaction?', 'jigoshop'),
			'id' => 'jigoshop_authorize_receive_log_emails',
			'std' => 'yes',
			'type' => 'checkbox',
			'choices' => array(
				'no' => __('No', 'jigoshop-authorize-pro'),
				'yes' => __('Yes', 'jigoshop-authorize-pro')
			)
		);

		$defaults[] = array(
			'name' => __('Email Error Logs to:', 'jigoshop'),
			'desc' => '',
			'tip' => __('Email address you want to use to send error logs to. If email field is empty, the Jigoshop email address will be used.', 'jigoshop-authorize-pro'),
			'id' => 'jigoshop_authorize_logs_emailto',
			'std' => '',
			'type' => 'email'
		);

		// the 'codeblock' option type is only available in Jigoshop 1.8 onwards
			$defaults[] = array(
				'name' => __('SSL Certification', 'jigoshop-authorize-pro'),
				'desc' => __('Leave blank to display nothing if you want to display it elsewhere on the site or you are not using SSL and AIM.<br />Available HTML tags are: ', 'jigoshop-authorize-pro')."'a', 'img', 'script', 'abbr', 'acronym', 'b', 'blockquote', 'cite', 'code', 'del', 'em', 'i', 'q', 'strike', 'strong'",
				'tip' => __('Use limited HTML markup for links, images and javascript code to display your site\'s SSL certification image.', 'jigoshop-authorize-pro'),
				'id' => 'jigoshop_authorize_certificate',
				'std' => '',
				'type' => 'codeblock'
			);

		return $defaults;
	}

	/**
	 *  Admin Notices for conditions under which Authorize.net PRO is available on a Shop
	 */
	public function notices()
	{
		$options = \Jigoshop_Base::get_options();

		if ($this->enabled == 'no') {
			return;
		}

		if (!$this->aim_enabled && $this->connect_method == 'aim') {
			echo '<div class="error"><p>'.__('The Authorize.net PRO gateway cannot use the AIM connection method without Jigoshop SSL enabled.  Please enable SSL to use this connection method.  The connection method has been <strong>reset back to SIM</strong> in the gateway settings.', 'jigoshop-authorize-pro').'</p></div>';
			$options->set_option('jigoshop_authorize_connect_method', 'sim');
		}

		if ($this->aim_enabled && !($this->connect_method == 'aim')) {
			echo '<div class="error"><p>'.__('The Authorize.net PRO gateway will <strong>always</strong> use the AIM connection method if the Jigoshop settings for SSL are enabled.  The connection method has been <strong>reset back to AIM</strong> in the gateway settings.  If you don\'t want this you must disable Jigoshop\'s SSL setting on the General Tab.', 'jigoshop-authorize-pro').'</p></div>';
			$options->set_option('jigoshop_authorize_connect_method', 'aim');
		}

		if (!in_array($this->currency, $this->allowed_currency)) {
			echo '<div class="error"><p>'.sprintf(__('The Authorize.net PRO gateway accepts payments in currencies of %s.  Your current currency is %s.  Authorize.net PRO won\'t work until you change the Jigoshop currency to an accepted one.  Authorize.net PRO is <strong>currently disabled</strong> on the Payment Gateways settings tab.', 'jigoshop-authorize-pro'), implode(', ', $this->allowed_currency), $this->currency).'</p></div>';
			$options->set_option('jigoshop_authorize_enabled', 'no');
		}

		if (!in_array($this->shop_base_country, $this->merchant_countries)) {
			$country_list = array();
			foreach ($this->merchant_countries as $this_country) {
				$country_list[] = \jigoshop_countries::get_country($this_country);
			}
			echo '<div class="error"><p>'.sprintf(__('The Authorize.net PRO gateway is available to merchants from: %s.  Your country is: %s.  Authorize.net PRO won\'t work until you change the Jigoshop Shop Base country to an accepted one.  Authorize.net PRO is <strong>currently disabled</strong> on the Payment Gateways settings tab.', 'jigoshop-authorize-pro'), implode(', ', $country_list), \jigoshop_countries::get_country($this->shop_base_country)).'</p></div>';
			$options->set_option('jigoshop_authorize_enabled', 'no');
		}

		if ((!$this->apilogin || !$this->transkey) && $this->enabled == 'yes') {
			echo '<div class="error"><p>'.__('The Authorize.net PRO gateway does not have values entered for the required fields for either Merchant API Login ID or Transaction Key and the gateway is set to enabled.  Please enter your credentials for these fields or the gateway <strong>will not</strong> be available on the Checkout.  Disable the gateway to remove this warning.', 'jigoshop-authorize-pro').'</p></div>';
		}

		if (!$this->hasCards() && $this->enabled == 'yes') {
			echo '<div class="error"><p>'.__('The Authorize.net PRO gateway does not have any Credit Card Types enabled.  Please enable the Credit Cards your Authorize.net Merchant account is set up to process or the gateway <strong>will not</strong> be available on the Checkout.  Disable the gateway to remove this warning.', 'jigoshop-authorize-pro').'</p></div>';
		}
	}

	/**
	 *  Determine conditions for which Authorize.net PRO is available on the Shop Checkout
	 */
	public function is_available()
	{
		if ($this->enabled == 'no') {
			return false;
		}

		if (!in_array($this->currency, $this->allowed_currency)) {
			return false;
		}

		if (!in_array($this->shop_base_country, $this->merchant_countries)) {
			return false;
		}

		if (!$this->apilogin || !$this->transkey) {
			return false;
		}

		if (!$this->hasCards()) {
			return false;
		}

		return true;
	}

	/**
	 *  Determine if there are Credit Card types available from Settings
	 */
	private function hasCards()
	{
		$result = false;
		foreach ($this->cardtypes as $value) {
			if ($value == '1') {
				$result = true;
				break;
			}
		}

		return $result;
	}

	/**
	 *  Determine connection method, process the payment and handle results
	 */
	public function process_payment($order_id)
	{
		if ($this->aim_enabled) {
			return $this->processAimPayment($order_id);
		} elseif ($this->dpm_enabled) {
			return $this->processDpmPayment($order_id);
		} else {
			$order = new \jigoshop_order($order_id);
			$args = array(
				'order' => $order->id,
				'key' => $order->order_key,
			);

			return array(
				'result' => 'success',
				'redirect' => add_query_arg($args, get_permalink(jigoshop_get_page_id('pay')))
			);
		}
	}

	/**
	 *  Only used for SIM connection methods, uses the 'pay' page, called from action hook
	 */
	public function receiptPage($order_id)
	{
		echo '<p>'.__('Thank you for your order, please click the button below to pay with Authorize.net.', 'jigoshop-authorize-pro').'</p>';
		$this->processSimPayment($order_id);
	}

	/**
	 *  prefill form fields for use with both SIM and DPM
	 */
	private function getFormFields($order_id)
	{
		$order = new \jigoshop_order($order_id);
		$time = time();
		$fingerprint = \DTI_ANet_SIM_Form::getFingerprint($this->apilogin, $this->transkey, $order->order_total, $order->id, $time);
		$transtype = $this->transtype == 'capture' ? 'AUTH_CAPTURE' : 'AUTH_ONLY';

		$form_fields = new \DTI_ANet_SIM_Form(array(
			'x_type' => $transtype,
			'x_amount' => $order->order_total,
			'x_freight' => $order->order_shipping,
			'x_tax' => $order->get_total_tax(false, false),
			'x_login' => $this->apilogin,
			'x_fp_hash' => $fingerprint,
			'x_fp_sequence' => $order->id,
			'x_fp_timestamp' => $time,
			'x_delim_data' => 'false',
			'x_relay_response' => 'true',
			'x_relay_always' => 'true',
			'x_relay_url' => trailingslashit(get_bloginfo('url')),
			'x_cancel_url' => get_permalink(jigoshop_get_page_id('cart')),
			'x_receipt_link_ method' => 'POST',
			'x_method' => 'CC',
			'x_first_name' => $order->billing_first_name,
			'x_last_name' => $order->billing_last_name,
			'x_company' => $order->billing_company,
			'x_address' => $order->billing_address_1.' '.$order->billing_address_2,
			'x_city' => $order->billing_city,
			'x_state' => $order->billing_state,
			'x_zip' => $order->billing_postcode,
			'x_country' => $order->billing_country,
			'x_phone' => $order->billing_phone,
			'x_email' => $order->billing_email,
			'x_ship_to_first_name' => $order->shipping_first_name,
			'x_ship_to_last_name' => $order->shipping_last_name,
			'x_ship_to_company' => $order->shipping_company,
			'x_ship_to_address' => $order->shipping_address_1.' '.$order->shipping_address_2,
			'x_ship_to_city' => $order->shipping_city,
			'x_ship_to_state' => $order->shipping_state,
			'x_ship_to_zip' => $order->shipping_postcode,
			'x_ship_to_country' => $order->shipping_country,
			'x_cust_id' => $order->user_id,
			'x_customer_ip' => $_SERVER['REMOTE_ADDR'],
			'x_invoice_num' => $order->get_order_number(),
			'x_order_key' => $order->order_key,
			'x_description' => $order->id,
		));

		return $form_fields;
	}

	/**
	 *  Process the payment for DPM and handle the result
	 */
	private function processDpmPayment($order_id)
	{
		$form = $this->getFormFields($order_id);
		$form->add_fields(array(
			'x_card_num' => $this->getPost('authorize_pro_ccnum'),
			'x_exp_date' => $this->getPost('authorize_pro_expmonth').'-'.$this->getPost('authorize_pro_expyear'),
			'x_card_code' => $this->getPost('authorize_pro_cvc')
		));

		if ($this->email_receipt) {
			$form->add_fields(array(
				'x_email_customer' => 'true'
			));
		}

		// get all the data fields from the form as 'hidden' inputs
		$hidden_fields = $form->getHiddenFieldString();

		// spit them out in javascript attached to the checkout form to call authorize dot net
		echo '
				<script type="text/javascript">
				/*<![CDATA[*/

					jQuery(function($){

						$("form.checkout").before(\'<form method="POST" name="authorize-pro-dpm-form" id="authorize-pro-dpm-form" action="'.$this->server_url.'">\
						'.$hidden_fields.'\
						<input type="submit" class="button-alt" id="authorize-pro-dpm-form-submit" value="'.__('Pay via Authorize.net', 'jigoshop-authorize-pro').'" />\
						</form>\');

						$("body").block(
							{
								message: "<img src=\"'.\jigoshop::assets_url().'/assets/images/ajax-loader.gif\" alt=\"Redirecting...\" />'.__('One moment ... contacting Authorize.net to process your order ...', 'jigoshop-authorize-pro').'",
								overlayCSS:
								{
									background: "#fff",
									opacity: 0.6
								},
								css: {
									padding:		20,
									textAlign:	  "center",
									color:		  "#555",
									border:		 "3px solid #aaa",
									backgroundColor:"#fff",
									cursor:		 "wait"
								}
							});
						$("#authorize-pro-dpm-form").submit();

					});

				/*]]>*/
				</script>
			';

		return false;
	}


	/**
	 *  Process the payment for SIM and handle the result
	 */
	private function processSimPayment($order_id)
	{
		$form = $this->getFormFields($order_id);
		$form->add_fields(array(
			'x_show_form' => 'PAYMENT_FORM', /* differentiates SIM from DPM */
		));
		if ($this->email_receipt) {
			$form->add_fields(array(
				'x_email_customer' => 'true'
			));
		}

		// get all the data fields from the form as 'hidden' inputs
		$hidden_fields = $form->getHiddenFieldString();

		// spit them out in javascript attached to the pay page bode to call authorize dot net
		echo '
				<script type="text/javascript">
				/*<![CDATA[*/

					jQuery(function($){

						$("body").append(\'<form method="POST" name="authorize-pro-sim-form" id="authorize-pro-sim-form" action="'.$this->server_url.'">\
						'.$hidden_fields.'\
						<input type="submit" class="button-alt" id="authorize-pro-sim-form-submit" value="'.__('Pay via Authorize.net', 'jigoshop-authorize-pro').'" />\
						</form>\');

						$("body").block(
							{
								message: "<img src=\"'.\jigoshop::assets_url().'/assets/images/ajax-loader.gif\" alt=\"Redirecting...\" />'.__('One moment ... transfering to Authorize.net where you can securely enter your Credit Card information ...', 'jigoshop-authorize-pro').'",
								overlayCSS:
								{
									background: "#fff",
									opacity: 0.6
								},
								css: {
									padding:		20,
									textAlign:	  "center",
									color:		  "#555",
									border:		 "3px solid #aaa",
									backgroundColor:"#fff",
									cursor:		 "wait"
								}
							});
						$("#authorize-pro-sim-form").submit();

					});

				/*]]>*/
				</script>
			';
	}

	/**
	 *  Check response from SIM and DPM, called from 'init' action hook
	 */
	public function checkResponse()
	{
		if (isset($_POST['x_response_code'])) {
			$response = new \DTI_ANet_SIM_Response($this->apilogin, $this->md5hash);
			$order = new \jigoshop_order($response->description);
			$transtype = $this->transtype == 'capture' ? 'AUTH_CAPTURE' : 'AUTH_ONLY';

			if (!$response->isAuthorizeNet()) {
				$note = __('The server-generated fingerprint does not match the merchant-specified fingerprint for the "MD5 Hash" ([md5_hash][md5_setting]).  Check the MD5 Hash Setting for the Authorize PRO Gateway and in your Authorize Merchant Account.', 'jigoshop-authorize-pro');
				$order->add_order_note(sprintf(__('Authorize.net PRO Payment Warning: %s', 'jigoshop-authorize-pro'), $note));
				if ($this->debuglog == 'on') {
					$this->addToLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
						'response_code: '.'3'.PHP_EOL.
						'response_reason_code: '.'99'.PHP_EOL.
						'response_reason_text: '.$note.PHP_EOL);
				}

				// notify the admin
				$this->emailErrorLog($note.PHP_EOL.print_r($response, true).PHP_EOL, $_POST, $order->id);
			}

			if ($response->approved) {
				// Successful payment
				if ($this->debuglog == 'on') {
					$this->addToLog('RESPONSE: '.print_r($response, true));
				}

				$order->payment_complete();
				$order->add_order_note(sprintf(__('Authorize.net PRO Payment completed via %s. (Response: %s - Transaction Type: %s with Authorization Code: %s)', 'jigoshop-authorize-pro'), strtoupper($this->connect_method), $response->response_reason_text, $transtype, $response->authorization_code));
				$args = array(
					'key' => $order->order_key,
					'order' => $order->id,
					'response_code' => 1,
					'transaction_id' => $response->transaction_id,
				);

				$redirect_url = add_query_arg($args, get_permalink(jigoshop_get_page_id('thanks')));
			} elseif ($response->error) {
				if ($this->debuglog == 'on') {
					$this->addToLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
						'response_code: '.$response->response_code.PHP_EOL.
						'response_reason_code: '.$response->response_reason_code.PHP_EOL.
						'response_reason_text: '.$response->response_reason_text);
					$this->addToLog('RESPONSE: '.print_r($response, true));
				}

				if ($this->emaillogs == 'yes') {
					$this->emailErrorLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
						'response_code: '.$response->response_code.PHP_EOL.
						'response_reason_code: '.$response->response_reason_code.PHP_EOL.
						'response_reason_text: '.$response->response_reason_text.PHP_EOL.print_r($response, true).PHP_EOL, $_POST, $order->id);
				}

				$args = array(
					'order_id' => $order->id,
					'response_code' => $response->response_code,
					'response_reason_code' => $response->response_reason_code,
					'response_reason_text' => $response->response_reason_text,
				);

				$redirect_url = add_query_arg($args, get_permalink(jigoshop_get_page_id('checkout')));
			} else {
				if ($this->debuglog == 'on') {
					$this->addToLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
						'response_code: '.$response->response_code.PHP_EOL.
						'response_reason_code: '.$response->response_reason_code.PHP_EOL.
						'response_reason_text: '.$response->response_reason_text);
					$this->addToLog('RESPONSE: '.print_r($response, true));
				}

				if ($this->emaillogs == 'yes') {
					$this->emailErrorLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
						'response_code: '.$response->response_code.PHP_EOL.
						'response_reason_code: '.$response->response_reason_code.PHP_EOL.
						'response_reason_text: '.$response->response_reason_text.PHP_EOL.print_r($response, true).PHP_EOL, $_POST, $order->id);
				}

				$args = array(
					'order_id' => $order->id,
					'response_code' => $response->response_code,
					'response_reason_code' => $response->response_reason_code,
					'response_reason_text' => $response->response_reason_text,
				);

				$order->add_order_note(srpintf(__('Authorize.net PRO Payment failed. Response Code: %s. Payment was rejected due to an error: %s', 'jigoshop-authorize-pro'), $response->response_reason_code, $response->response_reason_text));

				$redirect_url = add_query_arg($args, get_permalink(jigoshop_get_page_id('checkout')));
			}

			// send results back to Authorize.net and it will redirect customer to desired Shop page
			echo \DTI_ANet_SIM_Response::getRelayResponseSnippet($redirect_url);
		} elseif (!count($_POST) && count($_GET)) {
			// these are only set on error conditions from Authorize.net
			// put up messages for user on the Checkout
			if (isset($_GET['order_id']) && isset($_GET['response_code']) && isset($_GET['response_reason_code']) && isset($_GET['response_reason_text'])) {
				$order = new \jigoshop_order($_GET['order_id']);
				$fail_note = __('Authorize.net PRO Payment failed', 'jigoshop-authorize-pro').' (Response Code: '.$_GET['response_reason_code'].'). '.__('Payment was rejected due to an error', 'jigoshop-authorize-pro').': "'.$_GET['response_reason_text'].'". ';
				$order->add_order_note($fail_note);
				\jigoshop::add_error(sprintf(__('Authorize.net Payment failed (%s:%s) -- %s Please try again or choose another gateway for your Order.', 'jigoshop-authorize-pro'), $_GET['response_code'], $_GET['response_reason_code'], $_GET['response_reason_text']));
			}
		}
	}

	/**
	 *  Process the payment for AIM and handle the result
	 */
	private function processAimPayment($order_id)
	{
		$order = new \jigoshop_order($order_id);
		$transtype = $this->transtype == 'capture' ? 'AUTH_CAPTURE' : 'AUTH_ONLY';

		$dti_authorize_request = array(
			'type' => $transtype,
			'amount' => $order->order_total,
			'freight' => $order->order_shipping,
			'tax' => $order->get_total_tax(false, false),
			'login' => $this->apilogin,
			'tran_key' => $this->transkey,
			'cust_id' => $order->user_id,
			'customer_ip' => $_SERVER['REMOTE_ADDR'],
			'invoice_num' => $order->get_order_number(),
			'description' => $order->id,
			'first_name' => $order->billing_first_name,
			'last_name' => $order->billing_last_name,
			'company' => $order->billing_company,
			'address' => $order->billing_address_1.' '.$order->billing_address_2,
			'city' => $order->billing_city,
			'state' => $order->billing_state,
			'zip' => $order->billing_postcode,
			'country' => $order->billing_country,
			'phone' => $order->billing_phone,
			'email' => $order->billing_email,
			'ship_to_first_name' => $order->shipping_first_name,
			'ship_to_last_name' => $order->shipping_last_name,
			'ship_to_company' => $order->shipping_company,
			'ship_to_address' => $order->shipping_address_1.' '.$order->shipping_address_2,
			'ship_to_city' => $order->shipping_city,
			'ship_to_state' => $order->shipping_state,
			'ship_to_zip' => $order->shipping_postcode,
			'ship_to_country' => $order->shipping_country,
			'method' => 'CC',
			'card_num' => $this->getPost('authorize_pro_ccnum'),
			'card_code' => $this->getPost('authorize_pro_cvc'),
			'exp_date' => $this->getPost('authorize_pro_expmonth').'-'.$this->getPost('authorize_pro_expyear')
		);

		$request_sale = new \DTI_ANet_AIM_Request($this->apilogin, $this->transkey);
		$request_sale->setFields($dti_authorize_request);

		if ($this->email_receipt) {
			$request_sale->setFields(array(
				'email_customer' => 'true'
			));
		}

		if ($this->transtype == 'capture') {
			$response = $request_sale->authorizeAndCapture();
		} else {
			$response = $request_sale->authorizeOnly();
		}

		/** @var $response \DTI_ANet_AIM_Response */
		if ($response->approved) {
			// Successful payment
			$order->payment_complete();
			$order->add_order_note(sprintf(__('Authorize.net PRO Payment completed via %s. (Response: %s - Transaction Type: %s with Authorization Code: %s)', 'jigoshop-authorize-pro'), strtoupper($this->connect_method), $response->response_reason_text, $transtype, $response->authorization_code));

			// Return thankyou page redirect, Jigoshop will empty the Cart on the thankyou page
			return array(
				'result' => 'success',
				'redirect' => add_query_arg('key', $order->order_key, add_query_arg('order', $order_id, get_permalink(\Jigoshop_Base::get_options()->get_option('jigoshop_thanks_page_id'))))
			);
		} elseif ($response->error) {
			if ($this->debuglog == 'on') {
				$this->addToLog($response->error_message.PHP_EOL);
				$this->addToLog('RESPONSE: '.print_r($response, true));
			}

			if ($this->emaillogs == 'yes') {
				$this->emailErrorLog($response->error_message.PHP_EOL.print_r($response, true).PHP_EOL, array(), $order->id);
			}

			\jigoshop::add_error(sprintf(__('%s Please try again or choose another gateway for your Order.', 'jigoshop-authorize-pro'), strip_tags($response->error_message)));
		} else {
			if ($this->debuglog == 'on') {
				$this->addToLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
					'response_code: '.$response->response_code.PHP_EOL.
					'response_reason_text: '.$response->response_reason_text);
				$this->addToLog('RESPONSE: '.print_r($response, true));
			}

			if ($this->emaillogs == 'yes') {
				$this->emailErrorLog('AUTHORIZE.NET ERROR:'.PHP_EOL.
					'response_code: '.$response->response_code.PHP_EOL.
					'response_reason_text: '.$response->response_reason_text.PHP_EOL.print_r($response, true).PHP_EOL, array(), $order->id);
			}

			$cancelNote = __('Authorize.net PRO Payment failed', 'jigoshop-authorize-pro').' (Response Code: '.$response->response_code.'). '.__('Payment was rejected due to an error', 'jigoshop-authorize-pro').': "'.$response->response_reason_text.'". ';
			$order->add_order_note($cancelNote);

			\jigoshop::add_error(sprintf(__('Authorize.net PRO Payment failed: %s Please try again or choose another gateway for your Order.', 'jigoshop-authorize-pro'), $response->response_reason_text));
		}

		return false;
	}

	/**
	 *  Payment fields for Authorize.net on the Checkout.
	 */
	public function payment_fields()
	{
		if ($this->description) {
			echo wpautop(wptexturize($this->description));
		}

		if ($this->aim_enabled) {
			?>
			<div class="ssl-certificate" style="margin:15px 0;">
				<?php if ($this->certificate) {
					echo wptexturize($this->certificate);
				} ?>
			</div>
			<div class="clear"></div>
		<?php } ?>

		<div class="available-cards" style="margin:10px 0">
			<?php
			if ($this->cardtypes['visa'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/visa.png" alt="Visa Image">';
			}
			if ($this->cardtypes['mastercard'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/mastercard.png" alt="Mastercard Image">';
			}
			if ($this->cardtypes['amex'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/amex.png" alt="AMEX Image">';
			}
			if ($this->cardtypes['discover'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/discover.png" alt="Discover Image">';
			}
			if ($this->cardtypes['jcb'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/jcb.png" alt="JCB Image">';
			}
			if ($this->cardtypes['diners'] == '1') {
				echo '<img src="'.JIGOSHOP_AUTHORIZE_PRO_URL.'/assets/images/diners.png" alt="Diners Image">';
			}
			?>
		</div>
		<div class="clear"></div>

		<?php
		// we wont' display credit card entry fields for SIM
		if (!$this->aim_enabled && !$this->dpm_enabled) {
			return;
		}
		?>

		<fieldset>
			<p class="form-row form-row-first validate-required">
				<label for="authorize_pro_ccnum"><?php echo __('Credit Card Number', 'jigoshop-authorize-pro') ?> <span class="required">*</span></label>
				<input type="text" class="input-text input-required" id="authorize_pro_ccnum" name="authorize_pro_ccnum" />
			</p>
			<p class="form-row form-row-last validate-required">
				<label for="authorize_pro_cvc"><?php _e('Card Security Code', 'jigoshop-authorize-pro') ?> <span class="required">*</span></label>
				<input type="text" class="input-text input-required" id="authorize_pro_cvc" name="authorize_pro_cvc" maxlength="4" style="width:70px" />
			</p>
			<div class="clear"></div>
			<p class="form-row form-row-first validate-required">
				<label for="authorize_pro_expmonth"><?php echo __('Expiration Date', 'jigoshop-authorize-pro') ?> <span class="required">*</span></label>
				<select class="input-required" style="width: 120px;" name="authorize_pro_expmonth" id="authorize_pro_expmonth">
					<option value=""><?php _e('Month', 'jigoshop-authorize-pro') ?></option>
					<?php
					$months = array();
					for ($i = 1; $i <= 12; $i++) {
						$timestamp = mktime(0, 0, 0, $i, 1);
						$months[date('n', $timestamp)] = date('F', $timestamp);
					}
					foreach ($months as $num => $name) {
						printf('<option value="%u">%s</option>', $num, $name);
					}
					?>
				</select>
				<select class="input-required" style="width:120px;" name="authorize_pro_expyear" id="authorize_pro_expyear">
					<option value=""><?php _e('Year', 'jigoshop-authorize-pro') ?></option>
					<?php
					for ($i = date('y'); $i <= date('y') + 15; $i++) {
						printf('<option value="20%u">20%u</option>', $i, $i);
					}
					?>
				</select>
			</p>
			<div class="clear"></div>
		</fieldset>
	<?php
	}

	/**
	 *  Validate payment form fields on the Checkout, called from parent payment gateway class
	 */
	public function validate_fields()
	{
		// SIM and DPM doesn't need card validations
		if (!$this->aim_enabled) {
			return true;
		}

		$validated = true;
		$cardNumber = $this->getPost('authorize_pro_ccnum');
		$cardCVC = $this->getPost('authorize_pro_cvc');
		$cardExpirationMonth = $this->getPost('authorize_pro_expmonth');
		$cardExpirationYear = $this->getPost('authorize_pro_expyear');

		// check credit card number
		$cardNumber = str_replace(array(' ', '-'), '', $cardNumber);
		// this will validate (Visa, MasterCard, Discover, American Express) for length and format
		$valid = preg_match('^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$^', $cardNumber);
		if ($valid == 0) {
			\jigoshop::add_error(__('The Authorize.net Credit Card number entered is invalid.', 'jigoshop-authorize-pro'));
			$validated = false;
		} elseif ($valid === false) {
			\jigoshop::add_error(__('There was an error validating your Authorize.net credit card number.', 'jigoshop-authorize-pro'));
			$validated = false;
		}

		// check CVC
		if (!ctype_digit($cardCVC)) {
			\jigoshop::add_error(__('Authorize.net Credit Card security code entered is invalid.', 'jigoshop-authorize-pro'));
			$validated = false;
		}

		// check expiration data
		$currentYear = date('Y');
		if (!ctype_digit($cardExpirationMonth) || !ctype_digit($cardExpirationYear)
			|| $cardExpirationMonth > 12
			|| $cardExpirationMonth < 1
			|| $cardExpirationYear < $currentYear
			|| $cardExpirationYear > $currentYear + 20
		) {
			\jigoshop::add_error(__('Authorize.net Credit Card expiration date is invalid.', 'jigoshop-authorize-pro'));
			$validated = false;
		}

		return $validated;
	}

	/**
	 *  Clean and return requested $_POST data
	 */
	private function getPost($name)
	{
		$value = null;

		if (isset($_POST[$name])) {
			$value = strip_tags(stripslashes(trim($_POST[$name])));
		}

		return $value;
	}

	/**
	 *  Dump a message into the logging facility for debugging
	 */
	private function addToLog($message)
	{
		$path = JIGOSHOP_AUTHORIZE_PRO_DIR.'/log/authorize_pro_debug.log';

		$string = '-----Log Entry-----'.PHP_EOL;
		$string .= 'Log Date: '.date('r').PHP_EOL.$message.PHP_EOL;

		if (file_exists($path)) {
			if ($log = fopen($path, 'a')) {
				fwrite($log, $string, strlen($string));
				fclose($log);
			}
		} else {
			if ($log = fopen($path, 'c')) {
				fwrite($log, $string, strlen($string));
				fclose($log);
			}
		}
	}

	/**
	 * Email the error logs
	 */
	private function emailErrorLog($error, $posted = array(), $order_id = '')
	{
		$subject = sprintf(__('[%s] Authorize.net PRO Error Log for Order #%s', 'jigoshop'), html_entity_decode(get_bloginfo('name'), ENT_QUOTES), $order_id);
		$message = __('Order #', 'jigoshop-authorize-pro').$order_id.PHP_EOL;
		$message .= '======================================================='.PHP_EOL;
		if (!empty($error)) {
			$message .= __('Errors logged during the Jigoshop Authorize.net PRO Checkout process:', 'jigoshop-authorize-pro').PHP_EOL;
			$message .= $error.PHP_EOL;
		} else {
			$message .= __('No error message received.', 'jigoshop-authorize-pro').PHP_EOL;
		}
		$message .= '======================================================='.PHP_EOL;
		if (!empty($posted)) {
			$message .= 'All POST variables are:'.PHP_EOL;
			foreach ($posted as $key => $value) {
				$message .= $key.' = '.$value.PHP_EOL;
			}
			$message .= '======================================================='.PHP_EOL;
		}

		add_filter('wp_mail_from_name', 'jigoshop_mail_from_name', 99);
		wp_mail($this->emailaddress, $subject, $message);
		remove_filter('wp_mail_from_name', 'jigoshop_mail_from_name', 99);
	}
}
