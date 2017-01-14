<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<?php

if (get_the_title() == 'New Home Builds'){?>
	<style type="text/css">
		.entry-content{
			background: url(http://www.nzsolarakl.co.nz/wp-content/uploads/bg_new_home_builds.png) right bottom no-repeat;
		}
	</style>
<?php } else if (get_the_title() == 'Commercial Solar Power'){?>
	<style type="text/css">
		.entry-content{
			background: url(http://www.nzsolarakl.co.nz/wp-content/uploads/bg_commercial.png) right bottom no-repeat;
		}
	</style>

<?php } else if (get_the_title() == 'Residential Solar Power'){?>
	<style type="text/css">
		.entry-content{
			background: url(http://www.nzsolarakl.co.nz/wp-content/uploads/bg_residential.png) right bottom no-repeat;
		}
	</style>

<?php } else if (get_the_title() == 'Meet Nigel'){?>
	<style type="text/css">
		.entry-content{
			background: url(http://www.nzsolarakl.co.nz/wp-content/uploads/meet_nigel.png) 50px bottom no-repeat;
			min-height: 800px;
		}
	</style>
<?php } ?>

<div id="underheader">	<div class="entry-content">		<?php if(function_exists(simple_breadcrumb)) {simple_breadcrumb();} ?>		<h1><?php echo get_the_title();?></h1>	</div></div>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					
				</article><!-- #post -->

				
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>