<?php
get_header(); ?>

<div class="bottom-border">
	<div class="white-wrap container page-content">
		<div class="row">
			<div class="col-lg-2">&nbsp;</div>
			<div class="col-lg-8">
				<?php if (have_posts()): ?>
					<?php while(have_posts()) : the_post(); ?>
						<div class="container-fluid">
							<div class="row">
								<div class="col-lg-6 contact_us">
									<h2>Enquiries and Reservations</h2>
									<div id="primary_phone">
										<?php echo rwmb_meta( 'dd_contact_primary_phone' ); ?>
									</div>
									<div class="business_phone">
										<label>Business:</label><?php echo rwmb_meta( 'dd_contact_business_phone' ); ?>
									</div>
									<div class="business_phone">
										<label>Fax:</label><?php echo rwmb_meta( 'dd_contact_fax' ); ?>
									</div>
									<div class="business_phone">
										<label>Email:</label><?php echo rwmb_meta( 'dd_contact_email' ); ?>
									</div>
									<br /><br />
									<?php the_content(); ?>
								</div>
								<div class="col-lg-6 contact_us">
									<div class="margin_left_20">
										<?php echo do_shortcode( rwmb_meta( 'dd_contact_shortcode' ) ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part('404'); ?>
				<?php endif; ?>
			</div>
			<div class="col-lg-2">&nbsp;</div>
		</div>
	</div>
</div>

<?php get_footer();