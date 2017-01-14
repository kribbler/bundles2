<?php get_header();
include(TEMPLATEPATH . '/inc/data.php'); ?>
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php echo get_search_query() ?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php printf( __( 'Search Results: %s', $domain ), get_search_query() ); ?></div>
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php if ( have_posts() ) : ?>
					<?php get_template_part( 'loop', 'search' );
					if (have_posts()) afl_pager($posts_count, $per_page, $paged);?>
				<?php else : ?>
					<h4><?php _e( 'Nothing Found', $domain ); ?></h4>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'verona' ); ?></p>
					<br/>
					<?php get_search_form(); ?>
				<?php endif; ?>
            </section>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>