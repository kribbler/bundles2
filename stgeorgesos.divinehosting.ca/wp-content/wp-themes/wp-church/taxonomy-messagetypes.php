<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package Netstudio
 * @subpackage One point oh
 * @since Netstudio 1.0
 */

ob_start();
dynamic_sidebar( 'featured-image' );
$side=ob_get_contents();
ob_end_clean();

get_header(); ?>
<?php
$ppp=3;
$page=(empty($_GET['page']) || !is_numeric($_GET['page'])) ? 1 : intval($_GET['page']);
if ($page<1)
	$page=1;
$cpage=$page;
$offset = $ppp*($page-1);

if ($offset<0)
	$offset=0;

$args=array(
	'post_type'=>'messages',
	'posts_per_page'  => $ppp,
	'offset'          => $offset,
	'orderby'         => 'post_date',
    'order'           => 'DESC',
);
if (isset($_GET['month']))
	$args['monthnum']=$_GET['month'];
if (isset($_GET['yr']))
	$args['year']=$_GET['yr'];

$query = new WP_Query($args);

$args['numberposts']=-1;
$args['posts_per_page']=-1;
$args_no_offset=get_posts($args);
$total_posts = count($args_no_offset); // e.g. 33
$cnumpages = ceil($total_posts / $ppp); // e.g. ceil(33/10) = ceil(3.3) = 4

?>

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
							<h1 class="entry-title"><?php single_cat_title(); ?></h1>
							<?php if ( $query->have_posts() ) while ( $query->have_posts() ) : $query->the_post(); ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
								<div class="fwrapper">
									<div class="finfo">
										<h4><?php the_title(); ?></h4>
										<?php 
										$past = get_post_meta(get_the_ID(), 'netlabs_preacher' , true); 
										$evnt = get_post_meta(get_the_ID(), 'netlabs_messevent' , true);
										$dte = get_post_meta(get_the_ID(), 'netlabs_messagedate' , true);
										$pssg = get_post_meta(get_the_ID(), 'netlabs_passage' , true);
										$yout = get_post_meta(get_the_ID(), 'netlabs_messyoutube' , true);  
										$vimeo = get_post_meta(get_the_ID(), 'netlabs_messvimeo' , true); 
										$mplink = get_post_meta(get_the_ID(), 'netlabs_uploadlink' , true);        
										?>
										<?php if ($past || $evnt || $dte) { ?>
										<p><?php echo $past; ?>
											<?php if ($evnt) {?>
					 						at  <?php echo $evnt; ?>
											<?php } ?>
											<?php if ($dte) {?>
					 						- <?php echo $dte; ?>
					 						<?php } ?>
					 					</p>
					 					<?php } ?>
<!--										<span> <?php //echo book_replace($pssg); ?></span>-->
                                                                                 <?php the_excerpt(30);?>
									</div>
									<div class="ftd">
										<?php if ($yout) {?>	
										<div class="fvid" rel="<?php the_ID(); ?>">
											<a class="vid" href="http://www.youtube.com/watch?v=<?php echo $yout; ?>"><?php _e( 'video', 'wp-church' ); ?></a>
										</div>
										<?php } ?>
										<?php if ($vimeo) {?>	
										<div class="fvid" rel="<?php the_ID(); ?>">
											<a class="vim" href="http://vimeo.com/<?php echo $vimeo; ?>"><?php _e( 'video', 'wp-church' ); ?></a>
										</div>
										<?php } 
										 if ($mplink) {
											echo '<div rel="' . $mplink . '" class="fmp"></div>';
										} else {											
										 get_mpt(get_the_ID());
										}
										 
										?>
										<div class="finf" rel="<?php the_ID(); ?>">
											<a href="<?php the_permalink(); ?>"><?php _e( 'more', 'wp-church' ); ?></a>
										</div>										
									</div>
									<div class="clear"></div>
									<div class="infoholder" style="margin-top: 10px;"></div>
								</div>
							</div><!-- #post-## -->
							<?php endwhile; ?>
							<?php //adminace_paging(); ?>
                            <?php
							echo '<div style="float:left;width:100%">';
							$link='/messagetypes/all-messages/?';
							if (isset($_GET['month']))
								$link.='month='.intval($_GET['month']).'&';
							if (isset($_GET['yr']))
								$link.='yr='.intval($_GET['yr']).'&';	
							if ($cpage>1) {
								if ($cpage>2)
									$l=$link.'page='.($cpage-1);
								else
									$l=rtrim($link,'&?');
								echo '<a href="',$l,'" style="float:left">&lt;&lt; Previous</a>';
							}
							if ($cnumpages>$cpage)
								echo '<a href="',$link,'page='.($cpage+1).'" style="float:right">Next &gt;&gt;</a>';
							echo '</div>';
							?>
						</div><!-- #content -->
					</div><!-- #container -->

					<?php// get_sidebar(); ?>
                                         <?php if ( is_active_sidebar( 'index-page' ) ) : ?>	
                                <div  class="home-right" role="complementary">				
				<ul class="right">	
					<?php echo $side;
					dynamic_sidebar( 'index-page' ); ?>
				</ul>
                            </div>
			<?php endif; ?>
					<?php get_footer(); ?>