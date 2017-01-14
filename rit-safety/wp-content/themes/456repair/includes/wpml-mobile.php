<?php $wpml_switcher= ot_get_option('wpml_switcher');?>

    <?php if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')):?>
	    <?php if($wpml_switcher):?>
	    <div class="wpml-switcher-mobile visible-xs visible-sm lpd-animated-link">
		    <?php lpd_language_selector_flags_mobile(); ?>
	    </div>
	    <?php endif; ?>
    <?php endif; ?>