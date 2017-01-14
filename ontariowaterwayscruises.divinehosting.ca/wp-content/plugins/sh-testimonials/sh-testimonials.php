<?php
/*
Plugin Name: DD Testimonials
Plugin URI: http://www.seoheap.com/
Description: Shows testimonials
Author: James Cantrell
Version: 12.0.0
Author URI: http://www.seoheap.com/
*/
add_action( 'init', 'testimonials_init' );

function testimonials_init() {
	register_post_type( 'testimonials',array(
		'labels' => array(
			'name' => __( 'Testimonials' ),
			'singular_name' => __( 'testimonial' )
		),
		'public' =>true,
		'has_archive' => false,
		'supports'=>array('title','editor','thumbnail'),
		'register_meta_box_cb' => 'add_testimonial_metaboxes',
		'rewrite' => array( 'slug' => 'testimonials', 'with_front'=> false ),
	));	
}

function add_testimonial_metaboxes() {
    add_meta_box('wpt_testimonial_link', 'Other Info', 'wpt_testimonial_sample', 'testimonials', 'normal', 'default');	
}
function wpt_testimonial_sample() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="testimonialmeta_noncename" id="testimonialmeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$position = get_post_meta($post->ID, '_company', true);
	echo 'Company: <input type="text" name="_company" id="position" value="' . $position  . '" class="widefat"/>';
}
function wpt_save_testimonial_meta($post_id, $post) {
	if (!isset($_POST['testimonialmeta_noncename']) || !wp_verify_nonce( $_POST['testimonialmeta_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
	}
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	$meta['_company'] = $_POST['_company'];
	foreach ($meta as $key => $value) {
		$value = implode(',', (array)$value);
		if(get_post_meta($post->ID, $key, FALSE)) {
			update_post_meta($post->ID, $key, $value);
		} else {
			add_post_meta($post->ID, $key, $value);
		}
		if (!$value)
			delete_post_meta($post->ID, $key);
	}
}
add_action('save_post', 'wpt_save_testimonial_meta', 1, 2); // save the custom fields

function testimonials_shortcode($atts) {
	ob_start();
	include dirname(__FILE__).'/testimonials.php';
	$cont=ob_get_contents();
	ob_end_clean();
	return $cont;
}
add_shortcode('testimonials','testimonials_shortcode' );