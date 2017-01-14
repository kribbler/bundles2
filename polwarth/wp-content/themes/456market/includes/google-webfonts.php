<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* General Settings
    ================================================== */
    $body_font_family = get_option_tree('body_font_family',$theme_options);
    $body_2_font_family = get_option_tree('body_2_font_family',$theme_options);
    $elements_font_family = get_option_tree('elements_font_family',$theme_options);
    $navigation_font_family = get_option_tree('navigation_font_family',$theme_options);
    $input_font_family = get_option_tree('input_font_family',$theme_options);
    $google_character_sets = get_option_tree('google_character_sets',$theme_options);
}
?>


	<!-- Google Web Fonts
  ================================================== -->
<?php if($body_font_family||$body_2_font_family||$elements_font_family||$navigation_font_family||$input_font_family){ ?>
  
    <?php if($body_font_family == 'Open+Sans'
    || $body_font_family == 'Titillium+Web'
    || $body_font_family == 'Oxygen'
    || $body_font_family == 'Quicksand'
    || $body_font_family == 'Lato'
    || $body_font_family == 'Raleway'
    || $body_font_family == 'Source+Sans+Pro'
    || $body_font_family == 'Dosis'
    || $body_font_family == 'Exo'
    || $body_font_family == 'Arvo'
    || $body_font_family == 'Vollkorn'
    || $body_font_family == 'Ubuntu'
    || $body_font_family == 'PT+Sans'
    || $body_font_family == 'PT+Serif'
    || $body_font_family == 'Droid+Sans'
    || $body_font_family == 'Droid+Serif'
    || $body_font_family == 'Cabin'
    || $body_font_family == 'Lora'
    || $body_font_family == 'Oswald'
    || $body_font_family == 'Varela+Round'
    ){ ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $body_font_family; ?>:300,400,700,400italic<?php if($google_character_sets){echo '&subset=latin,'; echo $google_character_sets; } ?>' rel='stylesheet' type='text/css'>
    <?php }?>
    
    <?php if($body_2_font_family == 'Open+Sans'
    || $body_2_font_family == 'Titillium+Web'
    || $body_2_font_family == 'Oxygen'
    || $body_2_font_family == 'Quicksand'
    || $body_2_font_family == 'Lato'
    || $body_2_font_family == 'Raleway'
    || $body_2_font_family == 'Source+Sans+Pro'
    || $body_2_font_family == 'Dosis'
    || $body_2_font_family == 'Exo'
    || $body_2_font_family == 'Arvo'
    || $body_2_font_family == 'Vollkorn'
    || $body_2_font_family == 'Ubuntu'
    || $body_2_font_family == 'PT+Sans'
    || $body_2_font_family == 'PT+Serif'
    || $body_2_font_family == 'Droid+Sans'
    || $body_2_font_family == 'Droid+Serif'
    || $body_2_font_family == 'Cabin'
    || $body_2_font_family == 'Lora'
    || $body_2_font_family == 'Oswald'
    || $body_2_font_family == 'Varela+Round'
    ){ ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $body_2_font_family; ?>:300,400,700,400italic<?php if($google_character_sets){echo '&subset=latin,'; echo $google_character_sets; } ?>' rel='stylesheet' type='text/css'>
    <?php }?>
    
    <?php if($elements_font_family == 'Open+Sans'
    || $elements_font_family == 'Titillium+Web'
    || $elements_font_family == 'Oxygen'
    || $elements_font_family == 'Quicksand'
    || $elements_font_family == 'Lato'
    || $elements_font_family == 'Raleway'
    || $elements_font_family == 'Source+Sans+Pro'
    || $elements_font_family == 'Dosis'
    || $elements_font_family == 'Exo'
    || $elements_font_family == 'Arvo'
    || $elements_font_family == 'Vollkorn'
    || $elements_font_family == 'Ubuntu'
    || $elements_font_family == 'PT+Sans'
    || $elements_font_family == 'PT+Serif'
    || $elements_font_family == 'Droid+Sans'
    || $elements_font_family == 'Droid+Serif'
    || $elements_font_family == 'Cabin'
    || $elements_font_family == 'Lora'
    || $elements_font_family == 'Oswald'
    || $elements_font_family == 'Varela+Round'
    ){ ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $elements_font_family; ?>:300,400,700,400italic<?php if($google_character_sets){echo '&subset=latin,'; echo $google_character_sets; } ?>' rel='stylesheet' type='text/css'>
    <?php }?>
    
    <?php if($navigation_font_family == 'Open+Sans'
    || $navigation_font_family == 'Titillium+Web'
    || $navigation_font_family == 'Oxygen'
    || $navigation_font_family == 'Quicksand'
    || $navigation_font_family == 'Lato'
    || $navigation_font_family == 'Raleway'
    || $navigation_font_family == 'Source+Sans+Pro'
    || $navigation_font_family == 'Dosis'
    || $navigation_font_family == 'Exo'
    || $navigation_font_family == 'Arvo'
    || $navigation_font_family == 'Vollkorn'
    || $navigation_font_family == 'Ubuntu'
    || $navigation_font_family == 'PT+Sans'
    || $navigation_font_family == 'PT+Serif'
    || $navigation_font_family == 'Droid+Sans'
    || $navigation_font_family == 'Droid+Serif'
    || $navigation_font_family == 'Cabin'
    || $navigation_font_family == 'Lora'
    || $navigation_font_family == 'Oswald'
    || $navigation_font_family == 'Varela+Round'
    ){ ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $navigation_font_family; ?>:300,400,700,400italic<?php if($google_character_sets){echo '&subset=latin,'; echo $google_character_sets; } ?>' rel='stylesheet' type='text/css'>
    <?php }?>
    
    <?php if($input_font_family == 'Open+Sans'
    || $input_font_family == 'Titillium+Web'
    || $input_font_family == 'Oxygen'
    || $input_font_family == 'Quicksand'
    || $input_font_family == 'Lato'
    || $input_font_family == 'Raleway'
    || $input_font_family == 'Source+Sans+Pro'
    || $input_font_family == 'Dosis'
    || $input_font_family == 'Exo'
    || $input_font_family == 'Arvo'
    || $input_font_family == 'Vollkorn'
    || $input_font_family == 'Ubuntu'
    || $input_font_family == 'PT+Sans'
    || $input_font_family == 'PT+Serif'
    || $input_font_family == 'Droid+Sans'
    || $input_font_family == 'Droid+Serif'
    || $input_font_family == 'Cabin'
    || $input_font_family == 'Lora'
    || $input_font_family == 'Oswald'
    || $input_font_family == 'Varela+Round'
    ){ ?>
        <link href='http://fonts.googleapis.com/css?family=<?php echo $input_font_family; ?>:300,400,700,400italic<?php if($google_character_sets){echo '&subset=latin,'; echo $google_character_sets; } ?>' rel='stylesheet' type='text/css'>
    <?php }?>

<?php }else{?> 
    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>   
<?php }?>