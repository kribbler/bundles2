<?php
if ('wwm-plans.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 
if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));
	
global $wpdb;

	if  (isset($_POST['edit-submit'])) {
		if ((!is_numeric($_POST['plan-duration'])) || (!is_numeric($_POST['plan-price'])) ) { $msg="Price and Duration should be number! Go back and try agian";}
		elseif( (empty($_POST['plan-title'])) || (empty($_POST['plan-type'])) ||($_POST['plan-duration']=='') || ($_POST['plan-price']=='') ) { $msg="Please fill of of required fields! Go back and try again";}else{
		$sql="UPDATE ".WWM_PLANS_TABLE." SET title=%s, plantype=%s ,duration=%s, price=%s, display=%s, description=%s WHERE id=%s;";
		$wpdb->query($wpdb->prepare($sql,stripslashes($_POST['plan-title']),$_POST['plan-type'],$_POST['plan-duration'],$_POST['plan-price'],$_POST['plan-display'],stripslashes($_POST['plan-description']),$_POST['id']));
		$msg='Plan successfully updated!';
		}
	}
	
	if (isset($_POST['submit'])) {
		if ( (empty($_POST['plan-title'])) || (empty($_POST['plan-type'])) ||($_POST['plan-duration']=='') || ($_POST['plan-price']=='') ) {$msg='Please fill all of required fields!';
		}elseif( (!is_numeric($_POST['plan-duration'])) || (!is_numeric($_POST['plan-price'])) ) { $msg="Price and Duration should be number!";
		}else{
		$title=stripslashes($_POST['plan-title']);
		$type=$_POST['plan-type'];
		$duration=$_POST['plan-duration'];
		$price=$_POST['plan-price'];
		$display=$_POST['plan-display'];
		$description=stripslashes($_POST['plan-description']);
		$sql="INSERT INTO ".WWM_PLANS_TABLE." (title, plantype, duration, price, display, description) VALUES (%s,%s,%s,%s,%s,%s);";
		$wpdb->query($wpdb->prepare($sql,$title,$type,$duration,$price,$display,$description));
		$msg='Plan successfully added!';
		}	
	}
	
	if (isset($_GET['delete_plan_id'])) {
		$sql="DELETE FROM ".WWM_PLANS_TABLE." WHERE `id` = %s LIMIT 1";
		$wpdb->query($wpdb->prepare($sql,$_GET['delete_plan_id']));
		$msg='Plan successfully deleted!';	
	}

	if ( (isset($_GET['edit_plan_id'])) && (is_numeric($_GET['edit_plan_id'])) && (!isset($_POST['edit-submit'])) ) {
		$theplan = $wpdb->get_results("SELECT id,title,display,duration,price,plantype,description FROM ".WWM_PLANS_TABLE." WHERE id={$_GET['edit_plan_id']}" ); 

		if (!$theplan) {echo 'Not found any thing';}else{
			foreach ($theplan as $plan) {
			?>
			
			<div class="wrap">
            <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
            <div class="form-wrap">
            <h3>Edit Business Plans</h3>
            <form method="post" name="edit-plan-form" action="">
            
            <div class="form-field">
            <label for="plan-title">Plan Title</label>
            <input type="text" name="plan-title" style="width:250px" value="<?php echo $plan->title; ?>" />
            <p>
            Don't forget to add price and duration in Plan Title or Plan Description</p>
            </div>
    
     <div class="form-field">
            <label for="plan-type">Plan Type</label>
            <select name="plan-type" class='postform'>
            <option <?php if ($plan->plantype=='membership') echo 'selected="selected"';?>  value="membership"> Membership </option>
            <option <?php if ($plan->plantype=='order') echo 'selected="selected"';?>  value="order"> Order </option>
            </select></div>
        
          <div class="form-field">
            <label for="plan-duration">Duration</label>
            <input type="text" name="plan-duration" style="width:250px" value="<?php echo $plan->duration; ?>" /><p>
            How many days can members use this service? (e.g. 365 means one year subscription, 90 means 3 months and 0 means Unlimited) </p>
            </div>
        
        <div class="form-field">
            <label for="plan-price">Price</label>
            <input type="text" name="plan-price" style="width:250px" value="<?php echo $plan->price; ?>" /><p>
            How much it cost? (0 means FREE)</p>
            </div>
        
          <div class="form-field">
            <label for="plan-display" style="width:250px">Display</label>
            <select name="plan-display" class='postform'><option <?php if ($plan->display=='1') echo 'selected="selected"';?> value="1"> Yes </option><option <?php if ($plan->display=='0') echo 'selected="selected"';?> value="0"> No </option></select><p>
            Would you like to suggest this plan in the registration page?</p>
            </div>
        
        <div class="form-field">
            <label for="plan-description">Description(optional)</label>
            <textarea name="plan-description" style="width:250px" cols="40" rows="5"><?php echo esc_attr($plan->description); ?></textarea>
        </div>
            <input type="hidden" name="id" value="<?php echo $_GET['edit_plan_id'];?>" />
        
            <input type="submit" class="button" name="edit-submit" value="Save changes" /> | <a  title="Cancel and go to plans page" href="?page=<?php echo $_GET['page']; ?>">Go Back</a>
            </form></div></div>
			<?php
				
			}
		}
	

	}else{


?>
<div class="wrap">
        <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
        
<h2>Manage Plans</h2>
        <P>Here you can add and manage your business plans or products(e.g. membership fee,membership duration, order price, etc)        </p>
        
        <table class="widefat">
<thead>
<tr class="thead">
	<th class="posts column-posts num" >ID</th>
	<th>Title</th>
	<th>Type</th>
	<th class="posts column-posts num">Duration</th>
    <th class="posts column-posts num">Price </th>
    <th>Display </th>
    <th class="posts column-posts num">Users </th>
	<th>Actions</th>
</tr>
</thead>

<tfoot>
<tr class="tfoot">
	<th class="posts column-posts num">ID</th>
	<th>Title</th>
	<th>Type</th>
	<th class="posts column-posts num">Duration</th>
    <th class="posts column-posts num">Price </th>
    <th>Display </th>
    <th class="posts column-posts num">Users </th>
	<th>Actions</th>
</tr>
</tfoot>

<tbody id="plans" class="list:plan plan-list">
<?php 

$planlist = $wpdb->get_results("SELECT id,title,display,duration,price,plantype FROM ".WWM_PLANS_TABLE.";" ); 

	if (!$planlist) {echo '<tr><td>There is no plan currently, so membership is free.</tr></td></tbody></table>';}else{
		foreach ($planlist as $plan) {
			$count_users=$wpdb->get_var("SELECT count(*) FROM {$wpdb->usermeta} WHERE meta_key='plan_id' AND meta_value={$plan->id} ;");
 ?>
	<tr id='user-<?php $id=$plan->id;echo $id;?>' class="alternate" >
		<th scope='row' class="posts column-posts num"><?php echo $id;?></th>
		<td><strong><a title="click to edit" href="?page=<?php echo $_GET['page'];?>&edit_plan_id=<?php echo $id;?>"><?php echo esc_attr($plan->title); ?></a></strong></td>
		<td ><?php echo $plan->plantype;?></td>
		<td class="posts column-posts num"><?php echo $plan->duration;?></a></td>
        <td class="posts column-posts num"> <?php echo $plan->price;?></td>
        <td><?php if($plan->display) echo '<img src="'.get_option('siteurl').'/wp-admin/images/yes.png'.'" alt="Yes" />';else echo '<img src="'.get_option('siteurl').'/wp-admin/images/no.png'.'" alt="No" />';?> </td>
		<td class="posts column-posts num"><?php echo $count_users;?> </td>      
		<td>
        <a href="?page=<?php echo $_GET['page'];?>&edit_plan_id=<?php echo $id;?>" title="View/Edit plan details ">Edit</a> | 
        <a onClick="if ( confirm('You are about to delete a plan \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" 
        href="?page=<?php echo $_GET['page'];?>&delete_plan_id=<?php echo $id;?>" title='Delete plan'>Delete</a>        </td>
	</tr>

<?php 	} //end foreach ?>
</tbody>
</table><p>&nbsp;</p>
		
<?php
	}//end if
	?>


<div class="form-wrap">
<h3>Add a new plan</h3>
<form method="post" name="add-plan" style="width:400px">

<div class="form-field">
<label for="plan-title">Plan Title</label>
<input type="text" name="plan-title" value="" style="width:250px"/>
 <p>Don't forget to mention price and duration in Plan Title or Plan Description</p>
</div>


<div class="form-field">
<label for="plan-type">Plan Type</label>
<select name="plan-type" class='postform'>
<option selected="selected"  value="membership"> Membership </option>
<option   value="order"> Order </option>
</select>
</div>

<div class="form-field">
<label for="plan-duration">Duration</label>
<input type="text" name="plan-duration" value=""  style="width:250px"/>
<p>How many days members can use your services? (e.g. 365 means one year subscription ,0 means Unlimited, 0 for orders)  </p>
</div>

<div class="form-field">
<label for="plan-price">Price</label>
<input type="text" name="plan-price" value="" style="width:250px"/>
<p>How much money users should pay for this plan? (0 means FREE)</p>
</div>

<div class="form-field">
<label for="plan-display">Display</label>
<select name="plan-display" class='postform'><option selected="selected"  value="1"> Yes </option><option  value="0"> No </option></select>
<p>Would you like to suggest this plan in registration page?</p>
</div>

<div class="form-field">
<label for="plan-description">Description(optional)</label>
<textarea name="plan-description" rows="5" cols="40"></textarea>
</div>

<input type="submit" class="button" name="submit" value="Add Plan" style="width:80px" />
</form></div></div>
<?php
	}//endif

?>