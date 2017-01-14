<?php
function lpd_breadcrumb() {

    $posts_page_id = get_option( 'page_for_posts');
    $posts_page = get_page( $posts_page_id);    

	echo '<a href="';
	echo home_url();
	echo '">';
    _e('Home', GETTEXT_DOMAIN); 
	echo "</a>&nbsp;/ ";
    if (is_home()){
        if($posts_page_id){
            echo "<span class='current'>";
            echo $posts_page->post_title;
            echo "</span>";
        }else{
            echo "<span class='current'>";
            echo bloginfo( 'description' );
            echo "</span>";
        }
    }
	if (is_single()) {
        if (is_singular('portfolio')) {
        echo '<a href="';
        echo get_post_type_archive_link('portfolio');
        echo '">';
        	_e('Portfolio', GETTEXT_DOMAIN); 
        echo "</a>&nbsp;/ ";
        $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
            if($terms){
                foreach($terms as $term) { 
                    echo '<a href="';
                    echo get_term_link($term->slug, 'portfolio_category');
                    echo '">';
                    echo $term->name;
                    echo "</a>&nbsp;/ ";
                }
            }
        } elseif (is_singular('product')) {
        	if(get_the_terms( get_the_ID(), 'product_cat' )){
	            foreach((get_the_terms( get_the_ID(), 'product_cat' )) as $category) { 
	                echo '<a href="';
	                echo get_term_link($category->slug, 'product_cat');
	                echo '">';
	                echo $category->name;
	                echo "</a>&nbsp;/ ";
	            }
            }
        } else{
        if($posts_page_id){
            echo '<a href="';
            echo get_page_link($posts_page_id);
            echo '">';
            echo $posts_page->post_title;
            echo "</a>&nbsp;/ ";
        }
            foreach((get_the_category()) as $category) { 
                echo '<a href="';
                echo get_category_link($category->term_id);
                echo '">';
                echo $category->cat_name;
                echo "</a>&nbsp;/ ";
            }
        }
        echo "<span class='current'>";
        the_title(); 
        echo "</span>";
	} elseif (is_page()) {
        if (!is_front_page()){
        	global $wp_query;
            $page_id = get_post($wp_query->post->ID);        
            $parent = $page_id->post_parent;
            $parent_link = get_permalink($parent);
            $parent_title = get_the_title($parent);
            if($parent){
            echo '<a href="';
            echo($parent_link);
            echo '">';
            echo($parent_title);
            echo "</a>&nbsp;/ ";
            }
            echo "<span class='current'>";
            the_title();
            echo "</span>"; 
        }
    } elseif (is_404()) {
        echo "<span class='current'>";
        _e('404 Error', GETTEXT_DOMAIN); 
        echo "</span>";
    } elseif (is_archive()) {
        echo "<span class='current'>";
        if ( is_day() ) :
            printf( get_the_date('j M Y'));
        elseif ( is_month() ) :
            printf( get_the_date('F Y'));
        elseif ( is_year() ) :
            printf( get_the_date('Y')); 
        else : 
            if ( is_post_type_archive('portfolio') ) {
                _e( 'Portfolio', GETTEXT_DOMAIN); 
            }else{
                _e( 'Archives', GETTEXT_DOMAIN);  
            }
        endif;
        echo "</span>";
        if(is_author()){
            echo "&nbsp;/ <span class='current'>";
            $author = get_userdata( get_query_var('author') );
            echo $author->display_name;
            echo "</span>";
        }elseif(is_category()){
        	echo "&nbsp;/ <span class='current'>";
            _e( 'Category', GETTEXT_DOMAIN);
            echo "</span>";
            echo "&nbsp;/ <span class='current'>";
            single_cat_title();
            echo "</span>";
        }elseif(is_tag()){
        	echo "&nbsp;/ <span class='current'>";
            _e( 'Tag', GETTEXT_DOMAIN);
            echo "</span>";
            echo "&nbsp;/ <span class='current'>";
            single_tag_title();
            echo "</span>";
        }elseif (is_tax('portfolio_category')) {
        	echo "&nbsp;/ <span class='current'>";
            _e( 'Portfolio Category', GETTEXT_DOMAIN);
            echo "</span>";
            echo "&nbsp;/ <span class='current'>";
            echo get_queried_object()->name;
            echo "</span>";
        }elseif (is_tax('portfolio_tags')) {
        	echo "&nbsp;/ <span class='current'>";
            _e( 'Portfolio Tag', GETTEXT_DOMAIN);
            echo "</span>";
            echo "&nbsp;/ <span class='current'>";
            echo get_queried_object()->name;
            echo "</span>";
        } 
	} elseif(is_search()){
        echo " <span class='current'>";
        _e('Search for:', GETTEXT_DOMAIN);                
        the_search_query();
        echo "</span>";
	}
}
?>