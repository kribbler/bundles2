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

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form lpd-cart cart<?php if($product_page_a_type){?> cre-animate<?php }?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>"<?php if($product_page_a_type){ echo $animation_att;}?>>
	<?php if ( ! empty( $available_variations ) ) : ?>
		
	<div class="row">
		<div class="col-md-8">	
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value"><select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" class="form-control" name="attribute_<?php echo sanitize_title( $name ); ?>">
							<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
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
		<?php if(!$catalog_type||$product_options_catalog_btn_text!=''){?>
			<div class="col-md-4 clear-selection">	
			<?php
				if ( sizeof($attributes) == $loop )
					echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
			?>
			</div>
		<?php }?>
	</div>
		
	<div class="variable-cart-wrap">
	
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<?php if($catalog_type!="purchases_prices"){?>
			
				<?php if($product->min_variation_price!=$product->max_variation_price){?>
	
				<div class="single_variation clearfix"></div>
				
				<?php } else{?>
				
				<div class="single_variation_equal clearfix">
					<span class="price">
						<?php echo $product->get_price_html(); ?>
					</span>
					<div class="single_variation"></div>
				</div>
				
				<?php }?>
			
			<?php }?>

			<?php if(!$catalog_type||$product_options_catalog_btn_text!=''){?>
			
			<div class="variations_button">
				
				<?php if(!$catalog_type){?>
				
				<div class="variations_button_wrap clearfix">
					<span class="lpd-quantity"><?php _e( 'Quantity', 'woocommerce' );?></span><?php woocommerce_quantity_input(); ?>
					<button type="submit" class="single_add_to_cart_button btn btn-primary"><?php echo $product->single_add_to_cart_text(); ?></button>
				</div>
				
				<?php }?>
				
				<?php if($catalog_type){?>
				
					<?php if($product_options_catalog_btn_text){?>
					
					<div class="variations_button_wrap clearfix">
						<a href="<?php if($product_options_catalog_btn_url) { echo $product_options_catalog_btn_url; } else{ echo '#';};?>" class="btn btn-primary" style="float:left"><?php echo $product_options_catalog_btn_text;?></a>
					</div>
					
					<?php }?>
				
				<?php }?>
				
			</div>
			
			<?php }?>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		
	</div>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
