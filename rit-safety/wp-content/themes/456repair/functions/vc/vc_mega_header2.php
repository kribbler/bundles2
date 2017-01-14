<?php

function vc_mega_header2_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'separator' => '',
      'description' => '',
      'dark_bg' => '',
      'padding_top' => '',
      'padding_bottom' => '',
      'margin_top' => '',
      'margin_bottom' => '',
   ), $atts ) );
 
   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   	if($padding_top){$padding_top = 'padding-top:'.$padding_top.'px;';}
	if($padding_bottom){$padding_bottom = 'padding-bottom:'.$padding_bottom.'px;';}

	if($margin_top){$margin_top = 'margin-top:'.$margin_top.'px;';}
	if($margin_bottom){$margin_bottom = 'margin-bottom:'.$margin_bottom.'px;';}
	
	$styles = '';
	
	if($padding_top||$padding_bottom||$margin_top||$margin_bottom){$styles = ' style="'.$margin_top.''.$margin_bottom.''.$padding_top.''.$padding_bottom.'"';}
   
   ob_start();?>
   
   <div class="lpd-mega-header2<?php if($dark_bg){?> dark_bg<?php } ?>"<?php echo $styles; ?>>
	   <?php if($title){?><h3><?php echo $title; ?></h3><?php } ?>
	   <?php if($description){?><span class="mh2_description"><?php echo $description; ?></span><?php } ?>
	   <?php if($separator){?><div class="deco-sep-line-<?php echo $separator; ?>"></div><?php } ?>
	   <?php if($content){?><div class="mh2_content"><?php echo $content; ?></div><?php } ?>
   </div>
   
   <?php return ob_get_clean();

}
add_shortcode( 'vc_mega_header2', 'vc_mega_header2_func' );


vc_map(array(
   "name" => __("Mega Header 2", GETTEXT_DOMAIN),
   "base" => "vc_mega_header2",
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
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis dapibus massa.',
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
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

   )
));

?>