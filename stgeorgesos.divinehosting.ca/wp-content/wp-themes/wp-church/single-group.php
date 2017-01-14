<?php
/**
 * The template for displaying single group entries
 *
 *
 * @package Netstudio
 * @subpackage One point Oh
 * @since Netstudio10
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
									<?php the_content(); ?>
									<?php netstudio_get_social(); ?>
								</div><!-- .entry-content -->
							</div><!-- #post-## -->
							<?php if (get_option('nets_commgroup')  == 'true') {?>
							<?php comments_template( '', true ); ?>
							<?php } ?>
							<?php endwhile; ?>
						</div><!-- #content -->
					</div><!-- #container -->
					<?php get_sidebar(); ?>
					<?php get_footer(); ?>
