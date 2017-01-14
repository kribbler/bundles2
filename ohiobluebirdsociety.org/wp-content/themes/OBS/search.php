<?php get_header();?>
<?php get_sidebar();?>

<div class="innerContent">
<!-- ************************************************************* -->
<?php if (have_posts()) : ?> 
		<h2 class="pagetitle">Search Results for &ldquo;<?php echo $_GET['s'];?>&rdquo;</h2>
        
		<?php while (have_posts()) : the_post(); ?>
    
        	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		
		<!-- ************************************************ -->
		
			<div class="story">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<p class="storyAuthor">by <span><?php the_author(); ?></span> &nbsp;|&nbsp; <?php the_time('j.m.Y'); ?> &nbsp;|&nbsp; <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?> <?php edit_post_link('Edit','&nbsp;| &nbsp;'); ?></p>
				
				<div class="storyContent">
					<?php the_excerpt(); ?>
					<div style="clear:both;"></div>
				</div>
                
				<p class="storyCategory">Posted under&nbsp;: <?php the_category(',') ?></p>
				<p class="storyTags"><?php the_tags('Tags : ', ', ', '<br />'); ?></p>
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

        <h2 class="error">No posts found. Try a different search?</h2>
        <?php get_search_form(); ?>
    
<?php endif; ?>

<!-- ************************************************************* -->
</div><!-- close innerContent -->
                    
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>