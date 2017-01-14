<?php
/*
 * Template Name: Home Page
 */

get_header(); ?>



	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">



			<?php /* The loop */ ?>

			<?php while ( have_posts() ) : the_post(); ?>



				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					



					<div class="entry-content <?php if (is_front_page()){echo 'entry-content-home';}?>">

						<?php the_content(); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

					</div><!-- .entry-content -->



					

				</article><!-- #post -->



				

			<?php endwhile; ?>



		</div><!-- #content -->

	</div><!-- #primary -->



<?php get_sidebar(); ?>

<?php get_footer(); ?>
