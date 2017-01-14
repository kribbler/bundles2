<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_image_size( 'gallery_size', 286, 190, true );

add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;

function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video_container">'.$html.'</div>';
    return $return;
}

/**
 * Proper way to enqueue scripts and styles
 */
function theme_name_scripts() {
	wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_style( 'style-name', 'http://fonts.googleapis.com/css?family=Montserrat:400,700|Pacifico:400|Roboto:400,700|Roboto+Condensed:400' );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css' );
    wp_enqueue_style( 'owl.theme', get_template_directory_uri() . '/css/owl.theme.css' );
    wp_enqueue_style( 'owl.transitions', get_template_directory_uri() . '/css/owl.transitions.css' );

    //wp_enqueue_script( 'jquery'); // use default version
	wp_enqueue_script( 'jquery1.9.1', get_template_directory_uri() . '/js/jquery-1.9.1.min.js', array(), '1.9.1', true );
	wp_enqueue_script( 'circletype', get_template_directory_uri() . '/js/circletype.min.js', array(), '', true );
	wp_enqueue_script( 'circletype-plugins', get_template_directory_uri() . '/js/circletype-plugins.js', array(), '', true );

    wp_enqueue_script( 'select', get_template_directory_uri() . '/js/select.js', array(), '', true );

    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '', true );
    wp_enqueue_script( 'owl-my-carousel', get_template_directory_uri() . '/js/owl-my-carousel.js', array(), '', true );

	wp_enqueue_script( 'ontario-script', get_template_directory_uri() . '/js/ontario-script.js', array(), '', true );


}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

function dd_generate_dropdown($items = array(),$checked_elm=false,$default = 'Please select...',$use_checkbox=false,$echo = true){
	static $unique_id;
	$unique_id++;
	$dropdown_id = 'dropdown_'.$unique_id;
	$return = '<div class="dropdown" id="'.esc_attr($dropdown_id).'">';
		$return .= '<label>'.esc_html($default).'</label>';
	foreach($items as $id=>$item){
		$checkbox_name = esc_attr('checkbox-'.$unique_id.'-'.$id);
		$return .= '<input type="'.($use_checkbox?"checkbox":"radio").'" '.checked($item==$checked_elm,true,false).' name="'.esc_attr($dropdown_id).'[]" id="'.esc_attr($checkbox_name).'"><label for="'.$checkbox_name.'">'.esc_html($item).'</label>';
	}
	$return .= '</div>';
	if($echo)
		echo $return;
	else
		return $return;
}

add_theme_support('menus');

if(function_exists('register_nav_menus')) {
	// Register navigation
	register_nav_menus( array(
	    'primary-nav' 	=> "Primary Menu",
	    'header-nav'	=> "Header Menu",
	    'subheader-nav'	=> "SubHeader Menu",
	    'footer-nav' 	=> "Footer Menu",
        'mobile-menu'   => "Mobile Menu"
	) );
}

function theme_add_bootstrap() {
	//wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css' );
	//wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.0.0', true );
}
 
add_action( 'wp_enqueue_scripts', 'theme_add_bootstrap' );

function my_widgets_init(){
	register_sidebar( array(
        'name' => 'Header Top Right',
        'id' => 'header-top-right',
        'before_widget' => '<div id="%1$s" class="header_top_right sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
	
    register_sidebar( array(
        'name' => 'Header Top Right Mobile',
        'id' => 'header-top-right-mobile',
        'before_widget' => '<div id="%1$s" class="header_top_right sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    
	register_sidebar( array(
        'name' => 'Footer Social',
        'id' => 'footer-social',
        'before_widget' => '<div id="%1$s" class="footer_social sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => 'Footer',
        'id' => 'footer',
        'before_widget' => '<div id="%1$s" class="footer sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
	
}

add_action( 'widgets_init', 'my_widgets_init' );

/*
* Add Custom Meta Boxes to the different pages
*/

add_filter('rwmb_meta_boxes', 'dd_register_meta_boxes');

function dd_register_meta_boxes($meta_boxes) {
    $post_id = isset($_GET['post']) && $_GET['post'] ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);

    $post_data    = get_post($post_id, ARRAY_A);
    $slug       = $post_data['post_name'];

    /*
    * To show a metabox on whatever page is called the Home Page
    */
    if ($post_id && get_option('show_on_front') == 'page' && get_option('page_on_front') == $post_id) {
    	$cruise_pages = get_cruise_pages();

        $meta_boxes[] = array(
            'title'    => 'Extra Content',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Banner Text',
                    'id'    => 'dd_banner_text',
                    'type'    => 'wysiwyg',
                    'desc'    => 'Text to be displayed bellow page title'
                ),
				
                //cruise 1
				array(
                	'name'		=> 'Cruise Title 1',
                	'id'		=> 'dd_cruise_title_1',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Title 1'
                ),
                array(
                	'name'		=> 'Cruise Image 1',
                	'id'		=> 'dd_cruise_image_1',
                	'type'		=> 'file',
                	'desc'		=> 'Cruise Image 1',
                	'max_file_uploads'  => 1
                ),
                array(
                	'name'		=> 'Cruise Description 1',
                	'id'		=> 'dd_cruise_description_1',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Description 1',
                ),
                array(
                	'name'		=> 'Cruise Link 1',
                	'id'		=> 'dd_cruise_link_1',
                	'type'		=> 'select',
                	'desc'		=> 'Cruise Link To 1',
                	'options' 	=> $cruise_pages
                ),

                //cruise 2
                array(
                	'name'		=> 'Cruise Title 2',
                	'id'		=> 'dd_cruise_title_2',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Title 2'
                ),
                array(
                	'name'		=> 'Cruise Image 2',
                	'id'		=> 'dd_cruise_image_2',
                	'type'		=> 'file',
                	'desc'		=> 'Cruise Image 2',
                	'max_file_uploads'  => 1
                ),
                array(
                	'name'		=> 'Cruise Description 2',
                	'id'		=> 'dd_cruise_description_2',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Description 2',
                ),
                array(
                	'name'		=> 'Cruise Link 2',
                	'id'		=> 'dd_cruise_link_2',
                	'type'		=> 'select',
                	'desc'		=> 'Cruise Link To 2',
                	'options' 	=> $cruise_pages
                ),

                //cruise 3
                array(
                	'name'		=> 'Cruise Title 3',
                	'id'		=> 'dd_cruise_title_3',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Title 3'
                ),
                array(
                	'name'		=> 'Cruise Image 3',
                	'id'		=> 'dd_cruise_image_3',
                	'type'		=> 'file',
                	'desc'		=> 'Cruise Image 3',
                	'max_file_uploads'  => 1
                ),
                array(
                	'name'		=> 'Cruise Description 3',
                	'id'		=> 'dd_cruise_description_3',
                	'type'		=> 'text',
                	'desc'		=> 'Cruise Description 3',
                ),
                array(
                	'name'		=> 'Cruise Link 3',
                	'id'		=> 'dd_cruise_link_3',
                	'type'		=> 'select',
                	'desc'		=> 'Cruise Link To 3',
                	'options' 	=> $cruise_pages
                ),

                array(
                	'name'		=> 'Captains Notes`',
                	'id'		=> 'dd_captains_notes',
                	'type'		=> 'wysiwyg',
                	'desc'		=> 'Captains Notes'
                ),

                
                
            ),
        );
    }

    if ($post_data['post_type'] == 'page' && $post_data['post_name'] == 'general-info') {
        
        $meta_boxes[] = array(
            'title'    => 'Friends & Neighbours',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Friend Name 1',
                    'id'    => 'dd_friend_name_1',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Friend Image 1',
                    'id'    => 'dd_friend_image_1',
                    'type'    => 'image',
                    'desc'    => 'Logo Image',
                    'max_file_uploads'  => 1
                ),

                array(
                    'name'    => 'Friend Url 1',
                    'id'    => 'dd_friend_url_1',
                    'type'    => 'text',
                    'desc'    => 'Link to Website',
                ),

                array(
                    'name'    => 'Friend Name 2',
                    'id'    => 'dd_friend_name_2',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Friend Image 2',
                    'id'    => 'dd_friend_image_2',
                    'type'    => 'image',
                    'desc'    => 'Logo Image',
                    'max_file_uploads'  => 1
                ),

                array(
                    'name'    => 'Friend Url 2',
                    'id'    => 'dd_friend_url_2',
                    'type'    => 'text',
                    'desc'    => 'Link to Website',
                ),

                array(
                    'name'    => 'Friend Name 3',
                    'id'    => 'dd_friend_name_3',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Friend Image 3',
                    'id'    => 'dd_friend_image_3',
                    'type'    => 'image',
                    'desc'    => 'Logo Image',
                    'max_file_uploads'  => 1
                ),

                array(
                    'name'    => 'Friend Url 3',
                    'id'    => 'dd_friend_url_3',
                    'type'    => 'text',
                    'desc'    => 'Link to Website',
                ),

                array(
                    'name'    => 'Friend Name 4',
                    'id'    => 'dd_friend_name_4',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Friend Image 4',
                    'id'    => 'dd_friend_image_4',
                    'type'    => 'image',
                    'desc'    => 'Logo Image',
                    'max_file_uploads'  => 1
                ),

                array(
                    'name'    => 'Friend Url 4',
                    'id'    => 'dd_friend_url_4',
                    'type'    => 'text',
                    'desc'    => 'Link to Website',
                ),
               
            ),
        );
    }

    if ($post_data['post_type'] == 'page' && !empty($post_data['page_template']) && $post_data['page_template'] == "template-video-and-gallery.php") {
        
        $meta_boxes[] = array(
            'title'    => 'Video Info',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Video Title',
                    'id'    => 'dd_video_title',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Video Url',
                    'id'    => 'dd_video_url',
                    'type'    => 'text',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Video Description',
                    'id'    => 'dd_video_description',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Gallery Shortcode',
                    'id'    => 'dd_oba_gallery_images',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),
            ),
        );
    }

    if ($post_data['post_type'] == 'page' && $post_data['post_name'] == 'passenger-activities') {
        $meta_boxes[] = array(
            'title'    => 'Video Info',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Video Title',
                    'id'    => 'dd_pa_video_title',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Video Url',
                    'id'    => 'dd_pa_video_url',
                    'type'    => 'text',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Video Description',
                    'id'    => 'dd_pa_video_description',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Gallery Shortcode',
                    'id'    => 'dd_pa_gallery_images',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),
            ),
        );
    }

    if ($post_data['post_type'] == 'page' && $post_data['post_name'] == 'contact-us') {
        
        $meta_boxes[] = array(
            'title'    => 'Contact Details',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Primary Phone',
                    'id'    => 'dd_contact_primary_phone',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Business Phone',
                    'id'    => 'dd_contact_business_phone',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Fax',
                    'id'    => 'dd_contact_fax',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Email',
                    'id'    => 'dd_contact_email',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Shortcode',
                    'id'    => 'dd_contact_shortcode',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                
            ),
        );
    }
	
    if ($post_data['post_type'] == 'page' && $post_data['post_name'] == 'about-us') {
        
        $meta_boxes[] = array(
            'title'    => 'Additional Content',
            'context'    => 'normal',
            'priority'    => '',
            'pages'    => array('page'),
            'fields'    => array(
                array(
                    'name'    => 'Video Title 1',
                    'id'    => 'dd_about_video_title1',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Video Title 2',
                    'id'    => 'dd_about_video_title2',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Video Subtitle',
                    'id'    => 'dd_about_video_subtitle',
                    'type'    => 'text',
                    //'desc'    => 'Just a simple paragraph explaining the team members shown on your homepage'
                ),
                array(
                    'name'    => 'Video Url',
                    'id'    => 'dd_about_video_url',
                    'type'    => 'text',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Meet The Team Description',
                    'id'    => 'dd_about_meet_the_team',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Meet The Team Description 2',
                    'id'    => 'dd_about_meet_the_team2',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Gallery 1 Images Shortcode',
                    'id'    => 'dd_about_us_gallery1_images',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'The Ship ',
                    'id'    => 'dd_about_us_the_ship',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),

                array(
                    'name'    => 'Gallery 2 Images Shortcode',
                    'id'    => 'dd_about_us_gallery2_images',
                    'type'    => 'wysiwyg',
                    //'desc'    => 'Logo Image',
                ),
            ),
        );
    }

    return $meta_boxes;
}

function get_cruise_pages() {
    $page = get_page_by_path( 'cruises' );

    $args = array(
	    'post_parent'       => $page->ID,                               
	    'order'             => 'ASC',
	    'posts_per_page'    => -1,
	    'post_type'			=> 'page'
	);

	$cruises = get_posts($args);
	$final_array = array();

    foreach ($cruises as $cruise) {
        $final_array[$cruise->ID] = $cruise->post_title;
    }

    return $final_array;
}

class Et_Navigation extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $display_depth = ($depth + 1); 
        if($display_depth == '1') {
            $class_names = 'nav-sublist-dropdown';
            $container = 'container';
        } else {
            $class_names = 'nav-sublist';
            $container = '';
        }

        $indent = str_repeat("\t", $depth);

         $output .= "\n$indent<ul class=".$class_names.">\n";
    }

    function end_lvl( &$output, $depth = 1, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . apply_filters('custom_menu_link', esc_attr( $item->url )) .'"' : '';

        $description = '';
        if(strpos($class_names,'image-item') !== false){$description = '<img src="'.do_shortcode($item->description).'" alt=" "/>';}

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= $description;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    } 


}