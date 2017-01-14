<?php get_header();

$blog_sidebar=$tax_category_sidebar=$tax_post_tag_sidebar="";

if(is_home()){$blog_sidebar= ot_get_option('blog-sidebar');}

if(is_category()||is_tag()){
$tax = $wp_query->get_queried_object();
$tax_id = $tax->term_id;

$category_term_meta = get_option( "category_$tax_id" );
$post_tag_term_meta = get_option( "post_tag_$tax_id" );

}
if(is_category()){
	if($category_term_meta){
		$tax_category_sidebar = $category_term_meta['custom_term_meta2'];
	}
}
if(is_tag()){
	if($post_tag_term_meta){
		$tax_post_tag_sidebar = $post_tag_term_meta['custom_term_meta2'];
	}
}
?>

<?php get_template_part('includes/title-breadcrumb' ) ?>
<div id="main" class="inner-page<?php if ($blog_sidebar=='left'||$tax_category_sidebar=='left'||$tax_post_tag_sidebar=='left'){?> left-sidebar-template<?php }?>">
	<div class="container">
		<div class="row">
			<div class="col-md-9 page-content lpd-sidebar-page">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
				
				<?php get_template_part('includes/index-post' ) ?>
				
				<?php endwhile; else: ?>
				
				<p><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN); ?></p>
				
				<?php endif; wp_reset_query();?>
				
				<?php if (lpd_show_posts_nav()) : ?>
				<div class="blog-pagination">
					<?php previous_posts_link(__('&larr; Newer Entries', GETTEXT_DOMAIN), 0) ?>
					<?php next_posts_link(__('Older Entries &rarr;', GETTEXT_DOMAIN), 0); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>