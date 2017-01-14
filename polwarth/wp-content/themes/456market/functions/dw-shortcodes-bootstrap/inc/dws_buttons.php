<?php 
/**
 *DesignWall shortcodes grid
 *@package DesignWall Shorcodes
 *@since 1.0
*/

/**
 * Button
 */
function dws_buttons($params, $content = null){
	extract(shortcode_atts(array(
		'size' => 'default',
		'type' => 'default',
		'value' => 'button',
		'icon' => '',
		'href' => "#"
	), $params));
	
	if($type=='link'){
		$livicon_color = '#ea2e49';
	}else{
		$livicon_color = 'white';
	}
	
	$icon_button_size = '';
	$icon_button = '';
	$livicon = '';
	
	if($icon){
		if($size=='large'){
			$button_size = '32';
			$icon_button_size = 'icon-button-32';
		}else{
			$button_size = '16';
			$icon_button_size = 'icon-button-16';
		}
		$livicon = '<span class="livicon" data-n="'.$icon.'" data-s="'.$button_size.'" data-c="'.$livicon_color.'" data-hc="0" data-onparent="true"></span>';
		$icon_button = 'icon-button';
	}
	
	$content = preg_replace('/<br class="nc".\/>/', '', $content);
	$result = '<a class="btn btn-'.$size.' btn-'.$type.' '.$icon_button.' '.$icon_button_size.'" href="'.$href.'">'.$livicon.''.$value.'</a>';
	return force_balance_tags( $result );
}
add_shortcode('button', 'dws_buttons');
