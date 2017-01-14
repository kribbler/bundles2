<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
 
<div id="secondary-1" class="widget-area" role="complementary" style="float:left;">
    <?php 	// A primary sidebar for widgets, just because.
        if ( is_active_sidebar( 'jigoshop-widget-area' ) ) : ?>
                    <?php dynamic_sidebar( 'jigoshop-widget-area' ); ?>
     <?php endif; ?>                   
</div><!-- #secondary --> 