<?php

function vc_widget_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'post_type' => '',
      'widget_style' => '',
      'carousel' => '',
      
   'carousel_autoheight' => '',
   'carousel_margin' => '',
   'carousel_navi' => '',
   'carousel_dots_navi' => '',
   'carousel_autoplay' => '',
   'carousel_autoplaytimeout' => '',
   'carousel_autoplayhoverpause' => '',
   'carousel_loop' => '',
   
      'columns' => '',	
      'items' => '',
      'cat_filter' => '',
      'thumbnails' => '',
      'caption' => '',
      'order' => '',
      'orderby' => ''

   ), $atts ) );
   
   
   if($post_type=="post"){
	   $post_type="post";
	   $cat_terms="category";
   }else{
	   $post_type="portfolio";
	   $cat_terms="portfolio_category";
   }
   
   if($items){
	   $posts_per_page='&posts_per_page='.$items.'';
   }else{
	   $posts_per_page='&posts_per_page=-1';
   }
   
	if($post_type=="portfolio"){
		$category_filter = '&portfolio_category='.$cat_filter;
	}else{
		$category_filter = '&category_name='.$cat_filter;
	}
	
	if ( $carousel ) {
	
		if($columns=="3"){
			$columns="4";
		}elseif($columns=="4"){
			$columns="3";
		}elseif($columns=="6"){
			$columns="2";
		}
	
		global $shortcode_atts;
		
		$shortcode_atts = array(
			'carousel_autoheight' => $carousel_autoheight,
		  'carousel_margin' => $carousel_margin,
		  'carousel_navi' => $carousel_navi,
		  'carousel_dots_navi' => $carousel_dots_navi,
		  'carousel_autoplay' => $carousel_autoplay,
		  'carousel_autoplaytimeout' => $carousel_autoplaytimeout,
		  'carousel_autoplayhoverpause' => $carousel_autoplayhoverpause,
		  'carousel_loop' => $carousel_loop,
		  'columns' => $columns,
		);
		
		lpd_owl_carousel();
		
		global $the_post_widget_ID;
		
		$the_post_widget_ID = rand();
	
	} 	
   
	ob_start();?>
	
						<div class="post-widget">
							<div class="row">
							<?php if ( $carousel ) { ?><div class="col-md-12 owl-carousel-<?php echo $the_post_widget_ID;?>"><?php }?>
	
	
						<?php $query = new WP_Query();?>
						<?php $query->query('post_type='.$post_type.''.$posts_per_page.''.$category_filter.'&orderby='.$orderby.'&order='.$order.'');?>
							
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
                        
						<?php $video = lpd_parse_video(get_post_meta(get_the_ID(), 'video_post_meta', true));?>
						<?php $link = get_post_meta(get_the_ID(), 'link_post_meta', true);?>
						
						<?php $gallery_type = get_post_meta(get_the_ID(), 'portfolio_options_select', true);?>
						<?php $terms = get_the_terms( get_the_ID(), $cat_terms ); ?>
						
						<?php if($post_type=="portfolio"){?>
							<?php $header_image = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'portfolio_header_image', true), 'cubeportfolio' ); ?>
						<?php }else{?>
							<?php $header_image = wp_get_attachment_image_src( get_post_meta(get_the_ID(), 'post_header_image', true), 'cubeportfolio' ); ?>
						<?php }?>
						
						  
	<?php if ( !$carousel ) { ?><div class="col-md-<?php echo $columns ?>"><?php }?>
		<div class="lpd-portfolio-item<?php if ( $widget_style=='2') { ?> widget_style_2<?php } else if($widget_style=='3'){?> widget_style_3<?php }?>">
		<?php if ( !$thumbnails ) { ?>
			<?php if ( $link ) { ?>
		        <?php if(has_post_thumbnail()) {?>
					<a href="<?php echo $link; ?>" class="effect-thumb">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'cubeportfolio' ); echo $image[0];?>"/>
						<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-link"></div>
					</a>
				<?php } elseif($header_image){?>
					<a href="<?php the_permalink(); ?>" class="effect-thumb">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $header_image[0];?>"/>
						<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-video"></div>
					</a>
				<?php }else{?>
			        <a href="<?php echo $link; ?>" class="effect-thumb">
			        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/no-image.png"/>
			        	<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-link"></div>
					</a>
		        <?php }?>
		    <?php } elseif ( $video ) { ?>
		        <?php if(has_post_thumbnail()) {?>
					<a href="<?php the_permalink(); ?>" class="effect-thumb">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'cubeportfolio' ); echo $image[0];?>"/>
						<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-video"></div>
					</a>
				<?php } elseif($header_image){?>
					<a href="<?php the_permalink(); ?>" class="effect-thumb">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $header_image[0];?>"/>
						<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-video"></div>
					</a>
				<?php }else{?>
			        <a href="<?php the_permalink(); ?>" class="effect-thumb">
			        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/no-image.png"/>
			        	<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-video"></div>
					</a>
		        <?php }?>
		    <?php } elseif ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>
				<a href="<?php the_permalink(); ?>" class="effect-thumb">
					<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
					<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'cubeportfolio' ); echo $image[0];?>"/>
					<?php } ?>
					<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
					<div class="mega-icon-bg"></div>
					<div class="mega-icon-photo"></div>
				</a>
			<?php } else{?>
				<?php if($header_image){?>
					<a href="<?php the_permalink(); ?>" class="effect-thumb">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo $header_image[0];?>"/>
						<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
						<div class="mega-icon-bg"></div>
						<div class="mega-icon-video"></div>
					</a>
				<?php }else{?>
		        <a href="<?php the_permalink(); ?>" class="effect-thumb">
		        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/no-image.png"/>
		        	<?php if ( $widget_style=='2'||$widget_style=='3') { ?><div class="mega-icon-border"></div><?php }?>
					<div class="mega-icon-bg"></div>
					<div class="mega-icon-photo"></div>
				</a>
				<?php }?>
		    <?php }?>
	    <?php }?>
			<div class="content<?php if ( $thumbnails ) { ?> no-thumbnail<?php }?>">
				<?php if ( $link ) { ?>
				<h4 class="title lpd-animated-link"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
				<?php }else{?>
				<h4 class="title lpd-animated-link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php }?>
				<?php if ( !$caption ) { ?>
					<div class="deco-sep-line-50"></div>
					<div class="column">
						<div class="post_content">
							<p><?php echo lpd_excerpt(15)?></p>
						</div>
					</div>
				<?php }?>
				<div class="widget-meta clearfix">
					<div class="author-data<?php if($post_type=="portfolio"){?><?php if(!$terms){?> no-cat-data<?php }?><?php }?>">
						<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="author"><?php echo get_the_author(); ?></a>
					</div>
					<?php if($post_type=="portfolio"){?>
					
						<?php if($terms){?>
						<div class="portfolio-categories">
						
							<?php $resultstr = array(); ?>
				            <?php if($terms) : foreach ($terms as $term) { ?>
				                <?php $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, $cat_terms).'">'.$term->name.'</a>'?>
				            <?php } ?>
				            <?php echo implode(", ",$resultstr); endif;?>
		            
						</div>					
						<?php }?>
					
						
					<?php }else{?>
					
						<div class="news-meta">
						
							<a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>" class="date"><?php the_time('M j, Y'); ?></a>
						
						</div>
					
					<?php }?>
				</div>		
			</div>
			<div class="clearfix"></div>
		</div>
	<?php if ( !$carousel ) { ?></div><?php }?>
	
						<?php endwhile; endif; wp_reset_query();?>
	
							<?php if ( $carousel ) { ?></div><?php }?>
							</div>
						</div>
						
	<?php
	if ( $carousel ) { 
		$counter_js = new post_widget_class();
		
		$counter_js->post_widget_callback();
	}	
	?>
						
	<?php return ob_get_clean();
    
    
}
add_shortcode( 'vc_widget', 'vc_widget_func' );


class post_widget_class
{
    protected static $var = '';

    public static function post_widget_callback(){
    
	global $the_post_widget_ID;
	
	global $shortcode_atts;
	
	$carousel_autoheight = $shortcode_atts['carousel_autoheight'];
	$carousel_margin = $shortcode_atts['carousel_margin'];
	$carousel_navi = $shortcode_atts['carousel_navi'];
	$carousel_dots_navi = $shortcode_atts['carousel_dots_navi'];
	$carousel_autoplay = $shortcode_atts['carousel_autoplay'];
	$carousel_autoplaytimeout = $shortcode_atts['carousel_autoplaytimeout'];
	$carousel_autoplayhoverpause = $shortcode_atts['carousel_autoplayhoverpause'];
	$carousel_loop = $shortcode_atts['carousel_loop'];
	$columns = $shortcode_atts['columns'];
	
		ob_start();?>
		
		<script>
		/* <![CDATA[ */
            jQuery(document).ready(function() {
              jQuery('.owl-carousel-<?php echo $the_post_widget_ID;?>').owlCarousel({
                <?php if ( $columns ) { ?>items: <?php echo $columns;?>,<?php }?>
                <?php if ( $carousel_margin ) { ?>margin: <?php echo $carousel_margin;?>,<?php }?>
                <?php if ( $carousel_autoheight ) { ?>autoHeight: true,<?php }?>
                <?php if ( $carousel_navi ) { ?>nav:true,<?php }?>
                <?php if ( !$carousel_dots_navi ) { ?>dots:false,<?php }?>
                <?php if ( $carousel_autoplay ) { ?>autoplay:true,<?php }?>
                <?php if ( $carousel_autoplaytimeout ) { ?>autoplayTimeout: <?php echo $carousel_autoplaytimeout;?>,<?php }?>
                <?php if ( $carousel_autoplayhoverpause ) { ?>autoplayHoverPause:true,<?php }?>
                <?php if ( $carousel_loop ) { ?>loop:true,<?php }?>
                navText : ['<?php _e('prev', GETTEXT_DOMAIN); ?>','<?php _e('next', GETTEXT_DOMAIN); ?>'],
			    <?php if ( $columns ) { ?>
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			        },
			        768:{
			            items:<?php echo $columns;?>,    
			        }
			    }<?php }?>
              });
            })
		/* ]]> */
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
   "name" => __("Posts Widget", GETTEXT_DOMAIN),
   "base" => "vc_widget",
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
			"value" => array(__('Blog Posts', GETTEXT_DOMAIN) => "post", __('Portfolio Posts', GETTEXT_DOMAIN) => "portfolio"),
			"description" => __("Select post type.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Widget Style", GETTEXT_DOMAIN),
			"param_name" => "widget_style",
			"value" => array(__('Style 1', GETTEXT_DOMAIN) => "1", __('Style 2', GETTEXT_DOMAIN) => "2", __('Style 3', GETTEXT_DOMAIN) => "3"),
			"description" => __("Select widget style.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Carousel", GETTEXT_DOMAIN),
	      "param_name" => "carousel",
	      "description" => __("Check, if you wish to enable carousel plugin.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Vertical Margin", GETTEXT_DOMAIN),
			 "param_name" => "carousel_margin",
			 "value" => '30',
			 "description" => __("Vertical gap between items, only integers (ex: 1, 5, 10).", GETTEXT_DOMAIN),
			 "dependency" => Array('element' => "carousel", 'value' => 'enable')
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("autoHeight", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoheight",
	      "description" => __("Enable auto height for carousel container.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Navigation", GETTEXT_DOMAIN),
	      "param_name" => "carousel_navi",
	      "description" => __("Show next/prev buttons.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Dots Navigation", GETTEXT_DOMAIN),
	      "param_name" => "carousel_dots_navi",
	      "description" => __("Show dots navigation.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Loop", GETTEXT_DOMAIN),
	      "param_name" => "carousel_loop",
	      "description" => __("Inifnity loop. Duplicate last and first items to get loop illusion.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Autoplay", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoplay",
	      "description" => __("Check, if you wish to enable autoplay function for carousel plugin.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel", 'value' => 'enable')
	    ),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("autoplayTimeout", GETTEXT_DOMAIN),
			 "param_name" => "carousel_autoplaytimeout",
			 "value" => '',
			 "description" => __("Autoplay interval timeout in (ms), only integers (ex: 1000, 5000, 10000).", GETTEXT_DOMAIN),
			 "dependency" => Array('element' => "carousel_autoplay", 'value' => 'enable')
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("autoplayHoverPause", GETTEXT_DOMAIN),
	      "param_name" => "carousel_autoplayhoverpause",
	      "description" => __("Pause on mouse hover.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "carousel_autoplay", 'value' => 'enable')
	    ),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", GETTEXT_DOMAIN),
			"param_name" => "columns",
			"value" => array(__('4 Columns', GETTEXT_DOMAIN) => "3", __('3 Columns', GETTEXT_DOMAIN) => "4", __('2 Columns', GETTEXT_DOMAIN) => "6"),
			"description" => __("Select number of columns.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Posts", GETTEXT_DOMAIN),
			 "param_name" => "items",
			 "value" => __("", GETTEXT_DOMAIN),
			 "description" => __("Enter number of post to show.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Filter", GETTEXT_DOMAIN),
			 "param_name" => "cat_filter",
			 "value" => __("", GETTEXT_DOMAIN),
			 "description" => __("Category slug separated by comma, an example: link,full.", GETTEXT_DOMAIN)
		),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Thumbnails", GETTEXT_DOMAIN),
	      "param_name" => "thumbnails",
	      "description" => __("Check, if you wish to disable thumbnails.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
	    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Caption", GETTEXT_DOMAIN),
	      "param_name" => "caption",
	      "description" => __("Check, if you wish to disable caption.", GETTEXT_DOMAIN),
	      "value" => Array(__("disable", GETTEXT_DOMAIN) => 'disable')
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