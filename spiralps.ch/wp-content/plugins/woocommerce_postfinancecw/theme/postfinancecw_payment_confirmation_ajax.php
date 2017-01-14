<div id="postfinancecw-payment-container">
	
	<script type="text/javascript" src="<?php echo $ajaxScriptUrl; ?>"></script>
	
	<?php if (isset($error_message) && !empty($error_message)): ?>
		<p class="payment-error woocommerce-error">
			<?php print $error_message; ?>
		</p>
	<?php endif; ?>
	
	<noscript><p class="payment-error woocommerce-error"><?php echo __('You have to activate JavaScript in your browser to complete the payment.', 'woocommerce_postfinancecw'); ?></p></noscript>
	
	
	
	<?php if (isset($visible_fields) && !empty($visible_fields)): ?>
		<fieldset>
			<h3><?php print $paymentMethod->getPaymentMethodDisplayName(); ?></h3>
			<?php print $visible_fields; ?>
		</fieldset>
	<?php endif; ?>
	
	<script type="text/javascript">

		var submitFunction = function() {
			var callbackFunction = <?php echo $submitCallbackFunction ?>;

			var formFields = {};

			jQuery('#postfinancecw-payment-container *[name]').each(function() {
				formFields[jQuery(this).attr('name')] = jQuery(this).attr('value');
			});

			callbackFunction(formFields);
			
		};
	
		
	</script>
	
	<input type="submit" class="button alt postfinancecw-payment-form-confirm" name="submit" onclick="submitFunction();" value="<?php print __("I confirm my payment", "woocommerce_postfinancecw"); ?>" />

</div>
