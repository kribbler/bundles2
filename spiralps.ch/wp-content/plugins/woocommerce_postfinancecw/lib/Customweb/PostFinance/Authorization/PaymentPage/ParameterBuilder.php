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


class Customweb_PostFinance_Authorization_PaymentPage_ParameterBuilder extends Customweb_PostFinance_AbstractParameterBuilder {

	private $formData = array();

	public function __construct($transaction, Customweb_PostFinance_Configuration $configuration, $formData) {
		parent::__construct($transaction, $configuration);
		$this->formData = $formData;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_PostFinance_AbstractParameterBuilder::buildParameters()
	 */
	public function buildParameters() {
		$this->addShopIdToCustomParameters();

		$parameters = array_merge(
				$this->getLanguageParameter(),
				$this->getAmountParameter($this->getTransactionContext()->getOrderContext()->getOrderAmountInDecimals()),
				$this->getCurrencyParameter(),
				$this->getPspParameter(),
				$this->getOrderIdParameter(),
				$this->getOrigParameter(),
				$this->getCustomerParameters(),
				$this->getDeliveryAndInvoicingParameters(),
				$this->getAliasManagerParameters(),
				$this->getReactionUrlParameters(),
				$this->getParamPlusParameters(),
				$this->getTemplateParameter(),
				$this->getCapturingModeParameter(),
				$this->getPaymentMethod()->getAuthorizationParameters(
						$this->getTransaction(), 
						$this->formData, 
						$this->getTransaction()->getAuthorizationMethod()
					)
		);

		$this->addShaSignToParameters($parameters);

		return $parameters;
	}
	
	
	protected function getReactionUrlParameters() {
		return array(
				'ACCEPTURL' => $this->getSuccessUrl(),
				'DECLINEURL' => $this->getFailedUrl(),
				'EXCEPTIONURL' => $this->getFailedUrl(),
				'CANCELURL' => $this->getFailedUrl(),
				'BACKURL' => $this->getFailedUrl()
		);
	}
	
}