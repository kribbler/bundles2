<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
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
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?> 
<SCRIPT>
    jQuery(function() {
  
   var extreamePosition = jQuery(".black-boxx-below-menu").position(); 
  
      var eTop = jQuery('body').offset().top; 
    jQuery(window).scroll(function() {    
       if(jQuery(window).scrollTop() > extreamePosition.top){
       		jQuery(".black-boxx-below-menu").addClass('fixedpanel');
       		jQuery(".hideThisImage").fadeOut('fast');
       } else {
       		jQuery(".black-boxx-below-menu").removeClass('fixedpanel');
       		jQuery(".hideThisImage").fadeIn('fast');
       } 
    });
    });

</SCRIPT>
<style>
.products li { padding: 0px 0px 50px 0px !important; }
.products li a { text-decoration: none; text-transform:capitalize; }
</style>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
	  
		<?php if( is_home() || is_front_page() ) { ?> 
        
            <div class="logo">
                <A href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                <IMG src="<?php bloginfo( 'template_url' ); ?>/images/logo.png"></A>
            </div>
          
          <ul class="header-banner">
                <a href="/featured-products/"  style="text-decoration: none;" class="title" style=" padding: 5px 0px 25px 0px; margin:0px; display:block; height:35px;"> 
                FEATURED PRODUCT </a > 
                <?php if ( is_active_sidebar( 'featured-product-widget-area' ) ) : ?>
                        <?php dynamic_sidebar( 'featured-product-widget-area' ); ?>
                <?php endif; ?>
           </ul>
           
           <div class="clear"></div>
                <div id="social_media">
                   <a href="http://www.facebook.com/RITSafety" target="_blank"><img src="<?php bloginfo( 'template_url' ); ?>/images/icon_facebook.png"></a>
                   <a href="http://twitter.com/ritsafety" target="_blank"><img src="<?php bloginfo( 'template_url' ); ?>/images/icon_twitter.png"></a>
                   <a href="http://www.youtube.com/user/RITSafetySolution?feature=watch" target="_blank"><img src="<?php bloginfo( 'template_url' ); ?>/images/icon_youtube.png"></a>
                </div>
                <div class="search-box">
                    <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                        <div><label class="screen-reader-text" for="s">Search for:</label>
                            <input type="text" value="Search" name="s" id="s" onFocus="this.value=''" onBlur="this.value=(this.value!='') ? this.value : 'Search'" />
                            <input type="submit" id="searchsubmit" value="Search" />
                        </div>
                    </form>
                </div>
     
          <div id="access-box">
            <div id="access" ROLE="navigation">
            	 <div style="float:left">
                 	<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
                 </div>
                 <div style="float:right;">
					<a href="<?php bloginfo('url');?>/cart/" class="cart-container" style="min-width:144px; padding-right:2px; padding-bottom:1px; padding-left:0; font-weight:normal; font-size:14px; line-height:24px; ">
                        <span class="cart-items">
                            <img src="<?php bloginfo('template_url');?>/images/cart-sm.png" width="30" height="23" class="cart-img" style=" float:left; margin:0;" />
							<?php 
                            $cart_contents = jigoshop_cart::$cart_contents;
                            if ( ! empty( $cart_contents ) ) {
                            
                                $_product = $cart_contents;
                                $s = (count($_product) > 0)? 's':'';
                                echo '<b>'.count($_product).'</b>', '&nbsp;', 'ITEMS';
                            
                            } else {
                                echo '&nbsp;', '<b>', '0', '</b>', '&nbsp;', 'ITEMS';
                            }
                            ?>
                        </span><!-- cart-items -->
                        
                        <span class="cart-total">
							<?php
                            $cart_contents = jigoshop_cart::$cart_contents;
                            if ( ! empty( $cart_contents ) )
	                            echo jigoshop_cart::get_cart_total(). '&nbsp;';
                            else
    	                        echo '$0.00'.'&nbsp;';
                            ?>
                        </span><!-- cart-total -->
                    </a><!-- cart-container -->
                 </div>
                 <div style="clear:both;">
            </div><!-- #access -->
          </div><!-- #access box -->

			<?php if ( is_active_sidebar( 'below-nav-black-bar' ) ) : ?>
                <div class="online-store-comming-soon">
                    <?php dynamic_sidebar( 'below-nav-black-bar' ); ?>
                </div> 
            <?php endif; ?>


          
        <?php } else { ?>
            <br><br>                 
          <a class="hideThisImage" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" style=" vertical-align:top; display: block; width:190px;height:140px;margin: 10px 0px -190px 10px; padding:0px; float:left; z-index:99999; position: relative; "><IMG src="<?php bloginfo( 'template_url' ); ?>/images/logo.png" style="height:140px; margin: 0px; display:inline-block;"></a> 
           <div id="access-box1" style=" margin:0px; display:inline-block;  ">     
            <div id="access" ROLE="navigation" style=" margin:0px;  ">
                      <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'menu' => 'innermenu', 'theme_location' => 'primary' ) ); ?>
            </div><!-- #access -->
          </div><!-- #access box -->   
          
            <div class="black-boxx-below-menu"> 
                <div class="black-boxx-below-menu3">
                    <a href="<?php bloginfo('url');?>/cart/" class="cart-container" style="min-width:144px;  font-weight:normal; font-size:14px; line-height:24px; ">
                        <span class="cart-items">
                            <img src="<?php bloginfo('template_url');?>/images/cart-sm.png" width="30" height="23" class="cart-img" style=" float:left; margin:0;" />
							<?php 
                            $cart_contents = jigoshop_cart::$cart_contents;
                            if ( ! empty( $cart_contents ) ) {
                            
                                $_product = $cart_contents;
                                $s = (count($_product) > 0)? 's':'';
                                echo '<b>'.count($_product).'</b>', '&nbsp;', 'ITEMS';
                            
                            } else {
                                echo '&nbsp;', '<b>', '0', '</b>', '&nbsp;', 'ITEMS';
                            }
                            ?>
                        </span><!-- cart-items -->
                        
                        <span class="cart-total">
							<?php
                            $cart_contents = jigoshop_cart::$cart_contents;
                            if ( ! empty( $cart_contents ) )
                            
                            echo '&nbsp;' . jigoshop_cart::get_cart_total(). '&nbsp;';
                            else
                            echo '&nbsp;', '$0.00', '&nbsp;';
                            ?>
                        </span><!-- cart-total -->
                    </a><!-- cart-container -->
                </div>   
                 
                <div class="black-boxx-below-menu2">
                    <div class="search-box" style="float:none; display:inline-block; width:255px;">
                    <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                        <div> 
                            <input type="text" value="Search Products" name="s" id="s" onFocus="this.value=(this.value!='Search Products') ? this.value : ''" onBlur="this.value=(this.value!='') ? this.value : 'Search Products'" style="width:200px;" />
                            <input type="submit" id="searchsubmit" value="Search" />
                        </div>
                    </form>
                    </div>
                </div>   
                <div class="black-boxx-below-menu1">1-800-254-2990</div>         		 
                <div class="clear"></div>
            </div>
            
        <?php }  ?>   
        
	</header><!-- #masthead -->

	<div id="main" class="wrapper">