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

require_once 'Customweb/Form/IRenderer.php';

/**
 * This class is a default implementation of the Customweb_Form_IRenderer interface.
 * It provides options to configure the behaviour at a certain degree. If more
 * should be changed this class should be subclassed.
 * 
 * @see Customweb_Form_IRenderer
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Renderer implements Customweb_Form_IRenderer{
	
	private $cssClassPrefix = '';
	private $elementClass = 'control-group';
	private $elementLabelClass = 'control-label';
	private $controlClass = 'controls';
	private $elementDescriptionClass = 'description';
	private $optionClass = 'option';
	private $elementErrorClass = 'element-error';
	private $errorMessageClass = 'error';
	private $addJs = true;
	private $controlCssClassResolver = NULL;
	private $namespacePrefix = NULL;
	private $renderOnLoadJs = true;
	
	
	/**
	 * @param Customweb_Form_IControlCssClassResolver $resolver
	 * @return Customweb_Form_Renderer
	 */
	public function setControlCssClassResolver(Customweb_Form_IControlCssClassResolver $resolver) {
		$this->controlCssClassResolver = $resolver;
		return $this;
	}
	
	/**
	 * @return Customweb_Form_IControlCssClassResolver
	 */
	public function getControlCssClassResolver() {
		return $this->controlCssClassResolver;
	}
	
	public function isAddJs() {
		return $this->addJs;
	}
	
	public function setAddJs($addJs) {
		$this->addJs = $addJs;
		return $this;
	}
	
	public function getCssClassPrefix() {
		return $this->cssClassPrefix;
	}
	
	public function setCssClassPrefix($prefix) {
		$this->cssClassPrefix = $prefix;
		return $this;
	}
	
	public function getElementCssClass() {
		return $this->elementClass;
	}
	
	public function setElementCssClass($elementClass) {
		$this->elementClass = $elementClass;
		return $this;
	}
	
	public function getElementLabelCssClass() {
		return $this->elementLabelClass;
	}
	
	public function setElementLabelCssClass($class) {
		$this->elementLabelClass = $class;
		return $this;
	}
	
	public function getControlCssClass() {
		return $this->controlClass;
	}
	
	public function setControlCssClass($class) {
		$this->controlClass = $class;
		return $this;
	}
	
	public function getOptionCssClass() {
		return $this->optionClass;
	}
	
	public function setOptionCssClass($class) {
		$this->optionClass = $class;
		return $this;
	}
	
	public function getDescriptionCssClass() {
		return $this->elementDescriptionClass;
	}
	
	public function setDescriptionCssClass($class) {
		$this->elementDescriptionClass = $class;
		return $this;
	}
	
	public function getElementErrorCssClass() {
		return $this->elementErrorClass;
	}
	
	public function setElementErrorCssClass($class) {
		$this->elementErrorClass = $class;
		return $this;
	}
	
	public function getErrorMessageCssClass() {
		return $this->errorMessageClass;
	}
	
	public function setErrorMessageCssClass($class) {
		$this->errorMessageClass = $class;
		return $this;
	}
	
	public function setNamespacePrefix($prefix) {
		$prefix = strip_tags($prefix);
		if (preg_match('/[^0-9a-zA-Z_]+/', $prefix)) {
			throw new Exception("The namespace prefix ('$prefix') can only contains A-Z, a-z, 0-9 and underscore (_) chars.");
		}
		$this->namespacePrefix = $prefix;
		return $this;
	}
	
	public function getNamespacePrefix() {
		return $this->namespacePrefix;
	}
	
	public function renderElementLabel(Customweb_Form_IElement $element) {
		$for = '';
		if ($element->getControl() != null && $element->getControl()->getControlId() !== null &&
				 $element->getControl()->getControlId() != '') {
			$for = $element->getControl()->getControlId();
		}
		$label = $element->getLabel();
		if ($element->isRequired()) {
			$label .= $this->renderRequiredTag($element);
		}
		
		return $this->renderLabel($for, $label, $this->getCssClassPrefix() . $this->getElementLabelCssClass());
	}
	
	protected function renderRequiredTag(Customweb_Form_IElement $element) {
		return '<span class="' . $this->getCssClassPrefix() . 'required">*</span>';
	}
	
	protected function renderLabel($referenceTo, $label, $class) {
		$for = '';
		if (!empty($referenceTo)) {
			$for = ' for="' . $referenceTo . '" ';
		}
		return '<label class="' . $class . '" ' . $for . '>' . $label . '</label>';
	}
	
	public function renderControl(Customweb_Form_Control_IControl $control) {
		return $control->render($this);
	}
	
	public function renderElementDescription(Customweb_Form_IElement $element) {
		return '<div class="' . $this->getCssClassPrefix() . $this->getDescriptionCssClass() . '">' . $element->getDescription() . '</div>';
	}
	public function renderElementErrorMessage(Customweb_Form_IElement $element) {
		return '<div class="' . $this->getCssClassPrefix() . $this->getErrorMessageCssClass() . '">' . strip_tags($element->getErrorMessage()) . '</div>';
	}
	
	public function renderElementPrefix(Customweb_Form_IElement $element) {
		$classes = $this->getCssClassPrefix() . $this->getElementCssClass();
		$classes .= ' ' . $this->getCssClassPrefix() . $element->getElementIntention()->getCssClass();

		$errorMessage = $element->getErrorMessage();
		if (!empty($errorMessage)) {
			$classes .= ' ' . $this->getCssClassPrefix() . $this->getElementErrorCssClass();
		}
		
		return '<div class="' . $classes . '" id="' . $element->getElementId() . '">';
	}
	
	
	public function renderElementPostfix(Customweb_Form_IElement $element) {
		return '</div>';
	}
	
	public function renderControlPrefix(Customweb_Form_Control_IControl $control, $controlTypeClass) {
		return '<div class="'. $this->getCssClassPrefix() . $this->getControlCssClass() . ' ' . $this->getCssClassPrefix() . $controlTypeClass . '" id="' . $control->getControlId() . '-wrapper">';
	}
	
	public function renderControlPostfix(Customweb_Form_Control_IControl $control, $controlTypeClass) {
		return '</div>';
	}
	public function renderOptionPrefix(Customweb_Form_Control_IControl $control, $optionKey) {
		return '<div class="' . $this->getCssClassPrefix() . $this->getOptionCssClass() . '" id="' . $control->getControlId() . '-' . $optionKey . '-key">';
	}
	
	public function renderOptionPostfix(Customweb_Form_Control_IControl $control, $optionKey) {
		return '</div>';
	}
	
	public function renderElements(array $elements) {
		$result = '';
		foreach($elements as $element) {
			if ($this->getNamespacePrefix() !== NULL) {
				$element->applyNamespacePrefix($this->getNamespacePrefix());
			}
			
			if ($this->getControlCssClassResolver() !== NULL) {
				$element->applyControlCssResolver($this->getControlCssClassResolver());
			}
			$result .= $element->render($this);
		}
		
		if ($this->isAddJs()) {
			$result .= '<script type="text/javascript">' . "\n";
			$result .= $this->renderValidatorCallbacks($elements);
			$result .= $this->renderOnLoadJs();
			$result .= "\n</script>";
		}
		
		return $result;
	}
	
	protected function renderValidatorCallbacks(array $elements) {
		$js = "
		function getFormElement(obj) {
			var obj_parent = obj.parentNode;
			if (!obj_parent) return false;
			if (obj_parent.tagName.toLowerCase() == 'form') { return obj_parent; }
			else { return getFormElement(obj_parent); }
		}
				
		function stopEvent(e) {
			if ( e.stopPropagation ) { e.stopPropagation(); }
			e.cancelBubble = true;
			if ( e.preventDefault ) { e.preventDefault(); } else { e.returnValue = false; }
			return false;
		}
		
		function addValidator( id, fn ) { 
			type = 'submit';
			formObj = getFormElement(document.getElementById(id));
			if ( formObj.attachEvent ) {  
				formObj['e'+type+fn] = fn; 
				formObj[type+fn] = function(){formObj['e'+type+fn]( window.event );} 
				formObj.attachEvent( 'onsubmit', formObj[type+fn] ); 
			} else { 
				formObj.addEventListener( 'submit', fn, false ); 
			}
		}
		\n";
		
		$prefix = '';
		
		if ($this->getNamespacePrefix() !== NULL) {
			$prefix = $this->getNamespacePrefix();
		}
	
		$js .= $prefix . 'validatePaymentFormElements = function () {
				var validators = new Array();
				';
		$validatorAdded = false;
		foreach($elements as $element) {
			foreach ($element->getValidators() as $validator) {
				$id = $validator->getControl()->getControlId();
				$js .= 'validators.push(function () {';
				// Create Callback function:
				$js .= ' var el = document.getElementById("' . $id . '"); 
						 var callback = ' . $validator->getCallbackJs() . ';';
				// Invoke callback
				$js .= 'return callback(el);';
				$js .= '}); 
						';
				$validatorAdded = true;
			}
		}
		
		$js .= 'for(var i=0; i < validators.length; i++){
					var f = validators[i];
					var res = f();
					if(res == false){
						return false;	
					}
				}};';
	
		$js .= '
		var ' . $prefix . 'registerValidatorCallbacks = function () { ';
		
		// Attach the validators only in case there is at least one validator added to the form.
		if ($validatorAdded) {
			$js .= 'addValidator("' . $id . '", function (e){if(' . $prefix . 'validatePaymentFormElements()==false){stopEvent(e)}}); ';
		}
		
		$js .= '}; ';
	
		return $js;
	}
	
	protected function renderOnLoadJs() {
		if(!$this->isRenderOnLoadJs()){
			return "";
		}
		$prefix = '';
		if ($this->getNamespacePrefix() !== NULL) {
			$prefix = $this->getNamespacePrefix();
		}
		
		// In case the window is already loaded
		$js = 'if (document.readyState == "complete") {	' . $prefix . 'registerValidatorCallbacks(); } ';
		
		// In case the browser supports addEventListener
		$js .= ' else if (window.addEventListener) { window.addEventListener("load", ' . $prefix . 'registerValidatorCallbacks, false); }';
		
		// In case the browse is a old IE
		$js .= ' else if (window.attachEvent) {	window.attachEvent("onload", ' . $prefix . 'registerValidatorCallbacks); }';
		
		// In case nothing else works as the window.onload method
		$js .= ' else { window.onload = ' . $prefix . 'registerValidatorCallbacks; }';
		
		return $js;
	}
	
	/**
	 * Should the onLoad Javascript code be rendered?. The default is 
	 * true, which means that the validator callbacks are registered. Depending
	 * on the context the form renderer is used, this might not be the desired behavior. 
	 * In those cases child classes migth override this method to return false. 
	 */
	protected function isRenderOnLoadJs(){
		return $this->renderOnLoadJs;
	}
	
	
	public function setRenderOnLoadJs($load) {
		$this->renderOnLoadJs = $load;
		return $this;
	}
	
}