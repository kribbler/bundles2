
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php 
	global $product;
	extract(etheme_get_single_product_sidebar());
?>

<?php
	/**
	 * Single Product Content
	 *
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     2.1.2
	 */
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class('single-product-page'); ?>>
	
	<div class="row product-info sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<div class="span3">
			<div id="product_right_col">
				<?php $sidebarname = 'shop';
				etheme_get_sidebar($sidebarname);
				?>
				<div class="clear-all"></div>
			</div>
		</div>

		<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<?php if($single_product_sidebar && ($position == 'left' || ($responsive == 'top' && $position == 'right'))): ?>
			<div class="span3 sidebar sidebar-left single-product-sidebar">
				<?php et_product_brand_image(); ?>
				<?php if(etheme_get_option('upsell_location') == 'sidebar') woocommerce_upsell_display(); ?>
				<?php dynamic_sidebar('single-sidebar'); ?>
			</div>
		<?php endif; ?>

		<div class="span9">
			<div class="row-fluid">
				<div class="span6">
					<?php woocommerce_show_product_images(); ?>
				</div>
				<div class="span6">
					<div class="product_meta">
						<?php
							//$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
							//echo $product->get_categories( ', ', '<h1 class="posted_in">' . _n( '', 'Categories:', $size, 'woocommerce' ) . ' ', '</h1>' );
						?>

						<?php if (etheme_get_option('show_name_on_single')): ?>
							<h2 class="product-name"><?php the_title(); ?></h2>
						<?php endif ?>
						
						<?php //echo do_shortcode('[ssba]');?>

						<div class="single_product_sku">
							ITEM #: <?php echo $product->get_sku(); ?>
						</div>

						<div class="product_page_price">
						<?php
							/**
							 * woocommerce_single_product_summary hook
							 *
							 * @hooked woocommerce_template_single_price - 10
							 * @hooked woocommerce_template_single_excerpt - 20
							 */
							do_action( 'woocommerce_single_product_summary' );
						?>
						</div>

						<div class="clear-all"></div>
						<?php woocommerce_template_loop_rating(); ?>
						
						<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
							<span itemprop="productID" class="sku_wrapper"><?php _e( 'Product code', ETHEME_DOMAIN ); ?>: <span class="sku"><?php echo $product->get_sku(); ?></span></span>
						<?php endif; ?>
						
						
						
					    <?php if ( etheme_get_custom_field('size_guide_img') ) : ?>
					    	<?php $lightbox_rel = (get_option('woocommerce_enable_lightbox') == 'yes') ? 'prettyPhoto' : 'lightbox'; ?>
					        <div class="size_guide">
					    	 <a rel="<?php echo $lightbox_rel; ?>" href="<?php etheme_custom_field('size_guide_img'); ?>"><?php _e('SIZING GUIDE', ETHEME_DOMAIN); ?></a>
					        </div>
					    <?php endif; ?>	


						<?php woocommerce_template_single_add_to_cart(); ?>
						
						<?php woocommerce_template_single_meta(); ?>
			            
			            <?php if(etheme_get_option('share_icons')) echo do_shortcode('[share text="'.get_the_title().'"]'); ?>
			           
			            
						<?php //woocommerce_template_single_sharing(); ?>
						
						
						<?php
						if (function_exists('the_field')){
							$sell_sheet = get_field( 'sell_sheet' );
							if ($sell_sheet['url']){
								echo '<a class="product_attachments" target="_blank" href="' . $sell_sheet['url'] . '"><img src="'.get_stylesheet_directory_uri().'/images/icon-sell-sheet.png" /><br />Sell Sheet</a>';
							}
						}?>
					</div>
				</div>
			</div>
			<?php echo apply_filters('the_content', $product->post->post_content); ?>

			<?php
				if (function_exists('the_field')){
					$youtube_video = get_field( 'youtube_video' );
					if ($youtube_video) {?>
						<div class="product_youtube">
						<?php echo apply_filters('the_content', $youtube_video); ?>
						
						</div>
					<?php }
				}
			?>
			<?php dynamic_sidebar( 'certifications' ); ?>
			
			<?php
	
				//woocommerce_output_product_data_tabs();

				if(etheme_get_custom_field('additional_block') != '') {
					echo '<div class="sidebar-position-without">';
					et_show_block(etheme_get_custom_field('additional_block'));
					echo '</div>';
				} 

			  	if(etheme_get_option('upsell_location') == 'after_content') woocommerce_upsell_display();
			  	if(etheme_get_option('show_related'))
					woocommerce_output_related_products();
				
			?>
		</div>
		


		
		<!--

		<?php if($single_product_sidebar && ($position == 'right' || ($responsive == 'bottom' && $position == 'left'))): ?>
			<div class="span3 sidebar sidebar-right single-product-sidebar">
				<?php et_product_brand_image(); ?>
				<?php if(etheme_get_option('upsell_location') == 'sidebar') woocommerce_upsell_display(); ?>
				<?php dynamic_sidebar('single-sidebar'); ?>
			</div>
		<?php endif; ?>
		-->
	</div>
	
	

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>