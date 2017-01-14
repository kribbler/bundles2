<?php $h_sm_locations = ot_get_option('h_sm_locations'); ?>

<?php get_template_part('includes/logo' ) ?>
<?php get_template_part('includes/header_search_mobile' ) ?>
<?php get_template_part('includes/header-bottom-search' ) ?>
<?php if($h_sm_locations!="right_h"):?>
	<?php get_template_part('includes/cart' ) ?>
<?php endif; ?>
<?php if($h_sm_locations=="right_h"):?>
	<?php get_template_part('includes/header_social_media' ) ?>
<?php endif; ?>
<?php get_template_part('includes/menu' ) ?>
