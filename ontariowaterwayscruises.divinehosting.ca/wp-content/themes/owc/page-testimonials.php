<?php
get_header(); ?>

<div class="bottom-border">
	<h2 class="center_me">What past passengers had to say.</h2>
	<div class="white-wrap container page-content">
		<div class="row">
			<div class="col-lg-2"><div class="testimonial_prev"></div></div>
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
			<div class="col-lg-2"><div class="testimonial_next"></div></div>
		</div>
	</div>
</div>

<?php get_footer();