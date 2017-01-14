<?php

require_once('config.php');

if (!current_user_can('edit_pages') && !current_user_can('edit_posts')){

	wp_die(__("You are not allowed to be here", $domain));

}



	global $wpdb;

?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Shortcode Panel</title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />

	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>

	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

	<script language="javascript" type="text/javascript" src="<?php echo  get_template_directory_uri() ?>/lib/tinymceShortcodes/tinymce.js"></script>

	<base target="_self" />

<style type="text/css">

<!-- 

select#afl_shortcode_tag optgroup { font:bold 11px Tahoma, Verdana, Arial, Sans-serif;}

select#afl_shortcode_tag optgroup option { font:normal 11px/18px Tahoma, Verdana, Arial, Sans-serif; padding-top:1px; padding-bottom:1px;}

-->

</style>

</head>

<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';

document.getElementById('afl_shortcode_tag').focus();" style="display: none">

<!-- <form onsubmit="insertLink();return false;" action="#"> -->

	<form name="afl_tabs" action="#">

		<!-- gallery panel -->

		<div id="afl_shortcode_panel" class="panel current">

			<br />

			<table border="0" cellpadding="4" cellspacing="0">

				<tr>

					<td nowrap="nowrap"><label for="afl_shortcode_tag"><?php _e("Select Shortcodes", 'shortcodes'); ?></label></td>

					<td><select id="afl_shortcode_tag" name="afl_shortcode_tag" style="width: 200px">

						<option value="0">No Style!</option>

						<?php

							if(is_array($shortcode_tags)){

								$i=1;

								foreach ($shortcode_tags as $afl_shortcodekey => $short_code_value){

									if( stristr($short_code_value, 'user_')!== FALSE ){

										$afl_shortcode_name = str_replace('user_', '' ,$short_code_value);

										$afl_shortcode_names = str_replace('_', ' ' ,$afl_shortcode_name);

										$afl_shortcodenames = ucwords($afl_shortcode_names);

										echo '<option value="' . $afl_shortcodekey . '" >' . $afl_shortcodenames.'</option>' . "\n";

										echo '</optgroup>'; 

										$i++;

									}

								}

							}

						?>

						</select>

					</td>

				</tr>

			</table>

		</div>

		

		<div class="mceActionPanel">

			<div style="float: left">

				<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />

			</div>



			<div style="float: right">

				<input type="submit" id="insert" name="insert" value="Insert" onClick="aflshortcodesubmit();" />

			</div>

		</div>

	</form>

</body>

</html>

