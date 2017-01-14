<?php

/* 
 
 
function swap_variable_add_to_cart() {

	global $post, $_product;
	$jigoshop_options = Jigoshop_Base::get_options();

	$attributes = $_product->get_available_attributes_variations();

	//get all variations available as an array for easy usage by javascript
	$variationsAvailable = array();
	$children = $_product->get_children();

	foreach($children as $child) {
		// @var $variation jigoshop_product_variation/
		$variation = $_product->get_child( $child );
		if($variation instanceof jigoshop_product_variation) {
			$vattrs = $variation->get_variation_attributes();
			$availability = $variation->get_availability();

			//@todo needs to be moved to jigoshop_product_variation class
			if (has_post_thumbnail($variation->get_variation_id())) {
				$attachment_id = get_post_thumbnail_id( $variation->get_variation_id() );
				$large_thumbnail_size = apply_filters('single_product_large_thumbnail_size', 'shop_large');
				$image = wp_get_attachment_image_src( $attachment_id, $large_thumbnail_size);
				if ( ! empty( $image ) ) $image = $image[0];
				$image_link = wp_get_attachment_image_src( $attachment_id, 'full');
				if ( ! empty( $image_link ) ) $image_link = $image_link[0];
			} else {
				$image = '';
				$image_link = '';
			}

			$a_weight = $a_length = $a_width = $a_height = '';

			if ( $variation->get_weight() ) {
				$a_weight = '
					<tr class="weight">
						<th>Weight</th>
						<td>'.$variation->get_weight().$jigoshop_options->get_option('jigoshop_weight_unit').'</td>
					</tr>';
			}

			if ( $variation->get_length() ) {
				$a_length = '
					<tr class="length">
						<th>Length</th>
						<td>'.$variation->get_length().$jigoshop_options->get_option('jigoshop_dimension_unit').'</td>
					</tr>';
			}

			if ( $variation->get_width() ) {
				$a_width = '
					<tr class="width">
						<th>Width</th>
						<td>'.$variation->get_width().$jigoshop_options->get_option('jigoshop_dimension_unit').'</td>
					</tr>';
			}

			if ( $variation->get_height() ) {
				$a_height = '
					<tr class="height">
						<th>Height</th>
						<td>'.$variation->get_height().$jigoshop_options->get_option('jigoshop_dimension_unit').'</td>
					</tr>
				';
			}

			$variationsAvailable[] = array(
				'variation_id'     => $variation->get_variation_id(),
				'sku'              => '<div class="sku">'.__('SKU','jigoshop').': ' . $variation->get_sku() . '</div>',
				'attributes'       => $vattrs,
				'in_stock'         => $variation->is_in_stock(),
				'image_src'        => $image,
				'image_link'       => $image_link,
				'price_html'       => '<span class="price">'.$variation->get_price_html().'</span>',
				'availability_html'=> '<p class="stock ' . esc_attr( $availability['class'] ) . '">'. $availability['availability'].'</p>',
				'a_weight'         => $a_weight,
				'a_length'         => $a_length,
				'a_width'          => $a_width,
				'a_height'         => $a_height,
			);
		}
	}

	?>
	<script type="text/javascript">
		var product_variations = <?php echo json_encode($variationsAvailable) ?>;
	</script>
	<?php $default_attributes = $_product->get_default_attributes() ?> 
	<form action="<?php echo esc_url( $_product->add_to_cart_url() ); ?>" class="variations_form cart" method="post">
		<fieldset class="variations">
			<?php foreach ( $attributes as $name => $options ): ?>
				<?php $sanitized_name = sanitize_title( $name ); ?>
				<div>
					<span class="select_label"><?php // echo jigoshop_product::attribute_label('pa_'.$name); ?></span>
					<select id="<?php echo esc_attr( $sanitized_name ); ?>" name="tax_<?php echo $sanitized_name; ?>">
						<option value=""><?php echo __('Select Product ', 'jigoshop') ?>&hellip;</option>

						<?php if ( empty( $_POST ) ): ?>
								<?php $selected_value = ( isset( $default_attributes[ $sanitized_name ] ) ) ? $default_attributes[ $sanitized_name ] : ''; ?>
						<?php else: ?>
								<?php $selected_value = isset( $_POST[ 'tax_' . $sanitized_name ] ) ? $_POST[ 'tax_' . $sanitized_name ] : ''; ?>
						<?php endif; ?>

						<?php foreach ( $options as $value ) : ?>
							<?php if ( taxonomy_exists( 'pa_'.$sanitized_name )) : ?>
								<?php $term = get_term_by( 'slug', $value, 'pa_'.$sanitized_name ); ?>
								<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $selected_value, $term->slug) ?>><?php echo $term->name; ?></option>
							<?php else :
								$display_value = apply_filters('jigoshop_product_attribute_value_custom',esc_attr(sanitize_text_field($value)),$sanitized_name);
							?>
								<option value="<?php echo $value; ?>"<?php selected( $selected_value, $value) ?> ><?php echo $display_value; ?></option>
							<?php endif;?>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endforeach;?>
		</fieldset>
		<div class="single_variation"></div>
		<?php do_action('jigoshop_before_add_to_cart_form_button'); ?>
		<div class="variations_button" style="display:none;">
			<input type="hidden" name="variation_id" value="" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<div class="quantity"><input name="quantity" value="1" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>
			<input type="submit" class="button-alt" value="<?php esc_html_e('Add to cart', 'jigoshop'); ?>" />
			<img src="<?php bloginfo('template_url'); ?>/images/cart-sm-gray.png" style="  margin: 5px 0px 10px 10px;">
		</div>
		<?php  do_action('jigoshop_add_to_cart_form'); ?>
	</form>
	<?php
} 
*/

?>