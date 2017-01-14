<?php
global $woocommerce;
#global $woocommerce_wishlist;
add_theme_support('woocommerce');
/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
include_once(TEMPLATEPATH. '/option-tree/theme-options.php' );

/**
 * Vc set as theme
 */
add_action( 'vc_before_init', 'your_prefix_vcSetAsTheme' );
function your_prefix_vcSetAsTheme() {
	vc_set_as_theme();
}

/* Localization
================================================== */
add_action('after_setup_theme', 'lpd_theme_setup');
function lpd_theme_setup(){
    load_theme_textdomain( GETTEXT_DOMAIN, get_template_directory() . '/languages');
}
add_filter('body_class','lpd_body_class');
function lpd_body_class($classes) {
	$classes[] = 'wordpress-456repair';
	return $classes;
}

add_filter('body_class','lpd_boxed_style');
function lpd_boxed_style($classes) {

	$theme_style = ot_get_option('theme_style');
	
	if($theme_style=="boxed"){
		$classes[] = 'boxed';
	}
	else{
		$classes[] = '';
	}
	return $classes;
}
add_filter('body_class','lpd_fixed_layouts');
function lpd_fixed_layouts($classes) {

	$type_layouts = ot_get_option('type_layouts');
	
	if($type_layouts=="fixed"){
		$classes[] = 'lpd_fixed_layouts';
	}
	else{
		$classes[] = '';
	}
	return $classes;
}
/* read shortcode in text widget
================================================== */
add_filter('widget_text', 'do_shortcode');

/* Feed Links
================================================== */
add_theme_support('automatic-feed-links');

/* content width
================================================== */
if ( ! isset( $content_width ) )
	$content_width = 620;  

/* Register WP Menus
================================================== */
function lpd_register_menu() {
	register_nav_menu('primary-menu', __('Primary Menu', GETTEXT_DOMAIN));
	register_nav_menu('left-meta-menu', __('Left Header Meta Menu', GETTEXT_DOMAIN));
	register_nav_menu('right-meta-menu', __('Right Header Meta Menu', GETTEXT_DOMAIN));
	register_nav_menu('footer-menu', __('Footer Menu', GETTEXT_DOMAIN));
}
add_action('init', 'lpd_register_menu');

// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
add_theme_support( 'post-thumbnails' );

if ( function_exists( 'add_theme_support' ) ) {
	set_post_thumbnail_size( 100, 100, true ); // Normal post thumbnails
	add_image_size( 'portfolio-page', 870, 653, true ); // portfolio image
	add_image_size( 'cubeportfolio', 600, 400, true ); // cubeportfolio
	add_image_size( 'cubeportfolio-project', 1024, 768, true ); // cubeportfolio project
	
	add_image_size( 'default-page', 1170, 400, true ); // default page image (full-width)
	add_image_size( 'default-sidebar-page', 870, 400, true ); // sidebar page image
	
	add_image_size( 'featured-module', 580, 878, true ); // featured module image
	add_image_size( 'module', 580, 282, true ); // module image
	add_image_size( 'front-shop-thumb', 580, 773, true ); // front shop thumbnail
	add_image_size( 'front-shop-thumb2', 580, 580, true ); // front shop thumbnail (square)
	#add_image_size( 'brand-logo', 580, 435, true ); // brand logo
	
	add_image_size( 'multi-module', 263, 690, true ); // multi module
	add_image_size( 'multi-module1', 555, 360, true ); // multi module
	add_image_size( 'multi-module2', 262, 360, true ); // multi module
	add_image_size( 'multi-module3', 262, 300, true ); // multi module
	add_image_size( 'multi-module4', 555, 300, true ); // multi module

}

// post format
add_theme_support( 'post-formats', array( 'link', 'video' ) );
add_post_type_support( 'portfolio', 'post-formats' );

?>