<?php

	// Set your return content type
	header('Content-type: text/xml');

	$mediaArr = array();

    // allowed extensions
    $allowed_files = array('mp3');

    //directory to read
    $dir = ($_REQUEST['folderUrl']);

	if(file_exists($dir)==false){
		echo 'Directory \'', $dir, '\' not found!';
	}else{
	
		$di = new RecursiveDirectoryIterator($dir);
		foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
			$file_type = explode(".", $filename);
			$extension = strtolower(array_pop($file_type));
			if(in_array($extension, $allowed_files) == true){
				$mediaArr[] = $filename;
			}
		}
		echo json_encode($mediaArr);
	}
?>
