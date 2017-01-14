<?php $position = get_post_meta($post->ID, 'team_options_text', true);?>

<?php $facebook = get_post_meta($post->ID, 'team_options_facebook', true);?>
<?php $twitter = get_post_meta($post->ID, 'team_options_twitter', true);?>
<?php $linkedin = get_post_meta($post->ID, 'team_options_linkedin', true);?>
<?php $pinterest = get_post_meta($post->ID, 'team_options_pinterest', true);?>
<?php $google_plus = get_post_meta($post->ID, 'team_options_google_plus', true);?>
<?php $tumblr = get_post_meta($post->ID, 'team_options_tumblr', true);?>
<?php $instagram = get_post_meta($post->ID, 'team_options_instagram', true);?>
<?php $custom1_icon = get_post_meta($post->ID, 'team_options_custom1_icon', true);?>
<?php $custom1_title = get_post_meta($post->ID, 'team_options_custom1_title', true);?>
<?php $custom1_url = get_post_meta($post->ID, 'team_options_custom1_url', true);?>
<?php $custom2_icon = get_post_meta($post->ID, 'team_options_custom2_icon', true);?>
<?php $custom2_title = get_post_meta($post->ID, 'team_options_custom2_title', true);?>
<?php $custom2_url = get_post_meta($post->ID, 'team_options_custom2_url', true);?>

<div class="cbp-l-member-img">
	<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
		<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'front-shop-thumb2' ); echo $image[0];?>" alt="<?php $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
		if(count($alt)) echo $alt;?>">
	<?php } else{?>
		<img alt="<?php _e('No Image', GETTEXT_DOMAIN) ?>" src="<?php echo get_template_directory_uri(). '/assets/img/add-featured-image-square.png'; ?>" />
	<?php }?>
</div>
<div class="cbp-l-member-info">
	<div class="cbp-l-member-name"><?php the_title(); ?></div>
	<?php if($position){ ?><div class="cbp-l-member-position"><?php echo $position; ?></div><?php }?>
	<?php if ($facebook||$twitter||$linkedin||$pinterest||$google_plus||$tumblr||$instagram||$custom1_icon||$custom2_icon) {?>
	<div class="about-post-details picons_social">
		<ul>
			<?php if ($facebook) {?><li><a href="<?php echo $facebook; ?>" class="icon facebook1">Facebook</a></li><?php }?>
			<?php if ($twitter) {?><li><a href="<?php echo $twitter; ?>" class="icon twitter1">Twitter</a></li><?php }?>
			<?php if ($linkedin) {?><li><a href="<?php echo $linkedin; ?>" class="icon linkedin1">LinkedInk</a></li><?php }?>
			<?php if ($pinterest) {?><li><a href="<?php echo $pinterest; ?>" class="icon pinterest1">Pinterest</a></li><?php }?>
			<?php if ($google_plus) {?><li><a href="<?php echo $google_plus; ?>" class="icon google_plus1">Google Plus+</a></li><?php }?>
			<?php if ($tumblr) {?><li><a href="<?php echo $tumblr; ?>" class="icon tumblr1">Tumblr</a></li><?php }?>
			<?php if ($instagram) {?><li><a href="<?php echo $instagram; ?>" class="icon instagram1">Instagram</a></li><?php }?>
			
			<?php if ($custom1_icon&&$custom1_url) {?><li><a href="<?php echo $custom1_url; ?>" class="icon custom-icon"<?php if ($custom1_icon) {?> style="background-image:url(<?php $custom1_icon_image = wp_get_attachment_image_src( $custom1_icon, 'full' ); echo $custom1_icon_image[0];?>);"<?php }?>><?php echo $custom1_title; ?></a></li><?php }?>
			<?php if ($custom2_icon&&$custom2_url) {?><li><a href="<?php echo $custom2_url; ?>" class="icon custom-icon"<?php if ($custom2_icon) {?> style="background-image:url(<?php $custom2_icon_image = wp_get_attachment_image_src( $custom2_icon, 'full' ); echo $custom2_icon_image[0];?>);"<?php }?>><?php echo $custom2_title; ?></a></li><?php }?>
		</ul>
	</div>
	<?php }?>
	<div class="cbp-l-member-desc">
		<?php the_content();?>
	</div>
	<a href="<?php the_permalink();?>" class="btn btn-primary"><?php _e('Read More', GETTEXT_DOMAIN); ?></a>
</div>
<div class="clearfix"></div>

