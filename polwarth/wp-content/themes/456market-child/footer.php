<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* Menu Options
    ================================================== */
    $navi_type = get_option_tree('navi_type',$theme_options);  
    /* Footer Options
    ================================================== */
    $footer_search = get_option_tree('footer_search',$theme_options);
    $footer_copyright = get_option_tree('footer_copyright',$theme_options);
    $ccard = get_option_tree('ccard',$theme_options);  
    
    /* Theme Options
    ================================================== */
    $bg_pattern = get_option_tree('bg_pattern',$theme_options);
    $bg_custom_pattern = get_option_tree('bg_custom_pattern',$theme_options);
    $bg_custom_img = get_option_tree('bg_custom_img',$theme_options);
     
}
?>
<?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>

			<?php if ( is_active_sidebar(10) ){?>
			<div id="footer-meta" <?php if($front_options_select=="style1"){?><?php if($post->post_content == "") {?>class="one-page"<?php }?><?php }?>>
				<div class="container">
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Meta') ) ?>
				</div>
			</div>
			<?php } ?>
			<?php if ( is_active_sidebar(9)||is_active_sidebar(2) ){?>
			<div id="footer">
				<div class="container">
				  <div class="row-fluid">
					<?php if ( is_active_sidebar(9) ){?>
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3 Column') ) ?>
					<?php } else{?>
						<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer') ) ?>
					<?php } ?>
				  </div>
				</div>
			</div>
			<?php } ?>
			<?php if ($footer_search!="none"||$ccard||$footer_copyright!=""||has_nav_menu( 'footer-menu' )) { ?>
			<div id="footer-bottom">
				<div class="container">
				  <div class="row-fluid">
						<div class="span6 <?php if ($footer_search) { ?>footer-search-form<?php } ?>">
							<?php get_template_part('includes/footer-search-form' ) ?>
							<?php get_template_part('includes/payment-method' ) ?>
						</div>
					  <div class="span6 footer-bottom-right">
							<?php if ( has_nav_menu( 'footer-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
							<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-nav', 'container' => '', 'depth' => 1  ) ); ?>
							<?php } ?>
							<?php get_template_part('includes/copyright' ) ?>
					  </div>
				  </div>
				</div>
			</div>
			<?php } ?>


<?php if($bg_pattern!="none"||$bg_custom_pattern){?>
</div> <!-- END pattern-background-->
<?php } ?>

<!--
<div id="our_brands">
	<div class="container">
		<div class="row-fluid">
			<?php dynamic_sidebar( 'our_brands' );?>
		</div>
	</div>
</div>
-->

<div id="newsletter_subscribe">
	<div class="container">
		<div class="row-fluid">
			<div class="span5">
				<?php dynamic_sidebar( 'newsletter_subscribe' );?>
			</div>
			<div class="span6">
				<input type="text" />
				<input type="text" />
				<input type="submit" value="Sign up" />
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>

<div id="my_footer">
	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<?php dynamic_sidebar('footer_column_1'); ?>
			</div>
			
			<div class="span2">
				<?php dynamic_sidebar('footer_column_2'); ?>
			</div>
			
			<div class="span2">
				<?php dynamic_sidebar('footer_column_3'); ?>
			</div>
			
			<div class="span2">
				<?php dynamic_sidebar('footer_column_4'); ?>
			</div>
			
			<div class="span3">
				<?php dynamic_sidebar('footer_column_5'); ?>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div class="container bellow_footer">
		<div class="row-fluid">
			<div class="span5">
				<?php dynamic_sidebar('bellow_footer_left');?>
			</div>
			<div class="span4">
				<?php dynamic_sidebar('bellow_footer_center');?>
			</div>
			<div class="span3">
				<?php dynamic_sidebar('bellow_footer_right');?>
			</div>
		</div>
	</!div>
</div>

<?php wp_footer(); ?>

<?php if($navi_type){ ?>
	<script>
		//<![CDATA[
/*global jQuery:false */
	jQuery('.nav.nav-pills').find('.dropdown').addClass('no-hover');
	//]]>
	</script>
<?php }else{ ?>	
	<script>
		//<![CDATA[
/*global jQuery:false */
	jQuery('.nav.nav-pills').find('.dropdown-toggle').addClass('disabled');
	//]]>
	</script>
<?php } ?>

<script>jQuery('.widget_shopping_cart_content buttons a').removeClass("button").addClass("btn btn-small btn-primary");</script>

<?php get_template_part('includes/custom_js') ?>

</body>
</html>