<?php
/*
 * Template Name: Page Index
 */

?>

<?php $mts_options = get_option('point'); ?>
<?php get_header(); ?>
<div id="page" class="home-page">
	<div class="content">
		<?php
		global $wpdb;

		$instance = array();
		$instance['show_counts'] = false;
		$instance['post_type'] = 'post';
		$count_col = '';
			if ( (bool) $instance['show_counts'] ) {
				$count_col = ", count( substring( TRIM( LEADING 'A ' FROM TRIM( LEADING 'AN ' FROM TRIM( LEADING 'THE ' FROM UPPER( $wpdb->posts.post_title ) ) ) ), 1, 1) ) as counts";
			}
			$querystr = "
				SELECT DISTINCT substring( TRIM( LEADING 'A ' FROM TRIM( LEADING 'AN ' FROM TRIM( LEADING 'THE ' FROM UPPER( $wpdb->posts.post_title ) ) ) ), 1, 1) as initial" . $count_col . "
				FROM $wpdb->posts
				WHERE $wpdb->posts.post_status = 'publish' 
				AND $wpdb->posts.post_type = '" . $instance['post_type'] . "'
				GROUP BY initial
				ORDER BY TRIM( LEADING 'A ' FROM TRIM( LEADING 'AN ' FROM TRIM( LEADING 'THE ' FROM UPPER( $wpdb->posts.post_title ) ) ) );
			";

			$pt_initials = $wpdb->get_results( $querystr, ARRAY_A );
			$initial_arr = array();
			$base_url = get_post_type_archive_link( $instance['post_type'] );
			if ( ! $base_url  ) {
				if (get_option('show_on_front')=='page') {
					$base_url = esc_url( get_permalink( get_option('page_for_posts') ) );
				} else {
					$base_url = esc_url( home_url( '/' ) );
				}
				
			}

			//echo "<pre>"; var_dump($pt_initials); echo "</pre>";
			$i = 0;
			foreach( $pt_initials AS $pt_rec ) {
				
				/*$link = add_query_arg( 'a2zaal', $pt_rec['initial'], $base_url );
				if ( (bool) $instance['show_counts'] ) {
					$item = '<li class="count"><a href="' . $link . '">' . $pt_rec['initial'] . '<span>' . $pt_rec['counts'] . '</span>' . '</a></li>';
				} else {
					$item = '<li><a href="' . $link . '">' . $pt_rec['initial'] . '</a></li>';
				}
				$initial_arr[] = $item;*/

				$args = array('name__like' => $pt_rec['initial'], 'order' => 'ASC', 'number' => 10);

				$results = get_terms( 'category', $args );
				//echo "<pre>";var_dump($pt_rec['initial']);var_dump($results[0]);echo "</pre>";
				if ( $results ) {
		         	if ($i++ % 4 == 0) {
		         		$div_clear = ' clear';
		         	} else {
		         		$div_clear = "";
		         	}
		         	echo '<div class="index_column '.$div_clear.'">';
		         	echo '<ul>';
		         	echo '<li class="index_head">' . $pt_rec['initial'] . '</li>';

		            foreach ( $results as $result ) 
		            {
		                setup_postdata ( $result ); 
		                ?> 
		                <li>
		                    <a href="<?php echo get_category_link($result->term_id);?>" rel="tag"><?php echo $result->name;?></a>
		                </li>
		                <?php 
		            }
		            echo '</ul>';
		            echo '</div>';
		         } 



				/*
				$query = "SELECT * FROM " . $wpdb->posts . " WHERE post_title LIKE '".$pt_rec['initial']."%'
					AND post_type = 'post'
					AND post_status = 'publish'
					AND post_title > 'A'
					AND post_title <= 'Z'
					LIMIT 20
					";

				$results = $wpdb->get_results($query);

				if ( $results ) {
		         	if ($i++ % 4 == 0) {
		         		$div_clear = ' clear';
		         	} else {
		         		$div_clear = "";
		         	}
		         	echo '<div class="index_column '.$div_clear.'">';
		         	echo '<ul>';
		         	echo '<li class="index_head">' . $pt_rec['initial'] . '</li>';

		            foreach ( $results as $post ) 
		            {
		                setup_postdata ( $post ); 
		                ?> 
		                <li>
		                    <?php $external_url = get_post_meta($post->ID, 'url', true);?>
		                    <a href="<?php echo $external_url ?>" target="_blank" title="<?php echo $post->post_title; ?>" rel="nofollow" id="featured-thumbnail">
		                    <?php echo $post->post_title;?>
		                    </a>
		                </li>
		                <?php 
		            }
		            echo '</ul>';
		            echo '</div>';
		         } */
			}
			$initial_list = '<ul>' . implode( '', $initial_arr ) . '</ul>';
		?>
	<?php get_footer(); ?>