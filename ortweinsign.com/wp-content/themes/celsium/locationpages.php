<?php

/**

 * Template Name: Location Pages

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
            <!-- <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php the_title();?></div> -->
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
					<!-- (don't need the title twice) <h2><?php the_title();?></h2> -->
					<?php the_content();?>
					<?php } ?>

            <section id="page-sidebar" class="oimagesbot">
			<div>
				<a href="/lifecycle-maintenance-protection/"><img class="aligncenter wp-image-1516" src="/wp-content/uploads/2011/08/intellocare_231x133.jpg" alt="" width="211" /></a>
				<a href="/complete-branding/"><img class="aligncenter wp-image-1516" src="/wp-content/uploads/2011/08/intellobrand_231x133.jpg" alt="" width="211" /></a>
				<a href="/branding-implementation/"><img class="aligncenter wp-image-1510" src="/wp-content/uploads/2011/08/intellosure_231x133.jpg" alt="" width="211" /></a>
				<a href="/brand-funding-leverage/"><img class="aligncenter wp-image-1514" src="/wp-content/uploads/2011/08/intellofund_231x133.jpg" alt="" width="211" /></a>
			</div>
	    </section>


            </section>
            <?php get_sidebar(); ?>
		</div>
    </div>
</section>
<?php get_footer(); ?>

