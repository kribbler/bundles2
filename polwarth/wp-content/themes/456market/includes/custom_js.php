<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');

    /* General Settings
    ================================================== */
    $custom_js = get_option_tree('custom_js',$theme_options);
}
?>

<?php if($custom_js){?>
<!-- Option Tree Custom Javascript -->
<script>
	<?php echo $custom_js ?>
</script>
<?php }?>