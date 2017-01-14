<?php $header_bottom_email= ot_get_option('header_bottom_email');?>
<?php $header_bottom_email_url= ot_get_option('header_bottom_email_url');?>

<?php if($header_bottom_email){ ?><div class="lpd-animated-link visible-xs visible-sm email-container"><a href="<?php echo $header_bottom_email_url; ?>"><?php echo $header_bottom_email; ?></a></div><?php } ?>