<?php
/*
Plugin Name: CMS Members
Plugin URI: http://wpwave.com/plugins/cms-members/
Description: Perfect membership/order management solution for WordPress.
Version: 1.87
Author: Hassan Jahangiry
Author URI: http://wpwave.com/


	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
	the Free Software Foundation.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
*/

if ('cms-members.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

define('WWM_FIELDS_TABLE','wwm_fields');
define('WWM_PLANS_TABLE','wwm_plans');
define('WWM_ORDERS_TABLE','wwm_orders');
define('WWM_VERSION','1.87'); //Number Only
define('MAX_DISCOUNT_NUM','10');
define('MAX_AWEBERPLAN_NUM','5');

define('WWM_URL', WP_PLUGIN_URL .'/'. dirname(plugin_basename(__FILE__)));

if ( (!get_option('wwm_main_fields')) || (WWM_VERSION > get_option('wwm_version')) ) {include('wwm-install.php'); ww_members_install();}

include('content-functions.php');
include('wwm-register.php');

function wwm_deposit_page() {
	if (is_user_logged_in() || (isset($_GET['action']))) 
		include('wwm-deposit.php');	
	else
		return "You are not allowed here!";
}
add_shortcode('cms_members_deposit', 'wwm_deposit_page');

function wwm_profile_page() {
	if (is_user_logged_in()) 
		include('wwm-profile.php');	
	else
		return "You are not allowed here!";
}
add_shortcode('cms_members_profile', 'wwm_profile_page');

function wwm_postbox(){
	global $wpdb;
	$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1' AND plantype='membership'");
	
	if( isset( $_REQUEST[ 'post' ] ) ) 
		$post_viewers=get_post_meta($_REQUEST[ 'post' ],'_wwm_post_viewers',true);
	 
	// print_r($post_viewers);
	if ($post_viewers['0']) 
		$post_viewers['who']=$post_viewers['0'];
	elseif (!is_array($post_viewers))
		$post_viewers['who']=$post_viewers;
	
	if (($post_viewers['who']) && (is_numeric($post_viewers['who'])))
		$plan=$post_viewers['who'];	
			
	echo '<input type="hidden" name="wwm_noncename" id="wwm_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';?>
    <div class="wwm_postbox" style="padding:5px;">
	<p><label><input name="wwm_post_viewers[who]" type="radio" id='wwm_radio_postbox' value="" <?php if (!$post_viewers['who']) echo "checked='checked'";?> />Everyone</label></p>
	<p><label><input name="wwm_post_viewers[who]" type="radio" id='wwm_radio_postbox' value="members" <?php if ('members'==$post_viewers['who']) echo "checked='checked'";?> />Memebers Only</label></p>
	<p><label><input name="wwm_post_viewers[who]" type="radio" id='wwm_radio_postbox' value="paidmembers" <?php if ('paidmembers'==$post_viewers['who']) echo "checked='checked'";?> />Paid Members Only</label></p>
	<p><label><input name="wwm_post_viewers[who]" type="radio" id='wwm_radio_postbox' value="plan" <?php if ($plan) echo "checked='checked'";?> />Plan:</label> 
    <select type="text" name="plan" id="wwm-plan" style="width:300px;" value="" />
    <?php
			$list='';
				foreach($planlist as $theplan)	{
					if (($plan==$theplan->id) ){
						$list.= "<option value=\"$theplan->id\" selected=\"selected\"> [".$theplan->id.'] '.$theplan->title;	
						if ($theplan->description) $list.=' - '.$theplan->description." </option>\n";
					}else{
						$list.="<option value=\"$theplan->id\"> [".$theplan->id.'] '.$theplan->title;	
						if ($theplan->description) $list.=' - '.$theplan->description." </option>\n";
					}
				}
			echo $list.'</select>'; ?></p>
            
            <p><label>Price <input name="wwm_post_viewers[price]" type="text" style="width:60px;" id='wwm_text_postbox' value="<?php  echo $post_viewers['price']; ?>" /> </label></p>
            
     <!--<p><label>They can see the post after <input name="wwm_post_viewers[time]" type="text" style="width:60px" id='wwm_number_postbox' value="<?php echo $post_viewers['time']; ?>" /> days of registartion.</label></p>
    
   <p><label><input name="wwm_post_viewers[title]" type="checkbox" id='wwm_radio_postbox' value="1" <?php if($post_viewers['wwm_post_viewers[title]']) echo 'checked="checked"'; ?> /> Protect Post Title</label></p>
     <p><label><input name="wwm_post_viewers[no_msg]" type="checkbox" id='wwm_radio_postbox' value="1" <?php if($post_viewers['wwm_post_viewers[no_msg]']) echo 'checked="checked"'; ?> /> Hide Warning Message </label></p>
    
      <p><label><input name="wwm_post_viewers[links]" type="checkbox" id='wwm_radio_postbox' value="1" <?php if($post_viewers['wwm_post_viewers[links]']) echo 'checked="checked"'; ?> /> Protect Content Links </label></p>
      
            <p><label><input name="wwm_post_viewers[exclude]" type="checkbox" id='wwm_radio_postbox' value="1" <?php if($post_viewers['wwm_post_viewers[exclude]']) echo 'checked="checked"'; ?> /> Exclude Post/Page from non-members </label></p>-->
      
            <p>
	Also...</p><p> You can insert a part of your content between <code>[onlymembers] [/onlymembers]</code>, <code>[onlypaid] [/onlypaid]</code>, <code>[onlyplans=X,Y] [/onlyplans]</code> and <code>[nonmembers] [/nonmembers]</code> tags where X and Y are plan ID. e.g. [onlyplans=2] Somthing for premium members [/onlyplans] or  [nonmembers]Please login to see full text![/nonmembers] </p>
    </div>
    
	<?php
}

function wwm_add_custom_box() {
  if( function_exists( 'add_meta_box' )) {
    	add_meta_box( 'epagepostcustomwwm',  'Who can see it? - CMS Members', 'wwm_postbox', 'post', 'normal','high' );
   		add_meta_box( 'epagepostcustomwwm','Who can see it? - CMS Members', 'wwm_postbox', 'page', 'normal','high' );
  } 
}
add_action('admin_menu', 'wwm_add_custom_box');

function wwm_save_post($post_id){
	if ( !wp_verify_nonce( $_POST['wwm_noncename'], plugin_basename(__FILE__) )) 
		return $post_id;
	  
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ))
		  return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ))
		  return $post_id;
	}
  
	if( !isset( $id ) )
		$id = $post_id;
		
	if (isset($_POST['wwm_post_viewers']['who']) )	{
		if ('plan'==$_POST['wwm_post_viewers']['who'])
			$update_wwm_post_viewers['who']=$_POST['plan']['who'];
		else
			$update_wwm_post_viewers['who']= $_POST['wwm_post_viewers']['who'];
	}
	
	
	$_POST['wwm_post_viewers']['who']=$update_wwm_post_viewers['who'];
	
	
	update_post_meta($id, '_wwm_post_viewers', $_POST['wwm_post_viewers']);	
	
	return $post_id;
}
add_action('save_post', 'wwm_save_post');

function get_deposit_content($content) {
	global  $wpdb,$user_level,$current_user, $user_ID, $post;
	$post_viewers=get_post_meta($post->ID, '_wwm_post_viewers', true);
		
	if (is_array($post_viewers)) 
		$post_price=$post_viewers['price'];
			
	if ((is_user_logged_in() || get_option('wwm_show_buynow')) && strpos($content,'limited') && $post_price) {
		$content.="<p><strong>".__('Price','wwm').":</strong> ".$post_price." ".get_option('wwm_paypal_currency_code')."</p><p><form ";
		$wwm_pages=get_option('wwm_pages');
		
		if (!is_user_logged_in())
			$content.=" action='".get_permalink($wwm_pages['register'])."' ";
			
		$content.="class='wwm_buyitform'  method='post' ><input  id='buyit_btn' type='submit' value='".__('Buy Now','wwm')."'";
		
		if (is_user_logged_in()){
			 $content.= "onclick=\"if ( confirm('You are about to buy \'".$post->post_title."\' using your deposit funds \\n \'Cancel\' to stop, \'OK\' to confirmation.') ) { return true;}return false;\"";
		 }
		
		 $content.="><input type='hidden' name='buy_it' value='".$post->ID."' /></form></p>";
		
	}
	return $content;
}
add_filter('the_content', 'get_deposit_content', 100);

//Thanks for Page exclude plugin of Simon Wheatley: http://simonwheatley.co.uk/wordpress/ 
function ep_exclude_pages2($pages){
	if (is_user_logged_in()) 
		return $pages;
	
	$bail_out = ( ( defined( 'WP_ADMIN' ) && WP_ADMIN == true ) || ( strpos( $_SERVER[ 'PHP_SELF' ], 'wp-admin' ) !== false ) );
	$bail_out = apply_filters( 'ep_admin_bail_out', $bail_out );
	if ( $bail_out ) return $pages;
	
	$wwm_pages=get_option('wwm_pages');
	$excluded_ids = array($wwm_pages['profile'], $wwm_pages['deposit']);
	$length = count($pages);

	for ( $i=0; $i<$length; $i++ ) {
		$page = & $pages[$i];
		if ( ep_ancestor_excluded2( $page, $excluded_ids, $pages ) ) {
			$excluded_ids[] = $page->ID;
		}
	}

	$delete_ids = array_unique( $excluded_ids );
	for ( $i=0; $i<$length; $i++ ) {
		$page = & $pages[$i];
		if ( in_array( $page->ID, $delete_ids ) ) {
			unset( $pages[$i] );
		}
	}

	if ( ! is_array( $pages ) ) $pages = (array) $pages;
	$pages = array_values( $pages );

	return $pages;
}

function ep_ancestor_excluded2( & $page, & $excluded_ids, & $pages ){
	$parent = & ep_get_page2( $page->post_parent, $pages );
	// Is it excluded?
	if ( in_array( $parent->ID, $excluded_ids ) ) {
		return $parent->ID;
	}
	// Is it the homepage?
	if ( $parent->ID == 0 ) return false;
	// Otherwise we have another ancestor to check
	return ep_ancestor_excluded2( $parent, $excluded_ids, $pages );
}

// Return the portion of the $pages array which refers to the ID passed as $page_id
function ep_get_page2( $page_id, & $pages ){
	$length = count($pages);
	for ( $i=0; $i<$length; $i++ ) {
		$page = & $pages[$i];
		if ( $page->ID == $page_id ) return $page;
	}
	return false;
}
//Exlude deposit and profile page
add_filter('get_pages','ep_exclude_pages2');


function wwm_can_user_login($user) {

	$userdata=get_userdatabylogin($user);
	$id=$userdata->ID;

	$status=get_usermeta($userdata->ID,'status');
	if ($status && 'expired'!= $status )  {
		wp_logout();
		if ($status=='incomplete')
		wp_die(__('Your registration is incomplete.<br>Check your mail for activation link.','wwm'));
		else
		wp_die(sprintf(__('Your account status: %s','wwm'),$status));
	}
	
	$now=date('Y-m-d H:i:s');
	$expire=get_usermeta($id,'expire');
	if( ($expire) && ($now>$expire) ){
		update_usermeta($id,'status','expired');
		$wwm_pages=get_option('wwm_pages');
		wp_die(__('Your account was expired. Please renew it.','wwm') . '<br/><a href="'.
		add_query_arg(array('action' => 'renew_upgrade'), get_permalink($wwm_pages['register']) ).
		'"><input type="button" name="renew_it" value="'.__('Renew','wwm').'"></a> <a href="'.add_query_arg(array('action' => 'deposit'), get_permalink($wwm_pages['deposit']) ).'"><input type="button" name="deposit_it" value="'.__('Deposit','wwm').'"></a> <a href="'.wp_logout_url().'"><input type="button" name="logout_it" value="'.__('Log out','wwm').'"></a>');
	}
	update_usermeta($id,'last_ip', $_SERVER['REMOTE_ADDR']);

}
function wwm_block_user() {
global $user_ID;
	if  ((!is_page()) || (!isset($_GET['action'])) ) {
		$now=date('Y-m-d H:i:s');
		$expire=get_usermeta($user_ID,'expire');
		$wwm_pages=get_option('wwm_pages');
		if( ($expire) && ($now>$expire) ){
			update_usermeta($user_ID,'status','expired');
			wp_die(__('Your account was expired. Please renew it.','wwm') . '<br/><a href="'.
			add_query_arg(array('action' => 'renew_upgrade'), get_permalink($wwm_pages['register']) ).
			'"><input type="button" name="renew_it" value="'.__('Renew','wwm').'"></a> <a href="'.add_query_arg(array('action' => 'deposit'), get_permalink($wwm_pages['deposit']) ).'"><input type="button" name="deposit_it" value="'.__('Deposit','wwm').'"></a> <a href="'.wp_logout_url().'"><input type="button" name="logout_it" value="'.__('Log out','wwm').'"></a>');
			exit;
		}
	}
}
add_action('wp','wwm_block_user');
add_action('admin_init','wwm_block_user');


function wwm_aff_code($id) {
	
	$orderinfo=get_order_info($id);
	$plan=get_plan_info($orderinfo->planid);
	
	$planprice=number_format($plan->price, 2, '.', '');
	$tags=array('{order_id}','{price}','{user_ip}');
	$replace=array( $orderinfo->id, $planprice, $orderinfo->ip );
	$code=str_replace($tags,$replace,get_option('wwm_aff_code'));
			
	echo $code;			
}
add_action('wwm_paid_order_registered','wwm_aff_code');

function add_to_aweber_list_order($id) {
	$aweber=get_option('wwm_aweber');
		
	if (!$awb['0']['awb']) //if disable!
		return false;
		
	$info=get_order_info($id);
	$plan=$info->planid;
	$email=$info->user_email;
	$name=$info->first_name.' '.$info->last_name;
	
	if (!$name)
		$name=$info->nicename;
	if (!$name)
		$name=$info->user_login;
		
	if (('-1'==$aweber['0']['plan'])&& ($aweber['0']['form']) && ($aweber['0']['list']) ) { //all
		$list_name=$aweber['0']['list'];
		$form_id=$aweber['0']['form'];
	}elseif ($aweber){
		foreach($aweber as $awb) {
			if ($awb['plan']==$plan){
				$list_name=$awb['list'];
				$form_id=$awb['form'];
				break;
			}
		}
	}

	$params = array(
	  "meta_web_form_id" => $form_id,
	  "meta_split_id" => "",
	  "unit" => $list_name,
	  "redirect" => "http://www.aweber.com/form/thankyou_vo.html",
	  "meta_redirect_onlist" => "",
	  "meta_adtracking" => "",
	  "meta_message" => "1",
	  "meta_required" => "name,from",
	  "meta_forward_vars" => "0",
	  "name" => $name,
	  "from" => $email,
	  "submit" => "Submit"
	);
	
	if (($list_name) && ($form_id))
		$r = _post_wwm('http://www.aweber.com/scripts/addlead.pl', $params);
}
add_action('wwm_paid_order_registered','add_to_aweber_list_order');
add_action('wwm_free_order_registered','add_to_aweber_list_order');

function add_to_aweber_list_free_member($id) {
	$aweber=get_option('wwm_aweber');
		
	if (!$awb['0']['awb']) //if disable!
		return false;
	
	if ( !$user = get_user_by('id', $id ) )
		return false;
			
	
	$plan=get_usermeta($id,'plan_id');
	$email=$user->user_email;
	$name=get_usermeta($id,'first_name').' '.get_usermeta($id,'last_name');
	
	if (!$name)
		$name=$user->nicename;
	if (!$name)
		$name=$user->user_login;
		
	if (('-1'==$aweber['0']['plan'])&& ($aweber['0']['form']) && ($aweber['0']['list']) ) { //all
		$list_name=$aweber['0']['list'];
		$form_id=$aweber['0']['form'];
	}else{
		foreach($aweber as $awb) {
			if ($awb['plan']==$plan){
				$list_name=$awb['list'];
				$form_id=$awb['form'];
				break;
			}
		}
	}

	$params = array(
	  "meta_web_form_id" => $form_id,
	  "meta_split_id" => "",
	  "unit" => $list_name,
	  "redirect" => "http://www.aweber.com/form/thankyou_vo.html",
	  "meta_redirect_onlist" => "",
	  "meta_adtracking" => "",
	  "meta_message" => "1",
	  "meta_required" => "name,from",
	  "meta_forward_vars" => "0",
	  "name" => $name,
	  "from" => $email,
	  "submit" => "Submit"
	);
	
	if (($list_name) && ($form_id))
		$r = _post_wwm('http://www.aweber.com/scripts/addlead.pl', $params);
}
add_action('wwm_free_member_registered','add_to_aweber_list_free_member');

function get_plan_info($id) {
global $wpdb;

	if (!is_numeric($id))
	  return false;
	return $wpdb->get_row("SELECT * FROM ".WWM_PLANS_TABLE." WHERE id={$id}");
}

function get_order_info($id) {
global $wpdb;

	if (!is_numeric($id))
	  return false;
	return $wpdb->get_row("SELECT * FROM ".WWM_ORDERS_TABLE." WHERE id={$id}");
}

function get_field_info($id) {
global $wpdb;

	if (!is_numeric($id))
	  return false;
	return $wpdb->get_row("SELECT * FROM ".WWM_FIELDS_TABLE." WHERE id={$id}");
}

function wwm_get_fields_last_id($pagetype='0') {
global $wpdb;

if ($pagetype=='0')
	return $wpdb->get_var("SELECT id FROM ".WWM_FIELDS_TABLE." WHERE display=1 ORDER BY id DESC LIMIT 1;");
return $wpdb->get_var($wpdb->prepare("SELECT id FROM ".WWM_FIELDS_TABLE." WHERE pagetype=%s AND display=1 ORDER BY id DESC LIMIT 1;",$pagetype));
}

if (!function_exists(wwm_image_resize)){
function wwm_image_resize( $file, $max_w, $max_h, $crop=false, $suffix=null, $dest_path=null, $jpeg_quality=90) {
	$destfilename[error]='';
	$image = wwm_load_image( $file );
	if ( !is_resource( $image ) )
		return $destfilename[error]='error_loading_image';

	list($orig_w, $orig_h, $orig_type) = getimagesize( $file );
	$dims = image_resize_dimensions($orig_w, $orig_h, $max_w, $max_h, $crop);
	if (!$dims)
		return $dims;
	list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;

	$newimage = imagecreatetruecolor( $dst_w, $dst_h);

	// preserve PNG transparency
	if ( IMAGETYPE_PNG == $orig_type && function_exists( 'imagealphablending' ) && function_exists( 'imagesavealpha' ) ) {
		imagealphablending( $newimage, false);
		imagesavealpha( $newimage, true);
	}

	imagecopyresampled( $newimage, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

	// we don't need the original in memory anymore
	imagedestroy( $image );

	// $suffix will be appended to the destination filename, just before the extension
	if ( !$suffix )
		$suffix = "{$dst_w}x{$dst_h}";

	$info = pathinfo($file);
	$dir = $info['dirname'];
	$ext = $info['extension'];
	$name = basename($file, ".{$ext}");
	if ( !is_null($dest_path) and $_dest_path = realpath($dest_path) )
		$dir = $_dest_path;
	$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

	if ( $orig_type == IMAGETYPE_GIF ) {
		if (!imagegif( $newimage, $destfilename ) )
			return $destfilename[error]='invalid resize path';
	}
	elseif ( $orig_type == IMAGETYPE_PNG ) {
		if (!imagepng( $newimage, $destfilename ) )
			return $destfilename[error]='invalid resize path';
	}
	else {
		// all other formats are converted to jpg
		$destfilename = "{$dir}/{$name}-{$suffix}.jpg";
		if (!imagejpeg( $newimage, $destfilename, apply_filters( 'jpeg_quality', $jpeg_quality ) ) )
			return  $destfilename[error]='invalid resize path';
	}

	imagedestroy( $newimage );

	// Set correct file permissions
	$stat = stat( dirname( $destfilename ));
	$perms = $stat['mode'] & 0000666; //same permissions as parent folder, strip off the executable bits
	@ chmod( $destfilename, $perms );

	return $destfilename;
}
}

if (!function_exists(wwm_load_image)){
function wwm_load_image( $file ) {
	

	if ( ! file_exists( $file ) )
		return sprintf(__("File '%s' doesn't exist?"), $file);

	if ( ! function_exists('imagecreatefromstring') )
		return __('The GD image library is not installed.');

	// Set artificially high because GD uses uncompressed images in memory
	@ini_set('memory_limit', '256M');
	$image = imagecreatefromstring( file_get_contents( $file ) );

	if ( !is_resource( $image ) )
		return sprintf(__("File '%s' is not an image."), $file);

	return $image;
}
}



//max size: KB
if (!function_exists(wwm_handle_upload)){
function wwm_handle_upload( &$file, $overrides = false, $maxsize=1500,$allowedexts=array(jpg,jpeg,jpe),$time = null ) {
	// The default error handler.
	if (! function_exists( 'wp_handle_upload_error' ) ) {
		function wp_handle_upload_error( &$file, $message ) {
			return array( 'error'=>$message );
		}
	}

	// You may define your own function and pass the name in $overrides['upload_error_handler']
	$upload_error_handler = 'wp_handle_upload_error';

	// You may define your own function and pass the name in $overrides['unique_filename_callback']
	$unique_filename_callback = null;

	// $_POST['action'] must be set and its value must equal $overrides['action'] or this:
	$action = 'wp_handle_upload';

	// Courtesy of php.net, the strings that describe the error indicated in $_FILES[{form field}]['error'].
	$upload_error_strings = array( false,
		__( "The uploaded file exceeds the <code>upload_max_filesize</code> directive in <code>php.ini</code>." ),
		__( "The uploaded file exceeds the <em>MAX_FILE_SIZE</em> directive that was specified in the HTML form." ),
		__( "The uploaded file was only partially uploaded." ),
		__( "No file was uploaded." ),
		'',
		__( "Missing a temporary folder." ),
		__( "Failed to write file to disk." ));

	// All tests are on by default. Most can be turned off by $override[{test_name}] = false;
	$test_form = true;
	$test_size = true;

	// If you override this, you must provide $ext and $type!!!!
	$test_type = true;
	$mimes = false;

	// Install user overrides. Did we mention that this voids your warranty?
	if ( is_array( $overrides ) )
		extract( $overrides, EXTR_OVERWRITE );

	// A correct form post will pass this test.
	if ( $test_form && (!isset( $_POST['action'] ) || ($_POST['action'] != $action ) ) )
		return $upload_error_handler( $file, __( 'Invalid form submission.' ));

	// A successful upload will pass this test. It makes no sense to override this one.
	if ( $file['error'] > 0 )
		return $upload_error_handler( $file, $upload_error_strings[$file['error']] );


	// A non-empty file will pass this test.
	if ( $test_size && !($file['size'] > 0 ) )
		return $upload_error_handler( $file, __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini.' ));
			

	// A properly uploaded file will pass this test. There should be no reason to override this one.
	if (! @ is_uploaded_file( $file['tmp_name'] ) )
		return $upload_error_handler( $file, __( 'Specified file failed upload test.' ));


	if ( ($file['size'] > $maxsize * 1024 ) )
		return $upload_error_handler( $file, sprintf(__('Max allowed file size: %s KB','wwm'),$maxsize) );
		
		
	// A correct MIME type will pass this test. Override $mimes or use the upload_mimes filter.
	if ( $test_type ) {
		$wp_filetype = wp_check_filetype( $file['name'], $mimes );

		extract( $wp_filetype );
		
		if ( ( !$type || !$ext ) && !current_user_can( 'unfiltered_upload' ) )
			return $upload_error_handler( $file, __( 'File type does not meet security guidelines. Try another.' ));

		if ( !$ext )
			$ext = ltrim(strrchr($file['name'], '.'), '.');

		if ( !$type )
			$type = $file['type'];
	
	
		$allowed=false;
		foreach ($allowedexts as $allowedext) 
			if ($ext==$allowedext)  $allowed=true;
		
		if (!$allowed)
		return $upload_error_handler($file,sprintf(__('%s Invalid file type.','wwm'),$ext));
	}
		
	// A writable uploads dir will pass this test. Again, there's no point overriding this one.
	if ( ! ( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] ) )
		return $upload_error_handler( $file, $uploads['error'] );

	$filename = wp_unique_filename( $uploads['path'], $file['name'], $unique_filename_callback );

	// Move the file to the uploads dir
	$new_file = $uploads['path'] . "/$filename";
	if ( false === @ move_uploaded_file( $file['tmp_name'], $new_file ) ) {
		return $upload_error_handler( $file, sprintf( __('The uploaded file could not be moved to %s.' ), $uploads['path'] ) );
	}

	// Set correct file permissions
	$stat = stat( dirname( $new_file ));
	$perms = $stat['mode'] & 0000666;
	@ chmod( $new_file, $perms );

	// Compute the URL
	$url = $uploads['url'] . "/$filename";

	$return = apply_filters( 'wp_handle_upload', array( 'file' => $new_file, 'url' => $url, 'type' => $type ) );

	return $return;
}
}
		
function wwm_validate_email( $email, $check_domain = true) {
    if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.
        '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
        '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email))
    {
        if ($check_domain && function_exists('checkdnsrr')) {
            list (, $domain)  = explode('@', $email);

            if (checkdnsrr($domain.'.', 'MX') || checkdnsrr($domain.'.', 'A')) {
                return true;
            }
            return false;
        }
        return true;
    }
    return false;
}
	
function wwm_refresh_user_details($id) {
	$id = (int) $id;
	
	if ( !$user = get_userdata( $id ) )
		return false;

	wp_cache_delete($id, 'users');
	wp_cache_delete($user->user_login, 'userlogins');
	return $id;
}

function wwm_reg_page_style() {
echo "\n
 <!-- WordPress Wave CMS Members *** http://wpwave.com -->
 \n";
?>
<style type="text/css" media="screen">
<?php echo get_option('wwm_custom_css'); ?>
</style>
<?php
echo "\n <!-- End CMS Members --> \n
 ";
}

if(is_admin()) {	
			
		function wwm_admin_style() { ?>
		<script type="text/javascript" src="<?php echo WWM_URL .'/include/admin_js.js'; ?>"></script> 
		<?php
		}
		
		function wwm_members_page() {
			include('wwm-members.php');
		}
		
		
		function wwm_admin_register_page() {
		
		?>
		<div class="wrap">
			<h2>Add a new member/Order</h2>
			<p>Register a new user in your site. It's FREE for you!! No need for verification mail but welcome mail [As a free member] will be sent for the user. </p>
			<?php wwm_register_page();?>
		</div>
        
		<?php
		}
		
		function wwm_orders_page(){
			include('wwm-orders.php');
		}
		
		function wwm_options_page(){
			include('wwm-options.php');
		}
		
		function wwm_plans_page(){
			include('wwm-plans.php');
		}
		
		function wwm_mass_mailer_page(){
			include('wwm-mass-mailer.php');
		}
		
		function wwm_custom_fields_page(){
			include('wwm-fields.php');
		}
		
		function add_wwm_pages() {
		 global $wp_version;
		 
			if ($wp_version<2.7) 
				add_menu_page('CMS Members', 'CMS Members', 10, basename('wwm-members.php') ,'wwm_members_page');
			else
				add_menu_page('CMS Members', 'CMS Members', 10, basename('wwm-members.php') ,'wwm_members_page',WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/menu-members.png');
		
			add_submenu_page(basename('wwm-members.php'), 'Add User', 'Add User', 10,basename('wwm-add.php') ,'wwm_admin_register_page');
			add_submenu_page(basename('wwm-members.php'), 'Plans / Products', 'Plans', 10,basename('wwm-plans.php'),'wwm_plans_page');
			add_submenu_page(basename('wwm-members.php'), 'Orders / Trans', 'Orders / Trans', 10,basename('wwm-orders.php') ,'wwm_orders_page');
			
			add_submenu_page(basename('wwm-members.php'), 'Custom fields', 'Custom Fields', 10,basename('wwm-fields.php'),'wwm_custom_fields_page');
			
			add_submenu_page(basename('wwm-members.php'), 'Mass Mailer', 'Mass Mailer', 10,basename('wwm-mass-mailer.php'),'wwm_mass_mailer_page');
			
			add_submenu_page(basename('wwm-members.php'), 'Options', 'Options', 10,basename('wwm-options.php'),'wwm_options_page');
		}

		add_action('admin_menu', 'add_wwm_pages');
		add_action('admin_head','wwm_admin_style');
		add_action('admin_head','wwm_reg_page_style');
} //end of is admin
add_action('wp_head','wwm_reg_page_style');
add_action('wp_login','wwm_can_user_login');
add_shortcode('cms_members_form', 'wwm_register_page');
add_filter('the_content', 'get_premium_content', 10);
add_filter('the_excerpt', 'get_premium_content', 10);


	if ( !defined('WP_PLUGIN_DIR') )  
			load_plugin_textdomain('wwm','wp-content/plugins/cms-members/lang');
 	else 
			load_plugin_textdomain('wwm', false, dirname(plugin_basename(__FILE__)) . '/lang');


function wwm_mail_from($from){ return get_option('blogname');}
function wwm_mail_make_html($type) { return 'text/html';}

function wwm_mail_actions($type='plain') {

	if ($type=='html') 
		add_action('wp_mail_content_type','wwm_mail_make_html');
		
	add_action('wp_mail_from_name','wwm_mail_from');
	
}


/************************************/
/* Aweber Integration */
/* Special thanks to Guru Consulting Services, Inc. (http://www.gurucs.com) for their original platform.     */
/************************************/

function _post_wwm($url, $fields) {
  return _request_wwm(true, $url, $fields);
}

function _request_wwm($post, $url, $fields) {
  $postfields = array();
  if(count($fields)) {
	foreach($fields as $i => $f) {
	  $postfields[] = urlencode($i) . '=' . urlencode($f);
    }
  }
  $fields = implode('&', $postfields);
  return _http_wwm($post ? 'POST' : 'GET', $url, $fields);
  $ch = curl_init($url);
  $ck = array();
  $headers = array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11", "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5", "Accept-Language: en-us,en;q=0.5", "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7", "Keep-Alive: 300", "Connection: keep-alive");
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  if($post) {
    curl_setopt($ch, CURLOPT_POST, true);
	$postfields = array();
	if(count($fields)) {
	  foreach($fields as $i => $f) {
		$postfields[] = urlencode($i) . '=' . urlencode($f);
	  }
	}
	$fields = implode('&', $postfields);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    $headers[] = "Content-Length: " . strlen($fields);
  }
  curl_setopt($ch, CURLOPT_HEADER, $this->headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}

function _http_wwm($method, $url, $data = null) {
  preg_match('~http://([^/]+)(/.*)~', $url, $subs);
  $host = $subs[1];
  $uri = $subs[2];
  $header .= "$method $uri HTTP/1.1\r\n";
  $header .= "Host: $host\r\n";
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
  $fp = fsockopen ($host, 80, $errno, $errstr, 30);
  if($fp) {
    fputs($fp, $header . $data);
	$result = '';
	while(!feof($fp)) $result .= fgets($fp, 4096);
  }
  fclose($fp);
  return $result;
}

function country_list() {
      $list = array('AF' => 'Afghanistan',
                    'AL' => 'Albania',
                    'DZ' => 'Algeria',
                    'AD' => 'Andorra',
                    'AO' => 'Angola',
                    'AI' => 'Anguilla',
                    'AG' => 'Antigua and Barbuda',
                    'AR' => 'Argentina',
                    'AM' => 'Armenia',
                    'AW' => 'Aruba',
                    'AU' => 'Australia',
                    'AT' => 'Austria',
                    'AZ' => 'Azerbaijan',
                    'BS' => 'Bahamas',
                    'BH' => 'Bahrain',
                    'BD' => 'Bangladesh',
                    'BB' => 'Barbados',
                    'BY' => 'Belarus',
                    'BE' => 'Belgium',
                    'BZ' => 'Belize',
                    'BJ' => 'Benin',
                    'BM' => 'Bermuda',
                    'BT' => 'Bhutan',
                    'BO' => 'Bolivia',
                    'BA' => 'Bosnia-Herzegovina',
                    'BW' => 'Botswana',
                    'BR' => 'Brazil',
                    'VG' => 'British Virgin Islands',
                    'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgaria',
                    'BF' => 'Burkina Faso',
                    'MM' => 'Burma',
                    'BI' => 'Burundi',
                    'KH' => 'Cambodia',
                    'CM' => 'Cameroon',
                    'CA' => 'Canada',
                    'CV' => 'Cape Verde',
                    'KY' => 'Cayman Islands',
                    'CF' => 'Central African Republic',
                    'TD' => 'Chad',
                    'CL' => 'Chile',
                    'CN' => 'China',
                    'CX' => 'Christmas Island (Australia)',
                    'CC' => 'Cocos Island (Australia)',
                    'CO' => 'Colombia',
                    'KM' => 'Comoros',
                    'CG' => 'Congo (Brazzaville),Republic of the',
                    'ZR' => 'Congo, Democratic Republic of the',
                    'CK' => 'Cook Islands (New Zealand)',
                    'CR' => 'Costa Rica',
                    'CI' => 'Cote d\'Ivoire (Ivory Coast)',
                    'HR' => 'Croatia',
                    'CU' => 'Cuba',
                    'CY' => 'Cyprus',
                    'CZ' => 'Czech Republic',
                    'DK' => 'Denmark',
                    'DJ' => 'Djibouti',
                    'DM' => 'Dominica',
                    'DO' => 'Dominican Republic',
                    'TP' => 'East Timor (Indonesia)',
                    'EC' => 'Ecuador',
                    'EG' => 'Egypt',
                    'SV' => 'El Salvador',
                    'GQ' => 'Equatorial Guinea',
                    'ER' => 'Eritrea',
                    'EE' => 'Estonia',
                    'ET' => 'Ethiopia',
                    'FK' => 'Falkland Islands',
                    'FO' => 'Faroe Islands',
                    'FJ' => 'Fiji',
                    'FI' => 'Finland',
                    'FR' => 'France',
                    'GF' => 'French Guiana',
                    'PF' => 'French Polynesia',
                    'GA' => 'Gabon',
                    'GM' => 'Gambia',
                    'GE' => 'Georgia, Republic of',
                    'DE' => 'Germany',
                    'GH' => 'Ghana',
                    'GI' => 'Gibraltar',
                    'GB' => 'Great Britain and Northern Ireland',
                    'GR' => 'Greece',
                    'GL' => 'Greenland',
                    'GD' => 'Grenada',
                    'GP' => 'Guadeloupe',
                    'GT' => 'Guatemala',
                    'GN' => 'Guinea',
                    'GW' => 'Guinea-Bissau',
                    'GY' => 'Guyana',
                    'HT' => 'Haiti',
                    'HN' => 'Honduras',
                    'HK' => 'Hong Kong',
                    'HU' => 'Hungary',
                    'IS' => 'Iceland',
                    'IN' => 'India',
                    'ID' => 'Indonesia',
                    'IR' => 'Iran (Islamic Republic of)',
                    'IQ' => 'Iraq',
                    'IE' => 'Ireland',
                    'IT' => 'Italy',
                    'JM' => 'Jamaica',
                    'JP' => 'Japan',
                    'JO' => 'Jordan',
                    'KZ' => 'Kazakhstan',
                    'KE' => 'Kenya',
                    'KI' => 'Kiribati',
                    'KW' => 'Kuwait',
                    'KG' => 'Kyrgyzstan',
                    'LA' => 'Laos',
                    'LV' => 'Latvia',
                    'LB' => 'Lebanon',
                    'LS' => 'Lesotho',
                    'LR' => 'Liberia',
                    'LY' => 'Libya',
                    'LI' => 'Liechtenstein',
                    'LT' => 'Lithuania',
                    'LU' => 'Luxembourg',
                    'MO' => 'Macao',
                    'MK' => 'Macedonia (Republic of)',
                    'MG' => 'Madagascar',
                    'MW' => 'Malawi',
                    'MY' => 'Malaysia',
                    'MV' => 'Maldives',
                    'ML' => 'Mali',
                    'MT' => 'Malta',
                    'MQ' => 'Martinique',
                    'MR' => 'Mauritania',
                    'MU' => 'Mauritius',
                    'YT' => 'Mayotte (France)',
                    'MX' => 'Mexico',
                    'MD' => 'Moldova',
                    'MC' => 'Monaco (France)',
                    'MN' => 'Mongolia',
                    'MS' => 'Montserrat',
                    'MA' => 'Morocco',
                    'MZ' => 'Mozambique',
                    'NA' => 'Namibia',
                    'NR' => 'Nauru',
                    'NP' => 'Nepal',
                    'NL' => 'Netherlands',
                    'AN' => 'Netherlands Antilles',
                    'NC' => 'New Caledonia',
                    'NZ' => 'New Zealand',
                    'NI' => 'Nicaragua',
                    'NE' => 'Niger',
                    'NG' => 'Nigeria',
                    'KP' => 'North Korea ',
                    'NO' => 'Norway',
                    'OM' => 'Oman',
                    'PK' => 'Pakistan',
					'PS' => 'Palestine',
                    'PA' => 'Panama',
                    'PG' => 'Papua New Guinea',
                    'PY' => 'Paraguay',
                    'PE' => 'Peru',
                    'PH' => 'Philippines',
                    'PN' => 'Pitcairn Island',
                    'PL' => 'Poland',
                    'PT' => 'Portugal',
                    'QA' => 'Qatar',
                    'RE' => 'Reunion',
                    'RO' => 'Romania',
                    'RU' => 'Russia',
                    'RW' => 'Rwanda',
                    'SH' => 'Saint Helena',
                    'KN' => 'Saint Kitts (St. Christopher and Nevis)',
                    'LC' => 'Saint Lucia',
                    'PM' => 'Saint Pierre and Miquelon',
                    'VC' => 'Saint Vincent and the Grenadines',
                    'SM' => 'San Marino',
                    'ST' => 'Sao Tome and Principe',
                    'SA' => 'Saudi Arabia',
                    'SN' => 'Senegal',
                    'YU' => 'Serbia-Montenegro',
                    'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone',
                    'SG' => 'Singapore',
                    'SK' => 'Slovak Republic',
                    'SI' => 'Slovenia',
                    'SB' => 'Solomon Islands',
                    'SO' => 'Somalia',
                    'ZA' => 'South Africa',
                    'GS' => 'South Georgia (Falkland Islands)',
                    'KR' => 'South Korea ',
                    'ES' => 'Spain',
                    'LK' => 'Sri Lanka',
                    'SD' => 'Sudan',
                    'SR' => 'Suriname',
                    'SZ' => 'Swaziland',
                    'SE' => 'Sweden',
                    'CH' => 'Switzerland',
                    'SY' => 'Syrian Arab Republic',
                    'TW' => 'Taiwan',
                    'TJ' => 'Tajikistan',
                    'TZ' => 'Tanzania',
                    'TH' => 'Thailand',
                    'TG' => 'Togo',
                    'TK' => 'Tokelau (Union) Group (Western Samoa)',
                    'TO' => 'Tonga',
                    'TT' => 'Trinidad and Tobago',
                    'TN' => 'Tunisia',
                    'TR' => 'Turkey',
                    'TM' => 'Turkmenistan',
                    'TC' => 'Turks and Caicos Islands',
                    'TV' => 'Tuvalu',
                    'UG' => 'Uganda',
                    'UA' => 'Ukraine',
                    'AE' => 'United Arab Emirates',
                    'UY' => 'Uruguay',
                    'UZ' => 'Uzbekistan',
                    'VU' => 'Vanuatu',
                    'VA' => 'Vatican City',
                    'VE' => 'Venezuela',
                    'VN' => 'Vietnam',
                    'WF' => 'Wallis and Futuna Islands',
                    'WS' => 'Western Samoa',
                    'YE' => 'Yemen',
                    'ZM' => 'Zambia',
                    'ZW' => 'Zimbabwe');

      return $list;
}
?>