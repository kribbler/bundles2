<?php

function vc_new_button_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'text' => '',
      'link' => '',
      'type' => '',
      'size' => '',
      'display' => '',
      'align' => '',
      'styles' => ''
   ), $atts ) );
   	
   	$white="";	
   	
   	if($type=="primary"){
	   	$white='white';
   	}
   	
   	if($display=="table"){
	   	$display='display: table;';
   	}else{
	   	$display='display: inline-block;';
   	}
   	
   	if($align=="center"){
	   	$align='margin: 0 auto;';
   	} elseif($align=="right"){
	   	$align='margin: 0 0 0 auto;';
   	}else{
	   	$align='margin: 0;';
   	}
   
    return '<a class="btn btn-vc btn-'. $type .' btn-'. $size .' '. $white .'" href="'. $link .'" style="'. $display .''. $align .''. $styles .'">'. $text .'</a>';
}
add_shortcode( 'vc_new_button', 'vc_new_button_func' );

vc_map(array(
   "name" => __("LPD Button", GETTEXT_DOMAIN),
   "base" => "vc_new_button",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Text", GETTEXT_DOMAIN),
			 "param_name" => "text",
			 "value" => __("Text on the button", GETTEXT_DOMAIN),
			 "description" => __("Text on the button.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link)", GETTEXT_DOMAIN),
			 "param_name" => "link",
			 "value" => __("#", GETTEXT_DOMAIN),
			 "description" => __("Button link.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Type", GETTEXT_DOMAIN),
			"param_name" => "type",
			"value" => array(__('Default', GETTEXT_DOMAIN) => "default", __('Primary', GETTEXT_DOMAIN) => "primary", __('Warning', GETTEXT_DOMAIN) => "warning"),
			"description" => __("Select type of the button.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Size", GETTEXT_DOMAIN),
			"param_name" => "size",
			"value" => array(__('Large', GETTEXT_DOMAIN) => "lg", __('Medium', GETTEXT_DOMAIN) => "medium", __('Small', GETTEXT_DOMAIN) => "sm", __('Extra Small', GETTEXT_DOMAIN) => "xs"),
			"description" => __("Select size of the button.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Display", GETTEXT_DOMAIN),
			"param_name" => "display",
			"value" => array(__('inline-block', GETTEXT_DOMAIN) => "inline-block", __('table', GETTEXT_DOMAIN) => "table"),
			"description" => __("Select display style of the button.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Align", GETTEXT_DOMAIN),
			"param_name" => "align",
			"value" => array(__('left', GETTEXT_DOMAIN) => "left",__('center', GETTEXT_DOMAIN) => "center", __('right', GETTEXT_DOMAIN) => "right"),
			"description" => __("Select button align.", GETTEXT_DOMAIN),
			"dependency" => Array('element' => "display", 'value' => array('table'))
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Custom Styles", GETTEXT_DOMAIN),
			 "param_name" => "styles",
			 "value" => '',
			 "description" => __("Custom Css styles.", GETTEXT_DOMAIN)
		)
   )
));


?>