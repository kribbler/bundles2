<?php 


class Customweb_I18n_LocalizableString {
	
	private $string = null;
	private $arguments = array();
	
	public function __construct($string, $args = array()) {
		$this->string = $string;
		$this->arguments = $args;
	}
	
	public function getUntranslatedString() {
		return $this->string;
	}
	
	public function getArguments() {
		return $this->arguments;
	}
	
	public function __toString() {
		return $this->toString();
	}
	
	public function toString() {
		return Customweb_I18n_Translation::__($this->string, $this->arguments);
	}
	
	
}