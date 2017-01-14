<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    
    /* Blog Options
    ================================================== */
    $filter_change_animation = get_option_tree('filter_change_animation',$theme_options);  
    $filter_change_speed = get_option_tree('filter-change-speed',$theme_options);  
    $filter_change_rotate = get_option_tree('filter-change-rotate',$theme_options);  
    $filter_change_scale = get_option_tree('filter-change-scale',$theme_options);  
    $delay = get_option_tree('delay',$theme_options);  
    $padding_horizontal = get_option_tree('padding-horizontal',$theme_options);  
    $padding_vertical = get_option_tree('padding-vertical',$theme_options);  
    $layout_array = get_option_tree('layout-array',$theme_options);
    $blog_left_sidebar = get_option_tree('blog_left_sidebar',$theme_options);  
    
      
}
?>

<?php get_header(); ?>

		<?php get_template_part('includes/heading' ) ?>
		<div id="main" class="page-title-template <?php if ($blog_left_sidebar){?>left-sidebar-template<?php }?>">
			<div class="container">
				<div class="row-fluid">
					<div class="span9 page-content">         
          
<div id="megafolio">					

<div class="container">

		<!-- The GRID System -->
		<div class="megafolio-container noborder norounded light-bg-entries">

			
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?> 

			<?php get_template_part('includes/blog-post' ) ?>

            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN); ?></p>
            <?php endif; wp_reset_query();?>
            
		</div>
</div>


	<!--
##############################
 - ACTIVATE THE BANNER HERE -
##############################
-->
<script type="text/javascript">


	jQuery(document).ready(function() {

		var api=jQuery('.megafolio-container').megafoliopro(
			{
				filterChangeAnimation:"<?php if ($filter_change_animation) {?><?php echo $filter_change_animation;?><?php }else{?>scale<?php }?>",			// fade, rotate, scale, rotatescale, pagetop, pagebottom,pagemiddle
				filterChangeSpeed:<?php if ($filter_change_speed) {?><?php echo $filter_change_speed;?><?php }else{?>400<?php }?>,					// Speed of Transition
				filterChangeRotate:<?php if ($filter_change_rotate) {?><?php echo $filter_change_rotate;?><?php }else{?>99<?php }?>,					// If you ue scalerotate or rotate you can set the rotation (99 = random !!)
				filterChangeScale:<?php if ($filter_change_scale) {?><?php echo $filter_change_scale;?><?php }else{?>0.6<?php }?>,					// Scale Animation Endparameter
				delay:<?php if ($delay) {?><?php echo $delay;?><?php }else{?>20<?php }?>,
				defaultWidth:980,
				paddingHorizontal:<?php if ($padding_horizontal) {?><?php echo $padding_horizontal;?><?php }else{?>15<?php }?>,
				paddingVertical:<?php if ($padding_vertical) {?><?php echo $padding_vertical;?><?php }else{?>15<?php }?>,
				layoutarray:[<?php if ($layout_array) {?><?php echo $layout_array;?><?php }else{?>3<?php }?>]		// Defines the Layout Types which can be used in the Gallery. 2-9 or "random". You can define more than one, like {5,2,6,4} where the first items will be orderd in layout 5, the next comming items in layout 2, the next comming items in layout 6 etc... You can use also simple {9} then all item ordered in Layout 9 type.
			});

	});

</script>

</div>
	                    <div class="blog-pagination">
							<?php previous_posts_link(__('&larr; Newer Entries', GETTEXT_DOMAIN), 0) ?>
							<?php next_posts_link(__('Older Entries &rarr;', GETTEXT_DOMAIN), 0); ?>
	                    </div>
					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>

<?php get_footer(); ?>