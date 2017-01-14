<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>
<?php $product_bottom_a_type = ot_get_option('product_bottom_a_type');
$product_bottom_a_speed = ot_get_option('product_bottom_a_speed');
$product_bottom_a_delay = ot_get_option('product_bottom_a_delay');
$product_bottom_a_offset = ot_get_option('product_bottom_a_offset');
$product_bottom_a_easing = ot_get_option('product_bottom_a_easing');

if(!$product_bottom_a_speed){
	$product_bottom_a_speed = '1000';
}
if(!$product_bottom_a_delay){
	$product_bottom_a_delay = '0';
}

if(!$product_bottom_a_offset){
	$product_bottom_a_offset = '80';
}

$animation_att = ' data-animation="'.$product_bottom_a_type.'" data-speed="'.$product_bottom_a_speed.'" data-delay="'.$product_bottom_a_delay.'" data-offset="'.$product_bottom_a_offset.'" data-easing="'.$product_bottom_a_easing.'"';

?>

		<div class="lpd-related lpd-products">
	
			<h2 class="lpd-heading-title<?php if($product_bottom_a_type){?> cre-animate<?php }?>"<?php if($product_bottom_a_type){ echo $animation_att;}?>><span><?php _e( 'Related Products', 'woocommerce' ); ?></span></h2>
	
			<?php woocommerce_product_loop_start(); ?>
	
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
	
					<?php wc_get_template_part( 'content', 'product' ); ?>
	
				<?php endwhile; // end of the loop. ?>
	
			<?php woocommerce_product_loop_end(); ?>
	
		</div>

<?php endif;

wp_reset_postdata();
