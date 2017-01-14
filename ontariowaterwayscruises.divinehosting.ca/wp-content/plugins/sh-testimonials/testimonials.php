<?php
$args = array(
	'posts_per_page'  => (isset($atts['limit']) ? $atts['limit'] : 2),
	'offset'          => 0,
	'numberposts'	  => 0,
	'orderby'         => 'RAND',
	'order'           => 'ASC',
	'post_type'       => 'testimonials'
);
$p=new WP_Query($args);
if ($p->have_posts()) {
	global $post;
	echo '<div class="testimonial-container container">';
	while ( $p->have_posts() ) {
		$p->the_post();
		echo '<div class="testimonial-',$post->ID,' testimonial">';
      	echo '<div class="quote">';
        the_content();
		echo '</div>';
		echo '<div>';
        echo '<span class="person-quoted">';
		the_title();
        echo '</span>';
        echo '<span class="position">';
		echo get_post_meta($post->ID, '_company', true);
        echo '</span>';
		echo '</div>';	
		echo '</div>';
	}
	echo '</div>';
}
wp_reset_query();
wp_reset_postdata();
