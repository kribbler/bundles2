<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php $i++; ?>
<article class="blog-post <?php echo get_post_class() ?>" id="post-<?php the_ID(); ?> ">
	<?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');?>

	<?php if (has_post_thumbnail()) { ?>
    <a href="<?php echo $src[0] ?>" rel="prettyPhoto" title="<?php echo $post->post_title ?>"><?php the_post_thumbnail('single'); ?></a>
	<?php } ?>
	<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	<?php include(TEMPLATEPATH . '/inc/blog-info.php'); ?>
	<?php the_excerpt(); ?>
</article>
<hr />
<?php endwhile; ?>
<?php else : ?>
<h2 class="blog-title">Not Found</h2>
<?php endif; ?>
<div class="clear"></div>