<?php
/**
 * Plugin Name: Shortcode Button
 * 
 * Author: WooThemes & lidplussdesign
 * Author URI: http://woothemes.com
 * Modified by: lidplussdesign
 * Description: Plugin created on woocommerce base.
 * License: GPL.
 */
?>
<?php

/* shortcode button in post editor
================================================== */
function theme_add_shortcode_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;
	if ( get_user_option('rich_editing') == 'true') :
		add_filter('mce_external_plugins', 'theme_add_shortcode_tinymce_plugin');
		add_filter('mce_buttons', 'theme_register_shortcode_button');
	endif;
}

function theme_register_shortcode_button($buttons) {
	array_push($buttons, "|", "theme_shortcodes_button");
	return $buttons;
}

function theme_add_shortcode_tinymce_plugin($plugin_array) {
	global $theme;
	$plugin_array['ThemeShortcodes'] = get_template_directory_uri() .'/admin/js/editor_plugin.js';
	return $plugin_array;
}

function theme_refresh_mce($ver) {
	$ver += 3;
	return $ver;
}
 /* icon
================================================== */
function theme_admin_menu_styles() {
	global $theme;
	wp_enqueue_style( 'theme_admin_menu_styles', get_template_directory_uri() . '/admin/css/tinymce.css' );
}
add_action( 'admin_print_styles', 'theme_admin_menu_styles' );

 /* add shortcode button
================================================== */
add_action( 'init', 'theme_add_shortcode_button' );
add_filter( 'tiny_mce_version', 'theme_refresh_mce' );

?>