<?php

/* URI shortcuts
================================================== */
define( 'THEME_ASSETS', get_template_directory_uri() . '/assets/', true );
define( 'TEMPLATEPATH', get_template_directory_uri(), true );
define( 'GETTEXT_DOMAIN', '456market' );

require_once dirname( __FILE__ ) . '/functions/reset.php';

require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-activation.php';
require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-register.php';


/* Register and load JS, CSS
================================================== */
function theme_enqueue_scripts() {
    
    // register scripts;
    wp_register_style('responsive', THEME_ASSETS . 'css/responsive_layouts.css');
    wp_register_style('responsive-1170', THEME_ASSETS . 'css/responsive_1170_layouts.css');
    wp_register_style('fixed-1170', THEME_ASSETS . 'css/fixed_1170_layouts.css');
    
    wp_register_style('woocommerce', THEME_ASSETS . 'css/woocommerce.css');
    wp_register_style('megafoliopro', THEME_ASSETS . 'megafolio-pro-1-2/megafolio/css/settings.css');
    wp_register_style('megafoliopro-responsive', THEME_ASSETS . 'megafolio-pro-1-2/megafolio/css/settings-responsive.css');
    wp_register_style('fancybox', THEME_ASSETS . 'megafolio-pro-1-2/megafolio/fancybox/jquery.fancybox.css');
    wp_register_style('showbiz', THEME_ASSETS . 'showbizpro/css/settings.css');
    wp_register_style('showbiz-responsive', THEME_ASSETS . 'showbizpro/css/settings-responsive.css');
    
    wp_register_style('woocommerce', THEME_ASSETS . 'css/woocommerce.css');
    
    wp_register_style('flashblock', THEME_ASSETS . 'mt_gallery/css/flashblock.css');
    wp_register_style('videoPlayer', THEME_ASSETS . 'mt_gallery/css/videoPlayer.css');
    wp_register_style('mt-playlist', THEME_ASSETS . 'mt_gallery/css/playlist.css');
    
    wp_register_style('vg-playlist', THEME_ASSETS . 'video_bg/css/playlist.css');

    wp_register_script('twitter-widgets', 'http://platform.twitter.com/widgets.js', false, false, true);
    wp_register_script('bootstrap', THEME_ASSETS.'js/bootstrap.min.js', false, false, true);
    wp_register_script('prettify', THEME_ASSETS.'js/google-code-prettify/prettify.js', false, false, true);
    wp_register_script('custom', THEME_ASSETS.'js/custom.function.js', false, false, false);
    wp_register_script('newsticker-fix', THEME_ASSETS.'js/newsticker-fix.js', false, false, true);
    wp_register_script('themepunch-plugins', THEME_ASSETS.'megafolio-pro-1-2/megafolio/js/jquery.themepunch.plugins.min.js', false, false, false);
    wp_register_script('megafoliopro', THEME_ASSETS.'megafolio-pro-1-2/megafolio/js/jquery.themepunch.megafoliopro.js', false, false, false);
    wp_register_script('fancybox', THEME_ASSETS.'megafolio-pro-1-2/megafolio/fancybox/jquery.fancybox.pack.js', false, false, false);
    wp_register_script('iframe-scale', THEME_ASSETS.'js/iframe.function.js', false, false, false);
    wp_register_script('raphael', THEME_ASSETS.'LivIcons-1-1-1/minified/raphael-min.js', false, false, false);
    wp_register_script('livicons', THEME_ASSETS.'LivIcons-1-1-1/minified/livicons-1.1.1.min.js', false, false, false);
    wp_register_script('isotope', THEME_ASSETS.'isotope/jquery.isotope.min.js', false, false, false);
    wp_register_script('isotope-function', THEME_ASSETS.'isotope/isotope.function.js', false, false, false);
    wp_register_script('prettyphoto', THEME_ASSETS.'prettyPhoto/jquery.prettyPhoto.js', 'jquery', false, false, false);
    wp_register_script('prettyphoto-function', THEME_ASSETS.'prettyPhoto/prettyPhoto.function.js', false, false, false);
    wp_register_script('showbiz-theme', THEME_ASSETS.'showbizpro/js/jquery.themepunch.plugins.min.js', false, false, false);
    wp_register_script('showbiz', THEME_ASSETS.'showbizpro/js/jquery.themepunch.showbizpro.min.js', false, false, false);
    wp_register_script('wc-wishlist', THEME_ASSETS.'js/wc-wishlist.js', false, false, true);
    wp_register_script('wc-catalog', THEME_ASSETS.'js/wc-catalog.js', false, false, true);
    
	wp_register_script('easing', THEME_ASSETS.'mt_gallery/js/jquery.easing.1.3.js', false, false, false);
	wp_register_script('address', THEME_ASSETS.'mt_gallery/js/jquery.address.js', false, false, false);
	wp_register_script('cj-swipe', THEME_ASSETS.'mt_gallery/js/jquery.cj-swipe.js', false, false, false);
	wp_register_script('swfobject', THEME_ASSETS.'mt_gallery/js/swfobject.js', false, false, false);
	wp_register_script('froogaloop', THEME_ASSETS.'mt_gallery/js/froogaloop.js', false, false, false);
	wp_register_script('youtube_api', 'http://www.youtube.com/player_api', false, false, false);
	wp_register_script('apYoutubePlayer', THEME_ASSETS.'mt_gallery/js/jquery.apYoutubePlayer.min.js', false, false, false);
	wp_register_script('apVimeoPlayer', THEME_ASSETS.'mt_gallery/js/jquery.apVimeoPlayer.min.js', false, false, false);
	wp_register_script('videoGallery', THEME_ASSETS.'mt_gallery/js/jquery.videoGallery.min.js', false, false, false);
	wp_register_script('mg', THEME_ASSETS.'mt_gallery/js/jquery.multiGallery.js', false, false, false);
	
	wp_register_script('apCookie', THEME_ASSETS.'video_bg/js/jquery.apCookie.min.js', false, false, false);
	wp_register_script('apPlaylistManager', THEME_ASSETS.'video_bg/js/jquery.apPlaylistManager.min.js', false, false, false);
	wp_register_script('vg', THEME_ASSETS.'video_bg/js/jquery.videoGallery.js', false, false, false);
	
	// enqueue scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap');
	wp_enqueue_script('prettify');
	wp_enqueue_script('custom');
	wp_enqueue_script('newsticker-fix');
	wp_enqueue_script('themepunch-plugins');
	wp_enqueue_script('megafoliopro');
	wp_enqueue_script('fancybox');
	wp_enqueue_script('iframe-scale');
	wp_enqueue_script('raphael');
	wp_enqueue_script('livicons');
	wp_enqueue_script('isotope');
	wp_enqueue_script('isotope-function');
	wp_enqueue_script('prettyphoto');
	wp_enqueue_script('prettyphoto-function');
	wp_enqueue_script('showbiz-theme');
	wp_enqueue_script('showbiz');

    wp_enqueue_style('megafoliopro');
    wp_enqueue_style('fancybox');
    wp_enqueue_style('showbiz');
    
    wp_enqueue_style('woocommerece');

    
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );   

}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

function front_slider_script() {
	wp_enqueue_script('easing');
	wp_enqueue_script('address');
	wp_enqueue_script('cj-swipe');
	wp_enqueue_script('swfobject');
	wp_enqueue_script('froogaloop');
	wp_enqueue_script('youtube_api');
	wp_enqueue_script('apYoutubePlayer');
	wp_enqueue_script('apVimeoPlayer');
	wp_enqueue_script('videoGallery');
	wp_enqueue_script('mg');
    wp_enqueue_style('flashblock');
    wp_enqueue_style('videoPlayer');
    wp_enqueue_style('mt-playlist');
}

function front_youtube_script() {
	wp_enqueue_script('easing');
	wp_enqueue_script('swfobject');
	wp_enqueue_script('address');
	wp_enqueue_script('youtube_api');
	wp_enqueue_script('apYoutubePlayer');
	wp_enqueue_script('apCookie');
	wp_enqueue_script('apPlaylistManager');
	wp_enqueue_script('vg');
	wp_enqueue_style('vg-playlist');
}

function lpd_wc_wishlist() {
	wp_enqueue_script('wc-wishlist');
}
function lpd_wc_catalog() {
	wp_enqueue_script('wc-catalog');
}
function woocommerce_styles() {
    wp_enqueue_style('woocommerce');
}
function responsive() {
	wp_enqueue_style('responsive');
	wp_enqueue_style('megafoliopro-responsive');
	wp_enqueue_style('showbiz-responsive');
}
function fixed_1170_layouts() {
	wp_enqueue_style('fixed-1170');
}
function responsive_1170_layouts() {
	wp_enqueue_style('responsive-1170');
}

function add_admin_scripts( $hook ) {

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {    
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('custom-js', get_template_directory_uri().'/functions/metabox/js/custom-js.js');
	wp_enqueue_style('jquery-ui-custom', get_template_directory_uri().'/functions/metabox/css/jquery-ui-custom.css');
    }
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

require_once dirname( __FILE__ ) . '/functions/sidebar.php';
require_once dirname( __FILE__ ) . '/functions/Functions.php';


require_once (TEMPLATEPATH. '/functions/theme_walker.php');
require_once (TEMPLATEPATH. '/functions/theme_video.php');
require_once (TEMPLATEPATH. '/functions/theme_comments.php');
require_once (TEMPLATEPATH. '/functions/theme_breadcrumb.php');
require_once (TEMPLATEPATH. '/functions/shortcodes.php');
include_once (TEMPLATEPATH. '/admin/shortcode-tinymce.php');
require_once (TEMPLATEPATH. '/functions/black-studio-tinymce-widget/black-studio-tinymce-widget.php');
require_once (TEMPLATEPATH. '/functions/dw-shortcodes-bootstrap/designwall-shortcodes.php');
include_once (TEMPLATEPATH. '/functions/woocommerce.php');

/* custom widgets
================================================== */
require_once (TEMPLATEPATH. '/functions/widget-footer-meta.php');
require_once (TEMPLATEPATH. '/functions/widget-front-meta.php');
require_once (TEMPLATEPATH. '/functions/widget-posts.php');
require_once (TEMPLATEPATH. '/functions/widget-post-tabs.php');


/* coding starts here
================================================== */
include_once (TEMPLATEPATH. '/functions/post_types_clients.php');
include_once (TEMPLATEPATH. '/functions/post_types_team.php');
include_once (TEMPLATEPATH. '/functions/post_types-portfolio.php');
include_once (TEMPLATEPATH. '/functions/post_types_front-tabs.php');
include_once (TEMPLATEPATH. '/functions/post_types_front_slider.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-sidebar.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-options.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-tagline.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-portfolio-filter.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-page-tagline.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-page-header.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-post-tagline.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-post-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-post-front-options.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-product-header.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-product-tagline.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-team-social.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-tabs.php');

include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-options.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-style1.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-style2.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-page-front-slider.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-page-front-youtube.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-callout.php');
include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-widget.php');


include_once (TEMPLATEPATH. '/functions/metabox/functions/add_meta_box-front-slider-options.php');

include_once (TEMPLATEPATH. '/functions/metabox-post-format.php');
include_once (TEMPLATEPATH. '/functions/metabox-portfolio-format.php');

?>