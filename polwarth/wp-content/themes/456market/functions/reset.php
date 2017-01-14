<?php
global $woocommerce;
global $woocommerce_wishlist;
add_theme_support('woocommerce');
/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
include_once(TEMPLATEPATH. '/option-tree/ot-loader.php' );
/**
 * Theme Options
 */
include_once(TEMPLATEPATH. '/option-tree/theme-options.php' );

/* Localization
================================================== */
add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain( GETTEXT_DOMAIN, get_template_directory() . '/languages');
}
function lpd_woo_catalog($classes) {
	$classes[] = 'woo-catalog-456market';
	return $classes;
}
/* Feed Links
================================================== */
add_theme_support('automatic-feed-links');

/* content width
================================================== */
if ( ! isset( $content_width ) )
	$content_width = 620;  

/* Register WP Menus
================================================== */
function register_menu() {
	register_nav_menu('primary-menu', __('Primary Menu', GETTEXT_DOMAIN));
	register_nav_menu('secondary-menu', __('Secondary Menu', GETTEXT_DOMAIN));
	register_nav_menu('meta-menu', __('Meta Menu', GETTEXT_DOMAIN));
	register_nav_menu('footer-menu', __('Footer Menu', GETTEXT_DOMAIN));
}
add_action('init', 'register_menu');

// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
add_theme_support( 'post-thumbnails' );

if ( function_exists( 'add_theme_support' ) ) {
	set_post_thumbnail_size( 56, 56, true ); // Normal post thumbnails
	add_image_size( 'page-header', 1600, 430, true ); // page header
	add_image_size( 'front-page-header', 1600, 1060, true ); // page header
	add_image_size( 'default-page', 1170, 400, true ); // default page thumbnail (full-width)
	add_image_size( 'default-sidebar-page', 870, 400, true ); // sidebar page thumbnail
	add_image_size( 'blog-page', 800, 600, true ); // blog thumbnail
	add_image_size( 'client', 234, 150, true ); // client thumbnail
	add_image_size( 'team-member', 710, 710, true ); // team member thumbnail
	add_image_size( 'featured-widget-post-portfolio', 290, 365, true ); // featured front widget for posts & portfolio
	add_image_size( 'front-header-1', 870, 460, true ); // front 1 thumbnail
	add_image_size( 'front-header-2', 1170, 460, true ); // front 2 thumbnail
	add_image_size( 'shop', 570, 570, true ); // front shop thumbnail
	add_image_size( 'featured-widget-product-2', 350, 278, true ); // featured widget product-2 thumbnail
	add_image_size( 'product-callout', 210, 130, true ); // product callout thumbnail
	add_image_size( 'product', 580, 580, true ); // Product thumbnail
	add_image_size( 'mini-thumb', 90, 90, true ); // Mini thumbnail, for cart, woocommerce mini elements
}

// post format
add_theme_support( 'post-formats', array( 'link', 'video' ) );
add_post_type_support( 'portfolio', 'post-formats' );

?>