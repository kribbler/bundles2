<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Main Sidebar', GETTEXT_DOMAIN),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Footer Top', GETTEXT_DOMAIN),
		'before_widget' => '<div class="col-md-3 one-column"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Footer', GETTEXT_DOMAIN),
		'before_widget' => '<div class="col-md-3 one-column"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Shop Sidebar', GETTEXT_DOMAIN),
        'description' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Product Post Sidebar', GETTEXT_DOMAIN),
        'description' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Footer Top 3 Column', GETTEXT_DOMAIN),
		'before_widget' => '<div class="col-md-4 one-column"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Footer 3 Column', GETTEXT_DOMAIN),
		'before_widget' => '<div class="col-md-4 one-column"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Visual Composer Sidebar', GETTEXT_DOMAIN),
        'description' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="title"><span class="align">',
		'after_title' => '</span></h4>',
	));
}

?>