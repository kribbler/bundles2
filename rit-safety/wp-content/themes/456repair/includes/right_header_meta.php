<?php $right_headermeta = ot_get_option('right_headermeta');?>
<?php $h_sm_locations = ot_get_option('h_sm_locations');?>
<?php $header_type = ot_get_option('header_type'); ?>

<?php if($header_type=="type1"){?>
	<?php get_template_part('includes/wpml-meta' ) ?>
	<?php get_template_part('includes/wpml-mobile' ) ?>
<?php } ?>

<?php if($h_sm_locations=="right_hm"):?>
	<?php get_template_part('includes/header_social_media' ) ?>
<?php endif; ?>

<!-- if not social add class "margin-right" -->

<?php if($right_headermeta){ ?>
	<div class="custom-meta right-custom-meta "><?php echo $right_headermeta; ?></div>
<?php }else{?>
	<?php if ( has_nav_menu( 'right-meta-menu' ) ) { ?>
		<?php wp_nav_menu( array( 'theme_location' => 'right-meta-menu', 'menu_class' => 'right-meta-menu meta-menu', 'container' => '', 'depth' => 1  ) ); ?>
	<?php } ?>
<?php } ?>
<div class="clearfix"></div>