<?php
/**
 * The template for displaying single calendar entries
 *
 *
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

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
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
								<h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-content">
									<?php caldescript(get_the_ID())?>
									<?php the_content(); ?>
									<div class="socialcontent">
										<?php netstudio_get_social(); ?>
									</div>
								</div><!-- .entry-content -->
							</div><!-- #post-## -->

							<?php if (get_option('nets_commcal')  == 'true') {?>
							<?php comments_template( '', true ); ?>
							<?php } ?>

							<?php endwhile; ?>

						</div><!-- #content -->
					</div><!-- #container -->

					<?php if (get_option('nets_calside') == 'normal sidebar') { 
						get_sidebar();
						} else {
						get_sidebar( 'calendar' );
						} ?>
					<?php get_footer(); ?>
