<!--footer-->
<footer id="footer">
    <div class="container">
        <div class="row">
			<?php
			$footer_cols = get_option('afl_footer') + 1;
			$span_num = 12 / $footer_cols;
			for( $i = 0 ; $i < $footer_cols ; $i++ ){
				$n = $i + 1;
				$sidebar_name = 'footer-widget-'.$n;
			?>
            	<div class="span<?php echo "{$span_num}"; ?>"><?php dynamic_sidebar($sidebar_name); ?></div>
			<?php } ?>
        </div>
    </div>
</footer>

<!--footer menu-->
<section id="footer-menu">
    <div class="container">
        <div class="row">
            <div class="span8 hidden-phone">
				<?php if(has_nav_menu('footer')) {
					wp_nav_menu(array( 'theme_location' => 'footer', 'container' =>'', 'container_class' => '', 'menu_class' => 'footer-menu'));
				} ?>
            </div>
            <p class="span4 pull-right"><span class="pull-right"><?php echo get_option('afl_footer_copyright'); ?></span></p>

		<div style="margin-left:35px;"><a href="http://www.bbb.org/chattanooga/business-reviews/signs/bill-ortwein-signs-in-chattanooga-tn-40032859#sealclick" title="Click for the Business Review of Bill Ortwein Signs, Inc., a Signs in Chattanooga TN"><img src="http://seal-chattanooga.bbb.org/seals/blue-seal-96-50-billortweinsignsinc-40032859.png" class=" centerimg" border="0" alt="Click for the BBB Business Review of this Signs in Chattanooga TN" style="border: 0px currentColor; display:inline; margin:15px" /></a>  <img src="/wp-content/uploads/2014/07/isalogobw.jpg" class=" centerimg" border="0" width="100" style=" margin:15px; display:inline;" />  <img src="/wp-content/uploads/2014/07/mssalogobw.jpg" class=" centerimg" border="0" width="100" style="display:inline; margin: 15px" /></div>
        </div>
    </div>
</section>
<?php if ($code=get_option('afl_counter_code')){?>
<?php print $code ?>
<?php } ?>

<?php

/* Always have wp_footer() just before the closing </body>

	 * tag of your theme, or you will break many plugins, which

	 * generally use this hook to reference JavaScript files.

	 */



wp_footer();

?>

<!-- Google Analytics Script -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45154219-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1003923076;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1003923076/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


</body>
</html>