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
	<?php $booking_content_type = ot_get_option('booking_content_type');?>

	<div class="header-content-wrap">
		<?php if($wt_phone||$tt_dates1||$tt_hours1||$tt_dates2||$tt_hours2||$tt_dates3||$tt_hours3):?>
		<div class="phone-work-hours header-content">
			<table>
				<tr>
					<?php if($wt_phone):?><td class="phone-numbers"<?php if($tt_dates1||$tt_hours1||$tt_dates2||$tt_hours2||$tt_dates3||$tt_hours3):?> style="padding-right: 40px;"<?php endif; ?>><?php echo $wt_phone;?><?php if($wt_phone2):?><br/><?php echo $wt_phone2;?><?php endif; ?></td><?php endif; ?>
					<?php if($tt_dates1||$tt_hours1):?><td class="work-hours first-work-hours"><?php echo $tt_dates1;?><?php if($tt_hours1):?><br/><?php echo $tt_hours1;?><?php endif; ?></td><?php endif; ?>
					<?php if($tt_dates2||$tt_hours2):?><td class="work-hours"><?php echo $tt_dates2;?><?php if($tt_hours2):?><br/><?php echo $tt_hours2;?><?php endif; ?></td><?php endif; ?>
					<?php if($tt_dates3||$tt_hours3):?><td class="work-hours"><?php echo $tt_dates3;?><?php if($tt_hours3):?><br/><?php echo $tt_hours3;?><?php endif; ?></td><?php endif; ?>
				</tr>
			</table> 
		</div>
		<?php endif; ?>
		<?php if($booking_content):?><div class="booking_cont<?php if($booking_content_type=='type2'):?> booking_cont_type2<?php endif; ?> header-content"><?php echo $booking_content;?></div><?php endif; ?>
		<?php if($custom_c_content):?><div class="custom-header-container header-content"><?php echo $custom_c_content;?></div><?php endif; ?>
	</div>