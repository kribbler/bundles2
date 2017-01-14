<?php

function vc_featured_module_1_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'scale' => '',
      'title' => '',
      'url' => '',
      'badge_text' => '',
      'badge_color' => '',
   ), $atts ) );

   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   $image_cropped = wp_get_attachment_image_src( $image, 'featured-module' );
 
	$out = '';
	$no_scale = '';
	
	if($title){
		$title='<h3>'.$title.'</h3>';
	}
	
	if($title||$content){
		$featured_module_1_content='<div class="featured-module-1-content">'.$title.'<p>'.$content.'</p></div>';
	}
	
	if($scale){
		$no_scale='featured-module-no-scale';
	}
	
	if($badge_text){
		$badge_text='<span class="lpd-badge" style="background-color:'.$badge_color.';">'.$badge_text.'</span>';
	}
	
	$out .= '<a href="'.$url.'" class="featured-module featured-module-1 '.$no_scale.'">'.$badge_text.'<img alt="" class="img-responsive" src="'.$image_cropped[0].'">'.$featured_module_1_content.'</a>';
	
	return $out;
    
}
add_shortcode( 'vc_featured_module_1', 'vc_featured_module_1_func' );


function vc_featured_module_2_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'scale' => '',
      'title' => '',
      'title2' => '',
      'top_bg' => '',
      'url' => '',
      'title_bottom' => '',
      'bottom_bg' => '',
      'badge_text' => '',
      'badge_color' => '',
   ), $atts ) );

   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   $image_cropped = wp_get_attachment_image_src( $image, 'featured-module' );
 
	$out = '';
	$no_scale = '';
	
	if($title){
		$title='<h3>'.$title.'</h3>';
	}
	
	if($title2){
		$title2='<span class="sep-border"></span><h3>'.$title2.'</h3>';
	}
	
	if($top_bg){
		$top_bg='style="background-color: '.$top_bg.';"';
	}
	
	if($title||$title2){
		$featured_module_2_content='<div class="featured-module-2-content" '.$top_bg.'>'.$title.''.$title2.'</div>';
	}
	
	if($bottom_bg){
		$bottom_bg='style="background-color: '.$bottom_bg.';"';
	}
	
	if($title_bottom){
		$featured_module_2_content_2='<div class="featured-module-2-content-2" '.$bottom_bg.'><h3>'.$title_bottom.'</h3></div>';
	}
	
	if($scale){
		$no_scale='featured-module-no-scale';
	}
	
	if($badge_text){
		$badge_text='<span class="lpd-badge" style="background-color:'.$badge_color.';">'.$badge_text.'</span>';
	}
	
	$out .= '<a href="'.$url.'" class="featured-module featured-module-2 '.$no_scale.'">'.$badge_text.'<img alt="" class="img-responsive" src="'.$image_cropped[0].'">'.$featured_module_2_content.''.$featured_module_2_content_2.'</a>';
	
	return $out;
    
}
add_shortcode( 'vc_featured_module_2', 'vc_featured_module_2_func' );

function vc_featured_module_3_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'scale' => '',
      'title' => '',
      'label1' => '',
      'bg' => '',
      'url' => '',
      'badge_text' => '',
      'badge_color' => '',
   ), $atts ) );

   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   $image_cropped = wp_get_attachment_image_src( $image, 'featured-module' );
 
	$out = '';
	$no_scale = '';
	
	if($title){
		$title='<h3>'.$title.'</h3>';
	}
	
	if($scale){
		$no_scale='featured-module-no-scale';
	}
	
	if($label1){
		$label1='<span class="featured-module-3-label"><span>'.$label1.'</span></span>';
	}
	
	if($content){
		$content='<span class="featured-module-3-text">'.$content.'</span>';
	}
	
	if($bg){
		$bg='style="background-color: '.$bg.';"';
	}
	
	if($title||$content){
		$featured_module_3_content='<div class="featured-module-3-content" '.$bg.'>'.$label1.''.$title.''.$content.'</div>';
	}
	
	if($badge_text){
		$badge_text='<span class="lpd-badge" style="background-color:'.$badge_color.';">'.$badge_text.'</span>';
	}
	
	$out .= '<a href="'.$url.'" class="featured-module featured-module-3 '.$no_scale.'">'.$badge_text.'<img alt="" class="img-responsive" src="'.$image_cropped[0].'">'.$featured_module_3_content.'</a>';
	
	return $out;
    
}
add_shortcode( 'vc_featured_module_3', 'vc_featured_module_3_func' );


vc_map(array(
   "name" => __("Featured Module 1", GETTEXT_DOMAIN),
   "base" => "vc_featured_module_1",
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
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent mattis purus vitae imperdiet suscipit.", GETTEXT_DOMAIN),
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
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


vc_map(array(
   "name" => __("Featured Module 2", GETTEXT_DOMAIN),
   "base" => "vc_featured_module_2",
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
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link)", GETTEXT_DOMAIN),
			 "param_name" => "url",
			 "value" => __("#", GETTEXT_DOMAIN),
			 "description" => __("Module link.", GETTEXT_DOMAIN)
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
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Featured Title", GETTEXT_DOMAIN),
			 "param_name" => "title2",
			 "value" => __("SIT AMET", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Top Background", GETTEXT_DOMAIN),
			"param_name" => "top_bg",
			"value" => '#0e5ba4',
			"description" => __("Choose background color.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Bottom Title", GETTEXT_DOMAIN),
			 "param_name" => "title_bottom",
			 "value" => __("LOREM IMSUM DOLOR", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Bottom Background", GETTEXT_DOMAIN),
			"param_name" => "bottom_bg",
			"value" => '#ccc',
			"description" => __("Choose background color.", GETTEXT_DOMAIN)
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

vc_map(array(
   "name" => __("Featured Module 3", GETTEXT_DOMAIN),
   "base" => "vc_featured_module_3",
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
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link)", GETTEXT_DOMAIN),
			 "param_name" => "url",
			 "value" => __("#", GETTEXT_DOMAIN),
			 "description" => __("Module link.", GETTEXT_DOMAIN)
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
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Label", GETTEXT_DOMAIN),
			 "param_name" => "label1",
			 "value" => __("DESIGNED BY ENVATO", GETTEXT_DOMAIN),
			 "description" => __("Enter your label.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed convallis mi metus, eu laoreet elit convallis vel. Nulla nisi nibh, bibendum vitae imperdiet eu, fermentum ut tellus. Sed euismod neque ac tempus vulputate.", GETTEXT_DOMAIN),
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background", GETTEXT_DOMAIN),
			"param_name" => "bg",
			"value" => '#0e5ba4',
			"description" => __("Choose background color.", GETTEXT_DOMAIN)
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