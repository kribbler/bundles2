<?php get_header(); ?>

<div class="white-wrap container page-content">
	<div class="row">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-8">
			<?php if (have_posts()): ?>
				<?php while(have_posts()) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part('404'); ?>
			<?php endif; ?>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="container-fluid general_info">
				<div class="row margin_top_40">
					<?php for ($i=1; $i<=3; $i++) {?>
						<div class="col-lg-4 center_me">
							<?php $files = rwmb_meta( 'dd_friend_image_' . $i, 'type=file' ); 
							foreach ($files as $file) {?>
								<img src="<?php echo $file['url']; ?>" title="<?php echo rwmb_meta( 'dd_friend_name_' . $i );?>" />	
							<?php } ?>
							<a href="<?php echo rwmb_meta('dd_friend_link_' . $i);?>" class="friend_link">
								<?php echo rwmb_meta('dd_friend_name_' . $i);?>
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="row margin_top_40 margin_bottom_40">
					<div class="col-lg-4 center_me">&nbsp;</div>
					<div class="col-lg-4 center_me">
						<?php $files = rwmb_meta( 'dd_friend_image_4', 'type=file' ); 
						foreach ($files as $file) {?>
							<img src="<?php echo $file['url']; ?>" title="<?php echo rwmb_meta( 'dd_friend_name_4' );?>" />	
						<?php } ?>
						<a href="<?php echo rwmb_meta('dd_friend_link_4');?>" class="friend_link">
							<?php echo rwmb_meta('dd_friend_name_4');?>
						</a>
					</div>
					<div class="col-lg-4 center_me">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer();