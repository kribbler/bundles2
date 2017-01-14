<div class="container">
<div class="page-content">
<div class="row-fluid">
	&copy; 2015 Bob Landstrom
</div>
</div>
</div>

<?php do_action('after_page_wrapper'); ?>

	<?php
		/* Always have wp_footer() just before the closing </body>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to reference JavaScript files.
		 */

		wp_footer();
	?>
</body>


</html>