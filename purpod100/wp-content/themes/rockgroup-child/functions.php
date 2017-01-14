<?php

register_nav_menus( array(
	'main-menu-left'	=> 'Main Menu Left',
	'main-menu-right'	=> 'Main Menu Right',
	'menu-mobile'		=> 'Menu Mobile',
	'footer-menu'		=> 'Footer Menu'
) ); 

global $THEMEREX_mainmenu_left, $THEMEREX_mainmenu_right, $THEMEREX_mainmenu_mobile, $THEMEREX_footer_menu;
	$THEMEREX_mainmenu_left = wp_nav_menu(array(
		'menu'              => '',
		'container'         => '',
		'container_class'   => '',
		'container_id'      => '',
		'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'        => '',
		'menu_id'           => 'main-menu-left',
		'echo'              => false,
		'fallback_cb'       => '',
		'before'            => '',
		'after'             => '',
		'link_before'       => '',
		'link_after'        => '',
		'depth'             => 11,
		'theme_location'    => 'main-menu-left'
	));

	$THEMEREX_mainmenu_right = wp_nav_menu(array(
		'menu'              => '',
		'container'         => '',
		'container_class'   => '',
		'container_id'      => '',
		'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'        => '',
		'menu_id'           => 'main-menu-right',
		'echo'              => false,
		'fallback_cb'       => '',
		'before'            => '',
		'after'             => '',
		'link_before'       => '',
		'link_after'        => '',
		'depth'             => 11,
		'theme_location'    => 'main-menu-right'
	));

	$THEMEREX_mainmenu_mobile = wp_nav_menu(array(
		'menu'              => '',
		'container'         => '',
		'container_class'   => '',
		'container_id'      => '',
		'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'        => '',
		'menu_id'           => 'main-menu-mobile',
		'echo'              => false,
		'fallback_cb'       => '',
		'before'            => '',
		'after'             => '',
		'link_before'       => '',
		'link_after'        => '',
		'depth'             => 11,
		'theme_location'    => 'main-menu-mobile'
	));

	$THEMEREX_footer_menu = wp_nav_menu(array(
		'menu'              => '',
		'container'         => '',
		'container_class'   => '',
		'container_id'      => '',
		'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'menu_class'        => '',
		'menu_id'           => 'footer_menu',
		'echo'              => false,
		'fallback_cb'       => '',
		'before'            => '',
		'after'             => '',
		'link_before'       => '',
		'link_after'        => '',
		'depth'             => 11,
		'theme_location'    => 'footer-menu'
	));

function child_theme_widgets_init(){		
	register_sidebar( array(
        'name' => 'Get The Media Kit',
        'id' => 'get-the-media-kit',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
	register_sidebar( array(
        'name' => 'Footer Follow Us',
        'id' => 'footer-follow-us',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    
    register_sidebar( array(
        'name' => 'Footer Contact Us',
        'id' => 'footer-contact-us',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
}

add_action( 'widgets_init', 'child_theme_widgets_init' );

function get_recent_posts() {
	$args = array(
	    'numberposts' => 5,
	    'offset' => 0,
	    'orderby' => 'post_date',
	    'order' => 'DESC',
	    'post_type' => 'post',
	    'post_status' => 'publish',
	    'suppress_filters' => true );
	$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

	$output = '<ul class="footer_recent_posts">';
	foreach ($recent_posts as $post) {
		$output .= '<li><a href="';
		$output .= get_permalink($post['ID']);
		$output .= '">';
		$output .= $post['post_title'];
		$output .= '</a></li>';
	}

	$output .= '</ul>';
	
	return $output;
}