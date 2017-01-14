<?php
/* Portfolio post type
================================================== */
function portfolio_post_type() 
{
	$labels = array(
		'name' => __( 'Portfolio', GETTEXT_DOMAIN),
		'singular_name' => __( 'Portfolio' , GETTEXT_DOMAIN),
		'add_new' => _x('Add New', 'portfolio', GETTEXT_DOMAIN),
		'add_new_item' => __('Add New Portfolio', GETTEXT_DOMAIN),
		'edit_item' => __('Edit Portfolio', GETTEXT_DOMAIN),
		'new_item' => __('New Portfolio', GETTEXT_DOMAIN),
		'view_item' => __('View Portfolio', GETTEXT_DOMAIN),
		'search_items' => __('Search Portfolio Items', GETTEXT_DOMAIN),
		'not_found' =>  __('No portfolio items found', GETTEXT_DOMAIN),
		'not_found_in_trash' => __('No portfolio found in Trash', GETTEXT_DOMAIN), 
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
		'rewrite' => array('slug' => __( 'portfolio' )),
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type(__( 'portfolio' ),$args);
	  flush_rewrite_rules();
}


/* Portfolio taxonomies
================================================== */
function portfolio_taxonomies(){
    
	// Categories
	
	register_taxonomy(
		'portfolio_category',
		'portfolio',
		array(
			'hierarchical' => true,
			'label' => __('Portfolio Categories', GETTEXT_DOMAIN),
			'query_var' => true,
			'rewrite' => true
		)
	);
    
	// Tags
	
	register_taxonomy(
		'portfolio_tags',
		'portfolio',
		array(
			'hierarchical' => false,
			'label' => __('Portfolio Tags', GETTEXT_DOMAIN),
			'query_var' => true,
			'rewrite' => true
		)
	);

}

/* Portfolio edit
================================================== */
function portfolio_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Portfolio Item Title' , GETTEXT_DOMAIN),
            "portfolio_category" => __( 'Categories' , GETTEXT_DOMAIN),
            "portfolio_tags" => __( 'Tags', GETTEXT_DOMAIN),
        );   
  
        return $columns;  
}  

/* Portfolio custom column
================================================== */
function portfolio_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
    		case "portfolio_category":
    			echo get_the_term_list($post->ID, 'portfolio_category', '', ', ','');
    		break;
    		case "portfolio_tags":
    			echo get_the_term_list($post->ID, 'portfolio_tags', '', ', ','');
    		break;
        }  
}  

add_action( 'init', 'portfolio_post_type' );
add_action( 'init', 'portfolio_taxonomies', 0 ); 
add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");  
add_action("manage_posts_custom_column",  "portfolio_custom_columns");  
?>