<?php
/**
 * Change password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php $woocommerce->show_messages(); ?>

<form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post">

	<p class="form-row form-row-first">
		<label for="password_1"><?php _e( 'New password', GETTEXT_DOMAIN ); ?> <span class="required">*</span></label>
		<input type="password" class="form-control" name="password_1" id="password_1" />
	</p>
	<p class="form-row form-row-last">
		<label for="password_2"><?php _e( 'Re-enter new password', GETTEXT_DOMAIN ); ?> <span class="required">*</span></label>
		<input type="password" class="form-control" name="password_2" id="password_2" />
	</p>
	<div class="clear"></div>

	<p><input type="submit" class="btn btn-normal btn-primary" name="change_password" value="<?php _e( 'Save', GETTEXT_DOMAIN ); ?>" /></p>

	<?php $woocommerce->nonce_field('change_password')?>
	<input type="hidden" name="action" value="change_password" />

</form>