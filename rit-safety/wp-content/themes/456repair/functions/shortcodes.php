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

function pre_clean($content){

    $content = str_ireplace('<br />', '', $content);
    return $content;
}

/* headings
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


/* paragraph
================================================== */
function p($atts, $content=null){
	return '<p>'.do_shortcode($content).'</p>';
}
add_shortcode('p', 'p');


/* address
================================================== */
function address($atts, $content=null){
	return '<address>'.do_shortcode($content).'</address>';
}
add_shortcode('address', 'address');


/* strong
================================================== */
function strong($atts, $content=null){
	return '<strong>'.do_shortcode($content).'</strong>';
}
add_shortcode('strong', 'strong');


/* abbr
================================================== */
function abbr($atts, $content=null){
	extract(shortcode_atts( array( 
							'title' => 'your title goes here',
							), $atts ));
	return '<abbr title="'.$title.'">'.do_shortcode($content).'</abbr>';
}
add_shortcode('abbr', 'abbr');

/* code, pre
================================================== */
function code($atts, $content=null){
	return '<code>'.pre_clean($content).'</code>';
}
add_shortcode('code', 'code');

function pre($atts, $content=null){
	return '<pre>'.pre_clean($content).'</pre>';
}
add_shortcode('pre', 'pre');

/* hr
================================================== */
function hr($atts, $content=null){
	return '<hr/>';
}
add_shortcode('hr', 'hr');


/* br
================================================== */
function br($atts, $content=null){
	return '<br/>';
}
add_shortcode('br', 'br');


/* dropcap, dropcap1, dropcap2
================================================== */
function dropcap($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap ' . $type . '">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap', 'dropcap');

function dropcap1($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap1 ' . $type . '">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap1', 'dropcap1');

function dropcap2($atts, $content=null){
	extract(shortcode_atts(array(
							'type' => ''
							),$atts));
	return '<span class="dropcap2 ' . $type . '">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap2', 'dropcap2');

/* label
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

/* clear
================================================== */
function clear( $atts, $content = null ) {
    extract(shortcode_atts(array(), $atts));
	$out = '';
    $out .= '<div class="clearfix"></div>';
    return $out;
}
add_shortcode('clear', 'clear');

/* hyperlink
================================================== */
function hyperlink($atts, $content=null){
	extract(shortcode_atts( array( 
							'href' => '#',
							'target' => '_self',
							), $atts ));

	return '<a href="'.$href.'" target="'.$target.'">'.do_shortcode($content).'</a>';
}
add_shortcode('hyperlink', 'hyperlink');

/* tooltip
================================================== */
function tooltip($atts, $content=null){
	extract(shortcode_atts( array( 
							'placement' => 'top',
							'title' => 'This is a tooltip',
							), $atts ));
	return '<a href="#" rel="tooltip" class="ttip ttip-'.$placement.'" data-placement="'.$placement.'" title="'.$title.'">'.do_shortcode($content).'</a>';
}
add_shortcode('tooltip', 'tooltip');

/* Working Time
================================================== */
function working_time( $atts, $content = null ) {

	extract(shortcode_atts( array( 
							'title' => 'Business Hours'
							), $atts ));
									
	if($title){ $title = '<h4>'.$title.'</h4>'; }
	
	ob_start();?>
	
    <div class="working-time">
        <?php echo $title; ?>
        <ul>
        	<?php echo do_shortcode($content); ?>
        </ul>
    </div>
	
	<?php return ob_get_clean();

}
add_shortcode('working_time', 'working_time');


function working_time_time($atts, $content=null){

	extract(shortcode_atts( array( 
	'day' => '',
	), $atts ));
							
	ob_start();?>
							
    <li><span><?php echo $day; ?></span> <span class="right"><?php echo do_shortcode($content); ?></span></li>
            
    <?php return ob_get_clean();
							
}

add_shortcode('time', 'working_time_time');

/* divider20 divider10 divider5
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

/* list
================================================== */
function list_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'icon' => '',
      'type' => '',
   ), $atts ) );
 
   $content = lpd_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
    return '<div class="halflings-icon-list '.$icon.' '.$type.'">'.$content.'</div>';
}
add_shortcode( 'list', 'list_func' );

/* icons
================================================== */
function icon_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
   ), $atts ) );
 
   $content = lpd_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
   
    return '<i class="halflings lpd-halflings-icon '.$content.'"></i>';
}
add_shortcode( 'icon', 'icon_func' );

/* table (for demo)
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