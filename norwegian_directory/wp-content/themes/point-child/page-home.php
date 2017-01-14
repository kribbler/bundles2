<?php
/*
 * Template Name: Home Page Child
 */

?>

<?php $mts_options = get_option('point'); ?>
<?php get_header(); ?>
<div id="page" class="home-page">
	<div class="content">
		<?php set_categories(); ?>

	<?php //if (!is_front_page()) get_sidebar(); ?>
	<?php get_footer(); ?>