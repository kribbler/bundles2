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

require_once 'Customweb/Payment/Authorization/Server/IAdapter.php';
require_once 'Customweb/Payment/Authorization/PaymentPage/IAdapter.php';
require_once 'Customweb/Payment/Authorization/Iframe/IAdapter.php';
require_once 'Customweb/Payment/Authorization/Hidden/IAdapter.php';
require_once 'Customweb/Payment/Authorization/Ajax/IAdapter.php';
require_once 'Customweb/I18n/Translation.php';


abstract class Customweb_Payment_Authorization_AbstractAdapterFactory {

	private $adapterInstances = array();
	private $configurationAdapterInstance = null;

	/**
	 * This method retrieves the adapter for the given order context.
	 *           	 		    			 
	 * @param Customweb_Payment_Authorization_IOrderContext $context
	 * @return Customweb_Payment_Authorization_IAdapter
	 */
	public function getAdapterByOrderContext(Customweb_Payment_Authorization_IOrderContext $context) {
		$configuredAuthorizationMethod = $context->getPaymentMethod()->getPaymentMethodConfigurationValue('authorizationMethod');
		return $this->getAdapterByOrderContextInner($configuredAuthorizationMethod, array_keys($this->getAdapterMap()), $context);
	}

	/**
	 * This method tries to instanciated an adapter for the given authorization method. If the authorization method
	 * is not supported for the given context the next one in the stack is tried.
	 * 
	 * @param string $currentMethod
	 * @param array $supportedMethod
	 * @param Customweb_Payment_Authorization_IOrderContext $context
	 * @throws Exception In case no adapter matches the given parameters.
	 */
	private function getAdapterByOrderContextInner($currentMethod, array $supportedMethod, Customweb_Payment_Authorization_IOrderContext $context) {
		if (count($supportedMethod) <= 0) {
			throw new Exception(
					Customweb_I18n_Translation::__(
							"No authorization method found for payment method !method.",
							array('!method' => $context->getPaymentMethod()->getPaymentMethodName())
					)
			);
		}

		$adapter = $this->getAdapterByAuthorizationMethod($currentMethod);
		if ($adapter->isAuthorizationMethodSupported($context)) {
			return $adapter;
		}
		else {
			$applicableMethods = array();
			foreach ($supportedMethod as $methodName) {
				if ($methodName == $currentMethod) {
					break;
				}
				$applicableMethods[] = $methodName;
			}
			return $this->getAdapterByOrderContextInner(end($applicableMethods), $applicableMethods, $context);
		}
	}


	/**
	 *           	 		    			 
	 * @param string $authorizationMethod
	 * @return Customweb_Payment_Authorization_IAdapter
	 * @throws Exception
	 */
	public function getAdapterByAuthorizationMethod($authorizationMethod) {

		if (!isset($this->adapterInstances[$authorizationMethod])) {
			$map = $this->getAdapterMap();

			if (!is_array($map)) {
				throw new Exception("The method Customweb_Payment_Authorization_AbstractAdapterFactory::getAdapterMap() has to return a array.");
			}

			if (!isset($map[$authorizationMethod])) {
				throw new Exception(Customweb_I18n_Translation::__(
						"The authorization method '!method' is not supported.",
						array('!method' => $authorizationMethod)
				));
			}

			$adapterClass = $map[$authorizationMethod];

			// Include the adapter class
			$classPath = str_replace('_', '/', $adapterClass) . '.php';
			require_once $classPath;

			$configurationAdapter = $this->getConfigurationAdapter();
			$this->adapterInstances[$authorizationMethod] = new $adapterClass($configurationAdapter);
		}

		return $this->adapterInstances[$authorizationMethod];
	}

	public function getConfigurationAdapter() {
		if ($this->configurationAdapterInstance == null) {
			$class = $this->getConfigurationAdapterClass();
			$this->configurationAdapterInstance = new $class();
		}
		return $this->configurationAdapterInstance;
	}

	/**
	 * This method has to return a key value map. Where the key is the authorization method name and
	 * the value the class to use.
	 *
	 * @return array
	 */
	abstract protected function getAdapterMap();

	/**
	 * This method has to return the configuration adapter class. Important: The class must
	 * be included by the subclass directly. It is not included automatically.
	 *
	 * @return string
	 */
	abstract public function getConfigurationAdapterClass();


}