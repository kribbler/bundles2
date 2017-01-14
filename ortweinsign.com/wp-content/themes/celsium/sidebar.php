<!--sidebar-->
<aside id="sidebar" class="alignright span3">
	<?php if ( dynamic_sidebar('primary-widget-area'));  else {?>

	<section>
    	<?php wp_list_pages('title_li=<h4>Pages</h4>' ); ?>
	</section>
	<section>
    	<h4>Archives</h4>
    	<ul class="ul-col2 clearfix">
            <?php wp_get_archives('type=monthly'); ?>
    	</ul>
	</section>
    <section>
        <ul class="ul-col2 clearfix">
    	   <?php wp_list_categories('show_count=3&title_li=<h4>Categories</h4>'); ?>
        </ul>
	</section>
	<section>
    	<?php wp_list_bookmarks('title_before=<h4>&title_after=</h4>&title_li=Blogroll'); ?>
	</section>
    <section>
    	<h4>Meta</h4>
    	<ul class="ul-col2 clearfix">
    		<?php wp_register(); ?>
    		<li><?php wp_loginout(); ?></li>
    		<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
    		<?php wp_meta(); ?>
    	</ul>
	</section>
	<section>
    	<h4>Subscribe</h4>
    	<ul class="ul-col2 clearfix">
    		<li><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a></li>
    		<li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a></li>
    	</ul>
	</section>
    <?php } ?>
</aside>