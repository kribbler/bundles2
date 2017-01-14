<?php

function vc_triangle_element_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'color' => '',
   ), $atts ) );
   
   ob_start();?>
   
   <div class="lpd-triangle-element"><div class="triangle" style="background-color:<?php echo $color; ?>"></div></div>
   
   <?php return ob_get_clean();

}
add_shortcode( 'vc_triangle_element', 'vc_triangle_element_func' );


vc_map(array(
   "name" => __("Triangle Element", GETTEXT_DOMAIN),
   "base" => "vc_triangle_element",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color", GETTEXT_DOMAIN),
			"param_name" => "color",
			"value" => '#fdb813',
			"description" => __("Choose triangle background.", GETTEXT_DOMAIN)
		)
   )
));

?>