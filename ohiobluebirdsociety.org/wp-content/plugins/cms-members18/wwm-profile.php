<?php
if ('wwm-profile.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 

global $wpdb,$user_level;
				
	if (!is_user_logged_in())   {
			return "Sorry, You have not enough permission to see this page!";	
	}
	
	$main_fields=get_option('wwm_main_fields');
	if ( (isset($_GET['edit_id'])) && (is_numeric($_GET['edit_id'])) && ($user_level > 7) ) {
		$user = get_userdata($_GET['edit_id']);
		
	}else{
		$user = wp_get_current_user();
	}

 	$email=$user->user_email;
	$fname=$user->first_name;
	$lname=$user->last_name;
	
	$nname=$user->user_nicename;
	$url=$user->user_url;
	
	$desc=$user->user_description;
	
	$yahooim=$user->yim;
	$aolim=$user->aim;
	$aolim=$user->aim;
	
	$jabberim=$user->jabber;
	
	$countryname=$user->country;
	$statename=$user->state;
	$cityname=$user->city;
	$adrs=$user->address;
	$adrs2=$user->address2;
	
	$zipcode=$user->zip;
	$telephone=$user->phone;
	//substr($expire,0,10)
	$birthday=substr($user->birthday,8,2);
	$birthmonth=substr($user->birthday,5,2);
	$birthyear=substr($user->birthday,0,4);
	

	$gender=$user->gender;
	$avatar=$user->avatar;
	
		
	$expire=$user->expire;
	$plan_id=$user->plan_id;
	
	
	$last_id=wwm_get_fields_last_id('registration');
	for ($i=1;$i<=$last_id;$i++) {
				$va=get_usermeta($user->ID,'customfield_'.$i);
				if  ($va)
				$custom_value[$i]=$va;
	}
			
 
	if (isset($_POST['pass'])) $pass=attribute_escape(strip_tags(stripslashes((trim($_POST['pass'])))));
	if (isset($_POST['pass2'])) $pass2=attribute_escape(strip_tags(stripslashes((trim($_POST['pass2'])))));
	
	if (isset($_POST['email'])) $email=attribute_escape(strip_tags(stripslashes((trim($_POST['email'])))));
	
	if (isset($_POST['companyname'])) $companyname=attribute_escape(strip_tags(stripslashes((trim($_POST['companyname'])))));
	
	if (isset($_POST['fname'])) $fname=attribute_escape(strip_tags(stripslashes((trim($_POST['fname'])))));
	
	if (isset($_POST['lname'])) $lname=attribute_escape(strip_tags(stripslashes((trim($_POST['lname'])))));
	
	if (isset($_POST['nname'])) $nname=attribute_escape(strip_tags(stripslashes((trim($_POST['nname'])))));
	if (isset($_POST['url'])) $url=attribute_escape(strip_tags(stripslashes((trim($_POST['url'])))));
	
	if (isset($_POST['desc'])) $desc=attribute_escape(strip_tags(stripslashes((trim($_POST['desc'])))));
	
	if (isset($_POST['yahooim'])) $yahooim=attribute_escape(strip_tags(stripslashes((trim($_POST['yahooim'])))));
	
	if (isset($_POST['aolim'])) $aolim=attribute_escape(strip_tags(stripslashes((trim($_POST['aolim'])))));
	
	if (isset($_POST['jabberim'])) $jabberim=attribute_escape(strip_tags(stripslashes((trim($_POST['jabberim'])))));
	
	if (isset($_POST['countryname'])) $countryname=attribute_escape(strip_tags(stripslashes((trim($_POST['countryname'])))));
	
	if (isset($_POST['statename'])) $statename=attribute_escape(strip_tags(stripslashes((trim($_POST['statename'])))));
	
	
	if (isset($_POST['cityname'])) $cityname=attribute_escape(strip_tags(stripslashes((trim($_POST['cityname'])))));
	if (isset($_POST['adrs'])) $adrs=attribute_escape(strip_tags(stripslashes((trim($_POST['adrs'])))));
	if (isset($_POST['adrs2'])) $adrs2=attribute_escape(strip_tags(stripslashes((trim($_POST['adrs2'])))));
	if (isset($_POST['zipcode'])) $zipcode=attribute_escape(strip_tags(stripslashes((trim($_POST['zipcode'])))));
	if (isset($_POST['telephone'])) $telephone=attribute_escape(strip_tags(stripslashes((trim($_POST['telephone'])))));
	
	
	if (isset($_POST['birthday'])) $birthday=attribute_escape(strip_tags(stripslashes((trim($_POST['birthday'])))));
	if (isset($_POST['birthmonth'])) $birthmonth=attribute_escape(strip_tags(stripslashes((trim($_POST['birthmonth'])))));
	if (isset($_POST['birthyear'])) $birthyear=attribute_escape(strip_tags(stripslashes((trim($_POST['birthyear'])))));
	if (isset($_POST['gender'])) $gender=attribute_escape(strip_tags(stripslashes((trim($_POST['gender'])))));
	
	if (isset($_POST['avatar'])) $avatar=attribute_escape(strip_tags(stripslashes((trim($_POST['avatar'])))));
	
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
	
	
		
			
		
	
	if ( (isset($_POST['submit'])) || (isset($_POST['submit-upload'])) ) {
	
		require_once(ABSPATH.'/wp-includes/registration.php');
		//require_once(ABSPATH.'/wp-includes/pluggable.php');
	
		if ( !wp_verify_nonce( $_POST['wwm_profile_noncename'], plugin_basename(__FILE__) )) 
			return "Invalid nonce. Try agian.";


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
				$uploaderror.=$main_fields[20][name].':'.__('Image is very little.','wwm').'<br/>';
		
			}else{
				$uploaderror.=$main_fields[20][name].': '.$result['error'].'.<br/>';
				
			}
		}
	
		if ($file_custom_fields) {
		
			foreach($file_custom_fields as $field_id) {
				
					$override['test_form']=false;
					$allowed=unserialize($wpdb->get_var($wpdb->prepare("SELECT options FROM ".WWM_FIELDS_TABLE." WHERE id=%s;",$field_id)));
					$max_upload_size=get_option('wwm_max_upload');
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

		
		if ( (!empty($pass)) && ((strlen($pass2)>30) || ($pass!==$pass2) )) $msgerror.=__('Please re-type password to confirm.', 'wwm')."<br/>";
		if ( (!empty($pass)) && (strlen($pass)<=5) ) $msgerror.=__('Please enter a password(at least 6 characters).', 'wwm')."<br/>";
		
		if ( ($main_fields[1][show]) || ($main_fields[0][show]) ) {
			if ( ($main_fields[1][req]) && (strlen($email)<6) ) $msgerror.=__('Please enter a correct email address.', 'wwm')."<br/>";
			
			if ( ($main_fields[1][req]) && (email_exists($email)) && (!$email==$user->user_email) ) $msgerror.=__('That email already exists.', 'wwm')."<br/>";
			if ( (!wwm_validate_email($email)) && (!strlen($email)<6) ) $msgerror.=__('Please enter a correct email address.', 'wwm')."<br/>";
		}
	 
		if ( ($main_fields[2][req]) && (strlen($fname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[2][name])."<br/>";
		if ( ($main_fields[3][req]) && (strlen($lname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[3][name])."<br/>";
		if ( (($main_fields[6][req]) && (strlen($url)<10)) || ( (strlen($url)>1) &&
		(!ereg('^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~])*$',$url) ))) 
		$msgerror.=__('Please enter a correct URL.', 'wwm')."<br/>";
		if ( ($main_fields[4][req]) && (strlen($nname)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[4][name])."<br/>";
		if ( ($main_fields[18][req]) && (strlen($desc)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[18][name])."<br/>";
		if ( ($main_fields[7][req]) && (strlen($yahooim)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[7][name])."<br/>";
		if ( ($main_fields[8][req]) && (strlen($aolim)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[8][name])."<br/>";
		if ( ($main_fields[9][req]) && (strlen($jabberim)<4) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[9][name])."<br/>";
		
		if ( ($main_fields[5][req]) && (strlen($companyname)<2) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[5][name])."<br/>";
		
		if ( ($main_fields[12][req]) && (strlen($countryname)<1) ) $msgerror.=__('Please choose your country.', 'wwm')."<br/>";
		if ( ($main_fields[13][req]) && (strlen($statename)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[13][name])."<br/>";
		if ( ($main_fields[14][req]) && (strlen($cityname)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[14][name])."<br/>";
		if ( ($main_fields[15][req]) && (strlen($adrs)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[15][name])."<br/>";
		if ( ($main_fields[16][req]) && (strlen($zipcode)<1)  ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[16][name])."<br/>";
		if ( ($main_fields[17][req]) && (strlen($telephone)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[17][name])."<br/>";
		if ( (($main_fields[10][req]) && (strlen($birthday)<1)) || (($main_fields[10][req]) && (strlen($birthmonth)<1)) || (($main_fields[10][req]) && (strlen($birthyear)<1)) ) $msgerror.=__('Please choose your birthdate.', 'wwm')."<br/>";
	
		if ( ($main_fields[11][req]) && (strlen($gender)<1) ) $msgerror.=__('Please choose your gender.', 'wwm')."<br/>";
		if ( ($main_fields[19][show]) && (strlen($terms)<1) && ($preview) ) $msgerror.=sprintf(__('Please accept %s.', 'wwm'), $main_fields[19][name])."<br/>";
		if ( ($main_fields[20][req]) && (strlen($avatar)<1) ) $msgerror.=sprintf(__('Please upload a photo as %s.', 'wwm'), $main_fields[20][name])."<br/>";
		//if ( ($main_fields[22][req]) && (strlen($promocode)<1) ) $msgerror.=sprintf(__('Please enter %s.', 'wwm'), $main_fields[22][name])."<br/>";
		
	 	

} 
	
	if (empty($msgerror) && ($_POST['submit']) ) {
		
		$user_login = $user->user_login;
		$user_email = $email;
		if ($pass) $user_pass = md5($pass);
		
		$user_nicename=$nname;
		$user_url=$url;
		$display_name=$user_nicename;
		$first_name=$fname;
		$last_name=$lname;
		$description=$desc;
		//$role=''; leave to default userrole
		$yim=$yahooim;
		$aim=$aolim;
		$jabber=$jabberim;
		$ID=$user->ID;
		$id=$ID;
		
			$userdata = compact('ID','user_login', 'user_email', 'user_pass','user_nicename','user_url','display_name','first_name','last_name','description','yim','aim','jabber');

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
			
			update_usermeta($id,'avatar',$avatar);


			for ($i=1;$i<=$last_id;$i++) {
				if  ( ($custom_value[$i]) )
				update_usermeta($id,'customfield_'.$i,$custom_value[$i]);
			}
			
			wp_insert_user($userdata);
			
			$thanksmsg=__('User settings updated.','wwm')."<br/>";
			$hidden=true;
			echo '<div class="wwm-thanksmessage">'.$thanksmsg.'</div>';
					
	
	}else{ //else if there is error
	
		 if ( ($msgerror)&&(isset($_POST['submit'])) ) echo '<div class="wwm-errormessage" >'.$msgerror.'</div>';	
	
	
	if ($uploaderror) echo '<div class="wwm-errormessage" >'.$uploaderror.'</div>';	
	
if (!$hidden) {	
$ba=get_usermeta($user->ID,'balance');
	?>
	
	<div class="wwm_register_page">
    <?php echo __('Balance','wwm') .': <strong>';
	if (!$ba) echo '0'; else echo $ba;
	echo  ' '.get_option('wwm_paypal_currency_code').'</strong><br/>';
	$wwm_pages=get_option('wwm_pages');
	if ($plan_id) {  $plan=get_plan_info($plan_id); echo __('Plan','wwm').': <strong>'. $plan->title.' </strong><br/>'; } ?>
      <?php if ($expire) echo __('Expire','wwm').': <strong>'. $expire.'</strong><br/><br/>';
	  if (($expire) || ($plan_id))
	  echo '<a href="'.add_query_arg(array('action' => 'renew_upgrade'), get_permalink($wwm_pages['register']) ).'"><input type="button" name="upgrade_it" value="'.__('Upgrade','wwm').' / '.__('Renew','wwm').'"></a><br/><br/>'; 
	  ?>

	<form  name="wordpresswave_members_plugin" id="wwm-members-form" method="post" enctype="multipart/form-data">
	<!--
	<label><?php _e('Username','wwm'); ?></label> <br />
	<input type="text" name='username' id="wwm-username" disabled= "disabled" autocomplete="off" value="<?php echo $user->user_login; ?>"   /></label><br />
	
	<br />-->
	<label><?php _e('Change Password','wwm'); ?></label> <br />
	<input type="password" name='pass' id="wwm-pass" value=""  autocomplete="off" /></label><br />
	
	<label><?php _e('Confirm Password','wwm'); ?></label> <br />
	<input type="password" name='pass2' id="wwm-pass2" value="" autocomplete="off" /></label><br /><br />
	<?php 
	 if ( ($main_fields[1][show]) || ($main_fields[0][show]) ) { //we need mail to register users so we show email when username-pass is show even when mail is hidden?>
	
	<label><?php echo $main_fields[1][name]; if ( ($main_fields[0][show]) || ($main_fields[1][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='email' id="wwm-email" value="<?php echo $email; ?>"   /></label><br /><small><?php echo $main_fields[1][desc]; ?></small><br/>
	
	<?php } 
	
	if ( ($main_fields[2][show]) ) {
	?>
	<label><?php echo $main_fields[2][name]; if ( ($main_fields[2][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='fname' id="wwm-fname" value="<?php echo $fname; ?>"   /></label><br /><small><?php echo $main_fields[2][desc]; ?></small><br />
	
	<?php } 
	if ( ($main_fields[3][show]) ) {
	?>
	<label><?php echo $main_fields[3][name]; if ( ($main_fields[3][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='lname' id="wwm-lname" value="<?php echo $lname; ?>"  /></label><br /><small><?php echo $main_fields[3][desc]; ?></small><br />
	
	<?php } 
	
	if ( ($main_fields[20][show]) ) {
	$avatar_size=get_option('wwm_avatar_width');
	?>
	<label><?php echo $main_fields[20][name];if ( ($main_fields[20][req])) echo  ' <span class="wwm-star">*</span>'; ?>
	<?php if($avatar)echo '<strong><span style="color: green;"> </span></strong><br/>'. __('Change it below','wwm');?><br /><?php if($avatar) echo '<img src="'.$avatar.'" class="wwm-avatar-img" height="'.$avatar_size.'" width="'.$avatar_size.'" /><input type="hidden" name="avatar" value="'.$avatar.'"> '; ?></label>
	<input type="file" name="avatarfile" id="wwm-avatar" />
	<input type="submit" name="submit-upload" value="<?php  _e('Upload','wwm');?>"  id="wwm_submit-upload" /> 
	<br /><small><?php echo $main_fields[20][desc]; ?></small>
	
	<p>
	
	
	<?php
	}
	if ( ($main_fields[4][show]) ) {
	?>
	<label><?php echo $main_fields[4][name];  if ( ($main_fields[4][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='nname' id="wwm-nname" value="<?php echo $nname; ?>"   /></label><br /><small><?php echo $main_fields[4][desc]; ?></small><br />
	
	<?php } 
	if ( ($main_fields[5][show]) ) {?>
	<label><?php echo $main_fields[5][name];  if ( ($main_fields[5][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='companyname' id="wwm-companye" value="<?php echo $companyname; ?>"   /></label><br /><small><?php echo $main_fields[5][desc]; ?></small><br />
	
	<?php }
	if ( ($main_fields[6][show]) ) {?>
	<label><?php echo $main_fields[6][name];  if ( ($main_fields[6][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='url' id="wwm-url" value="<?php echo $url; ?>" /></label><br /><small><?php echo $main_fields[6][desc]; ?></small><br />
	
	<?php }
	if ( ($main_fields[7][show]) ) {?>
	<label><?php echo $main_fields[7][name];  if ( ($main_fields[7][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='yahooim' id="wwm-yahooim" value="<?php echo $yahooim; ?>"   /></label><br /><small><?php echo $main_fields[7][desc]; ?></small><br />
	
	<?php }
	if ( ($main_fields[8][show]) ) {?>
	<label><?php echo $main_fields[8][name];  if ( ($main_fields[8][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='aolim' id="wwm-aolim" value="<?php echo $aolim; ?>"   /></label><br /><small><?php echo $main_fields[8][desc]; ?></small><br />
	
	<?php }
	if ( ($main_fields[9][show]) ) {?>
	<label><?php echo $main_fields[9][name];  if ( ($main_fields[9][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<input type="text" name='jabberim' id="wwm-jabberim" value="<?php echo $im; ?>"   /></label><br /><small><?php echo $main_fields[9][desc]; ?></small><br />
	
	<?php }
	if ( ($main_fields[11][show]) ) {?>
	<label><?php echo $main_fields[11][name];  if ( ($main_fields[11][req])) echo  ' <span class="wwm-star">*</span>'; ?><br /> 
	<small><?php echo $main_fields[11][desc]; ?></small>
	<input name="gender" type="radio" id="wwm-m" value="m" <?php if ($gender=='m') echo 'checked="checked"';?>/><?php  _e('Male','wwm');?></label><label>
	
	&nbsp;&nbsp;<input name="gender" type="radio" id="wwm-f" value="f" <?php if ($gender=='f') echo 'checked="checked"';?>/><?php  _e('Female','wwm');?></label>
	<br /><br />
	
	<?php }
	if ( ($main_fields[10][show]) ) {?>
	<label><?php echo $main_fields[10][name];  if ( ($main_fields[10][req])) echo  ' <span class="wwm-star">*</span>'; ?></label><br />
	<small><?php echo $main_fields[10][desc]; ?></small>
	<select type="text" name='birthday' id="wwm-birthday" value="<?php echo $birthday; ?>"  />
	<option value="" selected="selected"><?php _e('-Day-','wwm'); ?></option>
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
	
	
	
	<select class="wwm-birthmonth" name="birthmonth" id="wwm-birthmonth">
	<option value="" selected="selected"><?php _e('-Month-','wwm'); ?></option>
		<option value="01" <?php if ($birthmonth=='01') echo 'selected="selecteed"';?>><?php  _e('Januaray','wwm'); ?></option>
		<option value="02" <?php if ($birthmonth=='02') echo 'selected="selecteed"';?>><?php  _e('February','wwm'); ?></option>
		<option value="03" <?php if ($birthmonth=='03') echo 'selected="selecteed"';?>><?php  _e('March','wwm'); ?></option>
		<option value="04" <?php if ($birthmonth=='04') echo 'selected="selecteed"';?>><?php  _e('April','wwm'); ?></option>
		<option value="05" <?php if ($birthmonth=='05') echo 'selected="selecteed"';?>><?php  _e('May','wwm'); ?></option>
		<option value="06" <?php if ($birthmonth=='06') echo 'selected="selecteed"';?>><?php  _e('June','wwm'); ?></option>
		<option value="07" <?php if ($birthmonth=='07') echo 'selected="selecteed"';?>><?php  _e('July','wwm'); ?></option>
		<option value="08" <?php if ($birthmonth=='08') echo 'selected="selecteed"';?>><?php  _e('August','wwm'); ?></option>
		<option value="09" <?php if ($birthmonth=='09') echo 'selected="selecteed"';?>><?php  _e('September','wwm'); ?></option>
		<option value="10" <?php if ($birthmonth=='10') echo 'selected="selecteed"';?>><?php  _e('October','wwm'); ?></option>
		<option value="11" <?php if ($birthmonth=='11') echo 'selected="selecteed"';?>><?php  _e('November','wwm'); ?></option>
		<option value="12" <?php if ($birthmonth=='12') echo 'selected="selecteed"';?>><?php  _e('December','wwm'); ?></option>   
	</select>
	
	<select class="wwm-birthyear" name="birthyear" id="wwm-birthdayyear">
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
	
	<br /><br />
	
	<?php } ?>
	
	<?php //Custom fields here
	$fields=$wpdb->get_results("SELECT * FROM ".WWM_FIELDS_TABLE." WHERE pagetype='registration' AND display=1 ORDER BY fieldorder;");
	if ($fields) {
		foreach ($fields as $field) {
		
		echo '<label>'.$field->label.'</label>'; if  ($field->req) echo  ' <span class="wwm-star">*</span>'; echo'<br/>';
		//req
			if ( $field->fieldtype=='text' ) {
			echo '<input name="custom-'.$field->id.'" type="'.$field->fieldtype.'" class="wwm-customfield-'.$field->id.'" id="wwm-customfield-'.$field->id.'" class="wwm-customfield" value="'.$custom_value[$field->id].'"/>';
			echo '</label><br/><small>'.$field->description.'</small>';
			}
			
			if ($field->fieldtype=='checkbox') {
			echo '<small>'.$field->description.'</small><br/>';
					$options=unserialize($field->options);
					
					//make array
					foreach ($options as $optionarray=>$option) { 
					  echo '<label ><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'" class="wwm-customfield-'.$field->id.'" id="wwm-customfield-'.$field->id.'" value="'.$option.'"/';
						 if($option==$custom_value[$field->id])echo'checked="checked"'; 
						 echo '/>'.$option.'</label><br/>';
					}
					
			}
			
			if ($field->fieldtype=='radio') {
				$options=unserialize($field->options);
				foreach ($options as $option) { 
				echo '<label><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'"';
				$customname='custom-'.$field->id;
				if ($option==$custom_value[$field->id]) echo 'checked="checked"';
				echo  'class="wwm-customfield-radio" id="wwm-customfield-'.$field->id.'" value="'.$option.'"/>'.$option.'</label><br/>';
				}
			echo '<small>'.$field->description.'</small>';
			}
			
			if ($field->fieldtype=='file') {
				
				if ((empty($custom_value[$field->id]))|| (($custom_value[$field->id])=='error') ) {
				echo '<label><input name="custom-'.$field->id.'" type="'.$field->fieldtype.'" class="wwm-customfield-'.$field->id.'" id="wwm-customfield-'.$field->id.'"/></label><br/>';
				
				echo '<label><input name="file-'.$field->id.'" type="hidden" id="wwm-customfield-'.$field->id.'" value="'.$field->id.'"/></label>';
				}else{
				echo '<strong><span style="color: green;"> '.__('[Uploaded]','wwm').'</span></strong><br/><input name="custom-'.$field->id.'" type="hidden" value="'.$custom_value[$field->id].'">';
				}
			echo '<small>'.$field->description.'</small>';
			}
			
			
			if ($field->fieldtype=='dropdown') {
				$options=unserialize($field->options);
				?>
				<select class="wwm-country" name="custom-<?php echo $field->id; ?>" id="wwm-customfield-<?php echo $field->id; ?>">
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
				
			echo '<br/><small>'.$field->description.'</small>';
			}
			
			
			if ($field->fieldtype=='textarea') {
			echo '<small>'.$field->description.'</small><br/>
			<textarea name="custom-'.$field->id.'" class="wwm-customfield-'.$field->id.'">';
				if (isset($_POST['custom-'.$field->id])) echo $_POST['custom-'.$field->id];
			echo '</textarea><br/>';
			}
			
		echo '<br/>';
		}
	}	
	?>
	
	<?php if ( ($main_fields[12][show]) ) { ?>
	<label><?php echo $main_fields[12][name];  if ( ($main_fields[12][req])) echo  ' <span class="wwm-star">*</span>'; ?>
	<br/>
	<select class="wwm-country" name="countryname" id="wwm-country">
	<option value="" selected="selected"><?php _e('Select your country','wwm');?></option>
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
	</label><br /><?php echo $main_fields[13][desc]; ?><br />
	<?php } 
	 if ( ($main_fields[13][show]) ) {?>
	<label><?php echo $main_fields[13][name];  if ( ($main_fields[13][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='statename' id="wwm-state" value="<?php echo $statename; ?>"    /></label><br /><small><?php echo $main_fields[13][desc]; ?></small><br />
	
	<?php } 
	 if ( ($main_fields[14][show]) ) {?>
	<label><?php echo $main_fields[14][name];  if ( ($main_fields[14][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='cityname' id="wwm-city" value="<?php echo $cityname; ?>"    /></label><br /><small><?php echo $main_fields[14][desc]; ?></small><br />
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<label><?php echo $main_fields[15][name];  if ( ($main_fields[15][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='adrs' id="wwm-address" value="<?php echo $adrs; ?>"    /></label><br /><small><?php echo $main_fields[15][desc]; ?></small><br />
	
	<?php } 
	 if ( ($main_fields[15][show]) ) {?>
	<label><?php echo $main_fields[15][name];?> 2<br />
	<input type="text" name='adrs2' id="wwm-address2" value="<?php echo $adrs2; ?>"    /></label><br /><br />
	
	<?php } 
	 if ( ($main_fields[16][show]) ) {?>
	<label><?php echo $main_fields[16][name];  if ( ($main_fields[16][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='zipcode' id="wwm-zip" value="<?php echo $zipcode; ?>"    /></label><br /><small><?php echo $main_fields[16][desc]; ?></small><br />
	
	<?php } 
	 if ( ($main_fields[17][show]) ) {?>
	<label><?php echo $main_fields[17][name];  if ( ($main_fields[17][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<input type="text" name='telephone' id="wwm-phone" value="<?php echo $telephone; ?>"    /></label><br /><small><?php echo $main_fields[17][desc]; ?></small><br />
	
	<?php } 
	 if ( ($main_fields[18][show]) ) {?>
	<label><?php echo $main_fields[18][name];  if ( ($main_fields[18][req])) echo  ' <span class="wwm-star">*</span>'; ?><br />
	<small><?php echo $main_fields[18][desc]; ?></small><br />
	<textarea name='desc' id="wwm-desc" ><?php echo $desc; ?></textarea></label><br /><br />
	
	<?php } ?>
	
	 <?php 
	echo '<input type="hidden" name="wwm_profile_noncename" id="wwm_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';?>
  
	<input type="submit" name="submit" value="<?php _e('Save Changes', 'wwm');?>" id="wwm-submit" />
	
	</p></form></div>
	<?php	
	}//end if
}//end of hidden

?>