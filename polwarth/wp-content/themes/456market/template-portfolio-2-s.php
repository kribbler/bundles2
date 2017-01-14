<?php
/*
Template Name: 2 Columns Portfolio (sidebar)
*/
?>

<?php get_header(); ?>
<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true);?>

		<div id="page-title" class="container">
			<div class="row-fluid">
				<div class="span12"><h2><span><?php the_title();?></span></h2></div>
			</div>
		</div>
		<div id="main" class="page-title-template <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
			<div class="container 
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if((has_post_thumbnail())&&($post->post_content != "")) {?>
			content-filter
			<?php } ?>
			<?php if(($post->post_content != "")&&(!has_post_thumbnail())) {?>
			content-filter
			<?php } ?>
			<?php if(has_post_thumbnail()&&($post->post_content == "")) {?>
			content-filter
			<?php } ?>
			<?php endwhile; endif; ?>
			">
				<div class="row-fluid"><div class="span9 page-content">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<div class="row-fluid">
					<div class="span12">	
						<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
						<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
						<img alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" /><div class="divider20"></div>
					</div>
				</div>
				<?php }?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php if (get_the_content()) {?>
					<div class="row-fluid">
						<div class="span12"><?php the_content();?><div class="divider10"></div></div>
					</div>
					<?php }?>
				<?php endwhile; endif; ?>
                <?php get_template_part('includes/portfolio-filter') ?>
				<div class="row-fluid"><div class="span12">
                	<div id="container" class="portfolio clearfix portfolio-2">

				        <?php $filter = get_post_meta($post->ID, 'portfolio_filter_text', true);?>
                	
                        <?php $query = new WP_Query();?>
                        <?php if($filter){?>
                            <?php $query->query('post_type=portfolio&portfolio_category='. $filter .'&posts_per_page=-1');?>
                        <?php }else{?>
                            <?php $query->query('post_type=portfolio&posts_per_page=-1');?>
                        <?php }?>
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
                        
						<?php $lightbox = get_post_meta($post->ID, 'portfolio_options_lightbox', true);?>
						<?php $video_raw = get_post_meta($post->ID, 'video_post_meta', true);?>
						<?php $video = theme_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>
						<?php $link = get_post_meta($post->ID, 'link_post_meta', true);?>
						<?php $full_width = get_post_meta($post->ID, 'portfolio_options_full', true);?>
						<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
				       
						<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>
						<?php $gallery_type = get_post_meta($post->ID, 'portfolio_options_select', true);?>
						<?php $terms = get_the_terms( get_the_ID(), 'portfolio_category' ); ?>
						<?php $portfolio_header_image = get_post_meta($post->ID, 'portfolio_header_image', true); ?>
						<?php $portfolio_header_image_thumbnail = wp_get_attachment_image_src( $portfolio_header_image, 'default-sidebar-page' );?>                  
                        
						<div class="element post portfolio span6 <?php if($terms) : foreach ($terms as $term) { echo ''.$term->slug.' '; } endif; ?>">
							<div class="portfolio-item">
								<?php if ( $lightbox ) { ?>
									<?php if(has_post_thumbnail()||$portfolio_header_image) {?>
		                                <a rel="prettyPhoto[pp_gal-<?php echo $post->ID ?>]" class="effect-thumb" href="<?php if ($video) { echo $video_raw; }else{ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); echo $image[0]; }?>" title="<?php if ($video) { the_title(); }else{ $attachment = get_post(get_post_thumbnail_id( $post->ID )); echo $attachment->post_title;}?>">
		                                	<?php if(has_post_thumbnail()) {?>
		                                	<img alt="<?php the_title(); ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>"/>
		                                	<?php }elseif ($portfolio_header_image) { ?>
		                                	<img alt="<?php the_title(); ?>" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/>
		                                	<?php }?>
		                                	<div class="mega-livicon"><span class="livicon" data-n="zoom-in" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
		                                </a>
		                                <?php if (!$video) { $thumbnail_id = get_post_thumbnail_id( $post->ID ); }?>
		                                <?php $args = array(
		                                'numberposts' => 9999, // change this to a specific number of images to grab
		                                'offset' => 0,
		                                'post_parent' => $post->ID,
		                                'post_type' => 'attachment',
		                                'exclude'  => $thumbnail_id,
		                                'nopaging' => false,
		                                'post_mime_type' => 'image',
		                                'order' => 'ASC', // change this to reverse the order
		                                'orderby' => 'menu_order ID', // select which type of sorting
		                                'post_status' => 'any'
		                                );
		                                $attachments =& get_children($args);?>
		                                <?php foreach($attachments as $attachment) {
		                                    $imageTitle = $attachment->post_title;
		                                    $imageDescription = $attachment->post_content;
		                                    $imageArrayFull = wp_get_attachment_image_src($attachment->ID, 'full', false);?>
		                                    <a class="hide" rel="prettyPhoto[pp_gal-<?php echo $post->ID ?>]" href="<?php echo $imageArrayFull[0] ?>" title="<?php echo $imageTitle ?>"></a>
		                                <?php }?>
	                                <?php }else{?>
	                                <p style="color: #ed1c24; padding: 10px;"><?php _e( 'Please add an image to "Featured Image" for thumbnail.', GETTEXT_DOMAIN);?></p>
	                                <?php }?>
								<?php } elseif ( $link ) { ?>
	                                <?php if(has_post_thumbnail()) {?>
										<a href="<?php echo $link; ?>" class="effect-thumb">
											<img alt="<?php the_title(); ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>"/>
											<div class="mega-livicon"><span class="livicon" data-n="link" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
										</a>
									<?php }elseif ($portfolio_header_image) { ?>
										<a href="<?php echo $link; ?>" class="effect-thumb">
											<?php if ($portfolio_header_image) { ?><img alt="<?php the_title(); ?>" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/><?php } ?>
											<div class="mega-livicon"><span class="livicon" data-n="link" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
										</a>
	                                <?php }else{?>
	                                <p style="color: #ed1c24; padding: 10px;"><?php _e( 'Please add an image to "Featured Image" for thumbnail.', GETTEXT_DOMAIN);?></p>
	                                <?php }?>
                                <?php } elseif ( $video ) { ?>
	                                <?php if(has_post_thumbnail()) {?>
									<a href="<?php the_permalink(); ?>" class="effect-thumb">
										<img alt="<?php the_title(); ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>"/>
										<div class="mega-livicon"><span class="livicon" data-n="film" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
									</a>
									<?php }elseif ($portfolio_header_image) { ?>
									<a href="<?php the_permalink(); ?>" class="effect-thumb">
										<?php if ($portfolio_header_image) { ?><img alt="<?php the_title(); ?>" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/><?php } ?>
										<div class="mega-livicon"><span class="livicon" data-n="film" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
									</a>
	                                <?php }else{?>
	                                <p style="color: #ed1c24; padding: 10px;"><?php _e( 'Please add an image to "Featured Image" for video thumbnail.', GETTEXT_DOMAIN);?></p>
	                                <?php }?>
                                <?php } elseif ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
								<a href="<?php the_permalink(); ?>" class="effect-thumb">
									<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
									<img alt="<?php the_title(); ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>"/>
									<?php } ?>
									<div class="mega-livicon"><span class="livicon" data-n="eye-open" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
								</a>
								<?php } elseif ($portfolio_header_image) { ?>
								<a href="<?php the_permalink(); ?>" class="effect-thumb">
									<?php if ($portfolio_header_image) { ?>
									<img alt="<?php the_title(); ?>" src="<?php echo $portfolio_header_image_thumbnail[0];?>"/>
									<?php } ?>
									<div class="mega-livicon"><span class="livicon" data-n="eye-open" data-c="#fff" data-hc="#fff" data-s="32"></span></div>
								</a>
                                <?php }?>
								<div class="content">
									<?php if ( $link ) { ?>
									<h4 class="title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
									<?php }else{?>
									<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php }?>
									<div class="column">
										<div class="post_content">
											<p><?php echo excerpt(25)?> 
											<?php if ( $link ) { ?>
											<a class="more-link" href="<?php echo $link; ?>">[read more]</a></p>
											<?php }else{?>
											<a class="more-link" href="<?php the_permalink(); ?>">[read more]</a></p>
											<?php }?>
										</div>
									</div>
									<div class="portfolio-categories">
										<?php $resultstr = array(); ?>
	                                    <?php if($terms) : foreach ($terms as $term) { ?>
	                                        <?php $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_category').'">'.$term->name.'</a>'?>
	                                    <?php } ?>
	                                    <?php echo implode(", ",$resultstr); endif;?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>                    
						</div>
						<?php endwhile; endif; ?> 
                    </div>
				</div></div>
				</div><?php get_sidebar(); ?>
				</div>
			</div>
		</div>
        
<?php get_footer(); ?>