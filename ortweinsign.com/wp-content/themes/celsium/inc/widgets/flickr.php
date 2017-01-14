<?php
// =============================== Flickr stream  ======================================
class MY_FlickrWidget extends WP_Widget {
    /** constructor */
    function MY_FlickrWidget() {
        parent::WP_Widget(false, $name = 'Flickr');
    }

  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$flickr_id = apply_filters('flickr_id', $instance['flickr_id']);
		$amount = apply_filters('flickr_image_amount', $instance['image_amount']);
		$suf = rand(100000,999999);
        ?>
              <?php echo $before_widget; ?>



						<?php echo $before_title.$title.$after_title; ?>
						<ul id="flickrImages-<?php echo $suf ?>" class="flickr clearfix"></ul>
						<script type="text/javascript">
                            $('#flickrImages-<?php echo $suf ?>').jflickrfeed({
                                limit: <?php echo $amount ?>,
                                qstrings: {
                                    id: '<?php echo $flickr_id ?>'
                                },
                                itemTemplate: '<li>'+
                                        '<a rel="prettyPhoto[flickr]" href="{{image}}" title="{{title}}">' +
                                        '<img src="{{image_s}}" alt="{{title}}" />' +
                                        '</a>' +
                                        '</li>'
                            }, function(data) {
                                $("a[rel^='prettyPhoto']").prettyPhoto();

                                $("#flickrImages-<?php echo $suf ?> li").hover(function () {
                                    $(this).find("img").stop(true, true).animate({ opacity: 0.5 }, 800);
                                }, function() {
                                    $(this).find("img").stop(true, true).animate({ opacity: 1.0 }, 800);
                                });
                            });
						</script>
    
                        <?php wp_reset_query(); ?>
								
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
			$flickr_id = esc_attr($instance['flickr_id']);
			$amount = esc_attr($instance['image_amount']);
			
        ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID:', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></label></p>
	  <p><label for="<?php echo $this->get_field_id('image_amount'); ?>"><?php _e('Flickr images number:', $domain); ?> <input class="widefat" id="<?php echo $this->get_field_id('image_amount'); ?>" name="<?php echo $this->get_field_name('image_amount'); ?>" type="text" value="<?php echo $amount; ?>" /></label></p>		
			
        <?php 
    }

} // class  Widget
?>