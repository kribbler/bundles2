<?php get_header(); ?>
<?php 
plugin('jquery');
plugin('lightbox');
wp_enqueue_script('cruises','/wp-content/plugins/sh-cruises/cruises.js');

?>
<div class="white-wrap container-fluid">
	<div class="row">
		<div class="col-lg-12 bottom-border">
			<h2 class="center_me"><?php the_title(); ?></h2>
			<h3 class="center_me"><?php echo rwmb_meta('dd_video_title'); ?></h3>
			<div class="center_me">
				<?php echo apply_filters('the_content', rwmb_meta( 'dd_video_url' )); ?>
			</div>
		</div>
	</div>
</div>

<div class="bottom-border">
	<div class="white-wrap container page-content">
		<div class="row">
			<div class="col-lg-2">&nbsp;</div>
			<div class="col-lg-8">
				<?php if (have_posts()): ?>
					<?php while(have_posts()) : the_post(); ?>
						<div class="center_me">
							<?php the_content(); ?>
						</div>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part('404'); ?>
				<?php endif; ?>
			</div>
			<div class="col-lg-2">&nbsp;</div>
		</div>
	</div>
</div>

<div class="white-wrap container margin_bottom_40">
	<h2>Gallery</h2>
	<div class="gallery row">
		<?php echo do_shortcode( rwmb_meta( 'dd_oba_gallery_images' ) ); ?>
		<div class="help help_photo">
			Click/tap to view larger photo
		</div>
	</div>
</div>
<?php get_footer();