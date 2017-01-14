
<?php get_header(); ?>

		<?php get_template_part('includes/heading' ) ?>
		<div id="main" class="page-title-template">
			<div class="container">
				<div class="row-fluid">
					<div class="span9 page-content">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/member-post' ) ?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                    <?php endif; ?>
                    </div>
                    <?php get_sidebar(); ?>
				</div>
			</div>
		</div>
        
<?php get_footer(); ?>