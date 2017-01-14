jQuery(document).ready(function($) {
	$('#frontpage-title1').circleType({radius: 400, fluid: true});
	$('#frontpage-title2').circleType({radius: 400, fluid: true});
	$('#frontpage-title3').circleType({radius: 400, fluid: true});
	$('#frontpage-title4').circleType({radius: 400, fluid: true});
	$('#cruise_header').circleType({radius: 400, fluid: true});
	$('#the_family').circleType({radius: 400, fluid: true});
	$('#the_ship').circleType({radius: 400, fluid: true});
	$('#about_us').circleType({radius: 400, fluid: true});
	$('#passenger_title').circleType({radius: 400, fluid: true});
	
	$('.back_to_top').click(function(){
				$('html, body').animate({scrollTop : 0},800);
				return false;
		  });

	$('#activate_mobile_menu').click(function($){
	      jQuery('#mobile_menu_holder').toggle("slide");
	      console.log('hhh');
	});

	$('#mobile_close').click(function(){
		jQuery('#mobile_menu_holder').toggle("slide");
	})
});

jQuery( window ).on('resize',fixBannerPositioning);
jQuery( document ).ready(function(){
	fixBannerPositioning();
});

function fixBannerPositioning(){
	jQuery('.admin-bar #header-banner').css('margin-top',(jQuery('#wpadminbar').css('position')=="fixed"?jQuery('#wpadminbar').outerHeight(true):'0'));
	jQuery('body').css('padding-top',jQuery('#header-banner').outerHeight(true));
console.log('#header-banner').height()
}