	<?php $h_sm_locations = ot_get_option('h_sm_locations');?>
	<?php $wt_phone = ot_get_option('wt_phone');?>
	<?php $wt_phone2 = ot_get_option('wt_phone2');?>
	<?php $tt_dates1 = ot_get_option('tt_dates1');?>
	<?php $tt_hours1 = ot_get_option('tt_hours1');?>
	<?php $tt_dates2 = ot_get_option('tt_dates2');?>
	<?php $tt_hours2 = ot_get_option('tt_hours2');?>
	<?php $tt_dates3 = ot_get_option('tt_dates3');?>
	<?php $tt_hours3 = ot_get_option('tt_hours3');?>
	<?php $booking_content = ot_get_option('booking_content');?>
	<?php $custom_c_content = ot_get_option('custom_c_content');?>
	<?php $logo_location = ot_get_option('logo_location');?>
	<?php $h_sm_locations = ot_get_option('h_sm_locations'); ?>
	

	<?php if($logo_location=="left"){?>
	
		<?php get_template_part('includes/logo' ) ?>
		<?php if($h_sm_locations!="right_h"):?>
			<?php get_template_part('includes/cart' ) ?>
		<?php endif; ?>
		<?php get_template_part('includes/wpml-mobile' ) ?>
		<?php get_template_part('includes/header_search' ) ?>
		<?php get_template_part('includes/header_search_mobile' ) ?>
	
		<?php if($h_sm_locations=="right_h"):?>
			<?php get_template_part('includes/header_social_media' ) ?>
		<?php endif; ?>
		
		<?php if($wt_phone||$tt_dates1||$tt_hours1||$tt_dates2||$tt_hours2||$tt_dates3||$tt_hours3||$booking_content||$custom_c_content):?>
			<?php get_template_part('includes/header-content-wrap' ) ?>
		<?php endif; ?>
	
	<?php }else{?>
	
		<div class="header-middle-logo-center clearfix">
	
		<?php if($wt_phone||$tt_dates1||$tt_hours1||$tt_dates2||$tt_hours2||$tt_dates3||$tt_hours3||$booking_content||$custom_c_content):?>
			<?php get_template_part('includes/header-content-wrap' ) ?>
		<?php endif; ?>
	
		<?php get_template_part('includes/logo' ) ?>
	
		
		<div class="header-middle-logo-center-right-conteiner">
		<?php if($h_sm_locations!="right_h"):?>
			<?php get_template_part('includes/cart' ) ?>
		<?php endif; ?>
		<?php get_template_part('includes/wpml-mobile' ) ?>
		
		<?php get_template_part('includes/header_search' ) ?>
		<?php get_template_part('includes/header_search_mobile' ) ?>
	
		<?php if($h_sm_locations=="right_h"):?>
			<?php get_template_part('includes/header_social_media' ) ?>
		<?php endif; ?>
		
		<?php get_template_part('includes/header-middle-email-container' ) ?>
		
		</div>
	
		</div>
	
	<?php }?>