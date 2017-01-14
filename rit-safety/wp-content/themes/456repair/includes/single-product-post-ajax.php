<?php while ( have_posts() ) : the_post(); ?>

<?php global $post,$product;
	$catalog_type = ot_get_option('catalog_type');
?>

<div class="cbp-l-project-title"><?php the_title(); ?></div>
<div class="cbp-l-project-subtitle"><?php #$attachment_caption = get_post(get_post_thumbnail_id( $post->ID )); echo($attachment_caption->post_excerpt);?><?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></div>


<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
<div class="cbp-l-project-img-wrap">
<?php woocommerce_show_product_loop_sale_flash(); ?>

<?php if ( ! $product->is_in_stock() ) : ?>
	<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
<?php endif; ?>
	
<img src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'cubeportfolio-project' ); echo $image[0];?>" alt="<?php $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true); if(count($alt)) echo $alt;?>" class="cbp-l-project-img">

</div>
<?php }?>


<div class="cbp-l-project-container">
	<div class="cbp-l-project-desc">
	    <div class="cbp-l-project-desc-title"><span><?php _e('Product Description', GETTEXT_DOMAIN); ?></span></div>
	    <div class="cbp-l-project-desc-text"><p><?php echo lpd_excerpt_more(125);?></p></div>
	</div>
	<div class="cbp-l-project-details">
		<div class="cbp-l-project-details-title"><span><?php _e('Product Details', GETTEXT_DOMAIN); ?></span></div>

		<ul class="cbp-l-project-details-list">
            <?php if($catalog_type!="purchases_prices"){ if($product->get_price_html()){?><li><strong><?php _e('Price', GETTEXT_DOMAIN); ?>:</strong><span class="price"><?php echo $product->get_price_html(); ?></span></li><?php }}?>
			<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
				<li><strong><?php _e('SKU:', GETTEXT_DOMAIN); ?></strong><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', GETTEXT_DOMAIN ); ?></li>
			<?php endif; ?>
            <?php echo $product->get_categories( ', ', '<li><strong>' . _n( 'Category:', 'Categories:', sizeof( get_the_terms( $post->ID, 'product_cat' ) ), GETTEXT_DOMAIN ) . '</strong>', '.</li>' ); ?>
            <?php echo $product->get_tags( ', ', '<li><strong>' . _n( 'Tag:', 'Tags:', sizeof( get_the_terms( $post->ID, 'product_tag' ) ), GETTEXT_DOMAIN ) . '</strong>', '.</li>' ); ?>
		</ul>
		<?php #woocommerce_template_loop_price(); ?>
        <?php if($product->product_type == 'external'){?>
            <a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('Read More', GETTEXT_DOMAIN); ?></a>
        <?php } elseif($product->product_type == 'variable'){?>
        	<a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('Select Options', GETTEXT_DOMAIN); ?></a>
        <?php } elseif($product->product_type == 'grouped'){?>
        	<a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('View Options', GETTEXT_DOMAIN); ?></a>
        <?php } else{?>
            <a href="<?php the_permalink();?>" class="cbp-l-project-details-visit btn btn-primary"><?php _e('Add to Cart', GETTEXT_DOMAIN); ?></a>
        <?php }?>
	</div>
</div>

<?php endwhile; // end of the loop. ?>