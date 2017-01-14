<?php
 
/**
 * Product template
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
	$terms = get_the_terms( $post->ID, 'product_cat' );
	$term = current($terms); 
	 ?>  
     
    <div class="products-category-title"><?php echo $term->name; ?> PRODUCTS</div>   
    <div class="clear"></div> 

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); global $_product; $_product = new jigoshop_product( $post->ID ); ?>

		<?php do_action('jigoshop_before_single_product', $post, $_product); ?>
 
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php /*?><?php do_action('jigoshop_before_single_product_summary', $post, $_product); ?> 
			<div class="summary"> 
				<?php do_action( 'jigoshop_template_single_summary', $post, $_product ); ?> 
			</div> 
			<?php do_action('jigoshop_after_single_product_summary', $post, $_product); ?><?php */?>
             
			<div class="summary entry-content" >
            	<div class="product-left-part">
                    <div class="posttitle"><?php the_title();  ?></div>  
                    <?php $price = $_product->get_price_html(); ?> 
                    <?php if ($price != 'Price Not Announced' && $price != 0.00  && $price != 'Free' ){ ?>
                    <?php do_action( 'jigoshop_template_single_summary', $post, $_product ); ?>
                    <?php } ?>
                    <?php the_content(); //do_action('jigoshop_after_single_product_summary', $post, $_product); ?>
                    <br /><br />

                    <?php /*<!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-530ed29648d5b1ae"></script>
                    <!-- AddThis Button END -->*/ ?>

                    
                </div><!--product-left-part -->
                
            	<div class="product-right-part">
                	<?php echo do_shortcode('[ssba]');?>
               <?php /*?> 
                    <div style=" display:block; float:left; padding:0; margin: 0px 30px 0px 0px;">                                   
                        <a href="http://www.facebook.com/pages/RIT-Safety-Solutions-LLC/355744087837067" target="_blank">
                        <img src="<?php bloginfo('template_url'); ?>/images/facebook-iconn.jpg" /></a>
                        
                        <a href=" http://twitter.com/ritsafety" target="_blank">
                        <img src="<?php bloginfo( 'template_url' ); ?>/images/twitter-iconn.jpg"></a> 
                        
                        <a href="<?php bloginfo('url');?>/contact/" target="_blank" >
                        <img src="<?php bloginfo('template_url'); ?>/images/mail-iconn.jpg" /></a>
                    </div>
                    
                <a href="<?php // bloginfo('url');?>/products" style=" display:block; font-family: 'Open Sans Condensed'; font-weight: bold; font-size:15px; color:#b51111; padding: 7px 0px 0px 0px; text-decoration:none; ">BACK TO PRODUCTS</a> 
				<?php */?>
                    
                    <div class="clear"><br /></div>
                    
                    <a href="<?php bloginfo('template_url');?>/RIT_Global_Appraoch_To_Safety_-_SMALL.pdf" target="_blank" class="product-rightboxx-link1">
                    <img src="<?php bloginfo('template_url'); ?>/images/Documents.jpg" /></a> &nbsp;
                    
                    <a href="http://ritsafetysolutions.com/wp-content/uploads/2012/10/Certifications_and_Specifications.pdf" target="_blank" class="product-rightboxx-link2">
                    <img src="<?php bloginfo('template_url'); ?>/images/instruction.jpg" /></a> &nbsp;
                    
                    <a href="http://ritsafetysolutions.com/wp-content/uploads/2012/10/Care_and_Maintenance.pdf" target="_blank" class="product-rightboxx-link3">
                    <img src="<?php bloginfo('template_url'); ?>/images/maintanance.jpg" /></a>  &nbsp;
                    
                    <?php  $pdf_shell_sheat = get_field('pdf_sell_sheet', $post->ID); ?>
                    <?php if ($pdf_shell_sheat){?>
                        <a href="<?php echo $pdf_shell_sheat; ?>" class="product-rightboxx-link4" >
                        <img src="<?php bloginfo('template_url'); ?>/images/shell-sheet.jpg" /></a>
                    <?php }?>
                    
                    
                    <div class="clear"><br /></div>
                    
                    <div class="jigoshop_product_images">                    
                    <?php  do_action('jigoshop_before_single_product_summary', $post, $_product); ?> 
                    </div><!--jigoshop_product_images-->
                    
                    <div class="clear"><br /></div>

                    <?php $product_image = get_field('product_image'); ?>
                        <img src="<?php echo $product_image['url'];?>" alt="<?php echo $product_image['title'];?>" title="<?php echo $product_image['title'];?>" />
                    
                    
                    
                    <div class="clear"><br /></div>
                    <?php   $add_video = get_field('add_video'); 
                    if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
                        //echo "VIDEO:" ; var_dump($add_video);
                    }					
					if ( $add_video) {?>
                        <div class="flash_boxx" style=" width:142px; height:86px; display:block; ">                    
                        	<a href="/videos/?vid=<?php echo $post->ID; ?>"><img src="<?php bloginfo('template_url'); ?>/images/flash-img.jpg" /> </a>
                        </div>
                    <?php } ?>
                    
                     <div class="clear"><br /></div>
                                                            
                </div><!--product-right-part -->
                 
                <div class="clear yellow-line"></div> 
                
                <ul class="product_variation_list">
                <?php 
				
 				$post = get_post( $post_id );
				$post_name_slug = $post->post_name;
				
				$default_attributes = (array) maybe_unserialize(get_post_meta( $post->ID, 'product_attributes', true ));
				
				/*print_r($default_attributes);*/
				
				foreach ( $default_attributes as $key=>$value ) {
					$default_attributes_key = $key;
				}
                  $sanitized_name = sanitize_title( $default_attributes_key );
                
                $variations = get_posts(array(
					'post_type'   => 'product_variation',
					'post_status' => array('publish'),
					'numberposts' => -1,
					'orderby'     => 'id',
					'order'       => 'DESC',
					'post_parent' => $post->ID
                )); 
				
				// print_r($variations);
				
			    if( $variations ) {
					foreach( $variations as $key=>$variation ) {
						$variation->ID;	
						$variation->post_title;
						$variation->post_name; 
						
						if ( (int)$key % 2 == 0 ) {
 							echo '<li class="even">';
						} else {
 							echo '<li>';
						} 
						
						$sanitized_name11 = $post_name_slug.'-'.$sanitized_name.'-';
						$slug_value =sanitize_title(  str_replace($sanitized_name11, '', $variation->post_name) );
 						
						$sku = get_post_meta ( $variation->ID, 'sku' );
						echo '<div class="sku">'.$sku[0].'</div>';
  
						$term = get_term_by( 'slug', $slug_value, 'pa_'.$sanitized_name );							 						  
						echo '<div class="term_name">'.$term->name.'</div>';	 
 						
						$regular_price = get_post_meta ( $variation->ID, 'regular_price' );
						echo '<div class="regular_price">'.get_jigoshop_currency_symbol().' '.$regular_price[0].'</div>';
						
						$sale_price = get_post_meta ( $variation->ID, 'sale_price' );
						// echo '<div class="sale_price">'.$sale_price[0].'</div>'; 
						
 						echo '<div class="clear"></div></li>';
 					}
				}
                ?>
                </ul>
                
                <?php do_action( 'jigoshop_template_single_summary', $post, $_product ); ?> 
                
                <div class="clear yellow-line"></div>                
                <div class="clear"><br /></div>
                
                   
                 <img src="<?php bloginfo('template_url'); ?>/images/certification-logoes1.png" style=" margin: 0px 10px 0px 0px; display:block; float:left; ">
                 <img src="<?php bloginfo('template_url'); ?>/images/certification-logoes2.png" style=" margin: 0px 10px 0px 0px; display:block; float:left;">
                 <?php /*<img src="<?php bloginfo('template_url'); ?>/images/certification-logoes3.png" style=" margin: 0px 10px 0px 0px; display:block; float:left;">*/ ?>
                 <img src="<?php bloginfo('template_url'); ?>/images/certification-logoes4.png" style=" margin: 0px 10px 0px 0px; display:block; float:left;">
                 <img src="<?php bloginfo('template_url'); ?>/images/certification-logoes5.png" style=" margin: 0px 10px 0px 0px; display:block; float:left;"> 
                 
                <div class="MadeinUSA-bottom-boxx">
                 <img src="<?php bloginfo('template_url'); ?>/images/MadeinUSA.jpg" style=" display:block; margin: 0px 12px 0px 0px; float:left;">Our products are designed, developed and manufactured in the United States of America at our Twinsburg, Ohio facility and are <a href="http://ritsafetysolutions.com/wp-content/uploads/2012/09/RL31236.pdf" target="_blank">Berry Amendment</a> compliant.
                </div>
                 
                <div class="clear"></div>
                
			</div>
 
		</article><!-- #post -->

		<?php do_action('jigoshop_after_single_product', $post, $_product); ?>

	<?php endwhile; ?>
 
    </div><!-- #content -->
</div><!-- #container -->

<?php // do_action('jigoshop_after_main_content'); // </div></div> ?>

<?php // do_action('jigoshop_sidebar'); ?>
 
<?php get_sidebar('jigoshop'); ?>

<?php get_footer('shop'); ?>