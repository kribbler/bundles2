<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) return;
?>
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
<div class="lpd-prodcut-description<?php if($product_bottom_a_type){?> cre-animate<?php }?>" itemprop="description"<?php if($product_bottom_a_type){ echo $animation_att;}?>>
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
</div>