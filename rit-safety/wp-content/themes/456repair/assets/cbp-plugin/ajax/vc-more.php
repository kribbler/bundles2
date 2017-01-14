<?php
define('WP_USE_THEMES', false);
require_once('../../../../../../wp-load.php');

$identity=$_GET['id'];
$category_filter_identity=$_GET['category_filter'];
$items_identity=$_GET['items'];
$metadata_identity=$_GET['metadata'];
$thumbnail_identity=$_GET['thumbnail'];
$caption_type_identity=$_GET['caption_type'];
$filtertype_identity=$_GET['filtertype'];
$caption_align_identity=$_GET['caption_align'];
$post_type_identity=$_GET['post_type'];
?>

<?php $category_filter = $category_filter_identity;?>
<?php $items = $items_identity;?>
<?php $metadata = $metadata_identity;?>
<?php $thumbnail = $thumbnail_identity;?>
<?php $caption_type = $caption_type_identity;?>
<?php $caption_align = $caption_align_identity;?>
<?php $filtertype = $filtertype_identity;?>

<?php 
if($post_type_identity=="portfolio"){
	$post_type="portfolio";
	$cat_terms="portfolio_category";
} elseif($post_type_identity=="team"){
	$post_type="team";
	$cat_terms="team_category";
} elseif($post_type_identity=="product"){
	$post_type="product";
	$cat_terms="product_cat";
} else{
	$post_type="post";
	$cat_terms="category";
}?>

<?php $thumbnail_filter = ot_get_option('thumbnail_filter');?>

<?php if($category_filter){?>
    <?php query_posts('post_type='. $post_type .'&'. $cat_terms .'='. $category_filter .'&offset='. $items .'');?>
<?php }else{?>
    <?php query_posts('post_type='. $post_type .'&offset='. $items .'');?>
<?php }?>

<div class="cbp-loadMore-block1">

<?php if (have_posts()) :

	while (have_posts()): the_post();?>

	<?php $video_raw = get_post_meta($post->ID, 'video_post_meta', true);?>
	<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
	<?php $terms = get_the_terms($post->ID, $cat_terms ); //get_the_ID ?>
    
	<li class="cbp-item<?php if($terms) : foreach ($terms as $term) { echo ' lpd_'.$term->slug.''; } endif; ?>">
			                        
	    <?php if ($caption_type=='more_view') {?>
	        
	        <div class="cbp-caption">
	        
			<?php if($post_type=="product"){ ?>
			
				<?php woocommerce_show_product_loop_sale_flash(); ?>
				
				<?php global $product;?>
			
				<?php if ( ! $product->is_in_stock() ) : ?>
					<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
				<?php endif; ?>
				
			<?php } ?>
	    
	    <?php } else if ($caption_type=='title_desc_lightbox') {?>
	
	        <?php if ($video_raw) { ?>
	        
	        <a href="<?php echo $video_raw;?>" class="cbp-caption cbp-lightbox" data-title="<?php the_title();?>">
	        
	        <?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	        
	        <a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' ); echo $image[0];?>" class="cbp-caption cbp-lightbox" data-title="<?php echo $attachment_title = get_the_title(get_post_thumbnail_id( get_the_ID() )); ?></br><?php $attachment_caption = get_post(get_post_thumbnail_id( get_the_ID() )); echo($attachment_caption->post_excerpt);?>">
	        
	        <?php }?>
	        
			<?php if($post_type=="product"){ ?>
			
				<?php woocommerce_show_product_loop_sale_flash(); ?>
				
				<?php global $product;?>
			
				<?php if ( ! $product->is_in_stock() ) : ?>
					<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
				<?php endif; ?>
				
			<?php } ?>
	
	    <?php }else{?>
	    
	        
	        <?php if($post_type=="team"){?>
	        
	        	<a href="<?php the_permalink();?>" class="cbp-caption cbp-singlePage">
	        
	        <?php } else{?>
	        
	        	<a href="<?php the_permalink();?>" class="cbp-caption">
	        
	        <?php }?>
	        
			<?php if($post_type=="product"){ ?>
			
				<?php woocommerce_show_product_loop_sale_flash(); ?>
				
				<?php global $product;?>
			
				<?php if ( ! $product->is_in_stock() ) : ?>
					<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
				<?php endif; ?>
				
			<?php } ?>
	    
	    <?php }?>
	    
	        <div class="cbp-caption-defaultWrap">
	        <?php if($thumbnail_filter){?>
	            <?php if($post_type=="product"){?>
	            	<div class="white_isolated"></div>
	            <?php }?>
	        <?php }?>
	        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {?>
	            <img src="
	            <?php if($thumbnail=="square") {?>
	            	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'front-shop-thumb2' ); echo $image[0];?>
	            <?php } else if($thumbnail=="portrait") {?>
	            	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'front-shop-thumb' ); echo $image[0];?>
				<?php } else{?>
	            	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'cubeportfolio' ); echo $image[0];?>
	            <?php }?>
	            " alt="" width="100%">
	        <?php } else{?>
	        	<img src="
	            <?php if($thumbnail=="square") {?>
	            	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image-square.png'; ?>
	            <?php } else if($thumbnail=="portrait") {?>
	            	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image-portrait.png'; ?>
				<?php } else{?>
	            	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image.png'; ?>
	            <?php }?>
	        	" alt="" width="100%">
	        <?php }?>
	        </div>
	        <div class="cbp-caption-activeWrap">
	            <?php if ($caption_align=='left') {?>
	            <div class="cbp-l-caption-alignLeft">
	            <?php } else if($caption_align=='center') {?>
				<div class="cbp-l-caption-alignCenter">
				<?php }?>
	                <div class="cbp-l-caption-body">
	                	
	                
	                    <?php if ($caption_type=='more_view') {?>
	                    
	                        <a href="<?php the_permalink();?>" class="cbp-singlePage cbp-l-caption-buttonLeft btn btn-primary btn-sm"><?php _e('more info', GETTEXT_DOMAIN) ?></a>
	                        <?php if ($video_raw) { ?>
	                        <a href="<?php echo $video_raw;?>" class="cbp-lightbox cbp-l-caption-buttonRight btn btn-primary btn-sm" data-title="<?php the_title();?>"><?php _e("view video", GETTEXT_DOMAIN) ?></a>
	                        <?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
	                        <a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' ); echo $image[0];?>" class="cbp-lightbox cbp-l-caption-buttonRight btn btn-primary btn-sm" data-title="<?php echo $attachment_title = get_the_title(get_post_thumbnail_id( get_the_ID() )); ?></br><?php $attachment_caption = get_post(get_post_thumbnail_id( get_the_ID() )); echo($attachment_caption->post_excerpt);?>"><?php _e("view larger", GETTEXT_DOMAIN) ?></a>
	                        <?php }?>
	                    
	                    <?php } else if($caption_type=='view_post'){?>
	                    
	                    	<div class="cbp-l-caption-text"><?php _e("view post", GETTEXT_DOMAIN) ?></div>
	                    	
	                    <?php } else{?>
	                    
	                        <div class="cbp-l-caption-title"><?php the_title();?></div>
	                        <div class="cbp-l-caption-desc"><?php echo $attachment_title = get_the_title(get_post_thumbnail_id( get_the_ID() )); ?></div>
	                    
	                    <?php }?>
	                    
	                </div>
	            </div>
	        </div>
	        
		<?php if ($caption_type=='more_view') {?>
	    </div>
	    <?php }else{?>
	    </a>
	    <?php }?>
	    
	    <?php if(!$metadata) {?>
	    
			<?php if($post_type=="portfolio"){?>
			    <div class="cbp-l-grid-projects-title">
			    <?php if($link){?>
			        <a href="<?php echo $link;?>"><?php the_title();?></a>
			    <?php } else{?>
			        <a href="<?php the_permalink();?>"><?php the_title();?></a>
			    <?php }?>
			    </div>
			    <?php if($filtertype=='button'||$filtertype=='list'||$filtertype=='alignLeft'||$filtertype=='alignCenter'||$filtertype=='alignRight'){?>
			    <div class="cbp-l-grid-projects-desc"><?php $e='0'; if($terms) : foreach ($terms as $term) { $e++; if($e>1){echo " / ";} echo '<span class="cbp-l-grid-projects-inlineFilters" data-filter=".lpd_'.$term->slug.'">'.$term->name.'</span>'; } endif; ?></div>
			    <?php } else{?>
			    <div class="cbp-l-grid-projects-desc"><?php $e='0'; if($terms) : foreach ($terms as $term) { $e++; if($e>1){echo " / ";} echo '<a class="cbp-l-grid-projects-category" title="'.$term->name.'" href="'.get_term_link($term->slug, "portfolio_category").'">'.$term->name.'</a>'; } endif; ?></div>
			    <?php }?>
			<?php } elseif($post_type=="team"){?>
			
				<a href="<?php the_permalink();?>" class="cbp-singlePage cbp-l-grid-team-name"><?php the_title();?></a>
				
				<?php $position = get_post_meta(get_the_ID(), 'team_options_text', true);?>
				<?php if($position){?>
	            	<div class="cbp-l-grid-team-position"><?php echo $position; ?></div>
	            <?php }?>
	
			<?php } elseif($post_type=="product"){?>
			    <div class="cbp-l-grid-projects-title lpd-cbp-product">
			        <a href="<?php the_permalink();?>"><?php the_title();?></a>
			    </div>
			    <?php $catalog_type = ot_get_option('catalog_type');?>
			    <?php if($catalog_type!="purchases_prices"){?>
			    <div class="lpd-cbp-product-price">
			    <?php woocommerce_template_loop_price(); ?>
			    </div>
			    <?php }?>
			<?php } else{?>
			    <div class="cbp-l-grid-projects-title">
			    <?php if($link){?>
			        <a href="<?php echo $link;?>"><?php the_title();?></a>
			    <?php } else{?>
			        <a href="<?php the_permalink();?>"><?php the_title();?></a>
			    <?php }?>
			    </div>
	            <div class="cbp-l-grid-blog-date"><?php the_time('M j, Y'); ?></div>
	            <div class="cbp-l-grid-blog-split">|</div>
	            <a href="<?php echo get_comments_link(); ?>" class="cbp-l-grid-blog-comments"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a>
			<?php }?>
	        
	    <?php }?>
	    
	</li>

<?php 	endwhile; endif;

wp_reset_query(); 

?>
    
</div>