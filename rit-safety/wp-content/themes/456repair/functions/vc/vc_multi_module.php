<?php

function vc_multi_module_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'image_mm1' => '',
      'dark_bg_mm1' => '',
      'title_mm1' => '',
      'title_color_mm1' => '',
      'desc_mm1' => '',
      'desc_ls_mm1' => '',
      'url_mm1' => '',
      'image_mm2' => '',
      'dark_bg_mm2' => '',
      'title_mm2' => '',
      'title_color_mm2' => '',
      'desc_mm2' => '',
      'desc_ls_mm2' => '',
      'url_mm2' => '',
      'image_mm3' => '',
      'dark_bg_mm3' => '',
      'title_mm3' => '',
      'title_color_mm3' => '',
      'desc_mm3' => '',
      'desc_ls_mm3' => '',
      'url_mm3' => '',
      'image_mm4' => '',
      'dark_bg_mm4' => '',
      'title_mm4' => '',
      'title_ls_mm4' => '',
      'url_mm4' => '',
      'image_mm5' => '',
      'dark_bg_mm5' => '',
      'title_mm5' => '',
      'title_ls_mm5' => '',
      'url_mm5' => '',
      'button_text_mm1' => '',
      'button_size_mm1' => '',
      'title_location_mm4' => '',
      'title_location_mm5' => '',
      
   ), $atts ) );
   
   $image_cropped_mm1 = wp_get_attachment_image_src( $image_mm1, 'multi-module' );
   $image_cropped_mm2 = wp_get_attachment_image_src( $image_mm2, 'multi-module1' );
   $image_cropped_mm3 = wp_get_attachment_image_src( $image_mm3, 'multi-module2' );
   $image_cropped_mm4 = wp_get_attachment_image_src( $image_mm4, 'multi-module3' );
   $image_cropped_mm5 = wp_get_attachment_image_src( $image_mm5, 'multi-module4' );
   
   $image_cropped_mm1_xs = wp_get_attachment_image_src( $image_mm1, 'cubeportfolio' );
   $image_cropped_mm2_xs = wp_get_attachment_image_src( $image_mm2, 'cubeportfolio' );
   $image_cropped_mm3_xs = wp_get_attachment_image_src( $image_mm3, 'cubeportfolio' );
   $image_cropped_mm4_xs = wp_get_attachment_image_src( $image_mm4, 'cubeportfolio' );
   $image_cropped_mm5_xs = wp_get_attachment_image_src( $image_mm5, 'cubeportfolio' );
 
	ob_start();?>
	
	<div class="row hidden-xs">
		<div class="col-sm-3">
			<div class="mm_module_1 mm_module<?php if($dark_bg_mm1){?> <?php echo $dark_bg_mm1;?><?php }?>">
				<?php if($image_mm1){?><img alt="" class="" src="<?php echo $image_cropped_mm1[0];?>" /><?php }?>
				<div class="mm1_content">
					<table><tbody><tr><td style="vertical-align:top">
						<div class="mm1_content_wrap">
							<?php if($title_mm1){?><span class="mm1_title" style="color:<?php echo $title_color_mm1;?>;"><?php echo $title_mm1;?></span><?php }?>
							<?php if($desc_mm1){?><span class="mm1_description<?php if($desc_ls_mm1){?> <?php echo $desc_ls_mm1;?><?php }?>"><?php echo $desc_mm1;?></span><?php }?>
							<?php if($button_text_mm1){?><a class="btn btn-primary btn-<?php echo $button_size_mm1;?>" href="<?php echo $url_mm1;?>"><?php echo $button_text_mm1;?></a><?php }?>
						</div>
					</td></tr></tbody></table>
				</div>
				
			</div>
		</div>
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-8">
					<a href="<?php echo $url_mm2;?>" title="title" class="mm_module_2 mm_module<?php if($dark_bg_mm2){?> <?php echo $dark_bg_mm2;?><?php }?>">
						<?php if($image_mm2){?><img alt="" class="" src="<?php echo $image_cropped_mm2[0];?>" /><?php }?>
						<div class="mm2_content">
							<table><tbody><tr><td style="vertical-align:middle">
								<?php if($desc_mm2){?><span class="mm2_description<?php if($desc_ls_mm2){?> <?php echo $desc_ls_mm2;?><?php }?>"><?php echo $desc_mm2;?></span><?php }?>
								<?php if($title_mm2){?><span class="mm2_title" style="color:<?php echo $title_color_mm2;?>;"><?php echo $title_mm2;?></span><?php }?>						
							</td></tr></tbody></table>
						</div>
					</a>
				</div>
				<div class="col-sm-4">
					<a href="<?php echo $url_mm3;?>" title="title" class="mm_module_3 mm_module<?php if($dark_bg_mm3){?> <?php echo $dark_bg_mm3;?><?php }?>">
						<?php if($image_mm3){?><img alt="" class="" src="<?php echo $image_cropped_mm3[0];?>" /><?php }?>
						<div class="mm3_content">
							<table><tbody><tr><td style="vertical-align:middle">
								<?php if($title_mm3){?><span class="mm3_title" style="color:<?php echo $title_color_mm3;?>;"><?php echo $title_mm3;?></span><?php }?>
								<?php if($desc_mm3){?><span class="mm3_description<?php if($desc_ls_mm3){?> <?php echo $desc_ls_mm3;?><?php }?>"><?php echo $desc_mm3;?></span><?php }?>					
							</td></tr></tbody></table>
						</div>
					</a>
				</div>
			</div>
			<div class="divider30"></div>
			<div class="row">
				<div class="col-sm-4">
					<a href="<?php echo $url_mm4;?>" title="title" class="mm_module_4 mm_module<?php if($dark_bg_mm4){?> <?php echo $dark_bg_mm4;?><?php }?>">
						<?php if($image_mm4){?><img alt="" class="" src="<?php echo $image_cropped_mm4[0];?>" /><?php }?>
						<div class="mm4_hover_bg"></div>
						<div class="mm4_content<?php if($title_location_mm4){?> <?php echo $title_location_mm4;?><?php }?>">
							<?php if($title_mm4){?><span class="mm4_title<?php if($title_ls_mm4){?> <?php echo $title_ls_mm4;?><?php }?>" style="color:<?php echo $title_color_mm4;?>;"><?php echo $title_mm4;?></span><?php }?>						
						</div>		
					</a>
				</div>
				<div class="col-sm-8">
					<a href="<?php echo $url_mm5;?>" title="title" class="mm_module_5 mm_module<?php if($dark_bg_mm5){?> <?php echo $dark_bg_mm5;?><?php }?>">
						<?php if($image_mm5){?><img alt="" class="" src="<?php echo $image_cropped_mm5[0];?>" /><?php }?>
						<div class="mm5_hover_bg"></div>
						<div class="mm5_content<?php if($title_location_mm5){?> <?php echo $title_location_mm5;?><?php }?>">
							<?php if($title_mm5){?><span class="mm4_title<?php if($title_ls_mm5){?> <?php echo $title_ls_mm5;?><?php }?>" style="color:<?php echo $title_color_mm5;?>;"><?php echo $title_mm5;?></span><?php }?>				
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row visible-xs">
		<div class="col-xs-12">
			<div class="mm_module_1 mm_module<?php if($dark_bg_mm1){?> <?php echo $dark_bg_mm1;?><?php }?>"<?php if($image_mm1){?> style="background-image: url(<?php echo $image_cropped_mm1_xs[0];?>);"<?php }?>>
				<div class="mm1_content">	
					<?php if($title_mm1){?><span class="mm1_title" style="color:<?php echo $title_color_mm1;?>;"><?php echo $title_mm1;?></span><?php }?>
					<?php if($desc_mm1){?><span class="mm1_description<?php if($desc_ls_mm1){?> <?php echo $desc_ls_mm1;?><?php }?>"><?php echo $desc_mm1;?></span><?php }?>
					<?php if($button_text_mm1){?><a class="btn btn-primary btn-<?php echo $button_size_mm1;?>" href="<?php echo $url_mm1;?>"><?php echo $button_text_mm1;?></a><?php }?>
				</div>
			</div>
			<div class="divider20"></div>
			
			<a href="<?php echo $url_mm2;?>" title="title" class="mm_module_2 mm_module<?php if($dark_bg_mm2){?> <?php echo $dark_bg_mm2;?><?php }?>"<?php if($image_mm2){?> style="background-image: url(<?php echo $image_cropped_mm2_xs[0];?>);"<?php }?>>
				<div class="mm2_content">
					<?php if($desc_mm2){?><span class="mm2_description<?php if($desc_ls_mm2){?> <?php echo $desc_ls_mm2;?><?php }?>"><?php echo $desc_mm2;?></span><?php }?>
					<?php if($title_mm2){?><span class="mm2_title" style="color:<?php echo $title_color_mm2;?>;"><?php echo $title_mm2;?></span><?php }?>						
				</div>
			</a>
			<div class="divider20"></div>
	
			<a href="<?php echo $url_mm3;?>" title="title" class="mm_module_3 mm_module<?php if($dark_bg_mm3){?> <?php echo $dark_bg_mm3;?><?php }?>"<?php if($image_mm3){?> style="background-image: url(<?php echo $image_cropped_mm3_xs[0];?>);"<?php }?>>
				<div class="mm3_content">
					<?php if($title_mm3){?><span class="mm3_title" style="color:<?php echo $title_color_mm3;?>;"><?php echo $title_mm3;?></span><?php }?>
					<?php if($desc_mm3){?><span class="mm3_description<?php if($desc_ls_mm3){?> <?php echo $desc_ls_mm3;?><?php }?>"><?php echo $desc_mm3;?></span><?php }?>					
				</div>
			</a>
			<div class="divider20"></div>
			
			<a href="<?php echo $url_mm4;?>" title="title" class="mm_module_4 mm_module<?php if($dark_bg_mm4){?> <?php echo $dark_bg_mm4;?><?php }?>"<?php if($image_mm4){?> style="background-image: url(<?php echo $image_cropped_mm4_xs[0];?>);"<?php }?>>
				<div class="mm4_hover_bg"></div>
				<div class="mm4_content<?php if($title_location_mm4){?> <?php echo $title_location_mm4;?><?php }?>">
					<?php if($title_mm4){?><span class="mm4_title<?php if($title_ls_mm4){?> <?php echo $title_ls_mm4;?><?php }?>" style="color:<?php echo $title_color_mm4;?>;"><?php echo $title_mm4;?></span><?php }?>						
				</div>
			</a>
			<div class="divider20"></div>
			
			<a href="<?php echo $url_mm5;?>" title="title" class="mm_module_5 mm_module<?php if($dark_bg_mm5){?> <?php echo $dark_bg_mm5;?><?php }?>"<?php if($image_mm5){?> style="background-image: url(<?php echo $image_cropped_mm5_xs[0];?>);"<?php }?>>
				<div class="mm5_hover_bg"></div>
				<div class="mm5_content<?php if($title_location_mm5){?> <?php echo $title_location_mm5;?><?php }?>">
					<?php if($title_mm4){?><span class="mm4_title<?php if($title_ls_mm5){?> <?php echo $title_ls_mm5;?><?php }?>" style="color:<?php echo $title_color_mm5;?>;"><?php echo $title_mm5;?></span><?php }?>				
				</div>
			</a>
		</div>
	</div>
	
	<?php return ob_get_clean();
	
}
add_shortcode( 'vc_multi_module', 'vc_multi_module_func' );


vc_map(array(
   "name" => __("Multi Module", GETTEXT_DOMAIN),
   "base" => "vc_multi_module",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image Module 1", GETTEXT_DOMAIN),
	      "param_name" => "image_mm1",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
		  "type" => 'checkbox',
		  "heading" => __("Dark Background Module 1", GETTEXT_DOMAIN),
		  "param_name" => "dark_bg_mm1",
		  "description" => __("Enable, if you are using dark background.", GETTEXT_DOMAIN),
		  "value" => Array(__("Enable", GETTEXT_DOMAIN) => 'mm_dark_bg')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title Module 1", GETTEXT_DOMAIN),
			 "param_name" => "title_mm1",
			 "value" => '',
			 "description" => __("Title for module 1.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title Color Module 1", GETTEXT_DOMAIN),
			"param_name" => "title_color_mm1",
			"value" => '#ffffff',
			"description" => __("Choose title color module 1.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Description Module 1", GETTEXT_DOMAIN),
			 "param_name" => "desc_mm1",
			 "value" => '',
			 "description" => __("Description for module 1.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Description Letter Spacing", GETTEXT_DOMAIN),
	      "param_name" => "desc_ls_mm1",
	      "value" => array( __("none", GETTEXT_DOMAIN) => "", '0.75px' => "letter-space-75", '1px' => "letter-space-1", '3px' => "letter-space-3", '5px' => "letter-space-5", '10px' => "letter-space-10"),
	      "description" => __("Description letter spacing for module 1.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Text", GETTEXT_DOMAIN),
			 "param_name" => "button_text_mm1",
			 "value" => "",
			 "description" => __("Button text for module 1.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Size", GETTEXT_DOMAIN),
			"param_name" => "button_size_mm1",
			"value" => array(__('Large', GETTEXT_DOMAIN) => "lg", __('Medium', GETTEXT_DOMAIN) => "medium", __('Small', GETTEXT_DOMAIN) => "sm", __('Extra Small', GETTEXT_DOMAIN) => "xs"),
			"description" => __("Select size of the button.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link) Module 1", GETTEXT_DOMAIN),
			 "param_name" => "url_mm1",
			 "value" => "#",
			 "description" => __("Link for module 1.", GETTEXT_DOMAIN)
		),
		
		
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image Module 2", GETTEXT_DOMAIN),
	      "param_name" => "image_mm2",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
		  "type" => 'checkbox',
		  "heading" => __("Dark Background Module 2", GETTEXT_DOMAIN),
		  "param_name" => "dark_bg_mm2",
		  "description" => __("Enable, if you are using dark background.", GETTEXT_DOMAIN),
		  "value" => Array(__("Enable", GETTEXT_DOMAIN) => 'mm_dark_bg')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title Module 2", GETTEXT_DOMAIN),
			 "param_name" => "title_mm2",
			 "value" => '',
			 "description" => __("Title for module 2.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title Color Module 2", GETTEXT_DOMAIN),
			"param_name" => "title_color_mm2",
			"value" => '#ffffff',
			"description" => __("Choose title color module 2.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Description Module 2", GETTEXT_DOMAIN),
			 "param_name" => "desc_mm2",
			 "value" => '',
			 "description" => __("Description for module 2.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Description Letter Spacing", GETTEXT_DOMAIN),
	      "param_name" => "desc_ls_mm2",
	      "value" => array( __("none", GETTEXT_DOMAIN) => "", '0.75px' => "letter-space-75", '1px' => "letter-space-1", '3px' => "letter-space-3", '5px' => "letter-space-5", '10px' => "letter-space-10"),
	      "description" => __("Description letter spacing for module 2.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link) Module 2", GETTEXT_DOMAIN),
			 "param_name" => "url_mm2",
			 "value" => "#",
			 "description" => __("Link for module 2.", GETTEXT_DOMAIN)
		),
		
		
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image Module 3", GETTEXT_DOMAIN),
	      "param_name" => "image_mm3",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
		  "type" => 'checkbox',
		  "heading" => __("Dark Background Module 3", GETTEXT_DOMAIN),
		  "param_name" => "dark_bg_mm3",
		  "description" => __("Enable, if you are using dark background.", GETTEXT_DOMAIN),
		  "value" => Array(__("Enable", GETTEXT_DOMAIN) => 'mm_dark_bg')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title Module 3", GETTEXT_DOMAIN),
			 "param_name" => "title_mm3",
			 "value" => '',
			 "description" => __("Title for module 3.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title Color Module 3", GETTEXT_DOMAIN),
			"param_name" => "title_color_mm3",
			"value" => '#ffffff',
			"description" => __("Choose title color for module 3.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Description Module 3", GETTEXT_DOMAIN),
			 "param_name" => "desc_mm3",
			 "value" => '',
			 "description" => __("Description for module 3.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Description Letter Spacing", GETTEXT_DOMAIN),
	      "param_name" => "desc_ls_mm3",
	      "value" => array( __("none", GETTEXT_DOMAIN) => "", '0.75px' => "letter-space-75", '1px' => "letter-space-1", '3px' => "letter-space-3", '5px' => "letter-space-5", '10px' => "letter-space-10"),
	      "description" => __("Description letter spacing for module 3.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link) Module 3", GETTEXT_DOMAIN),
			 "param_name" => "url_mm3",
			 "value" => "#",
			 "description" => __("Link for module 3.", GETTEXT_DOMAIN)
		),
		
		
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image Module 4", GETTEXT_DOMAIN),
	      "param_name" => "image_mm4",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
		  "type" => 'checkbox',
		  "heading" => __("Dark Background Module 4", GETTEXT_DOMAIN),
		  "param_name" => "dark_bg_mm4",
		  "description" => __("Enable, if you are using dark background.", GETTEXT_DOMAIN),
		  "value" => Array(__("Enable", GETTEXT_DOMAIN) => 'mm_dark_bg')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title Module 4", GETTEXT_DOMAIN),
			 "param_name" => "title_mm4",
			 "value" => '',
			 "description" => __("Title for module 4.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Title Location Module 4", GETTEXT_DOMAIN),
	      "param_name" => "title_location_mm4",
	      "value" => array( __("top/left", GETTEXT_DOMAIN) => "top-left",__("top/right", GETTEXT_DOMAIN) => "top-right",__("bottom/left", GETTEXT_DOMAIN) => "bottom-left",__("bottom/right", GETTEXT_DOMAIN) => "bottom-right"),
	      "description" => __("Select title location for module 4.", GETTEXT_DOMAIN)
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Title Letter Spacing", GETTEXT_DOMAIN),
	      "param_name" => "title_ls_mm4",
	      "value" => array( __("none", GETTEXT_DOMAIN) => "", '0.75px' => "letter-space-75", '1px' => "letter-space-1", '3px' => "letter-space-3", '5px' => "letter-space-5", '10px' => "letter-space-10"),
	      "description" => __("Title letter spacing for module 4.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link) Module 4", GETTEXT_DOMAIN),
			 "param_name" => "url_mm4",
			 "value" => "#",
			 "description" => __("Link for module 4.", GETTEXT_DOMAIN)
		),
		
		
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image Module 5", GETTEXT_DOMAIN),
	      "param_name" => "image_mm5",
	      "value" => "",
	      "description" => __("Select image from media library.", GETTEXT_DOMAIN)
	    ),
		array(
		  "type" => 'checkbox',
		  "heading" => __("Dark Background Module 5", GETTEXT_DOMAIN),
		  "param_name" => "dark_bg_mm5",
		  "description" => __("Enable, if you are using dark background.", GETTEXT_DOMAIN),
		  "value" => Array(__("Enable", GETTEXT_DOMAIN) => 'mm_dark_bg')
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title Module 5", GETTEXT_DOMAIN),
			 "param_name" => "title_mm5",
			 "value" => '',
			 "description" => __("Title for module 5.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Title Location Module 5", GETTEXT_DOMAIN),
	      "param_name" => "title_location_mm5",
	      "value" => array( __("top/left", GETTEXT_DOMAIN) => "top-left",__("top/right", GETTEXT_DOMAIN) => "top-right",__("bottom/left", GETTEXT_DOMAIN) => "bottom-left",__("bottom/right", GETTEXT_DOMAIN) => "bottom-right"),
	      "description" => __("Select title location for module 5.", GETTEXT_DOMAIN)
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Title Letter Spacing", GETTEXT_DOMAIN),
	      "param_name" => "title_ls_mm5",
	      "value" => array( __("none", GETTEXT_DOMAIN) => "", '0.75px' => "letter-space-75", '1px' => "letter-space-1", '3px' => "letter-space-3", '5px' => "letter-space-5", '10px' => "letter-space-10"),
	      "description" => __("Title letter spacing for module 5.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url (link) Module 5", GETTEXT_DOMAIN),
			 "param_name" => "url_mm5",
			 "value" => "#",
			 "description" => __("Link for module 5.", GETTEXT_DOMAIN)
		)
   )
));

?>