<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');

    /* General Settings
    ================================================== */
    $custom_css = get_option_tree('custom_css',$theme_options);

}
?>

<?php if($custom_css){?>
<!-- Option Tree Custom Css -->
<style>
	<?php echo $custom_css ?>
</style>
<?php }?>