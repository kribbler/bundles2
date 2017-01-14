<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->

		
	</div><!-- #page -->

	<?php wp_footer(); ?>
<div class="yellow-footer"><div class="yellow-footer-inner"><div id="left" class="yellow-footer-inner">Start slashing your power bills by up to 100%<br />GET A FREE NO OBLIGATION QUOTE TODAY!</div><div id="right" class="yellow-footer-inner"><a href="http://www.nzsolarakl.co.nz/get-a-free-quote/"><img src="http://www.nzsolarakl.co.nz/wp-content/uploads/freequote1.png"></a></div></div></div>
<div style="clear: both;">&nbsp;</div>
<div style="padding: 25px; background-color: rgb(21, 50, 102); width: 100%; height: auto; overflow: auto;"><div style="width: 90%; max-width: 1170px; margin-left: auto; margin-right: auto;"><?php get_sidebar( 'main' ); ?></div>
<div style="clear: both;">&nbsp;</div>
<div style="float: left; margin-top: -40px;"><?php wp_nav_menu( array( 'theme_location' => 'foot', 'menu_class' => 'foot-menu' ) ); ?></div>
<div class="site-info">
				<?php do_action( 'twentythirteen_credits' ); ?>
				Website designed and developed by <a href="http://www.studioeleven.co.nz" target="_blank"><img src="http://www.nzsolarakl.co.nz/wp-content/uploads/signature.png" style="margin-bottom:4px"></a>
			</div></div>

</body>
</html>