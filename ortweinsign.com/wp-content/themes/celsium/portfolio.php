<?php
/**
 * The main template file.
 * Template Name: Portfolio
 *
 
 */

get_header(); ?>
<?php include(TEMPLATEPATH . '/inc/data.php'); ?>
<!--container-->
<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1><?php the_title();?></h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp <?php the_title();?></div>
        </div>
	</section>
    <div class="container">
		<?php

		$args=array(
			'post_type' => 'portfolio',
			'posts_per_page' => 199
		);
		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query();
		$wp_query->query($args);
		$terms = get_terms('portfoliocat');
		?>
		<?php if ($wp_query->have_posts()) :
		$portfolio_settings = get_portfolio_settings($post->ID);
		switch($portfolio_settings['num_cols']){
			case 2: $col_width = 'span6';break;
			case 4: $col_width = 'span3';break;
			default: $col_width = 'span4';break;
		}?>
        <!--filter-->
        <ul id="filtrable">
			<?php
			echo '<li class="current all"><a href="#">All</a></li>';
			foreach ( $terms as $term ) {
				$filter_last_item = end($terms);
				echo '<li class="'.strtolower(str_replace(" ", "-", $term->name)).'"><a href="#">'.$term->name.'</a></li>';
			}
			?>
        </ul>

        <div class="clear"></div>

        <section class="row da-thumbs portfolio filtrable">
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				<?php
				$i++;
				$custom = get_post_custom($post->ID);
				$foliocatlist = get_the_term_list( $post->ID, 'portfoliocat', '', ', ', '' );
				$entrycategory = get_the_term_list( $post->ID, 'portfoliocat', '', '_', '' );
				$entrycategory = strip_tags($entrycategory);
				$entrycategory = strtolower($entrycategory);
				$entrycategory = str_replace(' ', '-', $entrycategory);
				$entrycategory = str_replace('_', ' ', $entrycategory);
				$entrytitle = get_the_title();
				$blogimageurl = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				if($blogimageurl==""){
					$blogimageurl = get_template_directory_uri().'/images/blank.jpg';
				}
				?>
				<article data-id="id-<?php echo $post->ID; ?>" data-type="<?php echo $entrycategory ?>" class="<?php echo $col_width ?>">
					<span>
						<?php  $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
						<?php if (has_post_thumbnail()) {
						$imgurl = $src[0];
						the_post_thumbnail('portfolio');
					} else {
						$imgurl = $blogimageurl;
						echo '<img src="'.$imgurl.'"  alt="'.$post->post_title.'" />';
					} ?>
						<div class="pd">
							<a href="<?php echo $imgurl ?>" class="p-view"  data-rel="prettyPhoto"></a>
							<a href="<?php the_permalink() ?>" class="p-link"></a>
						</div>
					</span>
					<?php if(isset($portfolio_settings['portfolio_type'])&&$portfolio_settings['portfolio_type']==1) { ?>
						<h3><a href="<?php the_permalink() ?>"><?php echo $post->post_title ?></a></h3>
						<p><?php echo ((!empty($post->post_excerpt)) ? $post->post_excerpt : content()) ?></p>
						<a href="<?php the_permalink() ?>" class="read-more"><?php echo (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore') ?></a>
					<?php } ?>
				</article>
                <?php endwhile; ?>
               <?php else : ?>
               <h3>Oops, we could not find what you were looking for...</h3>
               <?php endif; ?>

               <?php
               $wp_query = null;
               $wp_query = $temp;
               wp_reset_query();
               ?>
       </section>
    </div>
</section>

<?php get_footer(); ?>
