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

library_load_class_by_name('Customweb_Payment_Authorization_DefaultPaymentCustomerContext');

class PostFinanceCw_PaymentCustomerContext implements Customweb_Payment_Authorization_IPaymentCustomerContext{
	
	private $context = null;
	private $customerId = null;
	
	public function __construct($customerId) {
		$this->customerId = $customerId;
	}
	
	public function getMap() {
		return $this->getContext()->getMap();
	}
	
	public function updateMap(array $update) {
		return $this->getContext()->updateMap($update);
	}
	
	public function persist() {
		if ($this->customerId > 0) {
			$map = unserialize(get_user_meta($this->customerId, 'postfinancecw_payment_context', true));
			$updatedMap = $this->getContext()->applyUpdatesOnMapAndReset($map);
			update_user_meta($this->customerId, 'postfinancecw_payment_context', serialize($updatedMap));
		}
	}
	
	public function __sleep() {
		$this->persist();
		return array('customerId');
	}
	
	public function __wakeup() {
	}
	
	protected function getContext() {
		if ($this->context === null) {
			if ($this->customerId > 0) {
				$map = unserialize(get_user_meta($this->customerId, 'postfinancecw_payment_context', true));
				$this->context = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext($map);
			}
			else {
				$this->context = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext(array());
			}
		}
		return $this->context;
	}
	
}