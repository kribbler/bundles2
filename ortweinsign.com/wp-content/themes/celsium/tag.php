<?php
/**
 * The template for displaying Tag Archive pages.
 *
 
 */
get_header();
include(TEMPLATEPATH . '/inc/data.php');?>
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php printf(__('Tags: %s', $domain), single_tag_title('', false));?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php printf(__('Tag Archives: %s', $domain), single_tag_title('', false));?></div>
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php get_template_part('loop', 'tag');
				if (have_posts()) afl_pager($posts_count, $per_page, $paged);
				?>
            </section>
			<?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>