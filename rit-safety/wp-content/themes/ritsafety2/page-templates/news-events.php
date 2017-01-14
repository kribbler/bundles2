<?php
/**
 * Template Name: NEWS AND EVENTS.
  
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
 

	<div id="primary" class="site-content">
			<div id="content" role="main"> 
      		 
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?> 
			<?php endwhile; // end of the loop. ?>

			<?php          
			query_posts('cat=17showposts=-1');			 
			while ( have_posts() ) : the_post(); ?>
			<div class="news_evets">
 				<div class="title"><a style="text-decoration:none;" href="<?php the_permalink();?>"><?php the_title(); ?></a></div>
 				<div class="date">Date : <?php  the_time('d   M   Y');?></div>
				<?php the_excerpt(); ?>
             </div>
            <?php
			endwhile; 			 
			wp_reset_query();
            ?> 
			</div><!-- #content -->
		</div><!-- #container -->

<?php  get_sidebar(); ?>
<?php get_footer(); ?>