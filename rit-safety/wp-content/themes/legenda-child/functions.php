<?php
add_image_size( 'homepage-thumb', 150, 150, true );
add_image_size( 'inner-thumb', 208, 208, true );
add_image_size( 'header-banner', 150, 100, true );

function child_ts_theme_widgets_init(){
    register_sidebar( array(
        'name' => __( 'Header Top Right', 'legenda' ),
        'id' => 'header-top-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Phone', 'legenda' ),
        'id' => 'header-phone',
        'before_widget' => '<div id="%1$s" class="header-phone sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Social', 'legenda' ),
        'id' => 'header-social',
        'before_widget' => '<div id="%1$s" class="header-social sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Home', 'legenda' ),
        'id' => 'header-home',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Header Bar', 'legenda' ),
        'id' => 'header-bar',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Ad Left', 'legenda' ),
        'id' => 'home-ad-1',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Ad Center', 'legenda' ),
        'id' => 'home-ad-2',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Ad Right', 'legenda' ),
        'id' => 'home-ad-3',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Certifications', 'legenda' ),
        'id' => 'certifications',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    
    /*
    register_sidebar( array(
        'name' => __( 'Copyright area 2', 'legenda' ),
        'id' => 'coyright-area-2',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );*/
    
    register_sidebar( array(
        'name' => __( 'Footer Left', 'legenda' ),
        'id' => 'footer-left',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Center', 'legenda' ),
        'id' => 'footer-center',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Right', 'legenda' ),
        'id' => 'footer-right',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Below', 'legenda' ),
        'id' => 'footer-bellow',
        'before_widget' => '<div id="%1$s" class="sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="sidebar_title"><h3>',
        'after_title' => '</h3></div>',
    ) );

}

add_action( 'widgets_init', 'child_ts_theme_widgets_init' );

register_post_type('distributor', array(
        'label' => 'Distributor',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array( 'title', 'editor','thumbnails' ),
    ) );

// **********************************************************************// 
// ! Menus
// **********************************************************************// 
if(!function_exists('etheme_register_s11_menus')) {
    function etheme_register_s11_menus() {
        register_nav_menus(array(
            'left-menu' => __('Left Menu', ETHEME_DOMAIN),
            'right-menu' => __('Right Menusenu', ETHEME_DOMAIN),
            'menu-art'  => __('Menu Art', ETHEME_DOMAIN)
        ));
    }
}

add_action('init', 'etheme_register_s11_menus');

function show_header_banner(){
    global $wpdb;
    global $post;

    $args = apply_filters('woocommerce_related_products_args', array(
        'post_type'             => 'product',
        'meta_key'              => '_featured',
        'meta_value'            => 'yes',
        'ignore_sticky_posts'   => 1,
        'orderby'               => 'rand',
        //'no_found_rows'         => 1,
        'posts_per_page'        => 1
    ) );

    $listings_array = get_posts( $args );

    $price = get_post_meta( $listings_array[0]->ID, '_regular_price');
    if ($price[0]){
        $price = '$' . $price[0];
    } else {
        $price = '<a class="" href="'.site_url().'/contact/">Call For Price</a>';
    }
    //pr($price);
    $product_url = get_permalink( $listings_array[0]->ID );
    $return = "";
    $return .= '<div class="row-fluid">';
        $return .= '<div class="span3">';
            $return .= get_the_post_thumbnail( $listings_array[0]->ID, 'header-banner' );
        $return .= '</div>';

        $return .= '<div class="span9">';
            $return .= '<h2><a href="'.$product_url.'">' . $listings_array[0]->post_title . '</a></h2>';
            $return .= $listings_array[0]->post_excerpt;    
            $return .= ' <a href="'.$product_url.'">Read More</a>';    
            //$return .= '<h3>' . $price . '</h3>';
        $return .= '</div>';            
    $return .= '</div>';

    
    $return .= '<div class="clear"></div>';

    wp_reset_query();
    return $return;
}

add_shortcode( 'get_latest_articles', 'get_latest_articles' );

function get_latest_articles($atts, $content = null) {
    extract(shortcode_atts(array(
        'numberposts' => 2,
        'category' => get_cat_ID( 'Blog' )
    ), $atts ) );

    $limit = 2;

    $query_args = array(
        'numberposts' => 2,
        'category' => get_cat_ID( 'Articles' )
    );

    $posts = get_posts( $query_args );

    $output = "";

    foreach ( $posts as $post ) : setup_postdata( $post );
        $output .= '<div class="footer_article">';
            $output .= '<a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a>';
            $output .= get_the_excerpt();
        $output .= '</div>';
    endforeach;

    //pr($posts);

    return $output;
}


add_shortcode( 'get_latest_blog_posts', 'get_latest_blog_posts' );

function get_latest_blog_posts($atts, $content = null) {
    extract(shortcode_atts(array(
        'numberposts' => 9,
        'category' => get_cat_ID( 'Blog' )
    ), $atts ) );

    $limit = 9;

    $query_args = array(
        'numberposts' => 9,
        'category' => get_cat_ID( 'Blog' )
    );

    $posts = get_posts( $query_args );

    $output = "";
$i = 0;
    foreach ( $posts as $post ) : setup_postdata( $post );
    //pr($post);
        $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        $output .= '<div class="block_" style="width: 30%; float: left">';
            
            $category = get_the_category($post->ID); 
            $output .= '<h2>'.$category[0]->name.'</h2>';
            $output .= '<img src="'.$feat_image.'" class="aligncenter size-full" />';
            $output .= '<h3>' . $post->post_title . '</h3>';
            $output .= '<div class="inner_block_">';
                $output .= $post->post_excerpt;
                $output .= '<a href="'.get_permalink($post->ID).'">Read More</a>';
            $output .= '</div>';
        $output .= '</div>';
        $i++;
        if ($i%3 == 0){
            $output .=  '<div class="clear"></div>';
        }
    endforeach;

    $output .= '<div class="clear"></div>';

    return $output;
}

add_shortcode( 'get_my_categories', 'get_my_categories' );

function get_my_categories($atts, $content = null) {
    extract(shortcode_atts(array(
        'numberposts' => 2,
        'category' => get_cat_ID( 'Blog' )
    ), $atts ) );

    $args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'category',
        'pad_counts'               => false 

    ); 

    $categories = get_categories( $args );

    $output = "<ul class='categories_list'>";

    foreach ($categories as $category){
        $output .= '<li><a href="' . get_category_link( $category->term_id ) . '">'.$category->name.'</a></li>';
    }

    $output .= '</ul>';
    return $output;
    pr($categories);
}

if(!function_exists('my_top_cart')) {
    function my_top_cart() {
        return true;
        global $woocommerce;
        ?>

            <div class="shopping-cart-widget a-right" <?php if(etheme_get_option('favicon_badge')) echo 'data-fav-badge="enable"' ?>>
                <div class="cart-summ" data-items-count="<?php echo $woocommerce->cart->cart_contents_count; ?>">
                    <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><span class="items"><?php echo $woocommerce->cart->cart_contents_count; ?> <?php echo ($woocommerce->cart->cart_contents_count != 1) ? __('items', ETHEME_DOMAIN) : __('item', ETHEME_DOMAIN) ; ?></span> <span class="for-label"><?php _e('for', ETHEME_DOMAIN) ?></span> <span class="price-summ"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span></a>
                </div>
                <div class="cart-popup-container">
                    <div class="cart-popup">
                        <?php
                            etheme_cart_items(3);
                        ?>
                    </div>
                </div> 
            </div>

    <?php
    }
}

add_shortcode( 'footer-cart', 'footer_cart' );

function footer_cart(){
    return "";
    global $woocommerce;

    $output = '<div id="footer_cart">';
    $output .= '<div class="shopping-cart-widget a-right">';
    $output .= '<div class="cart-summ" data-items-count="' . $woocommerce->cart->cart_contents_count . '">';
    $output .= '<span class="items">' . $woocommerce->cart->cart_contents_count . ' ' . 'items</span> <span class="for-label">' . __('for', ETHEME_DOMAIN) . '</span> <span class="price-summ">' . $woocommerce->cart->get_cart_subtotal() . '</span>';
    $output .= '</div>';
    $output .= '<a class="iblock" href="' . $woocommerce->cart->get_cart_url() . '">VIEW CART</a>';
    $output .= '<a class="iblock" href="' . $woocommerce->cart->get_checkout_url() . '">CHECKOUT</a>';

    $output .= '</div>';
    return $output;
}

/*
add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );

function woocommerce_category_image() {
    if ( is_product_category() ){
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        pr($image);
        if ( $image ) {
            echo '<img src="' . $image . '" alt="" />';
        }
    }
} 
*/


function woocommerce_subcats_from_parentcat_by_NAME($parent_cat_NAME) {
    $IDbyNAME = get_term_by('slug', $parent_cat_NAME, 'product_cat');
    $product_cat_ID = $IDbyNAME->term_id;
    
    $args = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        'hide_empty' => 0,
        'parent' => $product_cat_ID,
        'taxonomy' => 'product_cat'
    );
    $subcats = get_categories($args);                

    $k = 1;
    foreach ($subcats as $sc) {
        $link = get_term_link( $sc->slug, $sc->taxonomy );
        $thumbnail_id = get_woocommerce_term_meta( $sc->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id ); 
        echo '<div class="home-category">';
            echo '<a href="'.$link.'"><img src="'.$image.'" alt="subcat" width="167" height="167" class="alignnone size-full wp-image-68" /></a>';
            echo '<a class="subcat-link" href="'. $link .'">'.$sc->name.'</a>';
        echo '</div>';
        if ($k++ % 2 == 0) echo '<div class="clear"></div>';
    }
}

if(!function_exists('etheme_category_header2')){
    function etheme_category_header2() {
        if(function_exists('get_term_meta')){
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            if(!property_exists($cat, "term_id") && !is_search()){
                echo do_shortcode(etheme_get_option('product_bage_banner'));
            }else{
                $image = etheme_get_option('product_bage_banner');
                $queried_object = get_queried_object(); 
                if (isset($queried_object->term_id)){
            
                    $term_id = $queried_object->term_id;  
                    $content = get_term_meta($term_id, 'cat_meta');
            
                    if(isset($content[0]['cat_header'])){
                        $content = apply_filters( 'the_content', $content[0]['cat_header'] );
                        echo do_shortcode($content);
                    }
                }
            }
        }
    }
}

function pr($str){
    echo "<pre>"; var_dump($str); echo "</pre>";
}