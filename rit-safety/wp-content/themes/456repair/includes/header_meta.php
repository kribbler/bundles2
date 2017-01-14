<?php $header_meta= ot_get_option('header_meta');?>
<?php $header_meta_background = ot_get_option('header_meta_background');?>
<?php $hm_custom_pattern = ot_get_option('hm_custom_pattern');?>
<?php $hm_custom_bg = ot_get_option('hm_custom_bg');?>
<?php $hm_dark_bg = ot_get_option('hm_dark_bg');?>
<?php $triangle_element = ot_get_option('triangle_element');?>

<?php if(!$header_meta):?>
<div class="header-top<?php if ($header_meta_background) { ?> header-top-pattern-bg<?php } ?><?php if (!$hm_dark_bg) { ?> header-meta-dark-bg<?php } ?><?php if ($triangle_element) { ?> triangle-element<?php } ?>"<?php if ($header_meta_background=='custom'||$hm_custom_bg) { ?> style="<?php if ($header_meta_background=='custom') { ?>background-image:url(<?php echo $hm_custom_pattern;?>);<?php } ?><?php if ($hm_custom_bg) { ?>background-color: <?php echo $hm_custom_bg;?>;<?php } ?>"<?php } ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-6 lpd-animated-link left_header_meta<?php if (!$hm_dark_bg) { ?> dark-bg<?php } ?>">
				<?php get_template_part('includes/left_header_meta' ) ?>
			</div>
			<div class="col-md-6 lpd-animated-link right_header_meta<?php if (!$hm_dark_bg) { ?> dark-bg<?php } ?>">
				<?php get_template_part('includes/right_header_meta' ) ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>