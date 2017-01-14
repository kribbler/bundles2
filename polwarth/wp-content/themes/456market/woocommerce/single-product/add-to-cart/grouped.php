<?php
/**
 * Grouped product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data'>

<?php do_action( 'woocommerce_add_compare_button' ); ?>

<div class="group-table-wrap">
	<table cellspacing="0" class="group_table">
		<tbody>
			<?php
				foreach ( $grouped_products as $product_id ) :
					$product = get_product( $product_id );
					$post    = $product->post;
					setup_postdata( $post );
					?>
					<tr>
						<td>
							<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
								<?php woocommerce_template_loop_add_to_cart(); ?>
							<?php else : ?>
							<span class="qt-label"><?php _e( 'Quantity', GETTEXT_DOMAIN );?></span>
								<?php
									$quantites_required = true;
									woocommerce_quantity_input( array( 'input_name' => 'quantity[' . $product_id . ']', 'input_value' => '0' ) );
								?>
							<?php endif; ?>
						</td>

						<td class="label">
							<label for="product-<?php echo $product_id; ?>">
								<?php echo $product->is_visible() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : get_the_title(); ?>
							</label>
						</td>

						<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

						<td class="price">
							<?php
								echo $product->get_price_html();

								if ( ( $availability = $product->get_availability() ) && $availability['availability'] )
									echo apply_filters( 'woocommerce_stock_html', '<small class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</small>', $availability['availability'] );
							?>
						</td>
					</tr>
					<?php
				endforeach;

				// Reset to parent grouped product
				wp_reset_postdata();
				$product = get_product( $post->ID );
			?>
		</tbody>
	</table>
</div>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
		
	<?php if ( $quantites_required ) : ?>
	
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
	
		<div class="wrap-group-button clearfix"><button type="submit" class="single_add_to_cart_button button1 btn btn-normal btn-primary alt icon-button icon-button-16"><span class="livicon" data-n="shopping-cart" data-s="16" data-c="white" data-hc="0" data-onparent="true"></span><?php echo $product->single_add_to_cart_text(); ?></button></div>
	
		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php endif; ?>
	
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>