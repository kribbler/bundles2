<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart single-cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>

	<?php do_action( 'woocommerce_add_compare_button' ); ?>
		
	<div class="row-fluid">
	
		<div class="span8">
			<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value"><select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" class="form-control" name="attribute_<?php echo sanitize_title( $name ); ?>">
							<option value=""><?php echo __( 'Choose an option', GETTEXT_DOMAIN ) ?>&hellip;</option>
							<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $name ) ) {

										$orderby = wc_attribute_orderby( $name );

										switch ( $orderby ) {
											case 'name' :
												$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
											break;
											case 'id' :
												$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
											break;
											case 'menu_order' :
												$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
											break;
										}

										$terms = get_terms( $name, $args );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) )
												continue;

											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}
									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								}
							?>
						</select>
						</td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>
		</div>
		<div class="span4">	
		<?php
			if ( sizeof($attributes) == $loop )
				echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', GETTEXT_DOMAIN ) . '</a>';
		?>
		</div>
	</div>
		
	<div class="cart-wrap">
	
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

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
			<div class="single_variation" style="display: none"></div>

			<div class="variations_button">
				<div class="variations_button_wrap clearfix">
					<!--<span class="qt-label"><?php _e( 'Quantity', GETTEXT_DOMAIN );?></span><?php woocommerce_quantity_input(); ?>-->

					<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="cart-price">
				
						<span class="pr-label"><?php _e( 'Price', GETTEXT_DOMAIN);?>:</span>
					
						<p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
					
						<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
						<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
					
					</div>

					<button type="submit" class="single_add_to_cart_button btn btn-normal btn-primary button1 alt icon-button icon-button-16"><span class="livicon" data-n="shopping-cart" data-s="16" data-c="white" data-hc="0" data-onparent="true"></span><?php echo $product->single_add_to_cart_text(); ?></button>
				</div>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		
	</div>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', GETTEXT_DOMAIN ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

