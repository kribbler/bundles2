<?php
/**
 * The template for displaying Category Archive pages.
 *
 
 */

get_header();
include(TEMPLATEPATH . '/inc/data.php');?>

<!--container-->
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1>Blog: <?php printf( __( '%s', $domain ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php printf( __( '%s', $domain ), '<span>' . single_cat_title( '', false ) . '</span>' );?></div>
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				* If you want to overload this in a child theme then include a file
				* called loop-category.php and that will be used instead.
				*/
				get_template_part( 'loop', 'category' );
				if (have_posts()) afl_pager($posts_count, $per_page, $paged);
				?>
            </section>
			<?php get_sidebar(); ?>

        </div>
    </div>
</section>
<?php get_footer(); ?>