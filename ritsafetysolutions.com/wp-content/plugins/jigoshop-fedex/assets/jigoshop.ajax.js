jQuery(document).ready(function(){
	//Check if res indicator has been set in session
	if(jQuery('#residential-indicator').length >0){
		if(fedex.residential_customer=='1'){
			jQuery('#residential-indicator').attr('checked','checked')
		}else{
			jQuery('#residential-indicator').removeAttr('disabled');
		}
	}
	//Cart shipping calculator
	jQuery('#calc_shipping_res_indic').click(function(){
		var Othis = jQuery(this);
		var checked = jQuery(this).attr('checked');
		var action;
		Othis.attr({'disabled':'true'});
		Othis.parent().addClass('ajax-loading');
		
		//Set res ind session variable
		if(fedex.admin=="0"){
			ajax_action = 'set_admin_residential_indicator'
		}else{
			//ajax_action = 'set_user_residential_indicator'
				ajax_action = 'set_admin_residential_indicator'
		}
		
		jQuery.post(  
            fedex.siteurl+"/wp-admin/admin-ajax.php",  
            //Data  
            {  
                action:ajax_action,  
                'cookie': encodeURIComponent(document.cookie),  
                'checked':checked,
                'ajax_nonce':fedex.ajax_nonce
               },  
            //on success function  
            function(checked){
            	
            	jQuery('input[name="shipping_rates"]').each(function(i){
            		
            		jQuery(this).parent().next().remove();
            		jQuery(this).parent().remove();
            	});
            	
            	var collaterals_total = jQuery('.cart_totals');
            	collaterals_total.empty();
            	
            	//Update checkbox
            	if(checked == 'checked0' || checked == 'checked-1'){
            		Othis.attr('checked','tue')
            	}else{
            		Othis.removeAttr('checked')
            	}
            	
            	Othis.parent().removeClass('ajax-loading');
            	Othis.removeAttr('disabled');
            	return false;  
            } 
        );
		return false;
	})
	//Checkout Page
	jQuery('#residential-indicator').click(function(){
		var Othis = jQuery(this);
		var checked = jQuery(this).attr('checked');
		var action;
		Othis.attr({'disabled':'true'});
		Othis.parent().addClass('ajax-loading');
		if(fedex.admin==0){
			ajax_action = 'set_admin_residential_indicator'
		}else{
			//ajax_action = 'set_user_residential_indicator'
				ajax_action = 'set_admin_residential_indicator'
		}
		
		//Set res ind session variable
		jQuery.post(  
            fedex.siteurl+"/wp-admin/admin-ajax.php",  
            //Data  
            {  
                action:ajax_action,  
                'cookie': encodeURIComponent(document.cookie),  
                'checked':checked,
                'ajax_nonce':fedex.ajax_nonce
               },  
            //on success function  
            function(checked){
            	//Update checkbox
            	if(checked == 'checked0' || checked == 'checked-1'){
            		Othis.attr('checked','checked')
            	}else{
            		Othis.removeAttr('checked')
            	}
            	//Update cart totals
            	update_checkout();
            	Othis.parent().removeClass('ajax-loading');
            	Othis.removeAttr('disabled');
            	return false;  
            } 
        );
		return false;
	})
});