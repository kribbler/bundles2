<?php

function vc_add_shortcode_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
   ), $atts ) );
 
   $content = do_shortcode($content); // fix unclosed/unwanted paragraph tags in $content
   
    return '<div class="vc_add_shortcode">'.$content.'</div>';		
    
}
add_shortcode( 'vc_add_shortcode', 'vc_add_shortcode_func' );


vc_map(array(
   "name" => __("Add Shortcode", GETTEXT_DOMAIN),
   "base" => "vc_add_shortcode",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
		array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Shortcode", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => __("", GETTEXT_DOMAIN),
			 "description" => __("Input your shortcode.", GETTEXT_DOMAIN)
		)
   )
));

?>