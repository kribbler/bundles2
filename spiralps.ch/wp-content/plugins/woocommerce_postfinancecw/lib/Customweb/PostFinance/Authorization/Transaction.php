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

require_once 'Customweb/Payment/Authorization/DefaultTransaction.php';
require_once 'Customweb/PostFinance/Method/Factory.php';
require_once 'Customweb/PostFinance/IAdapter.php';

class Customweb_PostFinance_Authorization_Transaction extends Customweb_Payment_Authorization_DefaultTransaction {
	
	const AUTHORIZATION_STATE_INITIAL = 'initial';
	const AUTHORIZATION_STATE_3DSECURE = '3dsecure';
	
	private $authorizationState = null;
	
	private $aliasIdentifier = null;
	
	private $aliasCreationResponse = null;
	
	private $directLinkCreationParameters = null;
	
	private $aliasTransactionId = null;
	
	private $aliasGatewayAlias = null;
	
	public function __construct(Customweb_Payment_Authorization_ITransactionContext $transactionContext) {
		parent::__construct($transactionContext);
	}
	
	public function getAliasName() {
		$params = $this->getAuthorizationParameters();
		return $params['ALIAS'];
	}
	
	/**
	 * This method returns the identifier to create new transactions with the credentials
	 * of this transaction.
	 * 
	 * @return string
	 */
	public function getAliasIdentifier() {
		$params = $this->getAuthorizationParameters();
		if (isset($params['ALIAS'])) {
			return $params['ALIAS'];
		}
		else {
			return NULL;
		}
	}
	
	public function getTransactionSpecificLabels() {
		$labels = array();

		$params = $this->getAuthorizationParameters();
		
		if (isset($params['ALIAS'])) {
			$labels['alias_psp'] = array(
				'label' => Customweb_I18n_Translation::__('Alias Token'),
				'value' => $params['ALIAS']
			);
		}
		
		if (isset($params['ACCEPTANCE'])) {
			$labels['acceptance'] = array(
				'label' => Customweb_I18n_Translation::__('Acceptance'),
				'value' => $params['ACCEPTANCE']
			);
		}
		
		if (isset($params['CARDNO'])) {
			$labels['cardnumber'] = array(
				'label' => Customweb_I18n_Translation::__('Card Number'),
				'value' => $params['CARDNO']
			);
		}
		
		if (isset($params['ED'])) {
			$labels['card_expiry'] = array(
				'label' => Customweb_I18n_Translation::__('Card Expiry Date'),
				'value' => substr($params['ED'], 0, 2) . '/' . substr($params['ED'], 2, 4)
			);
		}
		
		if (isset($params['ORDERID'])) {
			$labels['orderid'] = array(
				'label' => Customweb_I18n_Translation::__('Merchant Reference'),
				'value' => $params['ORDERID'],
			);
		}
		
		if ($this->isMoto()) {
			$labels['moto'] = array(
				'label' => Customweb_I18n_Translation::__('Mail Order / Telephone Order (MoTo)'),
				'value' => Customweb_I18n_Translation::__('Yes'),
			);
		}
		
		return $labels;
	}
	
	public function isMoto() {
		return $this->getAuthorizationMethod() == Customweb_Payment_Authorization_Moto_IAdapter::AUTHORIZATION_METHOD_NAME;
	}
	
	public function getAuthorizationState() {
		return $this->authorizationState;
	}
	
	public function setAuthorizationState($state) {
		$this->authorizationState = $tstate;
		return $this;
	}
	
	public function getDirectLinkCreationParameters() {
		return $this->directLinkCreationParameters;
	}
	
	public function setDirectLinkCreationParameters($params) {
		$this->directLinkCreationParameters = $params;
		return $this;
	}
	
	public function setAliasTransactionId($transactionId) {
		$this->aliasTransactionId = $transactionId;
		return $this;
	}
	
	public function getAliasTransactionId() {
		return $this->aliasTransactionId;
	}
	
	public function getFailedUrl() {
		return Customweb_Util_Url::appendParameters(
				$this->getTransactionContext()->getFailedUrl(),
				$this->getTransactionContext()->getCustomParameters()
		);
	}
	
	public function getBackendFailedUrl() {
		return Customweb_Util_Url::appendParameters(
				$this->getTransactionContext()->getBackendFailedUrl(),
				$this->getTransactionContext()->getCustomParameters()
		);
	}
	
	public function getSuccessUrl() {
		return Customweb_Util_Url::appendParameters(
				$this->getTransactionContext()->getSuccessUrl(),
				$this->getTransactionContext()->getCustomParameters()
		);
	}
	
	public function getBackendSuccessUrl() {
		return Customweb_Util_Url::appendParameters(
				$this->getTransactionContext()->getBackendSuccessUrl(),
				$this->getTransactionContext()->getCustomParameters()
		);
	}
	
	public function is3dRedirectionRequired() {
		$params = $this->getAuthorizationParameters();
		
		if (!isset($params['STATUS'])) {
			return false;
		}
		
		return $params['STATUS'] == Customweb_PostFinance_IAdapter::STATUS_WAITING_FOR_IDENTIFICATION;
	}
	
	public function getAliasCreationResponse() {
		return $this->aliasCreationResponse;
	}
	
	public function setAliasCreationResponse(array $response) {
		$this->aliasCreationResponse = $response;
		return $this;
	}
	
	public function getAliasGatewayAlias() {
		return $this->aliasGatewayAlias;
	}
	
	public function setAliasGatewayAlias($alias) {
		$this->aliasGatewayAlias = $alias;
		return $this;
	}
	
	public function setAuthorizationParameters(array $parameters) {
		return parent::setAuthorizationParameters(array_change_key_case($parameters, CASE_UPPER));
	}
	
	
	
}