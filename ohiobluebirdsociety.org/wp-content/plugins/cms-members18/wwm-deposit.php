<?php

if ('wwm-deposit.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 

global $wpdb,$user_ID;
$min=0;
$msg='';
if ((!is_user_logged_in()) && (!isset($_GET['action'])) )  
		return "Sorry, You have not enough permission to see this page!";
		
if (isset($_POST['deposit_submit'])) {
	if ( (isset($_POST['payment_amount'])) && ((empty($_POST['payment_amount'])) || (!is_numeric($_POST['payment_amount'])) || ($min > $_POST['payment_amount'])  ) ) {
		$msg.='Please enter a number for payment amount.';
		if ($min) 
			$msg.='Minimum deposit: '. $min;
	}
}
if (isset($_POST['deposit_submit']) && empty($msg)) {
	$hidden=true;
	$pageid=get_the_id();
	if (clean_url(get_option('permalink_structure'))) {
		$this_script =get_permalink($pageid);
		$sucpage=$this_script.'?action=success&amp;method='.$_POST['payment_type'];
		$canpage=$this_script.'?action=cancel&amp;method='.$_POST['payment_type'];
		$ipnpage=$this_script.'?action=ipn&amp;method='.trim($_POST['payment_type']);
	}else{
		$this_script = get_option('home').'?page_id='.$pageid;
		$sucpage=$this_script.'&amp;action=success&amp;method='.$_POST['payment_type'];
		$canpage=$this_script.'&amp;action=cancel&amp;method='.$_POST['payment_type'];
		$ipnpage=$this_script.'&amp;action=ipn&amp;method='.$_POST['payment_type'];
	}
	switch ($_POST['payment_type']) {
		case 'paypal':
			require_once('include/paypal.class.php');
			$admin_email=get_option('admin_email');
			
			if(get_option('wwm_paypal_mode')=='live'){
				$p = new wwm_paypal_class(false); // initiate an instance of the class. true:sandbox / false:live use
			}else{
				$p = new wwm_paypal_class(true);  //sandbox
			}           
			
			$p->add_field('business', get_option('wwm_paypal_mail_address'));
			$p->add_field('return', $sucpage);
			$p->add_field('cancel_return', $canpage);
			$p->add_field('notify_url', $ipnpage);
			$p->add_field('item_name', 'Deposit [user #'.$user_ID.']');
			$p->add_field('amount', $_POST['payment_amount']);
			$p->add_field('currency_code',get_option('wwm_paypal_currency_code')); //['USD,GBP,JPY,CAD,EUR']
			$p->add_field('custom', $user_ID); 
			$p->add_field('no_shipping', '1');
			
			foreach($_POST as $i => $v) {
				$postdata .= $i.'='.urlencode($v).'&';
			}
			$postdata .= 'cmd=_notify-validate';
			
			$p->submit_paypal_post(); // submit the fields to paypal
		    //$p->dump_fields(); 
		break;
		case 'twoco':
			require_once ('include/TwoCo.php');
			$my2CO = new TwoCo();
			//$checkid = substr( md5( uniqid( microtime() ) ), 0, 3);
			$my2CO->addField('sid', get_option('wwm_2co_sid'));
			$my2CO->addField('cart_order_id', 	'Deposit [user #'.$user_ID.']');
			$my2CO->addField('total', $_POST['payment_amount']);
			$my2CO->addField('x_Receipt_Link_URL', $ipnpage);
			// *** IMPORTANT: add some thing to cart order id /SID****
			$my2CO->addField('custom', $user_ID);
			$my2CO->addField('id_type', '1');
			//$my2CO->addField('c_prod_1', '1,1');
			//$my2CO->addField('c_price_1', $_POST['payment_amount']);
			//$my2CO->addField('c_name_1', 'Deposit (user #'.$user_ID.')');
			
			if (get_option('wwm_2co_mode')=='test')
				$my2CO->enableTestMode();
			
			$my2CO->submitPayment();

		break;
	}//endswitch
}//endsubmitif

if (isset($_GET['action'])) {

	switch ($_GET['action']) {
		case 'success':
		 	echo "<div class=\"wwm-thanksmessage\">".__('Thank you for your deposit.','wwm')."</div>";
			$hidden=true;
		break;
		case 'cancel':
			echo "<div class=\"wwm-errormessage\">".__('The payment was canceled.','wwm')."</div>";
		break;
		
		case 'ipn':
			if ((isset($_GET['method'])) && ($_GET['method']=='paypal')){
				require_once('include/paypal.class.php');
			
				if(get_option('wwm_paypal_mode')=='live'){
					$p = new wwm_paypal_class(false); 
				}else{
					$p = new wwm_paypal_class(true);  
				} 
				
				$p->add_field('business', get_option('wwm_paypal_mail_address'));
				$error=false;

				if($_POST['payment_status']!='Completed' && isset($_POST['pending_reason'])) {
					$details .= "<br>The transaction was not completed successfully at Paypal. The pending reason for this is".' '.$_POST['pending_reason'];
					$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , txnid, memo, payment_status, payment_date, ip, failed_details) VALUES (%s,%s,%s,%s,%s,%s,%s,%s);";
					$wpdb->query($wpdb->prepare($sql, $p->ipn_data['custom'], 'Failed Deposit', $p->ipn_data['txn_id'], $p->ipn_data['memo'],'Failed', date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $details ));	
					$error=true;	
				}
				
				
				if ($p->validate_ipn()) {
					//check txn_id is unique
					
					$checktrans=$wpdb->get_results("SELECT txnid FROM ".WWM_ORDERS_TABLE.";");
					foreach($checktrans as $trans){
						if(strpos($trans->txnid, $p->ipn_data['txn_id'])===true){
							$details .= "<br>Duplicated Transaction ID. Transaction ID: {$p->ipn_data['txn_id']} ";
							$error=true;
						}
					}
				
					if($p->ipn_data['payment_status']!='Completed'){
						$details .= "<br>Payment is not completed. Currently Payment Status: \"{$p->ipn_data['payment_status']}\" ";
						$error=true;
						$p->log_ipn_results(false);
					}
					
					if ( !$error ) {
						$p->log_ipn_results(true);
						$user=get_user_by('id',  $p->ipn_data['custom']);
						
						$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , txnid, memo, payment_status, payment_date, payer_mail, payer_fname, payer_lname, payer_country, verify_sign, gross,user_login, first_name,last_name, ip) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);";
						$wpdb->query($wpdb->prepare($sql, $p->ipn_data['custom'], 'Successful Deposit',$p->ipn_data['txn_id'], $p->ipn_data['memo'], 'Completed', date('Y-m-d H:i:s'), $p->ipn_data['payer_email'], $p->ipn_data['first_name'], $p->ipn_data['last_name'], $p->ipn_data['residence_country'], $p->ipn_data['verify_sign'], $p->ipn_data['mc_gross'],$user->user_login, $user->first_name, $user->last_name, $_SERVER['REMOTE_ADDR'] ));
						
						$balance=get_usermeta($p->ipn_data['custom'],'balance');
						update_usermeta($p->ipn_data['custom'],'balance', $balance + $p->ipn_data['mc_gross']);
						
						
						
						//action first user_id second amount
						do_action('wwm_user_deposited', $p->ipn_data['custom'],$p->ipn_data['mc_gross'] );
					}else{ //if error
						$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , txnid, memo, payment_status, payment_date, ip, failed_details) VALUES (%s,%s,%s,%s,%s,%s,%s,%s);";
						$wpdb->query($wpdb->prepare($sql, $p->ipn_data['custom'], 'Failed Deposit', $p->ipn_data['txn_id'], $p->ipn_data['memo'], 'Failed', date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $details ));
						
					}
				}//endvalidate
			
			}elseif (isset($_GET['method']) && $_GET['method']=='twoco') {

				include_once ('include/TwoCo.php');
				$my2CO = new TwoCo();
				$my2CO->ipnLog = TRUE;
				$my2CO->setSecret(get_option('wwm_2co_secret'));
				
				if (get_option('wwm_2co_mode')=='test') 
					$my2CO->enableTestMode();
					
				if ($my2CO->validateIpn())
				{
					/*$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , checkid, txnid, memo, payment_status, payment_date, gross, ip) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s);";
					$wpdb->query($wpdb->prepare($sql, $my2CO->ipnData['custom'], 'Success Deposit', $my2CO->ipnData['cart_order_id'],$my2CO->ipnData['order_number'],'2Checkout Key: '.$my2CO->ipnData['key'], 'Completed', date('Y-m-d H:i:s'), $my2CO->ipnData['total'], $_SERVER['REMOTE_ADDR'] ));*/
					
					$user=get_user_by('id',  $my2CO->ipnData['custom']);
					
					$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , checkid, txnid, memo, payment_status, payment_date, payer_mail, payer_fname, payer_lname, payer_country, gross,user_login, first_name,last_name, ip) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s);";
						$wpdb->query($wpdb->prepare($sql, $my2CO->ipnData['custom'], 'Successful Deposit',$my2CO->ipnData['cart_order_id'],$my2CO->ipnData['order_number'], '2Checkout Key: '.$my2CO->ipnData['md5_hash'], 'Completed', date('Y-m-d H:i:s'), $my2CO->ipnData['customer_email'], $my2CO->ipnData['customer_first_name'], $my2CO->ipnData['customer_last_name'], $my2CO->ipnData['residence_country'], $my2CO->ipnData['invoice_list_amount'],$user->user_login, $user->first_name, $user->last_name, $my2CO->ipnData['customer_ip'] ));
						
					$balance=get_usermeta($my2CO->ipnData['custom'],'balance');
					update_usermeta($my2CO->ipnData['custom'],'balance', $balance + $my2CO->ipnData['invoice_list_amount']);
					
					do_action('wwm_user_deposited', $my2CO->ipnData['custom'], $my2CO->ipnData['invoice_list_amount']);

				}
				else
				{
					$sql="INSERT INTO ".WWM_ORDERS_TABLE." (userid, status , checkid, txnid, memo, payment_status, payment_date, gross, ip) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s);";
					$wpdb->query($wpdb->prepare($sql, $my2CO->ipnData['custom'], 'Failed Deposit', $my2CO->ipnData['cart_order_id'],$my2CO->ipnData['order_number'],'2Checkout Key: '.$my2CO->ipnData['key'], 'Failed', date('Y-m-d H:i:s'), $my2CO->ipnData['total'], $_SERVER['REMOTE_ADDR'] ));
				}
			}
		break;

	}//end switch
}

if ($msg) 
echo '<div class="wwm-errormessage" >'.$msg.'</div>';	
		
if (!$hidden) {
	$b=get_usermeta($user_ID,'balance');
	echo '<p><strong>Balance: ';
	if ($b) 
		echo $b; 
	else 
		echo '0';
	echo ' '.get_option('wwm_paypal_currency_code').'</strong></p>';
	echo '<div class="wwm_deposid">';
	_e('Choose your payment method, enter your amount and click to payment.','wwm');
	 if ($min) echo 'Minimum: '.$min.' '.get_option('wwm_paypal_currency_code'); ?>
	<br/>
	<p><form name="wwm_deposit_form" method="post" id="wwm-members-form">

	<p><label><?php _e('Amount','wwm');?>:  <input type="text" style="width:60px;" name="payment_amount" value=""  > <?php echo get_option('wwm_paypal_currency_code');?></label></p>
	<label><input type="radio" name="payment_type" value="paypal" checked="checked"> PayPal</label><br/>
	<?php if (get_option('wwm_2co')) { ?>
	<label><input type="radio" name="payment_type" value="twoco" > 2CO</label>
	<?php } ?><br/><br/>
	<input type="submit" name="deposit_submit" value="<?php _e('Continue','wwm');?>" >
	</form></p>
    </div>
<?php 
	}//end hidden
?>