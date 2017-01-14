<?php $st_buttons = ot_get_option('st_buttons'); ?>

<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
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

<div id="post-<?php the_ID(); ?>" class="single-post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?><?php if($blog_post_a_type){?> cre-animate<?php }?>"<?php if($blog_post_a_type){ echo $animation_att;}?>>
	<?php if ($video) { ?>
	<div class="lpd-video-responsive"><iframe class="" width="780" height="439" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
	<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
	<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
	<?php }?>
	
	<div class="single-post-content">
		<div class="single-post-meta">
			<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a>
			<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><?php echo get_the_author(); ?></a>
			<a href="<?php comments_link(); ?>" class="comment"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a>
		</div>
		<div class="single-post-content-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<div class="clearfix"></div>
		</div>
		<?php if ($st_buttons){?>
		<div class="st-share">
			<?php echo $st_buttons;?>
		</div>
		<div class="divider10"></div>
		<?php }else{?>
			<div class="divider20"></div>
		<?php }?>
	</div>
</div>