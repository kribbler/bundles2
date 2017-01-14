<?php
/**
 * The template for displaying Author Archive pages.
 
 */

get_header();
include(TEMPLATEPATH . '/inc/data.php'); ?>
<?php
if ( have_posts() )
	the_post();
?>
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php echo get_the_author().' Archives'?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php printf( __( 'Author Archives: %s', $domain ), get_the_author() ); ?></div>
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php
				include(TEMPLATEPATH . '/inc/author.php');

				rewind_posts();
				get_template_part( 'loop', 'author' );
				if (have_posts()) afl_pager($posts_count, $per_page, $paged);
				?>
            </section>
			<?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
