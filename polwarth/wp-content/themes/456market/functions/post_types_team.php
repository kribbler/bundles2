<?php
/* Team Members post type
================================================== */
function member_post_type() 
{
	$labels = array(
		'name' => __( 'Team Members', GETTEXT_DOMAIN),
		'singular_name' => __( 'Team Members' , GETTEXT_DOMAIN),
		'add_new' => _x('Add New', 'member', GETTEXT_DOMAIN),
		'add_new_item' => __('Add New Member', GETTEXT_DOMAIN),
		'edit_item' => __('Edit Member', GETTEXT_DOMAIN),
		'new_item' => __('New Member', GETTEXT_DOMAIN),
		'view_item' => __('View Member', GETTEXT_DOMAIN),
		'search_items' => __('Search Member', GETTEXT_DOMAIN),
		'not_found' =>  __('No members found', GETTEXT_DOMAIN),
		'not_found_in_trash' => __('No member found in trash', GETTEXT_DOMAIN), 
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
		'rewrite' => array('slug' => __( 'member' )),
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type(__( 'member' ),$args);
}
/* Team Members taxonomies
================================================== */
function member_taxonomies(){
    
	// Categories
	
	register_taxonomy(
		'about_category',
		'member',
		array(
			'hierarchical' => true,
			'label' => 'Member Title',
			'query_var' => true,
			'rewrite' => true
		)
	);

}
/* Team Members edit
================================================== */
function member_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Member Name' , GETTEXT_DOMAIN),
            "about_category" => __( 'Member Title' , GETTEXT_DOMAIN),
            "about_thumbnail" => __( 'Member Picture' , GETTEXT_DOMAIN),
        );  
  
        return $columns;  
}  

/* Team Members custom column
================================================== */
function member_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
    		case "about_category":
    			echo get_the_term_list($post->ID, 'about_category', '', ', ','');
    		break;
    		case "about_thumbnail":
    			the_post_thumbnail('thumbnail');
    		break;
        }  
}  

add_action( 'init', 'member_post_type' );
add_action( 'init', 'member_taxonomies', 0 ); 
add_filter("manage_edit-member_columns", "member_edit_columns");  
add_action("manage_posts_custom_column",  "member_custom_columns");  
?>