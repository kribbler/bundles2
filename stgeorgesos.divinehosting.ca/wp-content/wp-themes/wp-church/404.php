<?php
/**
 * The template for displaying the 404 page
 *
 *
 */

get_header(); ?>


<div class="lastmess">
</div>
<div class="bodymid">
	<div class="stripetop">
		<div class="stripebot">
			<div class="container">
				<div class="mapdiv"></div>
				<div class="clear"></div>
				<div id="main">
					<div class="grid8 first">	
						<div id="content" role="main">
							<h1 class="entry-title"><?php _e( 'Not Found', 'wp-church' ); ?></h1>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	

								<div class="entry-content">
									<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'wp-church' ); ?></p>
								</div>
							</div>
						</div>
					</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>