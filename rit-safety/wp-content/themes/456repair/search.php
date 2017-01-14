<?php get_header(); ?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-content lpd-search-template">
				<?php if (have_posts()){?>
				<p class="not-happy"><?php _e('Not happy with the results below please do another search.', GETTEXT_DOMAIN) ?></p>
                <div class="lpd-search-template-form">
	                <div class="row">
		                <form role="search" method="get" class="form-inline" action="<?php echo site_url(); ?>">
		                    <div class="page-search">
		                        <div class="col-sm-5"><input id="s" class="search_input form-control" type="text" name="s" value="<?php the_search_query() ?>"/>
		                        <input class="btn btn-primary" id="searchsubmit" type="submit" value="<?php _e('Search', GETTEXT_DOMAIN) ?>"/></div>
		                    </div>
		                </form>
	                </div>
                </div>
                <?php }?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('includes/search-post') ?>
                <?php endwhile; ?>
				<div class="search-pagination">
					<?php previous_posts_link(__('&larr; Newer Entries', GETTEXT_DOMAIN), 0) ?>
					<?php next_posts_link(__('Older Entries &rarr;', GETTEXT_DOMAIN), 0); ?>
				</div>
                <?php else: ?>
                <h4><?php _e('Nothing Found', GETTEXT_DOMAIN) ?></h4>
                <p class="not-happy"><?php _e('Sorry, no posts matched your criteria, please try again with some different keywords.', GETTEXT_DOMAIN) ?></p>
                <div class="lpd-search-template-form">
	                <div class="row">
		                <form role="search" method="get" class="form-inline" action="<?php echo site_url(); ?>">
		                    <div class="page-search">
		                        <div class="col-sm-5"><input id="s" class="search_input form-control" type="text" name="s" value="<?php the_search_query() ?>"/>
		                        <input class="btn btn-primary" id="searchsubmit" type="submit" value="<?php _e('Search', GETTEXT_DOMAIN) ?>"/></div>
		                    </div>
		                </form>
	                </div>
                </div>
                <hr />
                <div class="row">
	                <div class="col-sm-3">
		                <h5><?php _e('Blog Posts', GETTEXT_DOMAIN) ?></h5>
	                    <ul>
	                    	<?php $query = new WP_Query();?>
	                    	<?php $query->query('ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
	                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
	                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	                        <?php endwhile; endif; ?> 
	                        <?php wp_reset_query(); ?>
	                    </ul>
	                </div>
	                <div class="col-sm-3">
		                <h5><?php _e('Available Pages', GETTEXT_DOMAIN) ?></h5>
                        <ul>
                            <?php wp_list_pages('title_li=&posts_per_page=-1'); ?>
                        </ul>
	                </div>
	                <?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
		                <?php $query = new WP_Query();?>
		                <?php $products = $query->query('post_type=product&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
		                <?php if($products){?>
		                <div class="col-sm-3">
			                <h5><?php _e('Available Products', GETTEXT_DOMAIN) ?></h5>
		                    <ul>
		                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
		                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		                        <?php endwhile; endif; ?> 
		                        <?php wp_reset_query(); ?>
		                    </ul>
		                </div>
		                <?php }?>
	                <?php }?>
	                <?php $query = new WP_Query();?>
                    <?php $portfolio = $query->query('post_type=portfolio&ignore_sticky_posts=1&post_status=publish&posts_per_page=-1');?>
		        	<?php if($portfolio){?>
	                <div class="col-sm-3">
		                <h5><?php _e('Portfolio Posts', GETTEXT_DOMAIN) ?></h5>
	                    <ul>
	                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
	                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	                        <?php endwhile; endif; ?> 
	                        <?php wp_reset_query(); ?>
	                    </ul>
	                </div>
	                <?php }?>
                </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>