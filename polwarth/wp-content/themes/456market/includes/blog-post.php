						<!-- A GALLERY ENTRY -->
						<div class="mega-entry cat-two cat-all <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>" id="mega-entry-1" data-src="
							
							<?php $post_front_options_checkbox = get_post_meta($post->ID, 'post_front_options_checkbox', true); ?>
							<?php $post_front_options_description = get_post_meta($post->ID, 'post_front_options_description', true); ?>
							<?php $post_front_options_caption = get_post_meta($post->ID, 'post_front_options_caption', true); ?>
							<?php $video = get_post_meta($post->ID, 'video_post_meta', true); ?>
							<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
							<?php $post_header_image = get_post_meta($post->ID, 'post_header_image', true); ?>
							<?php $post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'blog-page' );?>
							
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { 
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-page' ); echo $image[0];
							} elseif($post_header_image){
								echo $post_header_image_thumbnail[0];
							} elseif ( $video ) {
								if(has_post_thumbnail()){
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-page' ); echo $image[0];
								} elseif($post_header_image){
									echo $post_header_image_thumbnail[0];
								}else{
									echo get_template_directory_uri(); ?>/assets/img/video-post-type.png<?php 
								}
							} elseif ( $link ) {
								if(has_post_thumbnail()){
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-page' ); echo $image[0];
								} elseif($post_header_image){
									echo $post_header_image_thumbnail[0];
								}else{
									echo get_template_directory_uri(); ?>/assets/img/link-post-type.png<?php 
								}
							} else{
							 	echo get_template_directory_uri(); ?>/assets/img/standard-post-type.png<?php 
							}?>
						
						" data-width="504" data-height="400" 
						<?php if ( $post_front_options_caption == 'transparent'||$post_front_options_description=="none" ) {?>data-lowsize="73"<?php }?>>

								<?php if ( $post_front_options_caption != "none" ) {?>
								<!-- ENTRY COVERCAPTION -->
								<div class="mega-covercaption mega-square-top mega-landscape-left mega-portrait-bottom mega-withsocialbar mega-smallcaptions
								<?php if (  $post_front_options_caption == 'theme' ) {?>
								mega-black
								<?php } elseif ( $post_front_options_caption == 'white' ) {?>
								mega-white
								<?php } elseif ( $post_front_options_caption == 'light' ) {?>
								mega-white mega-transparent 
								<?php } elseif ( $post_front_options_caption == 'dark' ) {?>
								mega-black mega-transparent
								<?php } elseif ( $post_front_options_caption == 'transparent' ) {?>
								<?php }?>
								">
									<div class="mega-title"><?php #echo $post_front_options_select;?><a href="
									<?php if ( $link ) {
										echo $link;
									}else{
										the_permalink();
									}?>
									"><?php the_title(); ?></a></div>
									<?php if (!$post_front_options_checkbox) {?>
									<div class="mega-date"><a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a>
									
									<?php if($categories = wp_get_post_categories($post->ID)){
										echo " | ";
                                        foreach ($categories as $category) {
                                        	$cat_id = '';
                                           $cat_id .= $category. ', ';
                                        }
                                        $categories=get_categories('include='.$cat_id.'');
                                        foreach($categories as $category) {
                                            $results[] = '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __('View all posts in %s', GETTEXT_DOMAIN), $category->name ) . '" ' . '>' . $category->name.'</a>';
                                        }
                                        echo implode(", ", $results);
                                    }?>
									</div>
									<?php }?>
									<?php if ($post_front_options_caption!='transparent'||$post_front_options_description!="none" ) {?>
									<p>
									<?php if ( $post_front_options_description=="excerpt_10" ) {?>
										<?php echo excerpt(10);?>
									<?php } elseif ( $post_front_options_description=="excerpt_20" ) {?>
										<?php echo excerpt(20);?>
									<?php } elseif ( $post_front_options_description=="excerpt_30" ) {?>
										<?php echo excerpt(30);?>
									<?php } elseif ( $post_front_options_description=="excerpt_40" ) {?>
										<?php echo excerpt(40);?>
									<?php } elseif ( $post_front_options_description=="excerpt_50" ) {?>
										<?php echo excerpt(50);?>
									<?php }?>
									<br/><br/><a href="
									<?php if ( $link ) {
										echo $link;
									}else{
										the_permalink();
									}?>">[
									<?php if ( $link ) { ?>
										<?php _e('view more', GETTEXT_DOMAIN); ?>
									<?php }else{ ?>
										<?php _e('read more', GETTEXT_DOMAIN); ?>
									<?php }?>
									]</a></p>
									<?php }?>
								</div>
								<?php }?>

								<!-- ENTRY SOCIALBAR -->
								<div class="mega-socialbar">
									<span class="mega-leftfloat"><?php _e('Share this', GETTEXT_DOMAIN) ?>:</span>
					                <?php $title=get_the_title();
				                    if ($link){
				                    	$url=$link;
				                    }else{
				                    	$url=get_permalink();
				                    }
				                    $summary= excerpt_more(25);
				                    $tw_summary= excerpt_more(10);
				                    $fb_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog-page' );?>
					                <a class="fb" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $fb_image[0];?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">facebook</a>
									<a onClick="window.open('https://twitter.com/share?url=https%3A%2F%2Fdev.twitter.com%2Fpages%2Ftweet-button&text=<?php echo $tw_summary;?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)" class="tw">twitter</a>
									<a href="
									<?php if ( $link ) {
										echo $link;
									}else{
										the_permalink();
									}?>
									"><div class="mega-show-more mega-soc mega-more mega-rightfloat"></div></a>
									<a href="<?php comments_link(); ?>"><div class="mega-soc mega-comments mega-rightfloat"><span><?php comments_number('0', '1', '%'); ?></span></div></a>
								</div>
						</div>