<?php 
    $st_javascript = ot_get_option('st_javascript');
    $st_javascript_p = ot_get_option('st_javascript_p');

    $footer_color = ot_get_option('footer_color');
    $footer_bg_type = ot_get_option('footer_bg_type');
    $footer_bg_img = ot_get_option('footer_bg_img');
    $footer_bg_style = ot_get_option('footer_bg_style');
    $bottom_footer_color = ot_get_option('bottom_footer_color');
    $bottom_footer_bg_type = ot_get_option('bottom_footer_bg_type');
    $bottom_footer_custom_color = ot_get_option('bottom_footer_custom_color');
    
	$cc = ot_get_option('cc');
	$footer_copyright = ot_get_option('footer_copyright');
	$footer_logo = ot_get_option('footer_logo');
    
    if($footer_bg_img){
	    if($footer_bg_style=='full_width'){
		    $style = ' style="background-color:transparant;background-image:url('.$footer_bg_img.');background-repeat: none;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;"';  
	    } elseif($footer_bg_style=='parallax'){
		    $style = ' style="background-color:transparant;background-image:url('.$footer_bg_img.');background-repeat: none;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;"';  
	    } elseif($footer_bg_style=='repeat'){
		    $style = ' style="background-color:'.$footer_color.';background-image:url('.$footer_bg_img.');background-repeat: repeat;"';
	    }else{
		   $style = ' style="background-color:'.$footer_color.'"';
	    }
    }else{
	   $style = ' style="background-color:'.$footer_color.'"';
    }
?>

		<?php if ( is_active_sidebar(6)||is_active_sidebar(2) ){?>
		<div id="footer-top">
			<div class="container">
				<div class="row">
				<?php if ( is_active_sidebar(6) ){?>
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Top 3 Column') ) ?>
				<?php } else{?>
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Top') ) ?>
				<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>

	<div id="footer"<?php if ($footer_color) { echo $style; } ?><?php if($footer_bg_style=='parallax') {?> data-stellar-background-ratio="0.5"<?php } ?>>

		<?php get_template_part('includes/footer-meta') ?>
		<?php if ( is_active_sidebar(7)||is_active_sidebar(3) ){?>
		<div class="footer<?php if (!$footer_bg_type) {?>  dark-theme<?php } ?>">
			<div class="container">
				<div class="row">
				<?php if ( is_active_sidebar(7) ){?>
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3 Column') ) ?>
				<?php } else{?>
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer') ) ?>
				<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ( $cc||$footer_copyright||$footer_logo||has_nav_menu( 'footer-menu' ) ){?>
		<div class="footer-bottom<?php if (!$bottom_footer_bg_type) {?> dark-theme<?php } ?>"<?php if ($bottom_footer_custom_color) { if ($bottom_footer_color) {?> style="background-color:<?php echo $bottom_footer_color;?>"<?php } }?>>
			<div class="container">
				<div class="row">
					<?php get_template_part('includes/footer-bottom-meta') ?>
					<?php get_template_part('includes/payment-method') ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<?php get_template_part('includes/custom_css') ?>
<?php get_template_part('includes/custom_js') ?>

<?php if (is_singular()) {?>
<!-- sharethis buttons -->
	<?php if ($st_javascript) {?>
		<?php echo $st_javascript;?>
	<?php } ?>
<?php } ?>

<?php if (is_singular('portfolio')) {?>
<!-- sharethis buttons -->
	<?php if ($st_javascript_p) {?>
		<?php echo $st_javascript_p;?>
	<?php } ?>
<?php } ?>
    
<?php wp_footer(); ?>

</body>
</html>