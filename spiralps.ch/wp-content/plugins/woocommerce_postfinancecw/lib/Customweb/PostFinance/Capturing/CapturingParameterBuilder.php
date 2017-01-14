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

require_once 'Customweb/PostFinance/MaintenanceParameterBuilder.php';
require_once 'Customweb/PostFinance/IAdapter.php';
require_once 'Customweb/Payment/Util.php';

class Customweb_PostFinance_Capturing_CapturingParameterBuilder extends Customweb_PostFinance_MaintenanceParameterBuilder {

	private $captureAmount = null;
	private $close = false;
	
	public function __construct(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_PostFinance_Configuration $configuration, $amount, $close) {
		parent::__construct($transaction, $configuration);
		
		$this->captureAmount = $amount;
		$this->close = $close;
	}

	protected function getOperationParameter() {
		if (Customweb_Payment_Util::amountEqual($this->getTransaction()->getAuthorizationAmount(), $this->captureAmount) || $this->close) {
			return array('OPERATION' => Customweb_PostFinance_IAdapter::OPERATION_CAPTURE_FULL);
		}
		else {
			return array('OPERATION' => Customweb_PostFinance_IAdapter::OPERATION_CAPTURE_PARTIAL);
		}
	}
	
	protected function getMaintenanceAmount() {
		return $this->captureAmount;
	}
}