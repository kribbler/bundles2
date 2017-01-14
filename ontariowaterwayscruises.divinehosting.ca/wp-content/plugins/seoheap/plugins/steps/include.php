<?php
plugin('jquery');
$path=(false && $_SERVER['REMOTE_ADDR']=='84.92.208.54') ? 'http://testcdn.staging.seoheap.com/' : cdnpath();
wp_enqueue_style('steps',$path.'steps/steps.css');
wp_enqueue_script('steps',$path.'steps/steps.js');