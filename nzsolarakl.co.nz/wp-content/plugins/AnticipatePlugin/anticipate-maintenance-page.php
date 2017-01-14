<?php
    global $ET_Anticipate;
    if ( isset($_POST['anticipate_email']) ) $ET_Anticipate->add_email( $_POST['anticipate_email'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NZ Solar Akl  |  Under Construction</title>

	<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/style.css" />

	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/ie6style.css" />
		<script type="text/javascript" src="<?php echo $ET_Anticipate->location_folder ; ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script type="text/javascript">DD_belatedPNG.fix('img#logo, #anticipate-top-shadow, #anticipate-center-highlight, #anticipate-overlay, #anticipate-piece, #anticipate-social-icons img');</script>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ET_Anticipate->location_folder ; ?>/css/ie7style.css" />
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body style="background-image: url('http://www.nzsolarakl.co.nz/wp-content/uploads/bg.png'); background-repeat: no-repeat; background-position: center top;">
<div style="max-width: 999px; width: 95%; margin-left: auto; margin-right: auto; margin-top: 200px;"><img src="http://www.nzsolarakl.co.nz/wp-content/uploads/contact.png" usemap="#Map" style="width: 100%; height: auto;">
  <map name="Map">
    <area shape="rect" coords="409,152,699,180" href="mailto:sean@nzsolarakl.co.nz">
  </map>
</body>
</html>