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

require_once 'Customweb/Payment/Refund/IAdapter.php';
require_once 'Customweb/I18n/Translation.php';

require_once 'Customweb/PostFinance/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Refund/RefundParameterBuilder.php';
require_once 'Customweb/PostFinance/Util.php';

class Customweb_PostFinance_Refund_Adapter extends Customweb_PostFinance_AbstractAdapter
implements Customweb_Payment_Refund_IAdapter {

	
	/**
	 * (non-PHPdoc)          	 		    			 
	 * @see Customweb_Payment_Refund_IAdapter::partialRefund()
	 */
	public function partialRefund(Customweb_Payment_Authorization_ITransaction $transaction, $amount, $close) {
		
		// Check transaction state
		$transaction->refundDry($amount, $close);
		
		$builder = new Customweb_PostFinance_Refund_RefundParameterBuilder($transaction, $this->getConfiguration(), $amount, $close);
		$parameters = $builder->buildParameters();
	
		$response = $this->sendMaintenanceRequest($parameters);
	
		$additionalMessage = '';
		switch($response['STATUS']) {
			case self::STATUS_REFUND:
				$additionalMessage = '';
				break;
	
			case self::STATUS_REFUND_UNCERTAIN:
				$additionalMessage = Customweb_I18n_Translation::__('The refund is in uncertain.');
				break;
	
			case self::STATUS_REFUND_PENDING:
			case self::STATUS_REFUND_PROCESSED_MERCHANT:
				$additionalMessage = Customweb_I18n_Translation::__('The refund is in progress.');
				break;
	
			case self::STATUS_REFUND_REFUSED:
			case self::STATUS_REFUND_DECLINED_ACQUIRER:
			case self::STATUS_INVALID:
			default:
				$detailedMessage = $response['NCERRORPLUS'];
				throw new Exception(Customweb_I18n_Translation::__(
						'The transaction could not be refunded. Details: @details',
						array('@details' => $detailedMessage)
				));
		}
	
		$transaction->refund($amount, $close, $additionalMessage);
	
		return true;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Refund_IAdapter::refund()
	 */
	public function refund(Customweb_Payment_Authorization_ITransaction $transaction) {
		return $this->partialRefund($transaction, $transaction->getCapturedAmount());
	}
	
}

