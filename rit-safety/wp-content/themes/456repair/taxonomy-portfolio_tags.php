<?php 

$columns = '4';
$items = '';

$animationtype = 'fadeOut';  //'fadeOut','quicksand','boxShadow','bounceLeft','bounceTop','bounceBottom','moveLeft','slideLeft','fadeOutTop','sequentially','skew','slideDelay','3d','rotateSides','flipOutDelay','flipOut','unfold','foldLeft','scaleDown','scaleSides','frontRow','flipBottom','rotateRoom'

$gaphorizontal = '5';
$gapvertical = '5';
$caption = 'revealBottom'; //'pushTop','pushDown','revealBottom','revealTop','moveRight','moveLeft','overlayBottomPush','overlayBottomReveal','overlayBottomAlong','overlayRightAlong','minimal','fadeIn','zoom',''
$displaytype = "default"; //'default','fadeIn','lazyLoading','fadeInToTop','sequentially','bottomToTop'
$displaytypespeed = '1000';
$no_more_works = "";

$metadata = '';
$thumbnail = 'square'; //'landscape','portrait','square'
$caption_type = 'view_post'; //'more_view','view_post','title_desc','title_desc_lightbox'
$caption_align = 'center'; //'center','left'

$the_cube_t_ID = get_the_ID();

if(!$items){
	$items='9999';
}

$taxo_slug = get_queried_object()->slug;

if(is_tax("portfolio_tags")){
	$queried_object = get_queried_object();
	$tax_id = $queried_object->term_id;
	$portfolio_tags_term_meta = get_option( "portfolio_tags_$tax_id" );
	$portfolio_tags_sidebar = $portfolio_tags_term_meta['custom_term_meta2'];
}

get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page<?php if ($portfolio_tags_sidebar=='left'){?> left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			
			<?php if ($portfolio_tags_sidebar=='none') {?>
			<div class="col-md-12 page-content">
			<?php } else{?>
			<div class="col-md-9 lpd-sidebar-page  page-content">
			<?php }?>
                
		        <div class="lpd-cbp-wrapper">
		
		            <div id="grid-container-<?php echo $the_cube_t_ID ?>" class="<?php if($caption_type=='view_post'){?>cbp-l-grid-projects <?php }?>lpd-cbp-project cbp-<?php if($columns) { echo $columns; } else{ echo '4';}?>-columns <?php if($metadata) {?> cbp-no-meta<?php }?><?php if($thumbnail=="square") {?> cbp-square<?php } else if($thumbnail=="portrait"){?> cbp-portrait<?php }?>">
		                <ul>
							<?php $query = new WP_Query();?>
						    <?php $query->query('portfolio_tags='.$taxo_slug.'&post_type=portfolio&posts_per_page='. $items .'');?>
							<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
							<?php $video_raw = get_post_meta($post->ID, 'video_post_meta', true);?>
							<?php $link = get_post_meta($post->ID, 'link_post_meta', true); ?>
							<?php $terms = get_the_terms($post->ID, 'portfolio_tags' ); //get_the_ID ?>
		                    
		                    <li class="cbp-item<?php if($terms) : foreach ($terms as $term) { echo ' lpd_'.$term->slug.''; } endif; ?>">
		                        
		                        <?php if ($caption_type=='more_view') {?>
		                        <div class="cbp-caption">
		                        <?php } else if ($caption_type=='title_desc_lightbox') {?>

                                    <?php if ($video_raw) { ?>
                                    
                                    <a href="<?php echo $video_raw;?>" class="cbp-caption cbp-lightbox" data-title="<?php the_title();?>">
                                    
                                    <?php } elseif ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {?>
                                    
                                    <a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); echo $image[0];?>" class="cbp-caption cbp-lightbox" data-title="<?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></br><?php $attachment_caption = get_post(get_post_thumbnail_id( $post->ID )); echo($attachment_caption->post_excerpt);?>">
                                    
                                    <?php }?>

		                        <?php }else{?>
			                        <?php if($link){?>
			                        	<a href="<?php echo $link;?>" class="cbp-caption">
			                        <?php } else{?>
			                        	<a href="<?php the_permalink();?>" class="cbp-caption">
			                        <?php }?>
		                        <?php }?>
		                        
		                            <div class="cbp-caption-defaultWrap">
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
			                                        <a href="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); echo $image[0];?>" class="cbp-lightbox cbp-l-caption-buttonRight btn btn-primary btn-sm" data-title="<?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></br><?php $attachment_caption = get_post(get_post_thumbnail_id( $post->ID )); echo($attachment_caption->post_excerpt);?>"><?php _e("view larger", GETTEXT_DOMAIN) ?></a>
			                                        <?php }?>
		                                        
		                                        <?php } else if($caption_type=='view_post'){?>
		                                        
							                        <?php if($link){?>
							                        	<div class="cbp-l-caption-text"><?php _e("view project", GETTEXT_DOMAIN) ?></div>
							                        <?php } else{?>
							                        	<div class="cbp-l-caption-text"><?php _e("view post", GETTEXT_DOMAIN) ?></div>
							                        <?php }?>
		                                        	
		                                        <?php } else{?>
		                                        
					                                <div class="cbp-l-caption-title"><?php the_title();?></div>
					                                <div class="cbp-l-caption-desc"><?php echo $attachment_title = get_the_title(get_post_thumbnail_id( $post->ID )); ?></div>
		                                        
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
								    <div class="cbp-l-grid-projects-title">
								    <?php if($link){?>
								        <a href="<?php echo $link;?>"><?php the_title();?></a>
								    <?php } else{?>
								        <a href="<?php the_permalink();?>"><?php the_title();?></a>
								    <?php }?>
								    </div>
								    <div class="cbp-l-grid-projects-desc"><?php $e='0'; if($terms) : foreach ($terms as $term) { $e++; if($e>1){echo " / ";} echo '<a class="cbp-l-grid-projects-category" title="'.$term->name.'" href="'.get_term_link($term->slug, "portfolio_tags").'">'.$term->name.'</a>'; } endif; ?></div>
		                        <?php }?>
		                        
		                    </li>
					        <?php endwhile; else: ?>
						        <li class="no-post-matched"><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN) ?></li>
					        <?php endif; ?>
		                </ul>
		            </div>
		
					<?php $count_posts = wp_count_posts("portfolio");
					$count_posts = $count_posts->publish; ?>
		
					<?php if($count_posts > $items){?>
		            <div class="cbp-l-loadMore-button">
		                <a href="<?php echo get_template_directory_uri(). '/assets/cbp-plugin/ajax/more-portfolio.php?id='. $the_cube_t_ID .'&items='. $items.'&metadata='. $metadata.'&thumbnail='. $thumbnail.'&caption_type='. $caption_type.'&taxo_slug='.$taxo_slug.'&taxo_type=portfolio_tags&caption_align='. $caption_align; ?>" class="cbp-l-loadMore-button-link btn-default btn"><?php _e('LOAD MORE', GETTEXT_DOMAIN) ?></a>
		            </div>
		            <?php }?>
		
		        </div>

			</div>
			
			<?php if ($portfolio_tags_sidebar!='none') {?>
			<?php get_sidebar(); ?>
			<?php }?>
			
		</div>
	</div>
</div>

<?php

$cube_widget_portfolio_js = new cube_widget_portfolio_class();

$cube_widget_portfolio_js->cube_widget_portfolio_callback();	
	
class cube_widget_portfolio_class
{
    protected static $var = '';

    public static function cube_widget_portfolio_callback() 
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

        gaphorizontal: <?php if($gaphorizontal){ echo $gaphorizontal; } else { echo '0'; } ?>,

        gapvertical: <?php if($gapvertical){ echo $gapvertical; } else { echo '0'; } ?>,

        gridAdjustment: 'responsive',

        caption: '<?php if($caption){ echo $caption; } else { echo 'pushTop'; } ?>',

        displaytype: '<?php if($displaytype){ echo $displaytype; } else { echo 'lazyLoading'; } ?>',

        displaytypespeed: <?php if($displaytypespeed){ echo $displaytypespeed; } else { echo '100'; } ?>,
        
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
	
?>

<?php add_action( 'wp_footer', 'lpd_install_cubeportfolio', 100);?>
        
<?php get_footer(); ?>