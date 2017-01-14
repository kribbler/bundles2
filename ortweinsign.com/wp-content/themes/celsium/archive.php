<?php
/**
 * The template for displaying Archive pages.
 
 */

get_header();
include(TEMPLATEPATH . '/inc/data.php');
if ( have_posts() ) the_post();
?>


<section id="container">
		<section class="container">
            <!--breadcrumbs -->
            <div class="container breadcrumbs">
                <h1><?php _e( 'Blog Archives', $domain ); ?></h1>
                <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily: <span>%s</span>', $domain ), get_the_date() ); ?>
						<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly: <span>%s</span>', $domain ), get_the_date( 'F Y' ) ); ?>
						<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly: <span>%s</span>', $domain ), get_the_date( 'Y' ) ); ?>
						<?php else : ?>
						<?php _e( 'Blog Archives', $domain ); ?>
						<?php endif; ?></div>
            </div>
		</section>
        <div class="container">
            <div class="row">
                <section id="page-sidebar" class="alignleft span9">
					<?php rewind_posts();
					get_template_part( 'loop', 'archive' );
					if (have_posts()) afl_pager($posts_count, $per_page, $paged);
					?>
				</section>
				<?php get_sidebar(); ?>
            </div>
        </div>
</section>

<?php get_footer(); ?>
