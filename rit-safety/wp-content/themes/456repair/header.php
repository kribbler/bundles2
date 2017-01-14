<?php require_once(ABSPATH .'/wp-admin/includes/plugin.php');?>

<?php get_template_part('includes/layouts' ); ?>
<?php get_template_part('includes/plug' );?>
<?php $header_bottom_a_type = ot_get_option('header_bottom_a_type');
$header_bottom_a_speed = ot_get_option('header_bottom_a_speed');
$header_bottom_a_delay = ot_get_option('header_bottom_a_delay');
$header_bottom_a_offset = ot_get_option('header_bottom_a_offset');
$header_bottom_a_easing = ot_get_option('header_bottom_a_easing');
$header_type = ot_get_option('header_type');
$s_cart_style = ot_get_option('s_cart_style');

if(!$header_bottom_a_speed){
	$header_bottom_a_speed = '1000';
}
if(!$header_bottom_a_delay){
	$header_bottom_a_delay = '0';
}

if(!$header_bottom_a_offset){
	$header_bottom_a_offset = '80';
}

$animation_att = ' data-animation="'.$header_bottom_a_type.'" data-speed="'.$header_bottom_a_speed.'" data-delay="'.$header_bottom_a_delay.'" data-offset="'.$header_bottom_a_offset.'" data-easing="'.$header_bottom_a_easing.'"';

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    
	<?php get_template_part('includes/title' ) ?>
    
	<?php get_template_part('includes/seo' ) ?>

	<?php get_template_part('includes/meta-viewport' ) ?>
    
    <meta name="author" content="lidplussdesign" />

    <?php get_template_part('includes/favicon' ) ?>

    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>

<div id="body-wrap">
	<div id="header">
		<?php get_template_part('includes/header_meta' ) ?>
		<?php if($header_type=="type2"){?>
		<div class="header-middle <?php if($s_cart_style=="style2"){ ?> lpd-shopping-cart-style-2<?php }?>">
			<div class="container">
				<div class="row">
					<div class="col-md-12">					
						<?php get_template_part('includes/header-middle' ) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="header-bottom-wrap">
				<div class="container">
					<div class="row">
						<div class="col-md-12<?php if($header_bottom_a_type){?> cre-animate<?php }?>"<?php if($header_bottom_a_type){ echo $animation_att;}?>>
					        <?php get_template_part('includes/header-bottom-search' ) ?>
					        <?php get_template_part('includes/wpml' ) ?>
					        <?php get_template_part('includes/header-email-container' ) ?>
							<?php get_template_part('includes/menu' ) ?>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<?php } else{?>
		<div class="theme-header lpd-new-header<?php if($s_cart_style=="style2"){ ?> lpd-shopping-cart-style-2<?php }?>">
			<div class="theme-header-wrap">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<?php get_template_part('includes/new_theme_header' ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
