<?php
/*
Template Name: Front Template
*/
?>

<?php get_header(); ?>
		
		
		<?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>
		<?php $front_options_wp_editor = get_post_meta($post->ID, 'front_options_wp_editor', true); ?>
		<?php $front_style2_select = get_post_meta($post->ID, 'front_style2_select', true); ?>
		<?php $front_style2_layerslider = get_post_meta($post->ID, 'front_style2_layerslider', true); ?>
		<?php $front_style2_nivoslider = get_post_meta($post->ID, 'front_style2_nivoslider', true); ?>
		<?php $front_style2_dynamic = get_post_meta($post->ID, 'front_style2_dynamic', true); ?>
		<?php $front_style2_video = get_post_meta($post->ID, 'front_style2_video', true); ?>
		<?php $video = theme_parse_video($front_style2_video);?>
		
		<?php if($front_options_select=="style1"){?>
			<?php get_template_part('includes/callout' ) ?>
		<?php }?>
		
		<div id="main" class="page-title-template <?php if($front_options_select=="style1"){?><?php if($post->post_content == "") {?>one-page<?php }?><?php }?>">
			
			<?php if($front_options_select=="style2"){?>
				<div id="front-header" class="container <?php if ($front_style2_select=="none") { ?>no-content <?php if (!is_active_sidebar(11)){?>no-front-meta<?php }?><?php }?>">
					<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Front Meta') ) ?>
					<?php if ($front_style2_select!="none") { ?>
					<div class="row-fluid">
						<div class="<?php if ($front_options_wp_editor) { ?>span8 front-header-padding-l<?php }else{?>span12 front-header-padding<?php }?>">
							<?php if ($front_style2_select=="layerslider") { ?>
								<?php echo do_shortcode($front_style2_layerslider); ?>
							<?php } elseif ($front_style2_select == 'nivoslider') {?>
								<?php echo do_shortcode($front_style2_nivoslider); ?>
							<?php } elseif ($front_style2_select == 'dynamic') {?>
								<?php echo do_shortcode($front_style2_dynamic); ?>
							<?php } elseif ($front_style2_select == 'video') {?>
			                    <?php if ( $video ) {?>
				                    	<iframe class="scale-with-grid-front shadow-s3" width="620" height="349" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe>
				                    <?php }else{?>
				                    	<p style="color: #ed1c24;"><?php _e('Enter a video URL to "Front Page Options"', GETTEXT_DOMAIN) ?></p>
				                    <?php }?>
							<?php } elseif ($front_style2_select == 'image') {?>
			                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
			                        <?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
		                            <?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
		                            <?php if($front_options_wp_editor){ ?>
		                                <img alt="<?php echo $alt; ?>" class="" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'front-header-1' ); echo $image[0];?>" />
		                            <?php }else{ ?>
				                    	<img alt="<?php echo $alt; ?>" class="" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'front-header-2' ); echo $image[0];?>" />
				                    <?php }?>
			                    <?php }else{?>
			                    	<p style="color: #ed1c24;"><?php _e('Add an image to "Featured Image".', GETTEXT_DOMAIN) ?></p>
			                    <?php }?>
		                    <?php }?>
						</div>
						<?php if ($front_options_wp_editor) { ?>
							<div class="span4 front-header-padding-r">
								<?php echo do_shortcode(wpautop($front_options_wp_editor)); ?>
							</div>
						<?php }?>
					</div>
					<?php }?>
				</div>
				<?php if ($front_style2_select=="none") { ?><?php if (!is_active_sidebar(11)){?>
					<?php get_template_part('includes/heading' ) ?>
				<?php }?><?php }?>
			<?php }?>
			
			<?php if($post->post_content != "") {?>
			<div class="container">
				<div class="row-fluid">
					<div class="span12 page-content">
			        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content();?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></p>
                    <?php endif; ?>
                    </div>
				</div>
			</div>
			<?php }?>
		</div>

<?php get_footer(); ?>