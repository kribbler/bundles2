<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* Blog Options
    ================================================== */
    $blog_post_share = get_option_tree('blog_post_share',$theme_options);

}
?>

<?php $video = theme_parse_video(get_post_meta($post->ID, 'video_post_meta', true));?>

						<div id="post-<?php the_ID(); ?>" class="post <?php if ($full_width){?>post_full-width<?php }?> <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
							<?php if ($video) { ?>
							<iframe class="scale-with-grid page-thumbnail" width="870" height="489" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe>
							<?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
							<?php $post_thumbnail_id = get_post_thumbnail_id(); ?> 
							<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
							<img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'default-sidebar-page' ); echo $image[0];?>" />
							<?php }?>
							
							<div class="post-content">
								<div class="post-meta">
									<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><i class="halflings-icon calendar"></i><?php the_time('M j, Y'); ?></a>
									<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><i class="halflings-icon user"></i><?php echo get_the_author(); ?></a>
									<a href="<?php comments_link(); ?>" class="comment"><i class="halflings-icon comments"></i><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a>
								</div>
								<div class="post-content-content">
									<?php the_content(); ?>
									<?php wp_link_pages(); ?>
									<div class="clearfix"></div>
									<?php edit_post_link( __('edit', GETTEXT_DOMAIN), '<span class="edit-post">[', ']</span>' ); ?>
								</div>
								<?php if (!$blog_post_share){?>
								<ul class="social">
									<li>
										<iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=0&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="width: 120px; border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
									</li>
									<li>
										<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                    </li>
                                    <li>
                                        <!-- Place this tag where you want the +1 button to render -->
                                        <div class="g-plusone" data-size="medium" data-annotation="none" data-href="<?php the_permalink(); ?>"></div>
                                        <!-- Place this render call where appropriate -->
                                        <script type="text/javascript">
                                          (function() {
                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                            po.src = 'https://apis.google.com/js/plusone.js';
                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                          })();
                                        </script>
                                    </li>
                                    <li>
                                        <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); echo $image[0];?>&description=<?php the_title();?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                                    </li>
								</ul>
								<?php }else{?>
									<div class="divider20"></div>
								<?php }?>
							</div>
						</div>