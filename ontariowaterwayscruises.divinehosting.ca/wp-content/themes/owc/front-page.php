<?php get_header(); ?>

<?php if (have_posts()): ?>
	<?php while(have_posts()) : the_post(); ?>
		<div class="container-fluid" id="front_block_01">
			<div id="frontpage-title1">
				<?php echo the_title();?>
			</div>
			<div class="front_banner">	
				<?php echo rwmb_meta( 'dd_banner_text' ); ?>
			</div>
		</div>


		<div class="white-wrap container page-content" id="front_block_02">
			<div class="row">
				<div class="col-lg-2">&nbsp;</div>
				<div class="col-lg-8">
					<?php the_content(); ?>
				</div>

			</div>
		</div>

		<a class="back_to_top" href="#">BACK TO TOP</a>

		<div id="front_block_03">
			<h4>EXPERIENCE THE</h4>
			<h2 id="frontpage-title2">Ontario Waterways</h2>
		</div>

		<a class="back_to_top" href="#">BACK TO TOP</a>

		<div id="front_block_04">
			<h2 id="frontpage-title3">OUR CRUISES</h2>
			<div class="container">
				<div class="row margin_bottom_40">
					<?php for($i = 1; $i <= 3; $i++){?>
					<div class="col-lg-4">
						<?php $files = rwmb_meta( 'dd_cruise_image_' . $i, 'type=file' ); 
						foreach ($files as $file) {?>
							<img src="<?php echo $file['url']; ?>" title="<?php echo rwmb_meta( 'dd_cruise_title_' . $i );?>" />	
						<?php } ?>
						<div class="cruise_title"><?php echo rwmb_meta( 'dd_cruise_title_' . $i );?></div>
						<div class="cruise_description"><?php echo rwmb_meta( 'dd_cruise_description_' . $i );?></div>
						<a class="cruise_link" href="<?php echo get_page_link( rwmb_meta( 'dd_cruise_link_' . $i ) );?>">Find Out More ></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<div id="front_block_05">
		<h2 id="frontpage-title4">CAPTAINS  NOTES</h2>
			<div class="container center_block">
				<div class="row">
					<div class="col-lg-2">&nbsp;</div>
					<div class="col-lg-8">
						<p><?php echo rwmb_meta( 'dd_captains_notes' ); ?></p>
						<p style="text-align: center;"><a href="<?php echo site_url();?>/request-a-reservation/" class="big_white_button">Request a Reservation</a></p>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php else : ?>
	<?php get_template_part('404'); ?>
<?php endif; ?>


<?php get_footer();