<?php

#the_post();

 /* Ajax check  */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php get_template_part('includes/single-post-ajax' );?>
<?php endwhile; endif; ?>

<?php } else { ?>

<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>
<?php $blog_post_a_type = ot_get_option('blog_post_a_type');
$blog_post_a_speed = ot_get_option('blog_post_a_speed');
$blog_post_a_delay = ot_get_option('blog_post_a_delay');
$blog_post_a_offset = ot_get_option('blog_post_a_offset');
$blog_post_a_easing = ot_get_option('blog_post_a_easing');

if(!$blog_post_a_speed){
	$blog_post_a_speed = '1000';
}
if(!$blog_post_a_delay){
	$blog_post_a_delay = '0';
}

if(!$blog_post_a_offset){
	$blog_post_a_offset = '80';
}

$animation_att = ' data-animation="'.$blog_post_a_type.'" data-speed="'.$blog_post_a_speed.'" data-delay="'.$blog_post_a_delay.'" data-offset="'.$blog_post_a_offset.'" data-easing="'.$blog_post_a_easing.'"';

?>
<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			<div class="col-md-9 page-content lpd-sidebar-page">
			
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('includes/single-post' );?>
					<div class="lpd_comment_wrap<?php if($blog_post_a_type){?> cre-animate<?php }?>"<?php if($blog_post_a_type){ echo $animation_att;}?>>
					<?php comments_template('', true); ?>
					</div>
                <?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                <?php endif; ?>
				
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>

<?php } ?>