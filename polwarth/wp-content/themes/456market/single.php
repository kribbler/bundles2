
<?php get_header(); ?>
<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>

		<?php get_template_part('includes/heading' ) ?>
		<div id="main" class="page-title-template <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
			<div class="container">
				<div class="row-fluid">
					<div class="span9 page-content">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/single-post' ) ?>
						<div class="row-fluid"><?php comments_template('', true); ?></div>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                    <?php endif; ?>
                    </div>
                    <?php get_sidebar(); ?>
				</div>
			</div>
		</div>
        
<?php get_footer(); ?>