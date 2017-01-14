<?php
/**
 * The main template file.
 * Template Name: Blog
 *
 *
 */

get_header(); ?>
<?php include(TEMPLATEPATH . '/inc/data.php'); ?>

<!--container-->
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1>Blog</h1>
           <!-- <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp Blog.</div> -->
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
                <?php 
                $paged = intval(get_query_var('paged'));
                if(empty($paged) || $paged == 0) $paged = 1;
                $offset = ($paged - 1) * $per_page;
                
                $args = array( 'posts_per_page' => $per_page, 'cat' => 77, 'offset' => $offset );
                $loop = new WP_Query($args);

                
                get_template_part( 'loop', 'blog' );
                afl_pager($loop->found_posts, $loop->query['posts_per_page'], $paged);
                
				?>
            </section>
            <?php get_sidebar(); ?>

    	</div>
    </div>
</section>
<?php get_footer(); ?>
