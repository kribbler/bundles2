<?php

function vc_module_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'scale' => '',
      'title' => '',
      'url' => '',
      'badge_text' => '',
      'badge_color' => '',
      
   ), $atts ) );
   
   $image_cropped = wp_get_attachment_image_src( $image, 'module' );
 
	$out = '';
	$no_scale = '';
	
	if($title){
		$title='<h3>'.$title.'</h3>';
	}
	
	if($badge_text){
		$badge_text='<span class="lpd-badge" style="background-color:'.$badge_color.';">'.$badge_text.'</span>';
	}
	
	if($title){
		$module_content='<div class="module_content"><table><tbody><tr><td style="vertical-align:middle">'.$title.'<div class="sep-border"></div></td></tr></tbody></table></div>';
	}
	
	if($scale){
		$no_scale=' module-no-scale';
	}
	
	$out .= '<a href="'.$url.'" class="lpd-module'.$no_scale.'">'.$badge_text.'<img alt="" class="img-responsive" src="'.$image_cropped[0].'">'.$module_content.'</a>';
	
    return $out;
}
add_shortcode( 'vc_module', 'vc_module_func' );


vc_map(array(
   "name" => __("Module", GETTEXT_DOMAIN),
   "base" => "vc_module",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image", GETTEXT_DOMAIN),
	      "param_name" => "image",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
    array(
      "type" => 'checkbox',
      "heading" => __("Thumbnail Scale", GETTEXT_DOMAIN),
      "param_name" => "scale",
      "description" => __("If selected, thumbnail scale will be disabled.", GETTEXT_DOMAIN),
      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
    ),
		array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", GETTEXT_DOMAIN),
			 "param_name" => "title",
			 "value" => __("LOREM IMSUM DOLOR", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link)", GETTEXT_DOMAIN),
			 "param_name" => "url",
			 "value" => __("#", GETTEXT_DOMAIN),
			 "description" => __("Module link.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Badge Text", GETTEXT_DOMAIN),
			 "param_name" => "badge_text",
			 "value" => __("", GETTEXT_DOMAIN),
			 "description" => __("Enter your content if you want to display your badget.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Badge Color", GETTEXT_DOMAIN),
			"param_name" => "badge_color",
			"value" => '#fdb813',
			"description" => __("Choose badge color.", GETTEXT_DOMAIN)
		)
   )
));

?>