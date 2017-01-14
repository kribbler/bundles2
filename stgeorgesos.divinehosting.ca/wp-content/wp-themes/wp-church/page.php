<?php
/**
 * The template for displaying all pages.
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
                                    <div class="inner-page">
					<div class="grid8 first">	
						<div id="content" role="main">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
                                                            
								<div class="entry-content">
                                                                    
									<?php the_content(); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-church' ), 'after' => '</div>' ) ); ?>
									<?php edit_post_link( __( 'Edit', 'wp-church' ), '<span class="edit-link">', '</span>' ); ?>
								</div><!-- .entry-content -->
							</div><!-- #post-## -->
							<?php if (get_option('nets_commpage')  == 'true') {?>
							<?php comments_template( '', true ); ?>
							<?php } ?>
							<?php endwhile; ?>

						</div><!-- #content -->
					
                                        
                                        </div><!-- #container -->
                                    </div>
					<?php //get_sidebar(); ?>
                                        <?php if ( is_active_sidebar( 'index-page' ) ) : ?>	
                                <div  class="home-right" role="complementary">				
				<ul class="right" style="margin-right:20px">	
					<?php 
					dynamic_sidebar( 'index-page' ); ?>
				</ul>
                            </div>
			<?php endif; ?>
                                        
					<?php get_footer(); ?>