<?php
$page_title_a_type = ot_get_option('page_title_a_type');
$page_title_a_speed = ot_get_option('page_title_a_speed');
$page_title_a_delay = ot_get_option('page_title_a_delay');
$page_title_a_offset = ot_get_option('page_title_a_offset');
$page_title_a_easing = ot_get_option('page_title_a_easing');

if(!$page_title_a_speed){
	$page_title_a_speed = '1000';
}
if(!$page_title_a_delay){
	$page_title_a_delay = '0';
}

if(!$page_title_a_offset){
	$page_title_a_offset = '80';
}

$animation_att = ' data-animation="'.$page_title_a_type.'" data-speed="'.$page_title_a_speed.'" data-delay="'.$page_title_a_delay.'" data-offset="'.$page_title_a_offset.'" data-easing="'.$page_title_a_easing.'"';
?>

<div id="title-breadcrumb" <?php echo lpd_page_header_image(); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="title-wrap lpd-animated-link<?php if($page_title_a_type){?> cre-animate<?php }?>"<?php if($page_title_a_type){ echo $animation_att;}?>>
					<h2><?php echo lpd_title();?></h2>
					<div class="deco-sep-line-100"></div>
					<?php if (is_plugin_active('woocommerce/woocommerce.php')) {?>
						<?php if(is_shop()){?>
							<div class="lpd_breadcrumb"><?php _e('You Are Here', GETTEXT_DOMAIN); ?>: <?php echo woocommerce_page_breadcrumb();?></div>
						<?php } else if (is_singular('product') ) {?>
							<div class="lpd_breadcrumb"><?php _e('You Are Here', GETTEXT_DOMAIN); ?>: <?php echo woocommerce_page_breadcrumb();?></div>
						<?php } else if (is_tax('product_cat')||is_tax('product_tag') ) {?>
							<div class="lpd_breadcrumb"><?php _e('You Are Here', GETTEXT_DOMAIN); ?>: <?php echo woocommerce_page_breadcrumb();?></div>
						<?php } else{?>
							<div class="lpd_breadcrumb"><?php _e('You Are Here', GETTEXT_DOMAIN); ?>: <?php echo woocommerce_page_breadcrumb();?></div>
						<?php }?>
					<?php }else{?>
						<div class="lpd_breadcrumb"><?php _e('You Are Here', GETTEXT_DOMAIN); ?>: <?php echo lpd_breadcrumb()?></div>
					<?php }?>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</div>