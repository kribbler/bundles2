<?php
if ('wwm-options.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 
if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

	add_filter( 'tiny_mce_before_init', 'wwm_mceinit');
	add_action('admin_footer', 'wp_tiny_mce');

	function wwm_mceinit($init) {
		
		$init['mode'] = 'specific_textareas';
		$init['editor_selector'] = 'content';
		$init['elements'] = 'mailcontent';
		//$init['plugins'] = 'safari,inlinepopups,spellchecker,paste,wordpress,media,fullscreen';
		//$init['theme_advanced_buttons1'] .= ',image';
		$init['theme_advanced_buttons2'] .= ',code';
		$init['onpageload'] = '';
		$init['width'] = '97%';
		$init['save_callback'] = '';
	
		return $init;
	}
		

	if (isset($_POST['wwm_discount_code'])) {
		for($i=1;$i<=MAX_DISCOUNT_NUM;$i++) {
			if ( (!empty($_POST['wwm_discount_code'][$i][percent])) &&  (!is_numeric($_POST['wwm_discount_code'][$i][percent]))) 
				$msg='Discount percent should be a number between 0 to 100 (100 means Free!)';
			$array[$i][code]=strtolower(stripslashes($_POST['wwm_discount_code'][$i][code]));
			$array[$i][percent]=$_POST['wwm_discount_code'][$i][percent];
			$array[$i][plans]= explode(',',trim($_POST['wwm_discount_code'][$i][plans], " \n\t\r\0\x0B\,")) ;
			
		}
	}
	
	
	if ( (isset($_POST['submit'])) && (empty($msg)) ) {
		
		check_admin_referer('wwm-options');
		
		if (isset($_POST['wwm_custom_css'])) 
		update_option('wwm_custom_css',stripslashes($_POST['wwm_custom_css']));
		
		if (isset($_POST['wwm_terms_content'])) 
		update_option('wwm_terms_content',stripslashes($_POST['wwm_terms_content']));
		
		if (isset($_POST['wwm_terms_title'])) 
		update_option('wwm_terms_title',stripslashes($_POST['wwm_terms_title']));
		
		if ((isset($_POST['wwm_cap_type'])) && ($_POST['wwm_cap_type']=='recap') ) {
			if (isset($_POST['wwm_recap_public'])) 
			update_option('wwm_recap_public',$_POST['wwm_recap_public']);
			
			if (isset($_POST['wwm_recap_private'])) 
			update_option('wwm_recap_private',$_POST['wwm_recap_private']);
		}
		
		if (isset($_POST['wwm_cap_type'])) 
		update_option('wwm_cap_type',$_POST['wwm_cap_type']);
		
		
		if (isset($_POST['wwm_2co']) && isset($_POST['wwm_2co_sid'])) 
		update_option('wwm_2co',$_POST['wwm_2co']);
		else
		update_option('wwm_2co','0');
		
		if (isset($_POST['wwm_2co_mode'])) 
		update_option('wwm_2co_mode',$_POST['wwm_2co_mode']);
		
		if (isset($_POST['wwm_2co_sid'])) 
		update_option('wwm_2co_sid',$_POST['wwm_2co_sid']);
		
		if (isset($_POST['wwm_2co_secret'])) 
		update_option('wwm_2co_secret',$_POST['wwm_2co_secret']);
		
		
		if (isset($_POST['wwm_paypal_currency_code'])) 
		update_option('wwm_paypal_currency_code',$_POST['wwm_paypal_currency_code']);
		
		if (isset($_POST['wwm_paypal_mail_address'])) 
		update_option('wwm_paypal_mail_address',$_POST['wwm_paypal_mail_address']);
		
		if (isset($_POST['wwm_paypal_mode'])) 
		update_option('wwm_paypal_mode',$_POST['wwm_paypal_mode']);
		
		if (isset($_POST['wwm_verify_mail_needed'])) 
		update_option('wwm_verify_mail_needed',$_POST['wwm_verify_mail_needed']);
		else
		update_option('wwm_verify_mail_needed','0');
		
		if (isset($_POST['wwm_show_preview'])) 
		update_option('wwm_show_preview',$_POST['wwm_show_preview']);
		else
		update_option('wwm_show_preview','0');
		
		if (isset($_POST['wwm_form_validator'])) 
		update_option('wwm_form_validator',$_POST['wwm_form_validator']);
		else
		update_option('wwm_form_validator','0');
		
		if (isset($_POST['verify_mail_body']))
		update_option('verify_mail_body',stripslashes($_POST['verify_mail_body']));
		
		if ( (isset($_POST['paid_members_welcome_mail'])) && ($_POST['paid_members_welcome_mail']=='1')) {
			if (isset($_POST['paid_members_welcome_mail_body'])) 
			update_option('paid_members_welcome_mail_body',stripslashes($_POST['paid_members_welcome_mail_body']));
		}
		
		if (isset($_POST['monly_msg'])) 
		update_option('monly_msg',stripslashes($_POST['monly_msg']));
		
		if (isset($_POST['pponly_msg'])) 
		update_option('pponly_msg',stripslashes($_POST['pponly_msg']));
		
		if (isset($_POST['monly_msg'])) 
		update_option('ponly_msg',stripslashes($_POST['ponly_msg']));
		
		if ( (isset($_POST['free_members_welcome_mail'])) && ($_POST['free_members_welcome_mail']=='1')) {
			if (isset($_POST['free_members_welcome_mail_body'])) 
			update_option('free_members_welcome_mail_body',stripslashes($_POST['free_members_welcome_mail_body']));
		}
		
		
		if (isset($_POST['free_members_welcome_mail'])) 
		update_option('free_members_welcome_mail',stripslashes($_POST['free_members_welcome_mail']));
		else
		update_option('free_members_welcome_mail','0');
		
		if ( (isset($_POST['pay_per_post_mail'])) && ($_POST['pay_per_post_mail']=='1')) {
			if (isset($_POST['pay_per_post_mail_body'])) 
			update_option('pay_per_post_mail_body',$_POST['pay_per_post_mail_body']);
		}
		
		if (isset($_POST['wwm_show_buynow'])) 
		update_option('wwm_show_buynow',$_POST['wwm_show_buynow']);
		else
		update_option('wwm_show_buynow','0');
		
		if (isset($_POST['paid_members_welcome_mail'])) 
		update_option('paid_members_welcome_mail',stripslashes($_POST['paid_members_welcome_mail']));
		else
		update_option('paid_members_welcome_mail','0');
		
		
		if (isset($_POST['first_click_free'])) 
		update_option('first_click_free',stripslashes($_POST['first_click_free']));
		else
		update_option('first_click_free','0');
		
		if (isset($_POST['wwm_aff_code'])) 
		update_option('wwm_aff_code',str_replace("\\", "", $_POST['wwm_aff_code']));
		
		if (isset($_POST['wwm_paypal_recurring'])) 
		update_option('wwm_paypal_recurring',$_POST['wwm_paypal_recurring']);
		
		if (isset($_POST['notify_free_members_signup'])) 
		update_option('notify_free_members_signup',$_POST['notify_free_members_signup']);
		else
		update_option('notify_free_members_signup','0');
		
		if (isset($_POST['notify_paid_members_signup'])) 
		update_option('notify_paid_members_signup',$_POST['notify_paid_members_signup']);
		else
		update_option('notify_paid_members_signup','0');
		
		if (isset($_POST['use_plugin_as'])) 
		update_option('use_plugin_as',$_POST['use_plugin_as']);
		
		if (isset($_POST['wwm_users_can_register'])) 
		update_option('wwm_users_can_register',$_POST['wwm_users_can_register']);
		else
		update_option('wwm_users_can_register','0');
		
		if (isset($_POST['wwm_discount_code'])) 
		update_option('wwm_discount_code',$array);
		
		if (isset($_POST['wwm_max_upload'])) 
		update_option('wwm_max_upload',$_POST['wwm_max_upload']);
		
		if (isset($_POST['wwm_avatar_width'])) 
		update_option('wwm_avatar_width',$_POST['wwm_avatar_width']);
		
		if (isset($_POST['awb'])) 
		update_option('wwm_aweber',$_POST['awb']);
		
		$msg='Changes Successfully Saved.';
	
	}
	 ?>
	 <div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		
	<h2>CMS Members Settings</h2>
	<?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
	<form method="post" >
	
	<table class="form-table">
	<tr valign="top">
	<th scope="row">Form</th>
	<td> <fieldset><legend class="hidden">Form</legend><label for="wwm_users_can_register">
	<input name="wwm_users_can_register" type="checkbox" id="wwm_users_can_register" value="1"  <?php if (get_option('wwm_users_can_register')=='1') echo 'checked="checked"';  ?> />
	Enable New Order/Register.</label><br />
    
        
	</fieldset></td>
	</tr>
	
    <table class="form-table">
	<tr valign="top">
	<th scope="row">Use Plugin For</th>
	<td> 
        <label ><input type='radio' name='use_plugin_as' value='membership' <?php if (get_option('use_plugin_as')=='membership') echo 'checked="checked"'; ?> /> Membership</label><br />
		<label ><input type='radio' name='use_plugin_as' value='order' <?php if (get_option('use_plugin_as')=='order') echo 'checked="checked"'; ?> /> Order</label><br />
        <label ><input type='radio' name='use_plugin_as' value='all' <?php if (get_option('use_plugin_as')=='all') echo 'checked="checked"'; ?> /> Both </label><br />
        <span class="setting-description">Add ?type=order or ?type=membership to registartion link for a specific form. e.g. http://domain.com/register/?type=order</span>
</fieldset></td>
	</tr>
	
    
    
	<tr valign="top">
	<th scope="row">Notifications</th>
	<td> <fieldset><legend class="hidden">Notifications</legend>
	
	
	<label ><input type="checkbox" name='notify_free_members_signup' id='notify_free_members_signup' value='1' <?php if (get_option('notify_free_members_signup')=='1') echo 'checked="checked"'; ?>  />Send an email to site admin when a free member/order registered</label><br />
		<label ><input type="checkbox" name='notify_paid_members_signup' id='notify_paid_members_signup' value='1' <?php if (get_option('notify_paid_members_signup')=='1') echo 'checked="checked"'; ?> />Send an email to site admin when a paid member/order registered</label><br />
        <label ><input type="checkbox" name='notify_pay_per_post' id='notify_pay_per_post' value='1' <?php if (get_option('notify_pay_per_post')=='1') echo 'checked="checked"'; ?> />Send an email to site admin when a post sold.</label><p></p>
	
		
		<label ><input type="checkbox" name='free_members_welcome_mail' id='free_members_welcome_mail' value='1' <?php if (get_option('free_members_welcome_mail')=='1') echo 'checked="checked"'; ?> />Send a welcome email to free memberships/orders</label><br />
		<div id="free_members_welcome_mail_div">
		<fieldset><legend class="hidden">Free Members Welcome Email</legend>
		<p><label for="free_members_welcome_mail">Code tags <code>{plantitle}</code>,<code>{expiredate}</code>,<code>{firstname}</code>,<code>{lastname}</code>,<code>{username}</code>,<code>{password}</code> ,<code>{planid}</code> HTML Allowed </label></p>
		<p>
		<textarea name="free_members_welcome_mail_body" id="free_members_welcome_mail_body" rows="12" cols="50" class="large-text code content"><?php echo htmlspecialchars(get_option('free_members_welcome_mail_body')); ?></textarea>
		</p>
		</fieldset>
	</div>
		
		
		<label ><input type="checkbox" name='paid_members_welcome_mail' id='paid_members_welcome_mail' value='1' <?php if (get_option('paid_members_welcome_mail')=='1') echo 'checked="checked"'; ?> />Send a welcome email to paid memberships/orders</label><br />
		
		<div id="paid_members_welcome_mail_div">
		<fieldset><legend class="hidden">Paid Members Welcome Email</legend>
		<p><label for="paid_members_welcome_mail">Code tags <code>{plantitle}</code>,<code>{expiredate}</code>,<code>{firstname}</code>,<code>{lastname}</code>,<code>{username}</code>,<code>{password}</code>,<code>{planid}</code>  HTML Allowed </label></p>
		<p>
		<textarea name="paid_members_welcome_mail_body" id="paid_members_welcome_mail_body" rows="12" cols="50" class="large-text code content"><?php echo htmlspecialchars(get_option('paid_members_welcome_mail_body')); ?></textarea>
		</p>
		</fieldset>
        </div>
        
        <label ><input type="checkbox" name='pay_per_post_mail' id='pay_per_post_mail' value='1' <?php if (get_option('pay_per_post_mail')=='1') echo 'checked="checked"'; ?> />Send post/download URL when a user purchase a post (Recommanded)</label><br />
		
		<div id="pay_per_post_mail_div">
		<fieldset><legend class="hidden">Pay Per Post Email</legend>
		<p><label for="pay_per_post_mail">Code tags <code>{post-url}</code>, <code>{download-url}</code>, <code>{posttitle}</code>, <code>{firstname}</code>,<code>{lastname}</code>,<code>{username}</code>, <code>{userid}</code>, <code>{orderid}</code> HTML Allowed </label></p>
		<p>
		<textarea name="pay_per_post_mail_body" id="pay_per_post_mail_body" rows="12" cols="50" class="large-text code content"><?php echo htmlspecialchars(get_option('pay_per_post_mail_body')); ?></textarea>
		</p>
		</fieldset>
        </div>
        
		<p></p>
		<label ><input type="checkbox" name='wwm_verify_mail_needed' id='verify_mail' value='1' <?php if (get_option('wwm_verify_mail_needed')=='1') echo 'checked="checked"'; ?> />
		Email verification is needed (only for free membership plans)</label><br />
        
        <div id="verify_mail_div">
		<fieldset><legend class="hidden">Verify Mail</legend>
		<p><label for="paid_members_welcome_mail">Code tags <code>{activation-link}</code><small>(A Must)<small>,<code>{plantitle}</code>,<code>{expiredate}</code>,<code>{firstname}</code>,<code>{lastname}</code>,<code>{planid}</code>  HTML Allowed </small></label></p><small><small>
		<p>
		<textarea name="verify_mail_body" id="verify_mail_body" rows="12" cols="50" class="large-text code content"><?php echo htmlspecialchars(get_option('verify_mail_body')); ?></textarea>
		</p>
		
		</small></small></fieldset>
	
	</fieldset></td>
	</tr>
	
	
	<tr>
	<th scope="row">Misc.</th>
	<td>
		<fieldset><legend class="hidden">Display confirmation page</legend>
	
		
        
        <label ><input type="checkbox" name='wwm_form_validator' id='show_prev' value='1' <?php if (get_option('wwm_form_validator')=='1') echo 'checked="checked"'; ?> /> Enable AJAX form validator (May have problem with complex script languages)</label> <br/>

        <label ><input type="checkbox" name='first_click_free' id='show_prev' value='1' <?php if (get_option('first_click_free')=='1') echo 'checked="checked"'; ?> /> Enable Google First Click Free.  <a href='http://googlewebmastercentral.blogspot.com/2008/10/first-click-free-for-web-search.html'> Learn more</a></label><br/>
        
        <label ><input type="checkbox" name='wwm_show_preview' id='show_prev' value='1' <?php if (get_option('wwm_show_preview')=='1') echo 'checked="checked"'; ?> /> Display confirmation page </label><br/>
        
        <label ><input type="checkbox" name='wwm_show_buynow' id='show_prev' value='1' <?php if (get_option('wwm_show_buynow')=='1') echo 'checked="checked"'; ?> /> Display "Buy Now" button for non-members and redirect them to register page when they click on it.  </label>
        
          <br/>
		</fieldset>
	</td>
	</tr>

 <tr valign="top">
	<th scope="row"><label for="aweber">AWeber Integration</label></th>
	<td>
	<fieldset><legend class="hidden">AWeber Integration</legend>
	<?php $awb=get_option('wwm_aweber'); if (!is_array($awb)) $awb=array(); ?>
	
    <label ><input type='checkbox' name="awb[0][awb]" id='aweber' value='1' <?php if ($awb['0']['awb']) echo 'checked="checked"'; ?> /> Enable <a href="http://aweber.com">AWeber</a> Integration. </label>  <br />
    <div id="aweber-div" style="margin-left:30px;">
    <span class="setting-description">Go to Web Forms > Get HTML > RAW HTML Version. Find meta_web_form_id(Form ID) and unit(List Name)</span><br /> 
		<label> <input type="radio" name="awb[0][plan]" value="-1" <?php if ($awb['0']['plan']=='-1') echo 'checked="checked"'; ?>/> Subscribe all members </label><br />
        
         List Name: <input type='text' style="width:100px;" name="awb[0][list]" class='awb_all' value='<?php echo $awb[0]['list'];?>' /> Form ID <input type='text' style="width:100px;" name="awb[0][form]" class='awb_all' value='<?php echo $awb[0]['form'];  ?>' />  <br />
		
		 
         <br />
        <label> <input type="radio" name="awb[0][plan]" value="-2" <?php if ($awb['0']['plan']=='-2') echo 'checked="checked"'; ?>/>  Subscribe each plan at a specific list</label><br />
		
	<?php 
	for ($i=1;$i<=MAX_AWEBERPLAN_NUM;$i++) {
	
		echo "Plan ID <input type='text' name='awb[".$i."][plan]' class='aweber_plan' style='width:60px;' value='". $awb[$i]['plan']."' /> List Name <input type='text' style='width:100px;' name='awb[".$i."][list]' id='aweber_list' value='". $awb[$i]['list']."' /> Form ID <input type='text' style='width:100px;'  name='awb[".$i."][form]' id='aweber_form' value='". $awb[$i]['form']."' /><br />";
	} //endfor
		
	?>
	
	   
		</div>
	
		</fieldset>
	
	</td>
	</tr>
	
	
	<tr>
	<th scope="row">PayPal Mode </th>
	<td>
		<fieldset><legend class="hidden">PayPal Mode </legend>
	
		<label ><input type='radio' name='wwm_paypal_mode' value='test' <?php if (get_option('wwm_paypal_mode')=='test') echo 'checked="checked"'; ?> /> Test Mode</label><br />
		<label ><input type='radio' name='wwm_paypal_mode' value='live' <?php if (get_option('wwm_paypal_mode')=='live') echo 'checked="checked"'; ?> /> Live Mode</label><br />
		
		
	
		</fieldset>
	</td>
	</tr>
	
	<tr valign="top">
    <?php $rec=get_option('wwm_paypal_recurring');?>
	<th scope="row"></th>
	<td><label><input type="checkbox" id='rec' name="wwm_paypal_recurring[0]" <?php if ($rec['0']) echo 'checked="checked"'; ?> value="1"  />Enable PayPal subscription/recurring payment</label><br/> 
    <div id='rec-div'>
    <label>First Trial Period <input type="text" name="wwm_paypal_recurring[p1]" style="width:60px" value="<?php echo $rec[p1]; ?>"  /> Days</label><br/>
    <label>First Trial Price &nbsp;&nbsp;<input type="text" name="wwm_paypal_recurring[a1]" style="width:60px" value="<?php echo $rec[a1]; ?>"  /> USD</label>
    <br/><small>Both are require. Only positive numbers.</small>
	</div>


    </td>
	</tr>	
	
    
	<tr valign="top">
	<th scope="row"><label for="wwm_paypal_mail_address">PayPal Email Address</label></th>
	<td><input type="text" name="wwm_paypal_mail_address" value="<?php form_option('wwm_paypal_mail_address'); ?>" class="regular-text" /> <span class="setting-description">Make a test account <a href="http://developer.paypal.com">Here</a>. </span></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="wwm_paypal_currency_code">PayPal Currency Code</label></th>
	<td>
	<select name="wwm_paypal_currency_code" id="wwm_paypal_currency_code">
		<option value='USD' <?php if (get_option('wwm_paypal_currency_code')=='USD') echo "selected='selected'"; ?>>USD</option>
		<option value='GBP' <?php if (get_option('wwm_paypal_currency_code')=='GBP') echo "selected='selected'"; ?>>GBP</option>
		<option value='JPY' <?php if (get_option('wwm_paypal_currency_code')=='JPY') echo "selected='selected'"; ?>>JPY</option>
		<option value='CAD' <?php if (get_option('wwm_paypal_currency_code')=='CAD') echo "selected='selected'"; ?>>CAD</option>
		<option value='EUR' <?php if (get_option('wwm_paypal_currency_code')=='EUR') echo "selected='selected'"; ?>>EUR</option></select>
	
	<span class="setting-description">Go to your PayPal profile and enable multi-currency. </span></td>
	</tr>
	
    <tr>
	<th scope="row">2CO Mode</th>
	<td>
		<fieldset><legend class="hidden">2CO Mode</legend>
        <label ><input type='checkbox' name='wwm_2co' value='1' <?php if (get_option('wwm_2co')) echo 'checked="checked"'; ?> /> Enable 2Check out Payment. </label>Beta (Under testing) <br />
	
		<label ><input type='radio' name='wwm_2co_mode' value='test' <?php if (get_option('wwm_2co_mode')=='test') echo 'checked="checked"'; ?> /> Test Mode</label><br />
		<label ><input type='radio' name='wwm_2co_mode' value='live' <?php if (get_option('wwm_2co_mode')=='live') echo 'checked="checked"'; ?> /> Live Mode</label><br />
		
		
	
		</fieldset>
	</td>
	</tr>
    
    <tr valign="top">
	<th scope="row"><label for="wwm_2co_sid">2CO Vendor ID</label></th>
	<td><input type="text" name="wwm_2co_sid" value="<?php form_option('wwm_2co_sid'); ?>" class="regular-text" /> <span class="setting-description">Go to your 2Check out account and choose the same PayPal currecy. </span></td>
	</tr>
    
    <tr valign="top">
	<th scope="row"><label for="wwm_2co_secret">2CO Secret key</label></th>
	<td><input type="text" name="wwm_2co_secret" value="<?php form_option('wwm_2co_secret'); ?>" class="regular-text" /> </td>
	</tr>
    
	<tr valign="top">
	<th scope="row"><label for="wwm_discount_code">Discount Code</label></th>
	<td>
	<fieldset><legend class="hidden">Discount Code</legend>
	<?php $code_array=get_option('wwm_discount_code');
	
	if (!is_array($code_array)) $code_array=array(); ?>
	
		Code <input type='text' name='wwm_discount_code[1][code]' id='wwm_discount_code' style="width:100px;" value='<?php echo $code_array[1][code];?>' /> Percentage <input type='text' style="width:100px;" name='wwm_discount_code[1][percent]' id='wwm_discount_code' value='<?php echo $code_array[1][percent];?>' /> Plans <input type='text' style="width:100px;" name='wwm_discount_code[1][plans]' id='wwm_discount_code' value='<?php if($code_array[1][plans][0]) foreach ($code_array[1][plans] as $plan) echo $plan.',';  ?>' />  <a><span id="showcodes" >More Fields...</span></a> <br />
		
		 
		<div id="discount-div" >
	<?php 
	for ($i=2;$i<=MAX_DISCOUNT_NUM;$i++) {
	
		echo "Code <input type='text' name='wwm_discount_code[".$i."][code]' id='wwm_discount_code' style='width:100px;' value='". $code_array[$i][code]."' /> Percentage <input type='text' style='width:100px;' name='wwm_discount_code[".$i."][percent]' id='wwm_discount_code' value='". $code_array[$i][percent]."' /> Plans <input type='text' style='width:100px;' name='wwm_discount_code[".$i."][plans]' id='wwm_discount_code' value='";
		
	  if($code_array[$i][plans][0]) 
		foreach ($code_array[$i][plans] as $plan) 
			echo $plan.',';
				
		echo  "' />  <br />";
	} //endfor
		
	?>
	
	   
		</div>
		<span class="setting-description"> e.g. Code:'WordPress' Percent:'45' (means 45% off) Plans: '1,4' (means will be applied only for those plans ID- leave empty to apply for all) </span><br />
	
		</fieldset>
	
	</td>
	</tr>
    
    
    
    
	
	<tr valign="top">
	<th scope="row">CAPTCHA</th>
	<td>
		<fieldset><legend class="hidden">CAPTCHA</legend>
	
		<label ><input type='radio' name='wwm_cap_type' id='wwm_cap_type' value='simple' <?php if (get_option('wwm_cap_type')=='simple') echo 'checked="checked"'; ?> /> CAPTCHA </label><br />
		<label ><input type='radio' name='wwm_cap_type' id='recap' value='recap'  <?php if (get_option('wwm_cap_type')=='recap') echo 'checked="checked"'; ?>/> ReCAPTCHA </label>
		<div id="recap-div">
		<span class="setting-description">Get your account <a href="http://recaptcha.net/">here</a>.</span>
		<br />Public Key  <input type="text" name="wwm_recap_public" value="<?php form_option('wwm_recap_public'); ?>" class="regular-text" /><br />
		Private Key<input type="text" name="wwm_recap_private" value="<?php form_option('wwm_recap_private'); ?>" class="regular-text" />
		</div>
	
		</fieldset>
	</td>
	</tr>
    
	
	<tr valign="top">
	<th scope="row">Avatar Width</th>
	<td>
		<fieldset><legend class="hidden">Avatar Width</legend>
	
		<label ><input type='text' name='wwm_avatar_width' id='wwm_avatar_width' style="width:60px" value='<?php form_option('wwm_avatar_width');?>'  /> px</label> <br />
		
		
	
		</fieldset>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Max file upload size</th>
	<td>
		<fieldset><legend class="hidden">Max file upload size</legend>
	
		<label ><input type='text' name='wwm_max_upload' id='wwm_max_upload' style="width:60px" value='<?php form_option('wwm_max_upload');?>'  /> KB</label> <br />
		
		
	
		</fieldset>
	</td>
	</tr>
	
    

    
    
	<tr>
	<th scope="row">Terms Agreement</th>
	<td>
		<fieldset><legend class="hidden">Terms Agreement</legend>
	
		Terms Title <input type="text" name="wwm_terms_title" id="terms-title" value="<?php echo form_option('wwm_terms_title'); ?>" class="regular-text" /> <span class="setting-description"> </span><br />
		
		<label >Terms Agreement </label><br /><textarea name="wwm_terms_content" rows="10" cols="50" id="terms-contant" class="large-text code"><?php echo htmlspecialchars(get_option('wwm_terms_content')); ?></textarea><br /><span class="setting-description">You can leave it blank and link to your terms page in Terms Title. e.g. accept &lt;a href="/terms/">terms&lt;/a&gt;</span>
		
		<tr valign="top">
	<th scope="row">Only Members Message</th>
	<td>
		<fieldset><legend class="hidden"></legend>
		<label ><input type='text' name='monly_msg' id='monly_msg'  style="width:300px" value='<?php form_option('monly_msg');?>'  />  Tag: <code>{login_url}</code></label> <br />
		</fieldset>
	</td>
	</tr>

     
    <tr valign="top">
	<th scope="row">Paid Members Message</th>
	<td>
		<fieldset><legend class="hidden"></legend>
		<label ><input type='text' name='pponly_msg'  style="width:300px" value='<?php form_option('pponly_msg');?>'  />  Tag: <code>{login_url}</code></label> <br />		
		</fieldset>
	</td>
	</tr>
    
    <tr valign="top">
	<th scope="row">Specific Plan(s) Message</th>
	<td>
		<fieldset><legend class="hidden"></legend>
		<label ><input type='text' name='ponly_msg'  style="width:300px" value='<?php form_option('ponly_msg');?>'  />  Tag: <code>{login_url}</code></label> <br />		
		</fieldset>
	</td>
	</tr>
    
    <tr valign="top">
	<th scope="row">Max file upload size</th>
	<td>
		<fieldset><legend class="hidden">Max file upload size</legend>
	
		<label ><input type='text' name='wwm_max_upload' id='wwm_max_upload' style="width:60px" value='<?php form_option('wwm_max_upload');?>'  /> KB</label> <br />
		
		
	
		</fieldset>
	</td>
	</tr>
	
		</fieldset>
	</td>
	</tr>
	
    
    <tr valign="top">
	
	<th scope="row">Affiliate Script Integration </th>
	<td><fieldset><legend class="hidden"></legend>
	<p></p>
	<p>
	<textarea name="wwm_aff_code" rows="3" cols="50" id="wwm_aff_code" class="large-text code"><?php form_option('wwm_aff_code'); ?></textarea></label>
	<br/> Tag: <code>{price}</code>, <code>{order_id}</code>, <code>{user_ip}</code></p>  <br />
	
	</fieldset></td>
	</tr>
    
    
	<tr valign="top">
	
	<th scope="row">Custom Register Page CSS </th>
	<td><fieldset><legend class="hidden">Custom Register Page CSS</legend>
	
	
	<p></p>
	<p>
   
<select name="form-templates" id='form_templates' onchange="if ( confirm('You will lose your customizations. \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;">
<option selected="selected"  value=""> - Form Templates - </option>
<option   value="default" id='default'> Default </option>
<option   value="blue" id='blue'> Light Blue </option>
<option   value="web20" id='web20'> Web 2.0 </option>
<option   value="red" id='red'> Red Form</option>
<option   value="dark" id='dark'> Dark Form </option>
</select>
	<textarea name="wwm_custom_css" rows="10" cols="50" id="wwm_custom_css" class="large-text code"><?php form_option('wwm_custom_css'); ?></textarea>
	</p>
	 <?php wp_nonce_field('wwm-options');?>
	</fieldset></td>
	</tr>
    
     
	
	
	</table><input class="button-primary" value="Save Changes" name='submit' type="submit"/></form>
 
</div>