<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* General Settings
    ================================================== */
    $custom_logo = get_option_tree('custom_logo',$theme_options);
    $logo_tagline = get_option_tree('logo_tagline',$theme_options);
}
?>

	                    <?php if($custom_logo){?>
	                    <div id="logo" class="img">
	                        <h1><a href="<?php echo home_url(); ?>"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo $custom_logo?>"/></a></h1>
	                        <?php if($logo_tagline){?>
	                            <?php if($blog_title = get_bloginfo('description')){?>
	                            <h5><?php echo $blog_title; ?></h5>
	                            <?php }?>
	                        <?php }?>
	                        <div class="clearfix"></div>
	                    </div>
	                    <?php }else{?>
	                    <div id="logo">
	                        <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	                        <?php if($logo_tagline){?>
	                            <?php if($blog_title = get_bloginfo('description')){?>
	                            <h5><?php echo $blog_title; ?></h5>
	                            <?php }?>
	                        <?php }?>
	                        <div class="clearfix"></div>
	                    </div>
	                    <?php }?>