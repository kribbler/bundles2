<?php $cc = ot_get_option('cc');?>
<?php $footer_bottom_a_type = ot_get_option('footer_bottom_a_type');
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
<div class="col-md-6 payment-methods<?php if($footer_bottom_a_type){?> cre-animate<?php }?>"<?php if($footer_bottom_a_type){ echo $animation_att;}?>>
<img src="<?php echo $cc; ?>" class="payment-cc img-responsive" alt="<?php _e('Payment methods', GETTEXT_DOMAIN) ?>">
</div>
<?php }?>