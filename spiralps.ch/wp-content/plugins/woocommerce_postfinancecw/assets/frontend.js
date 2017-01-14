(function ($) {
	
	var isSubmitted = false;
	
	var CheckoutObject = {
		
		cssClass: '',
		successCallback: '',
		
		placeOrder: function() { 
			
			var selectedPaymentMethod = $('input:radio[name=payment_method]:checked').val();
			var moduleName = 'postfinancecw';
			var selectedModuleName = selectedPaymentMethod.toLowerCase().substring(0, moduleName.length);
			
			if (moduleName == selectedModuleName) {
				var form = $('form.checkout');
				eval('var result = ' + selectedPaymentMethod.toLowerCase() + 'validatePaymentFormElements();');
				if(result == false){
					form.removeClass('processing').unblock();
					form.find( '.input-text, select' ).blur();
					return false;
				}
				
				
				// Generate Order
				form.addClass('processing');
				var form_data = form.data();

				if ( form_data["blockUI.isBlocked"] != 1 ) {
					form.block({message: null, overlayCSS: {background: '#fff url(' + woocommerce_params.ajax_loader_url + ') no-repeat center', backgroundSize: '16px 16px', opacity: 0.6}});
				}

				onCheckoutPlaceObject = this;
				
				$.ajax({
					type: 		'POST',
					url: 		woocommerce_params.checkout_url,
					data: 		form.serialize() + "&" + this.cssClass + "=true",
					success: 	function( code ) {
						
						if (code.indexOf("<!--WC_START-->") >= 0)
							code = code.split("<!--WC_START-->")[1];

						if (code.indexOf("<!--WC_END-->") >= 0)
							code = code.split("<!--WC_END-->")[0];

						result = $.parseJSON( code );
						if ( result.result == 'success' ) {
							onCheckoutPlaceObject.successCallback(result, selectedPaymentMethod);
						}
						else {
							$('.woocommerce-error, .woocommerce-message').remove();

							// Add new errors
							if ( result.messages )
								form.prepend( result.messages );
							else
								form.prepend( code );

						  	// Cancel processing
							form.removeClass('processing').unblock();

							// Lose focus for all fields
							form.find( '.input-text, select' ).blur();

							// Scroll to top
							$('html, body').animate({
							    scrollTop: ($('form.checkout').offset().top - 100)
							}, 1000);

							// Trigger update in case we need a fresh nonce
							if ( result.refresh == 'true' )
								$('body').trigger('update_checkout');
						}
						
						return false;
					}
					
				});
				
				return false;
			}
			
			
		},
	};

	
	var getFormFieldValues = function(parentCssClass, paymentMethodPrefix) {
		var output = {};
		$('.' + parentCssClass + ' *[data-field-name]').each(function (element) {
			var name = $(this).attr('data-field-name').substring(paymentMethodPrefix.length);
			name = name.substring(1, name.length -1 );
			output[name] = $(this).val();
		});
		
		return output;
	};
	
	var getHiddenFields = function(data) {
		var output = '';
		$.each(data, function(key, value) {
			output += '<input type="hidden" name="' + key + '" value="' + value + '" />';
		});
		
		return output;
	};
	
	var handleAuthorization = function(cssClass, successCallback) {

		// Remove name attribute to prevent submitting the data
		$('.' + cssClass + ' *[name]').each(function (element) {
			$(this).attr('data-field-name', $(this).attr('name'));
			$(this).removeAttr('name');
		});
		
		var form = $('form.checkout');
		
		
		// Add listener for alias Transaction selector
		$('.' + cssClass).parents('li').find('.postfinancecw-alias-input-box > select').bind('change', function() {
			$('body').trigger('update_checkout');
		});
		
		
		CheckoutObject.cssClass = cssClass;
		CheckoutObject.successCallback = successCallback;
		
		bindOrderConfirmEvent(CheckoutObject);
		
	};
	
	

	
	var bindOrderConfirmEvent = function (CheckoutObject) {
		var form = $('form.checkout');
		form.bind('checkout_place_order', function() {
			return CheckoutObject.placeOrder();
		});
		
	};


	
	
	$( document ).ajaxComplete(function() {
		if ($('.postfinancecw-hidden-authorization').length > 0) {
			handleAuthorization('postfinancecw-hidden-authorization', function (result, selectedPaymentMethod) {
				var newForm = '<form id="postfinancecw_hidden_authorization_redirect_form" action="' + result.form_action_url + '" method="POST">';
				newForm += result.hidden_form_fields;
				newForm += getHiddenFields(getFormFieldValues('postfinancecw-hidden-authorization', selectedPaymentMethod.toLowerCase()));
				newForm += '</form>';
				$('body').append(newForm);
				$('#postfinancecw_hidden_authorization_redirect_form').submit();
			});
		}
		if ($('.postfinancecw-ajax-authorization').length > 0) {
			handleAuthorization('postfinancecw-ajax-authorization', function (result, selectedPaymentMethod) {
				
				$.getScript(result.ajaxScriptUrl, function() {
					eval("var callbackFunction = " + result.submitCallbackFunction);
					callbackFunction(getFormFieldValues('postfinancecw-ajax-authorization', selectedPaymentMethod.toLowerCase()));
				});
				
			});
		}
	});
	
	
	
	
	
	
	
}(jQuery));