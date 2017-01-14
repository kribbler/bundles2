<?php get_header(); ?>

<div id="main-content">
	<div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area">

	            <section id="page-sidebar" class="alignleft span9">
	                <?php 
	                $paged = intval(get_query_var('paged'));
	                $posts_per_page = 8;
	                if(empty($paged) || $paged == 0) $paged = 1;
	                $offset = ($paged - 1) * $posts_per_page;


	                $args = array( 'posts_per_page' => $posts_per_page, 'cat' => 2, 'offset' => $offset, 'post_status' => 'publish' );
	                $loop = new WP_Query($args);

	                while ( $loop->have_posts() ) : $loop->the_post(); 
					$post_format = et_pb_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					et_divi_post_format_content();

					if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
						if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
							printf(
								'<div class="et_main_video_container">
									%1$s
								</div>',
								$first_video
							);
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						elseif ( 'gallery' === $post_format ) :
							et_pb_gallery_images();
						endif;
					} ?>

				<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
					<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php
						et_divi_post_meta();

						if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
							truncate_post( 270 );
						} else {
							the_content();
						}
					?>
				<?php endif; ?>

					</article> <!-- .et_pb_post -->
			<?php
					endwhile;

	                get_template_part( 'loop', 'blog' );
	                afl_pager($loop->found_posts, $loop->query['posts_per_page'], $paged);
	                
					?>
	            </section>
	         </div>
            <?php get_sidebar(); ?>

    	</div>
    </div>
	
</div> <!-- #main-content -->

<?php get_footer(); ?>