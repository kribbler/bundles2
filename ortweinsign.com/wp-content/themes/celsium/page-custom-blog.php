<?php
/**
 * Template Name: Custom Blog
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
                $offset = ($paged - 1) * 2;
                
                $args = array( 'posts_per_page' => 2, 'cat' => 78, 'offset' => $offset );

                $loop = new WP_Query($args);
                $k = 0; $end = false;

                while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php if ($k % 2 == 0) {?>
                        <div class="span12" style="margin-bottom: 20px;">
                    <?php } ?>
                    
                    <div class="alignleft span4">
                        <?php echo the_content(); ?>
                    </div>
                    
                    <?php if (++$k % 2 == 0) { $end = true;?>
                        </div>
                        <hr />
                    <?php } 
                endwhile; ?>

                <?php if (!$end) { ?>
                    </div> 
                <?php } 

            afl_pager($loop->found_posts, $loop->query['posts_per_page'], $paged); ?>

        <?php wp_reset_postdata();?>

      

            </section>

            <?php get_sidebar(); ?>

    	</div>
    </div>
</section>
<?php get_footer(); ?>
