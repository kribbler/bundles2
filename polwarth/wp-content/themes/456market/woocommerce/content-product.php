<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* Shop Options
    ================================================== */
    $s_rating = get_option_tree('s_rating',$theme_options);
    $loop_shop_per_page = get_option_tree('loop_shop_per_page',$theme_options);
    $shop_columns = get_option_tree('shop_columns',$theme_options);
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )

	if(!$shop_columns)
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
	else
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $shop_columns );

// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="<?php if($woocommerce_loop['columns'] == "2"){?>
		span6
	<?php } elseif($woocommerce_loop['columns'] == "3"){?>
		span4
	<?php } elseif($woocommerce_loop['columns'] == "4"){?>
		span3
	<?php } elseif($woocommerce_loop['columns'] == "6"){?>
		span2
	<?php } else{?>
		span3
	<?php }?>

 product <?php
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo 'last';
	elseif ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 )
		echo 'first';
	?>">

<div class="product-item">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>


		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		
		<div class="item-details">
		
			<h3><?php the_title(); ?></h3>
			
			<?php woocommerce_get_template( 'loop/price.php' );?>
			
			<?php if(!$s_rating){?>
				<?php woocommerce_get_template( 'loop/rating.php' );?>
			<?php }?>
	
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			
		</div>

	
</div>

</li>