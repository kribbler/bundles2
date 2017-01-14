<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Post Tabs Widget
	Plugin URI: http://www.lpd-themes.com
	Description: A widget that allows the display of popular posts, recent posts and all tags.
	Version: 1.0
	Author: lidplussdesign
	Author URI: http://www.lpd-themes.com

-----------------------------------------------------------------------------------*/


// add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'post_tabs_widget' );


// register widget.
function post_tabs_widget() {
	register_widget( 'Post_Tabs_Widget' );
}

// widget class.
class post_tabs_widget extends WP_Widget {


/* widget setup
================================================== */
	function Post_Tabs_Widget() {
	
		/* widget settings. */
		$widget_ops = array( 'classname' => 'post_tabs_widget', 'description' => __('A widget that displays your popular posts, recent posts and all tags.', GETTEXT_DOMAIN) );

		/* widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'post_tabs_widget' );

		/* create the widget. */
		$this->WP_Widget( 'post_tabs_widget', __('Post Tabs Widget', GETTEXT_DOMAIN), $widget_ops, $control_ops );
	}

/* display widget
================================================== */	
	function widget( $args, $instance ) {
		extract( $args );
		
        $rand = rand(2, 999);
		$title = apply_filters('widget_title', $instance['title'] );

		/* variables from the widget settings. */
		$num_popular = $instance['num_popular'];
        $num_recent = $instance['num_recent'];

		/* before widget. */
		echo $before_widget;

		/* display Widget */
		?> 
		
        <?php /* display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo $before_title . $title . $after_title;
				?>
				
				<div class="widget list">
					<div class="tabbable tabs-top"> <!-- Only required for left/right tabs -->
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1-<?php echo $rand;?>" data-toggle="tab"><?php _e('Popular', GETTEXT_DOMAIN) ?></a></li>
							<li><a href="#tab2-<?php echo $rand;?>" data-toggle="tab"><?php _e('Recent', GETTEXT_DOMAIN) ?></a></li>
							<li><a href="#tab3-<?php echo $rand;?>" data-toggle="tab"><?php _e('Tags', GETTEXT_DOMAIN) ?></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab1-<?php echo $rand;?>">
	                            <ul class="postWidget unstyled">
									<?php global $wpdb;
									$posts = $wpdb->get_results("SELECT comment_count, ID, post_title FROM $wpdb->posts WHERE post_type = 'post' ORDER BY comment_count DESC LIMIT 0 , $num_popular");
									foreach ($posts as $post_) {
	                                    $id = $post_->ID;
	                                    $title = $post_->post_title;
	                                    $count = $post_->comment_count;
	                                    $video = get_post_meta($id, 'video_post_meta', true);
										$link = get_post_meta($id, 'link_post_meta', true);
										$post_header_image = get_post_meta($id, 'post_header_image', true);
										$post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'mini-thumb' );
	                                    if ($count != 0) {?>
		                                <li>
		                                
							<?php if((function_exists('has_post_thumbnail')) && (has_post_thumbnail($id))||$post_header_image){?>
                            	<?php if ( has_post_thumbnail($id) ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>2" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>1" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/standard-post-type3.png" alt="<?php the_title()?>3" height="50" width="50"/>
								<?php } ?>
                            <?php }elseif ( $link ) { ?>
                            	<?php if ( has_post_thumbnail($id) ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/link-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } ?>
                            <?php }elseif($video){?>
                            	<?php if ( has_post_thumbnail($id) ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/video-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } ?>
                            <?php }else{ ?>
                            	<img src="<?php echo get_template_directory_uri(); ?>/assets/img/standard-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
                            <?php }?>
		                                
			                                <div class="content"><a class="post-title" title="<?php echo $title?>" href="
	                                        <?php if ( $link ) { ?>
	                                        <?php echo $link; ?>
	                                        <?php }else{?>
	                                        <?php echo get_permalink($id); ?>
	                                        <?php }?>
			                                "><?php echo $title?></a><a class="date" href="<?php echo get_day_link(get_the_time('Y', $id), get_the_time('m', $id), get_the_time('d', $id)); ?>" title="<?php echo get_the_time('j M Y', $id); ?>"><?php echo get_the_time('j M Y', $id); ?></a></div>
			                                <div class="clearfix"></div>
		                                </li>
	                                	<?php }?>
	                                <?php }?>
	                            </ul>
							</div>
							<div class="tab-pane" id="tab2-<?php echo $rand;?>">
								<ul class="unstyled">
	                            <?php $query = new WP_Query();?>
	                            <?php $query->query('posts_per_page='.$num_recent.'&ignore_sticky_posts=1');?>
	                            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
								<?php $video = get_post_meta(get_the_ID(), 'video_post_meta', true); ?>
								<?php $link = get_post_meta(get_the_ID(), 'link_post_meta', true); ?>
								<?php $post_header_image = get_post_meta(get_the_ID(), 'post_header_image', true);?>
								<?php $post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'mini-thumb' );?>
				                        <li>
				                        
							<?php if((function_exists('has_post_thumbnail')) && (has_post_thumbnail())||$post_header_image){?>
                            	<?php if ( has_post_thumbnail() ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>2" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>1" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/standard-post-type3.png" alt="<?php the_title()?>3" height="50" width="50"/>
								<?php } ?>
                            <?php }elseif ( $link ) { ?>
                            	<?php if ( has_post_thumbnail() ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/link-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } ?>
                            <?php }elseif($video){?>
                            	<?php if ( has_post_thumbnail() ) { ?>
									<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'mini-thumb' ); echo $image[0];?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } elseif ( $post_header_image ) { ?>
									<img src="<?php echo $post_header_image_thumbnail[0]; ?>" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } else{ ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/img/video-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
								<?php } ?>
                            <?php }else{ ?>
                            	<img src="<?php echo get_template_directory_uri(); ?>/assets/img/standard-post-type3.png" alt="<?php the_title()?>" height="50" width="50"/>
                            <?php }?>
	
				                            <div class="content"><a class="post-title" title="<?php the_title()?>" href="
				                            <?php if ( $link ) { ?>
				                            <?php echo $link; ?>
				                            <?php }else{?>
				                            <?php echo get_permalink(); ?>
				                            <?php }?>
				                            "><?php the_title()?></a><a class="date" href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" title="<?php echo get_the_time('j M Y'); ?>"><?php echo get_the_time('j M Y'); ?></a></div>
				                            <div class="clearfix"></div>
				                        </li>
				                <?php endwhile; endif; ?> 
				                <?php wp_reset_query(); ?>
								</ul>
							</div>
							<div class="tab-pane" id="tab3-<?php echo $rand;?>">
	                    		<div class="tagcloud tags">
	                                <?php wp_tag_cloud('smallest=12&largest=12&unit=px&number=0'); ?>
	                            </div>
							</div>
						</div>
					</div>
				</div>	
		<?php

		/* after widget (defined by themes). */
		echo $after_widget;
	}


/* widget update
================================================== */
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		/* strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_popular'] = strip_tags( $new_instance['num_popular'] );
        $instance['num_recent'] = strip_tags( $new_instance['num_recent'] );
        
		/* no need to strip tags for.. */

		return $instance;
	}
	

/* widget settings
================================================== */
	 
	function form( $instance ) {

		/* set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'num_popular' => 3,
		'num_recent' => 3
		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
        <!-- widget title: text input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', GETTEXT_DOMAIN) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        
		<!-- widget title: text input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num_popular' ); ?>"><?php _e('Amount to show popular post:', GETTEXT_DOMAIN) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'num_popular' ); ?>" name="<?php echo $this->get_field_name( 'num_popular' ); ?>" value="<?php echo $instance['num_popular']; ?>" />
		</p>
        
		<!-- widget num: text input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num_recent' ); ?>"><?php _e('Amount to show recent post:', GETTEXT_DOMAIN) ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'num_recent' ); ?>" name="<?php echo $this->get_field_name( 'num_recent' ); ?>" value="<?php echo $instance['num_recent']; ?>" />
		</p>

	
	<?php
	}
}
?>