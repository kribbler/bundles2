<?php
$type_layouts = ot_get_option('type_layouts');
?>
 
<?php if($type_layouts=="fixed"){
    add_action( 'wp_enqueue_scripts', 'lpd_fixed_1170' );
}?>