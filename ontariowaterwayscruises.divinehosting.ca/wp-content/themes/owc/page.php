<?php
/*
 * Template Name: Default
 */
?>

<?php get_header(); ?>

<div class="white-wrap container page-content margin_bottom_40">
	<div class="row">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-8">
			<?php if (have_posts()): ?>
				<?php while(have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part('404'); ?>
			<?php endif; ?>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>
</div>

<?php get_footer(); ?>
