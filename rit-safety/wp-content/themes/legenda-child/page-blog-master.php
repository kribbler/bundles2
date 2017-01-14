<?php
/*
Template Name: Blog Master Page
*/

	get_header();
?>

<?php 
	extract(etheme_get_page_sidebar());
?>


<div class="container">
	<?php if ($page_heading != 'disable' && ($page_slider == 'no_slider' || $page_slider == '')): ?>
		<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
			<div class="container">
				<div class="row-fluid">
					<div class="span12 a-center">
						<h1 class="title"><span><?php the_title(); ?></span></h1>
						<?php etheme_breadcrumbs(); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif ?>


	<?php if(have_posts()): while(have_posts()) : the_post(); ?>
						
		<?php the_content(); ?>

		<div class="post-navigation">
			<?php wp_link_pages(); ?>
		</div>

	<?php endwhile; endif;?>

</div>
<?php
	get_footer();
?>