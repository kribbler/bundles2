<?php global $post;
	 $tmp_post = $post;
	 $per_page = get_option('posts_per_page');
	 $posts_count = wp_count_posts('post')->publish;
	 $paged = intval(get_query_var('paged'));
	 if(empty($paged) || $paged == 0) $paged = 1;
	 $i = 0;
	 ?>