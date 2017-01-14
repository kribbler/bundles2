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


interface Customweb_Payment_Authorization_IInvoiceItem {

	const TYPE_SHIPPING = 'shipping';
	const TYPE_DISCOUNT = 'discount';
	const TYPE_PRODUCT = 'product';
	const TYPE_FEE = 'fee';
	
	/**
	 * The SKU of the invoice item.
	 *
	 * @return string SKU
	 */
	public function getSku();

	/**
	 * The (human readable) name of the invoice item.
	 *
	 * @return string name of the product / shipping name
	 */
	public function getName();

	/**
	 * Tax rate for the invoice item in percentage. A value of 19.3 means
	 * a tax rate 19.3%.
	 *
	 * @return double The tax rate in percentage.
	 */
	public function getTaxRate();

	/**
	 * Quantitiy of the invoice item.
	 *
	 * @return double Quantity
	 */
	public function getQuantity();

	/**
	 *  The total amount including the tax of the invoice item. The amount is always positive. Also in case
	 *  it is a discount!
	 *
	 *  @return double
	 */
	public function getAmountIncludingTax();
	
	/**
	 * The total amount excluding the tax. The amount is always positive. Also in case
	 * it is a discount!
	 */
	public function getAmountExcludingTax();
	
	/**
	 * The amount of tax of this line. It is the difference between getAmountIncludingTax() and getAmountExcludingTax()
	 */
	public function getTaxAmount();

	/**
	 * The type of the invoice item.
	 *
	 * @return TYPE_SHIPPING | TYPE_DISCOUNT | TYPE_PRODUCT
	 */
	public function getType();
}