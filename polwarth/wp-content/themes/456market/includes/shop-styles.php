<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* Shop Options
    ================================================== */
    $sale_flash_color2 = get_option_tree('sale_flash_color1',$theme_options);
    $sale_flash_color1 = get_option_tree('sale_flash_color2',$theme_options);
}
?>

<?php if($sale_flash_color1&&$sale_flash_color2){?>
<style>
.onsale_456market{
	background: <?php echo $sale_flash_color1 ?>; /* Old browsers */
	background: -moz-linear-gradient(top,  <?php echo $sale_flash_color1 ?> 1%, <?php echo $sale_flash_color2 ?> 99%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,<?php echo $sale_flash_color1 ?>), color-stop(99%,<?php echo $sale_flash_color2 ?>)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  <?php echo $sale_flash_color1 ?> 1%,<?php echo $sale_flash_color2 ?> 99%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  <?php echo $sale_flash_color1 ?> 1%,<?php echo $sale_flash_color2 ?> 99%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  <?php echo $sale_flash_color1 ?> 1%,<?php echo $sale_flash_color2 ?> 99%); /* IE10+ */
	background: linear-gradient(to bottom,  <?php echo $sale_flash_color1 ?> 1%,<?php echo $sale_flash_color2 ?> 99%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $sale_flash_color1 ?>', endColorstr='<?php echo $sale_flash_color2 ?>',GradientType=0 ); /* IE6-9 */
}
</style>
<?php }?>