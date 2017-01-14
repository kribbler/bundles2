<?php

$disable_seo = ot_get_option('disable_seo');
$theme_title = ot_get_option('theme_title');

?>

    <?php echo '<title>' ;
	    if($theme_title):
		    if($disable_seo != 'Disable'):
		    	$out = '';
		    	$out = $theme_title;
		    	
		    	$out = str_replace('%blog_title%', get_bloginfo('name'), $out);
		    	$out = str_replace('%blog_description%', get_bloginfo('description'), $out);
		    	$out = str_replace('%page_title%', wp_title('', false), $out);
		    	
		    	echo $out;
		    else:
		    	echo wp_title('', false) . ' | ' . get_bloginfo('name');
		    endif;
	    else:
	    	echo wp_title('', false) . ' | ' . get_bloginfo('name');
	    endif;
    echo '</title>';?>