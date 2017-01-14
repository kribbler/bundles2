<?php 

class Customweb_I18n_TranslatedString {
	
	private $translations = array();
	
	public function __construct($translations = array()) {
		$this->translations = $translations;
	}
	
	public function getTranslations() {
		return $this->translations;
	}
	
	public function getTranslation($languageCode) {
		if (isset($this->translations[$languageCode])) {
			return $this->translations[$languageCode];
		}
		else {
			return $this->__toString();
		}
	}
	
	public function __toString() {
		return current($this->translations);
	}
	
}