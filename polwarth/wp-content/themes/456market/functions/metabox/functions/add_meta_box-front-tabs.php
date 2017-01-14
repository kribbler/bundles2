<?php

// Add the Meta Box
function add_front_tabs_meta_box() {
    add_meta_box(
		'front_tabs', // $id
		'Front Tabs Options', // $title 
		'show_front_tabs_meta_box', // $callback
		'front_tabs', // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_front_tabs_meta_box');

// Field Array
$prefix = 'front_tabs_';
$front_tabs_meta_fields = array(
	array(
		'label'	=> 'Tab Icon',
		'desc'	=> 'Select an icon for tab.',
		'id'	=> $prefix.'select',
		'type'	=> 'select',
		'options' => array (
'none' => array ('label' => 'none','value'	=> 'none'),
'adjust' => array ('label' => 'adjust','value'	=> 'adjust'),
'alarm' => array ('label' => 'alarm','value'	=> 'alarm'),
'apple' => array ('label' => 'apple','value'	=> 'apple'),
'ban' => array ('label' => 'ban','value'	=> 'ban'),
'barchart' => array ('label' => 'barchart','value'	=> 'barchart'),
'barcode' => array ('label' => 'barcode','value'	=> 'barcode'),
'beer' => array ('label' => 'beer','value'	=> 'beer'),
'bell' => array ('label' => 'bell','value'	=> 'bell'),
'bolt' => array ('label' => 'bolt','value'	=> 'bolt'),
'bookmark' => array ('label' => 'bookmark','value'	=> 'bookmark'),
'briefcase' => array ('label' => 'briefcase','value'	=> 'briefcase'),
'brush' => array ('label' => 'brush','value'	=> 'brush'),
'bug' => array ('label' => 'bug','value'	=> 'bug'),
'calendar' => array ('label' => 'calendar','value'	=> 'calendar'),
'camera' => array ('label' => 'camera','value'	=> 'camera'),
'car' => array ('label' => 'car','value'	=> 'car'),
'cellphone' => array ('label' => 'cellphone','value'	=> 'cellphone'),
'certificate' => array ('label' => 'certificate','value'	=> 'certificate'),
'check' => array ('label' => 'check','value'	=> 'check'),
'check-circle' => array ('label' => 'check-circle','value'	=> 'check-circle'),
'check-circle-alt' => array ('label' => 'check-circle-alt','value'	=> 'check-circle-alt'),
'checked-off' => array ('label' => 'checked-off','value'	=> 'checked-off'),
'checked-on' => array ('label' => 'checked-on','value'	=> 'checked-on'),
'circle' => array ('label' => 'circle','value'	=> 'circle'),
'circle-alt' => array ('label' => 'circle-alt','value'	=> 'circle-alt'),
'clapboard' => array ('label' => 'clapboard','value'	=> 'clapboard'),
'clip' => array ('label' => 'clip','value'	=> 'clip'),
'clock' => array ('label' => 'clock','value'	=> 'clock'),
'cloud' => array ('label' => 'cloud','value'	=> 'cloud'),
'cloud-bolts' => array ('label' => 'cloud-bolts','value'	=> 'cloud-bolts'),
'cloud-rain' => array ('label' => 'cloud-rain','value'	=> 'cloud-rain'),
'cloud-snow' => array ('label' => 'cloud-snow','value'	=> 'cloud-snow'),
'cloud-sun' => array ('label' => 'cloud-sun','value'	=> 'cloud-sun'),
'cloud-down' => array ('label' => 'cloud-down','value'	=> 'cloud-down'),
'cloud-up' => array ('label' => 'cloud-up','value'	=> 'cloud-up'),
'code' => array ('label' => 'code','value'	=> 'code'),
'comment' => array ('label' => 'comment','value'	=> 'comment'),
'comments' => array ('label' => 'comments','value'	=> 'comments'),
'compass' => array ('label' => 'compass','value'	=> 'compass'),
'credit-card' => array ('label' => 'credit-card','value'	=> 'credit-card'),
'css3' => array ('label' => 'css3','value'	=> 'css3'),
'dashboard' => array ('label' => 'dashboard','value'	=> 'dashboard'),
'desktop' => array ('label' => 'desktop','value'	=> 'desktop'),
'doc-landscape' => array ('label' => 'doc-landscape','value'	=> 'doc-landscape'),
'doc-portrait' => array ('label' => 'doc-portrait','value'	=> 'doc-portrait'),
'download' => array ('label' => 'download','value'	=> 'download'),
'download-alt' => array ('label' => 'download-alt','value'	=> 'download-alt'),
'drop' => array ('label' => 'drop','value'	=> 'drop'),
'edit' => array ('label' => 'edit','value'	=> 'edit'),
'eye-close' => array ('label' => 'eye-close','value'	=> 'eye-close'),
'eye-open' => array ('label' => 'eye-open','value'	=> 'eye-open'),
'film' => array ('label' => 'film','value'	=> 'film'),
'filter' => array ('label' => 'filter','value'	=> 'filter'),
'fire' => array ('label' => 'fire','value'	=> 'fire'),
'flag' => array ('label' => 'flag','value'	=> 'flag'),
'gear' => array ('label' => 'gear','value'	=> 'gear'),
'gears' => array ('label' => 'gears','value'	=> 'gears'),
'ghost' => array ('label' => 'ghost','value'	=> 'ghost'),
'gift' => array ('label' => 'gift','value'	=> 'gift'),
'glass' => array ('label' => 'glass','value'	=> 'glass'),
'globe' => array ('label' => 'globe','value'	=> 'globe'),
'hammer' => array ('label' => 'hammer','value'	=> 'hammer'),
'heart' => array ('label' => 'heart','value'	=> 'heart'),
'heart-alt' => array ('label' => 'heart-alt','value'	=> 'heart-alt'),
'help' => array ('label' => 'help','value'	=> 'help'),
'home' => array ('label' => 'home','value'	=> 'home'),
'html5' => array ('label' => 'html5','value'	=> 'html5'),
'image' => array ('label' => 'image','value'	=> 'image'),
'inbox' => array ('label' => 'inbox','value'	=> 'inbox'),
'info' => array ('label' => 'info','value'	=> 'info'),
'key' => array ('label' => 'key','value'	=> 'key'),
'lab' => array ('label' => 'lab','value'	=> 'lab'),
'laptop' => array ('label' => 'laptop','value'	=> 'laptop'),
'leaf' => array ('label' => 'leaf','value'	=> 'leaf'),
'legal' => array ('label' => 'legal','value'	=> 'legal'),
'linechart' => array ('label' => 'linechart','value'	=> 'linechart'),
'link' => array ('label' => 'link','value'	=> 'link'),
'location' => array ('label' => 'location','value'	=> 'location'),
'lock' => array ('label' => 'lock','value'	=> 'lock'),
'magic' => array ('label' => 'magic','value'	=> 'magic'),
'magic-alt' => array ('label' => 'magic-alt','value'	=> 'magic-alt'),
'magnet' => array ('label' => 'magnet','value'	=> 'magnet'),
'mail' => array ('label' => 'mail','value'	=> 'mail'),
'mail-alt' => array ('label' => 'mail-alt','value'	=> 'mail-alt'),
'map' => array ('label' => 'map','value'	=> 'map'),
'minus' => array ('label' => 'minus','value'	=> 'minus'),
'minus-alt' => array ('label' => 'minus-alt','value'	=> 'minus-alt'),
'money' => array ('label' => 'money','value'	=> 'money'),
'more' => array ('label' => 'more','value'	=> 'more'),
'move' => array ('label' => 'move','value'	=> 'move'),
'music' => array ('label' => 'music','value'	=> 'music'),
'notebook' => array ('label' => 'notebook','value'	=> 'notebook'),
'pacman' => array ('label' => 'pacman','value'	=> 'pacman'),
'pen' => array ('label' => 'pen','value'	=> 'pen'),
'pencil' => array ('label' => 'pencil','value'	=> 'pencil'),
'phone' => array ('label' => 'phone','value'	=> 'phone'),
'piechart' => array ('label' => 'piechart','value'	=> 'piechart'),
'piggybank' => array ('label' => 'piggybank','value'	=> 'piggybank'),
'plane-down' => array ('label' => 'plane-down','value'	=> 'plane-down'),
'plane-up' => array ('label' => 'plane-up','value'	=> 'plane-up'),
'plus' => array ('label' => 'plus','value'	=> 'plus'),
'plus-alt' => array ('label' => 'plus-alt','value'	=> 'plus-alt'),
'presentation' => array ('label' => 'presentation','value'	=> 'presentation'),
'printer' => array ('label' => 'printer','value'	=> 'printer'),
'qrcode' => array ('label' => 'qrcode','value'	=> 'qrcode'),
'question' => array ('label' => 'question','value'	=> 'question'),
'quote-left' => array ('label' => 'quote-left','value'	=> 'quote-left'),
'quote-right' => array ('label' => 'quote-right','value'	=> 'quote-right'),
'remove' => array ('label' => 'remove','value'	=> 'remove'),
'remove-alt' => array ('label' => 'remove-alt','value'	=> 'remove-alt'),
'remove-circle' => array ('label' => 'remove-circle','value'	=> 'remove-circle'),
'responsive' => array ('label' => 'responsive','value'	=> 'responsive'),
'responsive-menu' => array ('label' => 'responsive-menu','value'	=> 'responsive-menu'),
'retweet' => array ('label' => 'retweet','value'	=> 'retweet'),
'rocket' => array ('label' => 'rocket','value'	=> 'rocket'),
'sandglass' => array ('label' => 'sandglass','value'	=> 'sandglass'),
'screenshot' => array ('label' => 'screenshot','value'	=> 'screenshot'),
'search' => array ('label' => 'search','value'	=> 'search'),
'settings' => array ('label' => 'settings','value'	=> 'settings'),
'share' => array ('label' => 'share','value'	=> 'share'),
'shield' => array ('label' => 'shield','value'	=> 'shield'),
'shopping-cart' => array ('label' => 'shopping-cart','value'	=> 'shopping-cart'),
'shuffle' => array ('label' => 'shuffle','value'	=> 'shuffle'),
'sign-in' => array ('label' => 'sign-in','value'	=> 'sign-in'),
'sign-out' => array ('label' => 'sign-out','value'	=> 'sign-out'),
'signal' => array ('label' => 'signal','value'	=> 'signal'),
'sitemap' => array ('label' => 'sitemap','value'	=> 'sitemap'),
'sort' => array ('label' => 'sort','value'	=> 'sort'),
'sort-down' => array ('label' => 'sort-down','value'	=> 'sort-down'),
'sort-up' => array ('label' => 'sort-up','value'	=> 'sort-up'),
'star-empty' => array ('label' => 'star-empty','value'	=> 'star-empty'),
'star-full' => array ('label' => 'star-full','value'	=> 'star-full'),
'star-half' => array ('label' => 'star-half','value'	=> 'star-half'),
'stopwatch' => array ('label' => 'stopwatch','value'	=> 'stopwatch'),
'sun' => array ('label' => 'sun','value'	=> 'sun'),
'tablet' => array ('label' => 'tablet','value'	=> 'tablet'),
'tag' => array ('label' => 'tag','value'	=> 'tag'),
'tags' => array ('label' => 'tags','value'	=> 'tags'),
'tasks' => array ('label' => 'tasks','value'	=> 'tasks'),
'thermo-down' => array ('label' => 'thermo-down','value'	=> 'thermo-down'),
'thermo-up' => array ('label' => 'thermo-up','value'	=> 'thermo-up'),
'thumbs-down' => array ('label' => 'thumbs-down','value'	=> 'thumbs-down'),
'thumbs-up' => array ('label' => 'thumbs-up','value'	=> 'thumbs-up'),
'trash' => array ('label' => 'trash','value'	=> 'trash'),
'tree' => array ('label' => 'tree','value'	=> 'tree'),
'trophy' => array ('label' => 'trophy','value'	=> 'trophy'),
'truck' => array ('label' => 'truck','value'	=> 'truck'),
'umbrella' => array ('label' => 'umbrella','value'	=> 'umbrella'),
'unlock' => array ('label' => 'unlock','value'	=> 'unlock'),
'upload' => array ('label' => 'upload','value'	=> 'upload'),
'upload-alt' => array ('label' => 'upload-alt','value'	=> 'upload-alt'),
'user' => array ('label' => 'user','value'	=> 'user'),
'users' => array ('label' => 'users','value'	=> 'users'),
'warning' => array ('label' => 'warning','value'	=> 'warning'),
'warning-alt' => array ('label' => 'warning-alt','value'	=> 'warning-alt'),
'wrench' => array ('label' => 'wrench','value'	=> 'wrench'),
'zoom-in' => array ('label' => 'zoom-in','value'	=> 'zoom-in'),
'zoom-out' => array ('label' => 'zoom-out','value'	=> 'zoom-out'),
'angle-down' => array ('label' => 'angle-down','value'	=> 'angle-down'),
'angle-left' => array ('label' => 'angle-left','value'	=> 'angle-left'),
'angle-right' => array ('label' => 'angle-right','value'	=> 'angle-right'),
'angle-up' => array ('label' => 'angle-up','value'	=> 'angle-up'),
'angle-double-down' => array ('label' => 'angle-double-down','value'	=> 'angle-double-down'),
'angle-double-left' => array ('label' => 'angle-double-left','value'	=> 'angle-double-left'),
'angle-double-right' => array ('label' => 'angle-double-right','value'	=> 'angle-double-right'),
'angle-double-up' => array ('label' => 'angle-double-up','value'	=> 'angle-double-up'),
'angle-wide-down' => array ('label' => 'angle-wide-down','value'	=> 'angle-wide-down'),
'angle-wide-left' => array ('label' => 'angle-wide-left','value'	=> 'angle-wide-left'),
'angle-wide-right' => array ('label' => 'angle-wide-right','value'	=> 'angle-wide-right'),
'angle-wide-up' => array ('label' => 'angle-wide-up','value'	=> 'angle-wide-up'),
'arrow-down' => array ('label' => 'arrow-down','value'	=> 'arrow-down'),
'arrow-left' => array ('label' => 'arrow-left','value'	=> 'arrow-left'),
'arrow-right' => array ('label' => 'arrow-right','value'	=> 'arrow-right'),
'arrow-up' => array ('label' => 'arrow-up','value'	=> 'arrow-up'),
'arrow-circle-down' => array ('label' => 'arrow-circle-down','value'	=> 'arrow-circle-down'),
'arrow-circle-left' => array ('label' => 'arrow-circle-left','value'	=> 'arrow-circle-left'),
'arrow-circle-right' => array ('label' => 'arrow-circle-right','value'	=> 'arrow-circle-right'),
'arrow-circle-up' => array ('label' => 'arrow-circle-up','value'	=> 'arrow-circle-up'),
'caret-down' => array ('label' => 'caret-down','value'	=> 'caret-down'),
'caret-left' => array ('label' => 'caret-left','value'	=> 'caret-left'),
'caret-right' => array ('label' => 'caret-right','value'	=> 'caret-right'),
'caret-up' => array ('label' => 'caret-up','value'	=> 'caret-up'),
'chevron-down' => array ('label' => 'chevron-down','value'	=> 'chevron-down'),
'chevron-left' => array ('label' => 'chevron-left','value'	=> 'chevron-left'),
'chevron-right' => array ('label' => 'chevron-right','value'	=> 'chevron-right'),
'chevron-up' => array ('label' => 'chevron-up','value'	=> 'chevron-up'),
'exchange' => array ('label' => 'exchange','value'	=> 'exchange'),
'external-link' => array ('label' => 'external-link','value'	=> 'external-link'),
'hand-down' => array ('label' => 'hand-down','value'	=> 'hand-down'),
'hand-left' => array ('label' => 'hand-left','value'	=> 'hand-left'),
'hand-right' => array ('label' => 'hand-right','value'	=> 'hand-right'),
'hand-up' => array ('label' => 'hand-up','value'	=> 'hand-up'),
'recycled' => array ('label' => 'recycled','value'	=> 'recycled'),
'redo' => array ('label' => 'redo','value'	=> 'redo'),
'refresh' => array ('label' => 'refresh','value'	=> 'refresh'),
'resize-big' => array ('label' => 'resize-big','value'	=> 'resize-big'),
'resize-big-alt' => array ('label' => 'resize-big-alt','value'	=> 'resize-big-alt'),
'resize-horizontal' => array ('label' => 'resize-horizontal','value'	=> 'resize-horizontal'),
'resize-horizontal-alt' => array ('label' => 'resize-horizontal-alt','value'	=> 'resize-horizontal-alt'),
'resize-small' => array ('label' => 'resize-small','value'	=> 'resize-small'),
'resize-small-alt' => array ('label' => 'resize-small-alt','value'	=> 'resize-small-alt'),
'resize-vertical' => array ('label' => 'resize-vertical','value'	=> 'resize-vertical'),
'resize-vertical-alt' => array ('label' => 'resize-vertical-alt','value'	=> 'resize-vertical-alt'),
'rotate-left' => array ('label' => 'rotate-left','value'	=> 'rotate-left'),
'rotate-right' => array ('label' => 'rotate-right','value'	=> 'rotate-right'),
'undo' => array ('label' => 'undo','value'	=> 'undo'),
'align-center' => array ('label' => 'align-center','value'	=> 'align-center'),
'align-justify' => array ('label' => 'align-justify','value'	=> 'align-justify'),
'align-left' => array ('label' => 'align-left','value'	=> 'align-left'),
'align-right' => array ('label' => 'align-right','value'	=> 'align-right'),
'bold' => array ('label' => 'bold','value'	=> 'bold'),
'columns' => array ('label' => 'columns','value'	=> 'columns'),
'font' => array ('label' => 'font','value'	=> 'font'),
'italic' => array ('label' => 'italic','value'	=> 'italic'),
'list' => array ('label' => 'list','value'	=> 'list'),
'list-ol' => array ('label' => 'list-ol','value'	=> 'list-ol'),
'list-ul' => array ('label' => 'list-ul','value'	=> 'list-ul'),
'table' => array ('label' => 'table','value'	=> 'table'),
'underline' => array ('label' => 'underline','value'	=> 'underline'),
'video-play' => array ('label' => 'video-play','value'	=> 'video-play'),
'video-play-alt' => array ('label' => 'video-play-alt','value'	=> 'video-play-alt'),
'video-stop' => array ('label' => 'video-stop','value'	=> 'video-stop'),
'video-pause' => array ('label' => 'video-pause','value'	=> 'video-pause'),
'video-eject' => array ('label' => 'video-eject','value'	=> 'video-eject'),
'video-backward' => array ('label' => 'video-backward','value'	=> 'video-backward'),
'video-step-backward' => array ('label' => 'video-step-backward','value'	=> 'video-step-backward'),
'video-fast-backward' => array ('label' => 'video-fast-backward','value'	=> 'video-fast-backward'),
'video-forward' => array ('label' => 'video-forward','value'	=> 'video-forward'),
'video-step-forward' => array ('label' => 'video-step-forward','value'	=> 'video-step-forward'),
'video-fast-forward' => array ('label' => 'video-fast-forward','value'	=> 'video-fast-forward'),
'screen-full' => array ('label' => 'screen-full','value'	=> 'screen-full'),
'screen-full-alt' => array ('label' => 'screen-full-alt','value'	=> 'screen-full-alt'),
'screen-small' => array ('label' => 'screen-small','value'	=> 'screen-small'),
'screen-small-alt' => array ('label' => 'screen-small-alt','value'	=> 'screen-small-alt'),
'speaker' => array ('label' => 'speaker','value'	=> 'speaker'),
'facebook' => array ('label' => 'facebook','value'	=> 'facebook'),
'facebook-alt' => array ('label' => 'facebook-alt','value'	=> 'facebook-alt'),
'flickr' => array ('label' => 'flickr','value'	=> 'flickr'),
'flickr-alt' => array ('label' => 'flickr-alt','value'	=> 'flickr-alt'),
'google-plus' => array ('label' => 'google-plus','value'	=> 'google-plus'),
'google-plus-alt' => array ('label' => 'google-plus-alt','value'	=> 'google-plus-alt'),
'linkedin' => array ('label' => 'linkedin','value'	=> 'linkedin'),
'linkedin-alt' => array ('label' => 'linkedin-alt','value'	=> 'linkedin-alt'),
'pinterest' => array ('label' => 'pinterest','value'	=> 'pinterest'),
'pinterest-alt' => array ('label' => 'pinterest-alt','value'	=> 'pinterest-alt'),
'rss' => array ('label' => 'rss','value'	=> 'rss'),
'skype' => array ('label' => 'skype','value'	=> 'skype'),
'twitter' => array ('label' => 'twitter','value'	=> 'twitter'),
'twitter-alt' => array ('label' => 'twitter-alt','value'	=> 'twitter-alt'),
'wordpress' => array ('label' => 'wordpress','value'	=> 'wordpress'),
'wordpress-alt' => array ('label' => 'wordpress-alt','value'	=> 'wordpress-alt'),
'youtube' => array ('label' => 'youtube','value'	=> 'youtube'),
'android' => array ('label' => 'android','value'	=> 'android'),
'ios' => array ('label' => 'ios','value'	=> 'ios'),
'windows' => array ('label' => 'windows','value'	=> 'windows'),
'windows8' => array ('label' => 'windows8','value'	=> 'windows8'),
'chrome' => array ('label' => 'chrome','value'	=> 'chrome'),
'firefox' => array ('label' => 'firefox','value'	=> 'firefox'),
'ie' => array ('label' => 'ie','value'	=> 'ie'),
'safari' => array ('label' => 'safari','value'	=> 'safari'),
'bootstrap' => array ('label' => 'bootstrap','value'	=> 'bootstrap'),
'jquery' => array ('label' => 'jquery','value'	=> 'jquery'),
'raphael' => array ('label' => 'raphael','value'	=> 'raphael'),
'paypal' => array ('label' => 'paypal','value'	=> 'paypal'),
'livicon' => array ('label' => 'livicon','value'	=> 'livicon'),
'spinner-one' => array ('label' => 'spinner-one','value'	=> 'spinner-one'),
'spinner-two' => array ('label' => 'spinner-two','value'	=> 'spinner-two'),
'spinner-three' => array ('label' => 'spinner-three','value'	=> 'spinner-three'),
'spinner-four' => array ('label' => 'spinner-four','value'	=> 'spinner-four'),
'spinner-five' => array ('label' => 'spinner-five','value'	=> 'spinner-five'),
'spinner-six' => array ('label' => 'spinner-six','value'	=> 'spinner-six'),
'spinner-seven' => array ('label' => 'spinner-seven','value'	=> 'spinner-seven')
		)
	)
);



// add some custom js to the head of the page
add_action('admin_head','add_front_tabs_scripts');
function add_front_tabs_scripts() {
	global $front_tabs_meta_fields, $post, $pagenow;
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
	
	$output = '<script type="text/javascript">
				jQuery(function() {';
	
	foreach ($front_tabs_meta_fields as $field) { // loop through the fields looking for certain types
		// date
		if($field['type'] == 'date')
			$output .= 'jQuery(".datepicker").datepicker();';
		// slider
		if ($field['type'] == 'slider') {
			$value = get_post_meta($post->ID, $field['id'], true);
			if ($value == '') $value = $field['min'];
			$output .= '
					jQuery( "#'.$field['id'].'-slider" ).slider({
						value: '.$value.',
						min: '.$field['min'].',
						max: '.$field['max'].',
						step: '.$field['step'].',
						slide: function( event, ui ) {
							jQuery( "#'.$field['id'].'" ).val( ui.value );
						}
					});';
		}
	}
	
	$output .= '});
		</script>';
		
	echo $output;
	}
}

// The Callback
function show_front_tabs_meta_box() {
	global $front_tabs_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="front_tabs_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($front_tabs_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1
					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '0';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						$image = get_template_directory_uri().'/images/image.png';	
						echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }				
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
					// wp_editor
					case 'wp_editor':
					$value = $meta != '' ? $meta : '0';
						wp_editor( $value, $field['id'], array( 'textarea_rows' => '5' ) );
						echo '<br /><span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_front_tabs_meta($post_id) {
    global $front_tabs_meta_fields;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['front_tabs_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($front_tabs_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach
	
	// save taxonomies
	#$post = get_post($post_id);
	#$category = $_POST['category'];
	#wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_front_tabs_meta');

?>