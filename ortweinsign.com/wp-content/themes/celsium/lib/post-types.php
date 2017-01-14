<?php
//bad way but ok for now
//global $pagenow;
//if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
//    if( !get_option('cpt_custom_post_types') ){
//        update_option('cpt_custom_post_types', unserialize('a:4:{i:0;a:15:{s:4:"name";s:8:"services";s:5:"label";s:8:"Services";s:14:"singular_label";s:7:"Service";s:11:"description";s:0:"";s:6:"public";s:1:"1";s:7:"show_ui";s:1:"1";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"0";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:0:"";s:9:"query_var";s:1:"1";s:13:"menu_position";s:0:"";i:0;a:10:{i:0;s:5:"title";i:1;s:6:"editor";i:2;s:7:"excerpt";i:3;s:10:"trackbacks";i:4;s:13:"custom-fields";i:5;s:8:"comments";i:6;s:9:"revisions";i:7;s:9:"thumbnail";i:8;s:6:"author";i:9;s:15:"page-attributes";}i:1;N;i:2;a:11:{s:7:"add_new";s:0:"";s:12:"add_new_item";s:0:"";s:4:"edit";s:0:"";s:9:"edit_item";s:0:"";s:8:"new_item";s:0:"";s:4:"view";s:0:"";s:9:"view_item";s:0:"";s:12:"search_items";s:0:"";s:9:"not_found";s:0:"";s:18:"not_found_in_trash";s:0:"";s:6:"parent";s:0:"";}}i:1;a:15:{s:4:"name";s:5:"works";s:5:"label";s:5:"Works";s:14:"singular_label";s:4:"work";s:11:"description";s:0:"";s:6:"public";s:1:"1";s:7:"show_ui";s:1:"1";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"0";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:0:"";s:9:"query_var";s:1:"1";s:13:"menu_position";s:0:"";i:0;a:10:{i:0;s:5:"title";i:1;s:6:"editor";i:2;s:7:"excerpt";i:3;s:10:"trackbacks";i:4;s:13:"custom-fields";i:5;s:8:"comments";i:6;s:9:"revisions";i:7;s:9:"thumbnail";i:8;s:6:"author";i:9;s:15:"page-attributes";}i:1;N;i:2;a:11:{s:7:"add_new";s:0:"";s:12:"add_new_item";s:0:"";s:4:"edit";s:0:"";s:9:"edit_item";s:0:"";s:8:"new_item";s:0:"";s:4:"view";s:0:"";s:9:"view_item";s:0:"";s:12:"search_items";s:0:"";s:9:"not_found";s:0:"";s:18:"not_found_in_trash";s:0:"";s:6:"parent";s:0:"";}}i:2;a:15:{s:4:"name";s:4:"news";s:5:"label";s:4:"News";s:14:"singular_label";s:3:"New";s:11:"description";s:0:"";s:6:"public";s:1:"1";s:7:"show_ui";s:1:"1";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"0";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:0:"";s:9:"query_var";s:1:"1";s:13:"menu_position";s:0:"";i:0;a:10:{i:0;s:5:"title";i:1;s:6:"editor";i:2;s:7:"excerpt";i:3;s:10:"trackbacks";i:4;s:13:"custom-fields";i:5;s:8:"comments";i:6;s:9:"revisions";i:7;s:9:"thumbnail";i:8;s:6:"author";i:9;s:15:"page-attributes";}i:1;a:1:{i:0;s:7:"newstax";}i:2;a:11:{s:7:"add_new";s:0:"";s:12:"add_new_item";s:0:"";s:4:"edit";s:0:"";s:9:"edit_item";s:0:"";s:8:"new_item";s:0:"";s:4:"view";s:0:"";s:9:"view_item";s:0:"";s:12:"search_items";s:0:"";s:9:"not_found";s:0:"";s:18:"not_found_in_trash";s:0:"";s:6:"parent";s:0:"";}}i:3;a:15:{s:4:"name";s:9:"portfolio";s:5:"label";s:9:"Portfolio";s:14:"singular_label";s:9:"Portfolio";s:11:"description";s:0:"";s:6:"public";s:1:"1";s:7:"show_ui";s:1:"1";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"0";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:0:"";s:9:"query_var";s:1:"1";s:13:"menu_position";s:0:"";i:0;a:10:{i:0;s:5:"title";i:1;s:6:"editor";i:2;s:7:"excerpt";i:3;s:10:"trackbacks";i:4;s:13:"custom-fields";i:5;s:8:"comments";i:6;s:9:"revisions";i:7;s:9:"thumbnail";i:8;s:6:"author";i:9;s:15:"page-attributes";}i:1;a:1:{i:0;s:12:"portfoliocat";}i:2;a:11:{s:7:"add_new";s:0:"";s:12:"add_new_item";s:0:"";s:4:"edit";s:0:"";s:9:"edit_item";s:0:"";s:8:"new_item";s:0:"";s:4:"view";s:0:"";s:9:"view_item";s:0:"";s:12:"search_items";s:0:"";s:9:"not_found";s:0:"";s:18:"not_found_in_trash";s:0:"";s:6:"parent";s:0:"";}}}'));
//        update_option('cpt_custom_tax_types', unserialize('a:1:{i:0;a:10:{s:4:"name";s:12:"portfoliocat";s:5:"label";s:20:"Portfolio Categories";s:14:"singular_label";s:8:"Category";s:12:"hierarchical";s:1:"1";s:7:"show_ui";s:1:"1";s:9:"query_var";s:1:"1";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:0:"";i:0;a:12:{s:12:"search_items";s:0:"";s:13:"popular_items";s:0:"";s:9:"all_items";s:0:"";s:11:"parent_item";s:0:"";s:17:"parent_item_colon";s:0:"";s:9:"edit_item";s:0:"";s:11:"update_item";s:0:"";s:12:"add_new_item";s:0:"";s:13:"new_item_name";s:0:"";s:26:"separate_items_with_commas";s:0:"";s:19:"add_or_remove_items";s:0:"";s:21:"choose_from_most_used";s:0:"";}i:1;a:1:{i:0;s:9:"portfolio";}}}'));
//    }
//}

function afl_register_post_types_hook(){
    //var_dump('sss');
   global $domain;/*
   register_post_type('services', array('label' => __('Services',$domain),'description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'labels' => array (
      'name' => __('Services', $domain),
      'singular_name' => __('Service', $domain),
      'menu_name' => __('Services', $domain),
      'add_new' => __('Add Service', $domain),
      'add_new_item' => __('Add New Service', $domain),
      'edit' => __('Edit', $domain),
      'edit_item' => __('Edit Service', $domain),
      'new_item' => __('New Service', $domain),
      'view' => __('View Service', $domain),
      'view_item' => __('View Service', $domain),
      'search_items' => __('Search Services', $domain),
      'not_found' => __('No Services Found', $domain),
      'not_found_in_trash' => __('No Services Found in Trash', $domain),
      'parent' => __('Parent Service', $domain),
   ),) );*/
   register_post_type('testimonials', array('label' => __( 'Testimonials', $domain ),'description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'labels' => array(
        'name' => __( 'Testimonials', $domain ),
        'singular_name' => __( 'Testimonial', $domain ),
        'add_new' => __( 'Add New', $domain ),
        'add_new_item' => __( 'Add New Testimonial', $domain ),
        'edit' => __( 'Edit', $domain ),
        'edit_item' => __( 'Edit Testimonial', $domain ),
        'new_item' => __( 'New Testimonial Post', $domain ),
        'view' => __( 'View Testimonials', $domain ),
        'view_item' => __( 'View Testmonial', $domain ),
        'search_items' => __( 'Search Testimonials', $domain ),
        'not_found' => __( 'No testimonial found', $domain ),
        'not_found_in_trash' => __( 'No testimonial in Trash', $domain ),
        'parent' => __( 'Parent Testimonial', $domain ),
    ),) );/*
    register_post_type('news', array('label' => __('News', $domain ),'description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'taxonomies' => array('newstax',),'labels' => array (
      'name' => __('News', $domain ),
      'singular_name' => __('New', $domain ),
      'menu_name' => __('News', $domain ),
      'add_new' => __('Add New', $domain ),
      'add_new_item' => __('Add New New', $domain ),
      'edit' => __('Edit', $domain ),
      'edit_item' => __('Edit New', $domain ),
      'new_item' => __('New New', $domain ),
      'view' => __('View New', $domain ),
      'view_item' => __('View New', $domain ),
      'search_items' => __('Search News', $domain ),
      'not_found' => __('No News Found', $domain ),
      'not_found_in_trash' => __('No News Found in Trash', $domain ),
      'parent' => __('Parent New', $domain ),
    ),) );*/
    register_post_type('portfolio', array('label' => __('Portfolio', $domain ),'description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),'taxonomies' => array('portfoliocat',),'labels' => array (
      'name' => __('Portfolio', $domain ),
      'singular_name' => __('Portfolio', $domain ),
      'menu_name' => __('Portfolio', $domain ),
      'add_new' => __('Add Portfolio', $domain ),
      'add_new_item' => __('Add New Portfolio', $domain ),
      'edit' => __('Edit', $domain ),
      'edit_item' => __('Edit Portfolio', $domain ),
      'new_item' => __('New Portfolio', $domain ),
      'view' => __('View Portfolio', $domain ),
      'view_item' => __('View Portfolio', $domain ),
      'search_items' => __('Search Portfolio', $domain ),
      'not_found' => __('No Portfolio Found', $domain ),
      'not_found_in_trash' => __('No Portfolio Found in Trash', $domain ),
      'parent' => __('Parent Portfolio', $domain ),
    ),) );
    //taxonomy
    register_taxonomy('portfoliocat',array (
      0 => 'portfolio',
    ),array( 'hierarchical' => true, 'label' => 'Portfolio Categories','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => 'portfolio'),'singular_label' => 'Category') );
}
add_action('init', 'afl_register_post_types_hook');

?>
