<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li>
								<div class="sidebar_top">
									<div class="sidebar_bottom">',
        'after_widget' => '			</div>
								</div>
							</li>',
        'before_title' => '<div class="sideBarTitle">
								<h3>',
        'after_title' => '		</h3>
							</div>',
		'name' =>'sidebar'
    ));		

	register_sidebar(array(
        'before_widget' => '<li>',
        'after_widget' => '</li>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
		'name' =>'right_sidebar'
    ));	
	

function string_limit_words($string, $word_limit)
{
$words = explode(' ', $string, ($word_limit + 1));
if(count($words) > $word_limit)
array_pop($words);
return implode(' ', $words);
}


add_filter( 'comments_template', 'legacy_comments' );
function legacy_comments( $file ) {
	if ( !function_exists('wp_list_comments') )
		$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}	

function exclude_category($query) {
	if ( $query->is_feed || $query->is_home ) {
		$query->set('cat', '-9');
	}
return $query;
}

add_filter('pre_get_posts', 'exclude_category');
?>