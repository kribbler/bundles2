<?php
/*
 * Template Name: Cruise
 */
 
$c=cruises::instance();
 
$galleries=array();

$terms=false;
if ($c->fareterms_slug) {
	$terms=get_posts(array(
	  'name'        => $c->fareterms_slug,
	  'post_type'   => 'page',
	  'post_status' => 'publish',
	  'numberposts' => 1
	));
	if ($terms)
		$terms=array_pop($terms);
}


plugin('jquery');
plugin('lightbox');
wp_enqueue_script('cruises','/wp-content/plugins/sh-cruises/cruises.js');
?>

<?php get_header(); ?>

<div class="singlecruise">
	<?php if (have_posts()): ?>
		<?php 
		global $post;
		the_post();
		$fareprice=get_post_meta($post->ID,'cruises_fareprice',true);
		$cancelprice=0;
		if ($fareprice)
			$cancelprice=get_post_meta($post->ID,'cruises_cancelation',true);
		$departure=get_post_meta($post->ID,'cruises_departureandreturn',true);
		$departure_title=get_post_meta($post->ID,'cruises_departure_title',true);
		$return=get_post_meta($post->ID,'cruises_return_body',true);
		$return_title=get_post_meta($post->ID,'cruises_return_title',true);
		if (preg_match_all('#\[gallery([^\]]+)\]#i',$post->post_content,$r)) {
			foreach ($r[1] as $a) {
				$b=shortcode_parse_atts($a);
				if (!empty($b['ids'])) {
					$b=explode(',',$b['ids']);	
					$b=array_walk($b,function($v) use (&$galleries) {
						$v=intval(trim($v));
						if ($v)
							$galleries[$v]=$v;
					});
				}
			}
		}
		$post->post_content=preg_replace('#\[gallery[^\]]+\]#i','',$post->post_content);
		$cruiseopts='';
		global $cruiseopts; // make global for contact form
		echo '<div class="white-wrap container-fluid title">';
			echo '<div class="row">';
				echo '<h1 id="cruise_header">Cruises</h1>';
				echo '<h2 id="cruise_name">- ',the_title(),' -</h2>';
				echo '<div class="boat_container">';
					echo '<div class="container">';
						echo '<div class="boat_buttons buttons">';
						echo '<div id="boat-on-waves"><img src="'.get_stylesheet_directory_uri().'/images/boat-on-waves.png"></div>';
						echo '<div class="row">';
						echo '<div class="col-lg-6 right">';
							echo '<select id="choosecruise" class="choosecruise style_select">';
								echo '<option value="">Please Select A Cruise</option>';
								$current=$post->ID;
								$opts=get_posts(array(
									'post_type'=>'cruises',
									'numberposts' => -1,
									'post_status' => 'any',
								));
								ob_start();
								foreach ($opts as $post) {
									echo '<option value="',the_permalink(),'"';
									if ($post->ID==$current)
										echo ' selected="selected"';
									echo '>';
									the_title();
									echo '</option>';
								}
								$cruiseopts=ob_get_contents();
								wp_reset_postdata();
							echo '</select>';
						echo '</div>';
						echo '<div class="col-lg-6 right">';
							echo '<a href="#schedule">Schedule</a>';
							if ($fareprice) {
								echo '<a href="#rates">Rates</a>';
							}
						echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
		echo '</div>';

		echo '<div class="white-wrap container title">';
		echo '<div id="tabs">';
		
		echo '<div class="white-wrap container page-content default active margin_bottom_40">';
		echo '<div class="row">';
		echo '<div class="col-lg-2">&nbsp;</div>';
		echo '<div class="col-lg-8">';
			echo apply_filters('the_content',$post->post_content);
		echo '</div>';
		echo '<div class="col-lg-2">&nbsp;</div>';
		echo '</div>';
		echo '<div class="buttons center_me">';
				if ($departure || $return) {
					echo '<a href="#departure-and-return" class="btn">Itinerary</a>';
				}
				echo '<a href="#request-a-reservation" class="btn">Request a Reservation</a>';
				echo '<a href="/contact-us/" class="btn">We\'re Here to Help</a>';
			echo '</div>';
		echo '</div>';
		
		if ($fareprice) {
			echo '<div id="rates">';
			echo '<div class="pricing container">';
				$total=$fareprice;
				echo '<div class="row">';
				echo '<div class="col-lg-2">&nbsp;</div>';
				echo '<div class="col-lg-4 left rates_left">';
					echo '<div class="container_rates">';
					echo '<div class="larger">';
					echo '<div class="container-fluid">';
						$c->label('Fare',$c->price($fareprice));
					echo '</div>';
					echo '</div>';
					foreach ($c->tax as $k=>$a) {
						$p=(($fareprice*$a)/100);
						echo '<div class="container-fluid">';
							$c->label($k,$c->price($p));
						echo '</div>';
						$total+=$p;
					}
					if ($cancelprice) {
						$total+=$cancelprice;
						echo '<div class="container-fluid">';
							$c->label('Cancellation Refund Plan',$c->price($cancelprice));
						echo '</div>';
						foreach ($c->aftercancel_tax as $k=>$a) {
							$p=(($cancelprice*$a)/100);
							echo '<div class="container-fluid">';
								$c->label($k,$c->price($p));
							echo '</div>';
							$total+=$p;
						}
					}
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-4 right rates_right">';
					echo '<div class="container_rates">';
						echo '<div class="total">';
						echo 'Total (CAD) '.$c->price($total);
						echo '</div>';
						echo '<em>(for $US pricing please read below)</em>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col-lg-2">&nbsp;</div>';
				echo '</div>';
				
			echo '</div>';
			if ($terms) {
				echo '<div id="terms">';
				echo apply_filters('the_content',$terms->post_content);
				echo '</div>';
			}
			
			echo '</div>';
		}
		
		echo '<div id="schedule" data-ajax="getschedule">';
		echo do_shortcode('[schedule cruise="'.$post->ID.'"]');
		echo '</div>';
		if ($departure || $return) {
			echo '<div id="departure-and-return" class="below">';
			$switch_style='';
			if ($departure_title && $return_title) {
				$switch_style=' style="display:none"';
				echo '<p><span class="IntroText"><span class="SelectedRouteText">'.html($departure_title).'</span></span>';
				echo '<br><a class="UnSelectedRouteText">Switch to <span class="switch_title">'.html($return_title).'</span></a></p>';
			}
			if ($departure && $departure_title && !$switch_style)
				echo '<p><span class="IntroText"><span class="SelectedRouteText">'.html($departure_title).'</span></span>';
			echo '<div class="departure">';
			echo apply_filters('the_content',$departure);
			echo '</div>';
			if ($departure && $departure_title && !$switch_style)
				echo '<p><span class="IntroText"><span class="SelectedRouteText">'.html($return_title).'</span></span>';
			echo '<div class="return"',$switch_style,'>';
			echo apply_filters('the_content',$return);
			echo '</div>';
			echo '</div>';
		}
		echo '<div id="request-a-reservation" class="below">';
		echo '<div class="container">';
		echo '<div class="row">';
		echo do_shortcode('[contactform view="reservation" email="james@seoheap.com"]');
		echo '</div>';
		echo '</div>';
		echo '</div>';
		
		echo '</div>';
		echo '</div>';

		if ( has_post_thumbnail() ) {
			echo '<a class="back_to_top" href="#">BACK TO TOP</a>';
			echo '<div class="container-fluid page-content" id="about_the_route">';
				echo '<div class="row map">';
					echo '<div class="col-lg-12">';
						echo '<div class="container">';
							echo '<h4>Find Out More</h4>';
							echo '<h1 id="frontpage-title1">About the Route</h1>';
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
							echo '<a href="',$large_image_url[0],'" class="lightbox">';
							the_post_thumbnail('medium');
							echo '</a>';
							echo '<div class="help help_photo">';
							echo 'Click/tap to view larger photo';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
		if ($galleries) {
			echo '<div class="white-wrap container page-content default active">';
				echo '<div class="gallery row">';
				echo '<h2 id="frontpage-title4">Gallery</h2>';
				echo do_shortcode('[gallery columns="4" link="file" ids="'.implode(',',$galleries).'"]');
				echo '<div class="help help_photo">';
				echo 'Click/tap to view larger photo';
				echo '</div>';
				echo '</div>';
			echo '</div>';
		}
		?>
	<?php else : ?>
		<?php get_template_part('404'); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
