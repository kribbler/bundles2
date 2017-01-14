<?php
plugin('jquery');
wp_enqueue_script('validform','/wp-content/plugins/seoheap/plugins/validator/validator.js?v='.filemtime(dirname(__FILE__).'/validator.js'));