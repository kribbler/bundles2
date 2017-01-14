<?php

function vc_woo_carousel_product_categories_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns' 	 => '4',
			'hide_empty' => 1,
			'parent'     => '',
		
   'carousel_autoheight' => '',
   'carousel_margin' => '',
   'carousel_navi' => '',
   'carousel_dots_navi' => '',
   'carousel_autoplay' => '',
   'carousel_autoplaytimeout' => '',
   'carousel_autoplayhoverpause' => '',
   'carousel_loop' => '',
		
   ), $atts ) );
   
   		global $woocommerce_loop;
   
		if ( isset( $atts[ 'ids' ] ) ) {
			$ids = explode( ',', $atts[ 'ids' ] );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( $parent !== "" ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		$woocommerce_loop['columns'] = $columns;
		
		global $shortcode_atts;
		
		$shortcode_atts = array(
			'carousel_autoheight' => $carousel_autoheight,
		  'carousel_margin' => $carousel_margin,
		  'carousel_navi' => $carousel_navi,
		  'carousel_dots_navi' => $carousel_dots_navi,
		  'carousel_autoplay' => $carousel_autoplay,
		  'carousel_autoplaytimeout' => $carousel_autoplaytimeout,
		  'carousel_autoplayhoverpause' => $carousel_autoplayhoverpause,
		  'carousel_loop' => $carousel_loop,
		  'columns' => $columns,
		);
		
		lpd_owl_carousel();
		
		global $carousel_product_categories_ID;
		
		$carousel_product_categories_ID = rand();

		ob_start(); ?>		

		<?php // Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

		if ( $product_categories ) {?>

			<div class="row"><ul class="lpd-products owl-carousel-<?php echo $carousel_product_categories_ID;?>">

			<?php foreach ( $product_categories as $category ) {

				wc_get_template( 'content-product_cat.php', array(
					'category' => $category
				) );

			}?>

			</ul></div>

		<?php }
		
		$counter_js = new carousel_product_categories_class();
		
		$counter_js->carousel_product_categories_callback();

		woocommerce_reset_loop();

		return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';

}
add_shortcode( 'vc_woo_carousel_product_categories', 'vc_woo_carousel_product_categories_func' );

class carousel_product_categories_class
{
    protected static $var = '';

    public static function carousel_product_categories_callback(){
    
	global $carousel_product_categories_ID;
	
	global $shortcode_atts;
	
	$carousel_autoheight = $shortcode_atts['carousel_autoheight'];
	$carousel_margin = $shortcode_atts['carousel_margin'];
	$carousel_navi = $shortcode_atts['carousel_navi'];
	$carousel_dots_navi = $shortcode_atts['carousel_dots_navi'];
	$carousel_autoplay = $shortcode_atts['carousel_autoplay'];
	$carousel_autoplaytimeout = $shortcode_atts['carousel_autoplaytimeout'];
	$carousel_autoplayhoverpause = $shortcode_atts['carousel_autoplayhoverpause'];
	$carousel_loop = $shortcode_atts['carousel_loop'];
	$columns = $shortcode_atts['columns'];
	
		ob_start();?>
		
		<script>
		/* <![CDATA[ */
            jQuery(document).ready(function() {
              jQuery('.owl-carousel-<?php echo $carousel_product_categories_ID;?>').owlCarousel({
                <?php if ( $columns ) { ?>items: <?php echo $columns;?>,<?php }?>
                <?php if ( $carousel_margin ) { ?>margin: <?php echo $carousel_margin;?>,<?php }?>
                <?php if ( $carousel_autoheight ) { ?>autoHeight: true,<?php }?>
                <?php if ( $carousel_navi ) { ?>nav:true,<?php }?>
                <?php if ( !$carousel_dots_navi ) { ?>dots:false,<?php }?>
                <?php if ( $carousel_autoplay ) { ?>autoplay:true,<?php }?>
                <?php if ( $carousel_autoplaytimeout ) { ?>autoplayTimeout: <?php echo $carousel_autoplaytimeout;?>,<?php }?>
                <?php if ( $carousel_autoplayhoverpause ) { ?>autoplayHoverPause:true,<?php }?>
                <?php if ( $carousel_loop ) { ?>loop:true,<?php }?>
                navText : ['<?php _e('prev', GETTEXT_DOMAIN); ?>','<?php _e('next', GETTEXT_DOMAIN); ?>'],
			    <?php if ( $columns ) { ?>
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			        },
			        768:{
			            items:<?php echo $columns;?>,    
			        }
			    }<?php }?>
              });
            })
		/* ]]> */
		</script>

		
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
   "name" => __("Product Categories Carousel", GETTEXT_DOMAIN),
   "base" => "vc_woo_carousel_product_categories",
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
			 "heading" => __("Number", GETTEXT_DOMAIN),
			 "param_name" => "number",
			 "value" => "",
			 "description" => __("Enter the number of products", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Name", GETTEXT_DOMAIN) => "name" ),
      "description" => sprintf(__('Select how to sort product categories. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order way", GETTEXT_DOMAIN),
      "param_name" => "order",
      "value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Columns", GETTEXT_DOMAIN),
      "param_name" => "columns",
      "value" => array( '2' => "2", '3' => "3", '4' => "4" )
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Hide Empty", GETTEXT_DOMAIN),
      "param_name" => "hide_empty",
      "value" => array( __("Yes", GETTEXT_DOMAIN) => "1", __("No", GETTEXT_DOMAIN) => "0" ),
    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("IDs", GETTEXT_DOMAIN),
			 "param_name" => "ids",
			 "value" => "",
			 "description" => __("Enter comma-separated category ids you want to display", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Vertical Margin", GETTEXT_DOMAIN),
			 "param_name" => "carousel_margin",
			 "value" => '30',
			 "description" => __("Vertical gap between items, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN),
			 "dependency" => Array('element' => "carousel", 'value' => 'enable')
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("autoHeight", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoheight",
	      "description" => __("Enable auto height for carousel container.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Navigation", GETTEXT_DOMAIN),
	      "param_name" => "carousel_navi",
	      "description" => __("Show next/prev buttons.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Dots Navigation", GETTEXT_DOMAIN),
	      "param_name" => "carousel_dots_navi",
	      "description" => __("Show dots navigation.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Loop", GETTEXT_DOMAIN),
	      "param_name" => "carousel_loop",
	      "description" => __("Inifnity loop. Duplicate last and first items to get loop illusion.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Autoplay", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoplay",
	      "description" => __("Check, if you wish to enable autoplay function for carousel plugin.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("autoplayTimeout", GETTEXT_DOMAIN),
			 "param_name" => "carousel_autoplaytimeout",
			 "value" => '',
			 "description" => __("Autoplay interval timeout in (ms), only integers (ex: 1000, 5000, 10000).", GETTEXT_DOMAIN),
			 "dependency" => Array('element' => "carousel_autoplay", 'value' => 'enable')
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("autoplayHoverPause", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoplayhoverpause",
	      "description" => __("Pause on mouse hover.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel_autoplay", 'value' => 'enable')
	    ),

   )
));

?>