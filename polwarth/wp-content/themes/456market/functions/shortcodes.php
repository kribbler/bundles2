<?php

/* Shortcodes
================================================== */

// This will do nothing but will allow the shortcode to be stripped
add_shortcode( 'foobar', 'shortcode_foobar' );
 
// Actual processing of the shortcode happens here
function foobar_run_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
 
    add_shortcode( 'foobar', 'shortcode_foobar' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
add_filter( 'the_content', 'foobar_run_shortcode', 7 );

/* prettyprint pre +
================================================== */
function pre_clean($content){

    $content = str_ireplace('<br />', '', $content);
    return $content;
}

function prettyprint($atts, $content=null){
	return '<pre class="prettyprint linenums">'.pre_clean($content).'</pre>';
}
add_shortcode('prettyprint', 'prettyprint');

/* headings +
================================================== */
function h1($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h1 '.$Type.'>'.do_shortcode($content).'</h1>';
}
function h2($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h2 '.$Type.'>'.do_shortcode($content).'</h2>';
}
function h3($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h3 '.$Type.'>'.do_shortcode($content).'</h3>';
}
function h4($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h4 '.$Type.'>'.do_shortcode($content).'</h4>';
}
function h5($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h5 '.$Type.'>'.do_shortcode($content).'</h5>';
}
function h6($atts, $content=null){
	extract(shortcode_atts( array( 'type' => '' ), $atts ));
	$Type = '';
	if($type){ $Type = 'class="'.$type.'"';};
	return '<h6 '.$Type.'>'.do_shortcode($content).'</h6>';
}
add_shortcode('h1', 'h1');
add_shortcode('h2', 'h2');
add_shortcode('h3', 'h3');
add_shortcode('h4', 'h4');
add_shortcode('h5', 'h5');
add_shortcode('h6', 'h6');


/* paragraph +
================================================== */
function p($atts, $content=null){
	return '<p>'.do_shortcode($content).'</p>';
}
add_shortcode('p', 'p');


/* address +
================================================== */
function address($atts, $content=null){
	return '<address>'.do_shortcode($content).'</address>';
}
add_shortcode('address', 'address');

/* margin bottom +
================================================== */
function margin_bottom($atts, $content=null){
	return '<div style="margin-bottom: 20px;">'.do_shortcode($content).'</div>';
}
add_shortcode('margin-bottom', 'margin_bottom');

/* strong +
================================================== */
function strong($atts, $content=null){
	return '<strong>'.do_shortcode($content).'</strong>';
}
add_shortcode('strong', 'strong');

/* selected +
================================================== */
function Select($atts, $content=null){
	return '<span class="selected">'.do_shortcode($content).'</span>';
}
add_shortcode('select', 'Select');

/* abbr +
================================================== */
function abbr($atts, $content=null){
	extract(shortcode_atts( array( 
							'title' => 'your title goes here',
							), $atts ));
	return '<abbr title="'.$title.'">'.do_shortcode($content).'</abbr>';
}
add_shortcode('abbr', 'abbr');


/* code, pre +
================================================== */
function code($atts, $content=null){
	return '<code>'.pre_clean($content).'</code>';
}
add_shortcode('code', 'code');

function pre($atts, $content=null){
	return '<pre>'.pre_clean($content).'</pre>';
}
add_shortcode('pre', 'pre');

/* blockquote +
================================================== */
function blockquote( $atts, $content = null ) {
	extract(shortcode_atts(array(
							'cite' => ''
							),$atts));
	$out = '';
    $out .= '<blockquote><p>'.do_shortcode($content).'</p>';
    if($cite){
    $out .= '<small><cite title="'. $cite .'" >'. $cite .'</cite></small></blockquote>';
    }else{
    $out .= '</blockquote>';
    }
    return $out;
}
add_shortcode('blockquote', 'blockquote');

function blockquote_right( $atts, $content = null ) {
	extract(shortcode_atts(array(
							'cite' => ''
							),$atts));
	$out = '';
    $out .= '<blockquote class="pull-right"><p>'.do_shortcode($content).'</p>';
    if($cite){
    $out .= '<small><cite title="'. $cite .'" >'. $cite .'</cite></small></blockquote>';
    }else{
    $out .= '</blockquote>';
    }
    return $out;
}
add_shortcode('blockquote-right', 'blockquote_right');

/* hr +
================================================== */
function hr($atts, $content=null){
	return '<hr/>';
}
add_shortcode('hr', 'hr');

/* br +
================================================== */
function br($atts, $content=null){
	return '<br/>';
}
add_shortcode('br', 'br');


/* lists +
================================================== */
function p_clean($content){

    $content = str_ireplace('<p>', '', $content);
    $content = str_ireplace('<p/>', '', $content);
    return $content;
}
function lists($atts, $content=null){
	extract(shortcode_atts(array(
							'bullet' => 'square',
							'type' => 'style1'
							),$atts));
	
	if($bullet=='adjust'||$bullet=='alarm'||$bullet=='apple'||$bullet=='ban'||$bullet=='barchart'||$bullet=='barcode'||$bullet=='beer'||$bullet=='bell'||$bullet=='bolt'||$bullet=='bookmark'||$bullet=='briefcase'||$bullet=='brush'||$bullet=='bug'||$bullet=='calendar'||$bullet=='camera'||$bullet=='car'||$bullet=='cellphone'||$bullet=='certificate'||$bullet=='check'||$bullet=='check-circle'||$bullet=='check-circle-alt'||$bullet=='checked-off'||$bullet=='checked-on'||$bullet=='circle-2'||$bullet=='circle-alt'||$bullet=='clapboard'||$bullet=='clip'||$bullet=='clock'||$bullet=='cloud'||$bullet=='cloud-bolts'||$bullet=='cloud-rain'||$bullet=='cloud-snow'||$bullet=='cloud-sun'||$bullet=='cloud-down'||$bullet=='cloud-up'||$bullet=='code'||$bullet=='comment'||$bullet=='comments'||$bullet=='compass'||$bullet=='credit-card'||$bullet=='css3'||$bullet=='dashboard'||$bullet=='desktop'||$bullet=='doc-landscape'||$bullet=='doc-portrait'||$bullet=='download'||$bullet=='download-alt'||$bullet=='drop'||$bullet=='edit'||$bullet=='eye-close'||$bullet=='eye-open'||$bullet=='film'||$bullet=='filter-2'||$bullet=='fire'||$bullet=='flag'||$bullet=='gear'||$bullet=='gears'||$bullet=='ghost'||$bullet=='gift'||$bullet=='glass'||$bullet=='globe'||$bullet=='hammer'||$bullet=='heart'||$bullet=='heart-alt'||$bullet=='help'||$bullet=='home'||$bullet=='html5'||$bullet=='image'||$bullet=='inbox'||$bullet=='info'||$bullet=='key'||$bullet=='lab'||$bullet=='laptop'||$bullet=='leaf'||$bullet=='legal'||$bullet=='linechart'||$bullet=='link'||$bullet=='location'||$bullet=='lock'||$bullet=='magic'||$bullet=='magic-alt'||$bullet=='magnet'||$bullet=='mail'||$bullet=='mail-alt'||$bullet=='map'||$bullet=='minus'||$bullet=='minus-alt'||$bullet=='money'||$bullet=='more'||$bullet=='move'||$bullet=='music'||$bullet=='notebook'||$bullet=='pacman'||$bullet=='pen'||$bullet=='pencil'||$bullet=='phone'||$bullet=='piechart'||$bullet=='piggybank'||$bullet=='plane-down'||$bullet=='plane-up'||$bullet=='plus'||$bullet=='plus-alt'||$bullet=='presentation'||$bullet=='printer'||$bullet=='qrcode'||$bullet=='question'||$bullet=='quote-left'||$bullet=='quote-right'||$bullet=='remove'||$bullet=='remove-alt'||$bullet=='remove-circle'||$bullet=='responsive'||$bullet=='responsive-menu'||$bullet=='retweet'||$bullet=='rocket'||$bullet=='sandglass'||$bullet=='screenshot'||$bullet=='search'||$bullet=='settings'||$bullet=='share'||$bullet=='shield'||$bullet=='shopping-cart-2'||$bullet=='shuffle'||$bullet=='sign-in'||$bullet=='sign-out'||$bullet=='signal'||$bullet=='sitemap'||$bullet=='sort'||$bullet=='sort-down'||$bullet=='sort-up'||$bullet=='star-empty'||$bullet=='star-full'||$bullet=='star-half'||$bullet=='stopwatch'||$bullet=='sun'||$bullet=='tablet'||$bullet=='tag'||$bullet=='tags'||$bullet=='tasks'||$bullet=='thermo-down'||$bullet=='thermo-up'||$bullet=='thumbs-down'||$bullet=='thumbs-up'||$bullet=='trash'||$bullet=='tree'||$bullet=='trophy'||$bullet=='truck'||$bullet=='umbrella'||$bullet=='unlock'||$bullet=='upload'||$bullet=='upload-alt'||$bullet=='user'||$bullet=='users'||$bullet=='warning'||$bullet=='warning-alt'||$bullet=='wrench'||$bullet=='zoom-in'||$bullet=='zoom-out'||$bullet=='angle-down'|$bullet=='angle-left'||$bullet=='angle-right'||$bullet=='angle-up'||$bullet=='angle-double-down'||$bullet=='angle-double-left'||$bullet=='angle-double-right'||$bullet=='angle-double-up'||$bullet=='angle-wide-down'||$bullet=='angle-wide-left'||$bullet=='angle-wide-right'||$bullet=='angle-wide-up'||$bullet=='arrow-down'||$bullet=='arrow-left'||$bullet=='arrow-right'||$bullet=='arrow-up'||$bullet=='arrow-circle-down'||$bullet=='arrow-circle-left'||$bullet=='arrow-circle-right'||$bullet=='arrow-circle-up'||$bullet=='caret-down'||$bullet=='caret-left'||$bullet=='caret-right'||$bullet=='caret-up'||$bullet=='chevron-down'||$bullet=='chevron-left'||$bullet=='chevron-right'||$bullet=='chevron-up'||$bullet=='exchange'||$bullet=='external-link'||$bullet=='hand-up'||$bullet=='hand-down'||$bullet=='hand-left'||$bullet=='hand-right'||$bullet=='hand-up li'||$bullet=='recycled'||$bullet=='redo'||$bullet=='refresh'||$bullet=='resize-big'||$bullet=='resize-big-alt'||$bullet=='resize-horizontal'||$bullet=='resize-horizontal-alt'||$bullet=='resize-small'||$bullet=='resize-small-alt'||$bullet=='resize-vertical'||$bullet=='resize-vertical-alt'||$bullet=='rotate-left'||$bullet=='rotate-right'||$bullet=='undo'||$bullet=='align-center'||$bullet=='align-justify'||$bullet=='align-left'||$bullet=='align-right'||$bullet=='bold'||$bullet=='columns'||$bullet=='font'||$bullet=='italic'||$bullet=='list'||$bullet=='list-ol'||$bullet=='list-ul'||$bullet=='table'||$bullet=='underline'||$bullet=='video-play'||$bullet=='video-play-alt'||$bullet=='video-stop'||$bullet=='video-pause'||$bullet=='video-eject'||$bullet=='video-backward'||$bullet=='video-step-backward'||$bullet=='video-fast-backward'||$bullet=='video-forward'||$bullet=='video-step-forward'||$bullet=='video-fast-forward'||$bullet=='screen-full'||$bullet=='screen-full-alt'||$bullet=='screen-small'||$bullet=='screen-small-alt'||$bullet=='speaker'||$bullet=='facebook'||$bullet=='facebook-alt'||$bullet=='flickr'||$bullet=='flickr-alt'||$bullet=='google-plus'||$bullet=='google-plus-alt'||$bullet=='linkedin'||$bullet=='linkedin-alt'||$bullet=='pinterest'||$bullet=='pinterest-alt'||$bullet=='rss'||$bullet=='skype'||$bullet=='twitter'||$bullet=='twitter-alt'||$bullet=='wordpress'||$bullet=='wordpress-alt'||$bullet=='youtube'||$bullet=='android'||$bullet=='ios'||$bullet=='windows'||$bullet=='windows8'||$bullet=='chrome'||$bullet=='firefox'||$bullet=='ie'||$bullet=='safari'||$bullet=='bootstrap'||$bullet=='jquery'||$bullet=='raphael'||$bullet=='paypal'||$bullet=='livicon-2'||$bullet=='spinner-one'||$bullet=='spinner-two'||$bullet=='spinner-three'||$bullet=='spinner-four'||$bullet=='spinner-five'||$bullet=='spinner-six'||$bullet=='spinner-seven'){
		$livicon = 'livicon-bullet';
	}
	
	if($type == "style1"){
		$type = 'advanced';
	}elseif($type == "style2"){
		$type = 'style2';
	}
							
	return'<div class="'.$type.' '.$livicon.' '.$bullet.'">'.p_clean(do_shortcode($content)).'</div>';
}
add_shortcode('lists', 'lists');


/* dropcap, dropcap1, dropcap2 +
================================================== */
function dropcap($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap', 'dropcap');

function dropcap1($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap1">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap1', 'dropcap1');

function dropcap2($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap2 ' . $type . '">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap2', 'dropcap2');

/* table +
================================================== */
function pre_table($content){

    $content = str_ireplace('<br />', '', $content);
    return $content;
}

function table( $atts, $content = null ) {
    extract(shortcode_atts(array('type' => ''), $atts));
	$out = '';
    $out .= '<table class="table '.$type.'">'.do_shortcode(pre_table($content)).'</table>';
    return $out;
}
add_shortcode('table', 'table');

function table_head( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<thead>'.do_shortcode(pre_table($content)).'</thead>';
    return $out;
}
add_shortcode('table-head', 'table_head');

function table_body( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<tbody>'.do_shortcode(pre_table($content)).'</tbody>';
    return $out;
}
add_shortcode('table-body', 'table_body');

function tr( $atts, $content = null ) {
    extract(shortcode_atts(array('type' => ''), $atts));
	$out = '';
    $out .= '<tr class="'.$type.'">'.do_shortcode(pre_table($content)).'</tr>';
    return $out;
}
add_shortcode('tr', 'tr');

function td( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<td>'.do_shortcode(pre_table($content)).'</td>';
    return $out;
}
add_shortcode('td', 'td');

function th( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<th>'.do_shortcode(pre_table($content)).'</th>';
    return $out;
}
add_shortcode('th', 'th');

/* label +
================================================== */
function label( $atts, $content = null ) {
    extract(shortcode_atts(array('type' => ''), $atts));
	$out = '';
	if($type){
		$type_ = "label-".$type;
	}
    $out .= '<span class="label '.$type_.'">'.do_shortcode(pre_table($content)).'</span>';
    return $out;
}
add_shortcode('label', 'label');

/* badge +
================================================== */
function badge( $atts, $content = null ) {
    extract(shortcode_atts(array('type' => ''), $atts));
	$out = '';
	if($type){
		$type_ = "badge-".$type;
	}
    $out .= '<span class="badge '.$type_.'">'.do_shortcode(pre_table($content)).'</span>';
    return $out;
}
add_shortcode('badge', 'badge');

/* icon heading +
================================================== */
function icon_heading($atts, $content=null){
	extract(shortcode_atts( array( 
							'icon_size' => '',
                            'align' => '',
							'icon' => '',
							), $atts ));
                            
    if(!$icon_size) {$icon_size = 'icon_64';};
    if($icon_size == '64') {$icon_size_ = 'icon_64';};
    if($icon_size == '48') {$icon_size_ = 'icon_48';};
    if($icon_size == '32') {$icon_size_ = 'icon_32';};
    
    if($icon){
	    $icon_ = "<span class='icon-bg'><span class='livicon img' data-name='".$icon."' data-color='#fff' data-hovercolor='#fff' data-size=".$icon_size."></span></span>";
    }
    
	$out = '';
    $out .= '<div class="header_icon '.$icon_size_.' '.$align.'">';
        $out .= $icon_;
        $out .= '<h4 class="title">'.do_shortcode($content).'</h4>';
    $out .= '</div>';
    return $out;
}
add_shortcode('icon_heading', 'icon_heading');

/* clear +
================================================== */
function clear( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<div class="clearfix"></div>';
    return $out;
}
add_shortcode('clear', 'clear');

/* hyperlink +
================================================== */
function hyperlink($atts, $content=null){
	extract(shortcode_atts( array( 
							'href' => '#',
							'target' => '_self',
							), $atts ));

	return '<a href="'.$href.'" target="'.$target.'">'.do_shortcode($content).'</a>';
}
add_shortcode('hyperlink', 'hyperlink');

/* iconitem +
================================================== */
function iconitem($atts, $content=null){
	extract(shortcode_atts( array( 
	'icon' => '',
	'title' => 'Lorem ipsum dolor',
	), $atts ));
	
	if($icon){
		$livicon = '<i class="livicon" data-s="16" data-n="'.$icon.'" data-color="#959595" data-hc="#363636"></i>';	
	}

	return '<div class="iconitem"><h5 class="title">'.$livicon.''.$title.'</h5><div class="content">'.do_shortcode($content).'</div></div>';
	
}
add_shortcode('iconitem', 'iconitem');

/* tooltip +
================================================== */
function tooltip($atts, $content=null){
	extract(shortcode_atts( array( 
							'placement' => 'top',
							'title' => 'This is a tooltip',
							), $atts ));
	return '<a href="#" rel="tooltip" class="ttip" data-placement="'.$placement.'" title="'.$title.'">'.do_shortcode($content).'</a>';
}
add_shortcode('tooltip', 'tooltip');


/* testimonial +
================================================== */
function testimonial( $atts, $content = null ) {

	$rand = rand(2, 999999);
	extract(shortcode_atts( array( 
							'title' => '',
							'control' => '',
							'title_pos' => '',
							), $atts ));
							
	if($title_pos=='left'){
		$title_pos='heading-title-left';
	}elseif($title_pos=='right'){
		$title_pos='heading-title-right';
	}else{
		$title_pos='heading-title-center';
	}
	
	$title_widget = '';
	$control_buttons = '';
	
	if($title){
		$title_widget .= '<div class="title-widget">';
			$title_widget .= '<div class="row-fluid heading-content">';
				$title_widget .= '<div class="span12">';
					$title_widget .= '<h4 class="heading-title '.$title_pos.'"><span>'.$title.'</span></h4>';
				$title_widget .= '</div>';
			$title_widget .= '</div>';
		$title_widget .= '</div>';
	}
	if($control != 'off'){
		$control_buttons = '	<a '.$control_styles.' class="left carousel-control1" href="#myCarousel'.$rand.'" data-slide="prev"><span class="livicon" data-n="caret-left" data-c="#363636" data-hc="#363636" data-s="16"></span></a>
		<a '.$control_styles.' class="right carousel-control1" href="#myCarousel'.$rand.'" data-slide="next"><span class="livicon" data-n="caret-right" data-c="#363636" data-hc="#363636" data-s="16"></span></a>';
	}else{
		$control_ = '';
	}
	return $title_widget. '<div id="myCarousel'.$rand.'" class="testimonial slide"><div class="carousel-inner">'.do_shortcode($content).'</div>'.$control_buttons.'</div>';

}
add_shortcode('testimonial', 'testimonial');

function testimonial_item($atts, $content=null){

	extract(shortcode_atts( array( 
							'cite' => '',
							'linktitle' => '',
							'linkurl' => ''
							), $atts ));
	
							
	if($linktitle&&$linkurl){
		$link = '<br /><a href="'.$linkurl.'">'.$linktitle.'</a>';
	}else{
		$link = '';
	}
	
	if($cite){
		$cite = '<div class="cite"><span>'.$cite.'</span>'.$link.'</div>';
	}
												
	return '<div class="item">'.do_shortcode($content).''.$cite.'</div>';
}

add_shortcode('testimonial-item', 'testimonial_item');

/* Business Hours +
================================================== */
function biz_hours( $atts, $content = null ) {

	extract(shortcode_atts( array( 
							'title' => 'Business Hours'
							), $atts ));
							
	$title_ = '';
							
	if($title){
		$title_ = '<h4 class="title">'.$title.'</h4>';
	}
	
	ob_start();?>
	
    <div class="widget biz_hours-widget list">
        <?php echo $title_; ?>
        <ul class="unstyled">
        	<?php echo do_shortcode($content); ?>
        </ul>
    </div>
	
	<?php return ob_get_clean();

}
add_shortcode('biz-hours', 'biz_hours');


function biz_day($atts, $content=null){

	extract(shortcode_atts( array( 
							'day' => 'Monday :',
							), $atts ));
							
	ob_start();?>
							
    <li><span><?php echo $day; ?></span> <span class="right"><?php echo do_shortcode($content); ?></span></li>
            
    <?php return ob_get_clean();
							
}

add_shortcode('biz-day', 'biz_day');



/* callout +
================================================== */
function callout($atts, $content=null){

	extract(shortcode_atts( array(
	), $atts ));
	
	$out = '';
	
	$out .= '<div class="callout">';
		$out .= do_shortcode($content);
		$out .= '<div class="clearfix"></div>';
	$out .= '</div>';
					
	return $out;
	
}
add_shortcode('callout', 'callout');

function callout_content($atts, $content=null){

	extract(shortcode_atts( array(
							'layout' => 'span8'
							), $atts ));
							
		$out = '';
	
		$out .= '<div class="content '.$layout.'">'.do_shortcode($content).'</div>';
					
	return $out;
	
}
add_shortcode('callout-content', 'callout_content');

function callout_button($atts, $content=null){

	extract(shortcode_atts( array(
							'layout' => 'span4'
							), $atts ));
							
		$out = '';
	
		$out .= '<div class="button '.$layout.'">'.do_shortcode($content).'</div>';
					
	return $out;
	
}
add_shortcode('callout-button', 'callout_button');


/* front tabs widget +
================================================== */
function front_tabs( $atts, $content = null ) {
	extract(shortcode_atts( array( 
							'category' => '',
							), $atts ));
     
	$query = new WP_Query();
	$front_tabs_posts = $query->query("front_tabs_category=$category&post_type=front_tabs&posts_per_page=-1");
	
	$out = '';
	
	if($front_tabs_posts){
	
		$out .= '<div class="front_tabs tabbable tabs-left">';
			$out .= '<ul class="nav nav-tabs">';
				$i = 1;
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
				$out .= '<li class="';
			    $select_icon = get_post_meta(get_the_ID(), 'front_tabs_select', true);
			    if($select_icon == 'none'){
			        $out .= 'none';
			        $icon = '';
			    }else{
			        $icon = '<span class="livicon" data-n="'.$select_icon.'" data-c="#555" data-hc="#959595" data-s="16"></span>';
			    }
			    if($i == 1){
				  $out .= ' active';  
			    }
				$out .= '"><a href="#tab'.get_the_ID().'" data-toggle="tab">'.$icon.''.get_the_title().'</a></li>';
				$i++;
				endwhile; endif;
			$out .= '</ul>';
			$out .= '<div class="tab-content">';	
				$i = 1;
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
				$out .= '<div class="tab-pane'; 
			    if($i == 1){
				  $out .= ' active';  
			    }
				$out .= '" id="tab'.get_the_ID().'">';
				    $content1 = get_the_content();
				    $content1 = apply_filters('the_content', $content1);
				    $content1 = str_replace(']]>', ']]&gt;', $content1);
				    $out .= do_shortcode($content1);
				$out .= '</div>';
				$i++;
				endwhile; endif;	
			$out .= '</div>';
		$out .= '</div>';
			
	}else{
	    
	    $out .= '<p style="color: #ed1c24;">'.__('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN).'</p>';
	    
	}   
        
    return $out;
}
add_shortcode('front_tabs', 'front_tabs');


/* sidebar +
================================================== */
function sidebar($atts, $content=null){
	extract(shortcode_atts( array( 
							'type' => 'right',
							), $atts ));
	
	$type_ = '';
	
	if($type == 'left'){
		$type_ = 'sidebar-left';
	}						
							
    ob_start();
    dynamic_sidebar('Shortcode Sidebar');
    $out = '<div class="shortcode-sb sidebar '.$type_.'">';
    $out .=  ob_get_contents();
    $out .= '<div class="clearfix"></div></div>';
    ob_end_clean();
    return $out;
}
add_shortcode('sidebar', 'sidebar');


/* widget +
================================================== */
function widget($atts, $content=null){
	extract(shortcode_atts( array( 
							'layout' => '4-column',
							'type' => 'portfolio',
							'category' => '',
							'title' => 'This is a title',
							'style' => '',
							'orderby' => '',
							'order' => '',
							'title_pos' => '',
							), $atts ));
							
	$layout_ = '';
	$showposts = '';
	$title_widget = '';
	$no_title = '';
	$category_filter = '';
	$out = '';
						
	if($layout == '3-column'){
		$layout_ = 'span4';
		$showposts = '3';
	}elseif($layout == '2-column'){
		$layout_ = 'span6';
		$showposts = '2';
	}elseif($layout == '6-column'){
		$layout_ = 'span2';
		$showposts = '6';
	}else{
		$layout_ = 'span3';
		$showposts = '4';
	}
	if($title_pos=='left'){
		$title_pos='heading-title-left';
	}elseif($title_pos=='right'){
		$title_pos='heading-title-right';
	}else{
		$title_pos='heading-title-center';
	}
	
	if($title){
		$title_widget .= '<div class="title-widget">';
			$title_widget .= '<div class="row-fluid heading-content">';
				$title_widget .= '<div class="span12">';
					$title_widget .= '<h4 class="heading-title '.$title_pos.'"><span>'.$title.'</span></h4>';
				$title_widget .= '</div>';
			$title_widget .= '</div>';
		$title_widget .= '</div>';
	}
	if(!$title){
		$no_title = "no-title";
	}
	$rand = rand(2, 999999);
	
	if($type=="portfolio"){
		$category_filter = '&portfolio_category='.$category;
	}else{
		$category_filter = '&category_name='.$category;
	}	
		
	$out .= '<div class="news-widget '.$style.' '.$no_title.'">'.$title_widget;
	$out .= '<div class="widget-container"><div class="row-fluid">';
				$query = new WP_Query();
				$query->query('showposts='.$showposts.'&post_type='.$type.'&posts_per_page=-1'.$category_filter.'&orderby='.$orderby.'&order='.$order.'');
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

				$lightbox = get_post_meta(get_the_ID(), 'portfolio_options_lightbox', true);
				$video_raw = get_post_meta(get_the_ID(), 'video_post_meta', true);
				$video = theme_parse_video(get_post_meta(get_the_ID(), 'video_post_meta', true));
				$link = get_post_meta(get_the_ID(), 'link_post_meta', true);
				$portfolio_header_image = get_post_meta(get_the_ID(), 'portfolio_header_image', true);
				$portfolio_header_image_thumbnail = wp_get_attachment_image_src( $portfolio_header_image, 'default-sidebar-page' );
				$post_header_image = get_post_meta(get_the_ID(), 'post_header_image', true);
				$post_header_image_thumbnail = wp_get_attachment_image_src( $post_header_image, 'default-sidebar-page' );
				$terms = get_the_terms( get_the_ID(), 'portfolio_category' );

				$out .= '<div class="'.$layout_.' item">';
						if ( $lightbox ) {
                            $out .= '<a rel="prettyPhoto[pp_gal-'.get_the_ID().''.$rand.']" class="effect-thumb" href="';
                            if ($video) { 
                            	$out .= $video_raw ; 
                            }else{ 
	                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' ); 
	                            $out .= $image[0];
                            }
                            $out .= '" title="';
                            if ($video) {
                            	$out .= get_the_title();
                            }else{
                            	$attachment = get_post(get_post_thumbnail_id( get_the_ID() ));
                            	$out .= $attachment->post_title;
                            }
                            $out .= '">';
                            	if(has_post_thumbnail()) {
								$out .= '<img class="" alt="'.get_the_title().'" src="';
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' );
                            	$out .= $image[0].'"/>';
                            	} elseif ( $portfolio_header_image||$post_header_image ) {
								$out .= '<img class="" alt="'.get_the_title().'" src="';
									if($type=="portfolio"){
										$out .= $portfolio_header_image_thumbnail[0].'"/>';
									}else{
										$out .= $post_header_image_thumbnail[0].'"/>';
									}
                            	}
                            	$out .= '<div class="mega-livicon"><span class="livicon" data-n="zoom-in" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
                            $out .= '</a>';
                            if (!$video) { $thumbnail_id = get_post_thumbnail_id( get_the_ID() ); }
                            $args = array(
                            'numberposts' => 9999, // change this to a specific number of images to grab
                            'offset' => 0,
                            'post_parent' => get_the_ID(),
                            'post_type' => 'attachment',
                            'exclude'  => $thumbnail_id,
                            'nopaging' => false,
                            'post_mime_type' => 'image',
                            'order' => 'ASC', // change this to reverse the order
                            'orderby' => 'menu_order ID', // select which type of sorting
                            'post_status' => 'any'
                            );
                            $attachments =& get_children($args);
                            foreach($attachments as $attachment) {
                                $imageTitle = $attachment->post_title;
                                $imageDescription = $attachment->post_content;
                                $imageArrayFull = wp_get_attachment_image_src($attachment->ID, 'large', false);
                                $out .= '<a class="hide1" rel="prettyPhoto[pp_gal-'.get_the_ID().''.$rand.']" href="'.$imageArrayFull[0].'" title="'.$imageTitle.'"></a>';
                            }
						} elseif ( $link ) {
							if(has_post_thumbnail()) {
							$out .= '<a href="'.$link.'" class="effect-thumb">';
								$out .= '<img class="" alt="'.get_the_title().'" src="';
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' );
								$out .= $image[0].'"/>';
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="link" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
	                       } elseif ( $portfolio_header_image||$post_header_image ) {
							$out .= '<a href="'.$link.'" class="effect-thumb">';
								$out .= '<img class="" alt="'.get_the_title().'" src="';
								if($type=="portfolio"){
									$out .= $portfolio_header_image_thumbnail[0].'"/>';
								}else{
									$out .= $post_header_image_thumbnail[0].'"/>';
								}
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="link" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
							}else{
							$out .= '<a href="'.$link.'" class="effect-thumb hidden-phone">';
								$out .= '<img class="sd_Thumbnail" alt="'.get_the_title().'" src="'.THEME_ASSETS.'img/link-post-type1.png"/>';
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="link" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
							}
                        } elseif ( $video ) {
                            if(has_post_thumbnail()) {
							$out .= '<a href="'.get_permalink().'" class="effect-thumb hidden-phone">';
								$out .= '<img class="" alt="'.get_the_title().'" src="';
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' );
								$out .= $image[0].'"/>';
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="film" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
	                       } elseif ( $portfolio_header_image||$post_header_image ) {
							$out .= '<a href="'.get_permalink().'" class="effect-thumb">';
								$out .= '<img class="" alt="'.get_the_title().'" src="';
								if($type=="portfolio"){
									$out .= $portfolio_header_image_thumbnail[0].'"/>';
								}else{
									$out .= $post_header_image_thumbnail[0].'"/>';
								}
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="film" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
                            }else{
							$out .= '<a href="'.get_permalink().'" class="effect-thumb hidden-phone">';
								$out .= '<img class="sd_Thumbnail" alt="'.get_the_title().'" src="'.THEME_ASSETS.'img/video-post-type1.png"/>';
								$out .= '<div class="mega-livicon"><span class="livicon" data-n="film" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
							$out .= '</a>';
                            }
                        } elseif ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
						$out .= '<a href="'.get_permalink().'" class="effect-thumb">';
							$out .= '<img class="" alt="'.get_the_title().'" src="';
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'default-sidebar-page' );
							$out .= $image[0].'"/>';
							$out .= '<div class="mega-livicon"><span class="livicon" data-n="eye-open" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
						$out .= '</a>';
                        } elseif ( $portfolio_header_image||$post_header_image ) {
						$out .= '<a href="'.get_permalink().'" class="effect-thumb">';
							$out .= '<img class="" alt="'.get_the_title().'" src="';
							if($type=="portfolio"){
								$out .= $portfolio_header_image_thumbnail[0].'"/>';
							}else{
								$out .= $post_header_image_thumbnail[0].'"/>';
							}
							$out .= '<div class="mega-livicon"><span class="livicon" data-n="eye-open" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
						$out .= '</a>';
                        }else{
						$out .= '<a href="'.get_permalink().'" class="effect-thumb hidden-phone">';
							$out .= '<img class="" alt="'.get_the_title().'" src="'.THEME_ASSETS.'img/standard-post-type1.png"/>';
							$out .= '<div class="mega-livicon"><span class="livicon" data-n="eye-open" data-c="#fff" data-hc="#fff" data-s="32"></span></div>';
						$out .= '</a>';
                        }
                        
                        $out .= '<div class="content">';
                        
						if ( $link ) {
						$out .= '<h5 class="title"><a href="'.$link.'">'.get_the_title().'</a></h5>';
						}else{
						$out .= '<h5 class="title"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>';
						}
						
						$out .= '<div class="column">';
							$out .= '<p>'.excerpt(15);
							if ( $link ) {
							$out .= ' <a class="more-link" href="'.$link.'">'.__( '[view more]', GETTEXT_DOMAIN).'</a></p>';
							}else{
							$out .= ' <a class="more-link" href="'.get_permalink().'">'.__( '[read more]', GETTEXT_DOMAIN).'</a></p>';
							}
						$out .= '</div>';
						
						if($type=="portfolio"){
						$out .= '<div class="portfolio-categories">';
									
							$resultstr = array();
                            if($terms) : foreach ($terms as $term) {
                                $resultstr[] = '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_category').'">'.$term->name.'</a>';
                            }
                            $out .= implode(", ",$resultstr); endif;
							
						$out .= '</div>';
						}else{
						$out .= '<div class="post_meta">';
							$out .= '<a class="date" href="'.get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')).'">'.get_the_time('M j, Y').'</a> <span>|</span> ';
							
								$out .= '<a class="comment" href="'.get_comments_link().'">';
								$num_comments=get_comments_number();
									if ( $num_comments == 0 ) {
										$out .=  __('No Comments', GETTEXT_DOMAIN);
									} elseif ( $num_comments > 1 ) {
										$out .=  $num_comments . __(' Comments', GETTEXT_DOMAIN);
									} else {
										$out .=  __('1 Comment', GETTEXT_DOMAIN);
									}
								$out .= '</a>';
							
						$out .= '</div>';
						}
						
						$out .= '</div>';
						
				$out .= '</div>';
				endwhile; endif; 
			$out .= '</div>';
		$out .= '</div>';
	$out .= '</div>';
													
	return $out;
}
add_shortcode('widget', 'widget');

/* clients +
================================================== */
function clients($atts, $content=null){
	extract(shortcode_atts( array(
	'title' => '',
	'title_pos' => 'center'
	), $atts ));
	$out = "";
	
	if($title_pos=='left'){
		$title_pos='heading-title-left';
	}elseif($title_pos=='right'){
		$title_pos='heading-title-right';
	}else{
		$title_pos='heading-title-center';
	}
							
	if($title){
		$title = '<div class="row-fluid heading-content"><div class="span12"><h4 class="heading-title '.$title_pos.'"><span>'.$title.'</span></h4></div></div>';
	}
			
    $query = new WP_Query();
    $client_posts = $query->query('post_type=client&posts_per_page=-1');
    if($client_posts){
			$out .= '<div class="clients-widget">'.$title;
				$out .= '<ul class="unstyled clearfix">';
					if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
					if(get_the_excerpt() == ""){
						$url = '#';
					}else{
						$url = get_the_excerpt();
					}
					$out .= '<li>';
					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
						$out .= '<a href="'.$url.'" title="'.get_the_title().'">';
	                        $out .= '<img alt="'.get_the_title().'" class="client-thumbnail" src="';
	                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'client' );
	                        $out .= $image[0].'" />';
						$out .= '</a>';
					} else {
                    	$out .= '<p style="color: #ed1c24;">'.__( 'Please add an image to "Featured Image" for client thumbnail.', GETTEXT_DOMAIN).'</p>';
                    }
					$out .= '</li>';
					endwhile; endif;
				$out .= '</ul>';
			$out .= '</div>';
	}else{
    	$out .= '<p style="color: #ed1c24;">'.__('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN).'</p>';
    }
									
	return $out;
}
add_shortcode('clients', 'clients');

/* title +
================================================== */
function title($atts, $content=null){
	extract(shortcode_atts( array(
	'title_pos' => 'center'
	), $atts ));
	
	if($title_pos=='left'){
		$title_pos='heading-title-left';
	}elseif($title_pos=='right'){
		$title_pos='heading-title-right';
	}else{
		$title_pos='heading-title-center';
	}
	
	$out = '<div class="title-widget">';
		$out .= '<div class="row-fluid heading-content">';
			$out .= '<div class="span12">';
				$out .= '<h4 class="heading-title '.$title_pos.'"><span>'.do_shortcode($content).'</span></h4>';
			$out .= '</div>';
		$out .= '</div>';
	$out .= '</div>';
	
	return $out;
}
add_shortcode('title', 'title');


/* video youtube or vimeo +
================================================== */
function video($atts, $content=null){
global $woocommerce_loop;
	extract(shortcode_atts( array( 
							'video_url' => '',
							), $atts ));
	
	$video = theme_parse_video($video_url);
	
	ob_start();
	
	if($video_url==""){?>
	
		<p><?php _e('Please enter a "video_url" value for "Video" shortcode.', GETTEXT_DOMAIN); ?></p>
	
	<?php }else{?>
	
		<iframe class="scale-with-grid" width="620" height="349" src="<?php echo $video ?>?wmode=transparent;showinfo=0" frameborder="0" allowfullscreen></iframe>
	
	<?php }
	
	return ob_get_clean();

}
add_shortcode('video', 'video');

/* divider20 divider10 divider5 +
================================================== */
function divider20($atts, $content=null){

	extract(shortcode_atts( array( 
	), $atts ));

	ob_start();
	
	?><div class="divider20"></div><?php
	
	return ob_get_clean();

}
add_shortcode('divider20', 'divider20');

function divider10($atts, $content=null){

	extract(shortcode_atts( array( 
	), $atts ));

	ob_start();
	
	?><div class="divider10"></div><?php
	
	return ob_get_clean();

}
add_shortcode('divider10', 'divider10');

function divider5($atts, $content=null){

	extract(shortcode_atts( array( 
	), $atts ));

	ob_start();
	
	?><div class="divider5"></div><?php
	
	return ob_get_clean();

}
add_shortcode('divider5', 'divider5');

/* livicon +
================================================== */

function livicon($atts, $content=null){

	extract(shortcode_atts( array(
	'icon' => 'livicon',
	'color' => '',
	'hover_color' => '',
	'size' => '',
	'href' => '',
	'float' => '',
	'onparent' => '',
	), $atts ));
	
	if(!$hover_color){
		$hover_color="#363636";
	}
	if(!$color){
		$color="#363636";
	}
	if(!$onparent){
		$onparent="false";
	}

	ob_start();
	
	?><?php if($href){?><a href="<?php echo $href;?>" <?php if($float=='left'){?>class="livicon-link livicon-float-left"<?php }elseif($float=='right'){?>class="livicon-link livicon-float-right"<?php }?>><?php }?><i class="livicon <?php if(!$href){?><?php if($float=='left'){?>livicon-float-left<?php }elseif($float=='right'){?>livicon-float-right<?php }?><?php }?>" data-s="<?php echo $size;?>" data-n="<?php echo $icon;?>" data-c="<?php echo $color;?>" data-hc="<?php echo $hover_color;?>" data-c="#363636" data-onparent="<?php echo $onparent;?>"></i><?php if($href){?></a><?php }?><?php
	
	return ob_get_clean();

}
add_shortcode('livicon', 'livicon');

/* shop tabs +
================================================== */
function shop_tabs($atts, $content=null){
global $woocommerce_loop;
	extract(shortcode_atts( array( 
							'columns' => '4',
							'orderby' => 'date',
							'order' => 'desc',
							'include_id' => '',
							), $atts ));

	
	$rand = rand(2, 999999);
	
	$args = array( 'include' => $include_id ); 

	ob_start();
	
	
    $plugins = get_option('active_plugins');
    $required_plugin = 'woocommerce/woocommerce.php';
    if ( in_array( $required_plugin , $plugins ) ) {?>
	
	<div class="shop-tabs woocommerce tabbable tabs-top">
		<ul class="nav nav-tabs">
			<?php $terms = get_terms('product_cat', $args);?>
			<?php $i = 1;?>
			<?php foreach ($terms as $term) {?>
				<li class="<?php if ($i==1){ echo "active"; } ?>"><a href="#tab-<?php echo $term->term_id;?>-<?php echo $rand;?>" data-toggle="tab"><?php echo $term->name;?></a></li>
			<?php $i++; }?>
		</ul>
		<div class="tab-content">
			<?php $terms = get_terms('product_cat', $args);?>
			<?php $i = 1;?>
			<?php foreach ($terms as $term) {?>
				<div class="tab-pane <?php if ($i==1){ echo "active"; } ?>" id="tab-<?php echo $term->term_id;?>-<?php echo $rand;?>">
				<?php $args = array(
					'post_type'	=> 'product',
					'posts_per_page' => $columns,
					'orderby' => $orderby,
					'order' => $order,
					'product_cat' => $term->slug
				);
				
				$products = new WP_Query( $args );
				
				$woocommerce_loop['columns'] = $columns;
				
				if ( $products->have_posts() ) : ?>
				
				<ul class="products">
				
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				
						<?php woocommerce_get_template_part( 'content', 'product' ); ?>
				
					<?php endwhile; // end of the loop. ?>
				
				</ul>
				
				<?php endif;
				
				wp_reset_query(); ?>
				</div>
			<?php $i++; }?>
		</div>
	</div><?php
	}else{
		?><p><?php _e('Sorry, shortcode is not available now, please activate WooCommerce plugin.', GETTEXT_DOMAIN); ?></p><?php
	}
	
	return ob_get_clean();

}
add_shortcode('shop-tabs', 'shop_tabs');

/* google map +
================================================== */
function map($atts, $content=null){
	extract(shortcode_atts( array( 
		'latitude' => '51.507335',
		'longitude' => '-0.127683',
		'icon' => '',
		'zoom' => '13',
		'height_px' => '300'
		), $atts ));
							
	$rand = rand(2, 999999);
	ob_start();
	
	$height = "";
	
	if($height_px){
		$height = 'style="height: '.$height_px.'px"';
	}
	?>
	
	<div <?php echo $height;?> id="map-canvas-<?php echo $rand;?>" class="google-map"></div>
	
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
	function initialize_<?php echo $rand;?>() {
	var map;
    var center = new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>);
	  var mapOptions = {
		zoom: <?php echo $zoom;?>,
		center: center,
		center: center,
		scrollwheel: false,
		panControl: false,
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		overviewMapControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById('map-canvas-<?php echo $rand;?>'),
	      mapOptions);
	         
		<?php if($icon){?>
		var image = '<?php echo $icon;?>';
		<?php }else{?>
		var image = '<?php echo get_template_directory_uri(); ?>/assets/img/pin.png';
		<?php }?>
	  
	  var myLatLng = new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>);
	  var beachMarker = new google.maps.Marker({
	      position: myLatLng,
	      map: map,
	      icon: image
	  });

	}
	
	google.maps.event.addDomListener(window, 'load', initialize_<?php echo $rand;?>);
    </script>

    
	<?php return ob_get_clean();	
	
}
add_shortcode('map', 'map');


/*  team members +
================================================== */
function team_members($atts, $content=null){
	extract(shortcode_atts( array( 
		'columns' => '4',
		'posts' => '',
		'title' => '',
		'id' => '',
		), $atts ));
		
	$post_per_page = '';
							
	if($posts){
		$post_per_page = $posts;
	}else{
		$post_per_page = '-1';
	}
	
	ob_start();?>
	
					<?php $query = new WP_Query();?>
				    <?php $about_posts = $query->query('post_type=member&posts_per_page='.$post_per_page.'&about_category='.$title.'&p='.$id.'');?>
				    <?php if($about_posts){?>
				    
				    <div class="about-post clearfix">
				    
				    <?php $loop = 1; $column = $columns;?>      
					<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
					<?php $about_buttons = get_post_meta(get_the_ID(), 'team_social_repeatable', true);?>
						
					<div class="
						<?php if($column=="1"){?>
						span12
						<?php }elseif($column=="2"){?>
						span6
						<?php }elseif($column=="3"){?>
						span4
						<?php }elseif($column=="4"){?>
						span3
						<?php }elseif($column=="6"){?>
						span2
						<?php }else{?>
						span4
						<?php }?>
						 member <?php if ( ( $loop - 1 ) % $column == 0 ) echo 'first'; ?>">
							
					    <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {?>
					        <img alt="<?php the_title(); ?>" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'team-member' ); echo $image[0];?>"/>
					    <?php } else{?>
					        <img alt="<?php _e('No Picture', GETTEXT_DOMAIN); ?>" src="<?php echo THEME_ASSETS; ?>img/placeholder-user.png"/>
					    <?php }?>
					    
					    <div class="member-content">
					        <h4 class="name"><?php the_title(); ?></h4>
					        <span class="info">
					                <?php $terms = get_the_terms( get_the_ID(), 'about_category' );
					                if($terms) : foreach ($terms as $term) { echo ''.$term->name.' '; } endif; ?>
					        </span>
					        <p class="excerpt"><?php echo excerpt(20)?> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php _e('[...]', GETTEXT_DOMAIN); ?></a></p>
					        <?php if($about_buttons){ ?>
					        <div class="member-social">
					            
					            <?php $separator = "%%";
					            $output = '';
					            foreach ($about_buttons as $item) {
					                if($item){
					                    list($item_text1, $item_text2) = explode($separator, trim($item));
					                    $output .= '<a href="' . $item_text2 . '" title="' . $item_text1 . '"><i class="livicon" data-name="' . $item_text1 . '" data-size="16" data-c="#959595" data-hc="';
					                    if($item_text1=="facebook"){
						                    $output .= '#3b5998';
					                    }elseif($item_text1=="facebook-alt"){
						                    $output .= '#3b5998';
					                    }elseif($item_text1=="flickr"){
						                    $output .= '#ff0084';
					                    }elseif($item_text1=="flickr-alt"){
						                    $output .= '#ff0084';
					                    }elseif($item_text1=="google-plus"){
						                    $output .= '#dd4a38';
					                    }elseif($item_text1=="google-plus-alt"){
						                    $output .= '#dd4a38';
					                    }elseif($item_text1=="linkedin"){
						                    $output .= '#006699';
					                    }elseif($item_text1=="linkedin-alt"){
						                    $output .= '#006699';
					                    }elseif($item_text1=="pinterest"){
						                    $output .= '#cc2129';
					                    }elseif($item_text1=="pinterest-alt"){
						                    $output .= '#cc2129';
					                    }elseif($item_text1=="rss"){
						                    $output .= '#fa9d39';
					                    }elseif($item_text1=="skype"){
						                    $output .= '#0ca6df';
					                    }elseif($item_text1=="twitter"){
						                    $output .= '#1ec7ff';
					                    }elseif($item_text1=="twitter-alt"){
						                    $output .= '#1ec7ff';
					                    }elseif($item_text1=="youtube"){
						                    $output .= '#c4302b';
					                    }else{
						                    $output .= '#555';
					                    }
					                    $output .= '"></i></a>';
					                }
					            }
					            echo $output;?>
					            
					        </div>
					        <?php } ?>
					    </div>
						
			        </div>
								
			        <?php $loop++; endwhile; endif; ?>
			        
			        </div>

				    <?php }else{?>
				    	<p style="color: #ed1c24;"><?php _e('Sorry, no posts matched your criteria.', GETTEXT_DOMAIN); ?></p>
				    <?php }?>
    
	<?php return ob_get_clean();	
	
}
add_shortcode('team-members', 'team_members');