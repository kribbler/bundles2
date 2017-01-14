<?php function lpd_install_mediaboxes() {?>
<?php $navigation_speed= ot_get_option('navigation_speed');?>
<?php $clickable_navigation= ot_get_option('clickable_navigation');?>
<?php $easing_navigation= ot_get_option('easing_navigation');?>	
<?php $animate_hoverIn= ot_get_option('animate_hoverIn');?>
<?php $animate_hoverOut= ot_get_option('animate_hoverOut');?>
<?php $type_layouts= ot_get_option('type_layouts');?>
<script>
	jQuery(document).ready(function () {
		jQuery('#menuMega').menu3d({
			"skin":"skin-456repair",
			"responsive":<?php if($type_layouts=="responsive"):?>true<?php else:?>false<?php endif; ?>,
			"clickable":<?php echo $clickable_navigation; ?>,
			"speed":<?php if(!$navigation_speed):?>600<?php else: echo $navigation_speed; endif; ?>,
			"easing":"<?php echo $easing_navigation; ?>",
			"hoverIn":"<?php echo $animate_hoverIn; ?>",
			"hoverOut":"<?php echo $animate_hoverOut; ?>"
		});
		
	});
</script>
<?php }?>
<?php add_action( 'wp_footer', 'lpd_install_mediaboxes', 100);?>