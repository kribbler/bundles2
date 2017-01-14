<?php
/*
Plugin Name: Tabby Responsive Tabs
Plugin URI: http://cubecolour.co.uk/tabby-responsive-tabs
Description: Create responsive tabs inside your posts, pages or post types by adding simple shortcodes inside the post editor. The tabs behave like an accordion on smaller screens.
Author: cubecolour
Version: 1.0.3
Author URI: http://cubecolour.co.uk

	Tabby Responsive Tabs WordPress plugin Copyright 2013 Michael Atkins
	
	Licenced under the GNU GPL:
		
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
	
	Original version of Responsive Tabs jQuery script by Pete Love:
	http://www.petelove.co.uk/responsiveTabs/
	http://codepen.io/petelove666/pen/zbLna
	MIT license: http://blog.codepen.io/legal/licensing/

	Permission is hereby granted, free of charge, to any person 
	obtaining a copy of this software and associated documentation 
	files (the "Software"), to deal in the Software without restriction,
	including without limitation the rights to use, copy, modify, 
	merge, publish, distribute, sublicense, and/or sell copies of 
	the Software, and to permit persons to whom the Software is 
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall 
	be included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
	OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
	HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER 
	DEALINGS IN THE SOFTWARE.

*/

// ==============================================
//	Add Links in Plugins Table
// ==============================================
 
add_filter( 'plugin_row_meta', 'cc_tabby_meta_links', 10, 2 );
function cc_tabby_meta_links( $links, $file ) {

	$plugin = plugin_basename(__FILE__);
	
// create the links
	if ( $file == $plugin ) {
		return array_merge( $links, array( '<a href="http://cubecolour.co.uk/wp">Donate</a>', '<a href="http://twitter.com/cubecolour">cubecolour on Twitter</a>' ) );
	}
	return $links;
}

// ==============================================
//	Register & enqueue the stylesheet
//	If you want to use custom styles, copy the content of the tabby.css to your child theme
//	and stop the default styles from loading by this by adding the following line to the theme's functions.php:
//
//	remove_action('wp_print_styles', 'cc_tabby_css', 30);
//
//	to do: Possibly split into two css files - one mandatory & one replaceable
//	or one with defaults & info on what/how to override
// ==============================================

add_action('wp_print_styles', 'cc_tabby_css', 30);

function cc_tabby_css() {
	wp_enqueue_style('tabby.css', plugin_dir_url(__FILE__).'css/' . 'tabby.css' , false, '1.0.2');	
}

// ==============================================
// Register & enqueue the script
// ==============================================
/*
add_action('wp_enqueue_scripts', 'cc_tabby_js');
function cc_tabby_js() {
	wp_register_script( 'tabby', plugins_url() . "/" . basename(dirname(__FILE__)) . '/js/tabby.js', array('jquery'), '1.0.1', true );
	wp_enqueue_script( 'tabby' );
}
*/
// ==============================================
// Trigger the script if it has not already been triggered on the page
// ==============================================

function cc_tabbytrigger() {

	static $tabbytriggered = FALSE;
	
	if ($tabbytriggered == FALSE) {
		echo "\n" . "<script>jQuery(document).ready(function($) { RESPONSIVEUI.responsiveTabs(); })</script>" .  "\n";

		$tabbytriggered = TRUE;
	}
}

// ==============================================
//	SHORTCODE FOR TABBY
//	use [tabby]
// ==============================================

function cc_shortcode_tabby( $atts, $content = null ) {

// initialise $firsttab flag so we can tell whether we are building the first tab

global $reset_firsttab_flag;
static $firsttab = TRUE;

if ($GLOBALS["reset_firsttab_flag"] === TRUE) {
	$firsttab = TRUE;
	$GLOBALS["reset_firsttab_flag"] = FALSE;
}

// extract title
	extract(shortcode_atts(array("title" => ''), $atts));

// test whether this is the first tab in the group
	if ( $firsttab == TRUE) {
	
// Set flag so we know subsequent tabs are not the first in the tab group
		$firsttab = FALSE;
// Build output for the first tab
		return '<div class="responsive-tabs"><h2 class="tabtitle">' . $title . '</h2><div class="tabcontent"><p>';
	}

    else {
// Build output for non-first tab(s)
		return '</p></div><h2 class="tabtitle">' . $title . '</h2><div class="tabcontent"><p>';
	}
}

add_shortcode('tabby', 'cc_shortcode_tabby');

// ==============================================
//	SHORTCODE TO GO AFTER FINAL TABBY TAB
//	use [tabbyending]
// ==============================================
function cc_shortcode_tabbyending( $atts, $content = null ) {

	wp_enqueue_script('tabby', plugins_url('js/tabby.js', __FILE__), array('jquery'), '1.0.2', true);

	add_action('wp_footer', 'cc_tabbytrigger', 20);

	$GLOBALS["reset_firsttab_flag"] = TRUE;

	return '</p></div></div>';
}

add_shortcode('tabbyending', 'cc_shortcode_tabbyending');

