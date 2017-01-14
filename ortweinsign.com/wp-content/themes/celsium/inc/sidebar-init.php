<?php
function elegance_widgets_init() {
	
	register_sidebar(array(
		'name'			=> 'Footer widget 1',
		'id' 			=> 'footer-widget-1',
		'description'   => __( 'Footer - 1', $domain),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' 			=> 'Footer widget 2',
		'id'			=> 'footer-widget-2',
		'description'	=> __( 'Footer - 2', $domain),
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
	));

    register_sidebar(array(
        'name' 			=> 'Footer widget 3',
        'id'			=> 'footer-widget-3',
        'description'	=> __( 'Footer - 3', $domain),
        'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
        'after_widget'	=> '</div>',
        'before_title'	=> '<h3>',
        'after_title'	=> '</h3>',
    ));

    register_sidebar(array(
        'name' 			=> 'Footer widget 4',
        'id'			=> 'footer-widget-4',
        'description'	=> __( 'Footer - 4', $domain),
        'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
        'after_widget'	=> '</div>',
        'before_title'	=> '<h3>',
        'after_title'	=> '</h3>',
    ));
	
	
    
		
		
}
/** Register sidebars by running elegance_widgets_init() on the widgets_init hook. */
	add_action( 'widgets_init', 'elegance_widgets_init' );
?>