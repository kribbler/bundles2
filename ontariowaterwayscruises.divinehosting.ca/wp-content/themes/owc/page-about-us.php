<?php get_header(); ?>
<?php 
//plugin('jquery');
//plugin('lightbox');
//wp_enqueue_script('cruises','/wp-content/plugins/sh-cruises/cruises.js');

?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$.each( $('.gallery-icon'), function(i, left) {
	   $('a', left).each(function() {
	   		$(this).addClass('fancybox');
	   		//$(this).append('<span>+</span>');
	   		$( this ).hover(
			  function() {
			    $( this ).append( $( "<span>+</span>" ) );
			  }, function() {
			    $( this ).find( "span:last" ).remove();
			  }
			);
	   });

	   
	});
});
</script>

<link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
<style type="text/css">
    a.fancybox img {
        border: 3px solid #2e5299 !important;
        box-shadow: none;
        -o-transform: scale(1,1); -ms-transform: scale(1,1); -moz-transform: scale(1,1); -webkit-transform: scale(1,1); transform: scale(1,1); -o-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;
    } 
    /*a.fancybox:hover img {
        position: relative; z-index: 999; -o-transform: scale(1.03,1.03); -ms-transform: scale(1.03,1.03); -moz-transform: scale(1.03,1.03); -webkit-transform: scale(1.03,1.03); transform: scale(1.03,1.03);
    }*/

    #fancybox-bg-n, #fancybox-bg-ne, #fancybox-bg-e, #fancybox-bg-se, 
    #fancybox-bg-s, #fancybox-bg-sw, #fancybox-bg-w, #fancybox-bg-nw {
    	display: none;
    }

    #fancybox-content {
    	border: 3px solid #2e5299;
    }

    #fancybox-close {
    	right: 15px;
    	bottom: -15px;
    	top: auto;
    }
</style>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
<script type="text/javascript">
    $(function($){
        var addToAll = false;
        var gallery = true;
        var titlePosition = 'inside';
        $(addToAll ? 'img' : 'img.fancybox').each(function(){
            var $this = $(this);
            var title = $this.attr('title');
            var src = $this.attr('data-big') || $this.attr('src');
            var a = $('<a href="#" class="fancybox"></a>').attr('href', src).attr('title', title);
            $this.wrap(a);
        });
        if (gallery)
            $('a.fancybox').attr('rel', 'fancyboxgallery');
        $('a.fancybox').fancybox({
            titlePosition: 'outside',
            cyclic: true,
            centerOnScroll: false,
            overlayShow: true,
            overlayOpacity: 0,
            margin: 3,
            prevEffect: 'none',
            fitToView: false,
            beforeShow: function () {
            	$("#fancybox-img").css({
		            "width": 800,
		            "height": 600
		        });
            	this.width = 800;
        		this.height = 600;
            }
        });
    });
    $.noConflict();
</script>

<div class="white-wrap container-fluid">
	<div class="row">
		<div class="col-lg-12 bottom_rope">
			<h1 id="about_us"><?php the_title(); ?></h1>
			<h3 class="center_me"><?php echo rwmb_meta('dd_about_video_title1'); ?></h3>
			<div class="container">
				<div class="col-lg-2">&nbsp;</div>
				<div class="col-lg-8 center_me">
					<?php echo apply_filters('the_content', rwmb_meta( 'dd_about_video_url' )); ?>
				</div>
				<div class="col-lg-2">&nbsp;</div>
			</div>

			<div class="container cruising_since_1982">
				<div class="row">
					<div class="col-lg-2">&nbsp;</div>
					<div class="col-lg-8">
						<?php if (have_posts()): ?>
							<?php while(have_posts()) : the_post(); ?>
								<div class="margin_left_right_40">
									<?php the_content(); ?>
								</div>
							<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part('404'); ?>
						<?php endif; ?>
					</div>
					<div class="col-lg-2">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
</div>

<a class="back_to_top_blue" href="#">BACK TO TOP</a>
<a name="meet_the_crew"></a>
<div class="white-wrap container" id="meet_the_family">
	<div class="row">
		<div class="col-lg-12">
			<h4>MEET</h4>
			<div id="the_family">The FAMILY</div>
		</div>
	</div>

	<div class="row team_members">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-2">
			<img src="<?php echo get_template_directory_uri();?>/images/marc.jpg" alt="Marc" />
			<h3 class="center_me">Marc</h3>
		</div>
		<div class="col-lg-2">
			<img src="<?php echo get_template_directory_uri();?>/images/robin.jpg" alt="Robin" />
			<h3 class="center_me">Robin</h3>
		</div>
		<div class="col-lg-2">
			<img src="<?php echo get_template_directory_uri();?>/images/john.jpg" alt="John" />
			<h3 class="center_me">John</h3>
		</div>
		<div class="col-lg-2">
			<img src="<?php echo get_template_directory_uri();?>/images/joy.jpg" alt="Joy" />
			<h3 class="center_me">Joy</h3>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>

	<div class="row margin_top_40 margin_bottom_40">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-8">
			<?php echo rwmb_meta( 'dd_about_meet_the_team' ); ?>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>
</div>

<div class="white-wrap" id="entire_crew">
	<img src="<?php echo get_template_directory_uri();?>/images/entire_crew.jpg" />
</div>

<div class="white-wrap container">
	<div class="row margin_top_40 margin_bottom_40">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-8">
			<?php echo rwmb_meta( 'dd_about_meet_the_team2' ); ?>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>
</div>

<div class="container-fluid bottom_rope margin_bottom_40">
	<div class="row">
		<div class="col-lg-12">
			<div class="white-wrap container cruising_since_1982">
				<div class="gallery row">
					<div class="col-lg-12 margin_bottom_40">
						<?php echo do_shortcode( rwmb_meta( 'dd_about_us_gallery1_images' ) ); ?>
						<div class="help help_photo">
							Click/tap to view larger photo
						</div>
					</div>
				</div>
				<div class="row center_me margin_bottom_40">
					<a href="<?php echo site_url();?>/employment/" class="big_white_button">Work With Us</a>
				</div>
			</div>
		</div>
	</div>
</div>

<a class="back_to_top_blue" href="#">BACK TO TOP</a>

<div class="white-wrap container">
	<div class="row margin_top_40">
		<div class="col-lg-2">&nbsp;</div>
		<div class="col-lg-8">
			<div id="the_ship">THE SHIP</div>
			<div class="center_me">
				<img src="<?php echo get_template_directory_uri();?>/images/the_ship.png" alt="Marc" />
				<br />
			</div>
			<?php echo rwmb_meta( 'dd_about_us_the_ship' ); ?>
		</div>
		<div class="col-lg-2">&nbsp;</div>
	</div>
</div>

<a class="back_to_top_blue" href="#">BACK TO TOP</a>

<div class="container-fluid margin_top_40">
	<div class="row">
		<div class="col-lg-12">
			<div class="white-wrap container">
				<div class="gallery row">
					<div class="col-lg-12 margin_bottom_40">
						<?php echo do_shortcode( rwmb_meta( 'dd_about_us_gallery2_images' ) ); ?>
						<div class="help help_photo">
							Click/tap to view larger photo
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid margin_bottom_40">
	<div class="row margin_bottom_40">
		<h2>THE KAWARTHA VOYAGER</h2>
		<div class="col-lg-4 move_top_60 max_img_width">
			<img src="<?php echo get_template_directory_uri();?>/images/ship-graphic-01.jpg" alt="" />
		</div>

		<div class="col-lg-4 center_me margin_top_40">
			<div class="gallery">
				<a class="fancybox" href="<?php echo get_template_directory_uri();?>/images/boat_plan.jpg">
					<img src="<?php echo get_template_directory_uri();?>/images/boat_plan.jpg" alt="" />
				</a>
				<div class="help help_photo">
					Click/tap to view larger photo
				</div>
			</div>
		</div>

		<div class="col-lg-4 align_right  max_img_width">
			<img src="<?php echo get_template_directory_uri();?>/images/ship-graphic-02.jpg" alt="" />
		</div>
	</div>

	<div class="row margin_top_40 margin_bottom_40">
		<div class="center_me">
			<a href="<?php echo site_url();?>/request-a-reservation/" class="big_white_button">Request a Reservation</a>
		</div>
	</div>
</div>
<?php get_footer();