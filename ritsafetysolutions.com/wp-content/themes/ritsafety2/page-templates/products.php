<?php
/**
 * Template Name: PRODUCTS PAGE
 
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?> 
<div class="jigoshop">
	<div id="primary" class="site-content-1" style="float:right;">
			<div id="content" role="main">
                 
                <div class="products-category-title">RIT SAFETY PRODUCT CATEGORIES</div>   
                <div class="clear"></div> 
                 
				<ul class="categories">
					<?php  $i = 1;
/*					$args = array(
						'type'                     => 'post',
						'child_of'                 => 0,
						'parent'                   => 0,
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 1,
						'hierarchical'             => false,
						'exclude'                  => '',
						'include'                  => '',
						'number'                   => '',
						'taxonomy'                 => 'product_cat',
						'pad_counts'               => false 
					
					); */
					$args = array( 
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 1,
						'hierarchical'             => false, 
						'taxonomy'                 => 'product_cat' 
					
					); 
                    $categories=  get_categories($args); 
					
					/*echo '<pre>';
					print_r($categories);
					echo '</pre>';*/
                     foreach ($categories as $category) { 		
				 
 						$thumb = jigoshop_product_cat_image( $category->term_id );
						if ( $thumb['thumb_id'] )
							$thumb_image = wp_get_attachment_image( $thumb['thumb_id'], 'shop_small' );
						else
							$thumb_image = jigoshop_get_image_placeholder();
			
                    ?> 
					<li class="category"> 
                        <a href="<?php echo get_term_link($category->slug, 'product_cat'); ?>" style=" text-decoration: none; ">
						<div class="thumb"><?php echo $thumb_image; ?></div>
                        <div class="title"><?php echo $category->cat_name; ?></div>
                        </a>
                    </li>                    
                    <?php 
						if($i==4) {
							$i=1;
							echo '<div class="clear"></div>';
						} else {
							$i++;
						}
                    }
                    ?> 
             </ul>   
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar('jigoshop'); ?>
</div>
<?php get_footer(); ?>