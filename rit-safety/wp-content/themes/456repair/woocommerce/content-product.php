<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
$shop_columns = ot_get_option('shop_columns');
$s_rating = ot_get_option('s_rating');
$catalog_type = ot_get_option('catalog_type');

$shop_thumb_a_type = ot_get_option('shop_thumb_a_type');
$shop_thumb_a_speed = ot_get_option('shop_thumb_a_speed');
$shop_thumb_a_delay = ot_get_option('shop_thumb_a_delay');
$shop_thumb_a_offset = ot_get_option('shop_thumb_a_offset');
$shop_thumb_a_easing = ot_get_option('shop_thumb_a_easing');

if(!$shop_thumb_a_speed){
	$shop_thumb_a_speed = '1000';
}
if(!$shop_thumb_a_delay){
	$shop_thumb_a_delay = '0';
}

if(!$shop_thumb_a_offset){
	$shop_thumb_a_offset = '80';
}

$animation_att = ' data-animation="'.$shop_thumb_a_type.'" data-speed="'.$shop_thumb_a_speed.'" data-delay="'.$shop_thumb_a_delay.'" data-offset="'.$shop_thumb_a_offset.'" data-easing="'.$shop_thumb_a_easing.'"';

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )

	if(!$shop_columns)
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	else
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $shop_columns );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ($woocommerce_loop['columns'] == "2"){
	$classes[] = 'col-md-6';
} elseif ($woocommerce_loop['columns'] == "3"){
	$classes[] = 'col-md-4';	
} elseif ($woocommerce_loop['columns'] == "4"){
	$classes[] = 'col-md-3';	
} else{
	$classes[] = 'col-md-3';	
}
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
	
if($shop_thumb_a_type){
	$classes[] = 'cre-animate';
}
?>
<li <?php post_class( $classes ); ?><?php if($shop_thumb_a_type){ echo $animation_att;}?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<?php woocommerce_show_product_loop_sale_flash(); ?>
	
	<?php if ( ! $product->is_in_stock() ) : ?>
		<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
	<?php endif; ?>

	<div class="lpd-product-thumbnail">

	<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
	?>
	
	</div>

	<h3><?php the_title(); ?></h3>

	<?php
		if($catalog_type!="purchases_prices"){
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		}
	?>
	
	<div class="clearfix"></div>
	
	<?php
		if(!$s_rating){
			woocommerce_template_loop_rating();
		}
	?>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>