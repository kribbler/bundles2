<?php

function vc_new_callout_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'layout' => '',
      'title' => '',	
      'bn_text' => '',
      'link' => '',
      'type' => '',
      'size' => ''
   ), $atts ) );
   
   	$white="";
   	
   	if($type=="primary"){
	   	$white='white';
   	}
   	
   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
 
	if($layout=="3414"){
		$content_layouts=" col-lg-9 col-md-9";
		$content_btn=" col-lg-3 col-md-3";
	}elseif($layout=="2313"){
		$content_layouts=" col-lg-8 col-md-8";
		$content_btn=" col-lg-4 col-md-4";
	}elseif($layout=="1212"){
		$content_layouts=" col-lg-6 col-md-6";
		$content_btn=" col-lg-6 col-md-6";
	}elseif($layout=="none"){
		$content_layouts=" col-lg-12 col-md-12";
	}
	
	if($content){
	   $sep_border = '<div class="sep-border"></div>';
   }
	
	$out = '';
    
	$out .= '<div class="callout"><div class="row"><div class="callout-content'. $content_layouts .'"><h4>'. $title .'</h4>'. $sep_border .''. $content .'</div>';
	
	if($layout!="none"){
		$out .= '<div class="callout-btn'. $content_btn .'"><table><tbody><tr><td style="vertical-align:middle"><a class="btn btn-vc btn-'. $type .' btn-'. $size .' '. $white .'" href="'. $link .'">'. $bn_text .'</a></td></tr></tbody></table></div>';
	}
	
	$out .= '</div></div>';
	
	return $out;
    
    
}
add_shortcode( 'vc_new_callout', 'vc_new_callout_func' );

vc_map(array(
   "name" => __("Callout", GETTEXT_DOMAIN),
   "base" => "vc_new_callout",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
  		array(
			"type" => "dropdown",
			"heading" => __("Layouts", GETTEXT_DOMAIN),
			"param_name" => "layout",
			"value" => array(__('3/4-1/4', GETTEXT_DOMAIN) => "3414", __('2/3-1/3', GETTEXT_DOMAIN) => "2313", __('1/2-1/2', GETTEXT_DOMAIN) => "1212", __('full width', GETTEXT_DOMAIN) => "none"),
			"description" => __("Select type of the button.", GETTEXT_DOMAIN)
		),
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
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus orci tellus, tincidunt non semper vitae, posuere vel felis. Vivamus ultrices turpis et enim ullamcorper porta. Sed lorem risus, pharetra id porta ut, congue at magna. Mauris gravida enim tincidunt nunc volutpat ac laoreet turpis hendrerit.", GETTEXT_DOMAIN),
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
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
		)
   )
));



?>