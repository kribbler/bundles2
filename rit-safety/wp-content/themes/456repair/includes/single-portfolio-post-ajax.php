<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
<?php $description = get_post_meta($post->ID, 'portfolio_options_textarea', true);?>
<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>

<div class="cbp-l-project-title"><?php the_title(); ?></div>
<div class="cbp-l-project-subtitle"><?php #$attachment_caption = get_post(get_post_thumbnail_id( $post->ID )); echo($attachment_caption->post_excerpt);?><?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></div>
<?php if ($video) { ?>

<div class="lpd-video-responsive"><iframe class="" width="780" height="439" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe></div>

<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'cubeportfolio-project' ); echo $image[0];?>" alt="<?php $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
if(count($alt)) echo $alt;?>" class="cbp-l-project-img">
<?php } else{?>

<div class="no-content-matched"><?php _e('Sorry, no contnet matched your criteria.', GETTEXT_DOMAIN) ?></div>

<?php }?>

<div class="cbp-l-project-container">
	<div class="cbp-l-project-desc">
	    <div class="cbp-l-project-desc-title"><span><?php _e('Project Description', GETTEXT_DOMAIN); ?></span></div>
	    <div class="cbp-l-project-desc-text"><p><?php if($description){ echo $description; } else { the_excerpt(); } ?></p></div>
	</div>
	<div class="cbp-l-project-details">
		<div class="cbp-l-project-details-title"><span><?php _e('Project Details', GETTEXT_DOMAIN); ?></span></div>
		<?php if($details){?>
		<ul class="cbp-l-project-details-list">
            <?php
            $separator = "%%";
            $output = '';
            foreach ($details as $item) {
                if($item){
                    list($item_text1, $item_text2) = explode($separator, trim($item));
                    $output .= '<li><strong>' . $item_text1 . '</strong> ' . do_shortcode($item_text2) . '</li>';
                }
            }
            echo $output;
            ?>
		</ul>
		<?php }?>
		
        <?php if($link){?>
            <a href="<?php echo $link;?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('View More', GETTEXT_DOMAIN); ?></a>
        <?php } else{?>
            <a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('Read More', GETTEXT_DOMAIN); ?></a>
        <?php }?>
	</div>
</div>