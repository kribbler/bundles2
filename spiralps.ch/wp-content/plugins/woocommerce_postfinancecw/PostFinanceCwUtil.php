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

library_load_class_by_name('Customweb_Util_Url');

class PostFinanceCwUtil {
	
	private function __construct() {}
	
	private static $methods = array();
	
	private static $basePath = NULL;
	
	/**
	 * This method loads a order.
	 * 
	 * @param integer $orderId
	 * @return Order Object
	 */
	public static function loadOrderObjectById($orderId) {
		if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.0.0') >= 0 && class_exists('WC_Order')) {
			return new WC_Order($orderId);
		}
		else {
			return new woocommerce_order( $orderId );
		}
	}
	
	public static function includeClass($class) {
		$classFile = str_replace('PostFinanceCw_', '', $class);
		require_once self::getBasePath() . '/classes/' . $classFile . '.php';
	}
	
	/**
	 * This method returns the base bath to the plugin.
	 * 
	 * @return string Base Path
	 */
	public static function getBasePath() {
		if (self::$basePath === NULL) {
			self::$basePath = dirname(__FILE__);
		}
		return self::$basePath;
	}
	
	public static function addPaymentMethods($gateways = array()) {
		$methods = self::getPaymentMethods();
		foreach ($methods as $class_name) {
			$gateways[] = $class_name;
		}
		
		return $gateways;
	}
	
	public static function getPaymentMethods($includClass = true) {
		if (count(self::$methods) <= 0) {
			if ($handle = opendir(self::getBasePath() . '/payment_methods')) {
				while (false !== ($file = readdir($handle))) {
					if (!is_dir(self::getBasePath() . '/' . $file) && $file !== '.' && $file !== '..' && substr($file, -4, 4) == '.php') {
						$class_name = substr($file, 0, -4);
						self::$methods[] = $class_name;
					}
				}
				closedir($handle);
			}
		}
		
		if ($includClass) {
			foreach (self::$methods as $method) {
				self::includePaymentMethod($method);
			}
		}
	
		return self::$methods;
	}
	
	public static function includePaymentMethod($methodClassName) {
		$methodClassName = strip_tags($methodClassName);
		if (!class_exists($methodClassName)) {
			$methods = self::getPaymentMethods(false);
			$fileName = self::getBasePath() . '/payment_methods/' . $methodClassName . '.php';
			if (!file_exists($fileName)) {
				throw new Exception("The payment method class could not be included, because it was not found. Payment Method Name: '" . $methodClassName . "' File Path: " . $fileName);
			}
			require_once $fileName;
		}
	}
	
	/**
	 * @param string $methodClassName
	 * @return PostFinanceCw_PaymentMethod
	 */
	public static function getPaymentMehtodInstance($methodClassName) {
		
		self::includePaymentMethod($methodClassName);
		return new $methodClassName();
	}
	
	public static function getPluginUrl($file, array $params = array()) {
		return Customweb_Util_Url::appendParameters(plugins_url($file, __FILE__), $params);
	}
	
	public static function getAssetsUrl($path) {
		return plugins_url(null,__FILE__) . '/assets/' . $path;
	}
	
	public static function installPlugin() {
		self::includeClass('PostFinanceCw_Transaction');
		self::includeClass('PostFinanceCw_Log');
		PostFinanceCw_Transaction::installTable();
		PostFinanceCw_Log::installTable();
		add_option( "woocommerce_postfinancecw_db_version", PostFinanceCwUtil::getPluginDatabaseVersion() );
	}
	
	public static function renderHiddenFields($fields) {
		$out = '';
		
		foreach ($fields as $key => $value) {
			$out .= '<input type="hidden" name="' . $key . '" value="' . str_replace('"', '\\"', $value) . '" />';
		}
		
		return $out;
	}
	
	public static function getPluginDatabaseVersion() {
		return '1.0';
	}
	
	public static function getTemplateFile($templateName) {
		$templates = array();
		$templates[] = $baseFileName;
		return get_query_template('postfinancecw', $templates);
	}
	
	public static function includeTemplateFile($templateName, $variables = array()) {
		if (empty($templateName)) {
			throw new Exception("The given template name is empty.");
		}
		
		$templateName = 'postfinancecw_' . $templateName;
		
		$templates = self::getTemplateFile($templateName);
		$template = apply_filters( 'template_include', $templates );
		extract($variables);
		if (!empty($template)) {
			require_once  $template;
		}
		else {
			require_once self::getBasePath() . '/theme/' . $templateName . '.php';
		}
	}
	
	public static function refundTransaction($transactionId, $amount, $close) {
		self::includeClass('PostFinanceCw_Transaction');
		$dbTransaction = PostFinanceCw_Transaction::loadById($transactionId);
		if ($dbTransaction === NULL) {
			throw new Exception("Could not load transaction.");
		}
		
		$paymentClass = $dbTransaction->getPaymentClassName();
		return self::getPaymentMehtodInstance($paymentClass)->refundTransaction($dbTransaction, $amount, $close);
	}
	
	public static function cancelTransaction($transactionId) {
		self::includeClass('PostFinanceCw_Transaction');
		$dbTransaction = PostFinanceCw_Transaction::loadById($transactionId);
		if ($dbTransaction === NULL) {
			throw new Exception("Could not load transaction.");
		}
		$paymentClass = $dbTransaction->getPaymentClassName();
		return self::getPaymentMehtodInstance($paymentClass)->cancelTransaction($dbTransaction);
	}
	
	public static function captureTransaction($transactionId, $amount, $close) {
		self::includeClass('PostFinanceCw_Transaction');
		$dbTransaction = PostFinanceCw_Transaction::loadById($transactionId);
		if ($dbTransaction === NULL) {
			throw new Exception("Could not load transaction.");
		}
		$paymentClass = $dbTransaction->getPaymentClassName();
		return self::getPaymentMehtodInstance($paymentClass)->captureTransaction($dbTransaction, $amount, $close);
	}
	
	/**
	 * This action is executed, when the form is rendered.
	 *
	 * @param WC_Checkout $checkout
	 */
	public static function actionBeforeCheckoutBillingForm(WC_Checkout $checkout) {
		self::includeClass('PostFinanceCw_ConfigurationAdapter');
		
		if (PostFinanceCw_ConfigurationAdapter::isReviewFormInputActive()) {
			$fieldsToForceUpdate = array('billing_first_name', 'billing_last_name', 'billing_company', 'billing_email', 'billing_phone');
			$checkout->checkout_fields['billing'] = self::addCssClassToForceAjaxReload($checkout->checkout_fields['billing'], $fieldsToForceUpdate);
		}
		
	}
	
	/**
	 * This action is executed, when the form is rendered.
	 *
	 * @param WC_Checkout $checkout
	 */
	public static function actionBeforeCheckoutShippingForm(WC_Checkout $checkout) {
		self::includeClass('PostFinanceCw_ConfigurationAdapter');
			
		if (PostFinanceCw_ConfigurationAdapter::isReviewFormInputActive()) {
			$fieldsToForceUpdate = array('shipping_first_name', 'shipping_last_name', 'shipping_company',);
			$checkout->checkout_fields['shipping'] = self::addCssClassToForceAjaxReload($checkout->checkout_fields['shipping'], $fieldsToForceUpdate);
		}
	}
	
	private static function addCssClassToForceAjaxReload($fields, $forceFields) {
		
		foreach($fields as $key => $data) {
			if (in_array($key, $forceFields)) {
				if (!in_array('address-field', $data['class'])) {
					$fields[$key]['class'][] = 'address-field';
				}
			}
		}
		
		return $fields;
	}
	
	public static function getBackendOperationAdapterFactory() {
		library_load_class_by_name('Customweb_Payment_BackendOperation_IAdapterFactory');
		library_load_class_by_name('Customweb_Payment_BackendOperation_DefaultAdapterFactory');
		
		self::includeClass('PostFinanceCw_ConfigurationAdapter');
	
		$factory = new Customweb_Payment_BackendOperation_DefaultAdapterFactory();
		$factory->setConfigurationAdapter(new PostFinanceCw_ConfigurationAdapter());
	
		return $factory;
	}
	
	function activatePullCron() {
		self::includeClass('PostFinanceCw_ConfigurationAdapter');
		wp_schedule_event(time()+60, 'PostFinanceCwPullInterval', 'PostFinanceCwPullCronHook');
	}
	
	function deactivePullCron() {
		wp_clear_scheduled_hook('PostFinanceCwPullCronHook');
	}
	
	public static function createPullCronInterval($schedules) {
		self::includeClass('PostFinanceCw_ConfigurationAdapter');
		if(! PostFinanceCw_ConfigurationAdapter::existsConfiguration('pull_interval')) {
			return $schedules; 
		}
		$interval = PostFinanceCw_ConfigurationAdapter::getConfigurationValue('pull_interval');
		if (empty($interval)){
			$interval=30;
		}
		$schedules['PostFinanceCwPullInterval'] = array(
				'interval' => intval($interval)*60,
				'display' => __('Interval specified in configuration')
		);
		
		return $schedules;
	}
	
}