<?php $navigation_search = ot_get_option('navigation_search');?>
<?php $wpml_switcher= ot_get_option('wpml_switcher');?>
<?php $header_bottom_email = ot_get_option('header_bottom_email');?>
<?php $header_bottom_email_url = ot_get_option('header_bottom_email_url');?>

<?php if($header_bottom_email){ ?><div class="lpd-animated-link hidden-xs hidden-sm email-container<?php if($navigation_search!="none"||$wpml_switcher){ ?> email-container-hide-border<?php } ?>"><a href="<?php echo $header_bottom_email_url; ?>"><?php echo $header_bottom_email; ?></a></div><?php } ?>