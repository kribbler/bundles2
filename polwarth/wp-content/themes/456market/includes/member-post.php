						<div id="post-<?php the_ID(); ?>" class="post <?php if ($full_width){?>post_full-width<?php }?> <?php $allClasses = get_post_class(); foreach ($allClasses as $class) { echo $class . " "; } ?>">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<?php $post_thumbnail_id = get_post_thumbnail_id(); ?>
							<?php $alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);?>
							<div class="span6">
								<img class="page-thumbnail" alt="<?php echo $alt; ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'team-member' ); echo $image[0];?>" />
							</div>
							<?php }?>
							<div class="post-content <?php if (has_post_thumbnail()) { ?>span6<?php }else{?>span12<?php }?>">
								<?php the_content(); ?>
								<?php $about_buttons = get_post_meta(get_the_ID(), 'team_social_repeatable', true);?>
						        <?php if($about_buttons){ ?>
						        <div class="member-social member-post">
						            
						            <?php $separator = "%%";
						            $output = '';
						            foreach ($about_buttons as $item) {
						                if($item){
						                    list($item_text1, $item_text2) = explode($separator, trim($item));
						                    $output .= '<a href="' . $item_text2 . '" title="' . $item_text1 . '"><i class="livicon" data-name="' . $item_text1 . '" data-size="16" data-c="#959595" data-hc="';
						                    if($item_text1=="facebook"){
							                    $output .= '#3b5998';
						                    }elseif($item_text1=="facebook-alt"){
							                    $output .= '#3b5998';
						                    }elseif($item_text1=="flickr"){
							                    $output .= '#ff0084';
						                    }elseif($item_text1=="flickr-alt"){
							                    $output .= '#ff0084';
						                    }elseif($item_text1=="google-plus"){
							                    $output .= '#dd4a38';
						                    }elseif($item_text1=="google-plus-alt"){
							                    $output .= '#dd4a38';
						                    }elseif($item_text1=="linkedin"){
							                    $output .= '#006699';
						                    }elseif($item_text1=="linkedin-alt"){
							                    $output .= '#006699';
						                    }elseif($item_text1=="pinterest"){
							                    $output .= '#cc2129';
						                    }elseif($item_text1=="pinterest-alt"){
							                    $output .= '#cc2129';
						                    }elseif($item_text1=="rss"){
							                    $output .= '#fa9d39';
						                    }elseif($item_text1=="skype"){
							                    $output .= '#0ca6df';
						                    }elseif($item_text1=="twitter"){
							                    $output .= '#1ec7ff';
						                    }elseif($item_text1=="twitter-alt"){
							                    $output .= '#1ec7ff';
						                    }elseif($item_text1=="youtube"){
							                    $output .= '#c4302b';
						                    }else{
							                    $output .= '#555';
						                    }
						                    $output .= '"></i></a>';
						                }
						            }
						            echo $output;?>
						            
						        </div>
						        <?php } ?>
							</div>
						</div>