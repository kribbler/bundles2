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

require_once dirname(dirname(__FILE__)) . '/classes/PaymentMethod.php'; 

class PostFinanceCw_PostFinanceCard extends PostFinanceCw_PaymentMethod
{
	public $machineName = 'postfinancecard';
	public $admin_title = 'PostFinance Card';
	public $title = 'PostFinance Card';
	
	public function __construct() {
		$this->icon = apply_filters(
			'woocommerce_postfinancecw_postfinancecard_icon', 
			PostFinanceCwUtil::getAssetsUrl('icons/postfinancecard.png')
		);
		parent::__construct();
	}
	
	public function createMethodFormFields() {
		$formFields = parent::createMethodFormFields();

		$methodSettings = array(
			'capturing' => array(
				'title' => __("Capturing", 'woocommerce_postfinancecw'),
 				'default' => 'direct',
 				'description' => __("Should the amount be captured automatically after the order (direct) or should the amount only be reserved (deferred)?", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
					'direct' => __("Directly after order", 'woocommerce_postfinancecw'),
 					'deferred' => __("Deferred", 'woocommerce_postfinancecw'),
 				),
 			),
 			'status_authorized' => array(
				'title' => __("Authorized Status", 'woocommerce_postfinancecw'),
 				'default' => 'processing',
 				'description' => __("This status is set, when the payment was successfull and it is authorized.", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
				),
 				'is_order_status' => true,
 			),
 			'status_uncertain' => array(
				'title' => __("Uncertain Status", 'woocommerce_postfinancecw'),
 				'default' => 'on-hold',
 				'description' => __("You can specify the order status for new orders that have an uncertain authorisation status.", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
				),
 				'is_order_status' => true,
 			),
 			'status_cancelled' => array(
				'title' => __("Cancelled Status", 'woocommerce_postfinancecw'),
 				'default' => 'cancelled',
 				'description' => __("You can specify the order status when an order is cancelled.", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_postfinancecw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_captured' => array(
				'title' => __("Captured Status", 'woocommerce_postfinancecw'),
 				'default' => 'no_status_change',
 				'description' => __("You can specify the order status for orders that are captured either directly after the order or manually in the backend.", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_postfinancecw'),
 				),
 				'is_order_status' => true,
 			),
 			'authorizationMethod' => array(
				'title' => __("Authorization Method", 'woocommerce_postfinancecw'),
 				'default' => 'PaymentPage',
 				'description' => __("Select the authorization method to use for processing this payment method.", 'woocommerce_postfinancecw'),
 				'type' => 'select',
 				'options' => array(
					'PaymentPage' => __("Payment Page", 'woocommerce_postfinancecw'),
 				),
 			),
 		);
		
		return array_merge(
			$formFields,
			$methodSettings
		);
	}
	
}