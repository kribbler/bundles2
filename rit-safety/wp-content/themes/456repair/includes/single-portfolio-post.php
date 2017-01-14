<?php $st_buttons_p = ot_get_option('st_buttons_p'); ?>

<?php $video = lpd_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>
<?php $portfolio_post_a_type = ot_get_option('portfolio_post_a_type');
$portfolio_post_a_speed = ot_get_option('portfolio_post_a_speed');
$portfolio_post_a_delay = ot_get_option('portfolio_post_a_delay');
$portfolio_post_a_offset = ot_get_option('portfolio_post_a_offset');
$portfolio_post_a_easing = ot_get_option('portfolio_post_a_easing');

if(!$portfolio_post_a_speed){
	$portfolio_post_a_speed = '1000';
}
if(!$portfolio_post_a_delay){
	$portfolio_post_a_delay = '0';
}

if(!$portfolio_post_a_offset){
	$portfolio_post_a_offset = '80';
}

$animation_att_pp = ' data-animation="'.$portfolio_post_a_type.'" data-speed="'.$portfolio_post_a_speed.'" data-delay="'.$portfolio_post_a_delay.'" data-offset="'.$portfolio_post_a_offset.'" data-easing="'.$portfolio_post_a_easing.'"';

?>
<?php $portfolio_thumbnails_a_type = ot_get_option('portfolio_thumbnails_a_type');
$portfolio_thumbnails_a_speed = ot_get_option('portfolio_thumbnails_a_speed');
$portfolio_thumbnails_a_delay = ot_get_option('portfolio_thumbnails_a_delay');
$portfolio_thumbnails_a_offset = ot_get_option('portfolio_thumbnails_a_offset');
$portfolio_thumbnails_a_easing = ot_get_option('portfolio_thumbnails_a_easing');

if(!$portfolio_thumbnails_a_speed){
	$portfolio_thumbnails_a_speed = '1000';
}
if(!$portfolio_thumbnails_a_delay){
	$portfolio_thumbnails_a_delay = '0';
}

if(!$portfolio_thumbnails_a_offset){
	$portfolio_thumbnails_a_offset = '80';
}

$animation_att = ' data-animation="'.$portfolio_thumbnails_a_type.'" data-speed="'.$portfolio_thumbnails_a_speed.'" data-delay="'.$portfolio_thumbnails_a_delay.'" data-offset="'.$portfolio_thumbnails_a_offset.'" data-easing="'.$portfolio_thumbnails_a_easing.'"';

?>

<div id="post-<?php the_ID(); ?>" class="single-post <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
	<div class="row">
	
	<?php if ($video) { ?>
	
	<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
	<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	
		<div class="col-md-8">
			<div class="lpd-video-responsive<?php if($portfolio_thumbnails_a_type){?> cre-animate<?php }?>"<?php if($portfolio_thumbnails_a_type){ echo $animation_att;}?>><iframe class="" width="780" height="439" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
			<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?><img class="page-thumbnail img-responsive" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio-page' ); echo $image[0];?>" /><?php }?>
			<?php $images = get_post_meta($post->ID, 'vdw_gallery_id', true);?>
			<?php if ($images) {?>
				<?php foreach ($images as $image) {?>
					<img class="page-thumbnail img-responsive<?php if($portfolio_thumbnails_a_type){?> cre-animate<?php }?>" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( $image, 'portfolio-page' ); echo $image[0];?>"<?php if($portfolio_thumbnails_a_type){ echo $animation_att;}?> />
				<?php }?>
			<?php }?>
		</div>
	
	<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	
	<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
	<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
	
		<div class="col-md-8">
			<img class="page-thumbnail img-responsive<?php if($portfolio_thumbnails_a_type){?> cre-animate<?php }?>" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio-page' ); echo $image[0];?>"<?php if($portfolio_thumbnails_a_type){ echo $animation_att;}?> />
			<?php $images = get_post_meta($post->ID, 'vdw_gallery_id', true);?>
			<?php if(!$images): $images = array(); endif;?>
			<?php foreach ($images as $image) {?>
			  <img class="page-thumbnail img-responsive<?php if($portfolio_thumbnails_a_type){?> cre-animate<?php }?>" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( $image, 'portfolio-page' ); echo $image[0];?>"<?php if($portfolio_thumbnails_a_type){ echo $animation_att;}?> />
			<?php }?>
		</div>
	
	<?php } else{?>
	
	<div class="col-md-8"><p class="no-content-matched"><?php _e('Sorry, no contnet matched your criteria.', GETTEXT_DOMAIN) ?></p></div>
	
	<?php }?>
	
	<div class="col-md-4">
		<div class="content">
			<div class="post_content<?php if($portfolio_post_a_type){?> cre-animate<?php }?>"<?php if($portfolio_post_a_type){ echo $animation_att_pp;}?>>
				<?php the_content(); ?>
			</div>
			<?php if($details){?>
			<div class="portfolio-post-details<?php if($portfolio_post_a_type){?> cre-animate<?php }?>"<?php if($portfolio_post_a_type){ echo $animation_att_pp;}?>>
				<h5><?php _e( 'Project Details', GETTEXT_DOMAIN);?></h5>
	            <ul>
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
				<?php if(!$share&&$st_buttons_p){?><div class="st-share-portfolio"><?php echo $st_buttons_p;?></div><?php }?>
			</div>
			<?php }?>
		</div>
	</div>
	
	</div>
</div>