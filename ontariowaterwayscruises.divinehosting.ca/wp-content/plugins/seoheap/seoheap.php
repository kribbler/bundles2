<?php
/*
Plugin Name: SEOHeap
Plugin URI: http://www.seoheap.com/
Description: Functions commonly used for custom functions developed by SEOHeap.com
Author: James Cantrell
Version: 1.0.0
Author URI: http://www.seoheap.com/
*/

include_once dirname(__FILE__).'/global.php';
include_once dirname(__FILE__).'/seoheap_class.php';

function handleseoheapfunctions() {
	if ($c=req('seoheap')) {
		switch ($c) {
			case 'uploadframe':
				include dirname(__FILE__).'/upload/upload.php';
				exit;
		}
	}
}
add_action('init', 'handleseoheapfunctions');

function add_plugin_meta_boxes() {  
   // add_meta_box('wp_seoheap_plugin','Plugins','wp_seoheap_plugin','page','side');
}
add_action('add_meta_boxes', 'add_plugin_meta_boxes');

function wp_seoheap_plugin($post) {  
	/*
    wp_nonce_field(plugin_basename(__FILE__), 'wp_seoheap_plugin_nonce');  
	$plug = get_post_meta($post->ID, 'wp_seoheap_plugin', true);
    echo '<p class="description">Comma separated list of plugins</p>';  
    echo '<input type="text" id="wp_seoheap_plugin" name="wp_seoheap_plugin" value="',htmlq($plug),'" size="25">';  

    wp_nonce_field(plugin_basename(__FILE__), 'wp_seoheap_hidethumb_nonce');  
	$plug = get_post_meta($post->ID, 'wp_seoheap_hidethumb', true);
    echo '<p><label><input type="hidden" name="wp_seoheap_hidethumb"/><input type="checkbox" name="wp_seoheap_hidethumb" value="1"',(($plug ? ' checked="checked"' : '')),'/> Hide Thumb</label></p>';  
	*/
}
function save_custom_plugin_meta_data($id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {  
		return $id;  
    }
	$meta=array();
	foreach ($_POST as $k=>$a) {
		if (substr($k,0,11)=='wp_seoheap_') {
			if (isset($_POST[$k.'_nonce']) && wp_verify_nonce($_POST[$k.'_nonce'], plugin_basename(__FILE__))) {
				if('page' == $_POST['post_type']) { // TODO: need to check post type
					if(current_user_can('edit_page', $id)) {
						$meta[$k]=is_array($a) ? posta($k) : post($k);
					}
				}
			}
		}
	}
	if (!$meta)
		return $id;
	foreach ($meta as $k=>$a) {
    	delete_post_meta($id,$k);  
		add_post_meta($id,$k,is_array($a) ? json_encode($a) : $a);  
	}
}
add_action('save_post', 'save_custom_plugin_meta_data');  
add_action('wp_head', 'load_page_plugins');

add_theme_support('post-thumbnails');

function load_page_plugins() {
	if (!is_page())
		return;
	$p=get_post_meta(get_the_ID(), 'wp_custom_plugin', true);
	$p=explode(',',$p);
	foreach ($p as $a) {
		$a=trim($a);
		if (!$a)
			continue;
		plugin($a);	
	}
}
/*
wp_register_script('sharethis_global','//w.sharethis.com/button/buttons.js',array(),1,true);
wp_register_script('sharethis','/wp-content/plugins/seoheap/plugins/sharethis/sharethis.js',array('sharethis_global'),1,true);
wp_localize_script('sharethis', 'sharethis_options',array(
	'publisher'=>"ed36603e-b74d-4e0a-939b-90c9f643230d",
	'doNotHash'=>false,
	'doNotCopy'=>false,
	'hashAddressBar'=>false
));
*/

function span_func($instance,$content='',$tag) {
	$content = apply_filters('the_content',trim($content,"\r\n 	"));
	return '<div class="'.htmlq($tag).'">'.$content.'</div>';
}
add_shortcode('row','span_func');
add_shortcode('span1','span_func');
add_shortcode('span2','span_func');
add_shortcode('span3','span_func');
add_shortcode('span4','span_func');
add_shortcode('span5','span_func');
add_shortcode('span6','span_func');
add_shortcode('span7','span_func');
add_shortcode('span8','span_func');
add_shortcode('span9','span_func');
add_shortcode('span10','span_func');
add_shortcode('span11','span_func');
add_shortcode('span12','span_func');

function youtube_func($attrs) {
	$width='100%';
	$height=300;
	extract($attrs);
	if (isset($attrs['url']))
		$id=youtubeid($attrs['url']);
	if (!$id)
		return '';
	$ret='<div class="youtube_iframe">';
	$ret.='<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe>';
	$ret.='</div>';
	return $ret;
}
add_shortcode('youtube','youtube_func');


