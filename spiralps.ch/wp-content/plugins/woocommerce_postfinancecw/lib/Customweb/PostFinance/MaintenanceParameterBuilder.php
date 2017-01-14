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

require_once 'Customweb/PostFinance/AbstractParameterBuilder.php';
require_once 'Customweb/I18n/Translation.php';

abstract class Customweb_PostFinance_MaintenanceParameterBuilder extends Customweb_PostFinance_AbstractParameterBuilder {
	
	/**
	 * (non-PHPdoc)          	 		    			 
	 * @see Customweb_PostFinance_AbstractParameterBuilder::buildParameters()
	 */
	public function buildParameters() {
		$parameters = array_merge(
				$this->getAmountParameter($this->getMaintenanceAmount()),
				$this->getCurrencyParameter(),
				$this->getAuthParameters(),
				$this->getPspParameter(),
				$this->getPayIdParameter(),
				$this->getOperationParameter()
		);
		
		$this->addShaSignToParameters($parameters);
		
		return $parameters;
	}
	
	protected function getPayIdParameter() {
		$payId = $this->getTransaction()->getPaymentId();
		if (empty($payId)) {
			throw new Exception(
					Customweb_I18n_Translation::__('For a maintenance request a payment id must be set on the transaction.')
			);
		}
		
		return array('PAYID' => $payId);
	}
	
	protected function getAuthParameters() {
		$parameters = array();
	
		$userId = $this->getConfiguration()->getApiUserId();
		$password = $this->getConfiguration()->getApiPassword();
	
		if (empty($userId)) {
			throw new Exception(Customweb_I18n_Translation::__('No API username was provided.'));
		}
	
		if (empty($password)) {
			throw new Exception(Customweb_I18n_Translation::__('No API password was provided.'));
		}
	
		return array(
			'USERID' => $userId,
			'PSWD' => $password
		);
	}
	
	abstract protected function getOperationParameter();
	
	abstract protected function getMaintenanceAmount();
	
}