<?php
/**
 * Template Name: Full width page No Title
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


    <div class="container">

        <div class="row">

            <section id="page-sidebar" class="alignleft span9 galleries">

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

            <section id="page-sidebar" class="alignleft oimages">
			<div><a href="/lifecycle-maintenance-protection/"><img class="aligncenter size-full wp-image-1516" src="/wp-content/uploads/2011/08/intellocare_231x133.jpg" alt="" width="231" /></a><a href="/complete-branding/"><img class="aligncenter size-full wp-image-1516" src="/wp-content/uploads/2011/08/intellobrand_231x133.jpg" alt="" width="231" /></a><a href="/branding-implementation/"><img class="aligncenter size-full wp-image-1510" src="/wp-content/uploads/2011/08/intellosure_231x133.jpg" alt="" width="231" /></a><a href="/brand-funding-leverage/"><img class="aligncenter size-full wp-image-1514" src="/wp-content/uploads/2011/08/intellofund_231x133.jpg" alt="" width="231" /></a></div>
	    </section>

	</div>
    </div>

</section>

<?php get_footer(); ?>