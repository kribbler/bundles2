<?php
if ('wwm-fields.php' == basename($_SERVER['SCRIPT_FILENAME']))
     die ('<h2>Direct File Access Prohibited</h2>');
	 
if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

global $wpdb;

	$list=get_option('wwm_main_fields');
	$msg='';
	if  (isset($_POST['mainfield-submit']))  {
	
		if ( ($_POST['req']) && (!$_POST['show'])) $msg='Can be a hidden field require?!';
		if ( empty($_POST['name']) ) $msg='Please choose a name for the field';
		
		if ($_POST['req'])$req=1; else $req=0;
		if ($_POST['show'])$show=1; else $show=0;
		
		if (!$msg) {
		$list=get_option('wwm_main_fields');
		$list[$_GET['edit_mainfield_id']][name]=$_POST['name'];
		$list[$_GET['edit_mainfield_id']][desc]=$_POST['desc'];
		$list[$_GET['edit_mainfield_id']][req]=$req;
		$list[$_GET['edit_mainfield_id']][show]=$show;
		
		update_option('wwm_main_fields',$list);
		$list=get_option('wwm_main_fields');
		$msg="Field successfully updated";
		}
	}
	
	if  (isset($_POST['addfield-submit']))  {
	
		if ($_POST['req'])$req=1; else $req=0;
		if ($_POST['show'])$show=1; else $show=0;
		
		if ( (empty($_POST['label'])) || (empty($_POST['type'])) ) { $msg='Please fill all of required fields!';
		}elseif( (!empty($_POST['order'])) && (!is_numeric($_POST['order']))  ) { $msg="Field Order should be number!";
		}elseif( ($_POST['req']) && (!$_POST['show']) ) {$msg='You can\'t set a hidden filed required!';
		}else{
		$label=stripslashes($_POST['label']);
		$options= explode('#',trim($_POST['options'], " \n\t\r\0\x0B\#")) ;
		$options=serialize($options);
		$regex=$_POST['regex'];
		$desc=stripslashes($_POST['desc']);
		$order=$_POST['order'];
		$display=$_POST['show'];
		$req=$_POST['req'];
		$type=$_POST['type'];
		$pagetype='registration';
		
		$sql="INSERT INTO ".WWM_FIELDS_TABLE." (label, regex, display, req, fieldtype, description, options, fieldorder,pagetype) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s);";
		$wpdb->query($wpdb->prepare($sql,$label,$regex,$display,$req,$type,$desc,$options,$order,$pagetype));
		$msg='Field successfully added!';
		}	
	}
	
	if (isset($_POST['customfield-submit'])) {
	
		if ($_POST['req'])$req=1; else $req=0;
		if ($_POST['show'])$show=1; else $show=0;
		
		if ( (empty($_POST['label'])) || (empty($_POST['type'])) ) { $msg='Please fill all of required fields!';
		}elseif( (!empty($_POST['order'])) && (!is_numeric($_POST['order']))  ) { $msg="Field Order should be number!";
		}elseif( ($_POST['req']) && (!$_POST['show']) ) {$msg='You can\'t set a hidden field required!';
		}else{
		$label=stripslashes($_POST['label']);
		$type=stripslashes($_POST['type']);
		
		$options= explode('#',trim($_POST['options'], " \n\t\r\0\x0B\#")) ;
		$options=serialize($options);
		$regex=stripslashes($_POST['regex']);
		$desc=stripslashes($_POST['desc']);
		$order=stripslashes($_POST['order']);
		$display=stripslashes($_POST['show']);
		$req=stripslashes($_POST['req']);
		$pagetype='registration';
		$sql="UPDATE ".WWM_FIELDS_TABLE." SET label=%s, regex='%s' ,display='%s', req=%s ,fieldtype=%s ,description='%s', options='%s', fieldorder='%s' ,pagetype=%s WHERE id=%s;";
		$wpdb->query($wpdb->prepare($sql,$label,$regex,$display,$req,$type,$desc,$options,$order,$pagetype,$_GET['edit_customfield_id']));
		$msg='Field successfully updated!';
		}	
	}
	
	if (isset($_GET['delete_customfield_id']) ) {
		$wpdb->query($wpdb->prepare("DELETE FROM ".WWM_FIELDS_TABLE." WHERE `id` = %s LIMIT 1",$_GET['delete_customfield_id']));
		$msg='Field successfully deleted!';
	}
	?>
	<div class="wrap">
	  <?php if($msg) { ?><div id="message" class="updated fade"><p><?php echo $msg;?></p></div><?php } 
	  
	if ( (isset($_GET['edit_mainfield_id'])) && (is_numeric($_GET['edit_mainfield_id'])) && (!$msg) ) { ?>
	
			<h3>Edit Fields</h3>
			<div class="form-wrap">
	 
			<form method="post">
			
			<div class="form-field">
			<label>Label</label>
			<input name="name"  style="width:250px" value="<?php echo esc_attr($list[$_GET['edit_mainfield_id']][name]); ?>"/>
			</div>
			
			 <div class="form-field">
			<label>Description(optional)</label>
			<input name="desc" style="width:250px" value="<?php echo esc_attr($list[$_GET['edit_mainfield_id']][desc]); ?>"/>
			</div>
			
			<label>
			<input type="checkbox" value="1"  name="show" <?php if ($list[$_GET['edit_mainfield_id']][show])echo 'checked="checked"'; ?>/> Show in registration page?</label><br />
			<label>
			<input type="checkbox" value="1" name="req" <?php if ($list[$_GET['edit_mainfield_id']][req])echo 'checked="checked"'; ?>/> Is it required field?</label><br /><br />
			<input name="mainfield-submit" class="button" type="submit" /> | <a  title="Cancel and go to Fields page" href="?page=<?php echo $_GET['page']; ?> ">Go Back</a><br/><p>Note:<br/> -If you choose CAPTCHA and Terms to show they will be required even if you don't want. Also username and mail.
        <br/>-Here is an example that shows only 'order' type plans with some default values:<br/> www.site.com/register/?type=order&plan=2&email=info@test.com&username=testuser&country=Iran&promocode=1234  </p>
			</form> 
			
	<?php 
	}elseif ( (isset($_GET['edit_customfield_id'])) && (is_numeric($_GET['edit_customfield_id'])) && (!$msg)) { ?>
	
			<h2>Edit Fields</h2>
	<?php $thefield = $wpdb->get_results("SELECT label,display,req,regex,fieldtype,description,options,fieldorder,pagetype FROM ".WWM_FIELDS_TABLE." WHERE id={$_GET['edit_customfield_id']};" ); 
	
			if (!$thefield) {echo 'Not found any thing';}else{
				foreach ($thefield as $field) { ?>
			<div class="form-wrap">
			<form method="post">
	   
			<div class="form-field">
			<label>Label</label>
			<input name="label" style="width:200px" value="<?php echo esc_attr($field->label);?>"/></div>
		
			<div class="form-field">
			<label>Field Type</label>
			<select name="type" class='postform' id='fieldtype'><option value="text" <?php if( $field->fieldtype=='text') echo 'selected="selected"';?> >Text</option>
			
			
			
									 <option value="checkbox" <?php if( $field->fieldtype=='checkbox') echo 'selected="selected"';?>>Check box</option>
									 <option value="radio" <?php if( $field->fieldtype=='radio') echo 'selected="selected"';?>>Radio</option>
									 <option value="dropdown" <?php if( $field->fieldtype=='dropdown') echo 'selected="selected"';?>>Drop Down</option>
									 <option value="file" <?php if( $field->fieldtype=='file') echo 'selected="selected"';?>>File Upload</option>
									 <option value="textarea" <?php if( $field->fieldtype=='textarea') echo 'selected="selected"';?>>Text Area</option>
									 
			</select></div>
			
			<div class="form-field" id="fieldoptions">
			<label id='options-label'>Field Options</label>
			<label id='field-type-label'>File Types</label>
			<input name="options" style="width:200px" value="<?php $optionslist=unserialize($field->options);foreach ($optionslist as $option) if ($option) echo $option.'#'; ?>"/><p id='options-comment'>Seperate with # (As an example for a radio or dropdown type: Male#Female)</p><p id='field-type-comment'>Seperate with # (e.g. jpg#jpeg#gif#png)</p></div>
			
			<!--<div class="form-field">
			
			<label>Regex</label>
			<input name="regex" style="width:200px" value="<?php echo $field->regex;?>"/></div>
			<small>Only for advanced users. This feature is under testing.</small> <a id='regex-example'>Some working examples</a>
			
			<div id="regex-example-div">
			
			</div>-->
	   
			<div class="form-field">
			<label>Description(optional)</label>
			<input name="desc" style="width:200px" value="<?php echo esc_attr($field->description);?>"/></div>
			
			<div class="form-field">
			<label>Field Order</label>
			<input name="order" style="width:200px" value="<?php echo $field->fieldorder;?>"/></div>
			
			
			<label>
			<input type="checkbox" value="1" id="show"  name="show" <?php if( $field->display=='1') echo 'checked="checked"';?> /> Show in registration page?</label> <br />
			<label> 
			<input type="checkbox" value="1" name="req" id="req" <?php if( $field->req=='1') echo 'checked="checked"';?> /> Is it required?</label><br />
			<input name="customfield-submit" class="button" type="submit" /> | <a  title="Cancel and go to Fields page" href="?page=<?php echo $_GET['page']; ?>">Go Back</a>
			</form></div> 
			
			<?php }
			}
	 } else{

?>
	<h2>Manage Custom Fields</h2>
	<p>Here you can add new fields to your registration page.</p>
	 <h3>Standard Fields</h3>
	   <table class="widefat">
	   
	<thead>
	<tr class="thead">
		<th class="posts column-posts num">ID</th>
		<th>Label</th>
		<th>Show</th>
		<th >Require</th>
		<th>Actions</th>
	</tr>
	</thead>
	
	<tfoot>
	
	<tr class="tfoot">
		<th class="posts column-posts num">ID</th>
		<th>Label</th>
		<th>Show</th>
		<th >Require</th>
		<th>Actions</th>
	</tr>
	</tfoot>
	
	<tbody id="fields" class="list:field field-list">
	<?php
	$mainfieldlist=get_option('wwm_main_fields');
	

	for ($i=0;$i<='101' ;$i++) {
			if ($mainfieldlist[$i][name]) {
	?>
                <tr id='user-<?php echo $i;?>' class="alternate" >
                    
                    <th scope='row' class="posts column-posts num"><?php echo $i;?></th>
                    <td><strong><a title="click to edit" href="?page=<?php echo $_GET['page'];?>&edit_mainfield_id=<?php echo $i;?>"><?php echo esc_attr($mainfieldlist[$i][name]); ?></a></strong></td>
                    <td><?php if($mainfieldlist[$i][show])echo '<img src="'.get_option('siteurl').'/wp-admin/images/yes.png'.'" alt="Yes" />';else echo '<img src="'.get_option('siteurl').'/wp-admin/images/no.png'.'" alt="No" />';?></td>
                    <td><?php if($mainfieldlist[$i][req])echo '<img src="'.get_option('siteurl').'/wp-admin/images/yes.png'.'" alt="Yes" />';else echo '<img src="'.get_option('siteurl').'/wp-admin/images/no.png'.'" alt="No" />';?></a></td>
                      
                    <td>
                    <a href="?page=<?php echo $_GET['page'];?>&edit_mainfield_id=<?php echo $i; ?>" title="View/Edit field details">Edit</a>        </td>
                </tr>
	
	<?php }
	} //end foreach 
	echo '</tbody>
	</table><p>&nbsp;</p>
	 <h3>Custom Fields</h3>
	<table class="widefat">
	
	<thead>
	<tr class="thead">
		<th class="posts column-posts num">ID</th>
		<th>Label</th>
		<th>Show</th>
		<th >Require</th>
		<th>Field Type </th>
		<th class="posts column-posts num">Order </th>
		<th>Actions</th>
	</tr>
	</thead>
	
	<tfoot>
	<tr class="tfoot">
		<th class="posts column-posts num">ID</th>
		<th>Label</th>
		<th>Show</th>
		<th >Require</th>
		<th>Field Type </th>
		<th class="posts column-posts num">Order </th>
		<th>Actions</th>
	</tr>
	</tfoot>
	
	<tbody id="fields" class="list:field field-list">';
	
	$fieldlist = $wpdb->get_results("SELECT id,label,display,req,fieldtype,fieldorder FROM ".WWM_FIELDS_TABLE." WHERE pagetype='registration'" ); 
		if (!$fieldlist) {echo '<tr><td>There is no field list now</td></tr>';}else{
			foreach ($fieldlist as $field) {
	?>
		<tr id='field-<?php echo  $field->id;?>' class="alternate" >
			<th scope='row' class="posts column-posts num"><?php echo  $field->id;?></th>
			<td><strong><a title="click to edit" href="?page=<?php echo $_GET['page'];?>&edit_customfield_id=<?php echo $field->id; ?>"><?php echo esc_attr($field->label);?></a></strong></td>
			<td ><?php if($field->display)echo '<img src="'.get_option('siteurl').'/wp-admin/images/yes.png'.'" alt="Yes" />';else echo '<img src="'.get_option('siteurl').'/wp-admin/images/no.png'.'" alt="No" />';?></td>
			<td ><?php if($field->req)echo '<img src="'.get_option('siteurl').'/wp-admin/images/yes.png'.'" alt="Yes" />';else echo '<img src="'.get_option('siteurl').'/wp-admin/images/no.png'.'" alt="No" />';?></a></td>
			<td> <?php echo  $field->fieldtype;?></td>
			<td class="posts column-posts num"><?php echo  $field->fieldorder;?> </td>     
			<td >
			<a href='?page=<?php echo $_GET['page'];?>&edit_customfield_id=<?php echo $field->id; ?>' title="View/Edit field details ">Edit</a> | 
			<a onClick="if ( confirm('You are about to delete a field \n \'Cancel\' to stop, \'OK\' to delete.') ) { return true;}return false;" href="?page=<?php echo $_GET['page'];?>&delete_customfield_id=<?php echo $field->id; ?>" title="Delete field ">Delete</a>        </td>
		</tr>
	<?php
			}
		}
	?>
	</tbody>
	</table> 
	<p>&nbsp;</p>
			
	<div class="form-wrap">
	<h3>Add a custom field</h3>
	
	<form method="post" style="width:400px" name="add-field">
	<div class="form-field">
			<label>Label</label>
			<input name="label"  value="" style="width:250px"/>
			<p></p>
	</div>
			
	<div class="form-field">
			<label>Field Type</label>
			<select name="type" class='postform' id='fieldtype'><option value="text" >Text</option>
									 <option value="checkbox" >Check Box</option>
									 <option value="radio" >Radio</option>
									 <option value="dropdown" >Drop Down</option>
									 <option value="file" >File Upload</option>
									 <option value="textarea" >Text Area</option>
									 
			</select></div>
			
			<div class="form-field" id="fieldoptions">
			<label id='options-label'>Field Options</label>
			<label id='field-type-label'>File Types</label>
			<input name="options" style="width:200px" value=""/><p id='options-comment'>Seperate with # (As an example for a radio or dropdown type: Male#Female)</p><p id='field-type-comment'>Seperate with # (e.g. jpg#jpeg#gif#png)</p></div>
			
			<!--<div class="form-field">
			
			<label>Regex</label>
			<input name="regex" style="width:200px" value=""/></div>

			<small>Only for advanced users. This feature is under testing.</small> <a id='regex-example'>Some working examples</a>
			
			<div id="regex-example-div">
			
			</div>-->
	   
			<div class="form-field">
			<label>Description(optional)</label>
			<input name="desc" style="width:200px" value=""/></div>
			
			<div class="form-field">
			<label>Field Order</label>
			<input name="order" style="width:200px" value=""/>
            <p id='options-comment'>Custom fields will be shown before Country.</p>
            </div>
			
			<!--
	<div class="form-field">
			<label>Regex</label>
			<input name="regex" style="width:250px" value=""/>
			<p></p> 
	</div>-->
	
			<label>
			<input type="checkbox" value="1"  name="show" /> Show in registration page?</label>
			<label>
			<input type="checkbox" value="1" name="req" /> Is it required?</label><br />
			<input name="addfield-submit" type="submit" class="button" value="Add Custom Field" />
			</form> 

	</div>
	<?php
	}

?>