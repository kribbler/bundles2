<?php global $woocommerce; ?>

						<div class="shopping-cart-wrap btn-group pull-right dropdown">
							<a href="#" data-toggle="dropdown" class="shopping-cart">
								<i class="livicon" data-name="more" data-color="#363636" data-size="16"></i>
								<span class="title"><?php _e('Shopping Bag', GETTEXT_DOMAIN); ?></span>
								<span class="total clearfix"><span class="items"><?php echo $woocommerce->cart->get_cart_contents_count(); ?> <?php _e('item(s)', GETTEXT_DOMAIN);?></span><?php if($woocommerce->cart->get_cart_contents_count()=="0"){?><span class="amount"><?php echo get_woocommerce_currency_symbol();echo "0.00";?></span><?php }else{echo $woocommerce->cart->get_cart_subtotal();}?></span>
							</a>
							<div class="dropdown-menu">
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
							</div>
						</div>