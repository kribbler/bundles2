<?php
/**
 * Template Name: Full width O Pages
 *
 */
get_header();
?>
<section id="container">
	<?php if(!is_home() && !is_front_page()):?>
    <!--breadcrumbs -->
	<section class="container">
    <div class="container breadcrumbs"> 
        <!--<h1><?php the_title();?></h1> -->
       <!-- <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php the_title();?></div> -->
    </div>
	</section>
	<?php endif; ?>
	<?php the_post();
	if(get_post_meta($post->ID, 'afl_composer', true)=='on') {?>
			<?php $items = afl_get_te_data($post->ID);?>
			<?php
			print(do_shortcode(afl_to_shortcode($items)));
			?>
		<?php } else { ?>
			<div class="container">
				<!--<h2><?php the_title();?></h2>-->
				<?php the_content();?>
			</div>
	<?php } ?>
</section>
<?php get_footer(); ?>