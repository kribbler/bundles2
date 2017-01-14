<?php

if (!defined(TEMPLATEURL)){
    define('TEMPLATEURL', get_template_directory_uri());
}

require_once TEMPLATEPATH . '/lib/defaults.php';
require_once TEMPLATEPATH . '/lib/utillity.php';
require_once TEMPLATEPATH . '/lib/options.php';
require_once TEMPLATEPATH . '/lib/shortcodes.php';


function afl_admin_print_styles_hook(){
    wp_enqueue_style('admin-custom-style', TEMPLATEURL.'/lib/css/admin-style.css');
	wp_enqueue_style('new-admin-style', TEMPLATEURL.'/lib/css/new-admin-style.css');
	wp_enqueue_style('colorpicker', TEMPLATEURL.'/lib/css/colorpicker.css');
	wp_enqueue_style('selectbox', TEMPLATEURL.'/lib/css/jquery.selectbox.css');
	wp_enqueue_style('prettyPhoto', TEMPLATEURL.'/css/prettyPhoto.css');
	wp_enqueue_style('checkbox', TEMPLATEURL.'/lib/css/ch-but.css');
	wp_enqueue_style('Droid+Sans', "http://fonts.googleapis.com/css?family=Droid+Sans");
}
add_action("admin_print_styles", 'afl_admin_print_styles_hook');

function afl_admin_print_scripts_hook(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('jquery-ui-accordion');
    
    wp_enqueue_script('ajaxupload', TEMPLATEURL.'/lib/js/ajaxupload.js', array('jquery'));
    
    wp_enqueue_script('admin-custom-script', TEMPLATEURL.'/lib/js/admin-script.js');
	
    wp_enqueue_script('tooltip-admin', TEMPLATEURL.'/lib/js/tooltip.js');
	//wp_enqueue_script('color-picker', TEMPLATEURL.'/lib/js/colorpicker.js');
	wp_enqueue_script('selectbox', TEMPLATEURL.'/lib/js/jquery.selectbox-0.6.1.js');
	wp_enqueue_script('prettyPhoto', TEMPLATEURL.'/js/jquery.prettyPhoto.js');
	wp_enqueue_script('checkbox', TEMPLATEURL.'/lib/js/ch-script.js');
	wp_enqueue_script('imagepreloader', TEMPLATEURL.'/lib/js/imagepreloader.js');
    
}
add_action("admin_print_scripts", 'afl_admin_print_scripts_hook');

add_action('wp_ajax_afl_ajax_upload_action', 'afl_ajax_upload_action_hook');



function afl_ajax_upload_action_hook() {
    if($_POST['type'] == 'image_upload'){
        $file = $_FILES[$_POST['id']];
        if($file){
            $file['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $file['name']);
            $uploaded_file = wp_handle_upload($file,array('test_form'=>false, 'action'=>'wp_handle_upload'));
            $json = null;
            if(count($uploaded_file['error'])){
                $json = array('status'=>0,'data'=>$uploaded_file['error']);
            }
            else{

                $json = array('status'=>1,'data'=>$uploaded_file['url']);
                if(filter_var($_POST['dothumbs'], FILTER_VALIDATE_BOOLEAN)){
                    $pi = pathinfo($uploaded_file['file']);
                    $thumb_path = image_resize($uploaded_file['file'],200,150,true,'bgthumb');
                    if(is_string($thumb_path)){
                    	$json['thumb'] = get_option('siteurl').'/'.str_replace(ABSPATH, '', $thumb_path);
                    }
                }
            }
            print json_encode($json);
        }
        exit;
    }
    elseif($_POST['type'] == 'get_composer_data'){
        $items = afl_get_te_data($_POST['post_ID'], 'afl_composer_data');
        if(isset($items)){
             print(json_encode(afl_to_shortcode($items)));
        }
        exit;
    }
}

function afl_media_upload_library_hook(){
    if(isset($_REQUEST[send])){
        //put scripts
        print '<script language="javascript" type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/tinymce/tiny_mce_popup.js"></script>';
	print '<script language="javascript" type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/tinymce/utils/form_utils.js"></script>';
        echo '<script type="text/javascript">
    /* <![CDATA[ */
    window.onload = function(){tinyMCEPopup.close();};
    /* ]]> */  
    </script>';
    }
    
}
add_action('media_upload_library', 'afl_media_upload_library_hook', 10);

require_once TEMPLATEPATH . '/lib/metaboxes.php';
require_once TEMPLATEPATH . '/lib/post-types.php';
require_once TEMPLATEPATH . '/lib/tinymceShortcodes/init.php';
require_once TEMPLATEPATH . '/lib/tinymceInsertImage/init.php';
//including custom background
require_once TEMPLATEPATH . '/lib/theme-backgrounds.php';

?>