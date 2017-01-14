<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* General Settings
    ================================================== */
    $footer_copyright = get_option_tree('footer_copyright',$theme_options);  
}
?>



<?php if($footer_copyright){ ?><p><?php echo $footer_copyright ?></p><?php } ?>