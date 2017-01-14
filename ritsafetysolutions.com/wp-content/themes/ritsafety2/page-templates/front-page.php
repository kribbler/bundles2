<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<br />
  	<DIV class="banner" style=" overflow: hidden !important; "> 
            <style>
			.cycloneslider-caption { top:20px; left:450px !important; width:400px !important; }
			.cycloneslider-template-default .cycloneslider-caption-title { padding: 10px 20px 15px 20px !important; }
			</style>
           <?php echo do_shortcode('[cycloneslider id="home-page-slider-window"]'); ?>
        
    </DIV>
    
    <DIV class="home-box-one Humanist777BT">
    	<a href="<?php bloginfo('url'); ?>/fire-rescue">
    	<DIV class="title">FIRE RESCUE</DIV><IMG src="<?php bloginfo( 'template_url' ); ?>/images/fire-safty.jpg" style="display:block;margin:0;padding:0;">
        </a>
    </DIV>

    <DIV class="home-box-one Humanist777BT">
    	<a href="<?php bloginfo('url'); ?>/industrial-safety">
    	<DIV class="title1">INDUSTRIAL SAFETY</DIV><IMG src="<?php bloginfo( 'template_url' ); ?>/images/industrialsafty.jpg" style="display:block;margin:0;padding:0;">
        </a>
    </DIV>
    
    <DIV class="home-box-one Humanist777BT" style=" margin-right:0PX;">
    	<a href="<?php bloginfo('url'); ?>/custom-applications">
    	<DIV class="title2">CUSTOM APPLICATIONS</DIV><IMG src="<?php bloginfo( 'template_url' ); ?>/images/custum-application.jpg" style="display:block;margin:0;padding:0;">
        </a>
    </DIV>

<?php get_footer(); ?>