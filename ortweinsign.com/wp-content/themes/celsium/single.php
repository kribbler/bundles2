<?php
/**
 * The Template for displaying all single posts.
 
 */

get_header(); ?>
<!--container-->
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php the_title();?></h1>
            <!-- <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php the_title();?></div> -->
        </div>
	</section>
	<div class="container">
		<div class="row">
			<section id="page-sidebar" class="alignleft span9">
				<article class="blog-post">
					<?php the_post();?>
					<!--<?php if( get_post_type($post->ID) != 'portfolio') include(TEMPLATEPATH . '/inc/info.php'); ?>-->
					<?php if (has_post_thumbnail()) { ?>
						<?php $src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');?>
						<a href="<?php echo $src[0] ?>" rel="prettyPhoto" title="<?php echo $post->post_title ?>"><?php the_post_thumbnail('single'); ?></a>
					<?php } ?>
					<?php the_content();?>
					<?php edit_post_link('Edit this entry','','.'); ?>
					<?php if (get_post_type($post->ID) == 'post' && get_the_author_meta( 'description' )) include(TEMPLATEPATH . '/inc/author.php'); ?>
				</article>
				<div class="clear"></div>

				<?php comments_template(); ?>
			</section>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
