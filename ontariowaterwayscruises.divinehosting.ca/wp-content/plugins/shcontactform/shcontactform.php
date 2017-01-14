<?php
/*
Plugin Name: Contact Form
Plugin URI: http://www.seoheap.com/
Description: Shows a nice ajax form
Author: James Cantrell
Version: 1000.0.0
Author URI: http://www.seoheap.com/
*/

class contactformWidget extends WP_Widget {
    function __construct() {
		$this->options = array(
			array(
				'name'=>'title',
				'label'=>'Title',
				'type'=>'text',
				'default'=>''
			),
			array(
				'name'=>'email',
				'label'=>'Email Addresses',
				'type'=>'text',
				'default'=>''			
			),
			array(
				'name'=>'prehtml',
				'label'=>'Pre Text',
				'type'=>'text',
				'default'=>''			
			),
			array(
				'name'=>'posthtml',
				'label'=>'Post Text',
				'type'=>'text',
				'default'=>''			
			),
			array(
				'name'=>'sepname',
				'label'=>'Separate Name',
				'type'=>'checkbox',
				'default'=>''			
			),
			array(
				'name'=>'phone',
				'label'=>'Show Phone',
				'type'=>'checkbox',
				'default'=>''			
			),
			array(
				'name'=>'from',
				'label'=>'From',
				'type'=>'text',
				'default'=>''			
			),
			array(
				'name'=>'view',
				'label'=>'View (if blank loads default form)',
				'type'=>'text',
				'default'=>''			
			)
		);
        parent::__construct(false,$name='Contact Form');	
    }
    function widget($args,$instance) {
		extract($args);
		$title=apply_filters('widget_title',$instance['title']);
		echo $before_widget;  
		if ($title) {
			echo $before_title,$instance['title'],$after_title;
		}
		extract($instance);
		include dirname(__FILE__).'/view.php';
		echo $after_widget;
    }
    function update($new_instance,$old_instance) {				
		$instance=$old_instance;
		foreach ($this->options as $val) {
			switch ($val['type']) {
				case 'text':
					$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
					break;
				case 'checkbox':
					$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
					break;
			}
		}
        return $instance;
    }
    function form($instance) {
		$new=(empty($instance));
		foreach ($this->options as $val) {
			if ($new && $val['default']) {
				$instance[$val['name']]=$val['default'];
			}
			$label='<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
			switch ($val['type']) {
				case 'text':
					echo '<p>',$label,'<br />';
					echo '<input class="widefat" id="',$this->get_field_id($val['name']),'" name="',$this->get_field_name($val['name']),'" type="text" value="',esc_attr($instance[$val['name']]),'"/></p>';
					break;
				case 'checkbox':
					$checked=($instance[$val['name']]) ? ' checked="checked"' : '';
					echo '<input id="',$this->get_field_id($val['name']),'" name="',$this->get_field_name($val['name']),'" type="checkbox"',$checked,'/> ',$label.'<br/>';
					break;
			}
		}
	}
}
add_action('widgets_init', create_function('', 'return register_widget("contactformWidget");'));

function contactform_func($instance) {
	ob_start();
	extract($instance);
	include dirname(__FILE__).'/view.php';
	$cont=ob_get_contents();
	ob_end_clean();
	return $cont;
}
add_shortcode('contactform','contactform_func' );