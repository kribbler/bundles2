<?php
/*
 * Template Name: Work Page - do not use
 */

?>

<?php if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
	/*
	$args = array( 'post_type' => 'post', 'posts_per_page' => 10000, 'orderby' => 'ID', 'order' => 'ASC');
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : 
		$loop->the_post(); 
		$image = get_site_thumb($post->ID);
		
		if ($image == get_stylesheet_directory_uri() . '/images/no-preview.png'){
			$external_url = get_post_meta($post->ID, 'url', true);
			echo "<p>" . $external_url . "</p>";
		}
		
		
		
		//die();
	endwhile; 
	wp_reset_query(); */


/*
 if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
						<div class="single_page">
							<header>
								<h1 class="title"><?php the_title(); ?></h1>
							</header>
							<div class="post-content box mark-links">
								<?php the_content(); ?>                                    
								<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','mythemeshop'), 'previouspagelink' => __('Previous','mythemeshop'), 'pagelink' => '%','echo' => 1 )); ?>
							</div><!--.post-content box mark-links-->
						</div>
					</div>
					<?php comments_template( '', true ); ?>
				<?php endwhile; ?>
*/
}?>
<div id="links"></div>
<?php 
$links = initiateScrap();
//echo admin_url("admin-ajax.php");

?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
	
	$.post(ajaxurl, { action: 'curling' }, function(output, is_ok) {
		output = JSON.parse(output);
		Object.keys(output).forEach(function(key) {
			console.log(output[key]);
			jQuery.ajax(
			  ajaxurl,
			  {
			  	async: false,
			    type: "POST",
			    data: {
			      action: "continuous_scrap",
			      link: output[key]
			      //nonce:  nonce
			    },
			    //error:   handleError,
			    success: function(){
			    	$('#links').append(output[key] + "<br />");
			    }
			  }
			);
			//console.log('stopping');
			//return false;
		});
		$('#links').append("DONE.");
	});
});
</script>