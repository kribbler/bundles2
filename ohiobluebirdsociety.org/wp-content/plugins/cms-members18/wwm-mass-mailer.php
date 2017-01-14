<?php
if ('wwm-mass-mailer-mu.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));
	

global $wpdb;

	if (isset($_GET['to']))
	 $to=$_GET['to'].', ';
	 

   if (!isset($_GET['type'])) { //HTML default
		add_filter( 'tiny_mce_before_init', 'wwm_mceinit');
		add_action('admin_footer', 'wp_tiny_mce');
	
		function wwm_mceinit($init) {
			
			$init['mode'] = 'specific_textareas';
			$init['editor_selector'] = 'mailcontent';
			$init['elements'] = 'mailcontent';
			$init['plugins'] = 'safari,inlinepopups,autosave,spellchecker,paste,wordpress,media,fullscreen';
			$init['theme_advanced_buttons1'] .= ',image';
			$init['theme_advanced_buttons2'] .= ',code';
			$init['onpageload'] = '';
			$init['width'] = '97%';
			$init['save_callback'] = '';
		
			return $init;
		}
	} //end 
	
	
	 if (isset($_POST['submit'])) {
		if ( (empty($_POST['content'])) || (empty($_POST['subject'])) ) {
			$msg='Body and Subject are required!';
		}else{
			
			$type=$_POST['type'];
			$subject=$_POST['subject'];
			$to=$_POST['to'].', ';
			$body=stripcslashes($_POST['content']);
			
			if (is_array($_POST['plans']))
			foreach ($_POST['plans'] as $plan)
				$plans[]=stripcslashes($plan);
				
			if ($type=='html')
				$body.='<p><small>powered by <a href="http://wpwave.com/plugins/cms-members/">CMS Members</a></small></p>';
			else
				$body.="\n\npowered by CMS Members \n";
			
			wwm_mail_actions($type); //set actions
			
			$mails=$wpdb->get_results("SELECT ID, user_email FROM ".$wpdb->users." ;");
			
			if ('all, '==$to) {
				$to='';
				foreach ($mails as $mail)
						$to.= $mail->user_email.', ';
				
			}elseif ($plans){
				foreach ($mails as $mail){
					if ((in_array(get_usermeta($mail->ID, 'plan_id'), $plans))&& (!get_usermeta($mail->ID,'status')) ) {
						$to.= $mail->user_email.', ';
					}
				}
			}
				
			$to=str_replace(',,',',',$to);
			$to=str_replace(', ,',', ',$to);
			$to=substr($to, 0, strlen($to)-2 ); 		
			$to_arr=explode(',', $to);

			if ($_FILES['attach1']['tmp_name'])
				rename($_FILES['attach1']['tmp_name'],$_FILES['attach1']['name']);

			foreach ($to_arr as $t) {
				if ( wp_mail($t, $subject, $body, '', $_FILES['attach1'])) 
					$too.=$t.' ,';
			}
			
			if ($too)
				$msg='Email(s) successfully sent: <br> '.$too;
			else
            	$msg='There is a problem. Ask your host support about php mail function or check addresses';
				
		}		?>
        <div class="wrap">
            <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div>   </div><?php } ?></div>
         <?php
	}else{
	
	?>
<div class="wrap">
        <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } ?>
        
<h2>Mass Mailer for Members</h2>

<table width="100%"><tr><td valign="top">

      <form method="post" name="mass-mailer" enctype="multipart/form-data" >
        
            <div id="titlediv">
            <div id="titlewrap">
            <label for="subject">Subject</label><br/>
            <input type="text" name="subject" class="" id="title" autocomplete="off" value="<?php  if(isset($_POST['subject'])) echo $_POST['subject'];?>" style="width:97%"/>
             </div></div>
            
            
             <div class="form-field">
                 <label >To</label><br/>
             
         
            <textarea name="to" rows="2" style="width:97%"><?php echo $to; ?></textarea>
            
        	<br/> <small>Type: 'all' for all members or seperate addresses with comma (,)</small>
        	<p></p>
         </div>
           	
            
            
            
            <div class="form-field">
                <label for="content"></label><br/>
                <textarea name="content" rows="15" style="width:97%" class="mailcontent" ><?php if(isset($_POST['content'])) echo stripslashes($_POST['content']); ?></textarea>
            </div>
        <p>&nbsp;</p>
        
       		
    <div id='poststuff' style="width:97%">
     		<div class="postbox">
                <h3>Attachment File</h3>
              <div class="inside">
               
<input type="file" name="attach1"  >


                <p></p>
           	 </div>
            </div>
            </div>
            
	 
</div>
</td><td width="250px" valign="top">
<?php $planlist = $wpdb->get_results("SELECT id,title FROM ".WWM_PLANS_TABLE." WHERE plantype='membership' "); ?>
 <div id='poststuff'>

      <div class="postbox">
      <h3>Send</h3>
     <div class="inside">
      <?php if (!isset($_GET['type'])) { ?>
              <div class="misc-pub-section" >Format: <strong>HTML</strong>  <a style="text-decoration:none" href="admin.php?page=<?php echo $_GET['page'];?>&amp;type=plain"><input type="button" class="button" value="Switch to Plain Text" /></a> </div>
              
            	 <input type="hidden" name="type"  value="html" />
         <?php }else { ?>
                
                 <div class="misc-pub-section" >Format: <strong>Plain Text</strong>  <a style="text-decoration:none" href="admin.php?page=<?php echo $_GET['page'];?>">		                  <input type="button" class="button" value="Switch to HTML" /></a> </div>
                 
                 <input type="hidden" name="type" value="plain" />
                 
                 
          <?php } ?>
          
          
      
      
      </div>
     <p></p>
     
<div id="major-publishing-actions">
<div id="delete-action">
</div>
<div id="publishing-action">
		<input class="button-primary" name="submit" type="submit" value="Send Now">
</div>
<div class="clear"></div>
</div>



      </div>
      
     <div class="postbox">
     <h3>To Plans</h3>
     <div class="inside">
     <p>Choose plans.</p>
      <ul style="padding-left:10px;">
      <?php if ($planlist) {
	  			foreach ($planlist as $theplan) {
                	echo '<li><label><input type="checkbox" name="plans[]" value="'.$theplan->id.'" /> '.$theplan->title .'</label></li>';
				}
			}else{ ?>
      		 <li>No Plan Currently</li>
      <?php } ?>
      </ul>
      <p>&nbsp;</p>
      <p> <small>Only active accounts will recieve email.</small></p>
      </div>
      </div>
      
 </div>
</div>
</td></tr>
</table>
</form>

<?php } ?>