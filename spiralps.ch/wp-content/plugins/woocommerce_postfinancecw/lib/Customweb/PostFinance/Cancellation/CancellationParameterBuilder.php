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

class Customweb_PostFinance_Cancellation_CancellationParameterBuilder extends Customweb_PostFinance_MaintenanceParameterBuilder {
	
	protected function getOperationParameter() {
		return array('OPERATION' => Customweb_PostFinance_IAdapter::OPERATION_DELETE_AUTHORISATION);
	}
	
	protected function getMaintenanceAmount() {
		return $this->getTransaction()->getAuthorizationAmount();
	}
	
}