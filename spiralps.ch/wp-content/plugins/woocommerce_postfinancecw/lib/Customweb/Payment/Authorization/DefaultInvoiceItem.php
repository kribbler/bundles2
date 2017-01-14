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

require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';

/**
 * Default implementation for an invoice item.
 * 
 * @author Severin Klingler
 *
 */
class Customweb_Payment_Authorization_DefaultInvoiceItem implements Customweb_Payment_Authorization_IInvoiceItem{
	
	private $sku;
	private $name;
	private $taxRate;
	private $quantity;
	private $amountIncludingTax;
	
	public function __construct($sku, $name, $taxRate, $amountIncludingTax, $quantity = 1 , $type = self::TYPE_PRODUCT){
		$this->sku = $sku;
		$this->name = $name;
		$this->taxRate = $taxRate;
		$this->amountIncludingTax = $amountIncludingTax;
		$this->quantity = $quantity;
		$this->type = $type;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getSku()
	 */
	public function getSku()
	{
		return $this->sku;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getName()
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getTaxRate()
	 */
	public function getTaxRate(){
		return $this->taxRate;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getQuantity()
	 */
	public function getQuantity(){
		return $this->quantity;
	}
	
	/**
	 * (non-PHPdoc)           	 		    			 
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getAmountIncludingTax()
	 */
	public function getAmountIncludingTax()
	{
		return $this->amountIncludingTax;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getAmountExcludingTax()
	 */
	public function getAmountExcludingTax() {
		return $this->getAmountIncludingTax() / ($this->getTaxRate()/100 + 1);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getTaxAmount()
	 */
	public function getTaxAmount() {
		return $this->getAmountIncludingTax() - $this->getAmountExcludingTax();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Payment_Authorization_IInvoiceItem::getType()
	 */
	public function getType(){
		return $this->type;
	}
}