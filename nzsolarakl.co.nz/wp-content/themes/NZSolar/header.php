<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<?php if(!is_front_page()){ ?>
<style>
.entry-header, .entry-content, .entry-summary, .entry-meta {
    margin: 0 auto;
    max-width: 1170px;
    padding: 15px 85px 15px 40px;
    width: 100%;
}
</style>
<?php } ?>
<body <?php body_class(); ?>><div class="top-banner-custom">&nbsp;</div><div class="behindbanner">&nbsp;</div><div class="behindbanner-white">&nbsp;</div><div class="behind-nav">&nbsp;</div>
<?php if(is_front_page()){ ?>
<div class="behind-round">&nbsp;</div>
<?php } ?>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><img src="http://www.nzsolarakl.co.nz/wp-content/uploads/logo2.png" style="max-width: 350px; height: auto; width: 100%; margin-top: 5px;"></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?><br /><span id="header_free_phone">Free phone 0800 46 88 46</span></h2>
			</a>

			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
					<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->
<div style="width: 100%; max-width: 1000px; margin-left: auto; margin-right: auto;"><?php putRevSlider("homepage","homepage") ?></div>
<?php if(is_front_page()){ ?><div class="home-boxes"><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
<?php } ?>
<div style="clear: both;"></div>
		<div id="main" class="site-main">
