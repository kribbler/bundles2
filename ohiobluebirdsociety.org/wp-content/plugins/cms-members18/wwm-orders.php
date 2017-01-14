<?php
if ('wwm-orders.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 
if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));
	


global $wpdb;

	if (isset($_GET['delete_order_id'])) {
	$wpdb->query($wpdb->prepare("DELETE FROM ".WWM_ORDERS_TABLE." WHERE `id` = %s LIMIT 1",$_GET['delete_order_id']));
	$msg="Order successfully deleted!";
	}
	
	if (isset($_POST['change_submit'])) {
	$wpdb->query($wpdb->prepare("DELETE FROM ".WWM_ORDERS_TABLE." WHERE `id` = %s LIMIT 1",$_GET['delete_order_id']));
	$msg="Status successfully changed!";
	}
	
	if (isset($_POST['change_submit'])) {
	$wpdb->query($wpdb->prepare("UPDATE ".WWM_ORDERS_TABLE." SET status=%s WHERE `id` = %s LIMIT 1",$_POST['status'],$_GET['view_order_id']));
	$msg="Status successfully changed!";
	} ?>
	
	<div class="wrap">
	<?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
	<?php 
	
	if ( (isset($_GET['view_order_id'])) && (empty($msg)) ) {
	
	$info=get_order_info($_GET['view_order_id']);
	$custom=unserialize($info->customfields);
	?>
	<h2>View Order Details</h2> 
	<p></p><form method="post">Change Status: <select class="wwm-status" name="status" id="wwm-status">
	<option value="Completed Order" <?php if($info->status=='Completed Order') echo 'selected="selected"';?> >Completed Order</option>
	<option value="Pending Order" <?php if($info->status=='Pending Payment') echo 'selected="selected"';?> >Pending Order</option>
	<option value="Sent" <?php if($info->status=='Sent') echo 'selected="selected"';?> >Sent Order</option>
	<option value="Completed Payment" <?php if($info->status=='Completed Payment') echo 'selected="selected"';?> >Completed Payment</option>
	<option value="Pending Payment" <?php if($info->status=='Pending Payment') echo 'selected="selected"';?> >Pending Payment</option>
	<option value="Free Order" <?php if($info->status=='Free Order') echo 'selected="selected"';?> >Free Order</option>
	<option value="Ignore Order" <?php if($info->status=='Ignore Order') echo 'selected="selected"';?> >Ignore Order</option>
	<option value="Failed" <?php if($info->status=='Failed') echo 'selected="selected"';?> >Failed</option>
	
	
	</select><input type="submit" name="change_submit" class="button-primary" value="Change Status"/><a onClick="if ( confirm('You are about to delete an order \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" href="?page=<?php echo $_GET['page'];?>&delete_order_id=<?php echo $_GET['view_order_id'];?>"><input type="button" class="button" value="Delete Record" /></a> | <a  title="Cancel and go to orders page" href="?page=<?php echo $_GET['page'];?>">Go Back</a></form> <p></p>
	<table class="widefat" style="width:700px;">
	<thead>
	<tr class="thead">
	<th >Name</th>
	<th>Value</th>
	</tr>
	</thead>
	
	<tfoot>
	<tr class="tfoot">
	<th >Name</th>
	<th>Value</th>
	</tr>
	</tfoot>
	
	<tbody id="orders" class="list:order orders-list">
	<?php 
	if ($info) {
		foreach ($info as $name=>$value) { 
				if( ($name=='customfields')||($name=='user_pass')||($value=='') ) continue;
					switch ($name) {
					case 'id':
						$name='ID';
						break;
					case 'planid':
						$name='Plan ID';
						break;
					case 'userid':
						$name='User ID';
						break;
					case 'txnid':
						$name='Transaction ID';
						break;
					case 'checkid':
						$name='Check ID';
						break;
					case 'payer_fname':
						$name='Payer First Name';
						break;
					case 'payer_lname':
						$name='Payer Last Name';
						break;
					case 'yim':
						$name='Yahoo IM';
						break;
					case 'aim':
						$name='AOL IM';
						break;
					case 'ip':
						$name='IP';
						break;
					}
	?>
					<tr>
					<td><?php echo str_replace('_',' ',strtoupper(substr($name,0,1)).substr($name,1,50));?></td>
					<td><?php if ($name=='avatar') {echo '<img src="'.$value.'" alt="'.$value.'">'; }elseif ($name=='User ID' && ($value)){  echo "<a href='?page=wwm-members.php&amp;edit_user_id=".$value."' title='Edit user info'>".$value."</a><tr><td>PayPal Subscr ID</td><td>".get_usermeta($value, 'PayPal_Subscr_ID')."</td>";}else{ echo $value; }?></td>
					</tr>
	<?php
		}?>
		<tr><td><h3>Custom Fields</h3></td><td> </td></tr>
		<?php
		$last_id=wwm_get_fields_last_id();
		for ($i=1;$i<=$last_id;$i++) {
				 //$body .="<b>".$custom[$i][label]." </b>".get_usermeta($id,'customfield_'.$i,$custom[$i][value]);
                 if ($custom[$i][label]) {?>
				 <tr>
					<td><?php echo str_replace('_',' ',strtoupper(substr($custom[$i][label],0,1)).substr($custom[$i][label],1,50));?></td>
					<td><?php echo $custom[$i][value];?></td>
				 </tr>
		<?php    }
		}
		echo'</tbody></table>';
		}//end if info
	}else{ ?>
	</tbody><h2>Orders / Transactions</h2>
	<p>Here you can view orders/transactions details. 
		<?php if (isset($_GET['plan'])) { ?>
   		 <a href="?page=<?php echo $_GET['page'];?>">Back.</a>
		 
		 <?php } ?>
	</p>
	 
	<table class="widefat">
	
	<thead>
	<tr class="thead">
		<th class="posts column-posts num">ID</th>
		<th class="posts column-posts num">User ID</th>
		<th class="posts column-posts num">Trans ID</th>
		<th>Name (Username)</th>
		<th>Plan Title</th>
		<th>Payment Status</th>
		<th>Order Satatus</th>
		<th>View</th>
	</tr>
	</thead>
	
	<tfoot>
	<tr class="tfoot">
		<th class="posts column-posts num">ID</th>
		<th class="posts column-posts num">User ID</th>
		<th class="posts column-posts num">Trans ID</th>
		<th>Name (Username)</th>
		<th>Plan Title</th>
		<th>Payment Status</th>
		<th>Order Satatus</th>
		<th>View</th>
	</tr>
	</tfoot>
	
	<tbody id="orders" class="list:order orders-list">
	<?php
	if (isset($_GET['plan']))
		$ordersnum = $wpdb->get_var( "SELECT count(*) FROM ".WWM_ORDERS_TABLE." WHERE planid={$_GET['plan']};" ); 
	else
		$ordersnum = $wpdb->get_var( "SELECT count(*) FROM ".WWM_ORDERS_TABLE.";" ); 
	
	$start=0;
	$pagenum=1;
	$nperpage=25;
	if (isset($_GET['pagenum'])) { $start=$_GET['pagenum']*$nperpage-$nperpage;$pagenum=$_GET['pagenum'];}
	
	if (isset($_GET['plan'])) {
		$orderslist=$wpdb->get_results("SELECT * FROM ".WWM_ORDERS_TABLE." WHERE planid={$_GET['plan']} ORDER BY id LIMIT {$start},{$nperpage};");
	}else{
		$orderslist=$wpdb->get_results("SELECT * FROM ".WWM_ORDERS_TABLE." ORDER BY id LIMIT {$start},{$nperpage};");
	}
	
	
		if (!$orderslist) {
		echo'<tr><td>There is no order currently</td></tr>';
		}else{
			foreach ($orderslist as $order) {
			?>
			<tr><td class="posts column-posts num"><?php echo $order->id;?></td>
				<td class="posts column-posts num"><?php echo $order->userid;?></td>
				<td class="posts column-posts num"><?php echo $order->txnid;?></td>
				<td>
				<?php if ($order->userid) { ?>
                
                	<strong><a href="?page=wwm-members.php&edit_user_id=<?php echo $order->userid;?>" title="View more details of this user" ><?php echo $order->first_name.' '.$order->last_name; echo '</a></strong>'; if ($order->user_login) echo '('.$order->user_login.')';?></a></strong>
                
            	<?php }else{ ?>
                
            	  <?php echo '<strong>'.$order->first_name.' '.$order->last_name; ?></strong>
                
         	    <?php }  ?>
                
                
                
                
                </td>
				 <td ><a href="?page=<?php echo $_GET['page'];?>&plan=<?php echo $order->planid;?>" title="Display Plan Transactions"><?php $planinfo=get_plan_info($order->planid); echo $planinfo->title;?></a></td>
				 <td><?php echo $order->payment_status;?></td>
				 <td><?php echo $order->status;?></td>
				 <td><a href="?page=<?php echo $_GET['page'];?>&view_order_id=<?php echo $order->id;?>" title="View more details/Edit status" >View</a> | 
					 <a onClick="if ( confirm('You are about to delete an order \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" href="?page=<?php echo $_GET['page'];?>&delete_order_id=<?php echo $order->id;?>" title="Delete order" >Delete</a></td>
	  </tr>
			<?php
			}//end foreach
		}
		echo '</tbody></table> <p>';
			
	
	$num=floor($ordersnum/1) +1;
	if ( (floor($ordersnum/1))==($ordersnum/1) ) $num--;
	
	if ($ordersnum>1) {	 
		?>
		
		<?php if ( ($pagenum) && ($pagenum>1) ) {
		?>
	</tbody><a class='prev page-numbers' href="?page=<?php echo $_GET['page']; ?>&pagenum=1<?php if (isset($_GET['plan'])) echo '&plan=' . $_GET['plan']; ?>">First</a>
		<?php
		$prev=$pagenum-1;
		
			if (isset($_GET['plan'])) 
				echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&pagenum=".$prev."&plan=".$_GET['plan']."'>Prev</a>";
			else
				echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&pagenum=".$prev."'>Prev</a>";
			
			
			
		}
		$floor=($ordersnum%$nperpage==0) ? floor($ordersnum/$nperpage) : floor($ordersnum/$nperpage)+1;
		if ( ($pagenum) && ($pagenum<$floor) ) {
		$next=$pagenum+1;
		
			if (isset($_GET['plan'])) 
				echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&plan=".$_GET['plan']."&pagenum=".$next."'>Next</a>";
			else
				echo "<a class='prev page-numbers' href='?page=". $_GET['page']."&pagenum=".$next."'>Next</a>";
		
		
		?>
   
		<a class='prev page-numbers' href="?page=<?php echo $_GET['page'];?>&pagenum=<?php echo $floor; if (isset($_GET['plan'])) echo '&plan='.$_GET['plan'];?>">Last</a>
        
        
		<?php } ?>
	<?php } ?>
			
			<p></p></div>
			<?php
	}//end first if

?> <br /><small>For more details about a transaction (e.g. Pending Reason) go to your domain root, open .paypal_ipn_results.log or .2co_ipn_results.log and search for transaction checkid.</small>
</table></table>