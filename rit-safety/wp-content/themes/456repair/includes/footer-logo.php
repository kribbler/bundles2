<?php 
    $footer_logo = ot_get_option('footer_logo');
?>

<?php if($footer_logo){?>
    <a class="footer_logo" title="<?php bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php echo $footer_logo?>"/></a>
<?php }?>