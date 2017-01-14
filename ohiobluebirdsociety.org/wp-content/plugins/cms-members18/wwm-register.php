<?php
if ('wwm-register.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

  
function wwm_register_page() {
global $wpdb, $user_ID;

$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1' AND plantype='membership'");

if ((isset($_GET['action'])) && ('renew_upgrade'==$_GET['action']) ) {
	$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1' AND plantype='membership' AND price>'0'");
	if (!is_user_logged_in())
		return 'You have not enough permission to see this page.';
	
	if (!$planlist )
		return 'There is no upgrade or renew option for you.';
	
	if ((isset($_POST['plan'])) && (is_numeric($_POST['plan'])) ) :
		
		$newplan=get_plan_info($_POST['plan']);
		
		if ($newplan->price > get_usermeta($user_ID,'balance')) {
			echo '<div class="wwm-errormessage" >'.__('You have not enough credit','wwm').'</div>'; 
			$er=true;
		}
		
		$expire=get_usermeta($user_ID,'expire');
		if ($newplan->duration) {
			if (get_usermeta($user_ID,'plan_id')==$_POST['plan']) // If It's current plan id extend from last expire date else (upgrade) calculate expire from today
				$expiredate = date("Y-m-d H:i:s", strtotime('+'.$newplan->duration.' day', strtotime($expire))); 
			else
				$expiredate = date("Y-m-d H:i:s", strtotime('+'.$newplan->duration.' day'));
		}else {
			$expiredate='0';	
		}
				
		if (!$er) {
	
			$bal = get_usermeta($user_ID,'balance') - ($newplan->price);
			$newplan->price=0;

			update_usermeta($user_ID,'balance', $bal);
			update_usermeta($user_ID,'expire', $expiredate);
			update_usermeta($user_ID,'plan_id',$_POST['plan']);
			do_action('wwm_user_upgraded');

			echo '<div class="wwm-thanksmessage" >'.__('Your account successfully upgraded. ','wwm').'</div>';
		}

	endif;

$ba=get_usermeta($user_ID,'balance');
	echo '<p>Balance: <strong>';
	if ($ba) 
		echo $ba; 
	else 
		echo '0';
		
	echo ' '.get_option('wwm_paypal_currency_code').'</strong></p>';
	
	if (get_usermeta($user_ID,'plan_id')) {
		$cplan=get_plan_info(get_usermeta($user_ID,'plan_id'));
		echo '<p>Plan: <strong>'. $cplan->title.'</strong></p>';
	}	
	if (get_usermeta($user_ID,'expire')) 
		echo '<p>Expires: '. get_usermeta($user_ID,'expire').'</p>';
	
?><div class="wwm_renew"><p>
<?php sprintf(__('Here you can renew or upgrade your account. If you have not enough credit please <a href="%s "> deposit</a>.','wwm'),get_option('home').'/deposit/?action=deposit'); ?>
<form method="post" name="wwm_renew_upgrade" action="" id='wwm-members-form' >
<?php 
		$plan=get_usermeta($user_ID,'plan_id');
		if ($planlist) {
			foreach ($planlist as $theplan) {
				if ($theplan->price> 0) {
					echo '<p><label><input name="plan" type="radio" id="wwm-plan" ';
					if ($plan ==$theplan->id) 
						echo ' checked="checked" ';
					echo 'class="wwm-plan'.$theplan->id.' validate[required] radio" value="'.$theplan->id.'" /> '.$theplan->title;	
					if ($theplan->description) 
						echo ' - '.$theplan->description;
					echo '</label></p>';
				}
			}
		}
		
		
		echo '<br/>';
	?>
<input name="wwm_renew_upgrade_submit" type="submit" id="submit" value='<?php echo __('Upgrade','wwm').' / '.__('Renew','wwm');?>' />

</form></p></div>
<?php
return;
exit;
}

		if (get_option('wwm_form_validator')) {
?>
            <link rel="stylesheet" href="<?php echo WWM_URL . '/include'; ?>/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
            <script src="<?php echo WWM_URL. '/include'; ?>/jquery.js" type="text/javascript"></script>  
            <?php if (WPLANG) { ?>
                <script src="<?php echo WWM_URL . '/include'; ?>/jquery.validationEngine-<?php echo WPLANG; ?>.js" type="text/javascript"></script>
            <?php } ?>
            <script src="<?php echo WWM_URL . '/include'; ?>/jquery.validationEngine.js" type="text/javascript"></script>
<?php
		}
	
	$main_fields=get_option('wwm_main_fields');
	
	$use_plugin_as=get_option('use_plugin_as');

	if ($use_plugin_as!=='all')  {
		if($use_plugin_as=='membership') {
			$type='membership';
			$main_fields[0][show]='1'; //show username and pass and mail
		}elseif($use_plugin_as=='order'){
			$type='order';
			$main_fields[0][show]='0'; //don't show username and pass and mail
		}else{
			$type='membership';
		}
	}
	
	
	if (isset($_GET['type'])) {
		if($_GET['type']=='membership') {
			$type='membership';
			$main_fields[0][show]='1'; //show username and pass and mail
		}elseif($_GET['type']=='order'){
			$type='order';
			$main_fields[0][show]='0'; //don't show username and pass and mail
		}
	}
	
	
	
	if ($type)
		$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1' AND plantype='".$type."'");
	else
		$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1'");
	
	if (isset($_POST['preview'])) $preview=$_POST['preview']; else $preview=0;
	
	if (isset($_POST['username'])) $username=attribute_escape(strip_tags(stripslashes(strtolower(trim($_POST['username'])))));elseif (isset($_GET['username'])) $username=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['username'])))));
	
	if (isset($_POST['pass'])) $pass=attribute_escape(strip_tags(stripslashes((trim($_POST['pass'])))));
	if (isset($_POST['pass2'])) $pass2=attribute_escape(strip_tags(stripslashes((trim($_POST['pass2'])))));
	
	if (isset($_POST['email'])) $email=attribute_escape(strip_tags(stripslashes((trim($_POST['email'])))));elseif (isset($_GET['email'])) $email=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['email'])))));
	
	if (isset($_POST['companyname'])) $companyname=attribute_escape(strip_tags(stripslashes((trim($_POST['companyname'])))));
	
	if (isset($_POST['fname'])) $fname=attribute_escape(strip_tags(stripslashes((trim($_POST['fname'])))));elseif (isset($_GET['fname'])) $fname=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['fname'])))));
	
	if (isset($_POST['lname'])) $lname=attribute_escape(strip_tags(stripslashes((trim($_POST['lname'])))));elseif (isset($_GET['lname'])) $lname=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['lname'])))));
	
	if (isset($_POST['nname'])) $nname=attribute_escape(strip_tags(stripslashes((trim($_POST['nname'])))));
	if (isset($_POST['url'])) $url=attribute_escape(strip_tags(stripslashes((trim($_POST['url'])))));elseif (isset($_GET['url'])) $url=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['url'])))));
	
	if (isset($_POST['desc'])) $desc=attribute_escape(strip_tags(stripslashes((trim($_POST['desc'])))));elseif (isset($_GET['desc'])) $desc=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['desc'])))));
	
	if (isset($_POST['yahooim'])) $yahooim=attribute_escape(strip_tags(stripslashes((trim($_POST['yahooim'])))));
	if (isset($_POST['aolim'])) $aolim=attribute_escape(strip_tags(stripslashes((trim($_POST['aolim'])))));
	if (isset($_POST['jabberim'])) $jabberim=attribute_escape(strip_tags(stripslashes((trim($_POST['jabberim'])))));
	
	if (isset($_POST['countryname'])) $countryname=attribute_escape(strip_tags(stripslashes((trim($_POST['countryname'])))));elseif (isset($_GET['countryname'])) $countryname=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['countryname'])))));
	
	if (isset($_POST['statename'])) $statename=attribute_escape(strip_tags(stripslashes((trim($_POST['statename'])))));
	elseif (isset($_GET['statename'])) $statename=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['statename'])))));
	
	if (isset($_POST['cityname'])) $cityname=attribute_escape(strip_tags(stripslashes((trim($_POST['cityname'])))));
	elseif (isset($_GET['cityname'])) $cityname=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['cityname'])))));
	
	if (isset($_POST['adrs'])) $adrs=attribute_escape(strip_tags(stripslashes((trim($_POST['adrs'])))));
	elseif (isset($_GET['adrs'])) $adrs=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['adrs'])))));
	
	if (isset($_POST['adrs2'])) $adrs2=attribute_escape(strip_tags(stripslashes((trim($_POST['adrs2'])))));
	elseif (isset($_GET['adrs2'])) $adrs2=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['adrs2'])))));
	
	
	if (isset($_POST['zipcode'])) $zipcode=attribute_escape(strip_tags(stripslashes((trim($_POST['zipcode'])))));
	elseif (isset($_GET['zipcode'])) $zipcode=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['zipcode'])))));
	
	if (isset($_POST['telephone'])) $telephone=attribute_escape(strip_tags(stripslashes((trim($_POST['telephone'])))));
	elseif (isset($_GET['telephone'])) $telephone=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['telephone'])))));
	
	if (isset($_POST['birthday'])) $birthday=attribute_escape(strip_tags(stripslashes((trim($_POST['birthday'])))));
	if (isset($_POST['birthmonth'])) $birthmonth=attribute_escape(strip_tags(stripslashes((trim($_POST['birthmonth'])))));
	if (isset($_POST['birthyear'])) $birthyear=attribute_escape(strip_tags(stripslashes((trim($_POST['birthyear'])))));
	if (isset($_POST['gender'])) $gender=attribute_escape(strip_tags(stripslashes((trim($_POST['gender'])))));
	if (isset($_POST['terms'])) $terms=attribute_escape(strip_tags(stripslashes((trim($_POST['terms'])))));
	if (isset($_POST['avatar'])) $avatar=attribute_escape(strip_tags(stripslashes((trim($_POST['avatar'])))));
	
	if (isset($_POST['plan'])) $plan=attribute_escape(strip_tags(stripslashes((trim($_POST['plan'])))));elseif (isset($_GET['plan'])) $plan=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['plan'])))));
	
	if (isset($_POST['captcha'])) $captcha=attribute_escape(strip_tags(stripslashes((trim($_POST['captcha'])))));
	
	if (isset($_POST['promocode'])) $promocode=attribute_escape(strip_tags(stripslashes((trim($_POST['promocode'])))));elseif (isset($_GET['promocode'])) $promocode=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['promocode'])))));
	
	if (isset($_POST['payment_method'])) $payment_method=attribute_escape(strip_tags(stripslashes((trim($_POST['payment_method'])))));elseif (isset($_GET['payment_method'])) $payment_method=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['payment_method'])))));
	
	if (isset($_POST['blog_title'])) $blog_title=attribute_escape(strip_tags(stripslashes((trim($_POST['blog_title'])))));elseif (isset($_GET['blog_title'])) $blog_title=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['blog_title'])))));
	
	if (isset($_POST['blog_domain'])) $blog_domain=attribute_escape(strip_tags(stripslashes((trim($_POST['blog_domain'])))));elseif (isset($_GET['blog_domain'])) $blog_domain=attribute_escape(strip_tags(stripslashes(strtolower(trim($_GET['blog_domain'])))));
	
	$last_id=wwm_get_fields_last_id('registration');
	
	for ($i=1;$i<=$last_id;$i++){
	
		$list=$wpdb->get_row("SELECT label,regex,req FROM ".WWM_FIELDS_TABLE." WHERE id={$i};");
		if ($list) {
		
			if (isset($_POST['custom-'.$i])) $custom_value[$i]=attribute_escape(stripslashes(strip_tags(trim($_POST['custom-'.$i]))));
			elseif (isset($_GET['custom-'.$i])) $custom_value[$i]=attribute_escape(strip_tags(stripslashes(trim($_GET['custom-'.$i]))));				$custom_regex[$i]=$list->regex;
					$custom_req[$i]=$list->req;
					$custom_label[$i]=$list->label;	
					$custom[$i][label]=$list->label;
					$custom[$i][value]=$custom_value[$i];
					
					if (isset($_POST['file-'.$i])) {
					$file_custom_fields[]=$_POST['file-'.$i];
					}
					
	    	}
			
	}
	
	if (!get_option('wwm_users_can_register')) {
		echo '<div class="wwm-errormessage" >'.__('Registration has been disabled.','wwm').'</div>';
		$hidden=true;	
	
	}elseif((isset($_GET['action']))){
		$hidden=true;
		
		if (isset($_GET['method']) && 'twoco'==$_GET['method'])
			include('include/payment_2co.php');
		else
			include('include/payment.php');
	
	}elseif ( (isset($_GET['mail'])) && (isset($_GET['activate_key'])) ) {
		$hidden=true;
		$user_data = get_user_by_email($_GET['mail']);
		
		
		if ( (get_usermeta($user_data->ID,'activate_key')==$_GET['activate_key']) && (get_usermeta($user_data->ID,'status')=='incomplete') ){
			update_usermeta($user_data->ID,'status','0');	
			delete_usermeta($user_data->ID,'activate_key');
			$thanksmsg=__('Your account has been successfully activated.','wwm') . ' <a href="'.wp_login_url().'"> '.__('Log In').'</a>';
			
			if (get_option('free_members_welcome_mail')) {
				$to=$_GET['mail'];
				
				$username=$user_data->user_login;
				$fname=$user_data->first_name;
				$lname=$user_data->last_name;
				$expiredate=get_usermeta($user_data->ID,'expire');
				$plan=get_usermeta($user_data->ID,'plan_id');
					$planinfo=get_plan_info($plan);
				$plantitle=$planinfo->title;
			
				
				$blogname=get_option('blogname');
				$subject='Welcome to '.$blogname.'!';
				
				$body=get_option('free_members_welcome_mail_body');
				$tags=array('{plantitle}','{expiredate}','{firstname}','{lastname}','{username}','{password}','{planid}');
				$replace=array($plantitle,$expiredate,$fname,$lname,$username,$pass,$plan);
				$body=str_replace($tags,$replace,$body);
				$body.='<p><small>Powered by <a href="http://wpwave.com/plugins/cms-members/">CMS Members</a><small>';
				
				
				wwm_mail_actions('html'); //set actions

				if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
			} //free members welcome
			
			echo '<div class="wwm-thanksmessage">'.$thanksmsg.'</div>';
		}elseif($user_data->ID && get_usermeta($user_data->ID,'status')!=='incomplete'){
			$errormsg=__('We think you did it before!','wwm');
		echo '<div class="wwm-errormessage" >'.$errormsg.'</div>';
		}elseif((!$user_data->ID) ||get_usermeta($user_data->ID,'activate_key')!==$_GET['activate_key']){
			$errormsg=__('Your activation key is not valid for the plan!','wwm');
			echo '<div class="wwm-errormessage" >'.$errormsg.'</div>';
		}
		
	}
	elseif ( (isset($_POST['submit'])) || (isset($_POST['submit-upload'])) ) {
	
		if ( !wp_verify_nonce( $_POST['wwm_form_noncename'], plugin_basename(__FILE__) )) 
			return "Invalid nonce. Try agian.";
			
		require_once(ABSPATH.'/wp-includes/registration.php');
		//require_once(ABSPATH.'/wp-includes/pluggable.php');
	
		if (isset($_POST['submit-upload'])) { //avatar
	
	
		$override['test_form']=false;
		$allowed=array(jpg,jpeg,jpe,gif,png);
		
		$result=wwm_handle_upload($_FILES['avatarfile'],$override,100,$allowed); //100Kb means max upload size for avatars!
	
		if (!$result['error']) {
			require_once(ABSPATH.'/wp-admin/includes/image.php');
			$site=get_option(siteurl);
			$path=ABSPATH.'/wp-content/avatar/';
			$urlpath=$site."/wp-content/avatar/";
			if (!is_dir($path))  {
				mkdir($path);//chmod($path,777);
			}
			$avatar_size=get_option('wwm_avatar_width');
			$avatar=wwm_image_resize( $result['file'],$avatar_size, $avatar_size, $crop=false, $suffix=$username.'avatar', $dest_path= $path, $jpeg_quality=75) ;
		
			if (basename($avatar))
			$avatar=$urlpath.basename($avatar);
			else
			$uploaderror.=$main_fields[20][name].': '.__('Image is very little.','wwm').'.<br/>';
	
		}else{
			$uploaderror.=$main_fields[20][name].': '.$result['error'].'.<br/>';
			
		}
	}
	
	if ($file_custom_fields) {
	
		foreach($file_custom_fields as $field_id) {
			
				$override['test_form']=false;
				$allowed=unserialize($wpdb->get_var($wpdb->prepare("SELECT options FROM ".WWM_FIELDS_TABLE." WHERE id=%s;",$field_id)));
				$max_upload_size=get_site_option( 'fileupload_maxk', 1500 );
				$result=wwm_handle_upload($_FILES['custom-'.$field_id ],$override,$max_upload_size,$allowed);
			
				if (!$result['error']) {
					$custom_value[$field_id]=$result['url'];
					
				}else{
					if (!$_FILES['custom-'.$field_id ][error]=='4') { //error[4] means empty file
						$msgerror.=$custom_label[$field_id].': '.$result['error'].'.<br/>';
						$custom_value[$field_id]='error';
					}
				}
			
		}
	}
	
	
	for ($i=1;$i<=$last_id;$i++){
					if ( ((empty($custom_value[$i])) || ($custom_value[$i]==__('-Select-','wwm'))) && ($custom_req[$i]) ) 
					$msgerror.= sprintf(__('Please enter %s.', 'wwm'), $custom_label[$i])."<br/>";
					
	}
				
	
	if ( ($planlist) && (strlen($plan)<1) ) $msgerror.=__('Please choose a plan.','wwm').'<br/>';
	
	if ($main_fields[0][show]) {
		if ((strlen($username)>20) || (strlen($username)<4) ) $msgerror.=__('Please enter a username(at least 4 characters).','wwm').'<br/>';  
		if (username_exists($username)) $msgerror.=sprintf(__('%s already exists.', 'wwm'), $username)."<br/>";
		if (!validate_username($username)) $msgerror.=sprintf(__('%s is not allowed.', 'wwm'), $username)."<br/>";
		
		if ( (strlen($pass)>30) || (strlen($pass)<6) ) $msgerror.=__('Please enter a password(at least 6 characters).', 'wwm')."<br/>";
		if ( (empty($pass2)) || (strlen($pass2)>30) || ($pass!==$pass2) ) $msgerror.=__('Please re-type password to confirm.', 'wwm')."<br/>";
	}
	if ( ($main_fields[1][show]) || ($main_fields[0][show]) ) {
		if ( ($main_fields[1][req]) && (strlen($email)<6) ) $msgerror.=__('Please enter a correct email address.', 'wwm')."<br/>";
		
		if ( ($main_fields[1][req]) && (email_exists($email)) && ($type!=='order') ) $msgerror.=__('That email already exists.', 'wwm')."<br/>";
		if ( (!wwm_validate_email($email)) && (!strlen($email)<6) ) $msgerror.=__('Please enter a correct email address.', 'wwm')."<br/>";
	}
	 
		if ( ($main_fields[2][req]) && (strlen($fname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[2][name])."<br/>";
		if ( ($main_fields[3][req]) && (strlen($lname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[3][name])."<br/>";
		if ( (($main_fields[6][req]) && (strlen($url)<10)) || ( (strlen($url)>1) &&
		(!ereg('^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$',$url) ))) 
		$msgerror.=__('Please enter a correct URL.', 'wwm')."<br/>";
		if ( ($main_fields[4][req]) && (strlen($nname)<5) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[4][name])."<br/>";
		if ( ($main_fields[18][req]) && (strlen($desc)<5) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[18][name])."<br/>";
		if ( ($main_fields[7][req]) && (strlen($yahooim)<5) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[7][name])."<br/>";
		if ( ($main_fields[8][req]) && (strlen($aolim)<5) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[8][name])."<br/>";
		if ( ($main_fields[9][req]) && (strlen($jabberim)<5) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[9][name])."<br/>";
		
		if ( ($main_fields[5][req]) && (strlen($companyname)<2) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[5][name])."<br/>";
		
		if ( ($main_fields[12][req]) && (strlen($countryname)<1) ) $msgerror.=__('Please choose your country.', 'wwm')."<br/>";
		if ( ($main_fields[13][req]) && (strlen($statename)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[13][name])."<br/>";
		if ( ($main_fields[14][req]) && (strlen($cityname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[14][name])."<br/>";
		if ( ($main_fields[15][req]) && (strlen($adrs)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[15][name])."<br/>";
		if ( ($main_fields[16][req]) && (strlen($zipcode)<1)  ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[16][name])."<br/>";
		if ( ($main_fields[17][req]) && (strlen($telephone)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[17][name])."<br/>";
		if ( (($main_fields[10][req]) && (strlen($birthday)<1)) || (($main_fields[10][req]) && (strlen($birthmonth)<1)) || (($main_fields[10][req]) && (strlen($birthyear)<1)) ) $msgerror.=__('Please choose your birthdate.', 'wwm')."<br/>";
	
		if ( ($main_fields[11][req]) && (strlen($gender)<1) ) $msgerror.=__('Please choose your gender.', 'wwm')."<br/>";
		if ( ($main_fields[19][show]) && (strlen($terms)<1) && ( (!get_option('wwm_show_preview'))||($preview) && (get_option('wwm_show_preview')) ) ) $msgerror.=sprintf(__('Please accept %s.', 'wwm'), $main_fields[19][name])."<br/>";
		if ( ($main_fields[20][req]) && (strlen($avatar)<1) ) $msgerror.=sprintf(__('Please upload a photo as %s.', 'wwm'), $main_fields[20][name])."<br/>";
		if ( ($main_fields[22][req]) && (strlen($promocode)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[22][name])."<br/>";
		
		//if ( ($main_fields[100][show]) && (strlen($blog_domain)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[100][name]) . ' '.__('(at least 4 characters)','wwm')." <br/>";
		//if ( ($main_fields[100][show]) && (strlen($blog_title)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[101][name]). ' '.__('(at least 4 characters)','wwm')." <br/>";
		
		
		
	 	if (!get_option('wwm_users_can_register')) $msgerror.=__('Registration has been disabled.', 'wwm')."<br/>";
				
		
	if (($main_fields[21][show]) && ( (!get_option('wwm_show_preview'))||($preview) && (get_option('wwm_show_preview')) ) )  {
		$type=get_option('wwm_cap_type');
		if ( $type == 'simple' ){
			if (!class_exists(tam_captcha)) include('captcha/captcha.php');
			
			$tam_captcha=new tam_captcha;
			$check=$tam_captcha->check(attribute_escape($_POST['captcha-id']), $captcha);
					
			$tam_captcha->remove(attribute_escape($_POST['captcha-id']));	
			
			if(!$check){
				$msgerror.=sprintf(__('Please enter a correct %s.', 'wwm'), $main_fields[21][name])."<br/>";
				
			}	
		} else if ( $type == 'recap'){
			require_once('captcha/recaptchalib.php');
			$privatekey = get_option('wwm_recap_private');
			$recap = rp_recaptcha_check_answer ($privatekey,
	
				$_SERVER["REMOTE_ADDR"],
				$_POST["recaptcha_challenge_field"],
				$_POST["recaptcha_response_field"]);
				
			if (!$recap->is_valid) {
				$msgerror.=sprintf(__('Please enter a correct %s.', 'wwm'), $main_fields[21][name])."<br/>";
			 
			}
		}
	} //end if requires	
		
		
	
	} //end first if
	
	
	 	if ($_POST['submit']) {
			if ($planlist) {
				$theplan = $wpdb->get_row($wpdb->prepare("SELECT title,price,duration,plantype FROM ".WWM_PLANS_TABLE." WHERE display='1' AND id=%s",$plan) );
				$planprice=$theplan->price;
				$plantitle=$theplan->title;
				$planduration=$theplan->duration;
				$plantype=$theplan->plantype;
			}
			
			
			if ( (strstr(basename($_SERVER['SCRIPT_FILENAME']),'admin.php')) && (is_admin()) ){
				$planprice=0;
				$admin=true; //free for backend page
			}
		
			if ($promocode) {
				$promocode=strtolower($promocode);
				$codes=get_option('wwm_discount_code');
				$valid=false;
				if ($codes) {
					for ($id=1;$id<=MAX_DISCOUNT_NUM;$id++ ) {
						if ($codes[$id][code]==$promocode) {
							if ( ($codes[$id][plans][0]) && ($codes[$id][plans][0]!==',')) {
							
								foreach($codes[$id][plans] as $codeid=>$codeplan) {
									if($codeplan==$plan) { 
										$planprice=$planprice*((100-$codes[$id][percent])*(1/100));
										$valid=true;
									}
								}
							}else{
								$valid=true;
								$planprice=$planprice*((100-$codes[$id][percent])*(1/100));
							}
						}
					}
				}
				
				if (!$valid) 
				$msgerror.=sprintf(__('%s is not valid.', 'wwm'), $main_fields[22][name])."<br/>";	
			}
			
		}	


	
	if (empty($msgerror) && ($_POST['submit']) ) {
		
		$user_login = $username;
		$user_email = $email;
		$user_pass = $pass;
		$user_nicename=$nname;
		$user_url=$url;
		$display_name=$user_nicename;
		$first_name=$fname;
		$last_name=$lname;
		$description=$desc;
		//$role=''; leave to default userrole
		//$rich_editing=true;
		$yim=$yahooim;
		$aim=$aolim;
		$jabber=$jabberim;

		
		if (  ($planprice<=0)&& ($type!='order') && ($plantype!='order') ) {
			$userdata = compact('user_login', 'user_email', 'user_pass','user_nicename','user_url','display_name','first_name','last_name','description','yim','aim','jabber');

			$id=wp_insert_user($userdata);

			update_usermeta($id,'company',$companyname);
			update_usermeta($id,'country',$countryname);
			update_usermeta($id,'state',$statename);
			update_usermeta($id,'city',$cityname);
			update_usermeta($id,'address',$adrs);
			update_usermeta($id,'address2',$adrs2);
			update_usermeta($id,'zip',$zipcode);
			update_usermeta($id,'phone',$telephone);
			if (($birthyear)&&($birthmonth)&&($birthday) ) $birthdate=$birthyear.'-'.$birthmonth.'-'.$birthday.' 00:00:00';
				update_usermeta($id,'birthday',$birthdate);
			update_usermeta($id,'gender',$gender);
			update_usermeta($id,'last_ip', $_SERVER['REMOTE_ADDR']);
			update_usermeta($id,'status','');
			update_usermeta($id,'plan_id',$plan);
			update_usermeta($id,'avatar',$avatar);
			update_usermeta($id,'promocode',$promocode);
			
				if ($planduration)
				$expiredate = date("Y-m-d H:i:s",strtotime('+'.$planduration.'day')); else $expiredate=0;
			
			update_usermeta($id,'expire',$expiredate);

			for ($i=1;$i<=$last_id;$i++) {
				if  ( ($custom_label[$i]) && ($custom_value[$i]) )
				update_usermeta($id,'customfield_'.$i,$custom_value[$i]);
			}
			
			do_action('wwm_free_member_registered',$id);
			
			if( (get_option('wwm_verify_mail_needed')) &&(!$admin) ){
				$key=substr( md5( uniqid( microtime() ) ), 0, 6);
				
				update_usermeta($id,'status','incomplete');
				update_usermeta($id,'activate_key', $key);
				$pageid=get_the_id();
				$link=get_option('home').'/?page_id='.$pageid.'&mail='.$user_email.'&activate_key='.$key;
				
				$to=$user_email;
				$blogname=get_option('blogname');
				$subject='['.$blogname.'] Activation Link';
				$body=get_option('verify_mail_body');
				$tags=array('{activation-link}','{plantitle}','{expiredate}','{firstname}','{lastname}','{planid}');
				$replace=array($link,$plantitle,$expiredate,$fname,$lname,$plan);
				$body=str_replace($tags,$replace,$body);
				$body.='<p><small>Powered by <a href="http://wpwave.com/plugins/cms-members/">CMS Members</a><small>';
				
				
				wwm_mail_actions('html'); //set actions

				if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
		
			} //end verify mail
			
			
			$thanksmsg=__('Thank you for your registration.','wwm')."<br/>";
			
			if ( (get_option('wwm_verify_mail_needed')) && (!$admin)) $thanksmsg.=__('Please check your mail for activation link.','wwm')."<br/>";
			
			echo '<div class="wwm-thanksmessage">'.$thanksmsg.'</div>';
			
			
			if(get_option('notify_free_members_signup')) {
				 $to=get_option('admin_email');
				
				$blogname=get_option('blogname');
				$subject='['.$blogname.'] New Free Member';
				$body="New free member. Details: \n";
				$body.="Username: {$user_login} \nEmail: {$user_email} \nFirst Name: {$fname}\nLast Name: {$lname}\nURL:{$user_url}\nCountry: {$countryname}\nPromo Code: {$promocode}\nComment: {$description}\n Full details:\n";
				$body .=get_option('siteurl')."/wp-admin/admin.php?page=wwm-members.php&edit_user_id={$id} \n\nRegards,\nCMS Members";
				

				if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
			
			} ///notify free members e
			
			if( (get_option('free_members_welcome_mail')) && (!get_option('wwm_verify_mail_needed')) ){
				 $to=$user_email;
		
				$blogname=get_option('blogname');
				$subject='Welcome to '.$blogname.'!';
				
				$body=get_option('free_members_welcome_mail_body');
				$tags=array('{plantitle}','{expiredate}','{firstname}','{lastname}','{username}','{password}','{planid}');
				$replace=array($plantitle,$expiredate,$fname,$lname,$username,$pass,$plan);
				$body=str_replace($tags,$replace,$body);
				$body.='<p><small>Powered by <a href="http://wpwave.com/plugins/cms-members/">WordPress Wave CMS Members</a><small>';
				
				
				wwm_mail_actions('html'); //set actions

				if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
			} //free members welcome
			
			
		}elseif( (!$msgerror) &&($preview)) { 
		?>
	<div class="wwm_register_page">
	<form  name="wordpresswave_members_plugin" id="wwm-members-form" method="post" enctype="multipart/form-data">
	<?php 
	
	
	echo '<input type="hidden" name="wwm_form_noncename" id="wwm_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	 
	if ($planlist) {
		$plan_inf=get_plan_info($plan);
			
		echo '<label>'.__('Plan','wwm').': </label>';
		
		?>
		<input type="hidden" name='plan' id="wwm-plan" value="<?php echo $plan; ?>"   />
		<?php
		echo '<strong>'.$plan_inf->title.'</strong>';
		echo '</p><br/><label><br/>';
		echo __('Price','wwm').': </label>';
		
		if ($planprice){
			echo '<strong>'.$planprice;
			echo ' '.get_option('wwm_paypal_currency_code').'</strong>';
		}
		  
		echo '<br/><br/>';
	}
	
	if ($main_fields[0][show]) { ?>
		<label><?php _e('Username','wwm'); ?>: </label> 
		<input type="hidden" name='username' id="wwm-username" autocomplete="off" value="<?php echo $username; ?>"   />
		<?php echo $username; ?>
		<br /><br/>
		
		
		<input type="hidden" name='pass' id="wwm-pass" autocomplete="off"  value="<?php echo $pass; ?>"  />
		<input type="hidden" name='pass2' id="wwm-pass" autocomplete="off"  value="<?php echo $pass2; ?>"  />
	
	
	<?php
	}
	 if ( ($main_fields[1][show]) || ($main_fields[0][show]) ) { //we need mail to register users so we show email when username-pass is show even when mail is hidden?>
	
	<label><?php echo $main_fields[1][name]; ?>:</label> <?php echo $email; ?>
    <input type="hidden" name='email' id="wwm-email" value="<?php echo $email; ?>"   />
	<br /><br/>
	
<?php } 

	
	if ( ($main_fields[2][show]) ) {
	?>
	<label><?php echo $main_fields[2][name];?>:</label> <?php echo $fname; ?>
	<input type="hidden" name='fname' id="wwm-fname" value="<?php echo $fname; ?>"   /><br /><br />
	
	<?php } 
	if ( ($main_fields[3][show]) ) {
	?>
	<label><?php echo $main_fields[3][name];?> </label> <?php echo $lname; ?>
	<input type="hidden" name='lname' id="wwm-lname" value="<?php echo $lname; ?>"  /><br /><br />
	
	<?php }
	if ( ($main_fields[20][show]) ) {
	$avatar_size=get_option('wwm_avatar_width');
	?>
	<label><?php echo $main_fields[20][name]; ?>: </label><br /><?php if($avatar) echo '<img src="'.$avatar.'" class="wwm-avatar-img" height="'.$avatar_size.'" width="'.$avatar_size.'" /><input type="hidden" name="avatar" value="'.$avatar.'"> '; ?>
	 
	<br />
	<br />
	
	<?php
	}
	
	if ( ($main_fields[4][show]) ) {
	?>
	<label><?php echo $main_fields[4][name]; ?>: </label> <?php echo $nname; ?>
	<input type="hidden" name='nname' id="wwm-nname" value="<?php echo $nname; ?>"   /><br /><br />
	
	<?php } 
	if ( ($main_fields[5][show]) ) {?>
	<label><?php echo $main_fields[5][name];  ?>: </label> <?php echo $companyname; ?>
	<input type="hidden" name='companyname' id="wwm-companye" value="<?php echo $companyname; ?>"   /><br /><br />
	
	<?php }
	if ( ($main_fields[6][show]) ) {?>
	<label><?php echo $main_fields[6][name]; ?>: </label> <?php echo $url; ?>
	<input type="hidden" name='url' id="wwm-url" value="<?php echo $url; ?>" /><br /><br />
	
	<?php }
	if ( ($main_fields[7][show]) ) {?>
	<label><?php echo $main_fields[7][name];  ?>: </label> <?php echo $yahooim; ?>
	<input type="hidden" name='yahooim' id="wwm-yahooim" value="<?php echo $yahooim; ?>"   /><br /><br />
	
	<?php }
	if ( ($main_fields[8][show]) ) {?>
	<label><?php echo $main_fields[8][name];?>: </label> <?php echo $aolim; ?>
	<input type="hidden" name='aolim' id="wwm-aolim" value="<?php echo $aolim; ?>"   /><br /><br />
	
	<?php }
	if ( ($main_fields[9][show]) ) {?>
	<label><?php echo $main_fields[9][name];?>: </label> <?php echo $im; ?>
	<input type="hidden" name='jabberim' id="wwm-jabberim" value="<?php echo $im; ?>"   /><br /><br />
	
	<?php }
	if ( ($main_fields[11][show]) ) {?>
	<label><?php echo $main_fields[11][name];  ?>: </label> <?php if ($gender=='m') echo __('Male','wwm');elseif($gender=='f') echo __('Female','wwm'); ?>	<input type="hidden" name='gender' id="wwm-gender" value="<?php echo $gender; ?>"   />
	<br /><br />
	
	<?php }
	if ( ($main_fields[10][show]) ) {?>
	<label><?php echo $main_fields[10][name]; ?>: </label><?php echo $birthday; ?>
	
	<input type="hidden" name='birthday' id="wwm-birthday" value="<?php echo ' '.$birthday; ?>"  />
	
	<?php switch($birthmonth) {
			case '1':
				echo __('Januaray','wwm');
				break;
			case '2':
				echo __('February','wwm');
				break;
			case '3':
				echo __('March','wwm');
				break;
			case '4':
				echo __('April','wwm');
				break;
			case '5':
				echo __('May','wwm');
				break;
			case '6':
				echo __('June','wwm');
				break;
			case '7':
				echo __('July','wwm');
				break;
			case '8':
				echo __('August','wwm');
				break;
			case '9':
				echo __('September','wwm');
				break;
			case '10':
				echo __('October','wwm');
				break;
			case '11':
				echo __('November','wwm');
				break;
			case '12':
				echo __('December','wwm');
				break;
		}
	?>
    <input type="hidden" name='birthmonth' id="wwm-birthmonth" value="<?php echo $birthmonth; ?>"  />
    <?php echo ' '.$birthyear; ?>
	<input type="hidden" name='birthyear' id="wwm-birthyear" value="<?php echo $birthyear; ?>"  />
	
	<br /><br />
	
<?php } ?>
	
	<?php //Custom fields here
	$fields=$wpdb->get_results("SELECT * FROM ".WWM_FIELDS_TABLE." WHERE pagetype='registration' AND display=1 ORDER BY fieldorder;");
	if ($fields) {
		foreach ($fields as $field) {
		
		echo '<label>'.$field->label.'</label>: '.$custom_value[$field->id]; 
		
		echo '<input name="custom-'.$field->id.'" type="hidden" class="wwm-customfield" value="'.$custom_value[$field->id].'"/>';
			
		echo '<br/><br/>';
		}
	}	
	?>
	
	<?php if ( ($main_fields[12][show]) ) { ?>
	<label><?php echo $main_fields[12][name]; ?>:</label> <?php echo $countryname; ?></label>
	<input type="hidden" class="wwm-country" name="countryname" id="wwm-country" value="<?php echo $countryname; ?>" />
	<br /><br />
	<?php } 
	 if ( ($main_fields[13][show]) ) {?>
	<label><?php echo $main_fields[13][name]; ?>:</label> <?php echo $statename; ?></label>
	<input type="hidden" name='statename' id="wwm-state" value="<?php echo $statename; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[14][show]) ) {?>
	<label><?php echo $main_fields[14][name];?>:</label> <?php echo $cityname; ?></label>
	<input type="hidden" name='cityname' id="wwm-city" value="<?php echo $cityname; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<label><?php echo $main_fields[15][name];?>:</label> <?php echo $adrs; ?> </label>
	<input type="hidden" name='adrs' id="wwm-address" value="<?php echo $adrs; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<label><?php echo $main_fields[15][name];?> 2:</label> <?php echo $adrs2; ?> </label>
	<input type="hidden" name='adrs2' id="wwm-address2" value="<?php echo $adrs2; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[16][show]) ) {?>
	<label><?php echo $main_fields[16][name]; ?>:</label> <?php echo $zipcode; ?></label>
	<input type="hidden" name='zipcode' id="wwm-zip" value="<?php echo $zipcode; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[17][show]) ) {?>
	<label><?php echo $main_fields[17][name]; ?>:</label> <?php echo $telephone; ?><br />
	<input type="hidden" name='telephone' id="wwm-phone" value="<?php echo $telephone; ?>"    /><br /><br />
	
	<?php } 
	 if ( ($main_fields[18][show]) ) {?>
	<label><?php echo $main_fields[18][name]; ?>: </label> <br/><?php echo $desc; ?>
	<input type="hidden" name='desc' id="wwm-desc" value="<?php echo $desc; ?>" /><br /><br />
	
	<?php } 
	 if ( ($main_fields[22][show]) ) {?>
	<label><?php echo $main_fields[22][name]; ?>:</label> <?php echo $promocode; ?>
	<input type="hidden" name='promocode' id="wwm-phone" value="<?php echo $promocode; ?>"  /><br /><br />
	
	
	<?php } 
	
	
	
	?>
	
	
	<br /><br />
    <input type="hidden" name='preview'  value="0"  />
    <a href="javascript:history.go(-1)" ><?php _e('Go back and edit','wwm'); ?></a> | 
	<input type="submit" name="submit" value="<?php _e('Confirm', 'wwm');?>" id="wwm-submit" />
	
	</p></form></div><?php
		
		
		}else{
			$checkid = substr( md5( uniqid( microtime() ) ), 0, 16);
			
			$rec = get_option('wwm_paypal_recurring');
			
			if ($rec[0] && $rec[p1])
				$gross=$rec[a1];
			else
				$gross=$planprice;
							
			$sql="INSERT INTO ".WWM_ORDERS_TABLE."
			(planid, status ,checkid,gross, user_login,user_email , user_pass , user_nicename ,user_url ,display_name,first_name,last_name,description,yim  , aim  , jabber  , company,country  ,state  , city  ,address,address2, zip ,phone,birthday ,gender,ip,avatar,promocode ,customfields) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);";
			
		
			$order_status=($planprice>0)?'Pending Payment':'Free Order';
			
			//save all info
			$wpdb->query($wpdb->prepare($sql, $plan, $order_status, $checkid, $gross, $user_login, $user_email, $user_pass, $user_nicename, $user_url, $display_name, $first_name, $last_name, $description, $yim, $aim, $jabber, $companyname, $countryname, $statename, $cityname, $adrs, $adrs2, $zipcode,$telephone, $birthdate, $gender, $_SERVER['REMOTE_ADDR'],$avatar,$promocode,serialize($custom) ));
			
	
			if ($planprice>0) {
			
				if ($payment_method=='twoco')
					require_once('include/payment_2co.php');
				else
					require_once('include/payment.php');
			}else{		
				
				$thanksmsg=__('Thank you for your order.','wwm');
				echo '<div class="wwm-thanksmessage">'.$thanksmsg.'</div>';	
				
				$order_id=$wpdb->get_var("SELECT id FROM ". WWM_ORDERS_TABLE." WHERE checkid='".$checkid."' LIMIT 1;");

				do_action('wwm_free_order_registered',$order_id);
						
				if(get_option('free_members_welcome_mail')) {
					$to=$user_email;
				//	$headers = 'From:noreply@noreply.com\r\n';				
				//	$headers .= "To: ".$user_email."\r\n";
				//	$headers .="Mime-Version: 1.0\r\n"."Content-type: text/plain; charset=utf-8
				//	\r\n"."Content-Transfer-Encoding: 7bit\r\n";
					$blogname=get_option('blogname');
					$subject='Welcome to '.$blogname.'!';
					
					$body=get_option('free_members_welcome_mail_body');
					$tags=array('{plantitle}','{expiredate}','{firstname}','{lastname}','{username}','{password}','{planid}');
					$replace=array($plantitle,$expiredate,$fname,$lname,$username,$pass,$plan);
					$body=str_replace($tags,$replace,$body);
					$body.='<p><small>Powered by <a href="http://wpwave.com/plugins/cms-members/">WordPress Wave CMS Members</a><small>';
					
					//WP MAIL
					
					wwm_mail_actions($type); //set actions

					if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
					
				
				}//end welcome mail free order //free order welcome mail
				
				if(get_option('notify_free_members_signup')) {
					 $to=$user_email;
					// $headers = 'From:'.$user_email.'\r\n';				
				//	 $headers .= "To: ".get_option('admin_email')."\r\n";
				//	 $headers .="Mime-Version: 1.0\r\n"."Content-type: text/plain; charset=utf-8
		//	\r\n"."Content-Transfer-Encoding: 7bit\r\n";
			
					$blogname=get_option('blogname');
					$subject='['.$blogname.'] New Order';
					$body.="New free order:<br>";
					$body.="Email: {$user_email} <br>First Name: {$fname}<br>Last Name: {$lname}<br>URL: {$user_url}<br>Country: {$countryname}<br>Promo Code: {$promocode}<br>Comment: {$description}<br>Full details:<br> ";
					$body .= get_option('siteurl')."/wp-admin/admin.php?page=wwm-orders.php&view_order_id={$id}";
					wwm_mail_actions('html'); //set actions

					if ( !wp_mail($to, $subject, $body, $header) ) 
						$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
				
				}//end notify free members //end notify free order
			}
		}
	}else{ //else if there is error 
	
		 if ( ($msgerror)&&(isset($_POST['submit'])) ) echo '<div class="wwm-errormessage" >'.$msgerror.'</div>';	
	
	
	if ($uploaderror) echo '<div class="wwm-errormessage" >'.$uploaderror.'</div>';	
	
if (!$hidden) {	

	do_action('wwm_register_header');
	
	?>
	
	<div class="wwm_register_page">
	<form  name="wordpresswave_members_plugin" id="wwm-members-form" method="post" enctype="multipart/form-data">
	<?php 
	
	if ($planlist) {
		echo '<div class="field"><label>'.__('Plan','wwm').'<span class="wwm-star">*</span></label><br />';
		
		if (count($planlist)<=5 ) {
				  
			foreach ($planlist as $theplan) {
			
			echo '<p><label><input name="plan" type="radio" id="wwm-plan" ';
			
			if ($plan ==$theplan->id) echo ' checked="checked" ';
			
			echo 'class="wwm-plan'.$theplan->id.' validate[required] radio" value="'.$theplan->id.'" /> '.$theplan->title;	
			if ($theplan->description) echo ' - '.$theplan->description;echo '</label></p>';
			
			
			}
			
		}else{
		echo '<select type="text" name="plan" id="wwm-plan" style="width:300px;" value="" />';  
			$list='';
				foreach($planlist as $theplan)	{
					if (($plan==$theplan->id) ){
						$list.= "<option value=\"$theplan->id\" selected=\"selected\"> ".$theplan->title;	
						if ($theplan->description) $list.=' - '.$theplan->description." </option>\n";
					}else{
						$list.="<option value=\"$theplan->id\"> ".$theplan->title;	
						if ($theplan->description) $list.=' - '.$theplan->description." </option>\n";
					}
				}
			echo $list.'</select>';
		
		
		}
		echo '</div>';
	}
	?>
	
	
	<?php if ($main_fields[0][show]) { ?>
    
    
     <?php /*if (($main_fields[100][show]) && ($wpdb->blogid=='1')) { ?>
	<div class="field"><label><?php echo $main_fields[100][name]; ?></label> <span class="wwm-star">*</span><br />
   					   http://<?php if ( constant( "VHOST" ) == 'yes' ) { ?>
							<input type="text" name='blog_domain' id="wwm-domain" class="validate[required,custom[noSpecialCaracters],length[4,20]]" value="<?php echo $blog_domain; ?>"   />.<?php echo  $current_site->domain;?> 
						<?php } else {
							echo $current_site->domain . $current_site->path; ?><input type="text" name='blog_domain' id="wwm-domain" class="validate[required,custom[noSpecialCaracters],length[4,20]]" value="<?php  echo $blog_domain; ?>"   />
						<?php } ?>
						
						</label><br/>
                       		<?php if ($main_fields[100][desc]) { ?><small><?php echo $main_fields[100][desc]; ?></small><?php } ?></div>

    
    <div class="field"><label><?php echo $main_fields[101][name]; ?></label> <span class="wwm-star">*</span><br />
    <input type="text" name='blog_title' id="wwm-title" class="validate[required,length[4,30]]" value="<?php echo $blog_title; ?>"   /></label><br/>
		<?php if ($main_fields[101][desc]) { ?><small><?php echo $main_fields[101][desc]; ?></small><?php } ?></div>
    
    <?php }*/ ?>
    
    
	<div class="field"><label><?php _e('Username','wwm'); ?></label> <span class="wwm-star">*</span><br />
    <input type="text" name='username' id="wwm-username" autocomplete="off" class="validate[required,custom[noSpecialCaracters],length[4,20]] text-input" value="<?php echo $username; ?>"   /></label><br/><?php if ($main_fields[0][desc]) { ?><small><?php echo $main_fields[0][desc]; ?></small><?php } ?></div>

	
	
	<div class="field"><label><?php _e('Password','wwm'); ?></label> <span class="wwm-star">*</span><br />
	<input type="password" name='pass' autocomplete="off" id="password" class="validate[required,length[6,30]] text-input" value="" <?php if ($msgerror) echo 'style="border:1px solid #ff9999"';?> /></label><br />
	
	<label><?php _e('Confirm Password','wwm'); ?></label> <span class="wwm-star">*</span><br />
	<input type="password" name='pass2' autocomplete="off" id="password2" class="validate[required,confirm[password]] text-input" value="" <?php if ($msgerror) echo 'style="border:1px solid #ff9999"';?> /></label></div>
	<?php } 
	 if ( ($main_fields[1][show]) || ($main_fields[0][show]) ) { //we need mail to register users so we show email when username-pass is show even when mail is hidden?>
	
	<div class="field"><label><?php echo $main_fields[1][name]; if ( ($main_fields[0][show]) || ($main_fields[1][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='email' id="wwm-email" value="<?php echo $email; ?>"  class="validate[<?php 
	
	if ( ($main_fields[0][show]) || ($main_fields[1][req])) 
		echo 'required'; 
	else
		echo 'optional';
	?>,custom[email]] text-input" /></label><br /><?php if ($main_fields[1][desc]) { ?><small><?php echo $main_fields[1][desc]; ?></small><?php } ?></div>
	
	<?php } 
	
	if ( ($main_fields[2][show]) ) {
	?>
	<div class="field"><label><?php echo $main_fields[2][name]; if ( ($main_fields[2][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='fname' id="wwm-fname" value="<?php echo $fname; ?>"  class="validate[<?php 
	
	if ( ($main_fields[2][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[3,100]] text-input" /></label><br /><?php if ($main_fields[2][desc]) { ?><small><?php echo $main_fields[2][desc]; ?></small><?php } ?></div>
	<?php } 
	if ( ($main_fields[3][show]) ) {
	?>
	<div class="field"><label><?php echo $main_fields[3][name]; if ( ($main_fields[3][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='lname' id="wwm-lname" value="<?php echo $lname; ?>"  class="validate[<?php 
	
	if ( ($main_fields[3][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[3,100]] text-input" /></label><br /><?php if ($main_fields[3][desc]) { ?><small><?php echo $main_fields[3][desc]; ?></small><?php } ?></div>
	
	<?php } 
	
	if ( ($main_fields[20][show]) ) {
	$avatar_size=get_option('wwm_avatar_width');
	?>
	<div class="field" <?php if ($avatar) echo 'style="height:'.($avatar_size+40).'px"';?> ><label><?php echo $main_fields[20][name];if ( ($main_fields[20][req])) echo  ' <span class="wwm-star">*</span>'; ?><?php if($avatar)echo '<strong><span style="color: green;"> '. __('[Uploaded]','wwm') .'</span></strong><br/>'. __('Change it below','wwm');?><br /><?php if($avatar) echo '
	
	<img src="'.$avatar.'" class="wwm-avatar-img" height="'.$avatar_size.'" width="'.$avatar_size.'" /><input type="hidden" name="avatar" value="'.$avatar.'"> '; ?></label>
	<input type="file" name="avatarfile" id="wwm-avatar" />
	<input type="submit" name="submit-upload" value="<?php  _e('Upload','wwm');?>"  id="wwm_submit-upload" /> 
	<br /><?php if ($main_fields[20][desc]) { ?><small><?php echo $main_fields[20][desc]; ?></small><?php } ?></div>
	
	<p>
	
	
	<?php
	}
	if ( ($main_fields[4][show]) ) {
	?>
	<div class="field"><label><?php echo $main_fields[4][name];  if ( ($main_fields[4][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='nname' id="wwm-nname" value="<?php echo $nname; ?>"  class="validate[<?php 
	
	if ( ($main_fields[4][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[5,30]] text-input" /></label><br /><?php if ($main_fields[4][desc]) { ?><small><?php echo $main_fields[4][desc]; ?></small><?php } ?></div>
	
	<?php } 
	if ( ($main_fields[5][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[5][name];  if ( ($main_fields[5][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='companyname' id="wwm-companye" value="<?php echo $companyname; ?>"  class="validate[<?php 
	
	if ( ($main_fields[5][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[5,30]] text-input" /></label><br /><?php if ($main_fields[5][desc]) { ?><small><?php echo $main_fields[5][desc]; ?></small><?php } ?></div>
	
	<?php }
	if ( ($main_fields[6][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[6][name];  if ( ($main_fields[6][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='url' id="wwm-url" value="<?php echo $url; ?>" class="validate[<?php 
	
	if ( ($main_fields[6][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>] text-input"/></label><br /><?php if ($main_fields[2][desc]) { ?><small><?php echo $main_fields[6][desc]; ?></small><?php } ?></div>
	
	<?php }
	if ( ($main_fields[7][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[7][name];  if ( ($main_fields[7][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='yahooim' id="wwm-yahooim" value="<?php echo $yahooim; ?>"  class="validate[<?php 
	
	if ( ($main_fields[7][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[5,30]] text-input" /></label><br /><?php if ($main_fields[7][desc]) { ?><small><?php echo $main_fields[7][desc]; ?></small><?php } ?></div>
	
	<?php }
	if ( ($main_fields[8][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[8][name];  if ( ($main_fields[8][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='aolim' id="wwm-aolim" value="<?php echo $aolim; ?>"   class="validate[<?php 
	
	if ( ($main_fields[8][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[5,30]] text-input" /></label><br /><?php if ($main_fields[8][desc]) { ?><small><?php echo $main_fields[8][desc]; ?></small><?php } ?></div>
	
	<?php }
	if ( ($main_fields[9][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[9][name];  if ( ($main_fields[9][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='jabberim' id="wwm-jabberim" value="<?php echo $im; ?>"  class="validate[<?php 
	
	if ( ($main_fields[9][req]))
		echo 'required'; 
	else
		echo 'optional';
	?>,length[5,30]] text-input"  /></label><br /><?php if ($main_fields[9][desc]) { ?><small><?php echo $main_fields[9][desc]; ?></small><?php } ?></div>
	
	<?php }
	if ( ($main_fields[11][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[11][name];  if ( ($main_fields[11][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<?php if ($main_fields[11][desc]) { ?><small><?php echo $main_fields[11][desc]; ?></small><br/><?php } ?>
	<input name="gender" type="radio" id="wwm-m" value="m" <?php if ($gender=='m') echo 'checked="checked"';?> class="validate[<?php 
	
	if ( ($main_fields[11][req]))
		echo 'required'; 
	else
		echo 'optional';?>] radio"
        
    /><?php  _e('Male','wwm');?></label><label>
	
	&nbsp;&nbsp;<input name="gender" type="radio" id="wwm-f" value="f" <?php if ($gender=='f') echo 'checked="checked"';?> class="validate[<?php 
	
	if ( ($main_fields[9][req]))
		echo 'required'; 
	else
		echo 'optional';?>] radio" /><?php  _e('Female','wwm');?></label>
	</div>
	
	<?php }
	if ( ($main_fields[10][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[10][name];  if ( ($main_fields[10][req])) echo  ' <span class="wwm-star">*</span>'; ?></label><br />
	<select type="text" name='birthday' id="wwm-birthday"  value="<?php echo $birthday; ?>"  />
	<option value="" selected="selected" ><?php _e('-Day-','wwm'); ?></option>
	<?php
			for($i=1, $n=31; $i<=$n; $i++)
			if($i<10) $daylist[]='0'.$i;else $daylist[]=$i;
			$list='';
				foreach($daylist as $oneday)	{
					if (($oneday==$birthday) ){
						$list.= "<option value=\"$oneday\" selected=\"selected\">".$oneday."</option>\n";
					}else{
						$list.="<option value=\"$oneday\">$oneday</option>\n";
					}
				}
			echo $list;
	?>
	</select>
	
	
	
	<select class="wwm-birthmonth" name="birthmonth" id="wwm-birthmonth" >
	<option value="" selected="selected"><?php _e('-Month-','wwm'); ?></option>
		<option value="01" <?php if ($birthmonth=='01') echo 'selected="selecteed"';?>><?php  _e('Januaray','wwm'); ?></option>
		<option value="02" <?php if ($birthmonth=='02') echo 'selected="selecteed"';?>><?php  _e('February','wwm'); ?></option>
		<option value="03" <?php if ($birthmonth=='03') echo 'selected="selecteed"';?>><?php  _e('March','wwm'); ?></option>
		<option value="04" <?php if ($birthmonth=='04') echo 'selected="selecteed"';?>><?php  _e('April','wwm'); ?></option>
		<option value="05" <?php if ($birthmonth=='05') echo 'selected="selecteed"';?>><?php  _e('May','wwm'); ?></option>
		<option value="06" <?php if ($birthmonth=='06') echo 'selected="selecteed"';?>><?php  _e('June','wwm'); ?></option>
		<option value="07" <?php if ($birthmonth=='07') echo 'selected="selecteed"';?>><?php  _e('July','wwm'); ?></option>
		<option value="08" <?php if ($birthmonth=='08') echo 'selected="selecteed"';?>><?php  _e('August','wwm'); ?></option>
		<option value="09" <?php if ($birthmonth=='09') echo 'selected="selecteed"';?>><?php  _e('September','wwm'); ?></option
		><option value="10" <?php if ($birthmonth=='10') echo 'selected="selecteed"';?>><?php  _e('October','wwm'); ?></option>
		<option value="11" <?php if ($birthmonth=='11') echo 'selected="selecteed"';?>><?php  _e('November','wwm'); ?></option>
		<option value="12" <?php if ($birthmonth=='12') echo 'selected="selecteed"';?>><?php  _e('December','wwm'); ?></option>   
	</select>
	
	<select class="wwm-birthyear" name="birthyear" id="wwm-birthdayyear" >
	<option value="" selected="selected"><?php _e('-Year-','wwm'); ?></option>
	<?php 
			for($i=date('Y')-6, $n=date('Y')-80; $i>$n; $i--)
			$yearlist[]=$i;
			$list='';
				foreach($yearlist as $oneyear)	{
					if (($oneyear==$birthyear) ){
						$list.= "<option value=\"$oneyear\" selected=\"selected\">".$oneyear."</option>\n";
					}else{
						$list.="<option value=\"$oneyear\">$oneyear</option>\n";
					}
				}
			echo $list;
	
	?></select>
	
	<br /><?php if ($main_fields[10][desc]) { ?><small><?php echo $main_fields[10][desc]; ?></small><?php } ?></div>
	
	<?php } ?>
	
	<?php //Custom fields here
	$fields=$wpdb->get_results("SELECT * FROM ".WWM_FIELDS_TABLE." WHERE pagetype='registration' AND display=1 ORDER BY fieldorder;");
	if ($fields) {
		foreach ($fields as $field) {
		
		echo '<div class="field"><label>'.$field->label.'</label>'; if  ($field->req) echo  ' <span class="wwm-star">*</span>'; echo'<br/>';
		//req
			if ( $field->fieldtype=='text' ) {
			echo '<input name="custom-'.$field->id.'" type="'.$field->fieldtype.'"  id="wwm-customfield-'.$field->id.'"  value="'.$custom_value[$field->id].'"  
			 class="validate[';
			if ($field->req)
				echo 'required'; 
			else
				echo 'optional';
            echo '] text-input wwm-customfield" />';
			
			echo '</label><br/>';
			?>
            <?php if ($field->description) { ?><small><?php echo $field->description; ?></small><?php } ?>
            <?php
			}
			
			if ($field->fieldtype=='checkbox') {?>
			<?php if ($field->description) { ?><small><?php echo $field->description; ?></small><br /><?php } ?>
            <?php
					$options=unserialize($field->options);
					
					//make array
					foreach ($options as $optionarray=>$option) { 
					  echo '<label ><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'" id="wwm-customfield-'.$field->id.'" value="'.$option.'"';
						 if($option==$custom_value[$field->id])echo ' checked="checked" '; 
						 echo '/>'.$option.'</label><br/>';
					}
					
			}
			
			if ($field->fieldtype=='radio') {
				if ($field->description) { ?><small><?php echo $field->description; ?></small><br/><?php }
				$options=unserialize($field->options);
				foreach ($options as $option) { 
				echo '<label><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'"';
				$customname='custom-'.$field->id;
				if ($option==$custom_value[$field->id]) echo 'checked="checked"';
				echo  ' id="wwm-customfield-'.$field->id.'" value="'.$option.'"';
				echo ' class="validate[';
				if ($field->req)
					echo 'required'; 
				else
					echo 'optional';
					
            echo '] radio wwm-customfield-radio" />';
			echo $option.'</label><br/>';
				}
				?>
			
            <?php
			}
			
			if ($field->fieldtype=='file') {
				
				if ((empty($custom_value[$field->id]))|| (($custom_value[$field->id])=='error') ) {
				echo '<label><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'" class="wwm-customfield-'.$field->id.'" id="wwm-customfield-'.$field->id.'"/></label><br/>';
				
				echo '<label><input name="file-'.$field->id.'" type="hidden" id="wwm-customfield-'.$field->id.'" value="'.$field->id.'"/></label>';
				}else{
				echo '<strong><span style="color: green;"> '.__('[Uploaded]','wwm').'</span></strong><br/><input name="custom-'.$field->id.'" type="hidden" value="'.$custom_value[$field->id].'">';
				}
			if ($field->description) { ?><small><?php echo $field->description; ?></small><?php } ?>
            <?php
			}
			
			
			if ($field->fieldtype=='dropdown') {
				$options=unserialize($field->options);
				?>
				<select name="custom-<?php echo $field->id; ?>" id="wwm-customfield-<?php echo $field->id; ?>" />
                
			<option value="" selected="selected">-Select-</option>
			<?php	
			
			$list='';
				foreach($options as $option)	{
					if ( ($option!=='')&&($option==$custom_value[$field->id] ) ){
						$list.= "<option value=\"{$option}\" selected=\"selected\">{$option}</option>\n";
					}else{
						$list.="<option value=\"{$option}\">{$option}</option>\n";
					}
				}
				
				echo $list.'</select>';
				
			echo '<br/>';
			if ($field->description) { ?><small><?php echo $field->description; ?></small><?php } ?><?php
			}
			
			
			if ($field->fieldtype=='textarea') {
			if ($field->description) { ?><small><?php echo $field->description; ?></small><br/><?php } ?>
            <?php echo '<textarea name="custom-'.$field->id.'" ';
			
			echo 'class="validate[';
				if ($field->req)
					echo 'required'; 
				else
					echo 'optional';
					
            echo ',length[5,300]] text-input" />';
				if (isset($_POST['custom-'.$field->id])) echo $_POST['custom-'.$field->id];
			echo '</textarea>';
			
			}
			
		echo '</div>';
		}
	}	
	?>
	
	<?php if ( ($main_fields[12][show]) ) { ?>
	<div class="field"><label><?php echo $main_fields[12][name];  if ( ($main_fields[12][req])) echo  ' <span class="wwm-star">*</span>'; ?>
	<br/>
	<select name="countryname" id="wwm-country">
	<option value="" selected="selected" value=""><?php _e('Select your country','wwm');?></option>
			<?php	
			$countrylist=country_list();
			$list='';
				foreach($countrylist as $code => $countryfullname)	{
					if ( ($countryname!=='')&&($countryfullname==$countryname) ){
						$list.= "<option value=\"$countryfullname\" selected=\"selected\">$countryfullname</option>\n";
					}else{
						$list.="<option value=\"$countryfullname\">$countryfullname</option>\n";
					}
				}
				
				echo $list;
				
	?></select>
	</label><br /><?php if ($main_fields[13][desc]) { ?><small><?php echo $main_fields[13][desc]; ?></small><?php } ?></div>
    
    
	<?php } 
	 if ( ($main_fields[13][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[13][name];  if ( ($main_fields[13][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='statename' id="wwm-state" value="<?php echo $statename; ?>"   
    class="validate[<?php
				if  ($main_fields[13][req])
					echo 'required'; 
				else
					echo 'optional';
				?>]  text-input"
                 /></label><br /><?php if ($main_fields[13][desc]) { ?><small><?php echo $main_fields[13][desc]; ?></small><?php } ?></div>
	
    
	<?php } 
	 if ( ($main_fields[14][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[14][name];  if ( ($main_fields[14][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='cityname' id="wwm-city" value="<?php echo $cityname; ?>"  class="validate[<?php
				if  ($main_fields[14][req])
					echo 'required'; 
				else
					echo 'optional';
				?>]  text-input"  /></label><br /><?php if ($main_fields[14][desc]) { ?><small><?php echo $main_fields[14][desc]; ?></small><?php } ?></div>
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[15][name];  if ( ($main_fields[15][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='adrs' id="wwm-address" value="<?php echo $adrs; ?>"  class="validate[<?php
				if  ($main_fields[15][req])
					echo 'required'; 
				else
					echo 'optional';?>]  text-input"  /></label><br /><?php if ($main_fields[15][desc]) { ?><small><?php echo $main_fields[15][desc]; ?></small><?php } ?></div>
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[15][name];?> 2<br />
	<input type="text" name='adrs2' id="wwm-address2" value="<?php echo $adrs2; ?>"   class="validate[<?php
				if  ($main_fields[15][req])
					echo 'required'; 
				else
					echo 'optional';?>]  text-input" /></label></div>
	
	<?php } 
	if ( ($main_fields[16][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[16][name];  if ( ($main_fields[16][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='zipcode' id="wwm-zip" value="<?php echo $zipcode; ?>"  class="validate[<?php if  ($main_fields[16][req])
					echo 'required'; 
				else
					echo 'optional'; ?>]  text-input"  /></label><br /><?php if ($main_fields[16][desc]) { ?><small><?php echo $main_fields[16][desc]; ?></small><?php } ?></div>
	
	<?php } 
	 if ( ($main_fields[17][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[17][name];  if ( ($main_fields[17][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='telephone' id="wwm-phone" value="<?php echo $telephone; ?>"  class="validate[<?php if  ($main_fields[17][req])
					echo 'required'; 
				else
					echo 'optional'; ?>]  text-input"  /></label><br /><?php if ($main_fields[17][desc]) { ?><small><?php echo $main_fields[17][desc]; ?></small><?php } ?></div>
	
	<?php } 
	 if ( ($main_fields[18][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[18][name];  if ( ($main_fields[18][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<?php if ($main_fields[18][desc]) { ?><small><?php echo $main_fields[18][desc]; ?></small><?php } ?>
	<textarea name='desc' id="wwm-desc" class="validate[
	<?php if  ($main_fields[18][req])
					echo 'required'; 
				else
					echo 'optional';?>,length[5,300]]  text-input"><?php echo $desc; ?></textarea></label></div>
	
	<?php } 
	 if ( ($main_fields[22][show]) ) {?>
	<div class="field"><label><?php echo $main_fields[22][name];  if ( ($main_fields[22][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='promocode' id="wwm-phone" value="<?php echo $promocode; ?>"  class="validate[<?php if  ($main_fields[22][req])
					echo 'required'; 
				else
					echo 'optional';?>]  text-input"  /></label><br /><?php if ($main_fields[22][desc]) { ?><small><?php echo $main_fields[22][desc]; ?></small><?php } ?></div>
	
	
	<?php } 
	
	if ( ($main_fields[21][show])  ) { 
	   echo '<div class="field">';
		
		if ( get_option('wwm_cap_type') == 'simple' ){
									
						if (!class_exists(tam_captcha)) include('captcha/captcha.php');
						$tam_captcha=new tam_captcha;
						$rand = md5(microtime());// md5 to generate the random string
						$rand = substr($rand,0,4);
						$path=WWM_URL.'/captcha/tmp/';
						$prefix=substr(md5(microtime()),5,4);
						$capimage=$path.$tam_captcha->generate_image($prefix,$rand);
						
						?>
						<input type="hidden" name="captcha-id" value="<?php echo $prefix; ?>"  />
						
						 <label><?php echo $main_fields[21][name]; echo  ' <span class="wwm-star">*</span>'; ?><br />
						<input type="text" name="captcha" id="wwm_captcha" value="" <?php if ($msgerror) echo 'style="border:1px solid #ff9999"';?> class="validate[required']  text-input" /></label><br/>
                        <img src="<?php echo $capimage;?>" id="wwm_captcha_img" /><br />
						<?php if ($main_fields[21][desc]) { ?><small><?php echo $main_fields[21][desc]; ?></small><?php } ?>
					   
						<?php
						
		} else if ( get_option('wwm_cap_type') == 'recap' && get_option('wwm_recap_public') && get_option('wwm_recap_private') ){
						require_once('captcha/recaptchalib.php');
						$pkey = get_option('wwm_recap_public');
						echo '<div id="reCAPTCHA">';
						echo rp_recaptcha_get_html($pkey);
						echo '</div>';
		}
		?>
        </label></div>
    <?php
	}	
	?>
	
	<?php
	
	 if ( ($main_fields[23][show]) && ($planlist) ) {
	 ?><div class="field"><label><?php echo $main_fields[23][name];?><br />
        <?php if ($main_fields[23][desc]) { ?><small><?php echo $main_fields[23][desc]; ?></small><br /><?php } ?></label>
      
	
    
		<label><input name="payment_method" type="radio" id="wwm-method" value="paypal" <?php if ( (!$payment_method) || ($payment_method=='paypal') ) echo 'checked="checked"';?> /> PayPal <img src="<?php echo WWM_URL.'/include/paypal.gif'; ?>"></label> <br/>
    <?php if (get_option('wwm_2co')) { ?>
    <label><input name="payment_method" type="radio" id="wwm-method" value="twoco" <?php if ($payment_method=='twoco') echo 'checked="checked"';?> /> 2CO <img src="<?php echo WWM_URL.'/include/2co.gif'; ?>"></label> <br/>

	<?php } ?>
	</div>
	
	<?php }   
	
	
	 if ( ($main_fields[19][show]) ) {
	?><div class="field"><?php echo $main_fields[19][name];?><br />
	 
	 <?php if (get_option('wwm_terms_content')) {echo '<textarea name="wwm_terms_content" id="wwm-terms-contant" class="wwm-terms-contant">'.get_option('wwm_terms_content').'</textarea><br/>';} ?>
     
	<label>
	<input name="terms" type="checkbox" id="wwm-terms" value="1" <?php if ($terms) echo 'checked="checked"';?> class="validate['required']  checkbox" /> <?php echo get_option('wwm_terms_title'); ?></label><br />
	<?php if ($main_fields[19][desc]) { ?><small><?php echo $main_fields[19][desc]; ?></small><?php } ?></div>
	
	
	<?php }   ?>
	
	<?php do_action('wwm_register_footer'); ?>
    
    <?php 
	echo '<input type="hidden" name="wwm_form_noncename" id="wwm_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';?>
    <input type="hidden" name='preview' value="<?php echo get_option('wwm_show_preview');?>"  />
	<div class="field"><input type="submit" name="submit" value="<?php _e('Register', 'wwm');?>" id="wwm-submit" /></div>
	
	</p></form></div>
    
	<?php	
	
	}//end if
}//end of hidden
}
?>