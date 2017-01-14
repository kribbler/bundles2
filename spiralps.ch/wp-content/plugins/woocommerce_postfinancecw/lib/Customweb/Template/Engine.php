<?php 

class Customweb_Template_Engine {
	
	const CONTENT_TAG = '$$$PAYMENT ZONE$$$';
	
	private $templateBaseDir = null;
	private $layoutUrl = null;
	private $variables = array();
	private $defaultTemplateFolderName = 'default';
	private $customTemplateFolderNaem = 'custom';
	private $layoutContent = null;
	
	
	public function __construct($templateBaseDir, $layoutUrl) {
		$this->templateBaseDir = $templateBaseDir;
		$this->layoutUrl = $layoutUrl;
	}
	
	public function setVariable($key, $value) {
		$this->variables[$key] = $value;
	}
	
	public function getVariable($key) {
		if (isset($this->variables[$key])) {
			return $this->variables[$key];
		}
		else {
			return null;
		}
	}
	
	public function render($template) {
		$templateContent = $this->renderTemplate($template);
		$layout = $this->fetchLayout();
		
		return str_replace(self::CONTENT_TAG, $templateContent, $layout);
	}
	
	protected function renderTemplate($template) {
		$templateFilePath = $this->templateBaseDir . '/' . $this->customTemplateFolderNaem . '/' . $template . '.php';
		if (!file_exists($templateFilePath)) {
			$defaultTemplateFilePath = $this->templateBaseDir . '/' . $this->defaultTemplateFolderName . '/' . $template . '.php';
			if (!file_exists($defaultTemplateFilePath)) {
				throw new Exception(Customweb_I18n_Translation::__("Could not find template file at default location '!location'.", array(
					'!location' => $defaultTemplateFilePath,
				)));
			}
			else {
				$templateFilePath = $defaultTemplateFilePath;
			}
		}
		
		return $this->renderFile($templateFilePath);
	}
	
	protected function renderFile($filePath) {
		ob_start();
		extract($this->variables);
		require $filePath;
		return ob_get_clean();
	}
	
	protected function renderLayout() {
		$this->fetchLayout();
		
		
	}
	
	protected function fetchLayout() {
		if ($this->layoutContent === null) {
			$request = new Customweb_Http_Request($this->layoutUrl);
			$request->deactivateCertifcateAuthorityCheck();
			$request->setRedirectionFollowLimit(3);
			
			try {
				$response = $request->send();
			}
			catch(Exception $e) {
				throw new Exception(Customweb_I18n_Translation::__("Could not load layout from URL !url. Reason: !reason", array(
					'!url' => $this->layoutUrl,
					'!reason' => $e->getMessage()
				)));
			}
			
			$layoutHtml = $response->getBody();
			
			if (strstr($layoutHtml, self::CONTENT_TAG) === false) {
				throw new Exception(Customweb_I18n_Translation::__("The layout does not contain the tag '!layout_tag'.", array(
					'!layout_tag' => self::CONTENT_TAG
				)));
			}
			$this->layoutContent = $layoutHtml;
		}
		
		return $this->layoutContent;
	}
}