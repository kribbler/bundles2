<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<?php $product_options_logo = get_post_meta($post->ID, 'product_options_logo', true);?>

<?php
	$classes = array();
	
	if ( is_active_sidebar(5)||$product_options_logo){
		$classes[] = 'col-md-9';
	}
	$classes[] = 'clearfix';
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

<?php if ( is_active_sidebar(5)||$product_options_logo){?>
    <div class="row">
<?php } ?>

	<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($classes); ?>>
	
		<div class="row">
	
			<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>
		
			<div class="col-md-6 product-content">
			
				<div class="lpd-rating-navigation clearfix<?php if($product_page_a_type){?> cre-animate<?php }?>"<?php if($product_page_a_type){ echo $animation_att;}?>>
					<?php
						echo woocommerce_template_single_rating();
					?>
					<?php
						$next_post = get_next_post();
						$prev_post = get_previous_post();
					?>
					<div class="product-navigation">
					<?php previous_post_link('<span class="pn-btn">%link</span>'); ?>
					<?php if (!empty( $next_post )): ?><?php if (!empty( $prev_post )): ?>&nbsp;/&nbsp;<?php endif; ?><?php endif; ?>
					<?php next_post_link('<span class="pn-btn">%link</span>'); ?>
					</div>
				</div>
		
				<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_output_product_data_tabs - 35
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
		
			</div><!-- .summary -->
		
		</div>
	
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	
	</div><!-- #product-<?php the_ID(); ?> -->


<?php if ( is_active_sidebar(5)||$product_options_logo){?>
	
    <div class="col-md-3">
	    <div class="sidebar">
	    <?php if ($product_options_logo){?>
		    <div class="widget">
		    	<h4 class="title"><span class="align"><?php _e('Product Brand', GETTEXT_DOMAIN) ?></span></h4>
			    <?php echo wp_get_attachment_image($product_options_logo, 'brand-logo'); ?>
		    </div>
	    <?php } ?>
	    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Product Post Sidebar') ) ?>
	    </div>
    </div>
    
</div>
<?php } ?>
<?php $product_bottom_a_type = ot_get_option('product_bottom_a_type');
$product_bottom_a_speed = ot_get_option('product_bottom_a_speed');
$product_bottom_a_delay = ot_get_option('product_bottom_a_delay');
$product_bottom_a_offset = ot_get_option('product_bottom_a_offset');
$product_bottom_a_easing = ot_get_option('product_bottom_a_easing');

if(!$product_bottom_a_speed){
	$product_bottom_a_speed = '1000';
}
if(!$product_bottom_a_delay){
	$product_bottom_a_delay = '0';
}

if(!$product_bottom_a_offset){
	$product_bottom_a_offset = '80';
}

$animation_att = ' data-animation="'.$product_bottom_a_type.'" data-speed="'.$product_bottom_a_speed.'" data-delay="'.$product_bottom_a_delay.'" data-offset="'.$product_bottom_a_offset.'" data-easing="'.$product_bottom_a_easing.'"';

?>

<?php if ( $post->post_excerpt ) {?><hr class="lpd-hr-product-post<?php if($product_bottom_a_type){?> cre-animate<?php }?>"<?php if($product_bottom_a_type){ echo $animation_att;}?>/><?php } ?>

<?php do_action( 'lpd_single_excerpt' );?>

<?php do_action( 'lpd_single_output_related' );?>

<?php do_action( 'lpd_single_output_upsells' );?>


<?php do_action( 'woocommerce_after_single_product' ); ?>