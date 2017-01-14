<?php
/**
 * The Template for displaying all single posts.
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
                                <div class="inner">
									<div class="entry-content">						
										<?php the_content(); ?>						
										<div class="socialcontent">
											<?php netstudio_get_social(); ?>
										</div>
									</div><!-- .entry-content -->
								</div>
							</div><!-- #post-## -->
							<?php //comments_template( '', true ); ?>
							<?php endwhile; // end of the loop. ?>
							<?php
							if (get_post_type()=='ministries')
                            	echo '<a href="/ministries/">&lt; Back to all ministries</a>';
							if (get_post_type()=='news')
                            	echo '<a href="/news/">&lt; Back to all news</a>';
							?>
						</div><!-- #content -->
					</div><!-- #container -->
					<?php //get_sidebar(); ?>
                                        
                                        <?php if ( is_active_sidebar( 'index-page' ) ) : ?>	
                                <div  class="home-right" role="complementary">				
				<ul class="right">	
					<?php 
					dynamic_sidebar( 'index-page' ); ?>
				</ul>
                            </div>
			<?php endif; ?>
					<?php get_footer(); ?>
