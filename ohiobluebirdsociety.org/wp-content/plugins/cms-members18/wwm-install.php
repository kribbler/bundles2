<?php
if ('wwm-install.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 
function ww_members_install() {
	global  $wpdb,$wp_rewrite;
	
	$posttable=$wpdb->prefix . "posts";
	$charset_collate = '';
	if ( $wpdb->supports_collation() ) {
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
	}
	
	$post_date=date('Y-m-d H:i:s');
	$post_date_gmt=gmdate('Y-m-d H:i:s');
	
	$last_id=$wpdb->get_var("SELECT ID FROM {$posttable} ORDER BY ID DESC LIMIT 1;");
	$last_id++;
	$page_guid = get_option('home') . '/?page_id='.$last_id;
	
	$ver = get_option('wwm_version') ;
	
	if (($ver)&&($ver<='1.85') ) {
		$wpdb->query("ALTER TABLE ".WWM_ORDERS_TABLE." ADD COLUMN postid bigint(20) NOT NULL;");
		$wpdb->query("ALTER TABLE ".WWM_ORDERS_TABLE." ADD COLUMN type varchar(255) NOT NULL;");
		$wpdb->query("ALTER TABLE ".WWM_ORDERS_TABLE." ADD COLUMN downloads bigint(20) NOT NULL;");	
	}
		
	$sql ="INSERT INTO {$posttable}
					(post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)
					VALUES
					('1', '$post_date', '$post_date_gmt', '[cms_members_form]', '', '".__('Register','wwm')."', '', 'publish', 'closed', 'closed', '', 'register', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page');";
		
	$sql2='CREATE TABLE '.WWM_PLANS_TABLE.' (
				  id bigint(20) auto_increment NOT NULL,
				  ref varchar(255) NOT NULL,
				  display tinyint(2) NOT NULL,
				  title text NOT NULL,
				  duration bigint(20) NOT NULL,
				  price float NOT NULL,
				  plantype varchar(64) NOT NULL,
				  description longtext NOT NULL,
				  options text NOT NULL,
				  PRIMARY KEY (id)
				)'.$charset_collate.';';
		
	$sql3='CREATE TABLE '.WWM_FIELDS_TABLE.' (
			  id bigint(20) auto_increment NOT NULL,
			  label text NOT NULL,
			  regex text NOT NULL,
			  display text NOT NULL,
			  req text NOT NULL,
			  fieldtype varchar(64) NOT NULL,
			  description longtext NOT NULL,
			  options longtext NOT NULL,
			  fieldorder float NOT NULL,
			  pagetype varchar(64) NOT NULL,
			  PRIMARY KEY (id)
			)'.$charset_collate.';';

	$sql4='CREATE TABLE '.WWM_ORDERS_TABLE.' (
			  id bigint(20) auto_increment NOT NULL,
			  planid bigint(20) NOT NULL,
			  userid bigint(20) NOT NULL,
			  postid bigint(20) NOT NULL,
			  status varchar(64) NOT NULL,
			  checkid varchar(100) NOT NULL,
			  type varchar(255) NOT NULL,
				
			  txnid varchar(64) NOT NULL,
			  memo varchar(250) NOT NULL,
			  payment_status varchar(64) NOT NULL,
			  payment_date datetime NOT NULL,
			  payer_mail varchar(100) NOT NULL,
			  payer_fname varchar(64) NOT NULL,
			  payer_lname varchar(64) NOT NULL,
			  payer_country varchar(64) NOT NULL,
			  verify_sign varchar(64) NOT NULL,
			  gross varchar(64) NOT NULL,
			  user_login varchar(60) NOT NULL,
			  user_email varchar(100) NOT NULL,
			  user_pass varchar(64) NOT NULL,
			  user_nicename varchar(50) NOT NULL,
			  user_url varchar(100) NOT NULL,
			  display_name varchar(250) NOT NULL,
			  first_name varchar(64) NOT NULL,
			  last_name varchar(64) NOT NULL,
			  description varchar(250) NOT NULL,
			  yim  varchar(50) NOT NULL,
			  aim  varchar(50) NOT NULL,
			  jabber  varchar(50) NOT NULL,
			  
			  company  varchar(64) NOT NULL,
			  country  varchar(64) NOT NULL,
			  state  varchar(50) NOT NULL,
			  city  varchar(64) NOT NULL,
			  address  text NOT NULL,
			  address2  text NOT NULL,
			  zip  varchar(20) NOT NULL,
			  phone  varchar(20) NOT NULL,
			  birthday  datetime NOT NULL,
			  gender  varchar(20) NOT NULL,
			  ip  varchar(64) NOT NULL,
			  avatar varchar(100) NOT NULL,
			  promocode varchar(50) NOT NULL,
			  
			  failed_details text NOT NULL,
			  downloads bigint(20) NOT NULL,
			  customfields longtext NOT NULL,
			  PRIMARY KEY (id)
			)'.$charset_collate.';';

	$sql5 ="INSERT INTO {$posttable}
				(post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)
				VALUES
				('1', '$post_date', '$post_date_gmt', '[cms_members_profile]', '', '".__('Edit Profile','wwm')."', '', 'publish', 'closed', 'closed', '', 'profile', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page');";
	
	
	$sql6 ="INSERT INTO {$posttable}
				(post_author, post_date, post_date_gmt, post_content, post_content_filtered, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_parent, menu_order, post_type)
				VALUES
				('1', '$post_date', '$post_date_gmt', '[cms_members_deposit]', '', '".__('Deposit','wwm')."', '', 'publish', 'closed', 'closed', '', 'deposit', '', '', '$post_date', '$post_date_gmt', '0', '0', 'page');";	

	if (!get_option('wwm_pages')) {
		$wpdb->query($sql);	
		$wwm_pages['register']=mysql_insert_id();
		$wpdb->query($sql5);
		$wwm_pages['profile']=mysql_insert_id();
		$wpdb->query($sql6);
		$wwm_pages['deposit']=mysql_insert_id();
	}
	
	$wpdb->query($sql2);	
	$wpdb->query($sql3);
	$wpdb->query($sql4);
	
	$list['0'][name]='Username-Password';
	$list['0'][show]='1';
	$list['0'][req]='1';
	
	$list['1'][name]=__('Email','wwm');
	$list['1'][show]='1';
	$list['1'][req]='1';
	
	$list['2'][name]=__('First name','wwm');
	$list['2'][show]='1';
	$list['2'][req]='1';
	
	$list['3'][name]=__('Last name','wwm');
	$list['3'][show]='1';
	$list['3'][req]='1';
	
	$list['4'][name]=__('Nickname','wwm');
	$list['4'][show]='0';
	$list['4'][req]='0';
	
	$list['5'][name]=__('Company','wwm');
	$list['5'][show]='0';
	$list['5'][req]='0';
	
	$list['6'][name]=__('URI','wwm');
	
	$list['6'][show]='1';
	$list['6'][req]='0';
	$list['6'][desc]=__('Starts with http://','wwm');
	
	$list['7'][name]=__('Yahoo IM','wwm');
	$list['7'][show]='1';
	$list['7'][req]='0';
	
	$list['8'][name]=__('AOL IM','wwm');
	$list['8'][show]='0';
	$list['8'][req]='0';
	
	$list['9'][name]=__('Jabber IM','wwm');
	$list['9'][show]='0';
	$list['9'][req]='0';
	
	$list['10'][name]=__('Birth Date','wwm');
	$list['10'][show]='1';
	$list['10'][req]='0';
	
	$list['11'][name]=__('Gender','wwm');
	$list['11'][show]='1';
	$list['11'][req]='0';
	
	$list['12'][name]=__('Country','wwm');
	$list['12'][show]='1';
	$list['12'][req]='1';
	
	$list['13'][name]=__('State/Province','wwm');
	$list['13'][show]='1';
	$list['13'][req]='0';
	
	$list['14'][name]=__('City','wwm');
	$list['14'][show]='1';
	$list['14'][req]='0';
	
	$list['15'][name]=__('Address','wwm');
	$list['15'][show]='1';
	$list['15'][req]='0';
	
	$list['16'][name]=__('ZIP/Postal Code','wwm');
	$list['16'][show]='1';
	$list['16'][req]='0';
	
	$list['17'][name]=__('Phone','wwm');
	$list['17'][show]='1';
	$list['17'][req]='0';
	
	$list['18'][name]=__('Note','wwm');
	$list['18'][show]='0';
	$list['18'][req]='0';
	$list['18'][desc]=__('Any comment here.','wwm');
	
	$list['19'][name]=__('Terms','wwm');
	$list['19'][show]='1';
	$list['19'][req]='1';
	
	$list['20'][name]=__('Avatar','wwm');
	$list['20'][show]='0';
	$list['20'][req]='0';
	$list['20'][desc]=__('Allowed file types: jpg,gif,png. Max size: 100KB','wwm');
	
	$list['21'][name]=__('CAPTCHA','wwm');
	$list['21'][show]='0';
	$list['21'][req]='0';
	$list['21'][desc]=__('Type above text in the field','wwm');
	
	$list['22'][name]=__('Promo Code','wwm');
	$list['22'][show]='1';
	$list['22'][req]='0';
	$list['22'][desc]=__('If you have a promo code type it above otherwise leave it blank.','wwm');
	
	
	$list['23'][name]=__('Payment Method','wwm');
	$list['23'][show]='1';
	$list['23'][req]='0';
	$list['23'][desc]='';
	
	if ((function_exists(is_site_admin)) && ($wpdb->blogid=='1') ) {
		$list['100'][name]=__('Blog Domain','wwm');
		$list['100'][show]='1';
		$list['100'][req]='1';
		$list['100'][desc]='';
		
		$list['101'][name]=__('Blog Title','wwm');
		$list['101'][show]='1';
		$list['101'][req]='1';
		$list['101'][desc]='';
	}
	
	add_option('wwm_pages',$wwm_pages);
	add_option('wwm_2co_mode','test');
	add_option('wwm_2co_secret','My Secret String');
	
	add_option('use_plugin_as','membership');
	add_option('wwm_users_can_register',1);
	
	add_option('notify_free_members_signup',1);
	add_option('notify_paid_members_signup',1);
	
	
	add_option('pay_per_post_mail','1');
	add_option('pay_per_post_mail_body','Hi {firstname} {lastname}<br> Thank you for your purchase! [Order #{orderid}]. Use below link to get your order <br>{posttitle} <br>{post-url}<br>{download-url}<br><br> Regards<br> Support Team');
	
	add_option('free_members_welcome_mail',0);
	add_option('free_members_welcome_mail_body','Hi {firstname} {lastname}<br> Welcome to our site! here is some details about your account/order<br>Username:{username} <br>Password:{password}<br>Plan:{plantitle}<br> Regards<br> Support Team');
	add_option('paid_members_welcome_mail',0);
	
	add_option('paid_members_welcome_mail_body','Hi {firstname} {lastname}<br> Welcome to our site! here is some details about your account/order<br>Username:{username} <br>Password:{password}<br>Plan:{plantitle}<br> Regards<br> Support Team');
	
	add_option('wwm_verify_mail_needed',1);
	add_option('verify_mail_body','Hi {firstname} {lastname}<br> Thank you for your registartion! click below to activate your account:<br>{activation-link}<br> Regards<br> Support Team');
	
	add_option('wwm_show_preview','0');
	add_option('wwm_form_validator','1');
	
	add_option('wwm_paypal_mode','test');
	add_option('wwm_paypal_mail_address','');
	add_option('wwm_paypal_currency_code','USD');
	add_option('wwm_discount_code','');
	
	add_option('monly_msg',stripslashes("This post is only viewable for members. Please <a href='{login_url}'>Login</a> to view full text."));
	add_option('pponly_msg',stripslashes("This post is only viewable for paid members please upgrade your account to view full text."));
	add_option('ponly_msg',stripslashes("You can not see this text please upgrade your account."));
	
	
	add_option('wwm_cap_type','simple');
	add_option('wwm_avatar_width','64');
	add_option('wwm_max_upload','1500');
	add_option('wwm_terms_title',__('I read and accept terms.','wwm'));
	add_option('wwm_terms_content','');
	
	$defaultstyle=".wwm-star{color:#ff9900}
		#wwm-submit {width:110px;}
		.wwm_register_page{padding:5px;}
		#wwm-members-form{text-align:left;}
		.wwm_register_page form{padding:5px;}
		.wwm_register_page small {color:#888888;}
		.wwm_register_page textarea{width:400px;height:140px;}
		#wwm-email,#wwm-address,#wwm-address2,#wwm-url,#wwm-country{width:200px}
		.wwm-avatar-img {float:right;border:2px solid #ccc ;padding:3px;}
		#wwm_captcha_img{border:1px solid #ccc;padding:1px;margin:3px;margin-top:8px}
		.wwm-thanksmessage{border:1px solid #FFCC66;color:green;background:#ffffcc;padding:5px;margin:3px;}
		.wwm-errormessage, .limited {border:1px solid #FFCC66;background:#ffffcc;padding:5px;margin:3px;color:red;line-height:18px}
		.field p {margin:5px;}
		.field{margin-bottom:3px; padding:5px;padding:7px;}.wwm_buyitform{text-align:left}";
		
	add_option('wwm_custom_css',$defaultstyle);
	add_option('wwm_recap_public','');
	add_option('wwm_recap_private','');
	update_option('wwm_main_fields',$list);
	
	$path=ABSPATH.'/wp-content/avatar/';
	if (!is_dir($path))  {
		mkdir($path);
		//chmod($path,0000777);
	}
	update_option('wwm_version',WWM_VERSION);

}//end func
?>