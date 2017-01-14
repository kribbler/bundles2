<?php

/**

 * The template for displaying all pages.

 *

 *

 */

/**

Template Name: Gallery

 */
ob_start();
dynamic_sidebar( 'featured-image' );
$side=ob_get_contents();
ob_end_clean();
get_header(); ?>



<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>



<div class="lastmess">
</div>

<div class="bodymid">

	<div class="stripetop">

		<div class="stripebot">

			<div class="container">

				<div class="mapdiv"></div>

				<div class="clear"></div>

				<div id="main">

					<div class="grid8 first">	

						<div id="content" role="main">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	

                                                            

								<div class="entry-content">

                                                                     <?php $refMonth = array(

	"JAN"	=> 1,

	"FEB"	=> 2,

	"MAR"	=> 3,

	"APR"	=> 4,

	"MAY"	=> 5,

	"JUN"	=> 6,

	"JUL"	=> 7,

	"AUG"	=> 8,

	"SEP"	=> 9,

	"OCT"	=> 10,

	"NOV"	=> 11,

	"DEC"	=> 12



);?>



    <?php 

    /*Initilize active month and year*****************************************/

    

    $req_month = $refMonth[$_REQUEST['q_month']];

    

    		$q_month = (( $req_month) && ( $req_month <= 12) && ( $req_month >= 1) ) ?  $req_month : date('n');

    		$q_year = ($_REQUEST['q_year']) ?  $_REQUEST['q_year'] : date('Y');

    

    

    

    $next_link_month = ($q_month == 12)? 1 : ($q_month + 1);

    $next_link_year =  ($q_month == 12)? ($q_year+1) : $q_year;

     $next_query = "q_month=".strtoupper( date("M",mktime(0,0,0, $next_link_month,1,$next_link_year))) . "&q_year=" .  $next_link_year;

    

    $prev_link_month = ($q_month == 1)? 12 : ($q_month - 1);

    $prev_link_year =  ($q_month == 1)? ($q_year - 1) : $q_year;

    

    $prev_query = "q_month=". strtoupper( date("M",mktime(0,0,0, $prev_link_month,1,$prev_link_year))). "&q_year=" .  $prev_link_year;

    ?>

    <div class="links_qallery">

    <a href="?<?=$prev_query?>" class="prev">Prev Month</a> <span><?php echo date("F",mktime(0,0,0,$q_month,1,$q_year)). ' ' . $q_year ;?> </span> <?php if(!(($q_month == date('n'))  && ($q_year == date('Y')))){ ?>

    <a href="?<?=$next_query?>" class="next">Next Month</a>

    

   <?php  }?> 

    </div>

    <?php  

   $args = array(  

        'numberposts' => -1, // Using -1 loads all posts  

        //'orderby' => 'menu_order', // This ensures images are in the order set in the page media manager  
        'orderby' => 'title', // This ensures images are in alphabetical order

        'order'=> 'ASC',  

        'post_mime_type' => 'image', // Make sure it doesn't pull other resources, like videos  

        'post_parent' => $post->ID, // Important part - ensures the associated images are loaded 

        'post_status' => null, 

        'post_type' => 'attachment'  

    );  

    $images = get_children( $args );   

 

    

    

    

    

	if($images){ 

		$count =0;

	?>

	<div class="custom_gallery">

	<ul id="image-grid">

		<?php foreach($images as $image){ ?>

		 

			<?php $im_year = get_the_time('Y', $image->ID); ?>

			<?php $im_month =  get_the_time('n', $image->ID); ?>

			<?php 

			$imagesrc =wp_get_attachment_image_src($image->ID,'thumbnail');

			if(($q_month == $im_month) && ($q_year == $im_year)): 

			

				$count++;

			

			?>

			 <li>

			 	<a href="<?php echo $image->guid; ?>" rel="fancy-gallery">

					<img src="<?php echo $imagesrc[0] ;//$image->guid; ?>"  alt="<?php echo $image->post_title; ?>" title="<?php echo $image->post_title; ?>" />

				</a>

			</li>	

			<?php else: ?> 

			

				<?php continue;?>

				

			<?php endif;?>

			

		<?php	} ?>

		<?php if($count == 0) {?> 

				<p>No images found</p>

			<?php }?>

	  </ul>

	</div>

  	<?php }  ?>

								</div><!-- .entry-content -->

							</div><!-- #post-## -->

						 <?php endwhile; ?>



						</div><!-- #content -->

					

                                        

                                        </div><!-- #container -->



					<?php //get_sidebar(); ?>

                                      

<div  class="gallery-right" role="complementary">

<?php if ( is_active_sidebar( 'index-right' ) ) : ?>	

			 				

				<ul class="gal-right">

                                    <h3 class="widget-title">Upcoming events</h3>

					<?php dynamic_sidebar( 'index-right' ); ?>

				</ul>

			 

			<?php endif; ?>

                                        <?php if ( is_active_sidebar( 'gallery' ) ) : ?> 		

				<ul class="gal-right">	

					<?php dynamic_sidebar( 'gallery' ); ?>

				</ul>

                           

			<?php endif; ?> </div>

                                        

					<?php get_footer(); ?>