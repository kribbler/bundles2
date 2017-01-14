<?php

add_action( 'widgets_init', 'child_456_widgets_init' );

function child_456_widgets_init(){
    if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
            'name' => 'Footer Column 1',
            'id' => 'footer_column_1',
            'before_widget' => '<div id="%1$s" class="footer_column_1 widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => 'Footer Column 2',
            'id' => 'footer_column_2',
            'before_widget' => '<div id="%1$s" class="footer_column_2 widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => 'Footer Column 3',
            'id' => 'footer_column_3',
            'before_widget' => '<div id="%1$s" class="footer_column_3 widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => 'Footer Column 4',
            'id' => 'footer_column_4',
            'before_widget' => '<div id="%1$s" class="footer_column_4 widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => 'Footer Column 5',
            'id' => 'footer_column_5',
            'before_widget' => '<div id="%1$s" class="footer_column_5 widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));	
		
		register_sidebar(array(
            'name' => __( 'Bellow Footer Left', 'theretailer' ),
            'id' => 'bellow_footer_left',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'Bellow Footer Center', 'theretailer' ),
            'id' => 'bellow_footer_center',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'Bellow Footer Right', 'theretailer' ),
            'id' => 'bellow_footer_right',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		
		register_sidebar(array(
            'name' => __( 'Newsletter Subscribe', 'theretailer' ),
            'id' => 'newsletter_subscribe',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		/*
		register_sidebar(array(
            'name' => __( 'Our Brands', 'theretailer' ),
            'id' => 'our_brands',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
		*/
		register_sidebar(array(
            'name' => __( 'Header Facebook', 'theretailer' ),
            'id' => 'header_facebook',
            'before_widget' => '<div id="%1$s" class="header_facebook widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>',
        ));
    }
}

//* Remove Categories from WooCommerce Product Category Widget
add_filter( 'woocommerce_product_categories_widget_args', 'rv_exclude_wc_widget_categories' );
function rv_exclude_wc_widget_categories( $cat_args ) {
	$cat_args['exclude'] = array('32');
	return $cat_args;
}


function mybar1_func( $atts, $content="" ) {
     return "<div class='mybar1'>" . do_shortcode( $content ) . "</div>";
}
add_shortcode( 'mybar1', 'mybar1_func' );
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
function custom_pre_get_posts_query( $q ) {
 
if ( ! $q->is_main_query() ) return;
if ( ! $q->is_post_type_archive() ) return;
if ( ! is_admin() && is_shop() ) {
 
$q->set( 'tax_query', array(array(
'taxonomy' => 'product_cat',
'field' => 'slug',
'terms' => array( 'Unpublished' ), // Don't display products in the knives category on the shop page
'operator' => 'NOT IN'
)));
}
 
remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
}