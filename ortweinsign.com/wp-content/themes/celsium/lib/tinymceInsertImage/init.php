<?php

/**
* Editor Button
*/
class Editor_Insertimages
{
	private $plugin_name = 'afl_insert_image';
	private $path = '';
	
	public function __construct()
	{
		$this->path = get_template_directory_uri() . '/lib/tinymceInsertImage/';
		add_action('init', array(&$this, 'add_buttons'));
	}
	
	public function add_buttons() {
		if (!current_user_can('edit_posts') && ! current_user_can('edit_pages')){
			return FALSE;
		}
		if (get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', array(&$this, 'add_plugin'), 5);
			add_filter('mce_buttons', array(&$this, 'reg_button'), 5);
			add_filter('mce_external_languages', array (&$this, 'add_langs_path'));
		}
	}

	public function reg_button($buttons){
		array_push($buttons, 'separator', $this->plugin_name);
		return $buttons;
	}

	public function add_plugin($plugin_array) {
		$plugin_array[$this->plugin_name] = $this->path . 'editor_plugin.js';
		return $plugin_array;
	}
	
	public function add_langs_path($plugin_array) 
	{
		$plugin_array[$this->pluginname] = get_template_directory_uri() . '/tinymceInsertImage/langs.php';
		return $plugin_array;
	}
}

//if(strpos($_SERVER['PHP_SELF'], 'edit-composer-item.php')!==FALSE){
    $editor_button = new Editor_Insertimages();
//}


/**
* end of file
*/