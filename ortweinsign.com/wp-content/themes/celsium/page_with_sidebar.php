<?php

/**

 * Template Name: Page with sidebar

 *

 

 */
get_header();
?>
<section id="container">
	<section class="container">
		<?php if(!is_home() && !is_front_page()):?>
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php the_title();?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php the_title();?></div>
        </div>
		<?php endif; ?>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php the_post();
				if(get_post_meta($post->ID, 'afl_composer', true)=='on') {
					$items = afl_get_te_data($post->ID);?>
					<?php
					print(do_shortcode(afl_to_shortcode($items)));
					?>
					<?php } else { ?>
					<h2><?php the_title();?></h2>
					<?php the_content();?>
					<?php } ?>
            </section>
            <?php get_sidebar(); ?>
		</div>
    </div>
</section>
<?php get_footer(); ?>

