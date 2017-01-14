<?php
/**
 * Product taxonomy template
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package             Jigoshop
 * @category            Catalog
 * @author              Jigoshop
 * @copyright           Copyright © 2011-2013 Jigoshop.
 * @license             http://jigoshop.com/license/commercial-edition
 */
 ?>

<?php get_header('shop'); ?>

<?php // do_action('jigoshop_before_main_content'); // <div id="container"><div id="content" role="main"> ?>

<div id="primary" class="site-content-1" style="float:right;">
	<div id="content" role="main">
    
 	<?php 
	$term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']);  
	/*
	//$categories = get_term_children( $term->term_id, 'product_cat' ); 
 	$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => $term->term_id,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'hierarchical'             => false,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => 'product_cat',
		'pad_counts'               => false 
	
	); 
	$categories=  get_categories($args); 
	
	if ( ! empty($categories) ) {
	
		// print_r($categories);
		?> 		

        <div class="products-category-title"><?php echo wptexturize( $term->name ); ?></div>   
        <div class="clear"></div> 
        
        
        <div class="entry-content" style=" font-size:15px; ">
            <?php echo apply_filters( 'jigoshop_product_taxonomy_description', wpautop(wptexturize($term->description)) ); ?>
        </div>
        
        <div class="clear"></div>          
            
		<ul class="sub-categories"> 		
			<?php
			foreach ( $categories  as $category ) {
				
				$term = get_term_by( 'id', $category->term_id, 'product_cat' );
	
				$title = $term->name;
				
				$thumb = jigoshop_product_cat_image( $term->term_id );
				if ( $thumb['thumb_id'] )
					$thumb_image = wp_get_attachment_image( $thumb['thumb_id'], 'shop_small' );
				else
					$thumb_image = jigoshop_get_image_placeholder();
	
				?>
				<li class="category">
				
					<a href="<?php echo get_term_link( $term->slug, 'product_cat' ); ?>" title="<?php echo $title; ?>" class="thumb"><?php echo $thumb_image; ?></a>
					
					<div class="category-text">
						<a href="<?php echo get_term_link( $term->slug, 'product_cat' ); ?>" title="<?php echo $title; ?>" class="title">
						<?php echo ( strlen( $title ) > 70 ) ? substr( $title , 0, 70) . '...' : $title; ?></a>
						Brief copy about each product.
						<a href="<?php echo get_term_link( $term->slug, 'product_cat' ); ?>" title="<?php echo $title; ?>" class="read-more">Read More >></a>
					</div>
					  
					<a href="<?php echo get_term_link( $term->slug, 'product_cat' ); ?>" title="<?php echo $title; ?>" class="shop-button">
					<img src="<?php bloginfo('template_url');?>/images/shop-button.png" /></a>
					
					<div class="clear"></div>
				</li>
				<?php 
			}
			?>
	
		</ul>
	
		<div class="clear"></div>
                        
	<?php
	} else {*/
 	?>

    <div class="products-category-title"><?php echo wptexturize( $term->name ); ?></div>   
    <div class="clear"></div> 
    
        <div class="entry-content" style=" font-size:15px; ">
        
            <?php $term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']); ?>
            
             <?php //echo apply_filters( 'jigoshop_product_taxonomy_header', '<h1 class="page-title">' . wptexturize( $term->name ) . '</h1>' ); ?>
            
            <?php echo apply_filters( 'jigoshop_product_taxonomy_description', wpautop(wptexturize($term->description)) ); ?>
            
            <div class="clear"><br /></div> 
            
            <?php jigoshop_get_template_part( 'loop', 'shop' ); ?>
            
            <?php do_action('jigoshop_pagination'); ?>
    
        </div><!-- entry-content -->
    <?php //} ?>
    </div><!-- #entry-conten -->
</div><!-- #container -->

<?php // do_action('jigoshop_after_main_content'); // </div></div> ?>

<?php // do_action('jigoshop_sidebar'); ?>
 
<?php get_sidebar('jigoshop'); ?>

<?php get_footer('shop'); ?>