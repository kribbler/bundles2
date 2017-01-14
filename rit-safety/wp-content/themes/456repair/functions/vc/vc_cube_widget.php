<?php

function vc_cube_widget_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      	'post_type' => '',
		'columns' => '',
		'caption_type' => '',
		'caption_align' => '',
		'thumbnail' => '',
		'border_radius' => '',
		'metadata' => '',
		'social_media' => '',
		'items' => '',
		'filtertype' => '',
		'category_filter' => '',
		'animationtype' => '',
		'gaphorizontal' => '',
		'gapvertical' => '',
		'caption' => '',
		'displaytype' => '',
		'displaytypespeed' => '',
		'no_more_works' => '',
		'disable_load_more' => ''
   ), $atts ) );
   
   global $shortcode_atts;
   
   $shortcode_atts = array(
		'animationtype' => $animationtype,
		'gaphorizontal' => $gaphorizontal,
		'gapvertical' => $gapvertical,
		'caption' => $caption,
		'displaytype' => $displaytype,
		'displaytypespeed' => $displaytypespeed,
		'no_more_works' => $no_more_works,
   );
   
   
	if($post_type=="portfolio"){
		$post_type="portfolio";
		$cat_terms="portfolio_category";
	} elseif($post_type=="team"){
		$post_type="team";
		$cat_terms="team_category";
	} elseif($post_type=="product"){
		$post_type="product";
		$cat_terms="product_cat";
	} else{
		$post_type="post";
		$cat_terms="category";
	}
	
	if(!$items){
		$items='9999';
	}
	
	$thumbnail_filter = ot_get_option('thumbnail_filter');
   
	global $wpdb, $woocommerce;
	
	$category_filter_slugs = explode(",", $category_filter);
	$category_filter_id = '';
	foreach($category_filter_slugs as $category_filter_slug){
	     $category_filter_id .= $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE slug='$category_filter_slug'").',';
	}
	
	global $the_cube_t_ID;
	$the_cube_t_ID = get_the_ID();	
   
	ob_start();?>
	

		        <div class="lpd-cbp-wrapper">
		 
		            <?php if($filtertype=='button'||$filtertype=='list'||$filtertype=='alignLeft'||$filtertype=='alignCenter'||$filtertype=='alignRight'){?>
		            <div id="filters-container" class="cbp-l-filters-<?php echo $filtertype; ?>">
		            	<?php if($filtertype=='list'||$filtertype=='alignLeft'){?>
		                <button data-filter="*" class="cbp-filter-item-active cbp-filter-item"><?php _e('All', GETTEXT_DOMAIN) ?> (<div class="cbp-filter-counter"></div>)</button>
		                <?php wp_list_categories(array('title_li' => '', 'style' => '', 'taxonomy' => $cat_terms, 'include' => $category_filter_id, 'walker' => new lpd_portfolio_walker1())); ?>
		                <?php } elseif($filtertype=='alignCenter') {?>
		                <button data-filter="*" class="cbp-filter-item-active cbp-filter-item"><?php _e('All', GETTEXT_DOMAIN) ?><div class="cbp-filter-counter"></div></button>/
		                <?php wp_list_categories(array('title_li' => '', 'style' => '', 'taxonomy' => $cat_terms, 'include' => $category_filter_id, 'walker' => new lpd_portfolio_walker2())); ?>
		                <?php } else {?>
		                <button data-filter="*" class="cbp-filter-item-active cbp-filter-item"><?php _e('All', GETTEXT_DOMAIN) ?><div class="cbp-filter-counter"></div></button>
		                <?php wp_list_categories(array('title_li' => '', 'style' => '', 'taxonomy' => $cat_terms, 'include' => $category_filter_id, 'walker' => new lpd_portfolio_walker3())); ?>
		                <?php }?>
		            </div>
		            <?php } elseif ($filtertype=='dropdown'){?>
		            <div id="filters-container" class="cbp-l-filters-dropdown">
		                <div class="cbp-l-filters-dropdownWrap">
		                    <div class="cbp-l-filters-dropdownHeader">Sort Gallery</div>
		                    <ul class="cbp-l-filters-dropdownList">
		                        <li>
		                            <button data-filter="*" class="cbp-filter-item-active cbp-filter-item"><?php _e('All', GETTEXT_DOMAIN) ?> (<span class="cbp-filter-counter"></span> items)</button>
		                        </li>
		                        <?php wp_list_categories(array('title_li' => '', 'taxonomy' => $cat_terms, 'include' => $category_filter_id, 'walker' => new lpd_portfolio_walker())); ?>
		                    </ul>
		                </div>
		            </div>
		            <?php }?>
		
		            <div id="grid-container-<?php echo $the_cube_t_ID ?>" class="<?php if($caption_type=='view_post'){?>cbp-l-grid-projects <?php }?>lpd-cbp-project cbp-<?php if($columns) { echo $columns; } else{ echo '4';}?>-columns <?php if($metadata) {?> cbp-no-meta<?php }?><?php if($thumbnail=="square") {?> cbp-square<?php } else if($thumbnail=="portrait"){?> cbp-portrait<?php }?>">
		                <ul>
							<?php $query = new WP_Query();?>
							<?php if($category_filter){?>
							    <?php $query->query('post_type='. $post_type .'&'. $cat_terms .'='. $category_filter .'&posts_per_page='. $items .'');?>
							<?php }else{?>
							    <?php $query->query('post_type='. $post_type .'&posts_per_page='. $items .'');?>
							<?php }?>
							<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
							<?php $video_raw = get_post_meta(get_the_ID(), 'video_post_meta', true);?>
							<?php $link = get_post_meta(get_the_ID(), 'link_post_meta', true); ?>
							<?php $terms = get_the_terms(get_the_ID(), $cat_terms ); //get_the_ID ?>
							
							
							
							
		                    <li class="cbp-item<?php if($terms) : foreach ($terms as $term) { echo ' lpd_'.$term->slug.''; } endif; ?><?php if(!$metadata){ ?><?php if($post_type=="team"){ ?><?php if($social_media){?> team-post-icons<?php } ?><?php } ?><?php } ?>">
		                    
	                    		<?php if($post_type=="product"){ ?>
								
									<?php woocommerce_show_product_loop_sale_flash(); ?>
									
									<?php global $product;?>
								
									<?php if ( ! $product->is_in_stock() ) : ?>
										<span class="lpd-out-of-s<?php if ($product->is_on_sale()) { ?> on-sale-products<?php }?>"><?php _e( 'Out of Stock', GETTEXT_DOMAIN ); ?></span>
									<?php endif; ?>
									
								<?php } ?>
		                        
		                        <?php if ($caption_type=='more_view') {?>
			                        
			                        <div class="cbp-caption<?php if ($border_radius) { echo ' '. $border_radius;  } ?>">
		                        
		                        <?php } else if ($caption_type=='title_desc_lightbox') {?>

                                    <?php if ($video_raw) { ?>
                                    
                                    <a href="<?php echo $video_raw;?>" class="cbp-caption cbp-lightbox<?php if ($border_radius) { echo ' '. $border_radius;  } ?>" data-title="<?php the_title();?>">
                                    
                                    <?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
                                    
                                    <a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' ); echo $image[0];?>" class="cbp-caption cbp-lightbox<?php if ($border_radius) { echo ' '. $border_radius;  } ?>" data-title="<?php echo $attachment_title = get_the_title(get_post_thumbnail_id( get_the_ID() )); ?></br><?php $attachment_caption = get_post(get_post_thumbnail_id( get_the_ID() )); echo($attachment_caption->post_excerpt);?>">
                                    
                                    <?php }?>                                 
				

		                        <?php }else{?>
		                        
			                        
			                        <?php if($post_type=="team"){?>
			                        
			                        	<a href="<?php the_permalink();?>" class="cbp-caption cbp-singlePage<?php if ($border_radius) { echo ' '. $border_radius;  } ?>">
			                        
			                        <?php } else{?>
			                        
				                        <?php if($link){?>
				                        	<a href="<?php echo $link;?>" class="cbp-caption<?php if ($border_radius) { echo ' '. $border_radius;  } ?>">
				                        <?php } else{?>
				                        	<a href="<?php the_permalink();?>" class="cbp-caption<?php if ($border_radius) { echo ' '. $border_radius;  } ?>">
				                        <?php }?>
			                        
			                        <?php }?>
		                        
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
		                                " alt="">
		                            <?php } else{?>
		                            	<img src="
		                                <?php if($thumbnail=="square") {?>
		                                	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image-square.png'; ?>
		                                <?php } else if($thumbnail=="portrait") {?>
		                                	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image-portrait.png'; ?>
										<?php } else{?>
		                                	<?php echo get_template_directory_uri(). '/assets/img/add-featured-image.png'; ?>
		                                <?php }?>
		                            	" alt="">
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
		                                        
							                        <?php if($link){?>
							                        	<div class="cbp-l-caption-text"><?php _e("view project", GETTEXT_DOMAIN) ?></div>
							                        <?php } else{?>
							                        	<div class="cbp-l-caption-text"><?php _e("view post", GETTEXT_DOMAIN) ?></div>
							                        <?php }?>
		                                        	
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
										<?php $facebook = get_post_meta(get_the_ID(), 'team_options_facebook', true);?>
										<?php $twitter = get_post_meta(get_the_ID(), 'team_options_twitter', true);?>
										<?php $linkedin = get_post_meta(get_the_ID(), 'team_options_linkedin', true);?>
										<?php $pinterest = get_post_meta(get_the_ID(), 'team_options_pinterest', true);?>
										<?php $google_plus = get_post_meta(get_the_ID(), 'team_options_google_plus', true);?>
										<?php $tumblr = get_post_meta(get_the_ID(), 'team_options_tumblr', true);?>
										<?php $instagram = get_post_meta(get_the_ID(), 'team_options_instagram', true);?>
										<?php $custom1_icon = get_post_meta(get_the_ID(), 'team_options_custom1_icon', true);?>
										<?php $custom1_title = get_post_meta(get_the_ID(), 'team_options_custom1_title', true);?>
										<?php $custom1_url = get_post_meta(get_the_ID(), 'team_options_custom1_url', true);?>
										<?php $custom2_icon = get_post_meta(get_the_ID(), 'team_options_custom2_icon', true);?>
										<?php $custom2_title = get_post_meta(get_the_ID(), 'team_options_custom2_title', true);?>
										<?php $custom2_url = get_post_meta(get_the_ID(), 'team_options_custom2_url', true);?>
										
										<?php if($position){?>
				                        	<div class="cbp-l-grid-team-position"><?php echo $position; ?></div>
				                        <?php }?>
		
										<?php if($social_media){?>		                        
										<?php if ($facebook||$twitter||$linkedin||$pinterest||$google_plus||$tumblr||$instagram||$custom1_icon||$custom2_icon) {?>
										<div class="cbp-about-post-details picons_social lpd-animated-link">
											<ul>
												<?php if ($facebook) {?><li><a href="<?php echo $facebook; ?>" class="icon facebook1"></a></li><?php }?>
												<?php if ($twitter) {?><li><a href="<?php echo $twitter; ?>" class="icon twitter1"></a></li><?php }?>
												<?php if ($linkedin) {?><li><a href="<?php echo $linkedin; ?>" class="icon linkedin1"></a></li><?php }?>
												<?php if ($pinterest) {?><li><a href="<?php echo $pinterest; ?>" class="icon pinterest1"></a></li><?php }?>
												<?php if ($google_plus) {?><li><a href="<?php echo $google_plus; ?>" class="icon google_plus1"></a></li><?php }?>
												<?php if ($tumblr) {?><li><a href="<?php echo $tumblr; ?>" class="icon tumblr1"></a></li><?php }?>
												<?php if ($instagram) {?><li><a href="<?php echo $instagram; ?>" class="icon instagram1"></a></li><?php }?>
												
												<?php if ($custom1_icon&&$custom1_url) {?><li><a href="<?php echo $custom1_url; ?>" class="icon custom-icon"<?php if ($custom1_icon) {?> style="background-image:url(<?php $custom1_icon_image = wp_get_attachment_image_src( $custom1_icon, 'full' ); echo $custom1_icon_image[0];?>);"<?php }?>></a></li><?php }?>
												<?php if ($custom2_icon&&$custom2_url) {?><li><a href="<?php echo $custom2_url; ?>" class="icon custom-icon"<?php if ($custom2_icon) {?> style="background-image:url(<?php $custom2_icon_image = wp_get_attachment_image_src( $custom2_icon, 'full' ); echo $custom2_icon_image[0];?>);"<?php }?>></a></li><?php }?>
											</ul>
										</div>
										<?php }?>
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
									    <div class="cbp-l-grid-blog-meta">
						                    <div class="cbp-l-grid-blog-date"><?php the_time('M j, Y'); ?></div>
						                    <div class="cbp-l-grid-blog-split">|</div>
						                    <a href="<?php echo get_comments_link(); ?>" class="cbp-l-grid-blog-comments"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('1 Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN)); ?></a> 
									    </div>
									<?php }?>
				                    
		                        <?php }?>
		                        
		                    </li>
					        <?php endwhile; else: ?>
						        <li class="no-post-matched"><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></li>
					        <?php endif; wp_reset_query();?>
		                </ul>
		            </div>
		
					<?php $count_posts = wp_count_posts($post_type);
					$count_posts = $count_posts->publish; ?>
					
					<?php if(!$disable_load_more){?>
						<?php if($count_posts > $items){?>
			            <div class="cbp-l-loadMore-button">
			                <a href="<?php echo get_template_directory_uri(). '/assets/cbp-plugin/ajax/vc-more.php?id='. $the_cube_t_ID .'&post_type='. $post_type.'&category_filter='. $category_filter.'&items='. $items.'&metadata='. $metadata.'&thumbnail='. $thumbnail.'&caption_type='. $caption_type.'&filtertype='. $filtertype.'&caption_align='. $caption_align; ?>" class="cbp-l-loadMore-button-link btn-warning btn"><?php _e('LOAD MORE', GETTEXT_DOMAIN) ?></a>
			            </div>
			            <?php }?>
		            <?php }?>
		
		        </div>
	
	<?php 
	$cube_widget_js = new cube_widget_class();
	
	$cube_widget_js->cube_widget_callback();	
	?>
											
	<?php return ob_get_clean();
    
    
}
add_shortcode( 'vc_cube_widget', 'vc_cube_widget_func' );

class cube_widget_class
{
    protected static $var = '';

    public static function cube_widget_callback() 
    {
    
	global $the_cube_t_ID;

	global $shortcode_atts;
	
	$animationtype = $shortcode_atts['animationtype'];
	$gaphorizontal = $shortcode_atts['gaphorizontal'];
	$gapvertical = $shortcode_atts['gapvertical'];
	$caption = $shortcode_atts['caption'];
	$displaytype = $shortcode_atts['displaytype'];
	$displaytypespeed = $shortcode_atts['displaytypespeed'];
	$no_more_works = $shortcode_atts['no_more_works'];

	
ob_start();?>

<script>
  
(function (jQuery, window, document, undefined) {

    var gridContainer = jQuery('#grid-container-<?php echo $the_cube_t_ID ?>'),
        filtersContainer = jQuery('#filters-container');

	// init cubeportfolio
    gridContainer.cubeportfolio({

        animationType: '<?php if($animationtype){ echo $animationtype; } else { echo 'flipOut'; } ?>',

        gapHorizontal: <?php if($gaphorizontal){ echo $gaphorizontal; } else { echo '0'; } ?>,

        gapVertical: <?php if($gapvertical){ echo $gapvertical; } else { echo '0'; } ?>,

        gridAdjustment: 'responsive',

        caption: '<?php if($caption){ echo $caption; } else { echo 'pushTop'; } ?>',

        displayType: '<?php if($displaytype){ echo $displaytype; } else { echo 'lazyLoading'; } ?>',

        displaytypeSpeed: <?php if($displaytypespeed){ echo $displaytypespeed; } else { echo '100'; } ?>,
        
        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxShowCounter: true,

        // singlePage popup
        singlePageDelegate: '.cbp-singlePage',
        singlePageDeeplinking: true,
        singlePageStickyNavigation: true,
        singlePageShowCounter: true,
        singlePageCallback: function (url, element) {

            // to update singlePage content use the following method: this.updateSinglePage(yourContent)
            var t = this;

            jQuery.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                timeout: 5000
            })
            .done(function(result) {
                t.updateSinglePage(result);
            })
            .fail(function() {
                t.updateSinglePage("<?php _e('Error! Please refresh the page!', GETTEXT_DOMAIN) ?>");
            });

        },

        // single page inline
        singlePageInlineDelegate: '.cbp-singlePageInline',
        singlePageInlinePosition: 'above',
        singlePageInlineShowCounter: true,
        singlePageInlineCallback: function(url, element) {
            // to update singlePage Inline content use the following method: this.updateSinglePageInline(yourContent)
        }
    });

    // add listener for filters click
    filtersContainer.on('click', '.cbp-filter-item', function (e) {

        var me = jQuery(this);

        // get cubeportfolio data and check if is still animating (reposition) the items.
        if ( !jQuery.data(gridContainer[0], 'cubeportfolio').isAnimating ) {
            me.addClass('cbp-filter-item-active').siblings().removeClass('cbp-filter-item-active');
        }

        // filter the items
        gridContainer.cubeportfolio('filter', me.data('filter'), function () {});

    });


    // add listener for inline filters click
    gridContainer.on('click', '.cbp-l-grid-projects-inlineFilters', function (e) {

        var filter = jQuery(this).data('filter');

        // get cubeportfolio data and check if is still animating (reposition) the items
        if ( !jQuery.data(gridContainer[0], 'cubeportfolio').isAnimating ) {
            filtersContainer.children().removeClass('cbp-filter-item-active').filter('[data-filter="' + filter + '"]').addClass('cbp-filter-item-active');
        }

        // filter the items
        gridContainer.cubeportfolio('filter', filter, function () {});

    });


    // activate counters
    gridContainer.cubeportfolio('showCounter', filtersContainer.find('.cbp-filter-item'));


    // add listener for load more click
    jQuery('.cbp-l-loadMore-button-link').on('click', function(e) {

        e.preventDefault();

        var clicks, me = jQuery(this), oMsg;

        if (me.hasClass('cbp-l-loadMore-button-stop')) return;

        // get the number of times the loadMore link has been clicked
        clicks = jQuery.data(this, 'numberOfClicks');
        clicks = (clicks)? ++clicks : 1;
        jQuery.data(this, 'numberOfClicks', clicks);

        // set loading status
        oMsg = me.text();
        me.text('<?php _e('LOADING...', GETTEXT_DOMAIN) ?>');

        // perform ajax request
        jQuery.ajax({
            url: me.attr('href'),
            type: 'GET',
            dataType: 'HTML'
        })
        .done( function (result) {
            var items, itemsNext;

            // find current container
            items = jQuery(result).filter( function () {
                return jQuery(this).is('div' + '.cbp-loadMore-block' + clicks);
            });

            gridContainer.cubeportfolio('appendItems', items.html(),
                 function () {
                    // put the original message back
                    me.text(oMsg);

                    // check if we have more works
                    itemsNext = jQuery(result).filter( function () {
                        return jQuery(this).is('div' + '.cbp-loadMore-block' + (clicks + 1));
                    });

                    if (itemsNext.length === 0) {
                    <?php if($no_more_works){ ?>
                        me.text('<?php echo $no_more_works; ?>');
					<?php } else { ?>
						me.text('<?php _e('NO MORE WORKS', GETTEXT_DOMAIN); ?>');
					<?php } ?>
                        me.addClass('cbp-l-loadMore-button-stop');
                    }

                 });

        })
        .fail(function() {
            // error
        });

    });

})(jQuery, window, document); 
       
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
   "name" => __("Cube Widget", GETTEXT_DOMAIN),
   "base" => "vc_cube_widget",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(

		array(
			"type" => "dropdown",
			"heading" => __("Post Type", GETTEXT_DOMAIN),
			"param_name" => "post_type",
			"value" => array(__('Blog Posts', GETTEXT_DOMAIN) => "post", __('Portfolio Posts', GETTEXT_DOMAIN) => "portfolio", __('Product Posts', GETTEXT_DOMAIN) => "product", __('Team Posts', GETTEXT_DOMAIN) => "team"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
	    array(
			"type" => "dropdown",
			"heading" => __("Columns", GETTEXT_DOMAIN),
			"param_name" => "columns",
			"value" => array('2' => "2", '3' => "3", '4' => "4", '6' => "6"),
			"description" => __("Select number of columns.", GETTEXT_DOMAIN)
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Caption Type", GETTEXT_DOMAIN),
			"param_name" => "caption_type",
			"value" => array(__('more info/view large', GETTEXT_DOMAIN) => "more_view", __('view post', GETTEXT_DOMAIN) => "view_post", __('title/description', GETTEXT_DOMAIN) => "title_desc", __('title/description, lightbox', GETTEXT_DOMAIN) => "title_desc_lightbox"),
			"description" => __("Select caption type.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Caption Align", GETTEXT_DOMAIN),
			"param_name" => "caption_align",
			"value" => array(__('center', GETTEXT_DOMAIN) => "center", __('left', GETTEXT_DOMAIN) => "left"),
			"description" => __("Select caption align.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Thumbnail Style", GETTEXT_DOMAIN),
			"param_name" => "thumbnail",
			"value" => array(__('Landscape', GETTEXT_DOMAIN) => "landscape", __('Portrait', GETTEXT_DOMAIN) => "portrait", __('Square', GETTEXT_DOMAIN) => "square"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Border Radius", GETTEXT_DOMAIN),
			"param_name" => "border_radius",
			"value" => array(__('None', GETTEXT_DOMAIN) => "", '50%' => "border-radius-50"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Metadate", GETTEXT_DOMAIN),
	      "param_name" => "metadata",
	      "description" => __("Check to hide metadata of a post.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Social Icons", GETTEXT_DOMAIN),
	      "param_name" => "social_media",
	      "description" => __("Check to enable social media icons.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "post_type", 'value' => 'team')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Items", GETTEXT_DOMAIN),
			 "param_name" => "items",
			 "value" => '',
			 "description" => __("The number of items to load when it first loads the page.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Filter Type", GETTEXT_DOMAIN),
			"param_name" => "filtertype",
			"value" => array(__('none', GETTEXT_DOMAIN) => "none", __('button', GETTEXT_DOMAIN) => "button", __('dropdown', GETTEXT_DOMAIN) => "dropdown", __('alignLeft', GETTEXT_DOMAIN) => "alignLeft", __('alignCenter', GETTEXT_DOMAIN) => "alignCenter", __('alignRight', GETTEXT_DOMAIN) => "alignRight", __('list', GETTEXT_DOMAIN) => "list"),
			"description" => __("Select filter type.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Category Filter", GETTEXT_DOMAIN),
			 "param_name" => "category_filter",
			 "value" => '',
			 "description" => __("Enter categories [slugs separated by commas] you would like to display, value for example 'cat1,cat2,cat3'.", GETTEXT_DOMAIN)
		),
	    array(
			"type" => "dropdown",
			"heading" => __("Animation Type", GETTEXT_DOMAIN),
			"param_name" => "animationtype",
			"value" => array('fadeOut' => "fadeOut", 'quicksand' => "quicksand", 'boxShadow' => "boxShadow", 'bounceLeft' => "bounceLeft", 'bounceTop' => "bounceTop", 'bounceBottom' => "bounceBottom", 'moveLeft' => "moveLeft", 'slideLeft' => "slideLeft", 'fadeOutTop' => "fadeOutTop", 'sequentially' => "sequentially", 'skew' => "skew", 'slideDelay' => "slideDelay", '3d' => "3d", 'Flip' => "Flip", 'rotateSides' => "rotateSides", 'flipOutDelay' => "flipOutDelay", 'flipOut' => "flipOut", 'unfold' => "unfold", 'foldLeft' => "foldLeft", 'scaleSides' => "scaleSides", 'scaleDown' => "scaleDown", 'frontRow' => "frontRow", 'flipBottom' => "flipBottom", 'rotateRoom' => "rotateRoom"),
			"description" => __("A description for the field.", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Horizontal Gap", GETTEXT_DOMAIN),
			 "param_name" => "gaphorizontal",
			 "value" => '',
			 "description" => __("Horizontal gap between items, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Vertical Gap", GETTEXT_DOMAIN),
			 "param_name" => "gapvertical",
			 "value" => '',
			 "description" => __("Vertical gap between items, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN)
		),
	    array(
			"type" => "dropdown",
			"heading" => __("Caption", GETTEXT_DOMAIN),
			"param_name" => "caption",
			"value" => array('pushTop' => "pushTop", 'pushDown' => "pushDown", 'revealBottom' => "revealBottom", 'revealTop' => "revealTop", 'moveRight' => "moveRight", 'revealLeft' => "revealLeft", 'overlayBottomPush' => "overlayBottomPush", 'overlayBottomReveal' => "overlayBottomReveal", 'overlayBottomAlong' => "overlayBottomAlong", 'overlayRightAlong' => "overlayRightAlong", 'minimal' => "minimal", 'fadeIn' => "fadeIn", 'zoom' => "zoom", 'none' => ""),
			"description" => __("The overlay that is shown when you put the mouse over an item. NOTE: If you don't want to have captions just select 'none'.", GETTEXT_DOMAIN)
	    ),
	    array(
			"type" => "dropdown",
			"heading" => __("Display Type", GETTEXT_DOMAIN),
			"param_name" => "displaytype",
			"value" => array('default' => "default", 'fadeIn' => "fadeIn", 'lazyLoading' => "lazyLoading", 'fadeInToTop' => "fadeInToTop", 'sequentially' => "sequentially", 'bottomToTop' => "bottomToTop"),
			"description" => __("The plugin will display his content based on the following values.
- default (the content will be displayed as soon as possible)
- fadeIn (the content will be displayed with a fadeIn effect)
- lazyLoading (the plugin will fully preload the images before displaying the items with a fadeIn effect)
- fadeInToTop - fadeInToTop (the plugin will fully preload the images before displaying the items with a fadeIn effect from bottom to top)
- sequentially (the plugin will fully preload the images before displaying the items with a sequentially effect)
- bottomToTop (the plugin will fully preload the images before displaying the items with an animation from bottom to top).", GETTEXT_DOMAIN)
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Display Speed", GETTEXT_DOMAIN),
			 "param_name" => "displaytypespeed",
			 "value" => "",
			 "description" => __("Only integers, values in ms (ex: 200, 300, 500).", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("'no more works' Button", GETTEXT_DOMAIN),
			 "param_name" => "no_more_works",
			 "value" => "",
			 "description" => __("The 'no more works' word so you can replace it to another word.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Load More Button", GETTEXT_DOMAIN),
	      "param_name" => "disable_load_more",
	      "description" => __("Check to hide load more button.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
   )
));


?>