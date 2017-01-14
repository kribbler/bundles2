<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post, $product;

if ( ! $product->is_purchasable() ) return;

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

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	
	<?php if($catalog_type!="purchases_prices"||$product_options_catalog_btn_text!=''){?>
	
	<form class="cart lpd-cart single-cart<?php if($product_page_a_type){?> cre-animate<?php }?>" method="post" enctype='multipart/form-data'<?php if($product_page_a_type){ echo $animation_att;}?>>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
		
		<div class="cart-wrap clearfix">
		
		 	<?php if(!$catalog_type){?>
		 	
		 	<?php  if ( 'no' == $product->sold_individually ) :?>
		 	
			 	<div class="cart-top clearfix">
	
				<div class="lpd-quantity"><?php _e('Quantity ', 'woocommerce') ?></div>
			 	<?php
			 		if ( ! $product->is_sold_individually() )
			 			woocommerce_quantity_input( array(
			 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
			 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
			 			) );
			 	?>
			 	
			 	<?php
					// Availability
					$availability = $product->get_availability();
				
					if ($availability['availability']) :
						echo apply_filters( 'woocommerce_stock_html', '<div class="cart-stock">'.__( 'Availability', 'woocommerce').': <p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p></div>', $availability['availability'] );
				    endif;
				?>
				 	
			 	</div>
		 	
		 	<?php endif; ?>

		 	<?php }?>
		 	
		 	<div class="cart-bottom clearfix<?php  if ( 'yes' == $product->sold_individually ) :?> lpd-sold_individually<?php endif; ?><?php if($catalog_type){?> lpd-sold_individually<?php }?>">
			 	
				<?php if($catalog_type!="purchases_prices"){?>
				
				<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="cart-price">

					<p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
				
					<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
					<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
				
				</div>
				
				<?php }?>
				
				<?php if($catalog_type){?>
				
					<?php if($product_options_catalog_btn_text){?>
					
					<a href="<?php if($product_options_catalog_btn_url) { echo $product_options_catalog_btn_url; } else{ echo '#';};?>" class="btn btn-primary"<?php if($catalog_type=="purchases"){?> style="float:right"<?php }?>><?php echo $product_options_catalog_btn_text;?></a>
					
					<?php }?>
				
				<?php }?>
		
				<?php if(!$catalog_type){?>
			 	
			 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
		
			 	<button type="submit" class="single_add_to_cart_button btn btn-primary"><?php echo $product->single_add_to_cart_text(); ?></button>
			 	
			 	<?php }?>
			 	
		 	</div>
			
		</div>

	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	 	
	</form>
	
	<?php }?>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php else: ?>

<?php if($catalog_type!="purchases_prices"||$product_options_catalog_btn_text!=''){?>

	
		<div class="clearfix lpd-out-of-stock<?php if($product_page_a_type){?> cre-animate<?php }?>"<?php if($product_page_a_type){ echo $animation_att;}?>>
			
			<?php if($catalog_type!="purchases_prices"){?><p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p><?php }?>
	
			<?php if(!$catalog_type){?>
			<?php
				// Availability
				$availability = $product->get_availability();
			
				if ( $availability['availability'] )
					echo apply_filters( 'woocommerce_stock_html', '<div class="cart-stock cart-out-of-stock">'.__( 'Availability', 'woocommerce').': <p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p></div>', $availability['availability'] );
			?>
			<?php }?>
			
			
			<?php if($catalog_type){?>
			
				<?php if($product_options_catalog_btn_text){?>
				
				<a href="<?php if($product_options_catalog_btn_url) { echo $product_options_catalog_btn_url; } else{ echo '#';};?>" class="btn btn-primary"<?php if($catalog_type=="purchases"){?> style="float:right"<?php }?>><?php echo $product_options_catalog_btn_text;?></a>
				
				<?php }?>
			
			<?php }?>
			
		</div>
	
	
<?php }?>

<?php endif; ?>