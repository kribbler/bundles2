<?php get_header();?>
<?php get_sidebar();?>

<div class="innerContent">
<!-- ************************************************************* -->
<?php is_tag(); ?>
<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_category()) { ?>
    <h2 class="pagetitle">Category : <?php single_cat_title(); ?></h2>
    <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2 class="pagetitle">Author Archive</h2>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle">Blog Archives</h2>
    <?php } ?>
    <?php //endif; ?>


<!-- ************************************************************* -->
<?php while (have_posts()) : the_post();
		//include (TEMPLATEPATH . "/inner_content.php");?>
        
        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		
		<!-- ************************************************ -->
		
			<div class="story">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<p class="storyAuthor">by <span><?php the_author(); ?></span> &nbsp;|&nbsp; <?php the_time('j.m.Y'); ?> &nbsp;|&nbsp; <?php comments_popup_link(__('0 Comments'), __('1 Comment'), __('% Comments')); ?> <?php edit_post_link('Edit','&nbsp;| &nbsp;'); ?></p>
				
				<div class="storyContent">
					<?php the_content('Read More...'); ?>
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
        
        
<?php else: 

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();
		
 endif; ?>
<!-- ************************************************************* -->
</div><!-- close innerContent -->
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>