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

/**
 * The renderer interface allows the controling of the rendering process
 * of a elment. The different classes and prefix and postfixes can 
 * be set through the renderer.
 * 
 * @see Customweb_Form_Renderer
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Form_IRenderer {
	
	/**
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementLabel(Customweb_Form_IElement $element);
	
	/**
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @return string Resulting HTML
	 */
	public function renderControl(Customweb_Form_Control_IControl $control);
	
	/**
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @return string Resulting HTML
	 */
	public function renderControlPrefix(Customweb_Form_Control_IControl $control, $controlTypeClass);
	
	/**
	 * 
	 * @param Customweb_Form_Control_IControl $control
	 * @return string Resulting HTML
	 */
	public function renderControlPostfix(Customweb_Form_Control_IControl $control, $controlTypeClass);
	
	/**
	 * 
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementDescription(Customweb_Form_IElement $element);
	
	/**
	 * 
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementErrorMessage(Customweb_Form_IElement $element);
	
	/**
	 * 
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementPrefix(Customweb_Form_IElement $element);
	
	/**
	 * 
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderElementPostfix(Customweb_Form_IElement $element);
	
	/**
	 * 
	 * @param Customweb_Form_IElement[] $elements
	 * @return string Resulting HTML
	 */
	public function renderElements(array $elements);
	
	/**
	 *
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderOptionPrefix(Customweb_Form_Control_IControl $control, $optionKey);
	
	/**
	 *
	 * @param Customweb_Form_IElement $element
	 * @return string Resulting HTML
	 */
	public function renderOptionPostfix(Customweb_Form_Control_IControl $control, $optionKey);
	
	
	
}