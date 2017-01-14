<?php function lpd_title() {?>

	<?php $posts_page_id = get_option( 'page_for_posts');
	$posts_page = get_page( $posts_page_id);?>
	
	<?php if(is_home()){
	
	    if($posts_page_id){
	        echo $posts_page->post_title;
	    }else{
	        echo bloginfo( 'description' );
	    }
	    
	}elseif ( is_post_type_archive('product') && get_option('page_on_front') !== woocommerce_get_page_id('shop') ) {
		
		if ( is_search() ) {
			printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
			if ( get_query_var( 'paged' ) )
			printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
		}else{
			$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
			echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
		}
	
	} elseif ( is_tax()) {
	
		echo single_term_title( "", false );
	
	} elseif(is_search()){
	
	    _e('Search for: ', GETTEXT_DOMAIN); the_search_query();
	    	
	} elseif (is_404()) {
	
		_e('404 Error', GETTEXT_DOMAIN);
		 
	} elseif(is_author()){
	
		$author = get_userdata( get_query_var('author') );
		echo $author->display_name;
	
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			
			} elseif (is_shop()) {
			
				$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
				echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
		}
		
	} elseif (is_archive()) {
	
	    if ( is_day() ) :
	        printf( get_the_date('M j, Y'));
	    elseif ( is_month() ) :
	        printf( get_the_date('F Y'));
	    elseif ( is_year() ) :
	        printf( get_the_date('Y'));
	    elseif(is_category()) :
	    	single_cat_title();
	    elseif(is_tag()) :
	    	single_tag_title();
	    else :
	    	_e( 'Archives', GETTEXT_DOMAIN);
	    endif;
	
	} else{
	    the_title();
	}?>
				
<?php }?>