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

require_once 'Customweb/I18n/Translation.php';

require_once 'Customweb/PostFinance/IAdapter.php';
require_once 'Customweb/PostFinance/Configuration.php';
require_once 'Customweb/PostFinance/Util.php';


abstract class Customweb_PostFinance_AbstractAdapter implements Customweb_PostFinance_IAdapter {
	
	/**
	 * Configuration object.
	 *
	 * @var Customweb_PostFinance_Configuration
	 */
	private $configuration;
	
	public function __construct(Customweb_Payment_IConfigurationAdapter $configurationAdapter) {
		$this->configuration = new Customweb_PostFinance_Configuration($configurationAdapter);
	}
	
	/**
	 * Returns the configuration object.
	 *
	 * @return Customweb_Payment_IBaseConfiguration
	 */
	public function getConfiguration() {
		return $this->configuration;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_IBaseAdapter::isTestMode()
	 */
	public function isTestMode() {
		return $this->getConfiguration()->isTestMode();
	}

	/**
	 * This method returns the base URL of OgoneDemo.
	 *          	 		    			 
	 * @return The base URL without any specifict intention.
	 */
	protected final function getBaseUrl() {
		// TODO: Should these URL's also be defined as constants in the interface?
		if($this->isTestMode()) {
			return 'https://e-payment.postfinance.ch/ncol/test/';
		}
		else {
			return 'https://e-payment.postfinance.ch/ncol/prod/';
		}
	}

	/**
	 * This method validates an incomming notification request from the payment service provider.
	 *
	 * @param array $responseParameters Key/value map of the parameter retunred by PostFinance.
	 * @return boolean Whether the notification is valid and not manipulated or not. True means it is valid.
	 */
	protected function validateResponse(array $responseParameters) {
		// TODO: Improve the validation of the additional parameters. // && $responseParameters['COMPLUS'] == sha1($responseParameters['PARAMPLUS'])
		
		if ((isset($responseParameters['SHASIGN']) && $responseParameters['SHASIGN'] == $this->calculateHashOut($responseParameters))
				) {  // && (isset($responseParameters['COMPLUS']) && true /* check here the response */ )
			return true;
		}
		else {
			return false;
		}
	}

	protected function sendMaintenanceRequest($parameters) {
		return $this->sendDirectRequest($this->getMaintenanceUrl(), $parameters);
	}
	
	protected function sendDirectRequest($url, $parameters) {
		$response = Customweb_PostFinance_Util::sendRequest($url, $parameters);
		$responseParameters = Customweb_PostFinance_Util::getXmlAttributes($response);
		
		// The request can not be validated, because the answer of PostFinance does not contain the
		// sha signature.
		if (!is_array($responseParameters) || count($responseParameters) <= 0) {
			throw new Exception(Customweb_I18n_Translation::__(
					'The server response was not valid. Response: @response',
					array('@response' => $response)
			));
		}
	
		return $responseParameters;
	}

	public final function calculateHashIn($parameters) {
		return Customweb_PostFinance_Util::calculateHash($parameters, 'IN', $this->getConfiguration());
	}

	public final function calculateHashOut($parameters) {
		return Customweb_PostFinance_Util::calculateHash($parameters, 'OUT', $this->getConfiguration());
	}

	protected function getPaymentPageUrl() {
		return $this->getBaseUrl() . self::URL_PAYMENT_PAGE;
	}

	protected function getDirectOrderUrl() {
		return $this->getBaseUrl() . self::URL_DIRECT_ORDER;
	}

	protected function getMaintenanceUrl() {
		return $this->getBaseUrl() . self::URL_MAINTENANCE;
	}

	protected function getHiddenAuthorizationUrl() {
		return $this->getBaseUrl() . self::URL_ALIAS_GATEWAY;
	}
	
	protected function setTransactionAuthorizationState(Customweb_PostFinance_Authorization_Transaction $transaction, $parameters) {
		
		// We supporte currently only the payment page with Alias Manager, hence we set this parameters only in case the payment page is active.
		if ($transaction->getAuthorizationMethod() == Customweb_Payment_Authorization_PaymentPage_IAdapter::AUTHORIZATION_METHOD_NAME) {
			
			// Set the display name for the alias and mark this transaction as a potential alias.
			if (isset($parameters['ALIAS']) && $transaction->getTransactionContext()->getAlias() !== null) {
				$displayName = $parameters['CARDNO'];
				if ($parameters['ED']) {
					$displayName .= ' (' . substr($parameters['ED'], 0, 2) . '/' . substr($parameters['ED'], 2, 4) . ')';
				}
				$transaction->setAliasForDisplay($displayName);
			}
		}
		
		$transaction->setPaymentId($parameters['PAYID']);
	
		switch($parameters['STATUS']) {
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_PROCESSING:
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_REQUESTED:
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_PROCESSED_MERCHANT:
				$transaction->authorize()->capture();
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_AUTHORISED:
				$transaction->authorize();
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_WAITING_FOR_CLIENT_PAYMENT:
				$transaction->authorize(Customweb_I18n_Translation::__('Waiting for client payment'));
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_ORDER_STORED:
				$transaction
				->authorize(Customweb_I18n_Translation::__('Order is stored, but not finally authorized or captured.'))
				->setAuthorizationUncertain();
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_STORED_WAITING_EXTERNAL_RESULT:
			case Customweb_PostFinance_IAdapter::STATUS_AUTHORISED_WAITING_EXTERNAL_RESULT:
				$transaction
				->authorize(Customweb_I18n_Translation::__('The authorization could not be completed, due to a delayed external validation of the payment.'))
				->setAuthorizationUncertain();
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_AUTHORISED_NOT_KNOWN:
				$transaction
				->authorize(Customweb_I18n_Translation::__('The result of the authorization is not known.'))
				->setAuthorizationUncertain();
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_UNCERTAIN:
				$transaction
				->authorize(Customweb_I18n_Translation::__('The payment could not be authorized, because it is not certain.'))
				->setAuthorizationUncertain();
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_IN_PROGRESS:
				$transaction
				->authorize(Customweb_I18n_Translation::__('The payment is not finished. Hence it must be manually checked.'))
				->setAuthorizationUncertain();
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_AUTHORISED_WAITING:
				$transaction
				->authorize(Customweb_I18n_Translation::__('The acquiring system is not available. Hence the authorization is not completed.'))
				->setAuthorizationUncertain();
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_REFUSED:
				$reason = Customweb_I18n_Translation::__('The payment is refused.');
				$transaction->setAuthorizationFailed($reason);
				break;
					
			case Customweb_PostFinance_IAdapter::STATUS_PAYMENT_DECLINED_ACQUIRER:
				$reason = Customweb_I18n_Translation::__('The authorization declined by the aquirer.');
				$transaction->setAuthorizationFailed($reason);
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_AUTHORISATION_REFUSED:
				$reason = Customweb_I18n_Translation::__('The authorization is refused.');
				$transaction->setAuthorizationFailed($reason);
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_CANCELED_BY_CUSTOMER:
				$reason = Customweb_I18n_Translation::__('The transaction is cancelled.');
				$transaction->setAuthorizationFailed($reason);
				break;
	
			case Customweb_PostFinance_IAdapter::STATUS_INVALID:
			default:
				$reason = Customweb_I18n_Translation::__('The transaction failed due to a unkown reason.');
				if (isset($parameters['NCERROR']) && !empty($parameters['NCERROR'])) {
					$reason = $parameters['NCERROR'];
				}
				if (isset($parameters['NCERRORPLUS'])) {
					$reason .= ': ' . $parameters['NCERRORPLUS'];
				}
				$transaction->setAuthorizationFailed($reason);
				break;
		}
		
		// If the transaction is authorized, ensure the card is masked
		if ($transaction->isAuthorized()) {
			
			$params = $transaction->getDirectLinkCreationParameters();
			if (isset($params['CARDNO'])) {
				$cardNumber = $params['CARDNO'];
				$cleanedNumber = preg_replace('/[^0-9]*/', '', $cardNumber);
				if (strlen($cleanedNumber) > 4) {
					$params['CARDNO'] = str_repeat("X", 12) . substr($cleanedNumber, -4, 4);
					$transaction->setDirectLinkCreationParameters($params);
				}
			}
		}
	}
	
	
	
}