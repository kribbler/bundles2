<?php

#the_post();

 /* Ajax check  */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php get_template_part('includes/single-team-post-ajax' );?>
<?php endwhile; endif; ?>

<?php } else { ?>

<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>

<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>

<div id="main" class="inner-page <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			<div class="col-md-9 page-content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/single-team-post' );?>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
            <?php endif; ?>
            </div>
            <?php get_sidebar(); ?>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>

<?php } ?>