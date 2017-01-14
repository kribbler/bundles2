
<?php get_header(); ?>
<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>
<?php $full_width = get_post_meta($post->ID, 'portfolio_options_full', true);?>

		<?php get_template_part('includes/heading' ) ?>
		<div id="main" class="page-title-template <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
			<div class="container">
				<div class="row-fluid">
					<div class="<?php if ($full_width){?>span12<?php }else{?>span9<?php }?> page-content">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php get_template_part('includes/single-portfolio-post' ) ?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                    <?php endif; ?>
                    </div>
                    <?php if (!$full_width){?>
                    <?php get_sidebar(); ?>
                    <?php }?>
				</div>
			</div>
		</div>
        
<?php get_footer(); ?>