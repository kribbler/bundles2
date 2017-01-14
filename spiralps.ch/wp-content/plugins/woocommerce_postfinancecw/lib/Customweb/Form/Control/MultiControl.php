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

require_once 'Customweb/Form/Control/Abstract.php';

/**
 * This control implementation allows the rendering of multiple controls 
 * within one control. This allows the presentation of mulitple input fields
 * per element.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_MultiControl extends Customweb_Form_Control_Abstract {

	/**
	 * @var Customweb_Form_Control_IControl[]
	 */
	private $controls = array();

	/**
	 * Constructor
	 * 
	 * @param string $controlName
	 * @param array $controls Subcontrols
	 */
	public function __construct($controlName, array $controls) {
		parent::__construct($controlName);
		$this->controls = $controls;
	}

	/**
	 * This method returns the list of subcontrols assigned to this 
	 * control.
	 * 
	 * @return Customweb_Form_Control_IControl[]
	 */
	public function getSubControls() {
		return $this->controls;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::renderContent()
	 */
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		$result = '';
		$result .= '<div id="' . $this->getControlId() . '" class="' . $this->getCssClass() . '">';
		foreach ($this->getSubControls() as $control) {
			$result .= $renderer->renderControl($control);
		}
		$result .= '</div>';
		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::getControlTypeCssClass()
	 */
	public function getControlTypeCssClass() {
		return 'multi-control';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_IControl::applyCssResolver()
	 */
	public function applyCssResolver(Customweb_Form_IControlCssClassResolver $resolver, Customweb_Form_IElement $element) {
		$this->setCssClass($resolver->resolveClass($this, $element));
		foreach ($this->getSubControls() as $control) {
			$control->setCssClass($resolver->resolveClass($control, $element));
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_IControl::applyNamespacePrefix()
	 */
	public function applyNamespacePrefix($prefix) {
		parent::applyNamespacePrefix($prefix);
		foreach ($this->getSubControls() as $control) {
			$control->applyNamespacePrefix($prefix);
		}
	}
	
	
}