<?php
$frontend='';
$enc=json_decode(decrypt(req('data')),true);
$flashupload=!empty($enc['multi']) && !empty($enc['flashupload']);

plugin('jquery');
if ($flashupload) {
	plugin('jqueryui');
	plugin('uploadify');	
}
wp_enqueue_style('myuploader','/wp-content/plugins/seoheap/upload/upload.css');

jsdata('shroot',rtrim(home_url(),'/'));
include dirname(__FILE__).'/upload-handle.php';

wp_enqueue_script('myuploader','/wp-content/plugins/seoheap/upload/upload.js');
if ($flashupload) { 
	$img=$enc['flashupload'];
	jsdata('shuploader',array(
		'path'=>uploadifypath(),
		'uploader'=>home_url().$frontend.'index.php?seoheap=upload',
		'data'=>req('data'),
		'limit'=>is_numeric($enc['multi']) ? $enc['multi'] : false,
		'frontendimg'=>!$frontend && !empty($img),
		'img'=>$img,
		'filetype'=>empty($enc['filetype']) ? '' : $enc['filetype']
	));
}

wp_head();
?>
<body>
<div id="progress">
<div></div><div class="total"></div>
</div>
<form method="post" action="<?php echo home_url().$frontend; ?>/index.php?seoheap=uploadframe" enctype="multipart/form-data">
<input type="hidden" name="data" value="<?php echo htmlq(req('data')); ?>"/>
<?php if ($err) { ?>
	<table>
	<tr><td>
	<div class="error" title="<?php echo htmlq($err); ?>">Error</div>';
	</td><td>
<?php } ?>
<input type="file" name="image" onChange="this.form.submit()"<?php echo ((!empty($enc['multi'])) ? ' id="uploadify"' : ''),((!empty($enc['style'])) ? ' style="'.htmlq($enc['style']).'"' : ''); ?>/>
<?php
if ($frontend) {
	echo '<span> or <a href="#" id="choose" data-enc="',htmlq(json_encode($enc)),'">Media Library</a></span>';
}
?>
<?php if ($err) { ?>
</td></tr>
</table>
<?php } ?>
</form>
</body>
<?php
wp_footer();