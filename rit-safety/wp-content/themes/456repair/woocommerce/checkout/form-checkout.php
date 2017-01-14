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

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		
		<div class="row">
			<div class="col-md-7">
			
			<div class="panel-group lpd-checkout-accordion" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#tab-billing">
							<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
								<?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?>
							<?php else : ?>
								<?php _e( 'Billing Address', 'woocommerce' ); ?>
							<?php endif; ?>
							</a>
						</span>
				    </div>
					<div id="tab-billing" class="panel-collapse collapse in">
						<div class="panel-body">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#tab-shipping" class="collapsed">
							<?php if ($woocommerce->cart->ship_to_billing_address_only()) : ?>
								<?php _e( 'Additional Information', 'woocommerce' ); ?>
							<?php else : ?>
								<?php _e( 'Shipping Address', 'woocommerce' ); ?>
							<?php endif; ?>
							</a>
						</span>
				    </div>
					<div id="tab-shipping" class="panel-collapse collapse">
						<div class="panel-body">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>
				</div>
			</div>
			
			</div>
			<div class="col-md-5">
			
				<div class="order_review_wrap">
					<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>			

			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>