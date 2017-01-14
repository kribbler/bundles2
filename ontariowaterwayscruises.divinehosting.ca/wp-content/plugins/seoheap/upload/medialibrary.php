<?php
plugin('jquery');
plugin('livequery');
plugin('placeholder');
JHTML::script('plugins/system/seoheap/seoheap/classes/upload/medialibrary.js');
JHTML::stylesheet('plugins/system/seoheap/seoheap/classes/upload/medialibrary.css');

$path=trim(req('path'),'/\\');
$types=array_filter(explode(',',strtolower(req('filetypes'))));
$root=JPATH_ROOT.'/';

$rproot=realpath($root);
$rppath=realpath($root.$path.'/');
$ok=true;
if (!$rppath) {
	$ok=false;	
} else {
	if (strpos($rppath,$rproot)===false)
		$path='';
	else
		$path=trim(str_replace('\\','/',str_replace($rproot,'',$rppath)),'/');

	if (substr($path,0,6)!='images')
		$path='images';
}


$get=allget();
$get['path']=$path;
$get['filetypes']=implode(',',$types);
jsdata('get',$get);

ob_start();

$dirs=array();
$files=array();
$fts=array();
echo '<h4 class="path">Path: <span>',$path,'</span></h4>';

$igtypes=array('htaccess','htpasswd');
$igfiles=array('php.ini');

if ($ok && is_dir($root.$path)) {
	$dir=scan_dir($root.$path);
	$dirs=$dir['dirs'];
	foreach ($dir['files'] as $a) {
		$la=strtolower($a);
		if (in_array($la,$igfiles))
			continue;
		$tft=preg_match('#\.([^\.]+)$#',$a,$r) ? strtolower($r[1]) : '';
		$af=preg_replace('#\.([^\.]+)$#','',$a);
		$aff=preg_replace('#^[a-f0-9]{11,}\-#','',$af);
		if ($aff)
			$af=$aff;
		if ($tft=='jpeg')
			$tft='jpeg';
		if (in_array($tft,$igtypes))
			continue;
		$inc=(empty($types)) || in_array($tft,$types);
		if ($inc) {
			$files[]=array(
				'filetype'=>$tft,
				'name'=>$a,
				'friendly'=>$af
			);
		}
	}
}
if (($up=dirname($path)) && $up!='.')
	echo '<a href="#" data-path="',htmlq($up),'" class="up carry">Up</a>';
	
if ($dirs) {
	echo '<ul class="dirs">';
	foreach ($dirs as $a) {
		echo '<li><a href="#" data-path="',htmlq($a),'" class="down">',html($a),'</a></li>';
	}
	echo '</ul>';
}
if ($files) {
	if (count($files)>1) {
		echo '<div class="filter">';
		echo '<input type="text" value="',htmlq(req('filter')),'" placeholder="Filter"/>';
		// TODO: filetype selector, checkboxes
		echo '</div>';	
	}
	echo '<ul class="files">';
	foreach ($files as $a) {
		echo '<li class="ft-',htmlq($a['filetype']),'" data-name="',htmlq($a['name']),'"><span>',$a['friendly'],'</span></li>';
	}
	echo '</ul>';
	echo '<div class="selected"><div>Selected: <input type="text" readonly/> <input type="button" value="Select..." class="btn btn-primary"/></div></div>';
}
$o=ob_get_contents();
ob_end_clean();
$document =& JFactory::getDocument();
$buffer = $document->getBuffer('head');

JResponse::setBody($buffer.'<body>'.$o.'</body>');
$dispatcher =& JDispatcher::getInstance();
$dispatcher->trigger('onAfterRender');
echo JResponse::getBody();