<?php
/**
 * Template Name: Custom Blog
 *
 *
 */

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>
<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">

<?php endif; ?>



            <section id="page-sidebar" class="alignleft span9">

                <?php 
                $paged = intval(get_query_var('paged'));
                if(empty($paged) || $paged == 0) $paged = 1;
                $offset = ($paged - 1) * 2;
                
                $args = array( 'posts_per_page' => 2, 'cat' => 4, 'offset' => $offset );

                $loop = new WP_Query($args);
                $k = 0; $end = false;

                while ( $loop->have_posts() ) : $loop->the_post(); ?>

                    <?php if ($k % 2 == 0) {
                        $class = "one_half";
                        ?>
                        <div style="margin-bottom: 20px;">
                    <?php } else {
                        $class = "one_half  et_column_last";
                    }?>

                    <div class="<?php echo $class;?>">
                        <?php echo the_content(); ?>
                    </div>
                    
                    <?php if (++$k % 2 == 0) { $end = true;?>
                        </div>
                        <div class="clear" style="clear: both"></div>
                    <?php } 
                endwhile; ?>
</section>
                <?php if (!$end) { ?>
                    </div>
                <?php } 

            afl_pager($loop->found_posts, $loop->query['posts_per_page'], $paged); ?>

        <?php wp_reset_postdata();?>

<?php if ( ! $is_page_builder_used ) : ?>

            </div> <!-- #left-area -->

            <?php get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>