<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Front Meta Widget
	Plugin URI: http://www.lpd-themes.com
	Description: A widget that allows to display front meta (only for front meta sidebar).
	Version: 1.0
	Author: lidplussdesign
	Author URI: http://www.lpd-themes.com

-----------------------------------------------------------------------------------*/


// add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'front_meta_widget' );


// register widget.
function front_meta_widget() {
	register_widget( 'Front_Meta_Widget' );
}

// widget class.
class front_meta_widget extends WP_Widget {


/* widget setup
================================================== */
	function Front_Meta_Widget() {
	
		/* widget settings. */
		$widget_ops = array( 'classname' => 'front_meta_widget', 'description' => __('A widget that allows to display front meta (only for front meta sidebar).', GETTEXT_DOMAIN) );

		/* widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'front_meta_widget' );

		/* create the widget. */
		$this->WP_Widget( 'front_meta_widget', __('Front Meta Widget', GETTEXT_DOMAIN), $widget_ops, $control_ops );
	}

/* display widget
================================================== */	
	function widget( $args, $instance ) {
		extract( $args );

	$front_meta_1 = $instance['front_meta_1'];
	$front_meta_2 = $instance['front_meta_2'];
	$front_meta_3 = $instance['front_meta_3'];
	$front_meta_4 = $instance['front_meta_4'];
	
		/* before widget. */
		echo $before_widget;
		
if($front_meta_1 || $front_meta_2 || $front_meta_3 || $front_meta_4){?> 
			  <div class="row-fluid">
				<div class="
<?php if($front_meta_2 && $front_meta_3 && $front_meta_4 ){?>
				span3
<?php }elseif($front_meta_2 && $front_meta_3){?>
				span4
<?php }elseif($front_meta_2){?>
				span6
<?php }else{?>
				span12
<?php }?>
				">
<?php if($front_meta_1){?><div class="item"><?php echo do_shortcode($front_meta_1);?></div><?php }?>					
				</div>
				<?php if($front_meta_2){?><div class="
<?php if(($front_meta_1) && $front_meta_3 && $front_meta_4){?>
				span3
<?php }elseif(($front_meta_1) && $front_meta_3){?>
				span4
<?php }elseif($front_meta_1){?>
				span6
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($front_meta_2);?></div></div><?php }?>
				<?php if($front_meta_3){?><div class="
<?php if(($front_meta_1) && $front_meta_2 && $front_meta_4){?>
				span3
<?php }elseif(($front_meta_1) && $front_meta_2){?>
				span4
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($front_meta_3);?></div></div><?php }?>
				<?php if($front_meta_4){?><div class="
<?php if(($front_meta_1) && $front_meta_2 && $front_meta_3){?>
				span3
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($front_meta_4);?></div></div><?php }?>
			  </div>
<?php }

		/* after widget (defined by themes). */
		echo $after_widget;
	}


/* widget update
================================================== */
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['front_meta_1'] =  $new_instance['front_meta_1'];
		$instance['front_meta_2'] =  $new_instance['front_meta_2'];
		$instance['front_meta_3'] =  $new_instance['front_meta_3'];
		$instance['front_meta_4'] =  $new_instance['front_meta_4'];
        
		/* no need to strip tags for.. */

		return $instance;
	}
	

/* widget settings
================================================== */
	 
	function form( $instance ) {

		/* set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'front_meta_1' ); ?>"><?php _e('Column 1', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('front_meta_1'); ?>" name="<?php echo $this->get_field_name('front_meta_1'); ?>"><?php echo $instance['front_meta_1']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'front_meta_2' ); ?>"><?php _e('Column 2', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('front_meta_2'); ?>" name="<?php echo $this->get_field_name('front_meta_2'); ?>"><?php echo $instance['front_meta_2']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'front_meta_3' ); ?>"><?php _e('Column 3', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('front_meta_3'); ?>" name="<?php echo $this->get_field_name('front_meta_3'); ?>"><?php echo $instance['front_meta_3']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'front_meta_4' ); ?>"><?php _e('Column 4', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('front_meta_4'); ?>" name="<?php echo $this->get_field_name('front_meta_4'); ?>"><?php echo $instance['front_meta_4']; ?></textarea>
        <p>

	
	<?php
	}
}
?>