<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
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

<div class="panel-group lpd-prodcut-accordion<?php if($product_page_a_type){?> cre-animate<?php }?>" id="accordion"<?php if($product_page_a_type){ echo $animation_att;}?>>
	<?php $i = 1; foreach ( $tabs as $key => $tab ) : ?>
	<?php $count = $i++; ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#tab-<?php echo $key ?>" class="<?php if($count>1){echo ' collapsed';}?>">
					<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
				</a>
			</span>
	    </div>
		<div id="tab-<?php echo $key ?>" class="panel-collapse collapse<?php if($count==1){echo ' in';}?>">
			<div class="panel-body">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>



<?php endif; ?>