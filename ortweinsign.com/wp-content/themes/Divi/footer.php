<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}
				?>

						<p id="footer-info">
<span style="float: right; width: 33%;"> Ortwein Sign &copy;<?php echo date('Y'); ?><br />Phone: 423.867.9208 Fax: 423.867.9211<br />Website by <a href="http://heymisterdesigns.com" target="_blank">WordPress Nashville</a></span>

<span style="float:left;"><a href="http://www.bbb.org/chattanooga/business-reviews/signs/bill-ortwein-signs-in-chattanooga-tn-40032859#sealclick" title="Click for the Business Review of Bill Ortwein Signs, Inc., a Signs in Chattanooga TN"><img src="http://seal-chattanooga.bbb.org/seals/blue-seal-96-50-billortweinsignsinc-40032859.png" style="margin:5px;" alt="Click for the BBB Business Review of this Signs in Chattanooga TN" /></a></span>

<img src="/wp-content/uploads/2014/07/isalogobw.jpg" style="margin:5px;" />  
<img src="/wp-content/uploads/2014/07/mssalogobw.jpg" style="margin:5px;" />


						</p>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>