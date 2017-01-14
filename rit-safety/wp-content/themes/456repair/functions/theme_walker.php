<?php
require_once(ABSPATH .'/wp-admin/includes/plugin.php');


class lpd_portfolio_walker extends Walker_Category {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
	
		extract($args);
		
		$cat_slug = esc_attr( $category->slug);
		$cat_name = esc_attr( $category->name);
		
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		
		$link = '<button data-filter=".lpd_'.$cat_slug.'" class="cbp-filter-item">';
		
		$link .= $cat_name;
		
		$link .= ' (<span class="cbp-filter-counter"></span> items)</button>';
	  
		//if ( isset($current_category) && $current_category ){
			//$current_category = get_category( $current_category );
		//}
		
		if ( 'list' == $args['style'] ) {
		  $output .= "<li class='cat-item cat-item-".$category->term_id;
		  $output .= "'>$link\n";
		} else {
		  $output .= "\t$link\n";
		}
		
	}
   
}

class lpd_portfolio_walker1 extends Walker_Category {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
	
		extract($args);
		
		$cat_slug = esc_attr( $category->slug);
		$cat_name = esc_attr( $category->name);
		
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		
		$link = '<button data-filter=".lpd_'.$cat_slug.'" class="cbp-filter-item">';
		
		$link .= $cat_name;
		
		$link .= ' (<div class="cbp-filter-counter"></div>)</button>';
	  
		//if ( isset($current_category) && $current_category ){
			//$current_category = get_category( $current_category );
		//}
		
		if ( 'list' == $args['style'] ) {
		  $output .= "<li class='cat-item cat-item-".$category->term_id;
		  $output .= "'>$link\n";
		} else {
		  $output .= "\t$link\n";
		}
		
	}
   
}

class lpd_portfolio_walker2 extends Walker_Category {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
	
		extract($args);
		
		$cat_slug = esc_attr( $category->slug);
		$cat_name = esc_attr( $category->name);
		
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		
		$link = '<button data-filter=".lpd_'.$cat_slug.'" class="cbp-filter-item">';
		
		$link .= $cat_name;
		
		$link .= '<div class="cbp-filter-counter"></div></button>';
	  
		//if ( isset($current_category) && $current_category ){
			//$current_category = get_category( $current_category );
		//}
		
		if ( 'list' == $args['style'] ) {
		  $output .= "<li class='cat-item cat-item-".$category->term_id;
		  $output .= "'>$link\n";
		} else {
		  $output .= "\t$link<span class='faction'>/</span>\n";
		}
		
	}
   
}

class lpd_portfolio_walker3 extends Walker_Category {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
	
		extract($args);
		
		$cat_slug = esc_attr( $category->slug);
		$cat_name = esc_attr( $category->name);
		
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		
		$link = '<button data-filter=".lpd_'.$cat_slug.'" class="cbp-filter-item">';
		
		$link .= $cat_name;
		
		$link .= '<div class="cbp-filter-counter"></div></button>';
	  
		//if ( isset($current_category) && $current_category ){
			//$current_category = get_category( $current_category );
		//}
		
		if ( 'list' == $args['style'] ) {
		  $output .= "<li class='cat-item cat-item-".$category->term_id;
		  $output .= "'>$link\n";
		} else {
		  $output .= "\t$link\n";
		}
		
	}
   
}

class lpd_portfolio_walker_colio extends Walker_Category {

	function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
	
		extract($args);
		
		$cat_slug = esc_attr( $category->slug);
		$cat_name = esc_attr( $category->name);
		
		$cat_slug = apply_filters( 'list_cats', $cat_slug, $category );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		
		$link = '<a href="#lpd_colio_'.$cat_slug.'">';
		
		$link .= $cat_name;
		
		$link .= '</a>';
	  
		//if ( isset($current_category) && $current_category ){
			//$current_category = get_category( $current_category );
		//}
		
		if ( 'list' == $args['style'] ) {
		  $output .= "<li class='cat-item cat-item-".$category->term_id;
		  $output .= "'>$link\n";
		} else {
		  $output .= "\t$link\n";
		}
		
	}
   
}


class lpd_bootstrap_nav_menu_walker extends Walker_Nav_Menu  {

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		
		$class = "";
		
		if($this->isnavMenu=="standard"){
			if($depth==0){
				$class = "dropdown-menu flyout-menu";
			}else{
				$class = "dropdown-menu sub";
			}
			if($depth==0){
				$output .= "\n$indent<div class=\"$class\"><ul>\n";
			}else{
				$output .= "\n$indent<ul class=\"$class\">\n";
			}
		}
		elseif($this->isnavMenu=="mega"){		
		
			if($depth==0){
			    $menu_title = '';
			
			    preg_match_all('/menu\-item\-(?P<digit>\d+)/', $output, $matches);
			
			    $parent_menu_id = end($matches['digit']);
			
			    if( is_numeric( $parent_menu_id ) ) {
			        $parent_menu = get_post( $parent_menu_id );
			        if (!empty( $parent_menu )) {
			            $menu_item_ID = $parent_menu->ID;
			            $menu_item_description = $parent_menu->post_content;
			            $a = get_post_meta( $parent_menu->ID, '_menu_item_classes', true );
			            $menu_item_classes = implode(" ",$a);
			        }
			    }
			    
			    #$output .= $menu_item_ID;
			    
			    #$output .= $menu_item_description;
			    
				#$output .= $menu_item_classes;
			}
		
			if($depth==0){
				$class = "dropdown-menu row";
			}else{
				$class = "";
			}
			if($depth==0){
				$output .= "\n$indent<div class=\"$class\"><div class='content $menu_item_classes'";
				$output .= " style='background-image:url($menu_item_description);'";
				$output .= ">\n";
			}elseif($depth==1){
				$output .= "";
			}else{
				$output .= "\n$indent<ul class=\"$class\">\n";
			}
			
		}
		elseif($this->isnavMenu=="full_width"){
			if($depth==0){
				$class = "dropdown-menu";
			}else{
				$class = "";
			}
			if($depth==0){
				$output .= "\n$indent<div class=\"$class\"><div class='content'>\n";
			}elseif($depth==1){
				$output .= "";
			}else{
				$output .= "\n$indent<ul class=\"$class\">\n";
			}
		}
		else{
			if($depth==0){
				$class = "dropdown-menu flyout-menu";
			}else{
				$class = "dropdown-menu sub";
			}
			if($depth==0){
				$output .= "\n$indent<div class=\"$class\"><ul>\n";
			}else{
				$output .= "\n$indent<ul class=\"$class\">\n";
			}
		}
		

	}


	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		
		if($this->isnavMenu=="standard"){
			if($depth==0){
				$output .= "$indent</ul></div>\n";
			}else{
				$output .= "$indent</ul>\n";
			}
		}
		elseif($this->isnavMenu=="mega"){
			if($depth==0){
				$output .= "$indent</div></div>\n";
			}elseif($depth==1){
				$output .= "";
			}else{
				$output .= "$indent</ul>\n";
			}
		}
		elseif($this->isnavMenu=="full_width"){
			if($depth==0){
				$output .= "$indent</div></div>\n";
			}elseif($depth==1){
				$output .= "";
			}else{
				$output .= "$indent</ul>\n";
			}
		}
		else{
			if($depth==0){
				$output .= "$indent</ul></div>\n";
			}else{
				$output .= "$indent</ul>\n";
			}
		}

		
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
			global $wp_query, $woocommerce;
			

			
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
			$class_names = $value = $item_output = '';
	        
			$value = get_post_meta( $item->ID, 'menu-item-nav-type-'.$item->ID,true);

			if($value=="standard"){
				$value="standard";
			}
			elseif($value=="mega"){
				$value="mega";
			}
			elseif($value=="full_width"){
				$value="full_width";
			}
			else{
				$value="standard";
			}
						
			if($depth==0){
					
					$this->isnavMenu = $value;
				    
					if($this->isnavMenu == "standard") {
						$this->menutype = "standard";
					}
					if($this->isnavMenu == "mega") {
						$this->menutype = "mega";
					}
					if($this->isnavMenu == "full_width") {
						$this->menutype = "full_width";
					}
	
				}
		
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				
				if($value=="standard"){
					if($depth==0){
						$classes[] = 'standard-menu';
					}
				}
				elseif($value=="mega"){
					if($depth==0){
						$classes[] = 'mega-menu';
					}
				}
				elseif($value=="full_width"){
					if($depth==0){
						$classes[] = 'full-width';
					}
				}
				else{
					if($depth==0){
						$classes[] = 'standard-menu';
					}
				}
				
				$classes[] = ($item->current) ? 'active' : '';
				
				$classes[] = 'menu-item-' . $item->ID;
				
				
				if($this->isnavMenu == "full_width"&&$depth==2||$this->isnavMenu == "mega"&&$depth==2){
					if(in_array("col-1-2", $classes)){
						$classes[] = 'col-md-6';
					}elseif(in_array("col-1-3", $classes)){
						$classes[] = 'col-md-4';
					}elseif(in_array("col-1-4", $classes)){
						$classes[] = 'col-md-3';
					}elseif(in_array("col-1-6", $classes)){
						$classes[] = 'col-md-2';
					}elseif(in_array("col-2-3", $classes)){
						$classes[] = 'col-md-8';
					}elseif(in_array("col-3-4", $classes)){
						$classes[] = 'col-md-9';
					}elseif(in_array("col-5-6", $classes)){
						$classes[] = 'col-md-10';
					}elseif(in_array("col-1-1", $classes)){
						$classes[] = 'col-md-12';
					}elseif(in_array("", $classes)){
						$classes[] = 'col-md-3';
					}
				}
				 
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
	
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	         
			 
				if($this->isnavMenu == "standard") {
				
					$classes = empty( $item->classes ) ? array() : (array) $item->classes;
					
					$output .= $indent . '<li' . $id  . $class_names .'>';
					
					$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
					
					if($args->has_children && $depth > 0) {
						$attributes .= ' href="javascript:;"';
					}else{
						$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
					}
					
					$item_output = $args->before;
					
					$item_output .= '<a'. $attributes .'>';
					
					$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
					
					$item_output .= '</a>';
					
					$item_output .= $args->after;
				
				}
				elseif($this->isnavMenu == "mega") {
				
					if(in_array("row", $classes)&&$depth==1){
					
						$output .= $indent . '<div class="row">';
					}
					elseif(in_array("thumbnail-item", $classes)&&$depth==2){
					
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$item_output = $args->before;
						
						$item_output .= '<div class="thumbnail-item-wrap">';
						
						if($item->description){
					
							$item_output .= '<div class="menu-description">'. esc_attr( $item->description ) .'</div>';
						
						}
						
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->object_id ), 'front-shop-thumb2' );
						
						if ( 'product' == get_post_type($item->object_id) ){
						
							$catalog_type = ot_get_option('catalog_type');
						
							$product_id = get_product($item->object_id);
							$on_sale_products = '';
						
							$item_output .= '<a href="' . esc_attr( $item->url ).'" class="thumbnail-object">';
							
							if ($product_id->is_on_sale()) :
							
								$item_output .= apply_filters('woocommerce_sale_flash', '<span class="lpd-onsale">'.__('Sale!', GETTEXT_DOMAIN).'</span>', $item->object_id, $product_id);
								
								$on_sale_products = ' on-sale-products';
							
							endif;
							
							if ( ! $product_id->is_in_stock() ) :
								$item_output .= '<span class="lpd-out-of-s'.$on_sale_products.'">'.__( 'Out of Stock', GETTEXT_DOMAIN ).'</span>';
							endif;
							
							if(!$image){
							
							    $uploads = THEME_ASSETS;
							    $src = $uploads . '/img/placeholder.png';
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$src.'"/>';
								
							}else{
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$image[0].'"/>';
							}
							
							$item_output .= '</a>';
							
							$item_output .= '<div class="thumbnail-item-content clearfix">';
							
								$item_output .= '<div class="thumbnail-item-title">';
								
									$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
								
								$item_output .= '</div>';
								
								if($catalog_type!="purchases_prices"){
								
									$item_output .= '<div class="thumbnail-item-price">';
									
										$item_output .= $product_id->get_price_html();
									
									$item_output .= '</div>';
								
								}
							
							$item_output .= '</div>';
						
						} elseif( 'portfolio' == get_post_type($item->object_id)){
						
							$item_output .= '<a href="' . esc_attr( $item->url ).'" class="thumbnail-object">';
							
							if(!$image){
							
							    $uploads = THEME_ASSETS;
							    $src = $uploads . '/img/placeholder.png';
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$src.'"/>';
								
							}else{
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$image[0].'"/>';
							}
							
							$item_output .= '</a>';
							
							$item_output .= '<div class="thumbnail-item-content-portfolio clearfix">';
							
								$item_output .= '<div class="thumbnail-item-title">';
								
									$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
								
								$item_output .= '</div>';
							
							$item_output .= '</div>';
						
						}
						
						$item_output .= '</div>';
					
					}
					elseif($item->description&&$depth==2){
						
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$item_output = $args->before;
						
						$item_output .= '<div class="menu-title">';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</div>';
						
						if($item->description){
					
							$item_output .= '<p>'. esc_attr( $item->description ) .'</p>';
						
						}
						
						$item_output .= $args->after;
						
					}
					elseif($depth==2){
						
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
						$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
						$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
						
						$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
						
						$item_output = $args->before;
						
						$item_output .= '<a class="menu-title" '. $attributes .'>';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</a>';
						
						$item_output .= $args->after;
						
					}
					else{
				
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<li' . $id  . $class_names .'>';
						
						$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
						$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
						$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
						
						if($args->has_children && $depth > 0) {
							$attributes .= ' href="javascript:;"';
						}else{
							$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
						}
						
						$item_output = $args->before;
						
						$item_output .= '<a'. $attributes .'>';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</a>';
						
						$item_output .= $args->after;
					
					}
					
				}
				elseif($this->isnavMenu == "full_width") {
				
					if(in_array("row", $classes)&&$depth==1){
					
						$output .= $indent . '<div class="row">';
						
					}
					elseif(in_array("thumbnail-item", $classes)&&$depth==2){
					
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$item_output = $args->before;
						
						$item_output .= '<div class="thumbnail-item-wrap">';
						
						if($item->description){
					
							$item_output .= '<div class="menu-description">'. esc_attr( $item->description ) .'</div>';
						
						}
						
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->object_id ), 'front-shop-thumb2' );
						
						if ( 'product' == get_post_type($item->object_id) ){
						
							$catalog_type = ot_get_option('catalog_type');
						
							$product_id = get_product($item->object_id);
							$on_sale_products = '';
						
							$item_output .= '<a href="' . esc_attr( $item->url ).'" class="thumbnail-object">';
							
							if ($product_id->is_on_sale()) :
							
								$item_output .= apply_filters('woocommerce_sale_flash', '<span class="lpd-onsale">'.__('Sale!', GETTEXT_DOMAIN).'</span>', $item->object_id, $product_id);
								
								$on_sale_products = ' on-sale-products';
							
							endif;
							
							if ( ! $product_id->is_in_stock() ) :
								$item_output .= '<span class="lpd-out-of-s'.$on_sale_products.'">'.__( 'Out of Stock', GETTEXT_DOMAIN ).'</span>';
							endif;
							
							if(!$image){
							
							    $uploads = THEME_ASSETS;
							    $src = $uploads . '/img/placeholder.png';
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$src.'"/>';
								
							}else{
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$image[0].'"/>';
							}
							
							$item_output .= '</a>';
							
							$item_output .= '<div class="thumbnail-item-content clearfix">';
							
								$item_output .= '<div class="thumbnail-item-title">';
								
									$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
								
								$item_output .= '</div>';
								
								if($catalog_type!="purchases_prices"){
								
									$item_output .= '<div class="thumbnail-item-price">';
									
										$item_output .= $product_id->get_price_html();
									
									$item_output .= '</div>';
								
								}
							
							$item_output .= '</div>';
						
						} elseif( 'portfolio' == get_post_type($item->object_id)){
						
							$item_output .= '<a href="' . esc_attr( $item->url ).'" class="thumbnail-object">';
							
							if(!$image){
							
							    $uploads = THEME_ASSETS;
							    $src = $uploads . '/img/placeholder.png';
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$src.'"/>';
								
							}else{
								$item_output .= '<img class="thumbnail-object-img" alt="'. apply_filters( 'the_title', $item->title, $item->ID ) .'" src="'.$image[0].'"/>';
							}
							
							$item_output .= '</a>';
							
							$item_output .= '<div class="thumbnail-item-content-portfolio clearfix">';
							
								$item_output .= '<div class="thumbnail-item-title">';
								
									$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
								
								$item_output .= '</div>';
							
							$item_output .= '</div>';
						
						}
						
						$item_output .= '</div>';
					
					}
					elseif($item->description&&$depth==2){
						
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$item_output = $args->before;
						
						$item_output .= '<div class="menu-title">';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</div>';
						
						if($item->description){
					
							$item_output .= '<p>'. esc_attr( $item->description ) .'</p>';
						
						}
						
						$item_output .= $args->after;
						
					}
					elseif($depth==2){
						
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<div' . $id  . $class_names .'>';
						
						$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
						$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
						$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
						
						$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
						
						$item_output = $args->before;
						
						$item_output .= '<a class="menu-title" '. $attributes .'>';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</a>';
						
						$item_output .= $args->after;
						
					}
					else{
				
						#$classes = empty( $item->classes ) ? array() : (array) $item->classes;
						
						$output .= $indent . '<li' . $id  . $class_names .'>';
						
						$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
						$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
						$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
						
						if($args->has_children && $depth > 0) {
							$attributes .= ' href="javascript:;"';
						}else{
							$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
						}
						
						$item_output = $args->before;
						
						$item_output .= '<a'. $attributes .'>';
						
						$item_output .= $args->link_before . do_shortcode(apply_filters( 'the_title', $item->title, $item->ID )) . $args->link_after;
						
						$item_output .= '</a>';
						
						$item_output .= $args->after;
					
					}
					
				}
 
			 
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			
		
	}


	function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		if($this->isnavMenu == "standard"){
			$output .= "</li>\n";
		}
		elseif($this->isnavMenu == "mega") {
			if(in_array("row", $classes)&&$depth==1){
				$output .= "</div>\n";
			}
			elseif($depth==2){
				$output .= "</div>\n";
			}
			else{
				$output .= "</li>\n";
			}
		}
		elseif($this->isnavMenu == "full_width") {
			if(in_array("row", $classes)&&$depth==1){
				$output .= "</div>\n";
			}
			elseif($depth==2){
				$output .= "</div>\n";
			}
			else{
				$output .= "</li>\n";
			}

		}
	}
	
	
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		
		if ( !$element ) {
			return;
		}
		
		$id_field = $this->db_fields['id'];

		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
}


class lpd_admin_menus_walker extends Walker_Nav_Menu {



	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		
		global $_wp_nav_menu_max_depth;
		
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array('action','customlink-tab','edit-menu-item','menu-item','page-tab','_wpnonce',);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		}
		elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = $original_object->post_title;
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;
		
		$value = get_post_meta( $item_id, 'menu-item-nav-type-'.$item_id,true);
		
		$value_mega = $value_full_width = $value_standard = "";
		
		if(($value=="standard")){
			$value_standard = "checked='yes'";
		}
		else{
			$value_mega = ($value=="mega") ? "checked='yes'"  : "";
			$value_full_width = ($value=="full_width") ? "checked='yes'"  : "";
		}


		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', GETTEXT_DOMAIN), $item->title );
		}
		elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', GETTEXT_DOMAIN), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;?>
		
		
		<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', GETTEXT_DOMAIN); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', GETTEXT_DOMAIN); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item', GETTEXT_DOMAIN); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e('Edit Menu Item', GETTEXT_DOMAIN); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL', GETTEXT_DOMAIN); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<?php _e( 'Navigation Label', GETTEXT_DOMAIN); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute', GETTEXT_DOMAIN); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab', GETTEXT_DOMAIN); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)', GETTEXT_DOMAIN); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)', GETTEXT_DOMAIN); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description', GETTEXT_DOMAIN); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', GETTEXT_DOMAIN); ?></span>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
				
                   <p class="nav-type clearfix">
                   <label for="menu-item-nav-type-<?php echo $item_id; ?>"><?php _e('Navigation Type', GETTEXT_DOMAIN); ?>:</label>
                   <input type="radio" id="menu-item-nav-type-<?php echo $item_id; ?>"  name="menu-item-nav-type-<?php echo $item_id; ?>" <?php  echo $value_standard; ?> value="standard" /> <?php _e('Standard', GETTEXT_DOMAIN); ?> &nbsp&nbsp
                   <input type="radio" id="menu-item-nav-type-<?php echo $item_id; ?>"  name="menu-item-nav-type-<?php echo $item_id; ?>" <?php  echo $value_mega; ?> value="mega" /> <?php _e('Mega', GETTEXT_DOMAIN); ?> &nbsp&nbsp
                   <input type="radio" id="menu-item-nav-type-<?php echo $item_id; ?>"  name="menu-item-nav-type-<?php echo $item_id; ?>" <?php  echo $value_full_width; ?> value="full_width" /> <?php _e('Full Width', GETTEXT_DOMAIN); ?> &nbsp&nbsp
				
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s', GETTEXT_DOMAIN), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e('Remove', GETTEXT_DOMAIN); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php	echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', GETTEXT_DOMAIN); ?></a>
						
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div>
			<ul class="menu-item-transport"></ul>
	
			<?php $output .= ob_get_clean();
			
	}

	function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$output .= "</li>\n";
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {}
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
}


function lpd_modify_backend_walker($name){
	return 'lpd_admin_menus_walker';
}
add_filter( 'wp_edit_nav_menu_walker', 'lpd_modify_backend_walker' , 100);		


/* add custom js for menus */
function lpd_custom_menu_scripts(){
	if(basename( $_SERVER['PHP_SELF']) == "nav-menus.php" )
	{	
	
		wp_enqueue_script( 'theme-walker' , get_template_directory_uri(). '/functions/theme-walker.js', false, true ); 

	}
}
add_action('admin_init', 'lpd_custom_menu_scripts');
				

function lpd_update_menu($menu_id, $menu_item_db){
		$value="";	
		if(isset($_POST['menu-item-nav-type-'.$menu_item_db])){$value = $_POST['menu-item-nav-type-'.$menu_item_db];}		
		update_post_meta( $menu_item_db, 'menu-item-nav-type-'.$menu_item_db , $value );			
}
add_action( 'wp_update_nav_menu_item', 'lpd_update_menu', 100, 3);






class lpd_menu3dmega_list_pages_walker extends Walker_Page{
 
        
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		if($depth==0){
			$output .= "\n$indent<div class=\"dropdown-menu flyout-menu \"><ul>\n";
		}else{
			$output .= "\n$indent<ul class=\"dropdown-menu sub \">\n";
		}
	}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		if($depth==0){
			$output .= "\n$indent</ul></div>\n";
		}else{
			$output .= "\n$indent</ul>\n";
		}
	}   
       
    function start_el(&$output,$page,$depth = 0, $args = array(),$current_object_id = 0){
	    
	    if ( $depth )
	        $indent = str_repeat("\t", $depth);
	    else
	        $indent = '';
	
	    extract($args, EXTR_SKIP);
	    $css_class = array('page_item', 'page-item-'.$page->ID);
		$current_page = $current_object_id;
	    if ( !empty($current_page) ) {
	        $_current_page = get_page( $current_page );
	        get_post_ancestors($_current_page);
	        if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
	            $css_class[] = 'current_page_ancestor active';
	        if ( $page->ID == $current_page )
	            $css_class[] = 'current_page_item';
	        elseif ( $_current_page && $page->ID == $_current_page->post_parent )
	            $css_class[] = 'current_page_parent active';
	    } elseif ( $page->ID == get_option('page_for_posts') ) {
	        $css_class[] = 'current_page_parent active';
	    }

		
		if($args['has_children'] && (integer)$depth < 1) $css_class[] = 'standard-menu';
		
		$css_class = implode(' ',apply_filters('page_css_class',$css_class, $page, $depth, $args, $current_page));
		
		$data = '';
		
		$custom_href = '';
		
		if($args['has_children'] && (integer)$depth > 0) {
			$custom_href = 'javascript:;';
		}else{
			$custom_href = get_permalink($page->ID);
		}
		
		if($args['has_children']) {
			$data = '';
		}
		
		$output .= $indent . '<li class="' . $css_class . '"><a ' . $data . ' href="' . $custom_href . '">' . $link_before . apply_filters('the_title',$page->post_title,$page->ID ) . $link_after;
		
		if($args['has_children'] && (integer)$depth < 1){
			$output .= $indent . '</a>';
		}else{
		   $output .= $indent . '</a>';
		}
		
		if(!empty($show_date)){
		        if('modified' == $show_date) $time = $page->post_modified;
		        else $time = $page->post_date;
		        $output .= " " . mysql2date($date_format,$time);
		}
    }
}
 

?>
