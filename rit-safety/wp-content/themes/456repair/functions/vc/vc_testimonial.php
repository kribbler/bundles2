<?php

function vc_testimonial_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image' => '',
      'title' => '',
      'meta_title' => '',
      'meta_sub_title' => '',
      'meta_info' => ''
   ), $atts ) );
   
   $image_cropped = wp_get_attachment_image_src( $image, 'thumbnail' );
   
      $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
 
	  $tmc_info = '';
	  $tmc_title = '';
	  $tmc = '';
	  $img = '';
	  
	  if($meta_info){
	  	$tmc_info = '<span class="tmc_info">'.$meta_info.'</span>';
	  }
	  
	  	if($meta_sub_title){
	 		$meta_sub_title= ' <small>'.$meta_sub_title.'</small>';
	 	}
	  
	  if($meta_title){
	  	$tmc_title = '<span class="tmc_title">'.$meta_title.''.$meta_sub_title.'</span>';
	  }
	  
	  if($meta_title||$meta_info){
	  	$tmc = '<div class="testiomonial_meta_content">'.$tmc_title.''.$tmc_info.'</div>';
	  }
	  
	  if($image_cropped){
	  	$img = '<img class="testiomonial_meta_img" src="'.$image_cropped[0].'"/>';
	  }
	  
	  if($title){
	  	$title = '<h4 class="tc_title">'.$title.'</h4>';
	  }
 
	$out = '';
	
	$out .= '<div class="vc_lpd_testiomonial"><div class="testiomonial_content">'.$title.'<div class="tc_content">'.$content.'</div></div><div class="testiomonial_meta">'.$img.''.$tmc.'</div></div>';
	
    return $out;
}
add_shortcode( 'vc_testimonial', 'vc_testimonial_func' );


vc_map(array(
   "name" => __("Testomonial", GETTEXT_DOMAIN),
   "base" => "vc_testimonial",
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
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", GETTEXT_DOMAIN),
			 "param_name" => "title",
			 "value" => __("LOREM IMSUM DOLOR", GETTEXT_DOMAIN),
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent mattis purus vitae imperdiet suscipit.",
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Meta Tilte", GETTEXT_DOMAIN),
			 "param_name" => "meta_title",
			 "value" => "",
			 "description" => __("Enter your meta title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Meta Sub-tilte", GETTEXT_DOMAIN),
			 "param_name" => "meta_sub_title",
			 "value" => "",
			 "description" => __("Enter your meta sub-title.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Meta Info", GETTEXT_DOMAIN),
			 "param_name" => "meta_info",
			 "value" => "",
			 "description" => __("Enter your meta info.", GETTEXT_DOMAIN)
		),
   )
));

?>