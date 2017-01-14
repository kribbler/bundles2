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


interface Customweb_Payment_BackendOperation_IAdapterFactory {

	
	public function setConfigurationAdapter(Customweb_Payment_IConfigurationAdapter $configurationAdapter);
	
	/**
	 * Returns the set configuration adapter.
	 * 
	 * @return Customweb_Payment_IConfigurationAdapter
	 */
	public function getConfigurationAdapter();
	
	/**
	 * Returns the adapter for cancellations.
	 * @return Customweb_Payment_BackendOperation_Adapter_ICancellationAdapter
	 */
	public function getCancellationAdapter();
	
	/**
	 * Returns the adapter for refunds.
	 * 
	 * @return Customweb_Payment_BackendOperation_Adapter_IRefundAdapter
	 */
	public function getRefundAdapter();
	
	/**
	 * Returns the adapter for captures.
	 * 
	 * @return Customweb_Payment_BackendOperation_Adapter_ICaptureAdapter
	 */
	public function getCaptureAdapter();
}