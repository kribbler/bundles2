<?php
if ('content-functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

function get_current_user_plan_id(){
	global $wpdb,$current_user, $user_ID;
	$userid=$user_ID;
	if ($user_ID == 0) 
		$userid = $current_user->id;
	return get_usermeta($userid,'plan_id');
}

function is_paid_member() {
global $wpdb,$current_user, $user_ID, $user_level;
		
	$userid=$user_ID;
	if ($user_ID == 0) 
		$userid = $current_user->id;
	
	if ($user_level>7)
		return true;

	if (is_google_bot())
		return true;
		
	$user_plan_id=get_usermeta($userid,'plan_id');
	$paidplans=$wpdb->get_results("SELECT id FROM ".WWM_PLANS_TABLE." WHERE price>0");
	
	if ($paidplans) {
		foreach ($paidplans as $plan) {
			if ($plan->id==$user_plan_id)
				return true;
		}
	return false;
	}
}


function is_google_bot() {
		if ( (get_option('first_click_free')) &&  ( (eregi("http://google.",$_SERVER['HTTP_REFERER'])) || (eregi(".google.",$_SERVER['HTTP_REFERER'])) ) ) 
			return true;
		if(eregi("Googlebot",$_SERVER['HTTP_USER_AGENT']))
			return true;
		if(eregi("Yahoo",$_SERVER['HTTP_USER_AGENT']))
			return true;
		if(eregi("MSNBot",$_SERVER['HTTP_USER_AGENT']))
			return true;
		if(eregi("bing",$_SERVER['HTTP_USER_AGENT']))
			return true;
	return false;
}


function get_premium_content($content) {
	global  $wpdb,$user_level,$current_user, $user_ID, $post;
	
		$userid=$user_ID;
		if ($user_ID == 0) $userid = $current_user->id;
		
		$domain = $_SERVER['HTTP_HOST'];
		$url = "http://" . $domain . $_SERVER['REQUEST_URI'];
		
		$monly_tag='onlymembers';
		$pponly_tag='onlypaid';
		$ponly_tag='onlyplans';
		$nonly_tag='nonmembers';
			
		$post_viewers=get_post_meta($post->ID, '_wwm_post_viewers', true);
		
		if ($post_viewers['0'])
			$post_viewers=$post_viewers['0'];
		elseif (!is_array($post_viewers))
			$post_viewers['who']=$post_viewers;
		
		
		if (isset($_POST['buy_it']) && ($_POST['buy_it']==$post->ID)) {
			$balance=get_usermeta($user_ID, 'balance');
			if ($balance>=$post_viewers['price']) {
				update_usermeta($user_ID, 'balance',$balance - $post_viewers['price']);
				
				$checkid= substr( md5( uniqid( microtime() ) ), 0, 16);
				 
				$sql="INSERT INTO ".WWM_ORDERS_TABLE."
					(postid, userid, status, type, checkid,gross, payment_status, ip) VALUES (%s,%s,%s,%s,%s,%s,%s,%s);";
			
				$wpdb->query($wpdb->prepare($sql,$post->ID, $user_ID, 'Get Post [#'.$post->ID.']','post-deposit',$checkid, $post_viewers['price'], 'Completed', $_SERVER['REMOTE_ADDR'] ));
				
				
				if (get_option('pay_per_post_mail'))	{
					$blogname=get_option('blogname');
					$subject='Your order at '.$blogname.'!';
					$post_url=add_query_arg(array('action' => 'get_post','cid'=> $checkid),get_permalink($post->ID) );
					
					$body=get_option('pay_per_post_mail_body');
					$tags=array('{post-url}','{download-url}','{posttitle}','{firstname}','{lastname}','{username}','{userid}','{orderid}');
					$replace=array($post_url,'','"'.$post->post_title.'"',$current_user->first_name,$current_user->last_name,$current_user->user_login,$current_user->ID, mysql_insert_id());
					$body=str_replace($tags,$replace,$body);
					$body.='<p><small>Powered by <a href="http://wpwave.com/plugins/cms-members/">CMS Members</a><small>';
					
					wwm_mail_actions('html'); //set actions
					
					if ( !wp_mail($to, $subject, $body, $header) ) 
							$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
				}
				
				if(get_option('notify_pay_per_post')) {
					$to=get_option('admin_email');
					
					$blogname=get_option('blogname');
					$subject='['.$blogname.'] New Pay Per Post';
					$body="New Pay Per Post. Details: \n";
					$body.="A new free member registered. \nUsername: {$current_user->user_login} \nPost Title: {$post->post_title} \nPost URL: ".get_permalink($post->ID)."\nPrice: {$post_viewers['price']}\n Full details:\n";
					$body.=get_option('siteurl')."/wp-admin/admin.php?page=wwm-orders.php&view_order_id=".mysql_insert_id()." \n\nRegards,\nCMS Members\n";
					
					//wwm_mail_actions('html'); //set actions
					
					if ( !wp_mail($to, $subject, $body, $header) ) 
							$msg= __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') ;
				} 
				$full=true;
						
			}else{
				echo '<script type="text/javascript">alert("You have not enough balance!")</script>';
			}
		}
		
		if (isset($_GET['cid']) && isset($_GET['action']) && ($_GET['action']=='get_post') && strlen($_GET['cid'])=='16' ) {
				if (is_user_logged_in() && ($post->ID==$wpdb->get_var("SELECT postid FROM ".WWM_ORDERS_TABLE. " WHERE checkid='".esc_attr($_GET['cid'])."' AND payment_status='Completed' ;")) ) 
					$full=true;
					
		}elseif (isset($_GET['cid']) && (!is_user_logged_in())){
				echo '<script type="text/javascript">alert("Please login first to acccess the content!")</script>';
		}
		
		$non_membersRegex="/\\[".$nonly_tag."\\].*?\\[\/".$nonly_tag."\\]/is";
		$startponly = strpos($content, '['.$ponly_tag.'=');
		$endponly = strpos($content, '[/'.$ponly_tag.']');
		
		if (!(($startnonly===FALSE) && ($endnonly===FALSE))) $n_only=true; else $n_only=false;
		
		if ( ($n_only) && (is_user_logged_in()) ){
			$content = preg_replace($non_membersRegex,' ',$content);	
		}
			
		if ($full){
			$remove_tags=array('['.$monly_tag.']','[/'.$monly_tag.']','['.$pponly_tag.']','[/'.$pponly_tag.']','['.$nonly_tag.']', '[/'.$nonly_tag.']');
			$content= str_replace($remove_tags,'',$content);
			$onlyplanstag[]="/\\[onlyplans=(\d+)(|,\d+|,)(|,\d+|,)(|,\d+|,)(|,\d+|,)\]/is";
			$onlyplanstag[]="/\\[\/onlyplans\\]/";
			
			return  $content;
		}
		
		if ( ('members'==$post_viewers['who']) && (!is_user_logged_in()) && ($user_level<8) && (!is_google_bot()) ){
			return "<div class='limited'>".str_replace('{login_url}',wp_login_url($url),get_option('monly_msg'))."</div>";
		}
		
		if ( ('paidmembers'==$post_viewers['who']) && (!is_paid_member()) ){
			return "<div class='limited'>".str_replace('{login_url}',wp_login_url($url),get_option('pponly_msg'))."</div>";
		}
		
		if ( (is_numeric($post_viewers['who'])) && ($post_viewers['who']!=get_current_user_plan_id()) && ($user_level<8) && (!is_google_bot()) ){
			return "<div class='limited'>".str_replace('{login_url}',wp_login_url($url),get_option('ponly_msg'))."</div>";
		}
	
		
		$membersRegex="/\\[".$monly_tag."\\].*?\\[\/".$monly_tag."\\]/is";
		$paidplansRegex="/\\[".$pponly_tag."\\].*?\\[\/".$pponly_tag."\\]/is";
		$plansRegex = "/\\[".$ponly_tag."=(\d+)(|,\d+|,)(|,\d+|,)(|,\d+|,)(|,\d+|,)(|,\d+|,)\].*?\\[\/".$ponly_tag."\\]/is";
	
		$startmonly = strpos($content, '['.$monly_tag.']');
		$endmonly = strpos($content, '[/'.$monly_tag.']');
		
		$startpponly = strpos($content, '['.$pponly_tag.']');
		$endpponly = strpos($content, '[/'.$pponly_tag.']');
		
		$startponly = strpos($content, '['.$ponly_tag.'=');
		$endponly = strpos($content, '[/'.$ponly_tag.']');
			
			if (  ($user_level<8) && (!is_google_bot() ) )   {

				if (!(($startmonly===FALSE) && ($endmonly===FALSE))) $m_only=true; else $m_only=false;
				if (!(($startpponly===FALSE) && ($endpponly===FALSE))) $pp_only=true; else $pp_only=false;
				if (!(($startponly===FALSE) && ($endponly===FALSE))) $p_only=true; else $p_only=false;
						
				if ( ($m_only) && (!is_user_logged_in()) ){
						//$please_login=str_replace('{login_url}',wp_login_url($url),get_option('monly_msg'));
						$please_login= "<div class='limited'>". str_replace('{login_url}',wp_login_url($url),get_option('monly_msg'))."</div>";
						$content = preg_replace($membersRegex,$please_login,$content);
					
				}
				if ( ($pp_only) && (!is_paid_member()) ){
						//$please_upgrade=str_replace('{login_url}',wp_login_url($url),get_option('pponly_msg'));
						$please_upgrade= "<div class='limited'>".str_replace('{login_url}',wp_login_url($url),get_option('pponly_msg'))."</div>";
						$content = preg_replace($paidplansRegex,$please_upgrade,$content);
					
				}
				if ($p_only)  {
					if	(preg_match_all($plansRegex, $content, $matches)) {
							if (is_array($matches)) {
							foreach($matches as $key ){
								if ($matches[0][0]!==$key[0]) {
								$key[0]=str_replace(',','',$key[0]);
								$result = $wpdb->get_var($wpdb->prepare("SELECT title FROM ".WWM_PLANS_TABLE." WHERE id=%s LIMIT 1;",$key[0]));
									if($result)
										$ids[]=$key[0];
									}
								}
							}
					}
					$user_allow=false;
				
				
					if (is_array($ids)) {
						$user_plan=get_current_user_plan_id();
						
						foreach ($ids as $id) 
							if ($user_plan==$id) 
								$user_allow=true;
					}
					
					if ($user_level>7)
						$user_allow=true;
					
					if ( (!$user_allow) && (!current_user_can('level_8')) ) {
						//$replace= str_replace('{login_url}',wp_login_url($url),get_option('ponly_msg'));
						$replace= "<div class='limited'>".str_replace('{login_url}',wp_login_url($url),get_option('ponly_msg'))."</div>";
						$content=preg_replace($plansRegex,$replace, $content);
						
					}	
				}
			}	
				
			$remove_tags=array('['.$monly_tag.']','[/'.$monly_tag.']','['.$pponly_tag.']','[/'.$pponly_tag.']','['.$nonly_tag.']', '[/'.$nonly_tag.']');
			$content= str_replace($remove_tags,'',$content);
			$onlyplanstag[]="/\\[onlyplans=(\d+)(|,\d+|,)(|,\d+|,)(|,\d+|,)(|,\d+|,)\]/is";
			$onlyplanstag[]="/\\[\/onlyplans\\]/";
		
			$content=preg_replace($onlyplanstag,'', $content);
			return $content;
}
?>