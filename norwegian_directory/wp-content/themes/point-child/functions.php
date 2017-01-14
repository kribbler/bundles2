<?php

function get_site_thumb($id){
	$url = get_post_meta( $id, 'url' );
	$url = $url[0];
	$url = str_replace("://", "_", $url);
	$url = str_replace("/", "_", $url);
	
	$url = str_replace("tt?tt", "tt_tt", $url);
	$url = str_replace(".php?tt=", ".php_tt=", $url);

	$url = str_replace("?", "", $url);
	$url = str_replace("&", "_", $url);
	$url = str_replace("=", "_", $url);

	//$url = str_replace(".php_", ".php", $url);
	//$url = str_replace("http_belysning1.no_trade_tracker.phptt_13156_471352_197855_", "http_belysning1.no_trade_tracker.php_tt_13156_471352_197855_", $url);

	$upload_dir = wp_upload_dir();
	$image_png = $upload_dir['baseurl'] . '/sites/' . $url . '.png';
	$image_jpg = $upload_dir['baseurl'] . '/sites/' . $url . '.jpg';
	$image_JPG = $upload_dir['baseurl'] . '/sites/' . $url . '.JPG';

	if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
		//echo "<pre>"; var_dump($url); echo "</pre>";
	}
	if (is_webfile($image_png)){
		return $image_png;
	} else if (is_webfile($image_jpg)){
		return $image_jpg;
	} else if (is_webfile($image_JPG)){
		return $image_JPG;
	} else 
		return get_stylesheet_directory_uri() . '/images/no-preview.png';
}
/*
http://mappen.no/wp-content/uploads/sites/http_belysning1.no_trade_tracker.phptt_13156_471352_197855_.png"
http://mappen.no/wp-content/uploads/sites/http_belysning1.no_trade_tracker.phptt_13156_471352_197855_.jpg"
http://mappen.no/wp-content/uploads/sites/http_belysning1.no_trade_tracker.phptt_13156_471352_197855_.JPG"
http://mappen.no/wp-content/uploads/sites/http_belysning1.no_trade_tracker.php_tt_13156_471352_197855_.jpg
http://mappen.no/wp-content/uploads/sites/http_belysning1.no_trade_tracker.phptt_13156_471352_197855_.jpg
                                          http_belysning1.no_trade_tracker.php_tt_13156_471352_197855_.jpg
*/

function get_site_thumb2($id){
	$url = get_post_meta( $id, 'url' );
	$url = $url[0];
	echo "<pre>";var_dump($url);echo "</pre>";
	$url = str_replace("://", "_", $url);
	$url = str_replace("/", "_", $url);
	$url = str_replace("?", "", $url);
	$url = str_replace("&", "_", $url);
	$url = str_replace("=", "_", $url);
	$url = str_replace("http_belysning1.no_trade_tracker.phptt_13156_471352_197855_", "http_belysning1.no_trade_tracker.php_tt_13156_471352_197855_", $url);

	$upload_dir = wp_upload_dir();
	$image_png = $upload_dir['baseurl'] . '/sites/' . $url . '.png';
	$image_jpg = $upload_dir['baseurl'] . '/sites/' . $url . '.jpg';
	$image_JPG = $upload_dir['baseurl'] . '/sites/' . $url . '.JPG';
	echo "<pre>";
	var_dump($url);
	var_dump($image_png);
	var_dump($image_jpg);
	var_dump($image_JPG);
	var_dump(is_webfile($image_jpg));
	echo "</pre>";
	if (is_webfile($image_png)){
		return $image_png;
	} else if (is_webfile($image_jpg)){
		return $image_jpg;
	} else if (is_webfile($image_JPG)){
		return $image_JPG;
	} else 
		return get_stylesheet_directory_uri() . '/images/no-preview.png';
}
//                                          http_tc.tradetracker.net_c_10401m=381576&a=197855
//http://mappen.no/wp-content/uploads/sites/http_tc.tradetracker.net_c_10401_m_381576_a_197855.png
//http://mappen.no/wp-content/uploads/sites/http_tc.tradetracker.net_c_10401_m_381576_a_197855.png

function is_webfile($webfile){
	$fp = @fopen($webfile, "r");
	if ($fp !== false)
 		fclose($fp);
	
	return($fp);
}

function set_categories(){
	$args = array(
		'type'                     => 'post',
		'child_of'                 => 0,
		'parent'                   => 0,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'taxonomy'                 => 'category',
		'pad_counts'               => true 
	); 

	$categories = get_categories( $args );
	$i = 0;
	foreach ($categories as $category){
		$clear_div = ($i++%2 == 0) ? "clear" : "";
		echo "<div class='home_category $clear_div' id='logo_".$category->slug."'>";
		echo "<div class='home_cat_inside'>";
			//echo "<h1><a href='" . $category->slug ."' title='" . $category->name ."' rel='bookmark'>" . $category->name . "</a> (" . $category->count . ")</h1>";
		echo "<h1><a href='" . $category->slug ."' title='" . $category->name ."' rel='bookmark'>" . $category->name . "</a></h1>";
			$args = array(
				'type'                     => 'post',
				//'child_of'                 => $category->term_id,
				'parent'                   => $category->term_id,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'taxonomy'                 => 'category',
				'pad_counts'               => true,
				'number'					=> 5
			); 

			$subcategories = get_categories($args);
			foreach ($subcategories as $subcategory){
				echo "<h6><a href='" . $category->slug . '/' . $subcategory->slug ."' title='" . $subcategory->name ."' rel='bookmark'>" . $subcategory->name . "</a> (" . $subcategory->count . ")</h6>";
			}
		echo "</div>"; //<div class='home_cat_inside'>
		echo "</div>"; //<div class='home_category'>
	}
	
}

function old_style_name_like_wpse_123298($clauses) {
  remove_filter('term_clauses','old_style_name_like_wpse_123298');
  $pattern = '|(name LIKE )\'%(.+%)\'|';
  $clauses['where'] = preg_replace($pattern,'$1 \'$2\'',$clauses['where']);
  return $clauses;
}
add_filter('terms_clauses','old_style_name_like_wpse_123298');

/** categories crawler **/
add_shortcode( 'crawl_categories', 'crawl_categories' );

function crawl_categories(){
	$args = array(
		'type'                     => 'post',
		//'child_of'                 => 0,
		//'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		//'hide_empty'               => 1,
		'hierarchical'             => 1,
		//'exclude'                  => '',
		//'include'                  => '',
		//'number'                   => '',
		'taxonomy'                 => 'category',
		//'pad_counts'               => false 
	);

	$categories = get_categories( $args );

	$category_links = array();
	foreach ($categories as $category){
		$category_links[] = get_category_link( $category->term_id );
	}

	$nextpage_pattern = "/<li class='current'>(.*?)<\/li>";
	$nextpage_pattern .= "<li><a rel='nofollow' href='(.*?)' class='inactive'>(.*?)<\/a>";
	$nextpage_pattern .= "<\/li>";
	$nextpage_pattern .= "/s";

	reset_log();
	set_time_limit(0);
	foreach ($category_links as $link){
		curl($link, $nextpage_pattern);
		//die('end');
	}
	//pr($category_links);
}

function curl($link, $nextpage_pattern){
	logtofile($link);
	
	$ch = curl_init($link);
        curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_REFERER,$master_url);
        curl_setopt($ch,CURLOPT_TIMEOUT,30);		
    $output = curl_exec($ch);
    //echo $output; die();

    preg_match_all(
            $nextpage_pattern,
            $output,
            $matches,
            PREG_SET_ORDER
    );

    if ($matches){
    	curl($matches[0][2], $nextpage_pattern);
    }
}

function logtofile($link){
	echo 'the link - ' . $link . '<br />';
	$UploadDir = wp_upload_dir();
	$UploadURL = $UploadDir['basedir'];
	$myFile = $UploadURL . "/log_links.log";
	$fh = fopen($myFile, 'a') or die("can't open file");
	$stringData = $link . "\n";
	fwrite($fh, $stringData);
	fclose($fh);
}

function reset_log(){
	$UploadDir = wp_upload_dir();
	$UploadURL = $UploadDir['basedir'];
	$myFile = $UploadURL . "/log_links.log";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $stringData);
	fclose($fh); 
}
function pr($s){
	echo "<pre>"; var_dump($s); echo "</pre>";
}

add_action('wp_head','ajaxurl');
function ajaxurl() { ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php }

/** initiate report - when questionnaire is started **/
/** start ajaxing the questions **/
add_action('wp_ajax_initiateReport', 'initiateReport');
add_action('wp_ajax_nopriv_initiateReport', 'initiateReport');

function initiateScrap() {
    reset_log();
    $args = array(
		'type'                     => 'post',
		//'child_of'                 => 0,
		//'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		//'hide_empty'               => 1,
		'hierarchical'             => 1,
		//'exclude'                  => '',
		//'include'                  => '',
		//'number'                   => '',
		'taxonomy'                 => 'category',
		//'pad_counts'               => false 
	);

	$categories = get_categories( $args );

	$category_links = array();
	foreach ($categories as $category){
		$category_links[] = get_category_link( $category->term_id );
	}
	return $category_links;
}

add_action('wp_ajax_curling', 'curling');
add_action('wp_ajax_nopriv_curling', 'curling');

function curling(){
	$links = initiateScrap();
	echo json_encode($links);
	die();
}

add_action('wp_ajax_continuous_scrap', 'continuous_scrap');
add_action('wp_ajax_nopriv_continuous_scrap', 'continuous_scrap');

function continuous_scrap($link){
	$nextpage_pattern = "/<li class='current'>(.*?)<\/li>";
	$nextpage_pattern .= "<li><a rel='nofollow' href='(.*?)' class='inactive'>(.*?)<\/a>";
	$nextpage_pattern .= "<\/li>";
	$nextpage_pattern .= "/s";
	//echo 'the clink'. $_POST['link'];
	curl($_POST['link'], $nextpage_pattern);

	die();
}