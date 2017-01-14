<?php

function vc_info_block_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'sub_title' => '',	
      'bn_text' => '',
      'link' => '',
      'type' => '',
      'size' => '',
      'image' => '',
      'right_border' => ''
   ), $atts ) );
   
   $image = wp_get_attachment_image_src( $image, 'full' );
 
   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   ob_start();?>
   
	<div class="info_block">
		<div class="ib-meta clearfix">
		
			<table><tbody>
			<tr>
				<td style="vertical-align:middle"><img class="img-responsive" src="http://localhost:8888/456repair-0807/wp-content/uploads/2014/07/shutterstock_130214537-n-580x263.jpg"></td>
				<td style="vertical-align:middle" class="ib-meta-data">100%<span class="ib-meta-data-description">positive verdicts</span></td>
			</tr>
			</tbody></table>
						
		</div>
	</div>
   
   <?php return ob_get_clean();

}
add_shortcode( 'vc_info_block', 'vc_info_block_func' );


vc_map(array(
   "name" => __("Info Block", GETTEXT_DOMAIN),
   "base" => "vc_info_block",
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
			 "heading" => __("Sub-title", GETTEXT_DOMAIN),
			 "param_name" => "sub_title",
			 "value" => __("LOREM ISPUN DOLOR", GETTEXT_DOMAIN),
			 "description" => __("Enter your sub-title.", GETTEXT_DOMAIN)
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
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Text", GETTEXT_DOMAIN),
			 "param_name" => "bn_text",
			 "value" => "Text on the button",
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
	      "type" => "attach_image",
	      "heading" => __("Image", GETTEXT_DOMAIN),
	      "param_name" => "image",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
			"type" => 'checkbox',
			"heading" => __("Right Border", GETTEXT_DOMAIN),
			"param_name" => "right_border",
			"description" => __("Check, if you want to hide right border.", GETTEXT_DOMAIN),
			"value" => Array(__("Hide", GETTEXT_DOMAIN) => 'hide')
		),
   )
));

?>