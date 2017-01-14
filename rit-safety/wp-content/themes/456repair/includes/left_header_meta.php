<?php $left_headermeta = ot_get_option('left_headermeta');?>
<?php $h_sm_locations = ot_get_option('h_sm_locations');?>

<?php if($h_sm_locations=="left_hm"):?>
	<?php get_template_part('includes/header_social_media' ) ?>
<?php endif; ?>

<?php if($left_headermeta){ ?>
	<div class="custom-meta left-custom-meta"><?php echo $left_headermeta; ?></div>
<?php }else{?>
	<?php if ( has_nav_menu( 'left-meta-menu' ) ) { ?>
		<?php wp_nav_menu( array( 'theme_location' => 'left-meta-menu', 'menu_class' => 'left-meta-menu meta-menu', 'container' => '', 'depth' => 1  ) ); ?>
	<?php } ?>
<?php } ?>
<div class="clearfix"></div>