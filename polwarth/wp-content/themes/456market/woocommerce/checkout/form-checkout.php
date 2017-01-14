<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$woocommerce->show_messages();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', GETTEXT_DOMAIN ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', $woocommerce->cart->get_checkout_url() ); ?>




<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="accordion" id="checkout-accordion">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#checkout-accordion" href="#collapse1">
					<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
						<?php _e( 'Billing &amp; Shipping', GETTEXT_DOMAIN ); ?>
					<?php else : ?>
						<?php _e( 'Billing Address', GETTEXT_DOMAIN ); ?>
					<?php endif; ?>
					</a>
				</div>
				<div id="collapse1" class="accordion-body collapse in">
					<div class="accordion-inner">
						<div class="form-billing-wrap"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#checkout-accordion" href="#collapse2">
					<?php if ($woocommerce->cart->ship_to_billing_address_only()) : ?>
						<?php _e( 'Additional Information', GETTEXT_DOMAIN ); ?>
					<?php else : ?>
						<?php _e( 'Shipping Address', GETTEXT_DOMAIN ); ?>
					<?php endif; ?>
					</a>
				</div>
				<div id="collapse2" class="accordion-body collapse">
					<div class="accordion-inner">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<h4 id="order_review_heading"><span><?php _e( 'Your order', GETTEXT_DOMAIN ); ?></span></h4>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>