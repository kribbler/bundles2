<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');

    $bg_pattern = get_option_tree('bg_pattern',$theme_options);
    $bg_types = get_option_tree('bg_types',$theme_options);
    $gradient_bg_color_1 = get_option_tree('gradient_bg_color_1',$theme_options);
    $gradient_bg_color_2 = get_option_tree('gradient_bg_color_2',$theme_options);
    $bg_custom_pattern = get_option_tree('bg_custom_pattern',$theme_options);
    $bg_custom_img = get_option_tree('bg_custom_img',$theme_options);

}
?>
<?php if($bg_pattern!="none"&&$bg_custom_pattern==""&&$bg_custom_img==""){?>
<style>
#pattern-background{
    background-image: url(<?php echo THEME_ASSETS; ?>Pattern/body-pattern/<?php echo $bg_pattern; ?>.png);
}
</style>
<?php }?>

<?php if($bg_custom_pattern&&$bg_custom_img==""){?>
<style>
#pattern-background{
    background-image: url(<?php echo $bg_custom_pattern; ?>);
}
</style>
<?php }?>

<?php if($gradient_bg_color_1){?>
<style>
#boxed{
	<?php if($bg_types=='one_color'){?>
		background: <?php echo $gradient_bg_color_1 ?>;
	<?php } elseif($bg_types=='horizontal'){?>
		background: <?php echo $gradient_bg_color_1 ?>;
		background: -moz-linear-gradient(left,  <?php echo $gradient_bg_color_1 ?> 0%, <?php echo $gradient_bg_color_2 ?> 50%, <?php echo $gradient_bg_color_1 ?> 100%);
		background: -webkit-gradient(linear, left top, right top, color-stop(0%,<?php echo $gradient_bg_color_1 ?>), color-stop(50%,<?php echo $gradient_bg_color_2 ?>), color-stop(100%,<?php echo $gradient_bg_color_1 ?>));
		background: -webkit-linear-gradient(left,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 50%,<?php echo $gradient_bg_color_1 ?> 100%);
		background: -o-linear-gradient(left,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 50%,<?php echo $gradient_bg_color_1 ?> 100%);
		background: -ms-linear-gradient(left,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 50%,<?php echo $gradient_bg_color_1 ?> 100%);
		background: linear-gradient(to right,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 50%,<?php echo $gradient_bg_color_1 ?> 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $gradient_bg_color_1 ?>', endColorstr='<?php echo $gradient_bg_color_1 ?>',GradientType=1 );
	<?php } elseif($bg_types=='vertical'){?>
		background: <?php echo $gradient_bg_color_1 ?>;
		background: -moz-linear-gradient(top,  <?php echo $gradient_bg_color_1 ?> 0%, <?php echo $gradient_bg_color_2 ?> 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $gradient_bg_color_1 ?>), color-stop(100%,<?php echo $gradient_bg_color_2 ?>));
		background: -webkit-linear-gradient(top,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 100%);
		background: -o-linear-gradient(top,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 100%);
		background: -ms-linear-gradient(top,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 100%);
		background: linear-gradient(to bottom,  <?php echo $gradient_bg_color_1 ?> 0%,<?php echo $gradient_bg_color_2 ?> 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $gradient_bg_color_1 ?>', endColorstr='<?php echo $gradient_bg_color_2 ?>',GradientType=0 );
	<?php } elseif($bg_types=='circular_top'){?>
 	
background: <?php echo $gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: -moz-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: -o-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $gradient_bg_color_2 ?>), color-stop(1, <?php echo $gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: radial-gradient(circle farthest-corner at center top, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $gradient_bg_color_1 ?>', endColorstr='<?php echo $gradient_bg_color_2 ?>',GradientType=0 );

	<?php } elseif($bg_types=='circular_top_50'){?>
	
background: <?php echo $gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 50%);
background-image: -moz-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 50%);
background-image: -o-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 50%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $gradient_bg_color_2 ?>), color-stop(0.5, <?php echo $gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, circle farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 50%);
background-image: radial-gradient(circle farthest-corner at center top, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 50%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $gradient_bg_color_1 ?>', endColorstr='<?php echo $gradient_bg_color_2 ?>',GradientType=0 );

	<?php } elseif($bg_types=='ellipse_top'){?>
	
background: <?php echo $gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, ellipse farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: -moz-radial-gradient(center top, ellipse farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: -o-radial-gradient(center top, ellipse farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $gradient_bg_color_2 ?>), color-stop(1, <?php echo $gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, ellipse farthest-corner, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
background-image: radial-gradient(ellipse farthest-corner at center top, <?php echo $gradient_bg_color_2 ?> 0%, <?php echo $gradient_bg_color_1 ?> 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $gradient_bg_color_1 ?>', endColorstr='<?php echo $gradient_bg_color_2 ?>',GradientType=0 );
	
	<?php }?>
}
</style>
<?php }?>

<?php if($bg_custom_img){?>
<style>
#boxed{
	background: url(<?php echo $bg_custom_img ?>);
	background-color: transparent;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	background-attachment: fixed;
	background-position: center top;
	background-repeat: repeat;
}
</style>
<?php }?>