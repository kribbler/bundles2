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

require_once 'Customweb/Util/Rand.php';
require_once 'Customweb/Form/IElement.php';
require_once 'Customweb/Form/Intention/Factory.php';

/**
 * This element implementation provides the default methods for the 
 * interface  Customweb_Form_IElement.
 * 
 * @see Customweb_Form_IElement
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Element implements Customweb_Form_IElement{
	
	/**
	 * @var unknown_type
	 */
	private $control;
	
	/**
	 * @var string
	 */
	private $label;
	
	/**
	 * @var string
	 */
	private $elementId;
	
	/**
	 * @var string
	 */
	private $description = '';
	
	/**
	 * @var boolean
	 */
	private $required = true;
	
	/**
	 * @var Customweb_Form_Intention_IIntention
	 */
	private $intention = null;
	
	/**
	 * @var string
	 */
	private $errorMessage = null;
	
	/**
	 * 
	 * @param string $label The label of the element
	 * @param Customweb_Form_Control_IControl $control The control of the element.
	 * @param string $description [optional] The description of the elment.
	 */
	public function __construct($label, Customweb_Form_Control_IControl $control, $description = '') {
		$this->label = $label;
		$this->control = $control;
		$this->elementId = $control->getControlId() . '-element';
		$this->description = $description;
		$this->intention = Customweb_Form_Intention_Factory::getNullIntention();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getControl()
	 */
	public function getControl() {
		return $this->control;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getElementIntention()
	 */
	public function getElementIntention() {
		return $this->intention;
	}
	
	/**
	 * This method sets the element's intention.
	 * 
	 * @param Customweb_Form_Intention_IIntention $intention
	 * @return Customweb_Form_Element
	 */
	public function setElementIntention(Customweb_Form_Intention_IIntention $intention) {
		$this->intention = $intention;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getLabel()
	 */
	public function getLabel() {
		return $this->label;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getElementId()
	 */
	public function getElementId() {
		return $this->elementId;
	}
	
	public function setElementId($id) {
		$this->elementId = $id;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getDescription()
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Sets the element description
	 * 
	 * @param string $description
	 * @return Customweb_Form_Element
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::isRequired()
	 */
	public function isRequired() {
		return $this->required;
	}
	
	/**
	 * This method sets if the user must enter some data or not.
	 * 
	 * @param boolean $required
	 */
	public function setRequired($required) {
		$this->required = $required;
		if ($this->getControl() !== NULL) {
			$this->getControl()->setRequired($required);
		}
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getValidators()
	 */
	public function getValidators() {
		return $this->getControl()->getValidators();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::render()
	 */
	public function render(Customweb_Form_IRenderer $renderer) {
		$result = 
			$renderer->renderElementPrefix($this) .
			$renderer->renderElementLabel($this) . 
			$renderer->renderControl($this->getControl());
		
		$errorMessage = $this->getErrorMessage();
		if (!empty($errorMessage)) {
			$result .= $renderer->renderElementErrorMessage($this);
		}
		
		$desc = $this->getDescription();
		if (!empty($desc)) {
			$result .= $renderer->renderElementDescription($this);
		}
			
		$result .= $renderer->renderElementPostfix($this);
		
		return $result;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::getErrorMessage()
	 */
	public function getErrorMessage() {
		return $this->errorMessage;
	}
	
	/**
	 * This method sets the error message for this element.
	 * 
	 * @param string $message
	 * @return Customweb_Form_Element
	 */
	public function setErrorMessage($message) {
		$this->errorMessage = $message;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::applyControlCssResolver()
	 */
	public function applyControlCssResolver(Customweb_Form_IControlCssClassResolver $resolver) {
		$this->getControl()->applyCssResolver($resolver, $this);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_IElement::applyNamespacePrefix()
	 */
	public function applyNamespacePrefix($prefix) {
		$this->setElementId($prefix . $this->getElementId());
		$this->getControl()->applyNamespacePrefix($prefix);
	}
	
}