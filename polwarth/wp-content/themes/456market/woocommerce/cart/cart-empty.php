<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<p><?php _e( 'Your cart is currently empty.', GETTEXT_DOMAIN ) ?></p>

<?php do_action('woocommerce_cart_is_empty'); ?>

<p><a class="button1 btn btn-normal" href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>"><?php _e( '&larr; Return To Shop', GETTEXT_DOMAIN ) ?></a></p>