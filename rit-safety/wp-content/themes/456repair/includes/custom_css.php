<?php 
$custom_css = ot_get_option('custom_css');
?>

<?php if($custom_css){?>
<!-- Option Tree Custom Css -->
<style>
	<?php echo $custom_css ?>
</style>
<?php }?>