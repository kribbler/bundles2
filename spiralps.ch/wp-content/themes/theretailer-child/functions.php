<?php 
function get_post_content_by_slug($slug){
	$post = get_page_by_path( $slug, OBJECT, 'post' );
	$postcontent = apply_filters('the_content', $post->post_content); 
	return $postcontent;
}