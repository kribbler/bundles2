<?php

function meta_block_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'icon' => '',
      'icon_color' => '',
      'url' => '',
      'url_target' => '',
   ), $atts ) );
 
   $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
   $icon_symbol = '';
   
   if($icon!=""){
	   $icon_classes = 'halflings lpd-halflings-icon '.$icon;
	   $icon_symbol = "<i class='".$icon_classes."' style='color:".$icon_color."'></i>";
   }
   if($content){
	   $sep_border = '<div class="sep-border"></div>';
   }
   
	if(!$url){
		return '<div class="meta-block"><h4>'.$icon_symbol.''.$title.'</h4>'.$sep_border.'<span class="meta-block-content">'.$content.'</span></div>';
	} else{
		return '<a href="'.$url.'" target="'.$url_target.'" class="meta-block"><h4>'.$icon_symbol.''.$title.'</h4>'.$sep_border.'<span class="meta-block-content">'.$content.'</span></a>';
	}
    
}
add_shortcode( 'vc_meta_block', 'meta_block_func' );

vc_map(array(
   "name" => __("Meta Block", GETTEXT_DOMAIN),
   "base" => "vc_meta_block",
   "class" => "",
   "icon" => "icon-wpb-lpd",
   "category" => __('Content', GETTEXT_DOMAIN),
   'admin_enqueue_js' => "",
   'admin_enqueue_css' => array(get_template_directory_uri().'/functions/vc/assets/vc_extend.css'),
   "params" => array(
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", GETTEXT_DOMAIN),
			 "param_name" => "title",
			 "value" => "Lorem ipsum dolor",
			 "description" => __("Enter your title.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon", GETTEXT_DOMAIN),
			"param_name" => "icon",
			"value" => array(
			__('none', GETTEXT_DOMAIN) => "",
__('glass', GETTEXT_DOMAIN) => "glass",
__('music', GETTEXT_DOMAIN) => "music",
__('search', GETTEXT_DOMAIN) => "search",
__('envelope', GETTEXT_DOMAIN) => "envelope",
__('heart', GETTEXT_DOMAIN) => "heart",
__('star', GETTEXT_DOMAIN) => "star",
__('star-empty', GETTEXT_DOMAIN) => "star-empty",
__('user', GETTEXT_DOMAIN) => "user",
__('film', GETTEXT_DOMAIN) => "film",
__('th-large', GETTEXT_DOMAIN) => "th-large",
__('th', GETTEXT_DOMAIN) => "th",
__('th-list', GETTEXT_DOMAIN) => "th-list",
__('ok', GETTEXT_DOMAIN) => "ok",
__('remove', GETTEXT_DOMAIN) => "remove",
__('zoom-in', GETTEXT_DOMAIN) => "zoom-in",
__('zoom-out', GETTEXT_DOMAIN) => "zoom-out",
__('off', GETTEXT_DOMAIN) => "off",
__('signal', GETTEXT_DOMAIN) => "signal",
__('cog', GETTEXT_DOMAIN) => "cog",
__('trash', GETTEXT_DOMAIN) => "trash",
__('home', GETTEXT_DOMAIN) => "home",
__('file', GETTEXT_DOMAIN) => "file",
__('time', GETTEXT_DOMAIN) => "time",
__('road', GETTEXT_DOMAIN) => "road",
__('download-alt', GETTEXT_DOMAIN) => "download-alt",
__('download', GETTEXT_DOMAIN) => "download",
__('upload', GETTEXT_DOMAIN) => "upload",
__('inbox', GETTEXT_DOMAIN) => "inbox",
__('play-circle', GETTEXT_DOMAIN) => "play-circle",
__('repeat', GETTEXT_DOMAIN) => "repeat",
__('refresh', GETTEXT_DOMAIN) => "refresh",
__('list-alt', GETTEXT_DOMAIN) => "list-alt",
__('lock', GETTEXT_DOMAIN) => "lock",
__('flag', GETTEXT_DOMAIN) => "flag",
__('headphones', GETTEXT_DOMAIN) => "headphones",
__('volume-off', GETTEXT_DOMAIN) => "volume-off",
__('volume-down', GETTEXT_DOMAIN) => "volume-down",
__('volume-up', GETTEXT_DOMAIN) => "volume-up",
__('qrcode', GETTEXT_DOMAIN) => "qrcode",
__('barcode', GETTEXT_DOMAIN) => "barcode",
__('tag', GETTEXT_DOMAIN) => "tag",
__('tags', GETTEXT_DOMAIN) => "tags",
__('book', GETTEXT_DOMAIN) => "book",
__('bookmark', GETTEXT_DOMAIN) => "bookmark",
__('print', GETTEXT_DOMAIN) => "print",
__('camera', GETTEXT_DOMAIN) => "camera",
__('font', GETTEXT_DOMAIN) => "font",
__('bold', GETTEXT_DOMAIN) => "bold",
__('italic', GETTEXT_DOMAIN) => "italic",
__('text-height', GETTEXT_DOMAIN) => "text-height",
__('text-width', GETTEXT_DOMAIN) => "text-width",
__('align-left', GETTEXT_DOMAIN) => "align-left",
__('align-center', GETTEXT_DOMAIN) => "align-center",
__('align-right', GETTEXT_DOMAIN) => "align-right",
__('align-justify', GETTEXT_DOMAIN) => "align-justify",
__('list', GETTEXT_DOMAIN) => "list",
__('indent-left', GETTEXT_DOMAIN) => "indent-left",
__('indent-right', GETTEXT_DOMAIN) => "indent-right",
__('facetime-video', GETTEXT_DOMAIN) => "facetime-video",
__('picture', GETTEXT_DOMAIN) => "picture",
__('pencil', GETTEXT_DOMAIN) => "pencil",
__('map-marker', GETTEXT_DOMAIN) => "map-marker",
__('adjust', GETTEXT_DOMAIN) => "adjust",
__('tint', GETTEXT_DOMAIN) => "tint",
__('edit', GETTEXT_DOMAIN) => "edit",
__('share', GETTEXT_DOMAIN) => "share",
__('check', GETTEXT_DOMAIN) => "check",
__('move', GETTEXT_DOMAIN) => "move",
__('step-backward', GETTEXT_DOMAIN) => "step-backward",
__('fast-backward', GETTEXT_DOMAIN) => "fast-backward",
__('backward', GETTEXT_DOMAIN) => "backward",
__('play', GETTEXT_DOMAIN) => "play",
__('pause', GETTEXT_DOMAIN) => "pause",
__('stop', GETTEXT_DOMAIN) => "stop",
__('forward', GETTEXT_DOMAIN) => "forward",
__('fast-forward', GETTEXT_DOMAIN) => "fast-forward",
__('step-forward', GETTEXT_DOMAIN) => "step-forward",
__('eject', GETTEXT_DOMAIN) => "eject",
__('chevron-left', GETTEXT_DOMAIN) => "chevron-left",
__('chevron-right', GETTEXT_DOMAIN) => "chevron-right",
__('plus-sign', GETTEXT_DOMAIN) => "plus-sign",
__('minus-sign', GETTEXT_DOMAIN) => "minus-sign",
__('remove-sign', GETTEXT_DOMAIN) => "remove-sign",
__('ok-sign', GETTEXT_DOMAIN) => "ok-sign",
__('question-sign', GETTEXT_DOMAIN) => "question-sign",
__('info-sign', GETTEXT_DOMAIN) => "info-sign",
__('screenshot', GETTEXT_DOMAIN) => "screenshot",
__('remove-circle', GETTEXT_DOMAIN) => "remove-circle",
__('ok-circle', GETTEXT_DOMAIN) => "ok-circle",
__('ban-circle', GETTEXT_DOMAIN) => "ban-circle",
__('arrow-left', GETTEXT_DOMAIN) => "arrow-left",
__('arrow-right', GETTEXT_DOMAIN) => "arrow-right",
__('arrow-up', GETTEXT_DOMAIN) => "arrow-up",
__('arrow-down', GETTEXT_DOMAIN) => "arrow-down",
__('share-alt', GETTEXT_DOMAIN) => "share-alt",
__('resize-full', GETTEXT_DOMAIN) => "resize-full",
__('resize-small', GETTEXT_DOMAIN) => "resize-small",
__('plus', GETTEXT_DOMAIN) => "plus",
__('minus', GETTEXT_DOMAIN) => "minus",
__('asterisk', GETTEXT_DOMAIN) => "asterisk",
__('exclamation-sign', GETTEXT_DOMAIN) => "exclamation-sign",
__('gift', GETTEXT_DOMAIN) => "gift",
__('leaf', GETTEXT_DOMAIN) => "leaf",
__('fire', GETTEXT_DOMAIN) => "fire",
__('eye-open', GETTEXT_DOMAIN) => "eye-open",
__('eye-close', GETTEXT_DOMAIN) => "eye-close",
__('warning-sign', GETTEXT_DOMAIN) => "warning-sign",
__('plane', GETTEXT_DOMAIN) => "plane",
__('calendar', GETTEXT_DOMAIN) => "calendar",
__('random', GETTEXT_DOMAIN) => "random",
__('comments', GETTEXT_DOMAIN) => "comments",
__('magnet', GETTEXT_DOMAIN) => "magnet",
__('chevron-up', GETTEXT_DOMAIN) => "chevron-up",
__('chevron-down', GETTEXT_DOMAIN) => "chevron-down",
__('retweet', GETTEXT_DOMAIN) => "retweet",
__('shopping-cart', GETTEXT_DOMAIN) => "shopping-cart",
__('folder-close', GETTEXT_DOMAIN) => "folder-close",
__('folder-open', GETTEXT_DOMAIN) => "folder-open",
__('resize-vertical', GETTEXT_DOMAIN) => "resize-vertical",
__('resize-horizontal', GETTEXT_DOMAIN) => "resize-horizontal",
__('hdd', GETTEXT_DOMAIN) => "hdd",
__('bullhorn', GETTEXT_DOMAIN) => "bullhorn",
__('bell', GETTEXT_DOMAIN) => "bell",
__('certificate', GETTEXT_DOMAIN) => "certificate",
__('thumbs-up', GETTEXT_DOMAIN) => "thumbs-up",
__('thumbs-down', GETTEXT_DOMAIN) => "thumbs-down",
__('hand-right', GETTEXT_DOMAIN) => "hand-right",
__('hand-left', GETTEXT_DOMAIN) => "hand-left",
__('hand-top', GETTEXT_DOMAIN) => "hand-top",
__('hand-down', GETTEXT_DOMAIN) => "hand-down",
__('circle-arrow-right', GETTEXT_DOMAIN) => "circle-arrow-right",
__('circle-arrow-left', GETTEXT_DOMAIN) => "circle-arrow-left",
__('circle-arrow-top', GETTEXT_DOMAIN) => "circle-arrow-top",
__('circle-arrow-down', GETTEXT_DOMAIN) => "circle-arrow-down",
__('globe', GETTEXT_DOMAIN) => "globe",
__('wrench', GETTEXT_DOMAIN) => "wrench",
__('filter', GETTEXT_DOMAIN) => "filter",
__('filter', GETTEXT_DOMAIN) => "filter",
__('briefcase', GETTEXT_DOMAIN) => "briefcase",
__('fullscreen', GETTEXT_DOMAIN) => "fullscreen",
__('dashboard', GETTEXT_DOMAIN) => "dashboard",
__('paperclip', GETTEXT_DOMAIN) => "paperclip",
__('heart-empty', GETTEXT_DOMAIN) => "heart-empty",
__('link', GETTEXT_DOMAIN) => "link",
__('phone', GETTEXT_DOMAIN) => "phone",
__('pushpin', GETTEXT_DOMAIN) => "pushpin",
__('euro', GETTEXT_DOMAIN) => "euro",
__('usd', GETTEXT_DOMAIN) => "usd",
__('gbp', GETTEXT_DOMAIN) => "gbp",
__('sort', GETTEXT_DOMAIN) => "sort",
__('sort-by-alphabet', GETTEXT_DOMAIN) => "sort-by-alphabet",
__('sort-by-alphabet-alt', GETTEXT_DOMAIN) => "sort-by-alphabet-alt",
__('sort-by-order', GETTEXT_DOMAIN) => "sort-by-order",
__('sort-by-order-alt', GETTEXT_DOMAIN) => "sort-by-order-alt",
__('sort-by-attributes', GETTEXT_DOMAIN) => "sort-by-attributes",
__('sort-by-attributes-alt', GETTEXT_DOMAIN) => "sort-by-attributes-alt",
__('unchecked', GETTEXT_DOMAIN) => "unchecked",
__('expand', GETTEXT_DOMAIN) => "expand",
__('collapse1', GETTEXT_DOMAIN) => "collapse1",
__('collapse-top', GETTEXT_DOMAIN) => "collapse-top",
__('log_in', GETTEXT_DOMAIN) => "log_in",
__('flash', GETTEXT_DOMAIN) => "flash",
__('log_out', GETTEXT_DOMAIN) => "log_out",
__('new_window', GETTEXT_DOMAIN) => "new_window",
__('record', GETTEXT_DOMAIN) => "record",
__('save', GETTEXT_DOMAIN) => "save",
__('open', GETTEXT_DOMAIN) => "open",
__('saved', GETTEXT_DOMAIN) => "saved",
__('import', GETTEXT_DOMAIN) => "import",
__('export', GETTEXT_DOMAIN) => "export",
__('send', GETTEXT_DOMAIN) => "send",
__('floppy_disk', GETTEXT_DOMAIN) => "floppy_disk",
__('floppy_saved', GETTEXT_DOMAIN) => "floppy_saved",
__('floppy_remove', GETTEXT_DOMAIN) => "floppy_remove",
__('floppy_save', GETTEXT_DOMAIN) => "floppy_save",
__('floppy_open', GETTEXT_DOMAIN) => "floppy_open",
__('credit_card', GETTEXT_DOMAIN) => "credit_card",
__('transfer', GETTEXT_DOMAIN) => "transfer",
__('cutlery', GETTEXT_DOMAIN) => "cutlery",
__('header', GETTEXT_DOMAIN) => "header",
__('compressed', GETTEXT_DOMAIN) => "compressed",
__('earphone', GETTEXT_DOMAIN) => "earphone",
__('phone_alt', GETTEXT_DOMAIN) => "phone_alt",
__('tower', GETTEXT_DOMAIN) => "tower",
__('stats', GETTEXT_DOMAIN) => "stats",
__('sd_video', GETTEXT_DOMAIN) => "sd_video",
__('hd_video', GETTEXT_DOMAIN) => "hd_video",
__('subtitles', GETTEXT_DOMAIN) => "subtitles",
__('sound_stereo', GETTEXT_DOMAIN) => "sound_stereo",
__('sound_dolby', GETTEXT_DOMAIN) => "sound_dolby",
__('sound_5_1', GETTEXT_DOMAIN) => "sound_5_1",
__('sound_6_1', GETTEXT_DOMAIN) => "sound_6_1",
__('sound_7_1', GETTEXT_DOMAIN) => "sound_7_1",
__('copyright_mark', GETTEXT_DOMAIN) => "copyright_mark",
__('registration_mark', GETTEXT_DOMAIN) => "registration_mark",
__('cloud', GETTEXT_DOMAIN) => "cloud",
__('loud_download', GETTEXT_DOMAIN) => "cloud_download",
__('cloud_upload', GETTEXT_DOMAIN) => "cloud_upload",
__('tree_conifer', GETTEXT_DOMAIN) => "tree_conifer",
__('tree_deciduous', GETTEXT_DOMAIN) => "tree_deciduous",
			),
			"description" => __("Select icon.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Icon color", GETTEXT_DOMAIN),
			"param_name" => "icon_color",
			"value" => '#555',
			"description" => __("Choose icon color.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", GETTEXT_DOMAIN),
			 "param_name" => "content",
			 "value" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent mattis purus vitae imperdiet suscipit.",
			 "description" => __("Enter your content.", GETTEXT_DOMAIN)
		),
		array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Url", GETTEXT_DOMAIN),
			 "param_name" => "url",
			 "value" => '',
			 "description" => __("Enter your url.", GETTEXT_DOMAIN)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Link Target", GETTEXT_DOMAIN),
			"param_name" => "url_target",
			"value" => array(
				"_blank" => "_blank",
				"_self" => "_self",
				"_parent" => "_parent",
				'_top' => "_top",
			),
			"description" => __("Select link target attribute.", GETTEXT_DOMAIN)
		),

   )
));

?>