<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post, $product;

$catalog_type = ot_get_option('catalog_type');
$product_options_catalog_btn_text = get_post_meta($post->ID, 'product_options_catalog_btn_text', true);
$product_options_catalog_btn_url = get_post_meta($post->ID, 'product_options_catalog_btn_url', true);

?>
<?php $product_page_a_type = ot_get_option('product_page_a_type');
$product_page_a_speed = ot_get_option('product_page_a_speed');
$product_page_a_delay = ot_get_option('product_page_a_delay');
$product_page_a_offset = ot_get_option('product_page_a_offset');
$product_page_a_easing = ot_get_option('product_page_a_easing');

if(!$product_page_a_speed){
	$product_page_a_speed = '1000';
}
if(!$product_page_a_delay){
	$product_page_a_delay = '0';
}

if(!$product_page_a_offset){
	$product_page_a_offset = '80';
}

$animation_att = ' data-animation="'.$product_page_a_type.'" data-speed="'.$product_page_a_speed.'" data-delay="'.$product_page_a_delay.'" data-offset="'.$product_page_a_offset.'" data-easing="'.$product_page_a_easing.'"';

?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<?php if($catalog_type!="purchases_prices"||$product_options_catalog_btn_text!=''){?>

<div class="external-cart clearfix <?php if (!$product->get_price_html()){?>no-price<?php } ?><?php if($product_page_a_type){?> cre-animate<?php }?>"<?php if($product_page_a_type){ echo $animation_att;}?>>
	<?php if($catalog_type!="purchases_prices"){?>
		<?php if ($product->get_price_html()){?>
		<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="cart-price">
		
			<p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
		
			<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
			<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
		
		</div>
		<?php } ?>
	<?php } ?>
	<?php if(!$catalog_type){?>
	<p class="cart">
		<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button btn btn-primary"><?php echo $button_text; ?></a>
	</p>
	<?php } ?>
	<?php if($catalog_type){?>
	
		<?php if($product_options_catalog_btn_text){?>
		<p class="cart" <?php if($catalog_type=="purchases_prices"){?> style="float:left"<?php }?>>
			<a href="<?php if($product_options_catalog_btn_url) { echo $product_options_catalog_btn_url; } else{ echo '#';};?>" class="btn btn-primary"><?php echo $product_options_catalog_btn_text;?></a>
		</p>
		<?php }?>
	
	<?php }?>
</div>

<?php } ?>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>