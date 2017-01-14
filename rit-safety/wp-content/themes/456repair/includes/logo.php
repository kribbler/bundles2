<?php 
    $custom_logo = ot_get_option('custom_logo');
    $header_type = ot_get_option('header_type');
    $custom_logo_tm = "";
	if($header_type=="type1"){
	    $custom_logo_tm = ot_get_option('custom_logo_tm');
	}
?>


	<?php if($custom_logo){?>
	<div id="logo" class="img">
	    <h1<?php if($custom_logo_tm){?> style="margin-top:<?php echo $custom_logo_tm; ?>px;"<?php }?>><a href="<?php echo home_url(); ?>"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo $custom_logo?>"/></a></h1>
	</div>
	<?php }else{?>
	<div id="logo">
	    <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <?php if($blog_title = get_bloginfo('description')){?>
        <h5><?php echo $blog_title; ?></h5>
        <?php }?>
	</div>
	<?php }?>