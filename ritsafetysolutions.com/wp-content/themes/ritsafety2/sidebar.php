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
 
<div id="secondary" class="widget-area" role="complementary">
    <?php 	// A primary sidebar for widgets, just because.
        if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
                    <?php dynamic_sidebar( 'primary-widget-area' ); ?>
     <?php endif; ?>
                  
</div><!-- #secondary --> 