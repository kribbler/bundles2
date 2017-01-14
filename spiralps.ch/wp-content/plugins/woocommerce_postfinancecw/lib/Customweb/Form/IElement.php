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

require_once 'Customweb/Form/Control/IControl.php';
require_once 'Customweb/Form/Intention/IIntention.php';

/**
 * The element represents a single item from a form. Where this item has a 
 * control. The control is the faciltiy where the user can do his input. 
 * 
 * @see Customweb_Form_Control_IControl
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Form_IElement {
	
	/**
	 * The control of this element
	 * 
	 * @return Customweb_Form_Control_IControl
	 */
	public function getControl();
	
	/**
	 * The translated label of the element.
	 * 
	 * @return string
	 */
	public function getLabel();
	
	/**
	 * The translated description of the element.
	 * 
	 * @return string
	 */
	public function getDescription();
	
	/**
	 * The message to show to the user which describs an error on the 
	 * element.
	 * 
	 * @return string Error message
	 */
	public function getErrorMessage();
	
	/**
	 * This method returns the intention of the elment. The intention
	 * describs the element. This can be used to provide different 
	 * renderings etc.
	 * 
	 * @return Customweb_Form_Intention_IIntention
	 */
	public function getElementIntention();
	
	/**
	 * The id of the element.
	 * 
	 * @return string
	 */
	public function getElementId();
	
	/**
	 * This method renders the given element to HTML.
	 * 
	 * @param Customweb_Form_IRenderer $renderer The renderer to use.
	 * @return string HTML
	 */
	public function render(Customweb_Form_IRenderer $renderer);
	
	/**
	 * Returns if the element requires any user input.
	 * 
	 * @return boolean True, when the user has to enter some data.
	 */
	public function isRequired();
	
	/**
	 * The list of validators assigned to this element.
	 * 
	 * @return Customweb_Form_Validator_IValidator[]
	 */
	public function getValidators();
	
	/**
	 * This method applies the given css class resolver on all the controls of this element.
	 * 
	 * @param Customweb_Form_IControlCssClassResolver $resolver
	 * @return void
	 */
	public function applyControlCssResolver(Customweb_Form_IControlCssClassResolver $resolver);
	
	/**
	 * This method applies the given namespace prefix on the element.
	 * 
	 * @param string $prefix
	 * @return void
	 */
	public function applyNamespacePrefix($prefix);
	
}