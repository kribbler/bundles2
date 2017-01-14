<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    
    /* Shop Options
    ================================================== */
    $shop_search_image_raw = get_option_tree('shop_search_image',$theme_options);
    $shop_tag_image_raw = get_option_tree('shop_tag_image',$theme_options);
}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

<?php $shop_search_image = get_attachment_id_from_src($shop_search_image_raw);?>
<?php $shop_tag_image = get_attachment_id_from_src($shop_tag_image_raw);?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

        <?php if (is_product_category()){ ?>
	        <?php global $wp_query; 
	        $cat = $wp_query->get_queried_object();
	        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); ?>
	        <?php if ($thumbnail_id) { ?>	
	            <?php $alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true); ?>
	            <?php if ( is_active_sidebar(5) ){?>
	                <img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( $thumbnail_id, 'default-sidebar-page' ); echo $image[0];?>" />
	            <?php }else{ ?>
	            	<img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( $thumbnail_id, 'default-page' ); echo $image[0];?>" />
	            <?php }?>
	        <?php }?>
	    <?php }elseif(is_search()){?>
	        <?php if($shop_search_image_raw){?>
	            <?php if ( is_active_sidebar(5) ){?>
	                <img class="page-thumbnail" alt="<?php echo get_post_meta($shop_search_image, '_wp_attachment_image_alt', true); ?>" src="<?php $shop_search_image_ = wp_get_attachment_image_src( $shop_search_image, 'default-sidebar-page' ); echo $shop_search_image_[0];?>" />
	            <?php }else{ ?>
	            	<img class="page-thumbnail" alt="<?php echo get_post_meta($shop_search_image, '_wp_attachment_image_alt', true); ?>" src="<?php $shop_search_image_ = wp_get_attachment_image_src( $shop_search_image, 'default-page' ); echo $shop_search_image_[0];?>" />
	            <?php }?>
	        <?php }?>
	    <?php }elseif(is_tax()){?>
	        <?php if($shop_tag_image_raw){?>	
	            <?php if ( is_active_sidebar(5) ){?>
	                <img class="page-thumbnail" alt="<?php echo get_post_meta($shop_tag_image, '_wp_attachment_image_alt', true); ?>" src="<?php $shop_tag_image_ = wp_get_attachment_image_src( $shop_tag_image, 'default-sidebar-page' ); echo $shop_tag_image_[0];?>" />
	            <?php }else{ ?>
	            	<img class="page-thumbnail" alt="<?php echo get_post_meta($shop_tag_image, '_wp_attachment_image_alt', true); ?>" src="<?php $shop_tag_image_ = wp_get_attachment_image_src( $shop_tag_image, 'default-page' ); echo $shop_tag_image_[0];?>" />
	            <?php }?>
	        <?php }?>
        <?php }else{?>
	        <?php $shop_page = get_post( woocommerce_get_page_id( 'shop' ) ); ?>
	        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail($shop_page->ID))  ) { ?>
	            <?php $post_thumbnail_id = get_post_thumbnail_id($shop_page->ID); ?> 
	            <?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	            <?php if ( is_active_sidebar(5) ){?>
	                <img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $shop_page->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
	            <?php }else{ ?>
	            	<img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $shop_page->ID ), 'default-page' ); echo $image[0];?>" />
	            <?php }?>
	        <?php }?>
        <?php }?> 
        
        
		<div class="shop-navigation clearfix">
		<?php
			do_action('woocommerce_breadcrumb');
			do_action('woocommerce_catalog_ordering');
		?>
		</div>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; wp_reset_query();// end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>