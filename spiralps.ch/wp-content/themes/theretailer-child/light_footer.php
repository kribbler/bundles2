<?php
global $theretailer_theme_options;
?>

<?php if ( (!$theretailer_theme_options['light_footer_all_site']) || ($theretailer_theme_options['light_footer_all_site'] == 0) ) { ?>

	<?php if ( is_active_sidebar( 'widgets_light_footer' ) && 1==2) : ?>
        
        <div class="gbtr_light_footer_wrapper">        
            <div class="container_12">
                <?php dynamic_sidebar('widgets_light_footer'); ?>
            </div>             
        </div>
    
    <?php else : ?>
    
        <div class="gbtr_light_footer_no_widgets" style="display:none">
            <div class="container_12">
                <div class="grid_12" style="display:none">
                    <h3><strong>Light Footer</strong> - Widgetized Area. <a href="<?php echo site_url(); ?>/wp-admin/widgets.php"><strong>Start Adding Widgets</strong></a>.</h3>
                </div>
                <div class="grid_4 d_banners">
                	<?php echo get_post_content_by_slug( 'box1-footer' ); ?>
                </div>        
                <div class="grid_4 d_banners">
                	<?php echo get_post_content_by_slug( 'box2-footer' ); ?>
                </div>        
                <div class="grid_4 d_banners">
                	<?php echo get_post_content_by_slug( 'box3-footer' ); ?>
                </div>                
            </div>
        </div>
    
    <?php endif; ?>

<?php } ?>