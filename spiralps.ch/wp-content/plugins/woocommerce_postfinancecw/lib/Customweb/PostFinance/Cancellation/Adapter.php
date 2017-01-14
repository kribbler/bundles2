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

require_once 'Customweb/Payment/Cancellation/IAdapter.php';
require_once 'Customweb/I18n/Translation.php';

require_once 'Customweb/PostFinance/AbstractAdapter.php';
require_once 'Customweb/PostFinance/Cancellation/CancellationParameterBuilder.php';
require_once 'Customweb/PostFinance/Util.php';


class Customweb_PostFinance_Cancellation_Adapter extends Customweb_PostFinance_AbstractAdapter
implements Customweb_Payment_Cancellation_IAdapter {
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_DirectLink_Cancellation_IAdapter::cancel()
	 */
	public function cancel(Customweb_Payment_Authorization_ITransaction $transaction) {
		
		// Check transaction state           	 		    			 
		$transaction->cancelDry();
		
		$builder = new Customweb_PostFinance_Cancellation_CancellationParameterBuilder($transaction, $this->getConfiguration());
		$parameters = $builder->buildParameters();

		$response = $this->sendMaintenanceRequest($parameters);
		
		$additionalMessage = '';
		switch($response['STATUS']) {

			case self::STATUS_CANCELED_REFUSED:
			case self::STATUS_INVALID:
			default:
				$detailedMessage = $response['NCERRORPLUS'];
				
				throw new Exception(Customweb_I18n_Translation::__(
					'The transaction could not be cancelled. Details: @details',
					array('@details' => $detailedMessage)
				));
			
			case self::STATUS_CANCELED:
			case self::STATUS_CANCELED_OK:
				$additionalMessage = '';
				break;
			
			case self::STATUS_CANCELED_WAITING:
			case self::STATUS_CANCELED_UNCERTAIN:
				$additionalMessage = Customweb_I18n_Translation::__('The cancellation is processed offline.');
				break;
		}
		
		$transaction->cancel($additionalMessage);
		return true;	
	}

}
