<?php

get_header(); ?>
<?php 
plugin('jquery');
plugin('lightbox');
wp_enqueue_script('cruises','/wp-content/plugins/sh-cruises/cruises.js');

?>
<div class="white-wrap container-fluid">
	<div class="row">
		<div class="col-lg-12 bottom-border">
			<h1 id="passenger_title" class="center_me"><?php the_title(); ?></h1>
			<h3 class="center_me"><?php echo rwmb_meta('dd_pa_video_title'); ?></h3>
			<div class="container">
				<div class="col-lg-2">&nbsp;</div>
				<div class="col-lg-8 center_me">
					<?php echo apply_filters('the_content', rwmb_meta( 'dd_pa_video_url' )); ?>
					<?php echo apply_filters('the_content', rwmb_meta( 'dd_pa_video_description' )); ?>
				</div>
				<div class="col-lg-2">&nbsp;</div>
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
						<?php if (!is_page('employment')) {?>
						<div class="center_me">
							<p>
								<a href="<?php echo site_url();?>/cruise-dates/">Cruise Dates</a> | <a href="#">View Rates</a>
							</p>
							<p>
								<a class="btn" href="<?php echo site_url();?>/request-a-reservation/">Request a Reservation</a>
							</p>
						</div>
						<?php } ?>
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
		<?php echo do_shortcode( rwmb_meta( 'dd_pa_gallery_images' ) ); ?>
		<div class="help help_photo">
			Click/tap to view larger photo
		</div>
	</div>
</div>
<?php get_footer();