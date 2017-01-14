<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
	<?php if($favicon=get_option('afl_favicon')): ?>
    <link rel="icon" href="<?php print $favicon; ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php print $favicon; ?>" type="image/x-icon" />
	<?php endif; ?>
    <title><?php
		/*
	   * Print the <title> tag based on what is being viewed.
	   */
		global $page, $paged;

		wp_title( '|', true, 'right' );

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', $domain ), max( $paged, $page ) );

		?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	?>

    <!--[if lt IE 9]>
	<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link href="css/ie.css" type="text/css" rel="stylesheet"/>
    <![endif]-->
	<?php echo afl_get_custom_style(); ?>
</head>
<body <?php body_class(); ?>>
<?php if(get_theme_mod("afl_page_use_slides", false)&&count($slides = get_theme_mod("afl_page_slides", array()))>0): ?>
	<?php
	$js = array();
	foreach($slides as $slide){
		$js[] = "{image : '$slide[image]', title : '$slide[title]', thumb : '$slide[thumb]'}";
	}

	?>
<script type="text/javascript">
    jQuery(function($){
        $.supersized.themeVars.image_path = '<?php print TEMPLATEURL.'/images/supersized/' ?>';
        $.supersized({

            // Functionality
            slideshow               :   1,			// Slideshow on/off
            autoplay                :	1,			// Slideshow starts playing automatically
            start_slide             :   1,			// Start slide (0 is random)
            stop_loop               :	0,			// Pauses slideshow on last slide
            random                  : 	0,			// Randomize slide order (Ignores start slide)
            slide_interval          :   3000,		// Length between transitions
            transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
            transition_speed        :	1000,		// Speed of transition
            new_window              :	1,			// Image links open in new window/tab
            pause_hover             :   0,			// Pause slideshow on hover
            keyboard_nav            :   1,			// Keyboard navigation on/off
            performance             :	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
            image_protect           :	1,			// Disables image dragging and right click with Javascript

            // Size & Position
            min_width		    :   0,			// Min width allowed (in pixels)
            min_height		    :   0,			// Min height allowed (in pixels)
            vertical_center         :   1,			// Vertically center background
            horizontal_center       :   1,			// Horizontally center background
            fit_always              :	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
            fit_portrait            :   1,			// Portrait images will not exceed browser height
            fit_landscape           :   0,			// Landscape images will not exceed browser width

            // Components
            slide_links             :	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
            thumb_links             :	1,			// Individual thumb links for each slide
            thumbnail_navigation    :   0,			// Thumbnail navigation
            slides                  :  	[			// Slideshow Images
				<?php print implode(',', $js); ?>
            ],
            // Theme Options
            progress_bar            :	1,			// Timer for each slide
            mouse_scrub             :	0
        });
    });

</script>
<?php endif;?>


    <?php
		 $page = $wp_query->get_queried_object();
		 $custom_fields = get_post_custom_values('_wp_page_template',$page->ID);
		 $page_template = $custom_fields[0]; 
	 ?>
    <section id="top-menu">
        <div class="container">
            <div class="row">
                <div class="span6 hidden-phone">
					<?php
					if(has_nav_menu('top')) {
						wp_nav_menu(array( 'theme_location' => 'top', 'container' =>'', 'container_class' => '', 'menu_class' => 'top-menu'));
					} ?>
                </div>
                <div class="span6 pull-right">
					<?php if ($icons=json_decode(get_option('afl_social'),true)) {?>
                    <ul class="top-social">
                        <li class="git">
			  <?php if ($phone=get_option('afl_phone')) { ?><span class="phone"><span class="color2">National Sales</span> <?php echo $phone; ?>  </span><?php } ?>
		      </li>
						<?php foreach ($icons as $icon){
						echo '<li><a href="'.$icon['url'].'" title=""><img src="'.$icon['image'].'"/></a></li>';
						}
						?>
                    </ul>
					<?php }?>
                </div>

            </div>
        </div>
    </section>
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="span4 logo">
                    <a href="<?php echo home_url(); ?>"><?php
						if ($logo_img=get_option('afl_logo')){ ?><img src="<?php echo $logo_img ?>" />
                        <?php }else{
							if (get_option('blogname_part1') !== '') {?> <strong><?php echo get_option('blogname_part1') ?></strong><?php }
                            if (get_option('blogname_part2') !== '') {?><b><?php echo get_option('blogname_part2') ?></b><?php } ?><br />
							<?php if (get_option('tagline') !== '') {?><span><?php echo get_option('tagline') ?></span><?php } ?>
						<?php } ?>
                    </a>
                </div>
                <div class="span8">
                <!--    <?php if ($phone=get_option('afl_phone')) { ?><span class="phone"><span class="color2">National Sales</span> <?php echo $phone; ?>&nbsp;&nbsp;</span><?php } ?> -->
             			<?php
					if(has_nav_menu('primary')) {
						wp_nav_menu(array( 'theme_location' => 'primary', 'container' =>'nav', 'container_id' => 'menu', 'menu_class' => 'sf-menu'));
					} else {
						echo 'Primary Menu is not set! Please go to Admin Panel "Appearance => Menus" and set menu for "Primary Navigation"';
					}
					?><!--
					<form id="search" method="get" enctype="multipart/form-data" action="<?php bloginfo('siteurl');?>">
                        <p><input type="text" name="s" value="Search..." onfocus="if(this.value=='Search...') this.value=''" onblur="if(this.value=='') this.value='Search...'"/></p>
                        <p><input type="submit" name="submit" value="" class="search-bt"/></p>
                    </form>     -->
                </div>
            </div>
		</div>
    </header>