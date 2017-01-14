<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
<?php $blog_front_a_type = ot_get_option('blog_front_a_type');
$blog_front_a_speed = ot_get_option('blog_front_a_speed');
$blog_front_a_delay = ot_get_option('blog_front_a_delay');
$blog_front_a_offset = ot_get_option('blog_front_a_offset');
$blog_front_a_easing = ot_get_option('blog_front_a_easing');

if(!$blog_front_a_speed){
	$blog_front_a_speed = '1000';
}
if(!$blog_front_a_delay){
	$blog_front_a_delay = '0';
}

if(!$blog_front_a_offset){
	$blog_front_a_offset = '80';
}

$animation_att = ' data-animation="'.$blog_front_a_type.'" data-speed="'.$blog_front_a_speed.'" data-delay="'.$blog_front_a_delay.'" data-offset="'.$blog_front_a_offset.'" data-easing="'.$blog_front_a_easing.'"';

?>

<div class="<?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>blog-post">
	<h2 class="blog-post-title<?php if($blog_front_a_type){?> cre-animate<?php }?>"<?php if($blog_front_a_type){ echo $animation_att;}?>><a href="<?php if ( $link ) {echo $link;}else{the_permalink();}?>"><?php the_title(); ?></a></h2>
	
	<div class="blog-post-taxo lpd-animated-link<?php if($blog_front_a_type){?> cre-animate<?php }?>"<?php if($blog_front_a_type){ echo $animation_att;}?>>
	<?php if($categories = wp_get_post_categories($post->ID)){?>
	<?php _e('Categories', GETTEXT_DOMAIN)?>:
	<ul>
        <?php
        $cat_id = '';
        foreach ($categories as $category) {
           $cat_id .= $category. ', ';
        }
        $categories=get_categories('include='.$cat_id.'');
        foreach($categories as $category) {
            $results[] = '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __('View all posts in %s', GETTEXT_DOMAIN), $category->name ) . '" ' . '>' . $category->name.'</a></li>';
        }
        echo implode(", ", $results);?>
	</ul>
    <?php }?>
	<?php if($tags = wp_get_post_tags($post->ID, array( 'fields' => 'ids' ))){?>
    <?php foreach ($tags as $tag) {
       $tag_id .= $tag. ', ';
    }
    $tags=get_tags('include='.$tag_id.'');?>
    <?php if($tags){?>    
		<?php _e('Tags', GETTEXT_DOMAIN)?>:
	<?php }?>
	<ul>
        <?php if($tags){
	        $results_tags = '';
	        foreach($tags as $tag) {
	            $results_tags[] = '<li><a href="' . get_tag_link( $tag->term_id ) . '" title="' . sprintf( __('View all posts in %s', GETTEXT_DOMAIN), $tag->name ) . '" ' . '>' . $tag->name.'</a></li>';
	        }
	        echo implode(", ", $results_tags);
        }?>
	</ul>
    <?php }?>
	</div>						
								
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {?> 
		<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
		<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
		<a href="<?php if ( $link ) {echo $link;}else{the_permalink();}?>"<?php if($blog_front_a_type){?> class="cre-animate"<?php }?><?php if($blog_front_a_type){ echo $animation_att;}?>>
			<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
		</a>
	<?php } elseif ( $video ) {?>
		<?php if(has_post_thumbnail()){?>
			<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
			<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
			<a href="<?php the_permalink();?>"<?php if($blog_front_a_type){?> class="cre-animate"<?php }?><?php if($blog_front_a_type){ echo $animation_att;}?>>
				<img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
			</a>
		<?php }else{?>
			<div class="lpd-video-responsive<?php if($blog_front_a_type){?> cre-animate<?php }?>"<?php if($blog_front_a_type){ echo $animation_att;}?>><iframe class="" width="780" height="439" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
		<?php }?>
	<?php }?>
					
    <div class="blog-post-content<?php if($blog_front_a_type){?> cre-animate<?php }?>"<?php if($blog_front_a_type){ echo $animation_att;}?>>
    <?php if ( $link ) { ?>
    <?php global $more;?>
    <?php $more = 1;?>
    <?php the_content(); ?>
    <?php }else{?>
    <?php global $more;?>
    <?php $more = 0;?>
    <?php the_content(__('read more &rarr;', GETTEXT_DOMAIN)); ?>
    <?php }?>
    </div>
    
    <div class="blog-post-meta lpd-animated-link<?php if($blog_front_a_type){?> cre-animate<?php }?>"<?php if($blog_front_a_type){ echo $animation_att;}?>>
		<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a>
		<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><?php echo get_the_author(); ?></a>
		<?php if ( !$link ) { ?><a href="<?php comments_link(); ?>" class="comment"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a><?php }?>
    </div>
</div>