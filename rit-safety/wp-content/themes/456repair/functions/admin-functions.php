<?php

function lpd_add_admin_scripts( $hook ) {

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {    
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('custom-js', get_template_directory_uri().'/functions/metabox/js/custom-js.js');
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/functions/metabox/css/jquery-ui-custom.css');
    }
}
add_action( 'admin_enqueue_scripts', 'lpd_add_admin_scripts', 10, 1 );

?>