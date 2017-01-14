<?php function sidebar_animation() {
$sidebar_a_type = ot_get_option('sidebar_a_type');
$sidebar_a_speed = ot_get_option('sidebar_a_speed');
$sidebar_a_delay = ot_get_option('sidebar_a_delay');
$sidebar_a_offset = ot_get_option('sidebar_a_offset');
$sidebar_a_easing = ot_get_option('sidebar_a_easing');
?>
<script>	
jQuery(document).ready(function() {
	"use strict";	
	jQuery( ".sidebar .widget" )
	.addClass('cre-animate')
	.css('opacity', '0')
	.attr('data-animation','<?php echo $sidebar_a_type; ?>')
	.attr('data-speed','<?php if ( !$sidebar_a_speed ) { ?>1000<?php }else{ echo $sidebar_a_speed; ?><?php }?>')
	.attr('data-delay','<?php if ( !$sidebar_a_delay ) { ?>0<?php }else{ echo $sidebar_a_delay; ?><?php }?>')
	.attr('data-offset','<?php if ( !$sidebar_a_offset ) { ?>80<?php }else{ echo $sidebar_a_offset; ?><?php }?>')
	.attr('data-easing','<?php echo $sidebar_a_easing; ?>');
});	
</script>	
<?php }?>
<?php function footer_animation() {
$footer_a_type = ot_get_option('footer_a_type');
$footer_a_speed = ot_get_option('footer_a_speed');
$footer_a_delay = ot_get_option('footer_a_delay');
$footer_a_offset = ot_get_option('footer_a_offset');
$footer_a_easing = ot_get_option('footer_a_easing');
?>
<script>	
jQuery(document).ready(function() {
	"use strict";	
	jQuery( ".footer .widget" )
	.addClass('cre-animate')
	.css('opacity', '0')
	.attr('data-animation','<?php echo $footer_a_type; ?>')
	.attr('data-speed','<?php if ( !$footer_a_speed ) { ?>1000<?php }else{ echo $footer_a_speed; ?><?php }?>')
	.attr('data-delay','<?php if ( !$footer_a_delay ) { ?>0<?php }else{ echo $footer_a_delay; ?><?php }?>')
	.attr('data-offset','<?php if ( !$footer_a_offset ) { ?>80<?php }else{ echo $footer_a_offset; ?><?php }?>')
	.attr('data-easing','<?php echo $footer_a_easing; ?>');
});	
</script>	
<?php }?>
<?php function footer_top_animation() {
$footer_top_a_type = ot_get_option('footer_top_a_type');
$footer_top_a_speed = ot_get_option('footer_top_a_speed');
$footer_top_a_delay = ot_get_option('footer_top_a_delay');
$footer_top_a_offset = ot_get_option('footer_top_a_offset');
$footer_top_a_easing = ot_get_option('footer_top_a_easing');
?>
<script>	
jQuery(document).ready(function() {
	"use strict";	
	jQuery( "#footer-top .widget" )
	.addClass('cre-animate')
	.css('opacity', '0')
	.attr('data-animation','<?php echo $footer_top_a_type; ?>')
	.attr('data-speed','<?php if ( !$footer_top_a_speed ) { ?>1000<?php }else{ echo $footer_top_a_speed; ?><?php }?>')
	.attr('data-delay','<?php if ( !$footer_top_a_delay ) { ?>0<?php }else{ echo $footer_top_a_delay; ?><?php }?>')
	.attr('data-offset','<?php if ( !$footer_top_a_offset ) { ?>80<?php }else{ echo $footer_top_a_offset; ?><?php }?>')
	.attr('data-easing','<?php echo $footer_top_a_easing; ?>');
});	
</script>	
<?php }?>