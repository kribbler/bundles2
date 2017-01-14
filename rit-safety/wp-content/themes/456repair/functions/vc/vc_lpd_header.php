<?php

function vc_lpd_header_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'separator' => '',
      'content_color' => '',
      'alignment' => '',
      'dark_bg' => '',
      'margin_top' => '',
      'margin_bottom' => '',
      'font_type' => '',
      'letter_spacing' => '',
      'line_height' => '',
      'icon_img' => '',
      'img_width' => '',
      'icon_color_bg' => '',
      'icon_color_bg_hover' => '',
      'icon_border_style' => '',
      'icon_color_border' => '',
      'icon_color_border_hover' => '',
      'icon_border_size' => '',
      'icon_border_radius' => '',
      'icon_border_spacing' => '',
      'icon_link' => '',
      'icon_align' => '',
      'icon_margin_bottom' => '',
   ), $atts ) );
   
   $icon_img = wp_get_attachment_image_src( $icon_img, 'module' );
 
   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

	if($margin_top){$margin_top = 'margin-top:'.$margin_top.'px;';}
	if($margin_bottom){$margin_bottom = 'margin-bottom:'.$margin_bottom.'px;';}
	
	$styles = $color = '';
	
	if($margin_top||$margin_bottom){$styles = ' style="'.$margin_top.''.$margin_bottom.'"';}
	if($content_color||$letter_spacing){
		$content_styles = ' style="';
		if($content_color){$content_styles .= 'color:'.$content_color.';';}
		if($letter_spacing){$content_styles .= 'letter-spacing:'.$letter_spacing.'px;';}
		if($line_height){$content_styles .= 'line-height:'.$line_height.'px;';}
		$content_styles .= '"';
	}
	if($alignment){$alignment = ' style="text-align:'.$alignment.';"';}

	$icon_link = ( $icon_link == '||' ) ? '' : $icon_link;
	$icon_link = vc_build_link( $icon_link );
	
	$icon_link_url = $icon_link['url'];
	$icon_link_title = $icon_link['title'];
	$icon_link_target = $icon_link['target'];
	
	$icon_styles='';
	
	if($img_width){
		$icon_styles = ' style="';
		if($img_width){$icon_styles .= 'font-size:'.$img_width.'px;';}		
		if($icon_color_bg){$icon_styles .= 'background-color:'.$icon_color_bg.';';}
		if($icon_border_style){$icon_styles .= 'border-style:'.$icon_border_style.';';}
		if($icon_color_border){$icon_styles .= 'border-color:'.$icon_color_border.';';}
		if($icon_border_size){$icon_styles .= 'border-width:'.$icon_border_size.'px;';}
		if($icon_border_radius){$icon_styles .= 'border-radius:'.$icon_border_radius.'px;';}
		if($icon_border_spacing){$icon_styles .= 'padding:'.$icon_border_spacing.'px;';}
		if($icon_margin_bottom){$icon_styles .= 'margin-bottom:'.$icon_margin_bottom.'px;';}
		$icon_styles .= '"';
	}
	
	if($icon_color_bg_hover||$icon_color_border_hover){
	
		global $shortcode_atts;
		
		$shortcode_atts = array(
			'icon_color_bg_hover' => $icon_color_bg_hover,
			'icon_color_border_hover' => $icon_color_border_hover,
		);
		
		global $the_lpd_header_ID;
		
		$the_lpd_header_ID = rand();
		
	}
   
   ob_start();?>
   
   <div class="lpd-header<?php if($dark_bg){?> dark_bg<?php } ?>"<?php echo $alignment ;?>>
	   <?php if($icon_img){?>
	   <div class="lpd-align-icon<?php if($icon_color_bg_hover||$icon_color_border_hover){?> lpd-header-icon-<?php echo $the_lpd_header_ID;?><?php } ?>"<?php if($icon_align){?> style="text-align:<?php echo $icon_align;?>;"<?php } ?>>
		   <?php if($icon_link_url){?><a href="<?php echo $icon_link_url ;?>" class="lpd-href-icon" title="<?php echo $icon_link_title ;?>"<?php if($icon_link_target){?> target="<?php echo $icon_link_target ;?>"<?php }?>><?php } else{ ?><span class="lpd-wrap-icon"><?php } ?>
			   <div class="lpd-img-wrap-icon"<?php echo $icon_styles ;?>>
				   <img class="lpd-img-icon" alt="<?php echo $title; ?>" src="<?php echo $icon_img[0] ;?>">
			   </div>
		  <?php if($icon_link){?></a><?php } else{ ?></span><?php } ?>
	   </div>
	   <?php } ?>
	   <?php if($title){?><h3><?php echo $title; ?></h3><?php } ?>
	   <?php if($separator){?><div class="deco-sep-line-<?php echo $separator; ?>"<?php echo $styles; ?>></div><?php } ?>
	   <?php if($content){?><div class="lpd_header_content<?php if($font_type){ echo ' '.$font_type; }?>"<?php echo $content_styles; ?>><?php echo $content; ?></div><?php } ?>
   </div>
   
	<?php
	if($icon_color_bg_hover||$icon_color_border_hover){ 
		$counter_js = new lpd_header_class();
		
		$counter_js->lpd_header_callback();
	}	
	?>
   
   <?php return ob_get_clean();

}
add_shortcode( 'vc_lpd_header', 'vc_lpd_header_func' );


class lpd_header_class
{
    protected static $var = '';

    public static function lpd_header_callback(){
    
	global $the_lpd_header_ID;
	
	global $shortcode_atts;
	
	$icon_color_bg_hover = $shortcode_atts['icon_color_bg_hover'];
	$icon_color_border_hover = $shortcode_atts['icon_color_border_hover'];
	
		ob_start();?>
		
		<style>
			.lpd-header:hover .lpd-header-icon-<?php echo $the_lpd_header_ID;?> .lpd-img-wrap-icon{
				<?php if($icon_color_bg_hover){?>background-color: <?php echo $icon_color_bg_hover; ?> !important;<?php } ?>
				<?php if($icon_color_border_hover){?>border-color: <?php echo $icon_color_border_hover; ?> !important;<?php } ?>
			}
		</style>

		
		<?php $script = ob_get_clean();

        self::$var[] = $script;

        add_action( 'wp_footer', array ( __CLASS__, 'footer' ), 20 );         
    }

	public static function footer() 
	{
	    foreach( self::$var as $script ){
	        echo $script;
	    }
	}

}


vc_map(array(
   "name" => __("LPD Header", GETTEXT_DOMAIN),
   "base" => "vc_lpd_header",
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
			 "heading" => __("Separator Margin Top", GETTEXT_DOMAIN),
			 "param_name" => "margin_top",
			 "value" => '',
			 "description" => __("Separator margin top, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Separator Margin Bottom", GETTEXT_DOMAIN),
			 "param_name" => "margin_bottom",
			 "value" => '',
			 "description" => __("Separator margin bottom, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Alignment", GETTEXT_DOMAIN),
			"param_name" => "alignment",
			"value" => array(		
__('Left', GETTEXT_DOMAIN) => "left",
__('Center', GETTEXT_DOMAIN) => "center",
__('Right', GETTEXT_DOMAIN) => "right",
			),
			"description" => __("Select the alignment for title and separator.", GETTEXT_DOMAIN)
		),	
		array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => '',
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content Color", GETTEXT_DOMAIN),
			"param_name" => "content_color",
			"value" => '#555',
			"description" => __("Choose content color.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Font Type", GETTEXT_DOMAIN),
			"param_name" => "font_type",
			"value" => array(		
__('Type 1', GETTEXT_DOMAIN) => "",
__('Type 2', GETTEXT_DOMAIN) => "font_type_2",
			),
			"description" => __("Select font type.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Letter Spacing", GETTEXT_DOMAIN),
			 "param_name" => "letter_spacing",
			 "value" => '',
			 "description" => __("Letter spacing for the content, only integers (ex: 0.75, 1, 3,).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Line Height", GETTEXT_DOMAIN),
			 "param_name" => "line_height",
			 "value" => '',
			 "description" => __("Line height for the content (in pixels), only integers (ex: 0.75, 1, 3,).", GETTEXT_DOMAIN)
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Dark Background", GETTEXT_DOMAIN),
			"param_name" => "dark_bg",
			"description" => __("Check, if you are using dark background.", GETTEXT_DOMAIN),
			"value" => Array(__("Dark Background", GETTEXT_DOMAIN) => 'enable')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Enable Icon", GETTEXT_DOMAIN),
			"param_name" => "enable_icon",
			"description" => __("Enable custom icon.", GETTEXT_DOMAIN),
			"value" => Array(__("Enable", GETTEXT_DOMAIN) => 'enable')
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Upload Image Icon:", GETTEXT_DOMAIN),
			"param_name" => "icon_img",
			"admin_label" => true,
			"value" => "",
			"description" => __("Upload the custom image icon.", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "enable_icon","value" => "enable"),
		),
		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Image Width", GETTEXT_DOMAIN),
			"param_name" => "img_width",
			"value" => 48,
			"min" => 16,
			"max" => 512,
			"suffix" => "px",
			"description" => __("Provide image width", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "enable_icon","value" => "enable"),
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Design Your Own Icon", GETTEXT_DOMAIN),
			"param_name" => "design_icon",
			"description" => __("Design your own custom icon.", GETTEXT_DOMAIN),
			"value" => Array(__("Yes", GETTEXT_DOMAIN) => 'enable')
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color", GETTEXT_DOMAIN),
			"param_name" => "icon_color_bg",
			"value" => "#ffffff",
			"description" => __("Select background color for icon.", GETTEXT_DOMAIN),	
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Hover Background Color", GETTEXT_DOMAIN),
			"param_name" => "icon_color_bg_hover",
			"value" => "#ffffff",
			"description" => __("Select hover background color for icon.", GETTEXT_DOMAIN),	
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon Border Style", GETTEXT_DOMAIN),
			"param_name" => "icon_border_style",
			"value" => array(
				"None"=> "",
				"Solid"=> "solid",
				"Dashed" => "dashed",
				"Dotted" => "dotted",
				"Double" => "double",
				"Inset" => "inset",
				"Outset" => "outset",
			),
			"description" => __("Select the border style for icon.",GETTEXT_DOMAIN),
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Color", GETTEXT_DOMAIN),
			"param_name" => "icon_color_border",
			"value" => "#555555",
			"description" => __("Select border color for icon.", GETTEXT_DOMAIN),	
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Hover Border Color", GETTEXT_DOMAIN),
			"param_name" => "icon_color_border_hover",
			"value" => "#555555",
			"description" => __("Select hover border color for icon.", GETTEXT_DOMAIN),	
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Border Width", GETTEXT_DOMAIN),
			"param_name" => "icon_border_size",
			"value" => 1,
			"min" => 1,
			"max" => 10,
			"suffix" => "px",
			"description" => __("Thickness of the border.", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Border Radius", GETTEXT_DOMAIN),
			"param_name" => "icon_border_radius",
			"value" => 500,
			"min" => 1,
			"max" => 500,
			"suffix" => "px",
			"description" => __("0 pixel value will create a square border. As you increase the value, the shape convert in circle slowly. (e.g 500 pixels).", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "number",
			"class" => "",
			"heading" => __("Background Size", GETTEXT_DOMAIN),
			"param_name" => "icon_border_spacing",
			"value" => 50,
			"min" => 30,
			"max" => 500,
			"suffix" => "px",
			"description" => __("Spacing from center of the icon till the boundary of border / background", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "design_icon","value" => "enable"),
		),
		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __("Link ",GETTEXT_DOMAIN),
			"param_name" => "icon_link",
			"value" => "",
			"dependency" => Array("element" => "enable_icon","value" => "enable"),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Alignment", GETTEXT_DOMAIN),
			"param_name" => "icon_align",
			"value" => array(
				"Center"	=>	"center",
				"Left"		=>	"left",
				"Right"		=>	"right"
			),
			"description" => __("Icon Alignment", GETTEXT_DOMAIN),
			"dependency" => Array("element" => "enable_icon","value" => "enable"),
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Icon Margin Bottom", GETTEXT_DOMAIN),
			 "param_name" => "icon_margin_bottom",
			 "value" => '',
			 "description" => __("Icon margin bottom, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
   )
));

?>