<?php $wpml_switcher= ot_get_option('wpml_switcher');?>
<?php $navigation_search = ot_get_option('navigation_search');?>

    <?php if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')):?>
	    <?php if($wpml_switcher):?>
	    <div class="wpml-switcher hidden-xs hidden-sm lpd-animated-link<?php if($navigation_search){ ?> wpml-switcher-hide-border<?php } ?>">
	        <?php lpd_language_selector_flags(); ?>
	    </div>
	    <?php endif; ?>
    <?php endif; ?>