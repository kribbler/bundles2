<?php
/* Team Members post type
================================================== */
function front_slider_post_type() 
{
	$labels = array(
		'name' => __( 'Front Slider', GETTEXT_DOMAIN),
		'singular_name' => __( 'Front Slider' , GETTEXT_DOMAIN),
		'add_new' => _x('Add New Slide', 'slide', GETTEXT_DOMAIN),
		'add_new_item' => __('Add New Slide', GETTEXT_DOMAIN),
		'edit_item' => __('Edit Slide', GETTEXT_DOMAIN),
		'new_item' => __('New Slide', GETTEXT_DOMAIN),
		'view_item' => __('View Slide', GETTEXT_DOMAIN),
		'search_items' => __('Search Slide', GETTEXT_DOMAIN),
		'not_found' =>  __('No sliders found', GETTEXT_DOMAIN),
		'not_found_in_trash' => __('No slider found in trash', GETTEXT_DOMAIN), 
		'parent_item_colon' => ''
	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
        'has_archive' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 40,
		'rewrite' => array('slug' => __( 'front_slider' )),
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type(__( 'front_slider' ),$args);
}
/* Team Members taxonomies
================================================== */
function front_slider_taxonomies(){
    
	// Categories
	
	register_taxonomy(
		'front_slider_category',
		'front_slider',
		array(
			'hierarchical' => true,
			'label' => 'Slider Category',
			'query_var' => true,
			'rewrite' => true
		)
	);

}
/* Team Members edit
================================================== */
function front_slider_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Slide' , GETTEXT_DOMAIN),
            "front_slider_category" => __( 'Category' , GETTEXT_DOMAIN),
            "front_slider_thumbnail" => __( 'Image' , GETTEXT_DOMAIN),
        );  
  
        return $columns;  
}  

/* Team Members custom column
================================================== */
function front_slider_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
    		case "front_slider_category":
    			echo get_the_term_list($post->ID, 'front_slider_category', '', ', ','');
    		break;
    		case "front_slider_thumbnail":
    			the_post_thumbnail('thumbnail');
    		break;
        }  
}  

add_action( 'init', 'front_slider_post_type' );
add_action( 'init', 'front_slider_taxonomies', 0 ); 
add_filter("manage_edit-front_slider_columns", "front_slider_edit_columns");  
add_action("manage_posts_custom_column",  "front_slider_custom_columns");  
?>