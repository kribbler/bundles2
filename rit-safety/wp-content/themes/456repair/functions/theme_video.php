<?php
function lpd_parse_video($path){
	$parsedUrl  = parse_url($path);
	
	if(strpos($path, "youtube.com")){
		// for youtube  
	    $embed	= $parsedUrl['query'];  
	    parse_str($embed, $out);  
	    $embedUrl   = $out['v']; 
	    return  "http://www.youtube.com/embed/$embedUrl"; 
	}
	
	if(strpos($path, "vimeo.com")){
		// for vimeo
		$embed	= $parsedUrl['path'];
		return "http://player.vimeo.com/video$embed";
	}
}
function lpd_parse_video_thumb($path){
	$parsedUrl  = parse_url($path);
	
	if(strpos($path, "youtube.com")){
		// for youtube  
	    $embed	= $parsedUrl['query'];  
	    parse_str($embed, $out);  
	    $embedUrl   = $out['v']; 
	    return  "http://img.youtube.com/vi/$embedUrl/0.jpg"; 
	}
}
function lpd_parse_video_yt_id($path){
	$parsedUrl  = parse_url($path);
	
	if(strpos($path, "youtube.com")){
		// for youtube  
	    $embed	= $parsedUrl['query'];  
	    parse_str($embed, $out);  
	    $embedUrl   = $out['v']; 
	    return  "$embedUrl"; 
	}
	
}
function lpd_parse_video_vimeo_id($path){
	$parsedUrl  = parse_url($path);
	
	if(strpos($path, "vimeo.com")){
		// for vimeo
		$embed	= $parsedUrl['path'];
		return "$embed";
	}
	
}
?>