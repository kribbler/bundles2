<?php
/**
 * Grouped product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post;

$parent_product_post = $post;

$catalog_type = ot_get_option('catalog_type');
$product_options_catalog_btn_text = get_post_meta($post->ID, 'product_options_catalog_btn_text', true);
$product_options_catalog_btn_url = get_post_meta($post->ID, 'product_options_catalog_btn_url', true);

do_action( 'woocommerce_before_add_to_cart_form' ); ?>
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

<form class="cart lpd-cart grouped-cart<?php if($product_page_a_type){?> cre-animate<?php }?>" method="post" enctype='multipart/form-data'<?php if($product_page_a_type){ echo $animation_att;}?>>

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
						<?php if(!$catalog_type){?>
						<td>
							<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
								<?php woocommerce_template_loop_add_to_cart(); ?>
							<?php else : ?>
								<?php
									$quantites_required = true;
									woocommerce_quantity_input( array( 'input_name' => 'quantity[' . $product_id . ']', 'input_value' => '0' ) );
								?>
							<?php endif; ?>
						</td>
						<?php }?>

						<td class="label">
							<label for="product-<?php echo $product_id; ?>">
								<?php echo $product->is_visible() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : get_the_title(); ?>
							</label>
						</td>

						<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

						<?php if($catalog_type!="purchases_prices"){?>
						<td class="price">
							<span class="price-wrap">
							<?php
								echo $product->get_price_html();
							?>
							</span>
							<?php
								if ( ( $availability = $product->get_availability() ) && $availability['availability'] )
									echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
							?>
						</td>
						<?php }?>
					</tr>
					<?php
				endforeach;

				// Reset to parent grouped product
				$post    = $parent_product_post;
				$product = get_product( $parent_product_post->ID );
				setup_postdata( $parent_product_post );
			?>
		</tbody>
	</table>
</div>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	<?php if ( $quantites_required ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="wrap-group-button clearfix"><button type="submit" class="single_add_to_cart_button btn btn-primary"><?php echo $product->single_add_to_cart_text(); ?></button></div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
	
	<?php if($catalog_type){?>
	
		<?php if($product_options_catalog_btn_text){?>
		
		<div class="wrap-group-button clearfix"><a href="<?php if($product_options_catalog_btn_url) { echo $product_options_catalog_btn_url; } else{ echo '#';};?>" class="btn btn-primary"><?php echo $product_options_catalog_btn_text;?></a></div>
		
		<?php }?>
	
	<?php }?>
	
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>