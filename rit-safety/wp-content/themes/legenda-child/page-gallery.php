<?php
/*
Template Name: Gallery Page
*/

get_header('gallery');
?>

<?php if(have_posts()): while(have_posts()) : the_post(); ?>
									
					<?php the_content(); ?>

					<div class="post-navigation">
						<?php wp_link_pages(); ?>
					</div>

				<?php endwhile; endif;?>

<?php
	get_footer('gallery');
?>