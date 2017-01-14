
<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>

<div class="cbp-l-project-title"><?php the_title(); ?></div>
<div class="cbp-l-project-subtitle"><?php #$attachment_caption = get_post(get_post_thumbnail_id( $post->ID )); echo($attachment_caption->post_excerpt);?><?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></div>
<?php if ($video) { ?>

<div class="lpd-video-responsive"><iframe class="" width="780" height="439" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe></div>

<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'cubeportfolio-project' ); echo $image[0];?>" alt="<?php $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
if(count($alt)) echo $alt;?>" class="cbp-l-project-img">
<?php }?>

<div class="cbp-l-project-container">
	<div class="cbp-l-project-desc">
	    <div class="cbp-l-project-desc-title"><span><?php _e('Short Description', GETTEXT_DOMAIN); ?></span></div>
	    <div class="cbp-l-project-desc-text"><p><?php the_excerpt();?></p></div>
	</div>
	<div class="cbp-l-project-details">
		<div class="cbp-l-project-details-title"><span><?php _e('Post Details', GETTEXT_DOMAIN); ?></span></div>

		<ul class="cbp-l-project-details-list">
            <li><strong><?php _e('Published', GETTEXT_DOMAIN); ?>:</strong><a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a></li>
            <li><strong><?php _e('Author', GETTEXT_DOMAIN); ?>:</strong><a href="<?php echo get_author_posts_url($post->post_author); ?>" class="author"><?php the_author_meta( 'user_nicename', $post->post_author); ?> </a></li>
            <li><strong><?php _e('Comments', GETTEXT_DOMAIN); ?>:</strong><a href="<?php comments_link(); ?>" class="comment"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a></li>
		</ul>
		
        <?php if($link){?>
            <a href="<?php echo $link;?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('View More', GETTEXT_DOMAIN); ?></a>
        <?php } else{?>
            <a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('Read More', GETTEXT_DOMAIN); ?></a>
        <?php }?>
	</div>
</div>