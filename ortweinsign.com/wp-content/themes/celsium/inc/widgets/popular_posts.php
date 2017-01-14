<?php
class MY_PopularPostsWidget extends WP_Widget {
    /** constructor */
    function MY_PopularPostsWidget() {
        parent::WP_Widget(false, $name = 'Popular Posts');
    }

  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$number = apply_filters('widget_post_number', $instance['number']);
		$excerpt_length = apply_filters('widget_post_excerpt_length', (isset($instance['excerpt_length'])) ? $instance['excerpt_length'] : 130);
        ?>
              <?php echo $before_widget; ?>
		<section class="post-widget">
				<?php echo $before_title.$title.$after_title; ?>
                <?php
                    global $wpdb;
					$request = "SELECT ID, post_title, post_excerpt, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
					$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
					$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $number";
					
					
					
                    $posts = $wpdb->get_results($request); ?>
                    <ul class="clearfix">
                    <?php
                    if ($posts) {
                    foreach ($posts as $post) {
                    $post_title = stripslashes($post->post_title);
                    $post_content = afl_strEx(stripslashes($post->post_excerpt), $excerpt_length);
                    $comment_count = $post->comment_count;
                    $permalink = get_permalink($post->ID);
					$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
					 ?>
                    <li>
                    <?php $image = wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'popular-post-thumbnail' );
					echo '<a href="'.$src[0].'" rel="prettyPhoto">'.$image.'</a>';
                     ?>
						<a href="<?php echo $permalink ?>" title="<?php echo $post_title?>"><?php echo $post_title ?></a>
						<span><?php the_time('F j, Y'); ?></span>
						<p><?php echo $post_content ?></p>
                        <div class="clear"></div>
                    </li>
                    <?php } 
                    } else { ?>
                    <li> "None found" </li>
                   <?php } ?>
                    </ul>
                    <?php wp_reset_query(); ?>
		</section>
              <?php echo $after_widget; ?>
			 
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
      $title = esc_attr($instance['title']);
	  $number = esc_attr($instance['number']);
	  $excerpt_lenght = esc_attr($instance['excerpt_lenght']);
			
        ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Post excerpt lenght(symbols):', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" type="text" value="<?php echo $excerpt_lenght; ?>" /></label></p>

        <?php 
    }

} // class  Widget
?>