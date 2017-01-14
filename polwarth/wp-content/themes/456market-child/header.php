<?php

require_once(ABSPATH .'/wp-admin/includes/plugin.php');
 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* General Settings
    ================================================== */
    $theme_layouts = get_option_tree('theme_layouts',$theme_options);
    $type_layouts = get_option_tree('type_layouts',$theme_options);
    $header_meta_layouts = get_option_tree('meta_layouts',$theme_options);
    $left_headermeta = get_option_tree('left_headermeta',$theme_options);
    $right_headermeta = get_option_tree('right_headermeta',$theme_options);
    $header_meta_c = get_option_tree('header_meta_c',$theme_options);
    $wpml_switcher = get_option_tree('wpml_switcher',$theme_options);
    $wpml_switcher_label = get_option_tree('wpml_switcher_label',$theme_options);
    $lm_headermeta = get_option_tree('lm_headermeta',$theme_options);
    $wishlist_headermeta = get_option_tree('wishlist_headermeta',$theme_options);
    $compare_headermeta = get_option_tree('compare_headermeta',$theme_options);
    
    /* SEO Settings
    ================================================== */
    $disable_seo = get_option_tree('disable_seo',$theme_options);
    $theme_title = get_option_tree('theme_title',$theme_options);
    $keywords = get_option_tree('keywords',$theme_options);
    $description = get_option_tree('description',$theme_options);
    
    /* Theme Options
    ================================================== */
    $theme_style = get_option_tree('theme_style',$theme_options);
    $bg_pattern = get_option_tree('bg_pattern',$theme_options);
    $bg_custom_pattern = get_option_tree('bg_custom_pattern',$theme_options);
    $bg_custom_img = get_option_tree('bg_custom_img',$theme_options);
    
    $favicon = get_option_tree('favicon',$theme_options);
    $iphone_icon = get_option_tree('iphone_icon',$theme_options);
    $ipad_icon = get_option_tree('ipad_icon',$theme_options);
    $iphone2_icon = get_option_tree('iphone2_icon',$theme_options);
    $ipad2_icon = get_option_tree('ipad2_icon',$theme_options);
    
    /* Blog Options
    ================================================== */
    $blog_tagline_title = get_option_tree('blog-tagline-title',$theme_options);
    $blog_tagline_description = get_option_tree('blog-tagline-description',$theme_options);
    $blog_header_image = get_option_tree('blog-header-image',$theme_options);
    
    /* Shop Options
    ================================================== */
    $s_cart = get_option_tree('s_cart',$theme_options);

}
?>
	<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
		<?php add_action( 'wp_enqueue_scripts', 'woocommerce_styles' );?> 
    <?php } ?>  
    <?php if($type_layouts=="responsive"){
        add_action( 'wp_enqueue_scripts', 'responsive' );
    }
    if($theme_layouts=="1170"&&$type_layouts=="fixed"){
    	add_action( 'wp_enqueue_scripts', 'fixed_1170_layouts' );
    }
    if($theme_layouts=="1170"&&$type_layouts=="responsive"){
    	add_action( 'wp_enqueue_scripts', 'responsive_1170_layouts' );
    }?>
    
	<?php if (is_plugin_active('woocommerce-wishlists/woocommerce-wishlists.php')) {
		add_action( 'wp_enqueue_scripts', 'lpd_wc_wishlist' );
	}
	
	if (is_plugin_active('woocommerce-catalog-visibility-options/woocommerce-catalog-visibility-options.php')) {
		add_filter('body_class','lpd_woo_catalog');
		add_action( 'wp_enqueue_scripts', 'lpd_wc_catalog' );
	} ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="p:domain_verify" content="24737e87a44c68370cd37835f4a39d2f"/>
    <?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>
    
	<?php if($front_options_select=="style1"){?>
		<?php $front_style1_select = get_post_meta($post->ID, 'front_style1_select', true); ?>
	<?php }?>
	
    <?php if($front_options_select=="style1"){?>
	    <?php if ($front_style1_select=="youtube") {
	    	add_action( 'wp_enqueue_scripts', 'front_youtube_script' );
	    } elseif($front_style1_select=="front_slider"){
	    	add_action( 'wp_enqueue_scripts', 'front_slider_script' );
	    }?>
    <?php }?>

    <?php
    echo '<title>' ;
    if($disable_seo != 'Disable'):
    	$out = '';
    	$out = $theme_title;
    	
    	$out = str_replace('%blog_title%', get_bloginfo('name'), $out);
    	$out = str_replace('%blog_description%', get_bloginfo('description'), $out);
    	$out = str_replace('%page_title%', wp_title('', false), $out);
    	
    	echo $out;
    else:
    	echo wp_title('', false) . ' | ' . get_bloginfo('name');
    endif;
    echo '</title>';
    
    if($disable_seo != 'Disable') {
        if($keywords):
    	?>
    		<meta name="keywords" content="<?php echo $keywords; ?>">
    	<?php
    	endif;
    
    	if($description):
    	?>
    		<meta name="description" content="<?php echo $description; ?>"> 
    	<?php
    	endif;
    }?>

    <?php if($type_layouts=="responsive"){?><meta name="viewport" content="width=device-width, initial-scale=1.0"><?php }?>
    
    <meta name="author" content="lidplussdesign" />

	<?php get_template_part('includes/google-webfonts' ) ?>
    
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
	<!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient {
	       filter: none;
	    }
	  </style>
	<![endif]-->
	
	<!--[if lte IE 8 ]>
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_ASSETS; ?>mt_gallery/css/ie.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_ASSETS; ?>video_bg/css/ie_below_9.css" />
	<![endif]-->

    <!--[if lt IE 8]>
    <script src="<?php echo THEME_ASSETS; ?>LivIcons-1-1-1/minified/json2.min.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <?php if($favicon){ ?><link rel="shortcut icon" href="<?php echo $favicon ?>"><?php } ?>  
    <?php if($ipad2_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ipad2_icon ?>"><?php } ?>
    <?php if($iphone2_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $iphone2_icon ?>"><?php } ?>
    <?php if($ipad_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ipad_icon ?>"><?php } ?>
    <?php if($iphone_icon){ ?><link rel="apple-touch-icon-precomposed" href="<?php echo $iphone_icon ?>"><?php } ?>
    
    <!-- JS -->
    <?php wp_head(); ?>
    
    <?php get_template_part('includes/fonts') ?>
    <?php get_template_part('includes/color') ?>
    <?php get_template_part('includes/page-header-css') ?>
    <?php get_template_part('includes/background') ?>
    
	<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
    	<?php get_template_part('includes/shop-styles') ?>
    <?php } ?>
    
    <?php get_template_part('includes/custom_css') ?>
    
</head>
<?php if(is_front_page()){ ?>
<style>
#page-header { display: none; }
</style>
<?php } ?>
<body <?php if($theme_style=="boxed"){?>id="boxed"<?php }?> <?php body_class(); ?>>
<?php if($bg_pattern!="none"||$bg_custom_pattern){?>
<div id="pattern-background">
<?php } ?>

<?php if (DEVICE_TYPE != 'computer'){?>
							<div class="first-menu <?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>second-menu-active<?php } ?> clearfix">
					            <div class="navbar bold-font bold-font-dropdown-menu uppercase">
					              <div class="">
					                <div class="container">
					                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					                    <span class="icon-bar"></span>
					                    <span class="icon-bar"></span>
					                    <span class="icon-bar"></span>
					                  </a>
					                  <div class="nav-collapse collapse navbar-responsive-collapse">
					                    <?php if ( has_nav_menu( 'primary-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
				                        <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav nav-pills', 'container' => '', 'walker' => new bootstrap_nav_menu_456shop_walker() ) ); ?>
				                        <?php } else { /* else use wp_list_pages */?>
				                        <ul class="nav nav-pills">
				                            <?php wp_list_pages( array('title_li' => '', 'menu_class' => '', 'walker' => new bootstrap_list_pages_walker() )); ?>
				                        </ul>
				                        <?php } ?>
					                  </div><!-- /.nav-collapse -->
					                </div>
					              </div><!-- /navbar-inner -->
					            </div><!-- /navbar -->
							</div>
<?php } ?>

		<?php if($header_meta_c==""){?>
			<div id="meta" class="">
				<div class="container">
					<div class="row-fluid">
					  <?php if($header_meta_layouts=="39"){?>
					  <div class="span3 jnews">
					  <?php } else if($header_meta_layouts=="48"){?>
					  <div class="span4 jnews">
					  <?php } else if($header_meta_layouts=="57"){?>
					  <div class="span5 jnews">
					  <?php } else if($header_meta_layouts=="66"){?>
					  <div class="span6 jnews">
					  <?php } else if($header_meta_layouts=="75"){?>
					  <div class="span7 jnews">
					  <?php } else if($header_meta_layouts=="84"){?>
					  <div class="span8 jnews">
					  <?php } else if($header_meta_layouts=="93"){?>
					  <div class="span9 jnews">
					  <?php } else{?>
					  <div class="span7 jnews">
					  <?php }?>
					  <?php if($left_headermeta){?><?php //echo do_shortcode($left_headermeta); ?><?php }?></div> 
					  <?php if($header_meta_layouts=="39"){?>
					  <div class="span9 meta-right">
					  <?php } else if($header_meta_layouts=="48"){?>
					  <div class="span8 meta-right">
					  <?php } else if($header_meta_layouts=="57"){?>
					  <div class="span7 meta-right">
					  <?php } else if($header_meta_layouts=="66"){?>
					  <div class="span6 meta-right">
					  <?php } else if($header_meta_layouts=="75"){?>
					  <div class="span5 meta-right">
					  <?php } else if($header_meta_layouts=="84"){?>
					  <div class="span4 meta-right">
					  <?php } else if($header_meta_layouts=="93"){?>
					  <div class="span3 meta-right">
					  <?php } else{?>
					  <div class="span5 meta-right">
					  <?php }?>				  	
	                    <?php if ( has_nav_menu( 'meta-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
	                    <?php wp_nav_menu( array( 'theme_location' => 'meta-menu', 'container' => 'div', 'container_class' => 'meta-shop-navigation', 'menu_class' => '') ); ?>
	                    <?php }	?>
	                    
						<?php if ( is_active_sidebar(7) ){?>
							<div class="right-meta"><?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Right Header Meta') ) ?></div>
						<?php }else{?>
							<?php if($right_headermeta){?><div class="right-meta"><?php echo do_shortcode($right_headermeta); ?></div><?php }?>
						<?php }?>
					  	
							
							<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
								<?php if (is_user_logged_in()) { ?>
									<div class="meta-hader-login">
										<?php if(!$lm_headermeta){?>
											<a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e( 'Logout', GETTEXT_DOMAIN ); ?></a>
											<a href="<?php echo get_permalink(woocommerce_get_page_id('myaccount')); ?>"><?php _e( 'My Account', GETTEXT_DOMAIN ); ?></a>
										<?php }?>
										<?php if (in_array( 'woocommerce-wishlists/woocommerce-wishlists.php' , get_option('active_plugins') ) ) { ?>
											<?php if($wishlist_headermeta){?>
												<a href="<?php echo $wishlist_headermeta;?>"><?php _e( 'Wishlist', GETTEXT_DOMAIN ); ?></a>
											<?php }?>
										<?php }?>
										<?php if (in_array( 'woocommerce-compare-products-pro/compare_products.php' , get_option('active_plugins') ) ) { ?>
											<?php if($compare_headermeta){?>
												<a href="<?php echo $compare_headermeta;?>"><?php _e( 'Compare', GETTEXT_DOMAIN ); ?></a>
											<?php }?>
										<?php }?>	
									</div>
								<?php } else{ ?>
									<div class="meta-hader-login">
										<?php if(!$lm_headermeta){?>
											<a href="#login-modal" role="button" data-toggle="modal"><?php _e( 'Login', GETTEXT_DOMAIN ); ?></a>
											<a href="#register-modal" class="sec-btn" role="button" data-toggle="modal"><?php _e( 'Register', GETTEXT_DOMAIN ); ?></a>
										<?php }?>
										<?php if (in_array( 'woocommerce-wishlists/woocommerce-wishlists.php' , get_option('active_plugins') ) ) { ?>
											<?php if($wishlist_headermeta){?>
												<a href="<?php echo $wishlist_headermeta;?>"><?php _e( 'Wishlist', GETTEXT_DOMAIN ); ?></a>
											<?php }?>
										<?php }?>
										<?php if (in_array( 'woocommerce-compare-products-pro/compare_products.php' , get_option('active_plugins') ) ) { ?>
											<?php if($compare_headermeta){?>
												<a href="<?php echo $compare_headermeta;?>"><?php _e( 'Compare', GETTEXT_DOMAIN ); ?></a>
											<?php }?>
										<?php }?>	

									</div>
									
								<?php }?>
							<?php }?>
							<?php echo dynamic_sidebar( 'header_facebook' );?>
							
			  			<?php if($wpml_switcher){?>
							<?php $plugins = get_option('active_plugins');?>
							<?php $required_plugin = 'sitepress-multilingual-cms/sitepress.php';?>
							<?php if ( in_array( $required_plugin , $plugins ) ) {?>
							<div class="meta-data-wpml clearfix"><?php if(!$wpml_switcher_label){?><div class="wpml_label"><?php _e('Languages', GETTEXT_DOMAIN); ?>:</div><?php }?>
							    <div class="wpml_flags"><?php language_selector_flags(); ?></div>
							</div>
							<?php }?>
						<?php }?>
					  </div>
					</div>
				</div>
			</div>
		
			<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php global $woocommerce; ?>
			<!-- login-modal -->
			<div id="login-modal" class="modal hide1 fade woocommerce" tabindex="-1" role="dialog" aria-labelledby="<?php _e( 'Login', GETTEXT_DOMAIN ); ?>" aria-hidden="true">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><?php _e( 'Login', GETTEXT_DOMAIN ); ?></h3>
				</div>
				<div class="modal-body">
					<?php echo woocommerce_show_messages1(); ?>										
					<form method="post" class="login">
						<p class="form-row form-row-first">
							<label for="username"><?php _e('Username or email', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
							<input type="text" class="input-text" name="username" id="username" />
						</p>
						<p class="form-row form-row-last">
							<label for="password"><?php _e('Password', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
							<input class="input-text" type="password" name="password" id="password" />
						</p>
						<div class="clear"></div>
						<p class="form-row">
							<?php $woocommerce->nonce_field('login', 'login') ?>
							<input type="submit" class="btn btn-normal btn-primary" name="login" value="<?php _e('Login', GETTEXT_DOMAIN); ?>" />
							<a class="lost_password" href="<?php echo esc_url( wp_lostpassword_url( home_url() ) ); ?>"><?php _e('Lost Password?', GETTEXT_DOMAIN); ?></a>
						</p>
					</form>
				</div>
				<div class="modal-footer">
				<button class="btn btn-normal" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
			<div id="register-modal" class="modal hide1 fade woocommerce" tabindex="-1" role="dialog" aria-labelledby="<?php _e( 'Register', GETTEXT_DOMAIN ); ?>" aria-hidden="true">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3><?php _e( 'Register', GETTEXT_DOMAIN ); ?></h3>
				</div>
				<div class="modal-body">
					<?php echo woocommerce_show_messages1(); ?>	
					<form method="post" class="register">
			
						<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>
			
							<p class="form-row form-row-first">
								<label for="reg_username"><?php _e('Username', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
								<input type="text" class="input-text" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
							</p>
			
							<p class="form-row form-row-last">
			
						<?php else : ?>
			
							<p class="form-row form-row-wide">
			
						<?php endif; ?>
			
							<label for="reg_email"><?php _e('Email', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
							<input type="email" class="input-text" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
						</p>
			
						<div class="clear"></div>
			
						<p class="form-row form-row-first">
							<label for="reg_password"><?php _e('Password', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
							<input type="password" class="input-text" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
						</p>
						<p class="form-row form-row-last">
							<label for="reg_password2"><?php _e('Re-enter password', GETTEXT_DOMAIN); ?> <span class="required">*</span></label>
							<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
						</p>
						<div class="clear"></div>
			
						<!-- Spam Trap -->
						<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" /></div>
			
						<?php do_action( 'register_form' ); ?>
			
						<p class="form-row">
							<?php $woocommerce->nonce_field('register', 'register') ?>
							<input type="submit" class="btn btn-normal btn-primary" name="register" value="<?php _e('Register', GETTEXT_DOMAIN); ?>" />
						</p>
			
					</form>
				</div>
				<div class="modal-footer">
				<button class="btn btn-normal" data-dismiss="modal" aria-hidden="true"><?php _e('Close', GETTEXT_DOMAIN); ?></button>
				</div>
			</div>
			<?php }?>
		
		<?php }?>
		<div id="header" class="">
		
			<div class="container">
				<div class="row-fluid">
					<?php get_template_part('includes/logo' ) ?>
					<div class="theme-navigation">
					
						<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
							<?php if(!$s_cart){?>
								<?php get_template_part('includes/cart' ) ?>
							<?php } ?>
						<?php } ?>
						<?php if (DEVICE_TYPE == 'computer'){?>
						<div class="theme-menu <?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>shopping-cart-active<?php } ?>">
							<div class="first-menu <?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>second-menu-active<?php } ?> clearfix">
					            <div class="navbar bold-font bold-font-dropdown-menu uppercase">
					              <div class="">
					                <div class="container">
					                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					                    <span class="icon-bar"></span>
					                    <span class="icon-bar"></span>
					                    <span class="icon-bar"></span>
					                  </a>
					                  <div class="nav-collapse collapse navbar-responsive-collapse">
					                    <?php if ( has_nav_menu( 'primary-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
				                        <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav nav-pills', 'container' => '', 'walker' => new bootstrap_nav_menu_456shop_walker() ) ); ?>
				                        <?php } else { /* else use wp_list_pages */?>
				                        <ul class="nav nav-pills">
				                            <?php wp_list_pages( array('title_li' => '', 'menu_class' => '', 'walker' => new bootstrap_list_pages_walker() )); ?>
				                        </ul>
				                        <?php } ?>
					                  </div><!-- /.nav-collapse -->
					                </div>
					              </div><!-- /navbar-inner -->
					            </div><!-- /navbar -->
							</div>
							<?php if ( has_nav_menu( 'secondary-menu' ) ) { ?>
							<div class="second-menu clearfix">
								<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'menu_class' => '', 'container' => '', 'depth' => 1 ) ); ?>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					
				</div>
			</div>
		</div>
		<?php get_template_part('includes/page-breadcrumb-header' ) ?>
