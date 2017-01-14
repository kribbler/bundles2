<?php

$favicon = ot_get_option('favicon');
$iphone_icon = ot_get_option('iphone_icon');
$ipad_icon = ot_get_option('ipad_icon');
$iphone2_icon = ot_get_option('iphone2_icon');
$ipad2_icon = ot_get_option('ipad2_icon');

?>

<?php if($favicon){ ?><link rel="shortcut icon" href="<?php echo $favicon ?>"><?php } ?>  
<?php if($ipad2_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ipad2_icon ?>"><?php } ?>
<?php if($iphone2_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $iphone2_icon ?>"><?php } ?>
<?php if($ipad_icon){ ?><link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ipad_icon ?>"><?php } ?>
<?php if($iphone_icon){ ?><link rel="apple-touch-icon-precomposed" href="<?php echo $iphone_icon ?>"><?php } ?>