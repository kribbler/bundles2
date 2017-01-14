<?php

function vc_team_widget_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
   
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
	'order' => '',
	'orderby' => '',
	'social_media' => '',
	
   ), $atts ) );
   
   if($items){
	   $posts_per_page='&posts_per_page='.$items.'';
   }else{
	   $posts_per_page='&posts_per_page=-1';
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
		
		global $the_team_widget_ID;
		
		$the_team_widget_ID = rand();
	
	} 
   
   ob_start();?>
   
   <div class="lpd_team_widget">
   <div class="row">
   
   <?php if ( $carousel ) { ?><div class="col-md-12 owl-carousel-<?php echo $the_team_widget_ID;?>"><?php }?>
	   
		<?php $query = new WP_Query();?>
		<?php $query->query('post_type=team'.$posts_per_page.''.$cat_filter.'&orderby='.$orderby.'&order='.$order.'');?>
			
        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
		
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
		
		<?php if ( !$carousel ) { ?><div class="col-md-<?php echo $columns ?>"><?php }?>
			<div class="team-widget-item">
				
		        <?php if(has_post_thumbnail()) {?>
					<a href="<?php the_permalink(); ?>" class="team-widget-thumbnail">
						<img alt="<?php the_title(); ?>" class="img-responsive" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'cubeportfolio' ); echo $image[0];?>"/>
						<?php if($position){?>
                        	<div class="member-position"><span class="wrap"><span><?php echo $position; ?></span></span></div>
                        <?php }?>
					</a>
				<?php }else{?>
			        <a href="<?php the_permalink(); ?>" class="effect-thumb">
			        	<img class="img-responsive" alt="<?php the_title(); ?>" src="<?php echo THEME_ASSETS; ?>img/no-image.png"/>
						<?php if($position){?>
                        	<div class="member-position"><span><?php echo $position; ?></span></div>
                        <?php }?>
					</a>
		        <?php }?>
		       <div class="team-widget-content dark-bg">
					<h4 class="title lpd-animated-link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="deco-sep-line-50"></div>
						<div class="column">
							<div class="post_content">
								<p><?php echo lpd_excerpt(15)?></p>
							</div>
						</div>
					
					<?php if($social_media){?>		                        
						<?php if ($facebook||$twitter||$linkedin||$pinterest||$google_plus||$tumblr||$instagram||$custom1_icon||$custom2_icon) {?>
						<div class="team-widget-social-details picons_social lpd-animated-link">
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
		        
					
		       </div>				       

			</div>
		<?php if ( !$carousel ) { ?></div><?php }?>
		
		<?php endwhile; endif; wp_reset_query();?>
		
	<?php if ( $carousel ) { ?></div><?php }?>
	   
	</div>
	</div>
	
	<?php
	if ( $carousel ) { 
		$counter_js = new team_widget_class();
		
		$counter_js->team_widget_callback();
	}	
	?>
   
   <?php return ob_get_clean();

}
add_shortcode( 'vc_team_widget', 'vc_team_widget_func' );

class team_widget_class
{
    protected static $var = '';

    public static function team_widget_callback(){
    
	global $the_team_widget_ID;
	
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
              jQuery('.owl-carousel-<?php echo $the_team_widget_ID;?>').owlCarousel({
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
   "name" => __("Team Widget", GETTEXT_DOMAIN),
   "base" => "vc_team_widget",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
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
    ),
	    array(
	      "type" => 'checkbox',
	      "heading" => __("Social Icons", GETTEXT_DOMAIN),
	      "param_name" => "social_media",
	      "description" => __("Check to enable social media icons.", GETTEXT_DOMAIN),
	      "value" => Array(__("enable", GETTEXT_DOMAIN) => 'enable'),
	      "dependency" => Array('element' => "post_type", 'value' => 'team')
	    ),
   )
));

?>