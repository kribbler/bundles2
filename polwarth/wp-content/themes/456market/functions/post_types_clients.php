<?php
/* Clients post type
================================================== */
function client_post_type() 
{
	$labels = array(
		'name' => __( 'Clients', GETTEXT_DOMAIN),
		'singular_name' => __( 'Clients' , GETTEXT_DOMAIN),
		'add_new' => _x('Add New', 'client', GETTEXT_DOMAIN),
		'add_new_item' => __('Add New Client', GETTEXT_DOMAIN),
		'edit_item' => __('Edit Client', GETTEXT_DOMAIN),
		'new_item' => __('New Client', GETTEXT_DOMAIN),
		'view_item' => __('View Client', GETTEXT_DOMAIN),
		'search_items' => __('Search Client', GETTEXT_DOMAIN),
		'not_found' =>  __('No clients found', GETTEXT_DOMAIN),
		'not_found_in_trash' => __('No client found in trash', GETTEXT_DOMAIN), 
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
		'rewrite' => array('slug' => __( 'client' )),
		'supports' => array('title','editor','thumbnail')
	  ); 
	  
	  register_post_type(__( 'client' ),$args);
}

/* Clients edit
================================================== */
function client_edit_columns($columns){  

        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Client Name' , GETTEXT_DOMAIN),
            "client_url" => __( 'Client Url' , GETTEXT_DOMAIN),
            "client_thumbnail" => __( 'Client Logo' , GETTEXT_DOMAIN),
        );  
  
        return $columns;  
}  

/* Client custom column
================================================== */
function client_custom_columns($column){  
        global $post;  
        switch ($column)  
        {
    		case "client_url":
    			the_excerpt();
    		break;
    		case "client_thumbnail":
    			the_post_thumbnail('thumbnail');
    		break;
        }  
}  

add_action( 'init', 'client_post_type' ); 
add_filter("manage_edit-client_columns", "client_edit_columns");  
add_action("manage_posts_custom_column",  "client_custom_columns");  
?>