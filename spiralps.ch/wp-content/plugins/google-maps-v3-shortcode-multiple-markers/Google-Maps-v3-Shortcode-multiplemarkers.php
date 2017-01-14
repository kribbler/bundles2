<?php
/*
Plugin Name: Google Maps v3 Shortcode multiple Markers
Description: This plugin allows you to add one or more maps to your page/post using shortcodes, even multiple markers per map! Kudos to yohman for his plugin: http://wordpress.org/extend/plugins/google-maps-v3-shortcode/
Version: 1.0
Author: soundwaves-productions
Plugin URI: http://www.soundwaves-productions.com/soundwavesblog/wordpress-plugins/google-maps-v3-shortcode-multiple-markers/
*/

// Add the google maps api to header
add_action('wp_head', 'MultipleMarkerMap_header');

function MultipleMarkerMap_header() {
	?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<?php
}

// Main function to generate google map
function MultipleMarkerMap_call($attr) {

	// default atts
	$attr = shortcode_atts(array(	
									'lat'   => '0', 
									'lon'    => '0',
									'id' => 'map',
									'z' => '1',
									'w' => '400',
									'h' => '300',
									'maptype' => 'ROADMAP',
									'marker' =>''								
									), $attr);
									
	$returnme = '
    <div id="' .$attr['id'] . '" style="width:' . $attr['w'] . 'px;height:' . $attr['h'] . 'px;border:1px solid gray;"></div><br>
    <script type="text/javascript">
    var infowindow = null;
		var latlng = new google.maps.LatLng(' . $attr['lat'] . ', ' . $attr['lon'] . ');
		var myOptions = {
			zoom: ' . $attr['z'] . ',
			center: latlng,
			mapTypeId: google.maps.MapTypeId.' . $attr['maptype'] . '
		};
		var ' . $attr['id'] . ' = new google.maps.Map(document.getElementById("' . $attr['id'] . '"),
		myOptions);
		';
   $returnme .=' var sites = [';
		//marker: show if address is not specified
		if ($attr['marker'] != '')
		{
			$markers = explode("|",$attr['marker']);
			for($i = 0;$i < count($markers);$i ++)
			{
				$markerTmp=$markers[$i];
				$marker= explode(",",$markerTmp);
					if (count($marker)>3) { 
	  				$markerTmp2 .='['.$marker[0].',' .$marker[1].',\'' . $marker[2] . '\',\'' . $marker[3] . '\'],';
					} else {
	  				$markerTmp2 .='['.$marker[0].',' .$marker[1].',\'' . $marker[2] . '\',null],';
						}
	  	}
	  }
	 $markerTmp2=substr ($markerTmp2,0,strlen ( $markerTmp2 )-1);
	 $returnme .=$markerTmp2;
	 $returnme .='];';
	 $returnme .='
	 ';
	 $returnme .=' for (var i = 0; i < sites.length; i++) {';
	 $returnme .=' var site = sites[i];
	 ';
   $returnme .=' var siteLatLng = new google.maps.LatLng(site[0], site[1]);
   ';
   $returnme .=' if(site[3]!=null) { 
   ';
   $returnme .=' var markerimage  = site[3];
   ';
   $returnme .=' var marker = new google.maps.Marker({
   ';
   $returnme .=' position: siteLatLng,
   ';
   $returnme .= ' map: '. $attr['id'].',
   ';
   $returnme .= ' icon: markerimage,
   ';
   $returnme .= ' html: site[2] });
   '; 
   $returnme .=' } else {
   ';
   $returnme .=' var marker = new google.maps.Marker({
   ';
   $returnme .=' position: siteLatLng,
   ';
   $returnme .= ' map: '. $attr['id'].',
   ';
   $returnme .= ' html: site[2] });
   ';
   $returnme .=' }
   ';
   $returnme .= ' var contentString = "Some content";';
   $returnme .= 'google.maps.event.addListener(marker, "click", function () {
   ';
   $returnme .= 'infowindow.setContent(this.html);
   ';
   $returnme .= ' infowindow.open('.$attr['id'].', this);
   ';
   $returnme .= '});
   ';
   $returnme .= '}
   ';
 	   $returnme .=' infowindow = new google.maps.InfoWindow({
                content: "loading..."
            });
    ';
 	$returnme .= '</script>';
		return $returnme;
	?>
    
    

	<?php
}
add_shortcode('MultipleMarkerMap', 'MultipleMarkerMap_call');


?>