<?php

function vc_multi_slider_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
   		'taxonomy' => '',
      'include_id' => '',
      'orderby' => '',
      'order' => '',
      'exclude_ids' => ''
      
   ), $atts ) );
   
    multi_slider();
    
    $args = array( 'include' => $include_id );
    
    $exclude_ids = array($exclude_ids);
    
	global $the_multi_slider_ID;
	
	$the_multi_slider_ID = rand(); 
   
   ob_start();?>
   
   		<?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
   
        <?php $terms = get_terms($taxonomy, $args);?>
        
		<div id="mi-slider-<?php echo $the_multi_slider_ID;?>" class="mi-slider">
		
			<?php foreach ($terms as $term) {?>
			<?php $args = array(
				'post_type'	=> 'product',
				$taxonomy => $term->slug
			);
			
			$products = new WP_Query( $args );
			
			
			if ( $products->have_posts() ) : ?>
			
			<ul>
				<?php $query = new WP_Query();?>
				
				<?php
					$new_args = array(
						'orderby' => $orderby,
						'order' => $order,
						'post_type' => 'product',
						$taxonomy => $term->slug,
						'posts_per_page' => '4',
						'post__not_in' => $exclude_ids,
					);
				?>

				<?php $query->query($new_args);?>

				<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>

				<li><a href="<?php the_permalink();?>">
				
			    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {?>
                    <img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'front-shop-thumb2' ); echo $image[0];?>" alt="<?php the_title();?>">
                <?php } else{?>
                	<img src="<?php echo get_template_directory_uri(). '/assets/img/add-featured-image.png'; ?>" alt="<?php the_title();?>">
                <?php }?>
				
				<h4><?php the_title();?></h4></a></li>
				
				<?php endwhile; endif; ?>
			</ul>
			
			<?php endif;
			
			wp_reset_query(); 
			
			}
			?>
			
			<nav>
				<?php foreach ($terms as $term) {?>
					<a href="#"><?php echo $term->name;?></a>
				<?php }?>
			</nav>
		</div>
		
		<?php }?>
		
	<?php 
	$multi_js = new multi_class();
	
	$multi_js->multi_callback();	
	?>
				
	<?php return ob_get_clean();
}
add_shortcode( 'vc_multi_slider', 'vc_multi_slider_func' );


class multi_class
{
    protected static $var = '';

    public static function multi_callback() 
    {
    
	global $the_multi_slider_ID;

	
ob_start();?>

<script>
       
jQuery(function() {

	jQuery( '#mi-slider-<?php echo $the_multi_slider_ID;?>' ).catslider();

});

</script>

<?php $script = ob_get_clean();

        self::$var[] = $script;

        add_action( 'wp_footer', array ( __CLASS__, 'footer' ), 20 );         
    }

	public static function footer() 
	{
	    foreach( self::$var as $script ){
	        echo $script;
	    }
	}

}


vc_map(array(
   "name" => __("Multi Slider", GETTEXT_DOMAIN),
   "base" => "vc_multi_slider",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
	    array(
	      "type" => "dropdown",
	      "heading" => __("Taxonomy", GETTEXT_DOMAIN),
	      "param_name" => "taxonomy",
	      "value" => array( __("Product Category", GETTEXT_DOMAIN) => "product_cat", __("Product Tag", GETTEXT_DOMAIN) => "product_tag" ),
	      "description" => __("Select product taxonomy.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Filter", GETTEXT_DOMAIN),
			 "param_name" => "include_id",
			 "value" => '',
			 "description" => __("Enter product category/tag ids separated by comma, an example: 10,20,30.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Exclude Prodcuts", GETTEXT_DOMAIN),
			 "param_name" => "exclude_ids",
			 "value" => '',
			 "description" => __("Enter product product post ids separated by comma, an example: 10,20,30.", GETTEXT_DOMAIN)
		),
    array(
      "type" => "dropdown",
      "heading" => __("Order by", GETTEXT_DOMAIN),
      "param_name" => "orderby",
      "value" => array( __("Date", GETTEXT_DOMAIN) => "date", __("ID", GETTEXT_DOMAIN) => "ID", __("Author", GETTEXT_DOMAIN) => "author", __("Title", GETTEXT_DOMAIN) => "title", __("Modified", GETTEXT_DOMAIN) => "modified", __("Random", GETTEXT_DOMAIN) => "rand", __("Comment count", GETTEXT_DOMAIN) => "comment_count", __("Menu order", GETTEXT_DOMAIN) => "menu_order" ),
      "description" => sprintf(__('Select how to sort retrieved posts. More at %s.', GETTEXT_DOMAIN), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
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