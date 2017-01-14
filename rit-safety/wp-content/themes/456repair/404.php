<?php get_header(); ?>

<div id="main" class="inner-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 page-content lpd-404-template">
				<div class="lpd-404-content">
					<h2 class="title-404">404</h2>
					<span class="subtitle-404"><?php _e('Page not found', GETTEXT_DOMAIN) ?></span>
					<span class="description-404"><?php _e('The page you are looking for does not exist.', GETTEXT_DOMAIN) ?></span>
					<a href="<?php echo home_url(); ?>" class="btn btn-default"><?php _e('Return to the home page', GETTEXT_DOMAIN) ?></a>
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
			</div>
		</div>
	</div>
</div>
        
<?php get_footer(); ?>