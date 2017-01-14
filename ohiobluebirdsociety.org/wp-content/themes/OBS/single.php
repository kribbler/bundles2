<?php get_header();?>
<?php get_sidebar();?>

<div class="innerContent">
<!-- ************************************************************* -->
<?php
if (have_posts()) :

	while (have_posts()) : the_post();
	
		//include (TEMPLATEPATH . "/inner_content.php"); ?>
        
		
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		
		<!-- ************************************************ -->
		
			<div class="story">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<p class="storyAuthor">by <span><?php the_author(); ?></span> &nbsp;|&nbsp; <?php the_time('j.m.Y'); ?> &nbsp;|&nbsp; <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?> <?php edit_post_link('Edit','&nbsp;| &nbsp;'); ?></p>
				
				<div class="storyContent">
					<?php the_content(); ?>
					<div style="clear:both;"></div>
				</div>
                
				<p class="storyCategory">Posted under&nbsp;: <?php the_category(',') ?></p>
				<p class="storyTags"><?php the_tags('Tags : ', ', ', '<br />'); ?></p>
                
                <p>
                <?php if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open ?>
					You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

				<?php } elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

				<?php } elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.

				<?php } elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.

				<?php } edit_post_link('Edit this entry','','.'); ?>
                </p>
                <div class="comment_template"><?php comments_template(); ?></div>
                
			</div><!-- close story -->
			
		<!-- ************************************************ -->
		
		</div><!-- close postid-->
        
        
	<?php endwhile; else: ?>

	<p class="error"><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    
<?php endif; ?>
            
<!-- ************************************************************* -->
</div><!-- close innerContent -->
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>