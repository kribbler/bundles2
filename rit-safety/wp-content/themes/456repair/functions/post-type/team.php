<?php
/* Team post type
================================================== */
function team_post_type() 
{
	$labels = array(
		'name' => __( 'Team', GETTEXT_DOMAIN),
		'singular_name' => __( 'Team' , GETTEXT_DOMAIN),
		'add_new' => _x('Add New', 'team', GETTEXT_DOMAIN),
		'add_new_item' => __('Add New Member', GETTEXT_DOMAIN),
		'edit_item' => __('Edit Member', GETTEXT_DOMAIN),
		'new_item' => __('New Member', GETTEXT_DOMAIN),
		'view_item' => __('View Member', GETTEXT_DOMAIN),
		'search_items' => __('Search Member Items', GETTEXT_DOMAIN),
		'not_found' =>  __('No member items found', GETTEXT_DOMAIN),
		'not_found_in_trash' => __('No member found in Trash', GETTEXT_DOMAIN), 
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
		'menu_position' => 35,
		'rewrite' => array('slug' => 'team'),
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type('team',$args);
	  flush_rewrite_rules();
}


/* Team taxonomies
================================================== */
function team_taxonomies(){
    
	// Categories
	
	register_taxonomy(
		'team_category',
		'team',
		array(
			'hierarchical' => true,
			'label' => __('Team Categories', GETTEXT_DOMAIN),
			'query_var' => true,
			'rewrite' => true
		)
	);
    
	// Tags
	
	register_taxonomy(
		'team_tags',
		'team',
		array(
			'hierarchical' => false,
			'label' => __('Team Tags', GETTEXT_DOMAIN),
			'query_var' => true,
			'rewrite' => true
		)
	);

}

/* Team edit
================================================== */
function team_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Member Title' , GETTEXT_DOMAIN),
            "team_category" => __( 'Categories' , GETTEXT_DOMAIN),
            "team_tags" => __( 'Tags', GETTEXT_DOMAIN),
        );   
  
        return $columns;  
}  

/* Team custom column
================================================== */
function team_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
    		case "team_category":
    			echo get_the_term_list($post->ID, 'team_category', '', ', ','');
    		break;
    		case "team_tags":
    			echo get_the_term_list($post->ID, 'team_tags', '', ', ','');
    		break;
        }  
}  

add_action( 'init', 'team_post_type' );
add_action( 'init', 'team_taxonomies', 0 ); 
add_filter("manage_edit-team_columns", "team_edit_columns");  
add_action("manage_posts_custom_column",  "team_custom_columns");  
?>