<?php
/*
Template Name: Full Width Template
*/
?>

<?php get_header(); ?>

		<div id="page-title" class="container">
			<div class="row-fluid">
				<div class="span12"><h2><span><?php the_title();?></span></h2></div>
			</div>
		</div>
		<div id="main" class="page-title-template">
			<div class="container">
				<div class="row-fluid">
					<div class="span12 page-content">
			        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                        <?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
                        <?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
			            <img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-page' ); echo $image[0];?>" />
			        <?php }?>
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content();?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                    <?php endif; ?>
                    </div>
				</div>
			</div>
		</div>
        
<?php get_footer(); ?>