<?php

if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {
	add_filter('body_class','my_class_names');
	function my_class_names($classes) {
		$classes[] = 'woocommerce-456market';
		return $classes;
	}
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
add_action( 'woocommerce_catalog_ordering', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_breadcrumb', 'woocommerce_breadcrumb', 10 );
add_action( 'woocommerce_page_breadcrumb', 'woocommerce_page_breadcrumb', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

remove_action('woocommerce_before_add_to_cart_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
add_action('woocommerce_add_compare_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
remove_action('woocommerce_before_template_part', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
remove_action('woocommerce_after_shop_loop_item', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 10 );

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

if ( ! function_exists( 'woocommerce_show_messages1' ) ) {
	function woocommerce_show_messages1() {
		global $woocommerce;

		if ( $woocommerce->error_count() > 0  )
			woocommerce_get_template( 'notices/error.php', array(
					'messages' => $woocommerce->get_errors()
				) );


		if ( $woocommerce->message_count() > 0  )
			woocommerce_get_template( 'notices/notice.php', array(
					'messages' => $woocommerce->get_messages()
				) );

		
	}
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
		<span class="total clearfix"><span class="items"><?php echo $woocommerce->cart->get_cart_contents_count(); ?> <?php _e('item(s)', GETTEXT_DOMAIN);?></span><?php if($woocommerce->cart->get_cart_contents_count()=="0"){?><span class="amount"><?php echo get_woocommerce_currency_symbol();echo "0.00";?></span><?php }else{echo $woocommerce->cart->get_cart_subtotal();}?></span>
	<?php
	$fragments['.shopping-cart .total'] = ob_get_clean();
	return $fragments;
}

// Ensure cart contents sedate when products are added to the cart via AJAX (place the following in functions.php)
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment1');
 
function woocommerce_header_add_to_cart_fragment1( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
		
								<div class="dd-cart-wrap">
									
									<div class="header_cart_list">
									
										<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
									
											<?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) :
									
												$_product = $cart_item['data'];
									
												// Only display if allowed
												if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
													continue;
									
												// Get price
												$product_price = get_option( 'woocommerce_display_cart_prices_excluding_tax' ) == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
									
												$product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );?>
									
												<div class="item clearfix">
													<a class="cart-thumbnail" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo $_product->get_image('mini-thumb'); ?></a>
													<div class="cart-content">
														<a class="cart-title" href="<?php echo get_permalink( $cart_item['product_id'] ); ?>"><?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?></a>
														<?php echo $woocommerce->cart->get_item_data( $cart_item ); ?>
														<div class="cart-meta">
															<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">remove</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', GETTEXT_DOMAIN) ), $cart_item_key );?>
															<span class="quantity"><?php printf( '%s &times; %s', $cart_item['quantity'], $product_price ); ?></span>
														</div>
													</div>
												</div>
												
											<?php endforeach; ?>
									
										<?php else : ?>
									
											<div class="empty"><?php _e('No products in the cart.', GETTEXT_DOMAIN); ?></div>
									
										<?php endif; ?>
									
									</div><!-- end product list -->
									
									<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) : ?>
									
									<div class="header_cart_footer">
										<p class="total cleanfix"><strong><?php _e('Cart Subtotal', GETTEXT_DOMAIN); ?>:</strong> <span><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></p>
									
										<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
									
										<p class="buttons">
											<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="btn btn-small"><?php _e('View Cart &rarr;', GETTEXT_DOMAIN); ?></a>
											<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="btn btn-primary btn-small checkout"><?php _e('Checkout &rarr;', GETTEXT_DOMAIN); ?></a>
										</p>
									</div>
									
									<?php endif; ?>
									
								</div>

	<?php
	$fragments['.dd-cart-wrap'] = ob_get_clean();
	return $fragments;
}

add_filter ( 'woocommerce_product_thumbnails_columns', 'ptc_456market' ); 
function ptc_456market() {
	return 4;
}
add_filter ( 'single_product_small_thumbnail_size', 'lts_456market' ); 
add_filter ( 'single_product_large_thumbnail_size', 'lts_456market' ); 
function lts_456market() {
	return 'shop';
}

if ( ! function_exists( 'woocommerce_output_related_products' ) ) {

	function woocommerce_output_related_products() {
		woocommerce_related_products( 4, 4  );
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	woocommerce_upsell_display( 4,4 );
	}
}


if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	
		global $post, $woocommerce;
		global $product;
	
		if ( ! $placeholder_width )
			$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
		if ( ! $placeholder_height )
			$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
			
			
			if ( (! $product->is_in_stock()) || ($product->product_type == 'external') || ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ) ){}
	
	
			if ( has_post_thumbnail() ) {
				
				$thumbnail = get_the_post_thumbnail( $post->ID, 'shop' );
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
							switch ( $product->product_type ) {
							case "variable" :
								$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
							break;
							case "grouped" :
								$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
							break;
							case "external" :
								$disable = 'yes';
							break;
							default :
								$link 	= get_permalink();
								$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
							break;
							}
							
							
						if($disable == 'yes'){
							
							$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			} else {
			
				$thumbnail = '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="480" height="480" />';
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a data-placement="bottom" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="" href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
							switch ( $product->product_type ) {
							case "variable" :
								$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
							break;
							case "grouped" :
								$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
							break;
							case "external" :
								$disable = 'yes';
							break;
							default :
								$link 	= get_permalink();
								$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
							break;
							}
							
							
						if($disable == 'yes'){
							
							$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			}
			
			return $output;
	}
}

if ( ! function_exists( 'woocommerce_get_product_thumbnail1' ) ) {

	function woocommerce_get_product_thumbnail1( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	
		global $post, $woocommerce;
		global $product;
	
		if ( ! $placeholder_width )
			$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
		if ( ! $placeholder_height )
			$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
			
			
			if ( (! $product->is_in_stock()) || ($product->product_type == 'external') || ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ) ){}
	
	
			if ( has_post_thumbnail() ) {
				
				$thumbnail = get_the_post_thumbnail( $post->ID, 'featured-widget-product-2' );
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
							switch ( $product->product_type ) {
							case "variable" :
								$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
							break;
							case "grouped" :
								$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
							break;
							case "external" :
								$disable = 'yes';
							break;
							default :
								$link 	= get_permalink();
								$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
							break;
							}
							
							
						if($disable == 'yes'){
							
							$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			} else {
			
				$thumbnail = '<img src="'.THEME_ASSETS.'/img/placeholder3.png" alt="Placeholder" width="350" height="278" />';
	
				if ( ! $product->is_purchasable() && ! in_array( $product->product_type, array( 'external', 'grouped' ) ) ){
				
					$output .= '<a data-placement="bottom" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
				}else{
				
					if ( ! $product->is_in_stock() ){
					
						$output .= '<a class="" href="'.apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
					
					}else{
					
							switch ( $product->product_type ) {
							case "variable" :
								$link 	= apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'variable_add_to_cart_text', __('Select options', GETTEXT_DOMAIN) );
							break;
							case "grouped" :
								$link 	= apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
								$label 	= apply_filters( 'grouped_add_to_cart_text', __('View options', GETTEXT_DOMAIN) );
							break;
							case "external" :
								$disable = 'yes';
							break;
							default :
								$link 	= apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
								$label 	= apply_filters( 'add_to_cart_text', __('Add to cart', GETTEXT_DOMAIN) );
							break;
							}
							
							
						if($disable == 'yes'){
							
							$output .= '<a class="" href="'.get_permalink().'" title="'.__('Read More', GETTEXT_DOMAIN).'">'.$thumbnail.'</a>';
						
						}else{
				
							$output .= '<a class="" href="'.$link.'" title="'.$label.'">'.$thumbnail.'</a>';
						
						}
				
					}
				
				}
	
			}
			
			return $output;
	}
}


add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {
    $upload_dir = wp_upload_dir();
    $uploads = THEME_ASSETS;
    $src = $uploads . '/img/placeholder.png';
    return $src;
}

if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* Shop Options
    ================================================== */
    $loop_shop_per_page = get_option_tree('loop_shop_per_page',$theme_options);
}

if (!$loop_shop_per_page){
    $loop_shop_per_page = 12;
}
$loop_shop_per_page = "return $loop_shop_per_page;";
$loop_shop_per_page = create_function('$cols', $loop_shop_per_page);

add_filter('loop_shop_per_page', $loop_shop_per_page);
?>