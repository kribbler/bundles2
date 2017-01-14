<?php

/* walker for wp_list_categories (portfolio filter)
================================================== */
class portfolio_filter_walker extends Walker_Category {
   function start_el(&$output, $category, $depth, $args) {
      extract($args);
      $cat_name = esc_attr( $category->slug);
      $cat_name_ = esc_attr( $category->name);
      $cat_name = apply_filters( 'list_cats', $cat_name, $category );
      $cat_name_ = apply_filters( 'list_cats', $cat_name_, $category );
	  $link = '<a href="#filter" ';
      $link .= 'title="' . sprintf( __('View all items filed under', GETTEXT_DOMAIN), $cat_name) . '" ';
      $link .= 'data-option-value=".'.$cat_name.'"';
      $link .= '>';
      // $link .= $cat_name . '</a>';
      $link .= $cat_name_;
      $link .= '</a>';
      if ( isset($current_category) && $current_category )
         $_current_category = get_category( $current_category );
      if ( 'list' == $args['style'] ) {
          $output .= "<li class='cat-item cat-item-".$category->term_id;
          $output .= "'>$link\n";
       } else {
          $output .= "\t$link<br />\n";
       }
   }
}


class bootstrap_nav_menu_456shop_walker extends Walker_Nav_Menu  {


	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$element = 'ul';
		$type = "";
		$class = "dropdown-menu";

		$output .= "\n$indent<{$element} class=\"$class $type \">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		
		$element = 'ul';
		$clear = "";

		$output .= "$indent</{$element}>$clear\n";
		
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	
			global $wp_query, $woocommerce;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	
			$class_names = $value = '';
		
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			
			$classes[] = ($item->current) ? 'active' : '';
			$classes[] = 'menu-item-' . $item->ID;
			 
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		
			if ($args->has_children && $depth > 0) {
				$class_names .= ' dropdown-submenu';
			} else if($args->has_children && $depth === 0) {
				$class_names .= ' dropdown';
			}

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		  
		  	$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			if(in_array("divider", $classes)){
				$output .= $indent . '<li class="divider"></li>';
			} else {	 
				$output .= $indent . '<li' . $id  . $class_names .'>';
		
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
				
				if($depth==0){
		            $plugins = get_option('active_plugins');
                    $required_plugin = 'woocommerce/woocommerce.php';
                    if ( in_array( $required_plugin , $plugins ) ) {
                        $woo_page_id = woocommerce_get_page_id('shop');
                    }else{
                        $woo_page_id = '0';
                    }
					if($woo_page_id==$item->object_id){
						$attributes .= ($args->has_children) 	    ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle menu-shop"' : 'class="menu-shop"';
					}else{
						$attributes .= ($args->has_children) 	    ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle"' : '';
					}
				}else{
					$attributes .= ($args->has_children) 	    ? '' : '';
				}
				
		
		       if($depth != 0){
					$caret = '</a>';
		       }else{
		           $caret = ' <span class="caret"></span></a>';
		       }
		
				$item_output = $args->before;
				if(in_array("nav-header", $classes)){
					$item_output .= '';
				}else{
					$item_output .= '<a'. $attributes .'>';
				}
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				if(in_array("nav-header", $classes)){
					$item_output .= '';
				}else{
					$item_output .= ($args->has_children) ? $caret : '</a>';
				}
				$item_output .= $args->after;
			}
		 
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output, $item, $depth) {
			$output .= "</li>\n";
	}
	
	
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		
		if ( !$element ) {
			return;
		}
		
		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
}

class bootstrap_list_pages_walker extends Walker_Page{
 
        
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$element = "ul";
		$class = "dropdown-menu";
		$output .= "\n$indent<{$element} class=\"$class \">\n";
	}
        
       
    function start_el(&$output,$page,$depth,$args,$current_page){
	    
	    if ( $depth )
	        $indent = str_repeat("\t", $depth);
	    else
	        $indent = '';
	
	    extract($args, EXTR_SKIP);
	    $css_class = array('page_item', 'page-item-'.$page->ID);
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

		
		if($args['has_children'] && (integer)$depth < 1) $css_class[] = 'dropdown';
		
		$css_class = implode(' ',apply_filters('page_css_class',$css_class, $page, $depth, $args, $current_page));
		
		$data = '';
		
		$dropdown_submenu = '';
		if($args['has_children'] && (integer)$depth > 0) {
			$dropdown_submenu = 'dropdown-submenu';
		}
		
		if($args['has_children']) {
			$data = 'data-toggle="dropdown" data-target="#" class="dropdown-toggle"';
		}
		
		$output .= $indent . '<li class="' . $dropdown_submenu . ' ' . $css_class . '"><a ' . $data . ' href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters('the_title',$page->post_title,$page->ID ) . $link_after;
		
		if($args['has_children'] && (integer)$depth < 1){
			$output .= $indent . ' <span class="caret"></span></a>';
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