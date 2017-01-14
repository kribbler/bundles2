<?php

/* the theme hooks */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'lpd_single_excerpt', 'woocommerce_template_single_excerpt', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
add_action( 'lpd_shop_content', 'lpd_product_archive_description', 10 );

remove_action('woocommerce_before_add_to_cart_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
if (is_plugin_active('woocommerce-compare-products-pro/compare_products.php')) {
	add_action('woocommerce_add_compare_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
}
remove_action('woocommerce_before_template_part', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
remove_action('woocommerce_after_shop_loop_item', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);

if ( ! function_exists( 'lpd_product_archive_description' ) ) {

	/**
	 * Show a shop page description on product archives
	 *
	 * @access public
	 * @subpackage	Archives
	 * @return void
	 */
	function lpd_product_archive_description() {
		if ( is_post_type_archive( 'product' ) && get_query_var( 'paged' ) == 0 ) {
			$shop_page   = get_post( wc_get_page_id( 'shop' ) );
			if ( $shop_page ) {
				$description = apply_filters( 'the_content', $shop_page->post_content );
				if ( $description ) {
					echo '<div class="page-description">' . $description . '</div>';
				}
			}
		}
	}
}

if ( ! function_exists( 'woocommerce_page_breadcrumb' ) ) {

	function woocommerce_page_breadcrumb( $args = array() ) {

		$defaults = apply_filters( 'woocommerce_breadcrumb_defaults', array(
			'delimiter'   => '&nbsp;&rarr; ',
			'wrap_before' => '',
			'wrap_after'  => '',
			'before'      => '',
			'after'       => '',
			'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
		) );

		$args = wp_parse_args( $args, $defaults );

		woocommerce_get_template( 'global/breadcrumb.php', $args );
	}
}

if ( ! function_exists( 'woocommerce_output_related_products' ) ) {
	function woocommerce_output_related_products() {
		$args = array(
			'posts_per_page' => 4,
			'columns' => 4,
			'orderby' => 'rand'
		);

		woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	}
}
add_action( 'lpd_single_output_related', 'woocommerce_output_related_products', 20 );

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		woocommerce_upsell_display( 4,4 );
	}
}
add_action( 'lpd_single_output_upsells', 'woocommerce_output_upsells', 15 ); // new function for up-sell

if ( ! function_exists( 'woocommerce_cross_sell_display' ) ) {

	function woocommerce_cross_sell_display( $posts_per_page = 3, $columns = 3, $orderby = 'rand' ) {
		wc_get_template( 'cart/cross-sells.php', array(
		
		'posts_per_page' => $posts_per_page,
		'orderby' => $orderby,
		'columns' => $columns
		
		) );
	}
}


function ptc_lpd_themes() {
	return 3;
}
add_filter ( 'woocommerce_product_thumbnails_columns', 'ptc_lpd_themes' ); 


function new_loop_shop_per_page() {

	$loop_shop_per_page= ot_get_option('loop_shop_per_page');

	if (!$loop_shop_per_page){
	    $loop_shop_per_page = 12;
	}
	
	return $loop_shop_per_page;

}
add_filter('loop_shop_per_page', 'new_loop_shop_per_page');


function woo_lts_lpd_themes() {			

	$product_image_type= ot_get_option('product_image_type');
				
	if($product_image_type=="none"){
		return 'shop_catalog';
	}else{
		if($product_image_type=="portrait"){
			return 'front-shop-thumb';	
		}else{
			return 'front-shop-thumb2';
		}
	}
	
}
add_filter ( 'single_product_large_thumbnail_size', 'woo_lts_lpd_themes' ); 


function woo_sts_lpd_themes() {	

	$product_thumb_type= ot_get_option('product_thumb_type');
	
	if($product_thumb_type=="none"){
		return 'shop_catalog';
	}else{		
		if($product_thumb_type=="portrait"){
			return 'front-shop-thumb';	
		}else{
			return 'front-shop-thumb2';
		}
	}
	
}
add_filter ( 'single_product_small_thumbnail_size', 'woo_sts_lpd_themes' );


if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post,$product;
		
		$shop_thumb_type = ot_get_option('shop_thumb_type');
		$catalog_type = ot_get_option('catalog_type');
		$thumbnail_filter = ot_get_option('thumbnail_filter');

		$output = '';
		
		if ( has_post_thumbnail() ){
		
			if($shop_thumb_type=="none"){
			
				$thumbnail = get_the_post_thumbnail( $post->ID, $size );
			
			}else{
			
				if($shop_thumb_type=="portrait"){
					$thumbnail = get_the_post_thumbnail( $post->ID, 'front-shop-thumb' );	
				}else{
					$thumbnail = get_the_post_thumbnail( $post->ID, 'front-shop-thumb2' );
				}
			
			}
			
			$output .= '<a class="img-transaction" href="'.get_permalink().'">';
				$output .= '<div class="featured-img">';
					$output .= $thumbnail;
				$output .= '</div>';
				$output .= '<div class="gallery-img">';
					$attachment_ids = $product->get_gallery_attachment_ids();
					if($attachment_ids){
						$loop = 0;
						foreach ( $attachment_ids as $attachment_id ) {
							$loop++;
							$image_link = wp_get_attachment_url( $attachment_id );
							if ( ! $image_link )continue;
							if ($loop==1)
							
							if($shop_thumb_type=="none"){
							
								$output .= wp_get_attachment_image( $attachment_id, $size );
							
							}else{
							
								if($shop_thumb_type=="portrait"){
									$output .= wp_get_attachment_image( $attachment_id, 'front-shop-thumb' );	
								}else{
									$output .= wp_get_attachment_image( $attachment_id, 'front-shop-thumb2' );
								}
							
							}
							
						}
					} else{
						$output .= $thumbnail;
					}
				$output .= '</div>';
				if($thumbnail_filter){
					$output .= '<div class="white_isolated"></div>';
				}
			$output .= '</a>';
			
		} elseif ( wc_placeholder_img_src() ){
		
			$thumbnail = '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="580" height="580" />';
			
			$output .= '<a href="'.get_permalink().'">';
				$output .= '<div class="featured-img">';
					#$output .= wc_placeholder_img( $size );
					$output .= $thumbnail;
				$output .= '</div>';
			$output .= '</a>';
			
		}
		
		$add_to_cart_button = '';

		if($product->is_purchasable()){
			$add_to_cart_button = ' add_to_cart_button';
		}
		
		#$output .= '<a href="'.esc_url( $product->add_to_cart_url() ).'" rel="nofollow" data-product_id="'.esc_attr( $product->id ).'" data-product_sku="'.esc_attr( $product->get_sku() ).'" class="btn btn-primary '.$add_to_cart_button.' product_type_'.esc_attr( $product->product_type ).'">'.esc_html( $product->add_to_cart_text() ).'</a>';
		
		#if( $product->get_price() === '' && $product->product_type != 'external' ) return;
		
		
		if ( ! $product->is_in_stock() ){
				
			$output .= '<a href="'.get_permalink($product->id).'" class="loop-shop-btn">'.apply_filters('out_of_stock_add_to_cart_text', __('Read More', 'woocommerce')).'</a>';
		
		} else{
			
				switch ( $product->product_type ) {
					case "variable" :
						$link 	= get_permalink($product->id);
						$label 	= apply_filters('variable_add_to_cart_text', __('Select options', 'woocommerce'));
					break;
					case "grouped" :
						$link 	= get_permalink($product->id);
						$label 	= apply_filters('grouped_add_to_cart_text', __('View options', 'woocommerce'));
					break;
					case "external" :
						$link 	= get_permalink($product->id);
						$label 	= apply_filters('external_add_to_cart_text', __('Read More', 'woocommerce'));
					break;
					default :
					if(!$catalog_type){
						$link 	= esc_url( $product->add_to_cart_url() );
						$label 	= apply_filters('add_to_cart_text', __('Add to cart', 'woocommerce'));
					}else{
						$link 	= get_permalink($product->id);
						$label 	= apply_filters('add_to_cart_text', __('Read More', 'woocommerce'));
					}
					break;
				}
				
				if ( $product->product_type == 'simple' ) {
					
					/*quantaty form
					
					$output .= '<form action="'.esc_url( $product->add_to_cart_url() ).'" class="cart" method="post" enctype="multipart/form-data">';
				
					 	woocommerce_quantity_input();
				
					 	$output .= '<button type="submit" class="button alt">'.$label.'</button>';
				
					$output .= '</form>';*/
					
					if(!$catalog_type){
					
					$output .= '<a href="'.$link.'" rel="nofollow" data-product_id="'.$product->id.'" data-if_added="'.__('Added', 'woocommerce').'" class="loop-shop-btn'.$add_to_cart_button.' product_type_'.$product->product_type.'">'.$label.'</a>';
					
					} else{
					
					$output .= '<a href="'.$link.'" rel="nofollow" data-product_id="'.$product->id.'" class="loop-shop-btn'.$add_to_cart_button.' product_type_'.$product->product_type.'_catalog">'.$label.'</a>';
					
					}
					
				} else {
					
					$output .= '<a href="'.$link.'" rel="nofollow" data-product_id="'.$product->id.'" class="loop-shop-btn'.$add_to_cart_button.' product_type_'.$product->product_type.'">'.$label.'</a>';
					
				}
		
		
		}
				
		return $output;
	}
}

add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {
    $upload_dir = wp_upload_dir();
    $uploads = THEME_ASSETS;
    $src = $uploads . '/img/no-product-image.png';
    return $src;
}

add_filter('add_to_cart_fragments', 'lpd_add_to_cart_fragments');
 
function lpd_add_to_cart_fragments( $fragments ) {
	global $woocommerce;
	ob_start();?>
		
	<div class="lpd-shopping-cart">
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart-total visible-xs visible-sm">
			<strong><?php _e('Shopping Bag', GETTEXT_DOMAIN); ?></strong>
			<?php echo WC()->cart->get_cart_contents_count(); ?> <?php _e('item(s)', GETTEXT_DOMAIN); ?> - <?php echo WC()->cart->get_cart_subtotal(); ?>
		</a>
		<a href="#" class="cart-button hidden-xs hidden-sm">
			<span class="cart-button-total"><?php _e('Cart', GETTEXT_DOMAIN); ?> / <?php echo WC()->cart->get_cart_subtotal(); ?></span>
			<span class="cart-icon">
				<span class="icon"></span>
				<span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			</span>
		</a>
		<div class="cart-dropdown hidden-xs hidden-sm css-transition-all-3-1">
			
			<div class="lpd-shopping-cart-list clearfix">
			
				<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
			
					<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			
								$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
			
								?>
								<div class="lpd-cart-list-item clearfix">
									<a class="lpd-cart-list-thumbnail" href="<?php echo get_permalink( $product_id ); ?>">
										<?php echo $thumbnail; ?>
									</a>
									<div class="lpd-cart-list-content">
										<div class="lpd-cart-list-title">
											<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo $product_name; ?></a>
										</div>
										<?php echo WC()->cart->get_item_data( $cart_item ); ?>
										<div class="lpd-cart-list-meta">
											<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">%s</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', GETTEXT_DOMAIN), __('Remove', GETTEXT_DOMAIN) ), $cart_item_key );?>
											<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
										</div>
									</div>
								</div>
								<?php
							}
						}
					?>
			
				<?php else : ?>
			
					<p class="empty"><?php _e( 'No products in the cart.', GETTEXT_DOMAIN ); ?></p>
			
				<?php endif; ?>
			
			</div>

			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
			
				<p class="lpd-cart-total clearfix"><strong><?php _e( 'Subtotal', GETTEXT_DOMAIN ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
			
				<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
			
				<p class="lpd-cart-buttons">
					<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="btn btn-default btn-sm view-cart-btn"><?php _e( 'View Cart', GETTEXT_DOMAIN ); ?></a>
					<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="btn btn-primary checkout-btn"><?php _e( 'Checkout', GETTEXT_DOMAIN ); ?></a>
				</p>
			
			<?php endif; ?>
			
		</div>
	</div>
		
	<?php $fragments['.lpd-shopping-cart'] = ob_get_clean();
	return $fragments;
}


?>