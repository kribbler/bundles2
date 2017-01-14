<?php

function mega_header_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'title_font_size' => '',
      'separator' => '',
      'description' => '',
      'description_font_size' => '',
      'sub_title' => '',
      'sub_title_font_size' => '',
      'sub_title_font_style' => '',
      'dark_bg' => '',
      'padding_top' => '',
      'padding_bottom' => '',
      'margin_top' => '',
      'margin_bottom' => '',
      'bg_color' => '',
   ), $atts ) );
   
   	$out = '';
   
   	if($dark_bg){
	   	$dark_bg = ' dark_bg';
   	}
   	
	$padding_top = 'padding-top:'.$padding_top.'px;';
	$padding_bottom = 'padding-bottom:'.$padding_bottom.'px;';

	$margin_top = 'margin-top:'.$margin_top.'px;';
	$margin_bottom = 'margin-bottom:'.$margin_bottom.'px;';
	
	$bg_color = 'background-color:'.$bg_color.';';

   	$out .= '<div class="mega_header'.$dark_bg.'" style='.$padding_top.''.$padding_bottom.''.$margin_top.''.$margin_bottom.''.$bg_color.'>';
   	
   	if($sub_title){
   		$out .= '<p class="sub-title" style="font-size:'.$sub_title_font_size.';font-style:'.$sub_title_font_style.';">'.$sub_title.'</p>';
   	}
   	
   	if($title){
   		$out .= '<h2 style="font-size:'.$title_font_size.';">'.$title.'</h2>';
   	}
   	
   	if($separator){
   		$out .= '<div class="deco-sep-line-'.$separator.'"></div>';
   	}
   	
   	if($description){
   		$out .= '<div class="mh_description" style="font-size:'.$description_font_size.';">'.$description.'</div>';
   	}
   	
    $out .= '</div>';
    
    return $out;		
    
}
add_shortcode( 'vc_mega_header', 'mega_header_func' );

vc_map(array(
   "name" => __("Mega Header", GETTEXT_DOMAIN),
   "base" => "vc_mega_header",
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
			 "value" => __("Lorem ipsum dolor", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Title Font Size", GETTEXT_DOMAIN),
			"param_name" => "title_font_size",
			"value" => array(
				"30px" => "30px",	
				"24px" => "24px",
				"18px" => "18px",		
			),
			"description" => __("Select title font size.", GETTEXT_DOMAIN)
		),	
		array(
			"type" => "dropdown",
			"heading" => __("Separator", GETTEXT_DOMAIN),
			"param_name" => "separator",
			"value" => array(		
__('none', GETTEXT_DOMAIN) => "",
__('50px', GETTEXT_DOMAIN) => "50",
__('100px', GETTEXT_DOMAIN) => "100",
__('150px', GETTEXT_DOMAIN) => "150",
__('200px', GETTEXT_DOMAIN) => "200",
			),
			"description" => __("Select icon.", GETTEXT_DOMAIN)
		),		
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Description", GETTEXT_DOMAIN),
			 "param_name" => "description",
			 "value" => "Lorem ipsum dolor",
			 "description" => __("Enter your description.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Description Font Size", GETTEXT_DOMAIN),
			"param_name" => "description_font_size",
			"value" => array(		
				"14px" => "14px",
				"16px" => "16px",
				"18px" => "18px",
			),
			"description" => __("Select description font size.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Sub-title", GETTEXT_DOMAIN),
			 "param_name" => "sub_title",
			 "value" => "",
			 "description" => __("Enter your sub-title.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Sub-title Font Size", GETTEXT_DOMAIN),
			"param_name" => "sub_title_font_size",
			"value" => array(
				"13px" => "13px",		
				"14px" => "14px",
				"16px" => "16px",
				"18px" => "18px",
			),
			"description" => __("Select sub-title font size.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Sub-title Font Style", GETTEXT_DOMAIN),
			"param_name" => "sub_title_font_style",
			"value" => array(
				__('normal', GETTEXT_DOMAIN) => "normal",
				__('italic', GETTEXT_DOMAIN) => "italic",
			),
			"description" => __("Select sub-title font style.", GETTEXT_DOMAIN)
		),		
		array(
			"type" => 'checkbox',
			"heading" => __("Dark Background", GETTEXT_DOMAIN),
			"param_name" => "dark_bg",
			"description" => __("Check, if you are using dark background.", GETTEXT_DOMAIN),
			"value" => Array(__("Dark Background", GETTEXT_DOMAIN) => 'enable')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Margin Top", GETTEXT_DOMAIN),
			 "param_name" => "margin_top",
			 "value" => '',
			 "description" => __("Margin top, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Margin Bottom", GETTEXT_DOMAIN),
			 "param_name" => "margin_bottom",
			 "value" => '',
			 "description" => __("Margin bottom, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Padding Top", GETTEXT_DOMAIN),
			 "param_name" => "padding_top",
			 "value" => '',
			 "description" => __("Padding top, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Padding Bottom", GETTEXT_DOMAIN),
			 "param_name" => "padding_bottom",
			 "value" => '',
			 "description" => __("Padding bottom, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color", GETTEXT_DOMAIN),
			"param_name" => "bg_color",
			"value" => '',
			"description" => __("Choose background color.", GETTEXT_DOMAIN)
		)
   )
));


?>