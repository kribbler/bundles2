<div id="postfinancecw-payment-container">
	
	<?php if (isset($error_message) && !empty($error_message)): ?>
		<p class="payment-error woocommerce-error">
			<?php print $error_message; ?>
		</p>
	<?php endif; ?>


	<?php if (empty($visible_form)): ?>
		<iframe src="<?php echo $iframe_url; ?>"  style="height: <?php echo $iframe_height; ?>px;" class="postfinancecw-iframe">
			
		</iframe>
	<?php else: ?>
	
		<form action="<?php echo $form_target_url; ?>" method="post" class="postfinancecw-payment-form">

			<?php foreach ($hidden_fields as $field_name => $field_value): ?>
				<input type="hidden" name="<?php print $field_name; ?>" value="<?php print $field_value; ?>" />
			<?php endforeach; ?>
			
			<?php if (isset($visible_fields) && !empty($visible_fields)): ?>
				<fieldset>
					<h3><?php print $paymentMethod->getPaymentMethodDisplayName(); ?></h3>
					<?php print $visible_fields; ?>
				</fieldset>
			<?php endif; ?>
						
			<input type="submit" class="button alt postfinancecw-payment-form-confirm" name="submit" value="<?php print __("I confirm my payment", "woocommerce_postfinancecw"); ?>" />
		</form>
	<?php endif; ?>
	
</div>
