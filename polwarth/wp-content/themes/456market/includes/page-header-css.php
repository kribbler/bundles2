<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* General Settings
    ================================================== */
    $type_layouts = get_option_tree('type_layouts',$theme_options);
    
    /* Page Options
    ================================================== */
    $page_header_bg_types = get_option_tree('page_header_bg_types',$theme_options);
    $page_gradient_bg_color_1 = get_option_tree('page_gradient_bg_color_1',$theme_options);
    $page_gradient_bg_color_2 = get_option_tree('page_gradient_bg_color_2',$theme_options);

}
?>


<?php if($page_gradient_bg_color_1){?>
<style>
#page-header{
	<?php if($page_header_bg_types=='one_color'){?>
		background-color: <?php echo $page_gradient_bg_color_1 ?>;
	<?php } elseif($page_header_bg_types=='horizontal'){?>
		background-color: <?php echo $page_gradient_bg_color_1 ?>;
		background-image: -moz-linear-gradient(left,  <?php echo $page_gradient_bg_color_1 ?> 0%, <?php echo $page_gradient_bg_color_2 ?> 50%, <?php echo $page_gradient_bg_color_1 ?> 100%);
		background-image: -webkit-gradient(linear, left top, right top, color-stop(0%,<?php echo $page_gradient_bg_color_1 ?>), color-stop(50%,<?php echo $page_gradient_bg_color_2 ?>), color-stop(100%,<?php echo $page_gradient_bg_color_1 ?>));
		background-image: -webkit-linear-gradient(left,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 50%,<?php echo $page_gradient_bg_color_1 ?> 100%);
		background-image: -o-linear-gradient(left,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 50%,<?php echo $page_gradient_bg_color_1 ?> 100%);
		background-image: -ms-linear-gradient(left,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 50%,<?php echo $page_gradient_bg_color_1 ?> 100%);
		background-image: linear-gradient(to right,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 50%,<?php echo $page_gradient_bg_color_1 ?> 100%);
	<?php } elseif($page_header_bg_types=='vertical'){?>
		background-color: <?php echo $page_gradient_bg_color_1 ?>;
		background-image: -moz-linear-gradient(top,  <?php echo $page_gradient_bg_color_1 ?> 0%, <?php echo $page_gradient_bg_color_2 ?> 100%);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $page_gradient_bg_color_1 ?>), color-stop(100%,<?php echo $page_gradient_bg_color_2 ?>));
		background-image: -webkit-linear-gradient(top,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 100%);
		background-image: -o-linear-gradient(top,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 100%);
		background-image: -ms-linear-gradient(top,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 100%);
		background-image: linear-gradient(to bottom,  <?php echo $page_gradient_bg_color_1 ?> 0%,<?php echo $page_gradient_bg_color_2 ?> 100%);
	<?php } elseif($page_header_bg_types=='circular_top'){?>
 	
background-color: <?php echo $page_gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: -moz-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: -o-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $page_gradient_bg_color_2 ?>), color-stop(1, <?php echo $page_gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: radial-gradient(circle farthest-corner at center top, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);

	<?php } elseif($page_header_bg_types=='circular_top_50'){?>
	
background-color: <?php echo $page_gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 50%);
background-image: -moz-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 50%);
background-image: -o-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 50%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $page_gradient_bg_color_2 ?>), color-stop(0.5, <?php echo $page_gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, circle farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 50%);
background-image: radial-gradient(circle farthest-corner at center top, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 50%);

	<?php } elseif($page_header_bg_types=='ellipse_top'){?>
	
background-color: <?php echo $page_gradient_bg_color_1 ?>; 
background-image: -ms-radial-gradient(center top, ellipse farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: -moz-radial-gradient(center top, ellipse farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: -o-radial-gradient(center top, ellipse farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%); 
background-image: -webkit-gradient(radial, center top, 0, center top, 553, color-stop(0, <?php echo $page_gradient_bg_color_2 ?>), color-stop(1, <?php echo $page_gradient_bg_color_1 ?>));
background-image: -webkit-radial-gradient(center top, ellipse farthest-corner, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
background-image: radial-gradient(ellipse farthest-corner at center top, <?php echo $page_gradient_bg_color_2 ?> 0%, <?php echo $page_gradient_bg_color_1 ?> 100%);
	
	<?php }?>
}
<?php if($type_layouts=="responsive"){?>
@media (max-width: 979px) {
#meta{
	background-color: <?php echo $page_gradient_bg_color_1 ?>;
}}
<?php }?>
</style>
<?php }?>