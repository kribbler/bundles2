<?php

$disable_seo = ot_get_option('disable_seo');
$keywords = ot_get_option('keywords');
$description = ot_get_option('description');

?>

<?php if($disable_seo != 'Disable') {
    if($keywords):
	?>
		<meta name="keywords" content="<?php echo $keywords; ?>">
	<?php
	endif;

	if($description):
	?>
		<meta name="description" content="<?php echo $description; ?>"> 
	<?php
	endif;
}?>