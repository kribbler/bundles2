<?php
/*
Template Name: FAQ Page
*/
?>

<?php get_header();?>
<?php get_sidebar();?>

<div class="innerContent">
<div class="story" style="padding-bottom:20px;"><h2>FAQ</h2></div>
<?php if (have_posts()) :	while (have_posts()) : the_post();	?>
<?php the_content(); ?>
<?php endwhile; endif; ?><br /><br />
<!-- ************************************************************* -->
<?php query_posts('category_name=faq&showposts=-1'); $cnt = 0; ?>
<?php if (have_posts()) :	while (have_posts()) : the_post();	?>		
		
    <?php $cnt++; ?>
    <div class="storyContent faq">
    <h4><?php echo $cnt; ?>. &nbsp;<a href="#faq<?php echo $cnt; ?>" rel="bookmark"><?php the_title(); ?></a></h4>
    </div>

	<?php endwhile; ?>

<?php else: ?>

<?php endif; wp_reset_query(); ?>	

<br /><br /><br />
<?php query_posts('category_name=faq&showposts=-1'); $cnt = 0; ?>
<?php if (have_posts()) :	while (have_posts()) : the_post();	?>		

		<?php $cnt++; ?>
        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">		

		<!-- ************************************************ -->
		
			<div class="story">
				<h4><a rel="bookmark" name="faq<?php echo $cnt; ?>"></a><?php the_title(); ?></h4>
				<div class="storyContent">
					<?php the_content(); ?>
					<div style="clear:both;"></div>
				</div>
			</div><!-- close story -->			

		<!-- ************************************************ -->		

		</div><!-- close postid-->
        
	<?php endwhile; ?>

	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
        <div style="clear:both;"></div>
	</div>    

<?php else: ?>

	<h2 class="error"><?php _e('Not Found.'); ?></h2>
	<p class="error">Sorry, but you are looking for something that isn't here.</p>
    <?php get_search_form(); ?>    

<?php endif; wp_reset_query(); ?>

<a href="#">Back to top</a>

<!-- ************************************************************* -->
</div><!-- close innerContent -->
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>