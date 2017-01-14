<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>
<?php
if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
	echo 'daniel';
}
?>
<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	
	<form class="cart single-cart" method="post" enctype='multipart/form-data'>
	
		<?php do_action( 'woocommerce_add_compare_button' ); ?>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
		
		<div class="cart-wrap clearfix">
	
		 	<div class="cart-top clearfix">
			 	
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
					echo apply_filters( 'woocommerce_stock_html', '<div class="cart-stock">'.__( 'Availability', GETTEXT_DOMAIN).': <p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p></div>', $availability['availability'] );
			    endif;
			?>
			 	
		 	</div>
		 	
		 	<div class="cart-bottom clearfix">
			 	
				<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="cart-price">
				
					<span class="pr-label"><?php _e( 'Price', GETTEXT_DOMAIN);?>:</span>
				
					<p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
				
					<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
					<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
				
				</div>
		
		
			 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
		
			 	<button type="submit" class="single_add_to_cart_button button1 btn btn-normal btn-primary alt icon-button icon-button-16"><span class="livicon" data-n="shopping-cart" data-s="16" data-c="white" data-hc="0" data-onparent="true"></span><?php echo $product->single_add_to_cart_text(); ?></button>
			 	
		 	</div>
			
		</div>

	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	 	

	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php else: ?>	
	
<?php
	// Availability
	$availability = $product->get_availability();

	if ( $availability['availability'] )
		echo apply_filters( 'woocommerce_stock_html', '<div class="cart-stock cart-out-of-stock">'.__( 'Availability', GETTEXT_DOMAIN).': <p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p></div>', $availability['availability'] );
?>

<?php endif; ?>