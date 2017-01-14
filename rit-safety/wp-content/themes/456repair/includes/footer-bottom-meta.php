<?php
$cc = ot_get_option('cc');

$footer_copyright = ot_get_option('footer_copyright');
$footer_logo = ot_get_option('footer_logo');

$footer_bottom_a_type = ot_get_option('footer_bottom_a_type');
$footer_bottom_a_speed = ot_get_option('footer_bottom_a_speed');
$footer_bottom_a_delay = ot_get_option('footer_bottom_a_delay');
$footer_bottom_a_offset = ot_get_option('footer_bottom_a_offset');
$footer_bottom_a_easing = ot_get_option('footer_bottom_a_easing');

if(!$footer_bottom_a_speed){
	$footer_bottom_a_speed = '1000';
}
if(!$footer_bottom_a_delay){
	$footer_bottom_a_delay = '0';
}

if(!$footer_bottom_a_offset){
	$footer_bottom_a_offset = '80';
}

$animation_att = ' data-animation="'.$footer_bottom_a_type.'" data-speed="'.$footer_bottom_a_speed.'" data-delay="'.$footer_bottom_a_delay.'" data-offset="'.$footer_bottom_a_offset.'" data-easing="'.$footer_bottom_a_easing.'"';

?>

<?php if($cc){ ?>
<div class="col-md-6<?php if($footer_bottom_a_type){?> cre-animate<?php }?>"<?php if($footer_bottom_a_type){ echo $animation_att;}?>>
<?php } else{ ?>
<div class="col-md-12<?php if($footer_bottom_a_type){?> cre-animate<?php }?>"<?php if($footer_bottom_a_type){ echo $animation_att;}?>>
<?php } ?>
	<?php get_template_part('includes/footer-logo' ) ?>
	<?php if ( has_nav_menu( 'footer-menu' )||$footer_copyright) {?>
		<div class="footer-m-copyright<?php if (!$footer_logo) {?> no-footer-logo<?php } ?>">
		<?php get_template_part('includes/copyright' ) ?>
		<?php if ( has_nav_menu( 'footer-menu' ) ) {?>
		<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-menu', 'container' => '', 'depth' => 1  ) ); ?>
		<?php } ?>
		</div>
	<?php } ?>
	<div class="clearfix"></div>
</div>