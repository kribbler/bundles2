<?php
/**
 * The template for displaying group Archive pages.
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
						<div id="content" role="main">
							<h1 class="entry-title"><?php single_cat_title(); ?></h1>
							<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>			
							<div class="groupcat">
								<div class="catclass">
									<div class="entry-content">
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('imlink'); ?></a>   
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									</div><!-- .entry-content -->
									<a href="<?php the_permalink(); ?>"><img class="over" src="<?php echo get_template_directory_uri(); ?>/images/morepic.png"></a>
								</div><!-- #post-## -->
							</div>			
							<?php endwhile; ?>
							<div class="clear"></div>
							<?php adminace_paging(); ?>
						</div><!-- #content -->
						<?php get_footer(); ?>
