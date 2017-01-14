		<?php $portfolio_header_image = get_post_meta($post->ID, 'portfolio_header_image', true); ?>
		<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php if(is_shop()){?>
				<?php $shop_id = woocommerce_get_page_id('shop');?>
				<?php $page_header_image = get_post_meta($shop_id, 'page_header_image', true); ?>
			<?php }else{?>
				<?php $page_header_image = get_post_meta($post->ID, 'page_header_image', true); ?>
			<?php }?>
		<?php }else{?>
			<?php $page_header_image = get_post_meta($post->ID, 'page_header_image', true); ?>
		<?php }?>
		<?php $post_header_image = get_post_meta($post->ID, 'post_header_image', true); ?>
		<?php $front_callout_checkbox = get_post_meta($post->ID, 'front_callout_checkbox', true); ?>
		<?php $front_widget_checkbox = get_post_meta($post->ID, 'front_widget_checkbox', true); ?>
		<?php $front_widget_title = get_post_meta($post->ID, 'front_widget_title', true); ?>
		<?php $front_widget_content = get_post_meta($post->ID, 'front_widget_content', true); ?>
		<?php $front_widget_navigation = get_post_meta($post->ID, 'front_widget_navigation', true); ?>
		<?php $front_widget_type = get_post_meta($post->ID, 'front_widget_type', true); ?>
		<?php $front_widget_s_posts = get_post_meta($post->ID, 'front_widget_s_posts', true); ?>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php if($front_widget_type=="product-2"){?>
				<?php $front_widget_type="product-2";?>
			<?php } elseif($front_widget_type=="product"){?>
				<?php $front_widget_type="product";?>
			<?php } elseif($front_widget_type=="portfolio"){?>
				<?php $front_widget_type="portfolio";?>
			<?php } elseif($front_widget_type=="post"){?>
				<?php $front_widget_type="post";?>
			<?php }?>
		<?php }else{?>
			<?php if($front_widget_type=="portfolio"){?>
				<?php $front_widget_type="portfolio";?>
			<?php } else{?>
				<?php $front_widget_type="post";?>
			<?php }?>
		<?php }?>
		
		
		<?php $front_widget_style = get_post_meta($post->ID, 'front_widget_style', true); ?>
		<?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>
		<?php $page_front_slider_select = get_post_meta($post->ID, 'page_front_slider_select', true); ?>
		<?php $page_front_slider_duration = get_post_meta($post->ID, 'page_front_slider_duration', true); ?>
		<?php $page_front_slider_transition = get_post_meta($post->ID, 'page_front_slider_transition', true); ?>	
		<?php $page_front_youtube_video = get_post_meta($post->ID, 'page_front_youtube_video', true); ?>
		<?php $page_front_youtube_autoplay = get_post_meta($post->ID, 'page_front_youtube_autoplay', true); ?>
		<?php $page_front_youtube_seekbar = get_post_meta($post->ID, 'page_front_youtube_seekbar', true); ?>
		<?php $page_front_youtube_control = get_post_meta($post->ID, 'page_front_youtube_control', true); ?>
		
		<?php if($front_options_select=="style1"){?>
			<?php $front_style1_select = get_post_meta($post->ID, 'front_style1_select', true); ?>
		<?php }?>
		
		<?php $portfolio_header_image_bg = wp_get_attachment_image_src( $portfolio_header_image, 'page-header' );?>
		<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'front-page-header' );?>
		<?php }else{?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'page-header' );?>
		<?php }?>
		<?php $post_header_image_bg = wp_get_attachment_image_src( $post_header_image, 'page-header' );?>
		
		<?php #remove it if($blog_header_image){ $blog_header_image = get_attachment_id_from_src($blog_header_image); }?>
		<?php #remove it $blog_header_image_bg = wp_get_attachment_image_src( $blog_header_image, 'page-header' );?>
		
				
				<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
				
				<div class="container">
					
					<?php $front_options_wp_editor = get_post_meta($post->ID, 'front_options_wp_editor', true); ?>
					<?php if ($front_style1_select!="front_slider"&&$front_style1_select!="youtube") { ?>
						<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
							<div id="front-page-caption">
								<div class="container">
									<div class="row-fluid">
										<div class="span5">
											<?php echo do_shortcode(wpautop($front_options_wp_editor)); ?>
										</div>
									</div>
								</div>
							</div>
						<?php }?>
					<?php }?>
					
					<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
						<?php if($front_widget_checkbox){?>
							<div id="featured-widget" class="hidden-phone">
								<div class="container">
									<div class="row-fluid">
						<div class="featured-label span3">
							<span class="label-border">
								
								<span class="title-wrap <?php if(!$front_widget_content){?>no-description<?php }?> <?php if(!$front_widget_title){?>no-title<?php }?>">
									<?php if($front_widget_title){?>
										<span class="title"><?php echo $front_widget_title; ?></span>
										<?php if($front_widget_content){?><span class="title-border"></span><?php }?>
									<?php }?>
								</span>
								
								<?php if($front_widget_content){?><span class="description"><?php echo $front_widget_content; ?></span><?php }?>
							</span>
							<?php if($front_widget_navigation){?>
							<div class="showbiz-navigation clearfix">
								<a id="showbiz_left_1" class="left"><i class=""><span class="livicon" data-n="caret-left" data-c="#fff" data-hc="#fff" data-s="16"></span></i></a>
								<a id="showbiz_play_1" class=""><i class="">play</i><i class="">pause</i></a>					
								<a id="showbiz_right_1" class=""><i class=""><span class="livicon" data-n="caret-right" data-c="#fff" data-hc="#fff" data-s="16"></span></i></a>
								<div class="sbclear"></div>
							</div>
							<?php }?>
						</div>
						<div class="featured-content span9">
							<div id="featured-content-posts" class="showbiz-container">

<?php if($front_widget_type=="product-2"){?>
							<!--	THE PORTFOLIO ENTRIES	-->
							<div class="showbiz woocommerce sb-modern-skin" data-left="#showbiz_left_1" data-right="#showbiz_right_1" data-play="#showbiz_play_1">
								<!-- THE OVERFLOW HOLDER CONTAINER, DONT REMOVE IT !! -->
								<div class="overflowholder">
									<!-- LIST OF THE ENTRIES -->
									<ul>
										
										<?php if($front_widget_s_posts) {$post_in = explode(',', $front_widget_s_posts);}
										$args = array(
											#'showposts' => $showposts,
											'post_type' => 'product',
											'posts_per_page' => '-1',
											#'orderby' => $orderby,
											#'order' => $order,
											'post__in' => $post_in,
										);
										$query = new WP_Query( $args );
										if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
							
										<?php $post_header_image = get_post_meta($post->ID, 'product_header_image', true); ?>
										<?php $post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'featured-widget-post-portfolio' );?>
										<?php $terms_product = get_the_terms( get_the_ID(), 'product_cat' );?>
							
										<li class="sb-modern-skin product">
			
										<?php woocommerce_get_template( 'loop/sale-flash.php' );
										echo woocommerce_get_product_thumbnail1()?>
											
								
										<div class="item-details">
										
											<h3><?php the_title(); ?></h3>
											
											<?php woocommerce_get_template( 'loop/price.php' );?>
									
											<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
											
										</div>
							
										</li><!-- END OF ENTRY -->
										
										<?php endwhile; endif; wp_reset_query();?>
							
							
									</ul>
									<div class="sbclear"></div>
								</div> <!-- END OF OVERFLOWHOLDER -->
								<div class="sbclear"></div>
							</div>
<?php } else{?>
							<!--	THE PORTFOLIO ENTRIES	-->
							<div class="showbiz sb-modern-skin <?php if($front_widget_style=="light"){?>light-skin<?php }?>" data-left="#showbiz_left_1" data-right="#showbiz_right_1" data-play="#showbiz_play_1">
								<!-- THE OVERFLOW HOLDER CONTAINER, DONT REMOVE IT !! -->
								<div class="overflowholder">
									<!-- LIST OF THE ENTRIES -->
									<ul>
										
										<?php if($front_widget_s_posts) {$post_in = explode(',', $front_widget_s_posts);}
										$args = array(
											#'showposts' => $showposts,
											'post_type' => $front_widget_type,
											'posts_per_page' => '-1',
											#'orderby' => $orderby,
											#'order' => $order,
											'post__in' => $post_in,
										);
										$query = new WP_Query( $args );

										if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
							
										<?php $lightbox = get_post_meta(get_the_ID(), 'portfolio_options_lightbox', true); ?>
										<?php $video_raw = get_post_meta(get_the_ID(), 'video_post_meta', true); ?>
										<?php $video = get_post_meta($post->ID, 'video_post_meta', true); ?>
										<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
										<?php if($front_widget_type=="post"){?>
											<?php $post_header_image = get_post_meta($post->ID, 'post_header_image', true); ?>
										<?php } elseif($front_widget_type=="portfolio"){?>
											<?php $post_header_image = get_post_meta($post->ID, 'portfolio_header_image', true); ?>
										<?php } else{?>
											<?php $post_header_image = get_post_meta($post->ID, 'product_header_image', true); ?>
										<?php }?>
										<?php $post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'featured-widget-post-portfolio' );?>
										<?php $terms_portfolio = get_the_terms( get_the_ID(), 'portfolio_category' );?>
										<?php $terms_product = get_the_terms( get_the_ID(), 'product_cat' );?>
							
										<li class="sb-modern-skin">
							
													<!-- THE MEDIA HOLDER -->
													<div class="mediaholder">
														<div class="mediaholder_innerwrap">
														
							
														
															<img alt="" src="
										
										<?php if ($front_widget_type=="product"){
											
											if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { 
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-widget-post-portfolio' ); echo $image[0];
											} elseif($post_header_image){
												echo $post_header_image_thumbnail[0];
											}else{
											 	echo get_template_directory_uri(); ?>/assets/img/placeholder2.png<?php 
											}
											
										} else{	
														
											if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { 
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-widget-post-portfolio' ); echo $image[0];
											} elseif($post_header_image){
												echo $post_header_image_thumbnail[0];
											} elseif ( $video ) {
												if(has_post_thumbnail()){
													$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-widget-post-portfolio' ); echo $image[0];
												} elseif($post_header_image){
													echo $post_header_image_thumbnail[0];
												}else{
													echo get_template_directory_uri(); ?>/assets/img/video-post-type2.png<?php 
												}
											} elseif ( $link ) {
												if(has_post_thumbnail()){
													$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'featured-widget-post-portfolio' ); echo $image[0];
												} elseif($post_header_image){
													echo $post_header_image_thumbnail[0];
												}else{
													echo get_template_directory_uri(); ?>/assets/img/link-post-type2.png<?php 
												}
											} else{
											 	echo get_template_directory_uri(); ?>/assets/img/standard-post-type2.png<?php 
											}
											
										}?>
															
															
															">
														</div>
													</div><!-- END OF MEDIA HOLDER -->
							
													<div class="darkhover"></div>
							
													<div class="detailholder">
														<div class="showbiz-title"><span><?php the_title(); ?></span></div>
														<div class="divide20"></div>
														<p class="excerpt"><?php echo excerpt(15)?><div class="divide20"></div></p>
														<!-- THE POST INFOS AND READ MORE BUTTON -->
														<div class="sb-post-details leftfloat"><span class="rm15">
															<?php if($front_widget_type=="post"){?>
																<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a>
															<?php } elseif($front_widget_type=="portfolio"){?>			
																<?php $resultstr = array();
									                             if($terms_portfolio) : foreach ($terms_portfolio as $term) {
									                                $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_category').'">'.$term->name.'</a>';
									                            }
									                            echo implode(", ",$resultstr); endif;?>
									                        <?php } elseif($front_widget_type=="product"){?>
																<?php $resultstr = array();
									                             if($terms_product) : foreach ($terms_product as $term) {
									                                $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'product_cat').'">'.$term->name.'</a>';
									                            }
									                            echo implode(", ",$resultstr); endif;?>
															<?php }?>				
														</span></div>
														<div class="sb-readmore rightfloat"><a href="
														<?php if ( $link ) {
															echo $link;
														}else{
															the_permalink();
														}?>
														">[
														<?php if ( $lightbox) { ?>
															<?php _e('view gallery', GETTEXT_DOMAIN); ?>
														<?php } elseif ( $link ) { ?>
															<?php _e('view more', GETTEXT_DOMAIN); ?>
														<?php }else{ ?>
															<?php _e('read more', GETTEXT_DOMAIN); ?>
														<?php }?>
														 ]</a></div>
														<div class="sb-clear"></div><!-- END OF POST INFOS AND READ MORE BUTTON -->
													</div>
							
							
										</li><!-- END OF ENTRY -->
										
										<?php endwhile; endif; wp_reset_query();?>
							
							
									</ul>
									<div class="sbclear"></div>
								</div> <!-- END OF OVERFLOWHOLDER -->
								<div class="sbclear"></div>
							</div>							
<?php }?>

							</div>
							
							<script type="text/javascript">
							jQuery(document).ready(function() {
							
								jQuery('#featured-content-posts').showbizpro({
									dragAndScroll:"on",
									visibleElementsArray:[3,3,2,1],
									mediaMaxHeight:[360,360,360,360],
									carousel:"off",
									entrySizeOffset:0,
									allEntryAtOnce:"off",
									ytMarkup:"<iframe src='http://www.youtube.com/embed/%%videoid%%?hd=1&amp;wmode=opaque&amp;autohide=1&amp;showinfo=0&amp;autoplay=1'></iframe>",
									vimeoMarkup:"<iframe src='http://player.vimeo.com/video/%%videoid%%?title=0&amp;byline=0&amp;portrait=0;api=1&amp;autoplay=1'></iframe>",
									rewindFromEnd:"off",
									autoPlay:"off",
									delay:2000,						
									speed:250
								});
							
								// THE FANCYBOX PLUGIN INITALISATION
								jQuery(".fancybox").fancybox();
							
							});
							</script>
								
						</div>
					</div>
								</div>
							</div>
						<?php }?>
					<?php }?>
	
				</div>
				
				<?php }?>