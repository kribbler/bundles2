<?php
function lpd_woocommerce_styles() {
	wp_enqueue_style('woocommerce');
}
function easypiechart() {
	wp_enqueue_script('easypiechart');	
}

function lpd_owl_carousel() {
	wp_enqueue_style('owl_carousel');
	wp_enqueue_script('owl_carousel');
}
function vc_admin() {

    // visual composer front admin
    wp_register_style('vc-extend-front', get_template_directory_uri() . '/functions/vc/assets/vc_extend_front.css');
    // visual composer front admin end
    
	wp_enqueue_style('vc-extend-front');
}
add_action( 'admin_enqueue_scripts', 'vc_admin' );

function lpd_ie_selectivizr() {
	global $is_IE;
	if ( $is_IE ) {
		echo '<!--[if IE 8]>';
		echo '<script src="'.THEME_ASSETS.'js/selectivizr.js"></script>';
		echo '<![endif]-->';
	}
}
add_action( 'wp_head', 'lpd_ie_selectivizr' );

function lpd_ie_html5() {
	global $is_IE;
	if ( $is_IE ) {
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
	}
}
add_action( 'wp_head', 'lpd_ie_html5' );

function lpd_fix_ie_css_limit() {
	global $is_IE;
	if ( $is_IE ) {
		echo '<!--[if IE]>';
		echo '<script src="'.THEME_ASSETS.'js/fix-ie-css-limit-standalone.min.js"></script>';
		echo '<![endif]-->';
	}
}
add_action( 'wp_footer', 'lpd_fix_ie_css_limit',99 );

function multi_slider() {
	wp_enqueue_script('custom_modernizr');
	wp_enqueue_script('multi_slider');
}

function lpd_sticky_menu() {
	wp_enqueue_script('sticky-menu');
}

function lpd_fixed_1170() {
	wp_enqueue_script('non-responsive-js');
	wp_enqueue_style('non-responsive-css');
}

function cre_animate() {
	wp_enqueue_script('cre-animate');
}

?>