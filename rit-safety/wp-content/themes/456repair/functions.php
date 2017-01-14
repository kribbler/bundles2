<?php

/* URI shortcuts
================================================== */
define( 'THEME_ASSETS', get_template_directory_uri() . '/assets/', true );
define( 'TEMPLATEPATH', get_template_directory_uri(), true );
define( 'GETTEXT_DOMAIN', '456repair' );

require_once dirname( __FILE__ ) . '/functions/reset.php';

require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-activation.php';
require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-register.php';


/* Register and load JS, CSS
================================================== */
function lpd_enqueue_scripts() {

    wp_register_style('woocommerce', THEME_ASSETS . 'css/woocommerce.css');
    
	wp_register_style('non-responsive-css', THEME_ASSETS . 'css/non-responsive.css');
    wp_register_script('non-responsive-js', THEME_ASSETS.'js/non-responsive.js', false, false, true);
    
	// register scripts;
    wp_register_script('bootstrap', THEME_ASSETS.'js/bootstrap.js', false, false, true);
    wp_register_script('custom', THEME_ASSETS.'js/lpd-custom.js', false, false, true);
    wp_register_script('sticky-menu', THEME_ASSETS.'js/sticky_menu.js', false, false, true);
    wp_register_script('menu3d', THEME_ASSETS.'js/menu3d.js', false, false, true);
    
    
    wp_register_script('stellar', THEME_ASSETS.'js/jquery.stellar.min.js', false, false, true);
    
    // cube
	wp_register_script('cubeportfolio', THEME_ASSETS.'cbp-plugin/cubeportfolio/js/jquery.cubeportfolio.min.js', false, false, true);
    // END cube

    // multi slider
    wp_register_script('custom_modernizr', THEME_ASSETS.'js/modernizr.custom.63321.js', false, false, true);
    wp_register_script('multi_slider', THEME_ASSETS.'js/jquery.catslider.js', false, false, true);
    // end multi slider
    
    // pie chart 
    wp_register_script('easypiechart', THEME_ASSETS.'js/easypiechart.js', false, false, true);
    // pie chart end
    
    // owl carousel
    wp_register_style('owl_carousel', THEME_ASSETS . 'css/owl.carousel.css');
	wp_register_script('owl_carousel', THEME_ASSETS.'js/owl.carousel.min.js', false, false, true);
    // owl carousel END
    
    // ca custom
    wp_register_script('cre-animate', THEME_ASSETS.'js/jquery.cre-animate.js', false, false, true);
    // ca custom
    
    // waypoints for menu3d if vc is inactive
    wp_register_script('waypoints', THEME_ASSETS.'js/waypoints.min.js', false, false, true);
    // waypoints for menu3d if vc is inactive
	
	// enqueue scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('custom');
	wp_enqueue_script('menu3d');
	wp_enqueue_script('stellar');
	wp_enqueue_script('waypoints');
	
	wp_enqueue_script('cubeportfolio');
 
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );   

}
add_action('wp_enqueue_scripts', 'lpd_enqueue_scripts');

function lpd_theme_style() {
	wp_enqueue_style( 'lpd-style', get_bloginfo( 'stylesheet_url' ), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'lpd_theme_style' );

require_once dirname( __FILE__ ) . '/functions/sidebar.php';
require_once dirname( __FILE__ ) . '/functions/Functions.php';

require_once (TEMPLATEPATH. '/functions/theme_walker.php');
require_once (TEMPLATEPATH. '/functions/menu3dmega-options.php');
require_once (TEMPLATEPATH. '/functions/theme_video.php');
require_once (TEMPLATEPATH. '/functions/theme_comments.php');
require_once (TEMPLATEPATH. '/functions/theme_breadcrumb.php');
require_once (TEMPLATEPATH. '/functions/lpd_title.php');
require_once (TEMPLATEPATH. '/functions/shortcodes.php');
include_once (TEMPLATEPATH. '/functions/woocommerce.php');
include_once (TEMPLATEPATH. '/functions/ggl_web_fonts.php');
require_once (TEMPLATEPATH. '/functions/page_header_image.php');
require_once (TEMPLATEPATH. '/functions/admin-functions.php');
require_once (TEMPLATEPATH. '/functions/enqueued_functions.php');
require_once (TEMPLATEPATH. '/functions/cre-animation.php');

/* functions custom styles
================================================== */
require_once (TEMPLATEPATH. '/functions/fonts.php');
require_once (TEMPLATEPATH. '/functions/background.php');
require_once (TEMPLATEPATH. '/functions/color.php');
if (is_plugin_active('woocommerce/woocommerce.php')) {require_once (TEMPLATEPATH. '/functions/shop-styles.php');}

/* post type
================================================== */
include_once (TEMPLATEPATH. '/functions/post-type/portfolio.php');
include_once (TEMPLATEPATH. '/functions/post-type/team.php');

/* visual composer elements
================================================== */
require_once (TEMPLATEPATH. '/functions/vc_elements.php');

/* metabox
================================================== */
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-sidebar.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-page-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-post-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-product-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_category.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_post_tag.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_product_category.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_product_tag.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_portfolio_category.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_taxonomy_portfolio_tag.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-options.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-team-options.php');

include_once (TEMPLATEPATH. '/functions/metabox-post-format.php');
include_once (TEMPLATEPATH. '/functions/metabox-portfolio-format.php');
require_once (TEMPLATEPATH. '/functions/gallery-metabox/gallery.php');

?>