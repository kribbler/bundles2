<?php

function vc_callout2_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'sep_word' => '',
      'bn_text' => '',
      'link' => '',
      'type' => '',
      'size' => '',
      'bg_color' => '',
   ), $atts ) );
   
   	$white="";
   	
   	if($type=="primary"){
	   	$white='white';
   	}

	$out = '';
	
	$out .= '<table class="vc_callout2"><tbody><tr><td class="callout2_title"><span style="background-color:'. $bg_color .'">'. $title .'</span></td><td class="callout2_sep_word"><span style="background-color:'. $bg_color .'">'. $sep_word .'</span></td><td class="callout2_btn"><a class="btn btn-vc btn-'. $type .' btn-'. $size .' '. $white .'" href="'. $link .'">'. $bn_text .'</a></td></tr></tbody></table>';
	
    return $out;
}
add_shortcode( 'vc_callout2', 'vc_callout2_func' );


vc_map(array(
   "name" => __("Callout2", GETTEXT_DOMAIN),
   "base" => "vc_callout2",
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
			 "heading" => __("Title", GETTEXT_DOMAIN),
			 "param_name" => "title",
			 "value" => __("LOREM IMSUM DOLOR SIT AMET", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Separate Word", GETTEXT_DOMAIN),
			 "param_name" => "sep_word",
			 "value" => __("OR", GETTEXT_DOMAIN),
			 "description" => __("Enter your separate word.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Text", GETTEXT_DOMAIN),
			 "param_name" => "bn_text",
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
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color", GETTEXT_DOMAIN),
			"param_name" => "bg_color",
			"value" => '#fff',
			"description" => __("Choose background color.", GETTEXT_DOMAIN)
		)

   )
));

?>