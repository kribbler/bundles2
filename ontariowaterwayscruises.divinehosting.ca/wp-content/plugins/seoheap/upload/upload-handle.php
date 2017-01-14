<?php
// TODO: Put in way to choose one from library, create a function to get the full filename, if it's without / then don't use directory
// TODO: Put in way to put in a url, and if your using the new function uploadfilename('the filename','default path');
$uploaded=false;
$err='';
if (isset($_FILES['image'])) {

	if (isset($enc['name'],$enc['id'],$enc['dir'])) {
		$a=$_FILES['image'];
		$friendly=basename($a['name']);
		$filetype='';
		if (preg_match('#^(.*?)\.([^\.]+)$#',$friendly,$r)) {
			$friendly=$r[1];
			$filetype=strtolower($r[2]);
		}
		if ($filetype=='jpeg')
			$filetype='jpg';
		$ft=(isset($enc['filetype'])) ? explode(',',$enc['filetype']) : array();
		if (empty($ft) || in_array($filetype,$ft)) {
			$filename=preg_replace('#[_ \t]+#','-',strtolower($friendly));
			$filename=trim(uniqid().'-'.(preg_replace('#[^a-z0-9\.!\-]+#','.',$filename)),'-.');
			if ($filetype)
				$filename.='.'.$filetype;
			$friendly=ucwords(preg_replace('#[\-_]+#',' ',$friendly));
			$enc['dir']=trim($enc['dir'],'\\\\/.');
			$enc['dir']=($enc['dir']) ? '/'.$enc['dir'].'/' : '/';
			@mkdir(ABSPATH.$enc['dir'],0755,true);
			if (move_uploaded_file($a['tmp_name'],ABSPATH.$enc['dir'].$filename)) {
				$uploaded=$enc;
				$uploaded['image']=$filename;
				$uploaded['filetype']=$filetype;
				$uploaded['friendly']=$friendly;
				
				if (!empty($enc['meta']) && $filetype=='jpg' && function_exists('exif_read_data')) {
					$uploaded['meta']=exif_read_data(ABSPATH.$enc['dir'].$filename);
				} elseif (!empty($enc['meta'])) {
					$uploaded['meta']=array();
					$uploaded['metaerror']=function_exists('exif_read_data') ? '' : 'exif_read_data doesnt exist';
				}
			} else
				$err='Unable to move file';
		} else {
			$err='Invalid filetype';
		}
	} else
		$err='Invalid Data';
}
if (reqi('is_flash')) {
	if (!$uploaded)
		$o=array('error'=>$err);
	else
		$o=$uploaded;
	die(json_encode($o)); 
}

if ($uploaded)
	jsdata('shuploaded',$uploaded);
