<?php
if ('wwm-members.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));
	
global $wpdb;	
$userstable=$wpdb->users;

$poststable=$wpdb->posts;

?>

<?php
if ( (isset($_GET['pagenum'])) && (is_numeric($_GET['pagenum'])) ) $start=$_GET['pagenum']*20;

	$author_count = '';
	if ( ($_GET['edit_user_id'])&&(is_numeric($_GET['edit_user_id'])) && (($_POST['submit'])) ) {
		
		
		if ( !wp_verify_nonce( $_POST['wwm_member_noncename'], plugin_basename(__FILE__) )) 
			die("Invalid nonce. Try agian.");
			
		$msg='';
			if ($_POST['pass']!==$_POST['pass2']) $msg='Please re-type password carefully!';elseif ( (!empty($_POST['pass']))&&(!empty($_POST['pass2'])) ) $user_pass=md5($_POST['pass']);
		
		$ID=$_GET['edit_user_id'];
		$user_login=$_POST['user_login'];
		$user_nicename=stripslashes($_POST['user_nicename']);
		$user_email=$_POST['user_email'];
		$user_url=$_POST['user_url'];
		$user_registered=$_POST['user_registered'];
		$display_name=stripslashes($_POST['display_name']);
		$user_activation_key=$_POST['user_activation_key'];
		
		$member_data=compact('ID','user_login','user_pass','user_nicename','user_email','user_url','user_registered','display_name','user_activation_key');
		
		wp_insert_user($member_data);
		
		$metanameslist = $wpdb->get_results($wpdb->prepare("SELECT meta_key FROM $wpdb->usermeta WHERE user_id = %s ", $_GET['edit_user_id']));
		foreach ($metanameslist as $themetaname) {
			if (!is_array(get_usermeta($_GET['edit_user_id'],$themetaname->meta_key)))
			update_usermeta($_GET['edit_user_id'],$themetaname->meta_key,$_POST[$themetaname->meta_key] );
		}
			
		$standardf=array('plan_id','expire','balance','avatar','first_name','last_name','description','status');
		foreach ($standardf as $sf) {
			if (!is_array(get_usermeta($_GET['edit_user_id'],$sf)))
			update_usermeta($_GET['edit_user_id'],$sf,$_POST[$sf] );
		}
		$msg='User successfully updated.';
		
		
		
		}elseif ( ($_GET['suspend_user_id'])&&(is_numeric($_GET['suspend_user_id'])) ) {
		update_usermeta($_GET['suspend_user_id'],'status','suspended');
		$msg='User successfully suspended.';
		
		}elseif( ($_GET['activate_user_id'])&&(is_numeric($_GET['activate_user_id'])) ) {
		
			if ((get_usermeta($_GET['activate_user_id'],'status')=='expired')) {
			$expire=get_usermeta($_GET['activate_user_id'],'expire');
			$planinfo=get_plan_info(get_usermeta($_GET['activate_user_id'],'plan_id'));
				if ($planinfo->duration)
				$newexpire=date("Y-m-d H:i:s" ,strtotime('+'.$planinfo->duration.' day'));
				else
				$newexpire=0;
			
			update_usermeta($_GET['activate_user_id'],'expire',$newexpire);
			}
		
		update_usermeta($_GET['activate_user_id'],'status','0');
		$msg='User successfully activated.';
		
		}elseif( ($_GET['delete_user_id'])&&(is_numeric($_GET['delete_user_id'])) ) {
		wp_delete_user($_GET['delete_user_id']);
		$msg='User with his/her posts successfully deleted.';
		
		}elseif( ($_GET['renew_user_id'])&&(is_numeric($_GET['renew_user_id'])) ) {
			$expire=get_usermeta($_GET['renew_user_id'],expire);
			if ($expire){
			
			$planinfo=get_plan_info(get_usermeta($_GET['renew_user_id'],'plan_id'));
			$status=get_usermeta($_GET['renew_user_id'],status);
			
			echo date("Y-m-d H:i:s" ,strtotime('+'.$planinfo->duration.' day'))-$expire;
			$today=date("Y-m-d H:i:s");
			$newexpire=date("Y-m-d H:i:s" ,strtotime('+'.$planinfo->duration.' day'));
			if ($planinfo) {
				if ($status=='expired'){
					update_usermeta($_GET['renew_user_id'],'expire',$newexpire);
					$msg='User successfully renewed.';
				}else{
					
				
					$newexpire=date("Y-m-d H:i:s" ,strtotime('+'.$planinfo->duration.' day',strtotime($expire)));
					
					update_usermeta($_GET['renew_user_id'],'expire',$newexpire);
					$msg='User successfully renewed.';
				}
			}
				//echo $expiredate = date("Y-m-d H:i:s",strtotime('+'.$planinfo->duration.'day'));
				//update_usermeta($_GET['renew_user_id'],'expire',$newexpire);
			}
		}
?>
		
		<div class="wrap">
        <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
        
        
 <?php if ( (isset($_GET['edit_user_id']))&&(is_numeric($_GET['edit_user_id'])) ) {
		
		
		if (isset($_GET['remove_avatar']))  {
			 delete_usermeta($_GET['edit_user_id'],'avatar'); ?>
			  <div id="message" class="updated fade"><p>Avatar deleted!</p></div>
		<?php } ?>
        
	  <h2>User Edit</h2> <p></p>
	   
	   <form method="POST">
	 
	   <input type="submit" class="button-primary" name="submit" value="Save changes" /> 
	   <?php  if (get_usermeta($_GET['edit_user_id'],'status')) { ?>
		 <a href="?page=<?php echo $_GET['page']; ?>&activate_user_id=<?php echo $_GET['edit_user_id'];?>" title="Allow this user to login"><input  type="button" class="button"  name="suspend" value="Activate Account" /></a>
		<?php }else{ ?>
        <a href="?page=<?php echo $_GET['page']; ?>&suspend_user_id=<?php echo $_GET['edit_user_id']; ?>">
         <input type="button" class="button" name="suspend" value="Suspend Account" /></a>
         <?php }?>
          <a onclick="if ( confirm('You are about to delete a user with all of his/her posts \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" title="Delete user with posts" href="?page=<?php echo $_GET['page']; ?>&delete_user_id=<?php echo $_GET['edit_user_id'];  ?>">
         <input type="button" class="button" name="delete" alt="Delete user with posts" value="Delete User" /></a>
         
         <a  href="?page=<?php echo $_GET['page']; ?>&renew_user_id=<?php echo $_GET['edit_user_id'];  ?>">
         <input type="button" class="button" name="renew"  value="Renew Account" /></a>
        
         <a  title="Cancel and go to manage page" href="?page=<?php echo $_GET['page']; ?>">Go Back</a>
	     <table class="form-table" style="width:600px">
	   <?php
	   $users_data=$wpdb->get_results($wpdb->prepare("SELECT user_login,user_nicename,user_email,user_url,user_registered,user_activation_key,display_name FROM $wpdb->users WHERE ID = %s ", $_GET['edit_user_id']));
	   
	   		foreach ($users_data as $user) {
			?>
	   			<tr class="form-field form-required" >
								<th scope="row">Username</th> 
								<td><input name="user_login" type="text" value="<?php echo $user->user_login; ?>" style="width:250px;background-color:#eee;color:#777" />
                        
                                <br />Username is not editable</td>
				</tr> 
                <tr class="form-field form-required" >
								<th scope="row">New Password</th> 
								<td><input name="pass" type="password" value="" style="width:250px;"  />
                                <br /><input name="pass2" type="password" value="" style="width:250px;"  />
                                <br />If you would like to change the password type a new one in above fields. Otherwise leave this blank.</td>
				</tr> 
                <tr class="form-field form-required" >
								<th scope="row">Nicename</th> 
								<td><input name="user_nicename" type="text" value="<?php echo $user->user_nicename; ?>" style="width:300px;"  />                                </td>
				</tr> 
                <tr class="form-field form-required" >
								<th scope="row">Email</th> 
								<td><input name="user_email" type="text" value="<?php echo $user->user_email; ?>" style="width:300px;" />                                </td>
				</tr>
                <?php
                $standardf=array('plan_id','expire','balance','avatar','first_name','last_name','description','status'); 
            	foreach ($standardf as $fld ) { ?>
                <tr class="form-field form-required" >
               
                            <th scope="row"><?php if ($fld=='plan_id') echo 'Plan'; else echo str_replace('_',' ',strtoupper(substr( $fld,0,1) ).substr( $fld,1,40) ); ?></th>
                            <td>
                            <?php 
							
							if ($fld=='plan_id') {
								$plan_id=get_usermeta($_GET['edit_user_id'],'plan_id');
								$planlist = $wpdb->get_results("SELECT id,title,price,description FROM ".WWM_PLANS_TABLE." WHERE display='1' AND plantype='membership'");
								if ($planlist) {
									echo '<select type="text" name="plan_id" id="wwm-plan" style="width:300px;" value="" onchange="alert(\'Do not forget to update expire date manually.\')" />';
									$list='';
									
									echo "<option value=\"\" selected=\"selected\""; if (!$plan_id) echo "selected=\"selected\"";
									echo " >none</option>";
									
									foreach($planlist as $theplan)	{
										if ($plan_id==$theplan->id) {
											$list.= "<option value=\"$theplan->id\" selected=\"selected\"> ".$theplan->title;	
											"</option>\n";
										}else{
											$list.="<option value=\"$theplan->id\"> ".$theplan->title;	
											$list.=" </option>\n";
										}
									}
									echo $list.'</select>';
								}else{
									echo 'No membership plan';
								}
										
								
							
							}elseif ($fld=='description') { ?>
                           		<textarea name="<?php echo $fld; ?>"  id="umeta"  style="width:300px;"  ><?php echo htmlspecialchars(get_usermeta($_GET['edit_user_id'],$fld)); ?></textarea>
                            <?php
							}elseif ($fld=='avatar') {
								$avtar=get_usermeta($_GET['edit_user_id'],'avatar');
								
								if (is_array($avtar)) 
										foreach ($avtar as $avt)
												echo '<img src='.$avt.'>';
								else
										echo '<img src='.$avtar.'><br/>';?>
											
								<input name="avatar" type="text"  id="umeta" value="<?php echo get_usermeta($_GET['edit_user_id'],'avatar'); ?>" style="width:300px;"  /><?php
							}else{ ?>
                             <input name="<?php echo $fld; ?>" type="text"  id="umeta" value="<?php echo get_usermeta($_GET['edit_user_id'],$fld); ?>" style="width:300px;"  /><?php if ($fld=='expire') echo '<br/>Only this format 2009-09-01 22:05:39';
							} ?></td>
                </tr> 
            <?php } //endforeach?>
                
                <tr class="form-field form-required" >
								<th scope="row">URL</th> 
				  <td><input name="user_url" type="text" value="<?php echo $user->user_url; ?>" style="width:300px;" />
                                <?php if($user->user_url) {?> <br />
                                <a href="<?php echo $user->user_url; ?>">Go to URL</a><?php } ?></td>
				</tr>
                <tr class="form-field form-required" >
								<th scope="row">Registered Date</th> 
								<td><input name="user_registered" type="text" value="<?php echo $user->user_registered; ?>" style="width:300px;" />                                </td>
				</tr>
                 <tr class="form-field form-required" >
								<th scope="row"> Display Name</th> 
								<td><input name="display_name" type="text" value="<?php echo $user->display_name; ?>" style="width:300px;" />                                </td>
				</tr>
              
                 <tr class="form-field form-required" >
								<th scope="row">Activation Key</th> 
								<td><input name="user_activation_key" type="text"   value="<?php echo $user->user_activation_key; ?>" style="width:300px;" />
                                <br />Do not edit here if you don't know what you are doing</td>
				</tr>
              
        	<?php
	   		}
			echo '<input type="hidden" name="wwm_member_noncename" id="wwm_noncename" value="' .wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	   echo '</table>
	   <table class="form-table" style="width:600px">';
	   $metas = $wpdb->get_results($wpdb->prepare("SELECT meta_key FROM {$wpdb->usermeta} WHERE user_id = %s ", $_GET['edit_user_id'])); 

	   		foreach ($metas as $meta) {
			$metaval=get_usermeta($_GET['edit_user_id'],$meta->meta_key);
			 	if (!in_array($meta->meta_key,$standardf)) { 
			?>
           
                <tr class="form-field form-required" >
                    <th scope="row"><?php echo str_replace('_',' ',strtoupper(substr( $meta->meta_key,0,1) ).substr( $meta->meta_key,1,40) ); ?></th>
                    <td>
                    <?php 
							
								 
						
						 
                                if  ((is_array($metaval))) {
                                    echo '<textarea name="array"  id="'. $meta->meta_key.'"  style="width:300px;height:62px;" disabled="disabled" /> ';
                                    print_r($metaval);
                                    echo '</textarea>';
                                }else{ ?>   
                                
                                    <input name="<?php echo $meta->meta_key; ?>" type="text"  id="umeta-<?php echo $meta->meta_key; ?>" value="<?php echo $metaval; ?>" style="width:300px;"  />
                          <?php }
                         
                         ?>
                     </td>
                </tr>
                                     
				<?php	}//endif_in array
			 } 
            
	  ?></table> <p class="submit"> <input type="submit" class="button-primary" name="submit" value="Save changes" /> 
	  <?php  if (get_usermeta($_GET['edit_user_id'],'status')) { ?>
		 <a href="?page=<?php echo $_GET['page']; ?>&activate_user_id=<?php echo $_GET['edit_user_id'];?>" title="Allow this user to login"><input  type="button" class="button"  name="suspend" value="Activate Account" /></a>
		<?php }else{ ?>
        <a href="?page=<?php echo $_GET['page']; ?>&suspend_user_id=<?php echo $_GET['edit_user_id']; ?>">
         <input type="button" class="button" name="suspend" value="Suspend Account" /></a>
         <?php }?>
         
          <a onclick="if ( confirm('You are about to delete a user with all of his/her posts \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" title="Delete user with posts" href="?page=<?php echo $_GET['page']; ?>&delete_user_id=<?php echo $_GET['edit_user_id'];  ?>">
         <input type="button" class="button" name="delete" alt="Delete user with posts" value="Delete User" /></a>
         
         <a  href="?page=<?php echo $_GET['page']; ?>&renew_user_id=<?php echo $_GET['edit_user_id'];  ?>">
         <input type="button" class="button" name="renew"  value="Renew Account" /></a>
        
         <a  title="Cancel and go to manage page" href="?page=<?php echo $_GET['page']; ?>">Go Back</a>
         
        </p></form>
	   <?php
	   
	   }else{
        $usersnum = $wpdb->get_var( "SELECT count(*) FROM {$userstable} " ); 
        ?>
		<div id="icon-users" class="icon32"><br /></div>


        <h2>Manage Members</h2>
        <P>You can also use <a href="<?php ABSPATH ?>users.php">this page</a> to delete users(without deleting their posts) and change roles. [Total Users:<?php echo $usersnum;?>]        </p><table class="widefat">
<thead>
<tr class="thead">
	<th>ID</th>
	<th>Username</th>
	<th>Name</th>
	<th>E-mail</th>
    <th>Posts </th>
    <th>Last IP</th>
	<th>Plan </th>
    <th>Registered</th>
    <th>Expires </th>
    <th>Status </th>
	<th>Actions</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th>ID</th>
	<th>Username</th>
	<th>Name</th>
	<th>E-mail</th>
    <th>Posts </th>
    <th>Last IP</th>
	<th>Plan </th>
    <th>Registered</th>
    <th>Expires </th>
    <th>Status </th>
	<th>Actions</th>
</tr>
</tfoot>



<tbody id="users" class="list:user user-list">
<?php 
$start=0;
$pagenum=1;
$nperpage=20;
if (isset($_GET['pagenum'])) { $start=$_GET['pagenum']*$nperpage-$nperpage;$pagenum=$_GET['pagenum'];}
$userlist = $wpdb->get_results( "SELECT ID,user_login,user_email,user_registered FROM {$userstable} ORDER BY ID LIMIT {$start},{$nperpage} " ); 


foreach ($userlist as $user) {
	$author_users_posts=$wpdb->get_var("SELECT count(*) FROM {$poststable} WHERE post_author={$user->ID} AND post_type='post' AND post_status='publish';");
 $id=$user->ID;	
 $status=get_usermeta($id,'status');
 $expire=get_usermeta($id,'expire');
 $now=date("Y-m-d H:i:s");
 
	 if ( ($expire)&&($expire<$now) ) {
			update_usermeta($id,'status','expired');
			$status=get_usermeta($id,'status');
	}elseif(($expire)&&($expire>$now)&&($status=='expired') ){
			update_usermeta($id,'status','0');
			$status=get_usermeta($id,'status');
	}
	
 
 ?>
	<tr id='user-<?php echo $id;?>'  class="alternate" <?php if ($status=='suspended') echo 'style="background-color:#FFA4A4;"';elseif ($status=='expired') echo 'style="background-color:#fffe9d;"';elseif ($status=='incomplete') echo 'style="background-color:#ccc;"'?>>
		<td class="posts column-posts num"><?php echo $id;?></th>		</td><td><strong><a title="click to edit" href="?page=<?php echo $_GET['page']; ?>&edit_user_id=<?php echo $id;?> "><?php echo $user->user_login; ?></a></strong></td>
		<td bgcolor=""><?php echo get_usermeta($id,'first_name').' '.get_usermeta($id,'last_name'); ?></td>
		<td ><a href='admin.php?page=wwm-mass-mailer.php&amp;to=<?php echo $user->user_email; ?>' title='e-mail: <?php echo $user->user_email; ?>'><?php echo $user->user_email; ?></a></td>
        <td class="posts column-posts num"> <a title="View <?php echo $author_users_posts;?> user published posts" href='<?php ABSPATH ?>edit.php?author=<?php echo $id;?>'><?php echo $author_users_posts; ?></a></td>
        <td><?php echo get_usermeta($id,'last_ip'); ?> </td>
		<td class="posts column-posts num">
		<?php $planinfo=get_plan_info(get_usermeta($id,'plan_id')); echo '<a title="'.$planinfo->title.'">'.$planinfo->id .'</a>';  ?> </td>
        <td><?php echo substr($user->user_registered,0,10); ?></td>
        <td><?php echo substr($expire,0,10); 
		
		
		
		
		
		?></td>
        <td><?php echo $status; ?></td>
        
		<td >
      	<?php  if ($status) { ?>
		 <a href='?page=<?php echo $_GET['page']; ?>&activate_user_id=<?php echo $id;?>' title='Allow this user to login-If expired  renw it'>Activate</a>
		<?php }else{ ?>
        <a href='?page=<?php echo $_GET['page']; ?>&suspend_user_id=<?php echo $id;?>' title='Do not allow this user to login'>Suspend</a>
		<?php } ?> | 
        <a href='?page=<?php echo $_GET['page']; ?>&edit_user_id=<?php echo $id;?>' title="View/Edit user's profile ">Edit</a> | 
         <a href='<?php ABSPATH ?>edit.php?author=<?php echo $id;?>' title=""> Posts</a> | 
        <a href='?page=<?php echo $_GET['page']; ?>&renew_user_id=<?php echo $id;?>' title="Add user's plan time to expire date">Renew</a> | 
        <a onclick="if ( confirm('You are about to delete a user with all of his/her posts \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" href='?page=<?php echo $_GET['page']; ?>&delete_user_id=<?php echo $id;?>' title='Delete with all of posts'>Delete</a></td>
	</tr>

	<?php } //end foreach ?>
</tbody>
</table>
		<p>
        
<?php 	
$num=($usersnum%$nperpage==0) ? floor($usersnum/$nperpage) : floor($usersnum/$nperpage)+1;


//if ( (floor($usersnum/$nperpage))==($usersnum/$nperpage) ) $num--;

if ($usersnum>$nperpage) {	 
	?>
	
    <?php if ( ($pagenum) && ($pagenum>1) ) {
	?>
	<a class='prev page-numbers' href="?page=<?php echo $_GET['page'];?>&pagenum=1">First</a>
    <?php
	$prev=$pagenum-1;
    echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&pagenum=".$prev."'>Prev</a>";
	}
	
	if ( ($pagenum) && ($pagenum<$num) ) {
	$next=$pagenum+1;
    echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&pagenum=".$next."'>Next</a>";
	
	?>
	<a class='prev page-numbers' href="?page=<?php echo $_GET['page'];?>&pagenum=<?php echo $num; ?>">Last</a>
	<?php } ?>
<?php } ?>
		</p></div>
</div>
<?php
	}//end if is edit 
?>