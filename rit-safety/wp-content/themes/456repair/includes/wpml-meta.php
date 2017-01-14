<?php $wpml_switcher= ot_get_option('wpml_switcher');?>
<?php $navigation_search = ot_get_option('navigation_search');?>
<?php $right_headermeta = ot_get_option('right_headermeta');?>
<?php $h_sm_locations = ot_get_option('h_sm_locations');?>

    <?php if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')):?>
	    <?php if($wpml_switcher):?>
	    <div class="wpml-switcher wpml-switcher-meta hidden-xs hidden-sm lpd-animated-link<?php if($right_headermeta||has_nav_menu( 'right-meta-menu' )||$h_sm_locations=="right_hm"){ echo ' wpml_switcher_hide_border_left'; }?>">
	        <?php lpd_language_selector_flags_1(); ?>
	    </div>
	    <?php endif; ?>
    <?php endif; ?>