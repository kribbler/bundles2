<?php
/**
 * The main template file.
 *
 */

get_header(); ?>

<div class="container">
	<?php get_slideshow(); ?>
</div>

<?php if (get_option('nets_latestmess')  == 'false') {?>
<div class="lastmess">
	<div class="container">
		<div class="grid10 first">
			<?php $musposts = get_posts('numberposts=1&post_type=messages');
			foreach($musposts as $musentry) { 
				$pagevalue = $musentry->ID;		
				$past = get_post_meta($pagevalue, 'netlabs_preacher' , true); 
				$evnt = get_post_meta($pagevalue, 'netlabs_messevent' , true);
				$dte = get_post_meta($pagevalue, 'netlabs_messagedate' , true);
				$pssg = get_post_meta($pagevalue, 'netlabs_passage' , true);
				$yout = get_post_meta($pagevalue, 'netlabs_messyoutube' , true);  
				$vimeo = get_post_meta($pagevalue, 'netlabs_messvimeo' , true); 
				$mplink = get_post_meta($pagevalue, 'netlabs_uploadlink' , true);   ?>		
			<?php } ?>
			<div class="lasthead"><?php echo get_option('nets_sptlatest')?></div>
			<div class="lasttitle">
			
				<span class="messspan"><?php echo get_the_title($pagevalue); ?></span> <span><?php echo book_replace($pssg); ?></span>
				<?php 
				if ($mplink) {
					echo '<img rel="' . $mplink . '" src="' . get_template_directory_uri() . '/images/micfront.png" class="micfront">';
				} else {											
					get_mpt2($pagevalue); 
				}
										 
				?>		
				
				
				<?php if ($yout) {?>	
					<a class="vid" href="http://www.youtube.com/watch?v=<?php echo $yout; ?>"><img class="movfront" src="<?php echo get_template_directory_uri(); ?>/images/movfront.png"></a>
				<?php } ?>
				<?php if ($vimeo) {?>	
					<a class="vim" href="http://vimeo.com/<?php echo $vimeo; ?>"><img class="movfront" src="<?php echo get_template_directory_uri(); ?>/images/movfront.png"></a>
				<?php } ?>
			
			
			</div>
			<div class="clear"></div>
			<div class="infoholder" style="margin: 0px 0px 0px 170px;"></div>
		</div>
	</div>
</div>


</script> 

<?php } ?>

<div class="bodymid">
	<div class="stripetop">
	<div class="stripebot">
	<div class="hfeed container">
		<div class="mapdiv"></div>
		<div class="clear"></div>
		<div id="main">	
			<?php if (get_option('nets_tagline')){ ?>			
			<div class="mainwelcome">
                            <div class="welcome-msg">
				<h1><?php echo stripslashes(get_option('nets_tagline')); ?></h1>
                            </div>
<!--                                <div class="fb">
                       <span class='st_facebook_large'></span>
                       <span class='st_twitter_large' displayText='Tweet'></span>
                       <div class="fb-txt">
                           <p>Like St.George's on facebook.Join our community for following reasons.</p>
                       </div>
                        </div>-->
			</div>		
			<?php } ?>
                    <div class="home-cnt">
                        <?php  $the_query = new WP_Query( 'page_id=110' );?>
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post();?>
                        <div class="home-left">
                        <?php the_content();?>
                        </div>
                        <?php endwhile;?>
                        <div class="social-icons">
                          <div class="fb">
                       <a href="http://www.facebook.com/stgeorgesowensound" target="_blank">
                       <span class="st_facebook_large" st_processed="yes"><span style="text-decoration:none;color:#000000;display:inline-block;cursor:pointer;" class="stButton"><span class="stLarge" style="background-image: url(http://w.sharethis.com/images/facebook_32.png);"></span><img src="http://w.sharethis.com/images/check-big.png" style="position: absolute; top: -7px; right: -7px; width: 19px; height: 19px; max-width: 19px; max-height: 19px; display: none;"></span></span>
                       </a>
<!--                       <span class='st_twitter_large' displayText='Tweet'></span>-->
                       <div class="fb-txt">
                          <p>Like St.George's on facebook.</p>
                          <p>Join our Community </p>
                          
                       </div>
                        </div>
                    </div>
                    </div>
                    <div class="first-widget">
			<?php if ( is_active_sidebar( 'index-left' ) ) : ?>	
			<div id="primary" class="widget-area grid4 first" role="complementary">				
				<ul class="xoxo">
                                    <h3><a href="/news/">Latest News</a></h3>
					<?php dynamic_sidebar( 'index-left' ); ?>
				</ul>
			</div>
			<?php endif; ?>
                    </div>
                    <div class="second-widget">
			<?php if ( is_active_sidebar( 'index-center' ) ) : ?>	
			<div id="primary" class="widget-area grid4" role="complementary">					
				<ul class="xoxo">
                                    <h3><a href="/messagetypes/all-messages/">Latest Sermons</a></h3>
					<?php dynamic_sidebar( 'index-center' ); ?>
				</ul>
			</div>
			<?php endif; ?>
                    </div>
                    <div class="third-widget">
			<?php if ( is_active_sidebar( 'index-right' ) ) : ?>	
			<div id="primary" class="widget-area grid4" role="complementary">					
				<ul class="xoxo">
                                    <h3><a href="/special-events-2/">Upcoming Events</a></h3>
					<?php dynamic_sidebar( 'index-right' ); ?>
				</ul>
			</div>
			<?php endif; ?>
                    </div>
             <div style="clear:both"></div>
                        <?php if ( is_active_sidebar( 'index-page' ) ) : ?>	
			<div  class="homepage-right" role="complementary">				
				<ul class="right">	
					<?php dynamic_sidebar( 'index-page' ); ?>
				</ul>
			</div>
			<?php endif; ?>
            <?php if ( is_active_sidebar( 'index-bottom' ) ) : ?>	
			<div  class="home-bottom" role="complementary">				
					<?php dynamic_sidebar( 'index-bottom' ); ?>
			</div>
			<?php endif; ?>
                     	
				

<?php get_footer(); ?>
