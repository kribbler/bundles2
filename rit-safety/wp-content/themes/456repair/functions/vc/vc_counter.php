<?php

function vc_counter_func( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'percent' => '',
      'description' => '',
      #'color' => '',
      'trackcolor' => '',
      'barcolor' => '',
      'linewidth' => '',
      'linecap' => '',
      'speed' => '',
      'disable_percent' => '',
      'align' => '',
      'animate_counter' => '',
   ), $atts ) );
   
   global $shortcode_atts;
   
   $shortcode_atts = array(
      #'color' => $color,
      'trackcolor' => $trackcolor,
      'barcolor' => $barcolor,
      'linewidth' => $linewidth,
      'linecap' => $linecap,
      'speed' => $speed,
      'disable_percent' => $disable_percent,
      'align' => $align,
      'animate_counter' => $animate_counter,
   );
   
   easypiechart();
   
	global $the_counter_ID;
	
	$the_counter_ID = rand(); 
   
   ob_start();?>
   
        <div class="load-counter-<?php echo $the_counter_ID;?> clearfix<?php if($animate_counter){?> animated<?php }?>"<?php if($animate_counter){?> data-animate="<?php echo $animate_counter;?>"<?php }?>>
			<div class="counter-circular">
				
    			<div class="chart easy-pie-chart" data-percent="<?php echo $percent;?>">
                    <div class="percent-container">
                        <span class="percent"><?php echo $percent;?></span>
                    </div>
                    <span class="info"><?php echo $description;?></span>
                </div>
				
			</div>
        </div>
   
	<?php 
	$counter_js = new counter_class();
	
	$counter_js->counter_callback();	
	?>
   
   <?php return ob_get_clean();
  
}
add_shortcode( 'vc_counter', 'vc_counter_func' );

class counter_class
{
    protected static $var = '';

    public static function counter_callback(){
    
	global $the_counter_ID;
	
	global $shortcode_atts;
	
	#$color = $shortcode_atts['color'];
	$trackcolor = $shortcode_atts['trackcolor'];
	$barcolor = $shortcode_atts['barcolor'];
	$linewidth = $shortcode_atts['linewidth'];
	$linecap = $shortcode_atts['linecap'];
	$speed = $shortcode_atts['speed'];
	$disable_percent = $shortcode_atts['disable_percent'];
	$align = $shortcode_atts['align'];
	$animate_counter = $shortcode_atts['animate_counter'];
	
		ob_start();?>
		
		<script>
		/* <![CDATA[ */
		jQuery(document).ready(function(jQuery) {
		    'use strict';
		    
	        <?php if($animate_counter){?>
	        if (jQuery(".load-counter-<?php echo $the_counter_ID;?>.animated")[0]) {
	            jQuery('.load-counter-<?php echo $the_counter_ID;?>.animated').css('opacity', '0');
	        }
	
	        jQuery('.load-counter-<?php echo $the_counter_ID;?>').waypoint(function() {
	            var animation = jQuery(this).attr('data-animate');
	            jQuery(this).css('opacity', '');
	            jQuery(this).addClass("animated " + animation);
	
	        },
                {
                    offset: '80%',
                    triggerOnce: true
                }
	        );
	        <?php }?>
		
		    jQuery('.load-counter-<?php echo $the_counter_ID;?>').waypoint(function() {
		        jQuery('.load-counter-<?php echo $the_counter_ID;?> .easy-pie-chart').easyPieChart({
		            animate: <?php echo $speed;?>,
		            scaleColor: false,
		            lineWidth: <?php echo $linewidth;?>,
		            lineCap: '<?php echo $linecap;?>',
		            size: '130',
		            trackColor: '<?php echo $trackcolor;?>',
		            barColor: '<?php echo $barcolor;?>',
					onStep: function(from, to, percent) {
						this.el.children[0].children[0].innerHTML = Math.round(percent);
					}
		        });
		    },
	            {offset: '60%'}
		    );
		
		
		});
		
		/* ]]> */
		</script>
		
		<style>
		<?php if($color){?>
		.load-counter-<?php echo $the_counter_ID;?> .percent{
			background-color: <?php echo $color ;?>;
		}
		<?php }?>
		<?php if($disable_percent){?>
		.load-counter-<?php echo $the_counter_ID;?> .percent:after{
			content: '';
		}
		<?php }?>
		<?php if($align=='left'){?>
		.load-counter-<?php echo $the_counter_ID;?> div.easy-pie-chart{
			margin: 0;
		}
		<?php }?>
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
   "name" => __("Counter", GETTEXT_DOMAIN),
   "base" => "vc_counter",
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
			 "heading" => __("Percent", GETTEXT_DOMAIN),
			 "param_name" => "percent",
			 "value" => '50',
			 "description" => __("Enter counter percent.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Description", GETTEXT_DOMAIN),
			 "param_name" => "description",
			 "value" => '',
			 "description" => __("Enter counter description.", GETTEXT_DOMAIN)
		),
		/*array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Color", GETTEXT_DOMAIN),
			"param_name" => "color",
			"value" => '#df7a6c',
			"description" => __("Choose counter color.", GETTEXT_DOMAIN)
		),*/
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Track Color", GETTEXT_DOMAIN),
			"param_name" => "trackcolor",
			"value" => '#cccccc',
			"description" => __("The color of the track for the bar, false to disable rendering.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Bar Color", GETTEXT_DOMAIN),
			"param_name" => "barcolor",
			"value" => '#0e5ba4',
			"description" => __("The color of the curcular bar.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Line Width", GETTEXT_DOMAIN),
			 "param_name" => "linewidth",
			 "value" => '3',
			 "description" => __("Width of the bar line in px.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Line Cap", GETTEXT_DOMAIN),
	      "param_name" => "linecap",
	      "value" => array( 'butt' => "butt", 'round' => "round", 'square' => "square" ),
	      "description" => __("Time in milliseconds for a eased animation of the bar growing, or false to deactivate.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Speed", GETTEXT_DOMAIN),
			 "param_name" => "speed",
			 "value" => '1000',
			 "description" => __("Time in milliseconds for a eased animation of the bar growing, or false to deactivate.", GETTEXT_DOMAIN)
		),
		array(
	      "type" => 'checkbox',
	      "heading" => __("Disable Percent", GETTEXT_DOMAIN),
	      "param_name" => "disable_percent",
	      "description" => __("Check to hide percent symbol.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Counter Aling", GETTEXT_DOMAIN),
	      "param_name" => "align",
	      "value" => array( __("center", GETTEXT_DOMAIN) => "center", __("left", GETTEXT_DOMAIN) => "left" ),
	      "description" => __("Select one of counter align.", GETTEXT_DOMAIN)
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Animation", GETTEXT_DOMAIN),
	      "param_name" => "animate_counter",
	      "value" => array( "none" => "", "bounce" => "bounce", "flash" => "flash", "pulse" => "pulse", "rubberBand" => "rubberBand", "shake" => "shake", "swing" => "swing", "tada" => "tada", "wobble" => "wobble", "bounceIn" => "bounceIn", "bounceInDown" => "bounceInDown", "bounceInLeft" => "bounceInLeft", "bounceInRight" => "bounceInRight", "bounceInUp" => "bounceInUp", "bounceOut" => "bounceOut", "bounceOutDown" => "bounceOutDown", "bounceOutLeft" => "bounceOutLeft", "bounceOutRight" => "bounceOutRight", "bounceOutUp" => "bounceOutUp", "fadeIn" => "fadeIn", "fadeInDown" => "fadeInDown", "fadeInDownBig" => "fadeInDownBig", "fadeInLeft" => "fadeInLeft", "fadeInLeftBig" => "fadeInLeftBig", "fadeInRight" => "fadeInRight", "fadeInRightBig" => "fadeInRightBig", "fadeInUp" => "fadeInUp", "fadeInUpBig" => "fadeInUpBig", "fadeOut" => "fadeOut", "fadeOutDown" => "fadeOutDown", "fadeOutDownBig" => "fadeOutDownBig", "fadeOutLeft" => "fadeOutLeft", "fadeOutLeftBig" => "fadeOutLeftBig", "fadeOutRight" => "fadeOutRight", "fadeOutRightBig" => "fadeOutRightBig", "fadeOutUp" => "fadeOutUp", "fadeOutUpBig" => "fadeOutUpBig", "flip" => "flip", "flipInX" => "flipInX", "flipInY" => "flipInY", "flipOutX" => "flipOutX", "flipOutY" => "flipOutY", "lightSpeedIn" => "lightSpeedIn", "lightSpeedOut" => "lightSpeedOut", "rotateIn" => "rotateIn", "rotateInDownLeft" => "rotateInDownLeft", "rotateInDownRight" => "rotateInDownRight", "rotateInUpLeft" => "rotateInUpLeft", "rotateInUpRight" => "rotateInUpRight", "rotateOut" => "rotateOut", "rotateOutDownLeft" => "rotateOutDownLeft", "rotateOutDownRight" => "rotateOutDownRight", "rotateOutUpLeft" => "rotateOutUpLeft", "rotateOutUpRight" => "rotateOutUpRight", "slideInDown" => "slideInDown", "slideInLeft" => "slideInLeft", "slideInRight" => "slideInRight", "slideOutLeft" => "slideOutLeft", "slideOutRight" => "slideOutRight", "slideOutUp" => "slideOutUp", "hinge" => "hinge", "rollIn" => "rollIn", "rollOut" => "rollOut"),
	      "description" => __("Select one of counter align.", GETTEXT_DOMAIN)
	    ),	    
		
   )
));

?>