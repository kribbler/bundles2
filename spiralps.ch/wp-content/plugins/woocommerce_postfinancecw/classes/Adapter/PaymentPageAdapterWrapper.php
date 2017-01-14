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

library_load_class_by_name('Customweb_Payment_Authorization_PaymentPage_AbstractWrapper');
require_once 'IAdapter.php';

class PostFinanceCw_Adapter_PaymentPageAdapterWrapper extends Customweb_Payment_Authorization_PaymentPage_AbstractWrapper implements PostFinanceCw_Adapter_IAdapter
{

	public function getCheckoutFormVaiables(PostFinanceCw_Transaction $dbTransaction, $failedTransaction) {
		$transaction = $dbTransaction->getTransactionObject();

		$formActionUrl = PostFinanceCwUtil::getPluginUrl("redirection.php", array('cw_transaction_id' => $dbTransaction->getTransactionId()));

		$visibleFormFields = $this->getVisibleFormFields(
			$transaction->getTransactionContext()->getOrderContext(),
			$transaction->getTransactionContext()->getAlias(),
			$failedTransaction,
			$dbTransaction->getTransactionObject()->getTransactionContext()->getPaymentCustomerContext()
		);
		
		$html = '';
		if ($visibleFormFields !== null && count($visibleFormFields) > 0) {
			$renderer = new Customweb_Form_Renderer();
			$renderer->setCssClassPrefix('postfinancecw-');
			$html = $renderer->renderElements($visibleFormFields);
		}

		$dbTransaction->save();

		return array(
			'form_target_url' => $formActionUrl,
			'hidden_fields' => array(),
			'visible_fields' => $html,
			'template_file' => 'payment_confirmation',
		);
	}
	
	public function getReviewFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction) {
	
	}
	
}