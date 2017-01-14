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

library_load_class_by_name('Customweb_Payment_Authorization_AbstractAdapterFactory');
library_load_class_by_name('Customweb_Payment_Authorization_PaymentPage_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Iframe_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Hidden_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Ajax_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Server_IAdapter');
library_load_class_by_name('Customweb_Payment_Authorization_Recurring_IAdapter');

PostFinanceCwUtil::includeClass('Adapter/AjaxAdapterWrapper');
PostFinanceCwUtil::includeClass('Adapter/HiddenAdapterWrapper');
PostFinanceCwUtil::includeClass('Adapter/IframeAdapterWrapper');
PostFinanceCwUtil::includeClass('Adapter/PaymentPageAdapterWrapper');
PostFinanceCwUtil::includeClass('Adapter/ServerAdapterWrapper');

PostFinanceCwUtil::includeClass('ConfigurationAdapter');


class PostFinanceCw_AdapterFactory extends Customweb_Payment_Authorization_AbstractAdapterFactory{
	
	/**
	 * @var PostFinanceCw_Adapter_IAdapter[]
	 */
	private static $wrapper_instances = array();

	/**
	 * @return PostFinanceCw_Adapter_IAdapter
	 */
	public function getAdapterByOrderContext(Customweb_Payment_Authorization_IOrderContext $context) {
		$adapter = parent::getAdapterByOrderContext($context);
		return $this->wrapAdapter($adapter);
	}
	
	/**
	 *           	 		    			 
	 * @param string $authorizationMethod
	 * @throws Exception
	 * @return PostFinanceCw_Adapter_IAdapter
	 */
	public function getAdapterByAuthorizationMethod($authorizationMethod) {
		$adapter = parent::getAdapterByAuthorizationMethod($authorizationMethod);
		
		if (!isset(self::$wrapper_instances[$authorizationMethod])) {
			self::$wrapper_instances[$authorizationMethod] = $this->wrapAdapter($adapter);
		}
		
		return self::$wrapper_instances[$authorizationMethod];
	}
	
	private function wrapAdapter($adapter) {
		$class = get_class($adapter);
		$o = new ReflectionClass( $class );
		$authorizationMethod = $o->getConstant("AUTHORIZATION_METHOD_NAME");
		$wrappers = $this->getAdapterWrapperMap();
		if (!isset($wrappers[$authorizationMethod])) {
			return $adapter;
		}
		$wrapperClass = $wrappers[$authorizationMethod];
		return new $wrapperClass($adapter);
	}
	
	protected function getAdapterMap() {
		return array(
			
			Customweb_Payment_Authorization_PaymentPage_IAdapter::AUTHORIZATION_METHOD_NAME => 'Customweb_PostFinance_Authorization_PaymentPage_Adapter',
			
			
			
			Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME => 'Customweb_PostFinance_Authorization_Hidden_Adapter',
			
			
			
			Customweb_Payment_Authorization_Server_IAdapter::AUTHORIZATION_METHOD_NAME => 'Customweb_PostFinance_Authorization_Server_Adapter',
			
			
			Customweb_Payment_Authorization_Recurring_IAdapter::AUTHORIZATION_METHOD_NAME => 'Customweb_PostFinance_Authorization_Recurring_Adapter',
			
		);
	}
	
	protected function getAdapterWrapperMap() {
		return array(
			
			Customweb_Payment_Authorization_PaymentPage_IAdapter::AUTHORIZATION_METHOD_NAME => 'PostFinanceCw_Adapter_PaymentPageAdapterWrapper',
			
			
			
			Customweb_Payment_Authorization_Hidden_IAdapter::AUTHORIZATION_METHOD_NAME => 'PostFinanceCw_Adapter_HiddenAdapterWrapper',
			
			
			
			Customweb_Payment_Authorization_Server_IAdapter::AUTHORIZATION_METHOD_NAME => 'PostFinanceCw_Adapter_ServerAdapterWrapper',
			
		);
		
	}
	
	public function getConfigurationAdapterClass() {
		return 'PostFinanceCw_ConfigurationAdapter';
	}
	
	
	/**
	 * @return Customweb_Payment_BackendOperation_Adapter_IRefundAdapter
	 */
	public static function getRefundAdapter() {
		library_load_class_by_name('Customweb_PostFinance_BackendOperation_Adapter_RefundAdapter');
		return new Customweb_PostFinance_BackendOperation_Adapter_RefundAdapter(new PostFinanceCw_ConfigurationAdapter());
	}
	
	
	
	/**
	 * @return Customweb_Payment_BackendOperation_Adapter_ICancellationAdapter
	 */
	public static function getCancellationAdapter() {
		library_load_class_by_name('Customweb_PostFinance_BackendOperation_Adapter_CancellationAdapter');
		return new Customweb_PostFinance_BackendOperation_Adapter_CancellationAdapter(new PostFinanceCw_ConfigurationAdapter());
	}
	
	
	
	/**
	 * @return Customweb_Payment_BackendOperation_Adapter_ICaptureAdapter
	*/
	public static function getCapturingAdapter() {
		library_load_class_by_name('Customweb_PostFinance_BackendOperation_Adapter_CaptureAdapter');
		return new Customweb_PostFinance_BackendOperation_Adapter_CaptureAdapter(new PostFinanceCw_ConfigurationAdapter());
	}
	
	
	
}