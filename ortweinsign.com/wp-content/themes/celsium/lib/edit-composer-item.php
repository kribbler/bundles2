<?php
    define('WP_USE_THEMES', false);
    require('../../../../wp-load.php');
    if (!current_user_can('edit_pages') && !current_user_can('edit_posts')){
	wp_die(__("You are not allowed to be here", $domain));
    }
?>
<?php
    $index = (array_keys($_POST['itemtype']));
    $index = $index[0];
    $data = array();
    $_POST['itemdata'][$index] = base64_decode(stripslashes($_POST['itemdata'][$index]));

    if( strlen($_POST['itemdata'][$index]) > 0 && unserialize($_POST['itemdata'][$index]) ){
        $data = unserialize($_POST['itemdata'][$index]);
    }
    $type = $_POST['itemtype'][$index];
	$name = $_POST['itemname'][$index];
?>
<div id="afl-edit-composer-item-form">
	<script>
		//jQuery('#afl-edit-composer-item-form select').selectbox();
		check();
	</script>
    <input type="hidden" name="index" value="<?php print $index; ?>" />
    <input type="hidden" name="type" value="<?php print $type; ?>" />
    <?php
        switch($_POST['itemtype'][$index]){
			case 'flex-slider':
				require_once 'items/flex_slider.php';
				break;
            case 'text_slider':
                require_once 'items/text_slider.php';
                break;
            case 'full_width':
                require_once 'items/full_width.php';
                break;
            case '2_columns':
                require_once 'items/2_column.php';
                break;
			case 'one_third_block':
                require_once 'items/2_column.php';
                break;
			case 'one_third_last_block':
                require_once 'items/2_column.php';
                break;
            case '3_columns':
                require_once 'items/3_column.php';
                break;
            case '4_columns':
                require_once 'items/4_column.php';
                break;
            case 'slogan':
                require_once 'items/slogan.php';
                break;
			case 'divider':
                require_once 'items/divider.php';
                break;
			case 'recent_projects':
				require_once 'items/recent_projects.php';
				break;
			case 'advanced_recent_projects':
				require_once 'items/advanced_recent_projects.php';
				break;
			case 'recent_posts':
                require_once 'items/recent_posts.php';
                break;
			case 'advanced_recent_posts':
				require_once 'items/advanced_recent_posts.php';
				break;
            case 'posts_strip':
                require_once 'items/posts_strip.php';
                break;
            case 'sidebar':
                require_once 'items/sidebar.php';
                break;
        }
    ?>
   <div class="controls"><span class="save-bt"><a href="#" class="button-primary afl-save"><?php print __('Save',$domain); ?></a></span>
   <span class="save-bt"><a href="#" class="button afl-cancel"><?php print __('Cancel',$domain); ?></a></span></div>
</div>


