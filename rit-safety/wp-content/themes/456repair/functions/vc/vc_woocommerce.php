<?php

vc_map(array(
   "name" => __("Product", GETTEXT_DOMAIN),
   "base" => "product",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Product ID", GETTEXT_DOMAIN),
			 "param_name" => "id",
			 "value" => "",
		)
   )
));

vc_map(array(
   "name" => __("Products", GETTEXT_DOMAIN),
   "base" => "products",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Product IDs", GETTEXT_DOMAIN),
			 "param_name" => "ids",
			 "value" => "",
			 "description" => __("Enter comma-separated product ids.", GETTEXT_DOMAIN)
		)
   )
));

vc_map(array(
   "name" => __("Product Categories", GETTEXT_DOMAIN),
   "base" => "product_categories",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Number", GETTEXT_DOMAIN),
			 "param_name" => "number",
			 "value" => "",
			 "description" => __("Enter the number of products", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Name", GETTEXT_DOMAIN) => "name" ),
      "description" => sprintf(__('Select how to sort product categories. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order way", GETTEXT_DOMAIN),
      "param_name" => "order",
      "value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Columns", GETTEXT_DOMAIN),
      "param_name" => "columns",
      "value" => array( '2' => "2", '3' => "3", '4' => "4" )
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Hide Empty", GETTEXT_DOMAIN),
      "param_name" => "hide_empty",
      "value" => array( __("Yes", GETTEXT_DOMAIN) => "1", __("No", GETTEXT_DOMAIN) => "0" ),
    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("IDs", GETTEXT_DOMAIN),
			 "param_name" => "ids",
			 "value" => "",
			 "description" => __("Enter comma-separated category ids you want to display", GETTEXT_DOMAIN)
		)
	
   )
));

vc_map(array(
   "name" => __("Product Category ", GETTEXT_DOMAIN),
   "base" => "product_category",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Per Page", GETTEXT_DOMAIN),
			"param_name" => "per_page",
			"value" => "",
			"description" => __("Enter number of products you want to display.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", GETTEXT_DOMAIN),
			"param_name" => "columns",
			"value" => array( '2' => "2", '3' => "3", '4' => "4" )
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order by", GETTEXT_DOMAIN),
			"param_name" => "orderby",
			"value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Author", GETTEXT_DOMAIN) => "author", __("Title", GETTEXT_DOMAIN) => "title", __("Name", GETTEXT_DOMAIN) => "name", __("Modified", GETTEXT_DOMAIN) => "modified", __("Random", GETTEXT_DOMAIN) => "rand", __("Comment count", GETTEXT_DOMAIN) => "comment_count", __("Menu order", GETTEXT_DOMAIN) => "menu_order" ),
			"description" => sprintf(__('Select how to sort product categories. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Order way", GETTEXT_DOMAIN),
			"param_name" => "order",
			"value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
			"description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Caterory", GETTEXT_DOMAIN),
			"param_name" => "category",
			"value" => "",
			"description" => __("Enter comma-separated category slugs to show multiple products", GETTEXT_DOMAIN)
		)
    
   )
));

vc_map(array(
   "name" => __("Recent Products", GETTEXT_DOMAIN),
   "base" => "recent_products",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Per Page", GETTEXT_DOMAIN),
			 "param_name" => "per_page",
			 "value" => "",
			 "description" => __("Enter number of products you want to display.", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Columns", GETTEXT_DOMAIN),
      "param_name" => "columns",
      "value" => array( '2' => "2", '3' => "3", '4' => "4" )
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Author", GETTEXT_DOMAIN) => "author", __("Title", GETTEXT_DOMAIN) => "title", __("Name", GETTEXT_DOMAIN) => "name", __("Modified", GETTEXT_DOMAIN) => "modified", __("Random", GETTEXT_DOMAIN) => "rand", __("Comment count", GETTEXT_DOMAIN) => "comment_count", __("Menu order", GETTEXT_DOMAIN) => "menu_order" ),
      "description" => sprintf(__('Select how to sort product categories. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order way", GETTEXT_DOMAIN),
      "param_name" => "order",
      "value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    )
    
   )
));

vc_map(array(
   "name" => __("Featured Products", GETTEXT_DOMAIN),
   "base" => "featured_products",
   "class" => "",
   "icon" => "icon-wpb-woocom",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
    
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Per Page", GETTEXT_DOMAIN),
			 "param_name" => "per_page",
			 "value" => "",
			 "description" => __("Enter number of products you want to display.", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Columns", GETTEXT_DOMAIN),
      "param_name" => "columns",
      "value" => array( '2' => "2", '3' => "3", '4' => "4" )
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Author", GETTEXT_DOMAIN) => "author", __("Title", GETTEXT_DOMAIN) => "title", __("Name", GETTEXT_DOMAIN) => "name", __("Modified", GETTEXT_DOMAIN) => "modified", __("Random", GETTEXT_DOMAIN) => "rand", __("Comment count", GETTEXT_DOMAIN) => "comment_count", __("Menu order", GETTEXT_DOMAIN) => "menu_order" ),
      "description" => sprintf(__('Select how to sort product categories. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    ),
    array(
      "type" => "dropdown",
      "heading" => __("Order way", GETTEXT_DOMAIN),
      "param_name" => "order",
      "value" => array( __("Descending", GETTEXT_DOMAIN) => "DESC", __("Ascending", GETTEXT_DOMAIN) => "ASC" ),
      "description" => sprintf(__('Designates the ascending or descending order. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
    )
    
   )
));


?>