<?php
/*
	Plugin Name: WP-SNAP!
	Plugin URI: http://www.nateomedia.com/wares/downloads/wordpress/wp-snap
	Description: WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an user interface for navigating alphabetized post titles.
	Version: 0.9.4
	Author: Nathan Olsen
	Author URI: http://www.nateomedia.com/

	-------------------------------------------------------------------------------

	CHANGE LOG
	08.2010.05 Version 0.9.4
		* Rooted out a couple more bugs

	08.2010.01 Version 0.9.3
		* The bug hunt continues!

	08.2010.01 Version 0.9.2
		* Fixed more bugs

	07.2010.31 Version 0.9.1
		* Fixed several bugs with the database call

	07.2010.30 Version 0.9
		* Improved international character support
		* Added warning if database is empty

	02.2009.20 Version 0.8.6
		* Fixed bug with posts beginning with misc. letters on sites not using
		  fancy URLs
		* Fixed bug with adminstrative menu

	06.2008.10 Version 0.8.5
		* Added international language file support
		* Changed the method for passing data to the plugin
		* Tracked down bugs

	06.2008.08 Version 0.8.4
		* Made the plugin compatible with Wordpress's new tagging system
		* Corrected problem with listing recent posts

	04.2008.03 Version 0.8.3
		* Fixed a small -- but significant -- typo
		* Moved the administrative submenu to plugins.php
		* Added the ability to display All/None/Recent posts on first load

	12.2007.02 Version 0.8.1
		* Fixed incompatibility with PHP 4

	11.2007.28 Version 0.8
		* Added support for fancy URLs

	10.2007.04 Version 0.7.3
		* Fixed error with Wordpress 2.3 database call

	09.2007.28 Version 0.7.2
		* Made database call compatible with Wordpress 2.3

	06.2007.02 Version 0.7.1
		* Fixed error with database call

	05.2007.30 Version 0.7
		* Fixed issue preventing the display of more than 10 posts
		* Fixed issue with sorting uppercase/lowercase post titles
		* Restored ability to pass a category to the plugin
		* Added ability to include category children in returned results
		* Added ability to display all categories
		* Added ability to change navigation style when calling the plugin
		* Added support for Gengo (hopefully)

	05.2007.12 Version 0.6.2
		* Restored the ability to exclude first words from being alphabetized
		* Cleaned-up some instructional text in the options menu

	01.2007.21 Version 0.6.1
		* Fixed a minor error with the $wp_snap_category variable

	01.2007.20 Version 0.6
		* Rebuilt the entire plugin to be better, stronger, faster
		* Changed how results are displayed; plugin now plays well with the
		  Wordpress loop
		* Removed option to pass a category number directly to the plugin,
		  making it incompatible with Pages (feature to return if requested)
		* Added nonce protection to the admin options panel
		* Added option to group posts beginning with a number under '#'
		* Fixed unencoded ampersands

	09.2006.20 Version 0.5.4
		* Updated WP-SNAP! to ignore posts with post-dated timestamps

	08.2006.02 Version 0.5.3
		* Fixed an error that affected certain navigational menu styles

	08.2006.01 Version 0.5.2
		* Updated alphabetization to accomodate accent marks; still needs refinement
		* Fixed a logic error with the post title sort loop

	06.2006.07 Version 0.5.1
		* Squashed some bugs in the new ignore filter

	06.2006.06 Version 0.5
		* Words can now be filtered from the alphabetization process from the WP-SNAP!
		  admin options menu

	06.2006.01 Version 0.4
		* Added '#' to catch category entries beginning with
		  non-alphanumeric characters
		* Tweaked the code here and there
		* Fixed the WP-SNAP! plugin url on the admin options page

	05.2006.13 Version 0.3.1
		* Fixed the url structure of the navigation when used on a Page
		* Added 'apply_filters' to the post excerpt

	05.2006.08 Version 0.3
		* Plugin no longer displays excerpts for password protected posts, if
		  the viewer is unauthorized
		* If there is no excerpt for a post and excerpts are turned on, plugin
		  now creates an excerpt from the post content
		* Fixed a typo

	03.2006.29 Version 0.2
		* Added the ability to pass a category number directly to the plugin,
		  making WP-SNAP compatible with Pages

	03.2006.29 Version 0.1
		* Inital release

	-------------------------------------------------------------------------------

	Copyright 2006-2008 Nathan Olsen  http://www.nateomedia.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	-------------------------------------------------------------------------------
*/

// Error Reporting
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Define defaults
add_option('key_snap_menu', '1');
add_option('key_snap_menumisc', '2');
add_option('key_snap_recent', '10');
add_option('key_snap_csscls1', 'snap_nav');
add_option('key_snap_csscls2', 'snap_selected');
add_option('key_snap_exclude', '');
add_option('key_snap_fancyurl', '2');
add_option('key_snap_fancyurlname', 'browse');
add_option('key_snap_tab1', '0');
add_option('key_snap_alphabet', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');

add_action('admin_menu',  'wp_snap_add_option_page');
add_action('init', 'wp_snap_load_language');

// Fancy url scheme derived from Keyvan Minoukadeh's GPL'd Wordpress plugin, Paged Comments.
// I honestly don't know if I would have been able to include this feature at all if it had
// been necessary for me to build it from scratch. Hooray for open source software! :)
if (get_option('key_snap_fancyurl') == 1) {
	add_action('init', 'wp_snap_fancy_url', 10, 0);
}

function wp_snap($snapquery = '') {

	if (!empty($snapquery)) {
		parse_str($snapquery, $snapqueryarray);
	}

	$nav = new wp_snap_core();

	if (isset($snapqueryarray['cat'])) {
		$nav->cat = snap_strtoupper(trim($snapqueryarray['cat']));
	} else {
		if (is_category()) {
			$nav->cat = get_query_var('cat');
		} elseif (is_tag()) {
			$nav->tag = get_query_var('tag_id');
		}
	}

	if (isset($snapqueryarray['child'])) {
		$nav->ifchildren = true;
	} else {
		$nav->ifchildren = false;
	}

	if (isset($snapqueryarray['menu'])) {
		$nav->menustyle = $snapqueryarray['menu'];
	}

	if (isset($snapqueryarray['firstload'])) {
		$nav->firstload = snap_strtoupper(trim($snapqueryarray['firstload']));
	}

	if (isset($_GET['cp'])) {
		$nav->first_letters = $_GET['cp'];
	} elseif (isset($_GET['snap'])) {
		if ($_GET['snap'] == 'misc') {
			$nav->first_letters = '#';
		} else {
			$nav->first_letters = urldecode($_GET['snap']);
		}
	}

	$results = $nav->navigation();

	return $results;
}

class wp_snap_core {

	var $cat;
	var $encoding;
	var $firstload;
	var $first_letters;
	var $ifchildren;
	var $menustyle;
	var $tag;

	function current_url($fancyurl, $fancyurlname = '') {
		$url = "http://" . $_SERVER['HTTP_HOST'];
		if ($fancyurl == 1 && get_option('permalink_structure') !== '') {
			$url .= preg_replace('@' . $fancyurlname . '.*@', '', $_SERVER['REQUEST_URI']);
		} else {
			$url .= preg_replace('@[\?\&]snap.*@', '', $_SERVER['REQUEST_URI']);
		}
		return $url;
	}

	function navigation() {
		global $wpdb, $wp_query, $user_ID;

		// Define variables
		$wp_snap_options = array(
			'menu' => get_option('key_snap_menu'),
			'menumisc' => get_option('key_snap_menumisc'),
			'recent' => get_option('key_snap_recent'),
			'csscls1' => get_option('key_snap_csscls1'),
			'csscls2' => get_option('key_snap_csscls2'),
			'tab1' => get_option('key_snap_tab1'),
			'fancyurl' => get_option('key_snap_fancyurl'),
			'fancyurlname' => get_option('key_snap_fancyurlname'),
			'alphabet' => get_option('key_snap_alphabet'),
			'exclude' => get_option('key_snap_exclude'));
		if (!empty($wp_snap_options['exclude']) && snap_strlen(preg_replace('/[^\|]+/i', '', $wp_snap_options['exclude'])) > 1) {
			$wp_snap_options['exclude'] = preg_replace('/[\|]+/i', ' ', $wp_snap_options['exclude']);
			$wp_snap_options['exclude'] = snap_regex_conversion($wp_snap_options['exclude'], $wp_snap_options['alphabet']);
			update_option('key_snap_exclude', $wp_snap_options['exclude']);
		}
		$wp_snap_options['exclude'] = explode(' ', $wp_snap_options['exclude']);
		$ehzee = snap_strtoupper(snap_substr($wp_snap_options['alphabet'], 0, 1)) . '-' . snap_strtoupper(snap_substr($wp_snap_options['alphabet'], -1, 1));
		$snap_alphabet_2 = explode(" ", snap_alphasplit_2($wp_snap_options['alphabet']));
		$snap_alphabet_3 = explode(" ", snap_alphasplit_3($wp_snap_options['alphabet']));
		$url = wp_snap_core::current_url($wp_snap_options['fancyurl'],$wp_snap_options['fancyurlname']);
		$tempstr['1']['0'] = '#' . $wp_snap_options['alphabet'];
		$tempstr['1']['1'] = '#0123456789' . $wp_snap_options['alphabet'];
		$tempstr['2']['0'] = '#' . str_replace(" ", "", snap_alphasplit_2($wp_snap_options['alphabet'], 1));
		$tempstr['2']['1'] = '#0-9' . str_replace(" ", "", snap_alphasplit_2($wp_snap_options['alphabet'], 1));
		$tempstr['2']['2'] = '#';
		$tempstr['2']['3'] = '0123456789';
		for ($i=0; $i < count($snap_alphabet_2); $i++) {
			$num = $i + 4;
			$tempstr['2'][$num] = $snap_alphabet_2[$i];
		}
		$tempstr['3']['0'] = '#' . str_replace(" ", "", snap_alphasplit_3($wp_snap_options['alphabet'], 1));
		$tempstr['3']['1'] = '#0-9' . str_replace(" ", "", snap_alphasplit_3($wp_snap_options['alphabet'], 1));
		$tempstr['3']['2'] = '#';
		$tempstr['3']['3'] = '0123456789';
		$tempstr['3']['4'] = $snap_alphabet_3[0];;
		$tempstr['3']['5'] = $snap_alphabet_3[1];;

		if (empty($this->menustyle)) {
			$this->menustyle = $wp_snap_options['menu'];
		}
		// Database query
		if ($wp_snap_options['exclude'][0] !== '') {
			$pipe = 0;
			$select = ", TRIM(LEADING ' ' from (CASE WHEN $wpdb->posts.post_title REGEXP '";
			for ($i=0; $i < count($wp_snap_options['exclude']); $i++) {
				if (snap_substr($wp_snap_options['exclude'][$i], -1, 2) !== ']]') {
					if ($pipe > 0) { $select .= "|";}
					$select .= "^" . $wp_snap_options['exclude'][$i] . ' +';
					$pipe = 1;
				}
			}
			if ($pipe == 0) {
				for ($i=0; $i < count($wp_snap_options['exclude']); $i++) {
					if (snap_substr($wp_snap_options['exclude'][$i], 0, 2) == '[[') {
						if ($pipe > 0) { $select .= "|";}
						$select .= "^" . $wp_snap_options['exclude'][$i] . '+';
						$pipe = 1;
					}
				}
				$select .= "' THEN SUBSTRING($wpdb->posts.post_title FROM 2)";
			} else {
				$select .= "' THEN TRIM(LEADING SUBSTRING_INDEX($wpdb->posts.post_title,' ',1) from $wpdb->posts.post_title)";
				$pipe = 0;
				for ($i=0; $i < count($wp_snap_options['exclude']); $i++) {
					if (snap_substr($wp_snap_options['exclude'][$i], 0, 2) == '[[') {
						if ($pipe == 0) {
							$select .= " WHEN $wpdb->posts.post_title REGEXP '";
							$pipe = 1;
						}
						if ($pipe > 1) { $select .= "|";}
						$select .= "^" . $wp_snap_options['exclude'][$i] . '+';
						$pipe = 2;
					}
				}
				if ($pipe !== 0) {
					$select .= "' THEN SUBSTRING($wpdb->posts.post_title FROM 2)";
				}
			}
			$select .= " ELSE $wpdb->posts.post_title END)) AS mytitle";
		}

		if (!empty($this->cat)) {
			$join = " LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)";
			if ($this->cat !== 'ALL') {
				$where = " AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.term_id IN ('" . $this->cat . "', ";
				if ($this->ifchildren == TRUE) {
					$where .= "'" . implode("', '", get_term_children($this->cat, 'category')) . "'";
				} else {
					$where =  snap_substr($where, 0, -2);
				}
				$where .= ")";
			}
		} elseif (!empty($this->tag)) {
			$join = " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)";
			$where = " AND $wpdb->term_taxonomy.taxonomy = 'post_tag' AND $wpdb->term_taxonomy.term_id IN ('" . $this->tag . "')";
		}

		$where .= " AND (post_type = 'post' AND (post_status = 'publish'";

		if (is_admin()) {
			$where .= " OR post_status = 'future' OR post_status = 'draft' OR post_status = 'pending'";
		}

		if (is_user_logged_in()) {
			$where .= current_user_can("read_private_" . get_query_var('post_type') . "s") ? " OR post_status = 'private'" : " OR post_author = $user_ID AND post_status = 'private'";
		}

		$where .= '))';

		if ($this->firstload == 'RECENT' && $this->first_letters == NULL) {
			$orderby = ' ORDER BY post_date DESC';
		} elseif ($wp_snap_options['exclude'][0] == '') {
			$orderby = ' ORDER BY post_title ASC';
		} else {
			$orderby = ' ORDER BY mytitle ASC';
		}

		$groupby = " GROUP BY $wpdb->posts.ID";
		$request = "SELECT $wpdb->posts.*" . $select . " FROM $wpdb->posts" . $from . $join . " WHERE 1=1" . $where . $groupby . $orderby;

		$request = apply_filters('posts_request', $request);
		$all_posts = $wpdb->get_results($request);

		if (!empty($all_posts)) {
			// Create a string containing the first letters of the post titles retrieved above
			for ($i=0; $i < count($all_posts); $i++) {
				if ($all_posts[$i]->mytitle == '') {
					$all_posts[$i]->mytitle = $all_posts[$i]->post_title;
				}
				$first_letter_all_posts .= snap_strtoupper(snap_substr($all_posts[$i]->mytitle, 0, 1));
			}

			// If no query is found in the url, select first post title letter
			if ($this->first_letters == NULL && $this->firstload !== 'RECENT' && $this->firstload !== 'NONE') {
				if ($this->firstload == 'ALL') {
					$this->first_letters = $tempstr['1']['1'];
				} elseif ((preg_match('/[^0-9' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)) || (($wp_snap_options['menumisc'] == '1') && (preg_match('/[^' . $wp_snap_options['alphabet'] . ']+/i', snap_substr($first_letter_all_posts, 0, 1))))) {
					$this->first_letters = '#';
				} elseif ($this->menustyle == '1') {
					$this->first_letters = snap_substr($first_letter_all_posts, 0, 1);
				} else { 
					for ($i=3; $i < count($tempstr[$this->menustyle]); $i++)
						if (snap_strstr($tempstr[$this->menustyle][$i], snap_substr($first_letter_all_posts, 0, 1)))
							$this->first_letters = $tempstr[$this->menustyle][$i];
				}
			}

			if ($this->first_letters !== $tempstr['1']['1']) {
				for ($i=0; $i < count($all_posts); $i++) {
					if (($this->first_letters == NULL && ($i >= $wp_snap_options['recent'] || $this->firstload == 'NONE')) || ($this->first_letters == '#' && (preg_match('/[' . $wp_snap_options['alphabet'] . ']+/i', snap_substr($all_posts[$i]->mytitle, 0, 1)) || ($wp_snap_options['menumisc'] == 2 && preg_match('/[0-9]+/i', snap_substr($all_posts[$i]->mytitle, 0, 1))))) || ($this->first_letters !== '#' && preg_match('/[^' . $this->first_letters . ']+/i', snap_substr($all_posts[$i]->mytitle, 0, 1)))) {
						$all_posts[$i] = NULL;
					}
				}
			}

			foreach ($all_posts as $key => $value) {
				if ($value == NULL) { 
					unset($all_posts[$key]);
				}
			}
			$all_posts = array_values($all_posts);

			$wp_query->post_count = count($all_posts);
			$wp_query->posts = $all_posts;

			// Test for post titles beginning with numbers
			$numtest = '0';
			if (preg_match('/[0-9]+/i', $first_letter_all_posts) && $wp_snap_options['menumisc'] !== '1') {
				$numtest = '1';
			}

			// Create tabs based on number input in admin menu
			$num_tabs = '';
			for ($y = 0; $y < $wp_snap_options['tab1']; $y++) {
				$num_tabs .= "\t";
			}

			// Insert ordered list tag for navigational menu, include class information
			$results = $num_tabs . '<ol';
			if ($wp_snap_options['csscls1']) {
				$results .= ' class="' . $wp_snap_options['csscls1'] . '">' . "\n";
			} else {
				$results .= ">\n";
			}

			// Check if ALL posts are to be displayed on first load
			if ($this->firstload == 'ALL') {
				$results .= $num_tabs . "\t<li";
				if ($this->first_letters == $tempstr['1']['1']) {
					$results .= ' class="' . $wp_snap_options['csscls2'] . '"';
				} else {
					$results .= '><a href="' . $url . '"';
				}
				$results .= '>ALL';
				if ($this->first_letters !== $tempstr['1']['1']) {
					$results .= '</a>';
				}
				$results .= "</li>\n";
			}

			// Test to see if non-alphanumeric characters were used in titles
			if (($wp_snap_options['menumisc'] == '1' && !preg_match('/[^' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)) || ($wp_snap_options['menumisc'] == 2 && !preg_match('/[^0-9' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts))) {
				$tempstr[$this->menustyle][$numtest] = str_replace('#', '', $tempstr[$this->menustyle][$numtest]);
			}

			// Create navigational menu list items
			switch ($this->menustyle) {
				case 1:
					for ($i = 0; $i < snap_strlen($tempstr[$this->menustyle][$numtest]); $i++) {
						$l = snap_substr($tempstr[$this->menustyle][$numtest], $i, 1);
						$nav_entry_test = FALSE;
						$results .= $num_tabs . "\t<li";

						if (($this->firstload == 'ALL' && $this->first_letters == $tempstr['1']['1']) || $l == $this->first_letters) {
							$results .= ' class="' . $wp_snap_options['csscls2'] . '"';
						}

						$nav_entry = '>' . $l . "</li>\n";

						for ($y = 0; $y < snap_strlen($first_letter_all_posts); $y++) {
							if (($this->first_letters !== $l) && (snap_strstr($first_letter_all_posts, $l) || ($l == '#' && preg_match('/[^0-9' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)) || ($l == '#' && $wp_snap_options['menumisc'] == '1' && preg_match('/[^' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)))) {
								$nav_entry = '><a href="' . $url;
								if ($wp_snap_options['fancyurl'] == 1) {
									$nav_entry .= $wp_snap_options['fancyurlname'] . '-' . $l . '/">' . $l . "</a></li>\n";
								} else {
									if (snap_strstr($url, '?')) {
										$nav_entry .= '&amp;';
									} else {
										$nav_entry .= '?';
									}
									$nav_entry .= 'snap=';
									if ($l == '#') {
										$nav_entry .= 'misc';
									} else {
										$nav_entry .= $l;
									}
									$nav_entry .= '">' . $l . "</a></li>\n";
								}
								$nav_entry_test = TRUE;
							}
						}
						$results .= $nav_entry;;
					}
					break;
				case 2:
				case 3:
					// Create a count that will allow $tempstr to be used in creating the URL query
					if (snap_substr($tempstr[$this->menustyle][$numtest], 0, 1) == '#') {
						$wp_snap_count = 2;
					} else {
						$wp_snap_count = 4 - $numtest;
					}
					for ($i = 0; $i < snap_strlen($tempstr[$this->menustyle][$numtest]); $i = $i + $wp_snap_adv) {
						if ($tempstr[$this->menustyle][$wp_snap_count] == '#') {
							$l = '#';
							$wp_snap_adv = 1;
						} else {
							$l = snap_substr($tempstr[$this->menustyle][$numtest], $i, 3);
							$wp_snap_adv = 3;
						}
						$results .= $num_tabs . "\t<li";
						if (($this->firstload == 'ALL' && $this->first_letters == $tempstr['1']['1']) || snap_strstr($this->first_letters, snap_substr($l, 0, 1))) {
							$results .= ' class="' . $wp_snap_options['csscls2'] . '"';
						}
						$nav_entry = '>' . $l . "</li>\n";
						if ($this->first_letters !== $tempstr[$this->menustyle][$wp_snap_count] && (preg_match('/[' . $first_letter_all_posts . ']+/i', $tempstr[$this->menustyle][$wp_snap_count]) || ($l == '#' && preg_match('/[^0-9' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)) || ($l == '#' && $wp_snap_options['menumisc'] == '1' && preg_match('/[^' . $wp_snap_options['alphabet'] . ']+/i', $first_letter_all_posts)))) {
							$nav_entry = '><a href="' . $url;
							if ($wp_snap_options['fancyurl'] == 1) {
								$nav_entry .= $wp_snap_options['fancyurlname'] . '-' . $tempstr[$this->menustyle][$wp_snap_count] . '/">' . $l . "</a></li>\n";
							} else {
								if (snap_strstr($url, '?')) {
									$nav_entry .= '&amp;';
								} else {
									$nav_entry .= '?';
								}
								$nav_entry .= 'snap=';
								if ($l == '#') {
									$nav_entry .= 'misc';
								} else { $nav_entry .= $tempstr[$this->menustyle][$wp_snap_count]; }
								$nav_entry .= '">' . $l . "</a></li>\n";
							}
						}
						$results .= $nav_entry;

						if ($wp_snap_count == 2) {
							$wp_snap_count = 4 - $numtest;
						} else {
							++$wp_snap_count;

						}
					}
					break;
			}
			$results .= $num_tabs . "</ol>\n";
		} else {
			$results = 'No posts found matching criteria.';
		}

		return $results;
	}
}

function snap_encoding() {
	if (function_exists('get_bloginfo')) {
		return get_bloginfo('charset');
	} else {
		return 'UTF-8';
	}
}

function snap_strlen($string) {
	if (function_exists(mb_strlen)) {
		return mb_strlen($string, snap_encoding());
	} else {
		return strlen($string);
	}
}

function snap_strstr($haystack, $needle, $part = FALSE) {
	if (function_exists(mb_strstr)) {
		return mb_strstr($haystack, $needle, $part, snap_encoding());
	} else {
		return strstr($haystack, $needle, $part);
	}
}

function snap_strtolower($string) {
	if (function_exists(mb_strtolower)) {
		return mb_strtolower($string, snap_encoding());
	} else {
		return strtolower($string);
	}
}

function snap_strtoupper($string) {
	if (function_exists(mb_strtoupper)) {
		return mb_strtoupper($string, snap_encoding());
	} else {
		return strtoupper($string);
	}
}

function snap_substr($string, $start, $length) {
	if (function_exists(mb_substr)) {
		return mb_substr($string, $start, $length, snap_encoding());
	} else {
		return substr($string, $start, $length);
	}
}

function snap_strpos($haystack, $needle) {
	if (function_exists(mb_strpos)) {
		return mb_strpos($haystack, $needle, '', snap_encoding());
	} else {
		return strpos($haystack, $needle);
	}
}

function snap_alphasplit_2($alphabet, $type = 0) {
	$al_len = snap_strlen($alphabet);
	if ($type == 1) {
		if ($al_len % 4 == 0 || $al_len % 4 > 2 || $al_len % 5 == 1) {
			for($i=0; $i < $al_len; $i++) {
				$alphabet_2 .= snap_substr($alphabet, $i, 1);
				$i = $i + 3;
				if ($i < $al_len) {
					$alphabet_2 .= '-' . snap_substr($alphabet, $i, 1) . ' ';
				} else {
					$alphabet_2 .= '-' . snap_substr($alphabet, -1, 1);
				}
			}
		} else {
			for($i=0; $i < $al_len; $i++) {
				$alphabet_2 .= snap_substr($alphabet, $i, 1);
				$i = $i + 4;
				if ($i < $al_len) {
					$alphabet_2 .= '-' . snap_substr($alphabet, $i, 1) . ' ';
				} else {
					$alphabet_2 .= '-' . snap_substr($alphabet, -1, 1);
				}
 			}
		}
	} else {
		if ($al_len % 4 == 0 || $al_len % 4 > 2 || $al_len % 5 == 1) {
			$alphabet_2 = snap_substr($alphabet, 0, 4);
			for($i=4; $i < $al_len; $i = $i + 4) {
				$alphabet_2 .= ' ' . snap_substr($alphabet, $i, 4);
			}
		} else {
			$alphabet_2 = snap_substr($alphabet, 0, 5);
			for($i=5; $i < $al_len; $i = $i + 5) {
				$alphabet_2 .= ' ' . snap_substr($alphabet, $i, 5);
			}
		}
	}
	return $alphabet_2;
}

function snap_alphasplit_3($alphabet, $type = 0) {
	$lettercount = snap_strlen($alphabet);
	$half = $lettercount / 2;
	if ($type == 1) {
		$half = $half - 1;
		$alphabet_3 = snap_substr($alphabet, 0, 1) . '-'. snap_substr($alphabet, $half, 1);
		$half = $half + 1;
		$alphabet_3 .= ' ' . snap_substr($alphabet, $half, 1) . '-'. snap_substr($alphabet, -1, 1);
	} else {
		$alphabet_3 = snap_substr($alphabet, 0, $half) . ' ' . snap_substr($alphabet, $half, 100);
	}
	return $alphabet_3;
}

function snap_regex_conversion($convert,$alphabet) {
	$convert = stripslashes($convert);
	$convert = explode(" ", $convert);
	for ($i=0; $i < count($convert); $i++) {
		for ($j=0; $j < snap_strlen($convert[$i]); $j++) {
			$test_con = $convert[$i][$j];
			if (snap_substr($convert[$i], $j, 2) == '[[') {
				for ($k=$j; $k < snap_strlen($convert[$i]); $k++) {
					if (snap_substr($convert[$i], $k, 2) == ']]' && snap_substr($convert[$i], $k, 4) !== ']][[') {
						$j = $k+2;
						$k = snap_strlen($convert[$i]);
						$test_con = $convert[$i][$j];
					}
				}
			}
			switch($test_con) {
				case '!': $test_con = '[[.exclamation-mark.]]'; break;
				case '#': $test_con = '[[.number-sign.]]'; break;
				case '$': $test_con = '[[.dollar-sign.]]'; break;
				case '%': $test_con = '[[.percent-sign.]]'; break;
				case '&': $test_con = '[[.ampersand.]]'; break;
				case "'":
				case '$apost;' : $test_con = '[[.apostrophe.]]'; break;
				case '"':
				case '&ldquo;':
				case '$quote;': $test_con = '[[.quotation-mark.]]'; break;
				case '(': $test_con = '[[.left-parenthesis.]]'; break;
				case ')': $test_con = '[[.right-parenthesis.]]'; break;
				case '*': $test_con = '[[.asterisk.]]'; break;
				case '+': $test_con = '[[.plus-sign.]]'; break;
				case ',': $test_con = '[[.comma.]]'; break;
				case '-': $test_con = '[[.hyphen.]]'; break;
				case '.': $test_con = '[[.period.]]'; break;
				case '/': $test_con = '[[.slash.]]'; break;
				case ':': $test_con = '[[.colon.]]'; break;
				case ';': $test_con = '[[.semicolon.]]'; break;
				case '<': $test_con = '[[.less-than-sign.]]'; break;
				case '=': $test_con = '[[.equals-sign.]]'; break;
				case '>': $test_con = '[[.greater-than-sign.]]'; break;
				case '?': $test_con = '[[.question-mark.]]'; break;
				case '@': $test_con = '[[.commercial-at.]]'; break;
				case '[': $test_con = '[[.left-square-bracket.]]'; break;
				case '\\': $test_con = '[[.backslash.]]'; break;
				case ']': $test_con = '[[.right-square-bracket.]]'; break;
				case '^': $test_con = '[[.circumflex.]]'; break;
				case '_': $test_con = '[[.underscore.]]'; break;
				case '{': $test_con = '[[.left-curly-bracket.]]'; break;
				case '}': $test_con = '[[.right-curly-bracket.]]'; break;
				case '|': $test_con = '[[.vertical-line.]]'; break;
				case '~': $test_con = '[[.tilde.]]'; break;
			}
			if ($test_con !== $convert[$i][$j]) {
				$convert[$i] = str_replace($convert[$i][$j], $test_con, $convert[$i]);
				$j = $j + snap_strlen($test_con) - 1;
			}
		}
	}
	$convert = implode(" ", $convert);
	return $convert;
}

function snap_regex_menu_conversion($convert) {
	$convert = explode(" ", $convert);
	for ($i=0; $i < count($convert); $i++) {
		for ($j=0; $j < snap_strlen($convert[$i]); $j++) {
			if (snap_substr($convert[$i], $j, 2) == '[[') {
				for ($k=$j; $k < snap_strlen($convert[$i]); $k++) {
					if (snap_substr($convert[$i], $k, 2) == ']]') {
						$test_con .= ']]';
						$k = snap_strlen($convert[$i]);
					} else {
						$test_con .= $convert[$i][$k];
					}
				}
				switch($test_con) {
					case '[[.exclamation-mark.]]':		$test_tran = '&#33;'; break;
					case '[[.number-sign.]]':			$test_tran = '#'; break;
					case '[[.dollar-sign.]]':			$test_tran = '&#36;'; break;
					case '[[.percent-sign.]]':			$test_tran = '%'; break;
					case '[[.ampersand.]]':				$test_tran = '&'; break;
					case '[[.apostrophe.]]':			$test_tran = "&#39;"; break;
					case '[[.quotation-mark.]]':		$test_tran = '&#34;'; break;
					case '[[.left-parenthesis.]]':		$test_tran = '&#40;'; break;
					case '[[.right-parenthesis.]]':		$test_tran = '&#41;'; break;
					case '[[.asterisk.]]':				$test_tran = '&#42;'; break;
					case '[[.plus-sign.]]':				$test_tran = '&#43;'; break;
					case '[[.comma.]]':					$test_tran = ','; break;
					case '[[.hyphen.]]':				$test_tran = '-'; break;
					case '[[.period.]]':				$test_tran = '.'; break;
					case '[[.slash.]]':					$test_tran = '/'; break;
					case '[[.colon.]]':					$test_tran = ':'; break;
					case '[[.semicolon.]]':				$test_tran = ';'; break;
					case '[[.less-than-sign.]]':		$test_tran = '<'; break;
					case '[[.equals-sign.]]':			$test_tran = '='; break;
					case '[[.greater-than-sign.]]':		$test_tran = '>'; break;
					case '[[.question-mark.]]':			$test_tran = '?'; break;
					case '[[.commercial-at.]]':			$test_tran = '@'; break;
					case '[[.left-square-bracket.]]':	$test_tran = '['; break;
					case '[[.backslash.]]':				$test_tran = '&#92;'; break;
					case '[[.right-square-bracket.]]':	$test_tran = ']'; break;
					case '[[.circumflex.]]':			$test_tran = '^'; break;
					case '[[.underscore.]]':			$test_tran = '_'; break;
					case '[[.left-curly-bracket.]]':	$test_tran = '{'; break;
					case '[[.right-curly-bracket.]]':	$test_tran = '}'; break;
					case '[[.vertical-line.]]':			$test_tran = '|'; break;
					case '[[.tilde.]]':					$test_tran = '~'; break;
				}
				if ($test_con !== '') {
					$convert[$i] = str_replace($test_con, $test_tran, $convert[$i]);
					$test_con = '';
					$j = $j + snap_strlen($test_tran) - 1;
				}
			}
		}
	}
	$convert = implode(" ", $convert);
	return $convert;
}

function wp_snap_load_language() {
	load_plugin_textdomain('wp-snap','/wp-content/plugins/wp-snap/languages/');
}

function wp_snap_fancy_url($var = 'REQUEST_URI') {
	$req = $_SERVER[$var];
	$fancyurlname = get_option('key_snap_fancyurlname');
	$fancyalphabet = get_option('key_snap_alphabet');
	$ehzee = snap_strtoupper(snap_substr($fancyalphabet, 0, 1)) . '-' . snap_strtoupper(snap_substr($fancyalphabet, -1, 1));
	if (preg_match('!^(.*/)' . $fancyurlname . '-([0-9' . snap_strtolower($ehzee) . $ehzee . ']*)/?(.*)?$!', $req, $match)) {
		if ($match[2] == '') {
			$_GET['cp'] = '#';
		} else {
			$_GET['cp'] = $match[2];
		}
		$req = $match[1] . $match[3];
		$_SERVER[$var] = $req;
	}
	if (($var !== 'PATH_INFO') && isset($_SERVER['PATH_INFO'])) {
		wp_snap_fancy_url('PATH_INFO');
	}
}

function snap_add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) {
		$this_plugin = plugin_basename(__FILE__);
	}
	if ($file == $this_plugin) {
		$settings_link = '<a href="plugins.php?page=wp-snap.php">'.__("Settings", "wp-snap").'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

add_filter('plugin_action_links', 'snap_add_settings_link', 10, 2 );

function wp_snap_add_option_page() {
	if (function_exists('add_options_page'))
		add_submenu_page('plugins.php', 'WP-SNAP!', 'WP-SNAP!', 8, basename(__FILE__), 'wp_snap_options_subpanel');
}

function wp_snap_options_subpanel() {
	$snap_alphabet = get_option('key_snap_alphabet');
	$snap_alphabet_2 = snap_alphasplit_2($snap_alphabet, 1);
	$snap_alphabet_3 = snap_alphasplit_3($snap_alphabet, 1);

	if (isset($_POST['info_update'])) { 

		$whitespace = array(" ", "\t", "\n", "\r", "\0", "\x0B");
		$snap_fancyurl = strip_tags(str_replace($whitespace, '', $_POST['key_snap_fancyurlname']));

		check_admin_referer('wp_snap_update_options');
		update_option('key_snap_menu', (int) $_POST['key_snap_menu']);
		update_option('key_snap_menumisc', (int) $_POST['key_snap_menumisc']);
		update_option('key_snap_recent', (int) $_POST['key_snap_recent']);
		update_option('key_snap_csscls1', (string) $_POST['key_snap_csscls1']);
		update_option('key_snap_csscls2', (string) $_POST['key_snap_csscls2']);
		update_option('key_snap_exclude', snap_regex_conversion($_POST['key_snap_exclude'], $_POST['key_snap_alphabet']));
		update_option('key_snap_fancyurl', (int) $_POST['key_snap_fancyurl']);
		update_option('key_snap_alphabet', (string) snap_strtoupper($_POST['key_snap_alphabet']));
		if (!empty($snap_fancyurl)) {
			update_option('key_snap_fancyurlname', (string) $snap_fancyurl);
		}
		update_option('key_snap_tab1', (int) $_POST['key_snap_tab1']);

		echo '<div id="message" class="updated fade"><p><strong>Options successfully updated.</strong></p></div>';
		$snap_alphabet = get_option('key_snap_alphabet');
		$snap_alphabet_2 = snap_alphasplit_2($snap_alphabet, 1);
		$snap_alphabet_3 = snap_alphasplit_3($snap_alphabet, 1);
	} ?>
<div class="wrap">
	<h2>WP-SNAP! v0.9.4</h2>
	<p><?php _e('To check for new versions or get more information, visit <a href="http://www.nateomedia.com/wares/downloads/wordpress/wp-snap/">this plugin\'s page</a>.', 'wp-snap'); ?></p>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<?php if (function_exists('wp_nonce_field')) { wp_nonce_field('wp_snap_update_options'); } ?>
		<input type="hidden" name="info_update" id="info_update" value="true" />
		<h3><?php _e('Navigational Menu Options', 'wp-snap'); ?></h3>
		<p><?php _e('<strong>Local Alphabet</strong> allows the user to input a custom alphabet. This feature is meant to improve international character support.', 'wp-snap'); ?></p>
		<p><?php _e('<strong>Menu Style</strong> controls how the user will navigate post titles. Three styles are provided to choose from. Numbers will only appear in the menu if post titles beginning with numbers exist and <strong>Group Posts</strong> is turned off. <strong>Recent Posts</strong> controls how many recent posts will be displayed when the plugin is first called (if the recent posts feature is called).', 'wp-snap'); ?></p>
		<p><?php _e('<strong>CSS Class Name</strong> fields add a class attribute to <code>&lt;ol></code> and/or <code>&lt;li></code> HTML tags.', 'wp-snap'); ?></p>
		<p><?php _e('<strong>Ignore During Alphabetizing</strong> allows the user to filter out words, letters and characters such as <em>the</em>, <em>a</em>, or quotation marks from the alphabetization process. For instance, if "the" is added to the ignore list, the post title "The Last Samurai" would be found under <em>L</em> instead of <em>T</em>. This function is not case sensitive.', 'wp-snap'); ?></p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Local Alphabet', 'wp-snap'); ?></th> 
				<td><input name="key_snap_alphabet" type="text" value="<?php echo $snap_alphabet; ?>" size="20" style="width: 30em;" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Menu Style', 'wp-snap'); ?></th>
				<td>
					<label style="letter-spacing: 1px;"><input name="key_snap_menu" type="radio" value="1" <?php checked('1', get_option('key_snap_menu')); ?> /> #0123456789<?php echo $snap_alphabet; ?></label><br />
					<label style="letter-spacing: 1px;"><input name="key_snap_menu" type="radio" value="2" <?php checked('2', get_option('key_snap_menu')); ?> /> # 0-9 <?php echo $snap_alphabet_2; ?></label><br />
					<label style="letter-spacing: 1px;"><input name="key_snap_menu" type="radio" value="3" <?php checked('3', get_option('key_snap_menu')); ?> /> # 0-9 <?php echo $snap_alphabet_3; ?></label>
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Group Posts', 'wp-snap'); ?></th>
				<td>
					<label><input name="key_snap_menumisc" type="radio" value="1" <?php checked('1', get_option('key_snap_menumisc')); ?> /> <?php _e('Group Post Titles Beginning With a Number Under Miscellaneous', 'wp-snap'); ?></label><br />
					<label><input name="key_snap_menumisc" type="radio" value="2" <?php checked('2', get_option('key_snap_menumisc')); ?> /> <?php _e('Do Not Group Post Titles Beginning With a Number Under Miscellaneous', 'wp-snap'); ?></label><br />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Recent Posts', 'wp-snap'); ?></th>
				<td>Display <input name="key_snap_recent" type="text" value="<?php echo get_option('key_snap_recent') ?>" size="20" style="width: 3em;" /> <?php _e('Recent Posts', 'wp-snap'); ?></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><code>&lt;ol></code> <?php _e('CSS Class Name', 'wp-snap'); ?></th>
				<td><input name="key_snap_csscls1" type="text" value="<?php echo get_option('key_snap_csscls1') ?>" size="20" style="width: 30em;" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><code>&lt;li></code> <?php _e('Selected CSS Class Name', 'wp-snap'); ?></th>
				<td><input name="key_snap_csscls2" type="text" value="<?php echo get_option('key_snap_csscls2') ?>" size="20" style="width: 30em;" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Ignore When Alphabetizing', 'wp-snap'); ?></th> 
				<td><input name="key_snap_exclude" type="text" value="<?php echo snap_regex_menu_conversion(get_option('key_snap_exclude')); ?>" size="20" style="width: 30em;" /> (<?php _e('Separate each entry with a space.', 'wp-snap'); ?>)</td>
			</tr>
		</table>
		<h3><?php _e('Presentational Options', 'wp-snap'); ?></h3>
		<p><?php _e('<strong>Fancy URLs</strong> should be activated if the Wordpress installation is using a custom URI permalink structure. The <strong>Fancy URL Name</strong> used in the URI may also be&nbsp;customized.', 'wp-snap'); ?></p>
		<p><?php _e('The <strong>Tabs</strong> option is purely for aesthetic purposes &mdash; it allows you to specify how far to indent the ordered list generated by WP-SNAP! so that it matches up with the rest of your HTML&nbsp;code.', 'wp-snap'); ?></p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Fancy URLs', 'wp-snap'); ?></th>
				<td>
					<label><input name="key_snap_fancyurl" type="radio" value="1" <?php checked('1', get_option('key_snap_fancyurl')); ?> /> <?php _e('Use Fancy URLs', 'wp-snap'); ?></label><br />
					<label><input name="key_snap_fancyurl" type="radio" value="2" <?php checked('2', get_option('key_snap_fancyurl')); ?> /> <?php _e('Do Not Use Fancy URLs', 'wp-snap'); ?></label><br />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Fancy URL Name', 'wp-snap'); ?></th> 
				<td><input name="key_snap_fancyurlname" type="text" value="<?php echo get_option('key_snap_fancyurlname') ?>" size="20" style="width: 30em;" /></td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Tabs', 'wp-snap'); ?></th> 
				<td><?php _e('Use', 'wp-snap'); ?> <input name="key_snap_tab1" type="text" value="<?php echo get_option('key_snap_tab1') ?>" size="1" style="width: 1.5em;" /> <?php _e('tabs', 'wp-snap'); ?></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save Changes', 'wp-snap'); ?>" />
	</form>
</div>
<?php 
}
?>