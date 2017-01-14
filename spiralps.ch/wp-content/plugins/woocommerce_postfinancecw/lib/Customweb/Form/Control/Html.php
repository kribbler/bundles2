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
 * This class provides a control, which does simply output the given
 * HTML string. This is useful if you want to provide information for
 * the user, but you do not want to collect any information.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Form_Control_Html extends Customweb_Form_Control_Abstract {

	/**
	 * @var Customweb_Form_Control_IControl[]
	 */
	private $htmlContent = '';

	/**
	 * Constructor.
	 * 
	 * @param string $controlName Name of the control
	 * @param string $htmlContent HTML content to show
	 */
	public function __construct($controlName, $htmlContent) {
		parent::__construct($controlName);
		if (is_string($htmlContent)) {
			$this->htmlContent = new Customweb_I18n_LocalizableString($htmlContent);
		}
		elseif($htmlContent instanceof Customweb_I18n_LocalizableString) {
			$this->htmlContent = $htmlContent;
		}
		
	}

	/**
	 * Returns the HTML content to show.
	 * 
	 * @return Customweb_I18n_LocalizableString The translatable string
	 */
	public function getContent() {
		return $this->htmlContent;
	}

	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::renderContent()
	 */
	public function renderContent(Customweb_Form_IRenderer $renderer) {
		return $this->getContent();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Customweb_Form_Control_Abstract::getControlTypeCssClass()
	 */
	public function getControlTypeCssClass() {
		return 'html-field';
	}
	

}