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

library_load_class_by_name('Customweb_Payment_Authorization_Iframe_AbstractWrapper');
require_once 'IAdapter.php';

class PostFinanceCw_Adapter_IframeAdapterWrapper extends Customweb_Payment_Authorization_Iframe_AbstractWrapper implements PostFinanceCw_Adapter_IAdapter
{
	
	public function getCheckoutFormVaiables(PostFinanceCw_Transaction $dbTransaction, $failedTransaction) {
		$transaction = $dbTransaction->getTransactionObject();
		$embeddedIframe = false;
		$visibleFormFields = array();
		$iframe_url = NULL;
		$formData = array();
		$iframeHeight = 1000;
		if (isset($_POST['iframeSubmit'])) {
			$embeddedIframe = true;
			$formData = $_POST;
		}
		else {
			$visibleFormFields = $this->getVisibleFormFields(
				$transaction->getTransactionContext()->getOrderContext(),
				$transaction->getTransactionContext()->getAlias(),
				$failedTransaction,
				$dbTransaction->getTransactionObject()->getTransactionContext()->getPaymentCustomerContext()
			);
		}
		
		if (count($visibleFormFields) <= 0) {
			$embeddedIframe = true;
		}
		
		if ($embeddedIframe) {
			$iframe_url = $this->getIframeUrl($transaction, $formData);
			$iframeHeight = $this->getIframeHeight($transaction, $formData);
		}
		$dbTransaction->save();
		
		$html = '';
		if ($visibleFormFields !== null && count($visibleFormFields) > 0) {
			$renderer = new Customweb_Form_Renderer();
			$renderer->setCssClassPrefix('postfinancecw-');
			$html = $renderer->renderElements($visibleFormFields);
		}
		
		// TODO: May be use a different URL
		$formActionUrl = PostFinanceCwUtil::getPluginUrl("iframe.php", array('cw_transaction_id' => $dbTransaction->getTransactionId()));
		
		return array(
			'iframe_url' => $iframe_url,
			'form_action_url' => $formActionUrl,
			'visible_form' => $html,
			'template_file' => 'payment_confirmation_iframe',
			'iframe_height' => $iframeHeight,
		);
		
	}
	
	public function getReviewFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction) {
	
	}
	
}