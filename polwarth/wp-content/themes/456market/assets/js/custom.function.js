/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
    functions();
});
function functions() {
	
	"use strict";
    prettyPrint();
	
	jQuery(".wpcf7 .wpcf7-submit").addClass("btn-primary").addClass("btn").addClass("btn-normal");
	
    jQuery('.widget_product_categories ul ul').hide().click(function(e) {
        e.stopPropagation();
    });
 
    jQuery('.widget_product_categories ul > li > ul.children').before('<span class="toggle">[+]</span>');
 
    var current_cat = jQuery('.widget_product_categories ul > li.current-cat, .widget_product_categories ul > li.current-cat-parent');
    
    current_cat.children('.toggle').html("[-]");
    current_cat.children('ul').slideDown().addClass('opened');
    
    
    jQuery('.widget_product_categories ul > li > ul.children').each(function() {
        jQuery(this).parent().children('.toggle').toggle(function() {
			if(jQuery(this).parent().children('ul').hasClass('opened')){
			jQuery(this).html("[+]");
			jQuery(this).parent().children('ul').slideUp();
			jQuery(this).parent().children('ul').removeClass('opened').addClass('closed');
			}else{
			jQuery(this).html("[-]");
			jQuery(this).parent().children('ul').slideDown();
			jQuery(this).parent().children('ul').removeClass('closed').addClass('opened');
			}
        }, function() {
			if(jQuery(this).parent().children('ul').hasClass('closed')){
			jQuery(this).html("[-]");
			jQuery(this).parent().children('ul').slideDown();
			jQuery(this).parent().children('ul').removeClass('closed').addClass('opened');
			}else{
			jQuery(this).html("[+]");
			jQuery(this).parent().children('ul').slideUp();
			jQuery(this).parent().children('ul').removeClass('opened').addClass('closed');
		}
        });    
    });

    jQuery(".gallery-item .gallery-icon a").each(function() {
    
	jQuery(this).addClass("thumbnail");
	
	});
    
	jQuery(".span4.one-column:nth-child(3n+1)").css({"margin-left":"0"});
	jQuery(".span3.one-column:nth-child(4n+1)").css({"margin-left":"0"});
	jQuery('<div class="clearfix"></div>').insertAfter(".span4.one-column:nth-child(3n)");
    jQuery('<div class="clearfix"></div>').insertAfter(".span3.one-column:nth-child(4n)");
    
    jQuery('.price_slider_amount button').removeClass("button").addClass("btn btn-small btn-primary");
    jQuery('.group_table a.product_type_external').removeClass('btn-normal btn-primary').addClass("btn-small btn-default");
    jQuery('.woo_compare_widget_button_container a').removeClass("woo_compare_button_go woo_compare_widget_button_go").addClass("btn btn-small btn-primary");
	jQuery(".testimonial").carousel({interval: 10000, pause: "hover"});
	jQuery(".testimonial").each(function(){
		jQuery(this).find('.item:first').addClass('active');
	});

	jQuery("#searchform #searchsubmit").addClass("btn btn-normal");
	jQuery("#searchform #searchsubmit").addClass("btn-primary");
	jQuery('.widget_search #s').addClass("span8");
	jQuery(".form-submit #submit").addClass("btn btn-normal").removeAttr("id");
	//wrap-tagline
	var wrapHeight = jQuery('.wrap-tagline').outerHeight();
	var centring = (210-wrapHeight)/2;
	jQuery('.wrap-tagline').css({marginTop: centring});
	// bootstrap tooltip
    jQuery(".ttip").tooltip();
	jQuery('.wpcf7-text').focus(function(){
	if(jQuery(this).val()===this.defaultValue){
	jQuery(this).val('');
	}
	});
	
	// if field is empty afterward, add text again
	jQuery('.wpcf7-text').blur(function(){
	if(jQuery(this).val()===''){
	jQuery(this).val(this.defaultValue);
	}
	});
	
	// comment form
	// clear input on focus
	jQuery('#commentform input').focus(function(){
	if(jQuery(this).val()===this.defaultValue){
	jQuery(this).val('');
	}
	});
	
	// if field is empty afterward, add text again
	jQuery('#commentform input').blur(function(){
	if(jQuery(this).val()===''){
	jQuery(this).val(this.defaultValue);
	}
	});
	
	// clear input on focus
	jQuery('#commentform textarea').focus(function(){
	if(jQuery(this).val()===this.defaultValue){
	jQuery(this).val('');
	}
	});
	
	// if field is empty afterward, add text again
	jQuery('#commentform textarea').blur(function(){
	if(jQuery(this).val()===''){
	jQuery(this).val(this.defaultValue);
	}
	});
	
	// clear input on focus
	jQuery('.form-search input').focus(function(){
		if(jQuery(this).val()===this.defaultValue){
			jQuery(this).val('');
		}
	});
	
	// if field is empty afterward, add text again
	jQuery('.form-search input').blur(function(){
		if(jQuery(this).val()===''){
			jQuery(this).val(this.defaultValue);
		}
	});
	
	// clear input on focus
	jQuery('#coupon_code').focus(function(){
		if(jQuery(this).val()===this.defaultValue){
			jQuery(this).val('');
		}
	});
	
	// if field is empty afterward, add text again
	jQuery('#coupon_code').blur(function(){
		if(jQuery(this).val()===''){
			jQuery(this).val(this.defaultValue);
		}
	});

    jQuery(".callout").each(function() {
    
    var moduleHeight = jQuery(this).find('.button').prev('.content').height();
    var bnHeight = jQuery(this).find('.button .btn').outerHeight();
    var Height = moduleHeight-20-bnHeight;
    
    jQuery(this).find(".button").css({height: moduleHeight-20, paddingTop: Height/2});
	
	});
	
	// sidebar portfolio
	jQuery(".portfolio-2 .element:nth-child(2n+1)").addClass('alpha').css({"margin-left":"0"});
	jQuery(".portfolio-3 .element:nth-child(3n+1)").addClass('alpha').css({"margin-left":"0"});
	jQuery(".portfolio-4 .element:nth-child(4n+1)").addClass('alpha').css({"margin-left":"0"});

	jQuery('.livicon-bullet.adjust li').prepend('<i class="livicon" data-s="16" data-n="adjust" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.alarm li').prepend('<i class="livicon" data-s="16" data-n="alarm" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.apple li').prepend('<i class="livicon" data-s="16" data-n="apple" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.ban li').prepend('<i class="livicon" data-s="16" data-n="ban" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.barchart li').prepend('<i class="livicon" data-s="16" data-n="barchart" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.barcode li').prepend('<i class="livicon" data-s="16" data-n="barcode" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.beer li').prepend('<i class="livicon" data-s="16" data-n="beer" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bell li').prepend('<i class="livicon" data-s="16" data-n="bell" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bolt li').prepend('<i class="livicon" data-s="16" data-n="bolt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bookmark li').prepend('<i class="livicon" data-s="16" data-n="bookmark" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.briefcase li').prepend('<i class="livicon" data-s="16" data-n="briefcase" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.brush li').prepend('<i class="livicon" data-s="16" data-n="brush" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bug li').prepend('<i class="livicon" data-s="16" data-n="bug" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.calendar li').prepend('<i class="livicon" data-s="16" data-n="calendar" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.camera li').prepend('<i class="livicon" data-s="16" data-n="camera" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.car li').prepend('<i class="livicon" data-s="16" data-n="car" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cellphone li').prepend('<i class="livicon" data-s="16" data-n="cellphone" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.certificate li').prepend('<i class="livicon" data-s="16" data-n="certificate" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.check li').prepend('<i class="livicon" data-s="16" data-n="check" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.check-circle li').prepend('<i class="livicon" data-s="16" data-n="check-circle" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.check-circle-alt li').prepend('<i class="livicon" data-s="16" data-n="check-circle-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.checked-off li').prepend('<i class="livicon" data-s="16" data-n="checked-off" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.checked-on li').prepend('<i class="livicon" data-s="16" data-n="checked-on" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.circle-2 li').prepend('<i class="livicon" data-s="16" data-n="circle" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.circle-alt li').prepend('<i class="livicon" data-s="16" data-n="circle-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.clapboard li').prepend('<i class="livicon" data-s="16" data-n="clapboard" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.clip li').prepend('<i class="livicon" data-s="16" data-n="clip" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.clock li').prepend('<i class="livicon" data-s="16" data-n="clock" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud li').prepend('<i class="livicon" data-s="16" data-n="cloud" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-bolts li').prepend('<i class="livicon" data-s="16" data-n="cloud-bolts" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-rain li').prepend('<i class="livicon" data-s="16" data-n="cloud-rain" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-snow li').prepend('<i class="livicon" data-s="16" data-n="cloud-snow" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-sun li').prepend('<i class="livicon" data-s="16" data-n="cloud-sun" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-down li').prepend('<i class="livicon" data-s="16" data-n="cloud-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.cloud-up li').prepend('<i class="livicon" data-s="16" data-n="cloud-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.code li').prepend('<i class="livicon" data-s="16" data-n="code" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.comment li').prepend('<i class="livicon" data-s="16" data-n="comment" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.comments li').prepend('<i class="livicon" data-s="16" data-n="comments" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.compass li').prepend('<i class="livicon" data-s="16" data-n="compass" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.credit-card li').prepend('<i class="livicon" data-s="16" data-n="credit-card" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.css3 li').prepend('<i class="livicon" data-s="16" data-n="css3" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.dashboard li').prepend('<i class="livicon" data-s="16" data-n="dashboard" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.desktop li').prepend('<i class="livicon" data-s="16" data-n="desktop" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.doc-landscape li').prepend('<i class="livicon" data-s="16" data-n="doc-landscape" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.doc-portrait li').prepend('<i class="livicon" data-s="16" data-n="doc-portrait" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.download li').prepend('<i class="livicon" data-s="16" data-n="download" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.download-alt li').prepend('<i class="livicon" data-s="16" data-n="download-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.drop li').prepend('<i class="livicon" data-s="16" data-n="drop" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.edit li').prepend('<i class="livicon" data-s="16" data-n="edit" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.eye-close li').prepend('<i class="livicon" data-s="16" data-n="eye-close" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.eye-open li').prepend('<i class="livicon" data-s="16" data-n="eye-open" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.film li').prepend('<i class="livicon" data-s="16" data-n="film" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.filter-2 li').prepend('<i class="livicon" data-s="16" data-n="filter" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.fire li').prepend('<i class="livicon" data-s="16" data-n="fire" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.flag li').prepend('<i class="livicon" data-s="16" data-n="flag" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.gear li').prepend('<i class="livicon" data-s="16" data-n="gear" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.gears li').prepend('<i class="livicon" data-s="16" data-n="gears" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.ghost li').prepend('<i class="livicon" data-s="16" data-n="ghost" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.gift li').prepend('<i class="livicon" data-s="16" data-n="gift" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.glass li').prepend('<i class="livicon" data-s="16" data-n="glass" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.globe li').prepend('<i class="livicon" data-s="16" data-n="globe" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.hammer li').prepend('<i class="livicon" data-s="16" data-n="hammer" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.heart li').prepend('<i class="livicon" data-s="16" data-n="heart" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.heart-alt li').prepend('<i class="livicon" data-s="16" data-n="heart-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.help li').prepend('<i class="livicon" data-s="16" data-n="help" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.home li').prepend('<i class="livicon" data-s="16" data-n="home" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.html5 li').prepend('<i class="livicon" data-s="16" data-n="html5" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.image li').prepend('<i class="livicon" data-s="16" data-n="image" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.inbox li').prepend('<i class="livicon" data-s="16" data-n="inbox" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.info li').prepend('<i class="livicon" data-s="16" data-n="info" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.key li').prepend('<i class="livicon" data-s="16" data-n="key" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.lab li').prepend('<i class="livicon" data-s="16" data-n="lab" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.laptop li').prepend('<i class="livicon" data-s="16" data-n="laptop" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.leaf li').prepend('<i class="livicon" data-s="16" data-n="leaf" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.legal li').prepend('<i class="livicon" data-s="16" data-n="legal" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.linechart li').prepend('<i class="livicon" data-s="16" data-n="linechart" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.link li').prepend('<i class="livicon" data-s="16" data-n="link" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.location li').prepend('<i class="livicon" data-s="16" data-n="location" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.lock li').prepend('<i class="livicon" data-s="16" data-n="lock" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.magic li').prepend('<i class="livicon" data-s="16" data-n="magic" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.magic-alt li').prepend('<i class="livicon" data-s="16" data-n="magic-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.magnet li').prepend('<i class="livicon" data-s="16" data-n="magnet" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.mail li').prepend('<i class="livicon" data-s="16" data-n="mail" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.mail-alt li').prepend('<i class="livicon" data-s="16" data-n="mail-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.map li').prepend('<i class="livicon" data-s="16" data-n="map" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.minus li').prepend('<i class="livicon" data-s="16" data-n="minus" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.minus-alt li').prepend('<i class="livicon" data-s="16" data-n="minus-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.money li').prepend('<i class="livicon" data-s="16" data-n="money" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.more li').prepend('<i class="livicon" data-s="16" data-n="more" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.move li').prepend('<i class="livicon" data-s="16" data-n="move" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.music li').prepend('<i class="livicon" data-s="16" data-n="music" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.notebook li').prepend('<i class="livicon" data-s="16" data-n="notebook" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.pacman li').prepend('<i class="livicon" data-s="16" data-n="pacman" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.pen li').prepend('<i class="livicon" data-s="16" data-n="pen" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.pencil li').prepend('<i class="livicon" data-s="16" data-n="pencil" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.phone li').prepend('<i class="livicon" data-s="16" data-n="phone" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.piechart li').prepend('<i class="livicon" data-s="16" data-n="piechart" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.piggybank li').prepend('<i class="livicon" data-s="16" data-n="piggybank" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.plane-down li').prepend('<i class="livicon" data-s="16" data-n="plane-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.plane-up li').prepend('<i class="livicon" data-s="16" data-n="plane-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.plus li').prepend('<i class="livicon" data-s="16" data-n="plus" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.plus-alt li').prepend('<i class="livicon" data-s="16" data-n="plus-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.presentation li').prepend('<i class="livicon" data-s="16" data-n="presentation" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.printer li').prepend('<i class="livicon" data-s="16" data-n="printer" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.qrcode li').prepend('<i class="livicon" data-s="16" data-n="qrcode" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.question li').prepend('<i class="livicon" data-s="16" data-n="question" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.quote-left li').prepend('<i class="livicon" data-s="16" data-n="quote-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.quote-right li').prepend('<i class="livicon" data-s="16" data-n="quote-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.remove li').prepend('<i class="livicon" data-s="16" data-n="remove" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.remove-alt li').prepend('<i class="livicon" data-s="16" data-n="remove-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.remove-circle li').prepend('<i class="livicon" data-s="16" data-n="remove-circle" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.responsive li').prepend('<i class="livicon" data-s="16" data-n="responsive" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.responsive-menu li').prepend('<i class="livicon" data-s="16" data-n="responsive-menu" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.retweet li').prepend('<i class="livicon" data-s="16" data-n="retweet" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.rocket li').prepend('<i class="livicon" data-s="16" data-n="rocket" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sandglass li').prepend('<i class="livicon" data-s="16" data-n="sandglass" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.screenshot li').prepend('<i class="livicon" data-s="16" data-n="screenshot" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.search li').prepend('<i class="livicon" data-s="16" data-n="search" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.settings li').prepend('<i class="livicon" data-s="16" data-n="settings" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.share li').prepend('<i class="livicon" data-s="16" data-n="share" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.shield li').prepend('<i class="livicon" data-s="16" data-n="shield" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.shopping-cart-2 li').prepend('<i class="livicon" data-s="16" data-n="shopping-cart" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.shuffle li').prepend('<i class="livicon" data-s="16" data-n="shuffle" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sign-in li').prepend('<i class="livicon" data-s="16" data-n="sign-in" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sign-out li').prepend('<i class="livicon" data-s="16" data-n="sign-out" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.signal li').prepend('<i class="livicon" data-s="16" data-n="signal" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sitemap li').prepend('<i class="livicon" data-s="16" data-n="sitemap" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sort li').prepend('<i class="livicon" data-s="16" data-n="sort" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sort-down li').prepend('<i class="livicon" data-s="16" data-n="sort-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sort-up li').prepend('<i class="livicon" data-s="16" data-n="sort-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.star-empty li').prepend('<i class="livicon" data-s="16" data-n="star-empty" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.star-full li').prepend('<i class="livicon" data-s="16" data-n="star-full" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.star-half li').prepend('<i class="livicon" data-s="16" data-n="star-half" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.stopwatch li').prepend('<i class="livicon" data-s="16" data-n="stopwatch" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.sun li').prepend('<i class="livicon" data-s="16" data-n="sun" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.tablet li').prepend('<i class="livicon" data-s="16" data-n="tablet" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.tag li').prepend('<i class="livicon" data-s="16" data-n="tag" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.tags li').prepend('<i class="livicon" data-s="16" data-n="tags" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.tasks li').prepend('<i class="livicon" data-s="16" data-n="tasks" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.thermo-down li').prepend('<i class="livicon" data-s="16" data-n="thermo-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.thermo-up li').prepend('<i class="livicon" data-s="16" data-n="thermo-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.thumbs-down li').prepend('<i class="livicon" data-s="16" data-n="thumbs-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.thumbs-up li').prepend('<i class="livicon" data-s="16" data-n="thumbs-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.trash li').prepend('<i class="livicon" data-s="16" data-n="trash" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.tree li').prepend('<i class="livicon" data-s="16" data-n="tree" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.trophy li').prepend('<i class="livicon" data-s="16" data-n="trophy" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.truck li').prepend('<i class="livicon" data-s="16" data-n="truck" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.umbrella li').prepend('<i class="livicon" data-s="16" data-n="umbrella" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.unlock li').prepend('<i class="livicon" data-s="16" data-n="unlock" data-color="#363636" data-hc="#959595"></i>');      
	jQuery('.livicon-bullet.upload li').prepend('<i class="livicon" data-s="16" data-n="upload" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.upload-alt li').prepend('<i class="livicon" data-s="16" data-n="upload-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.user li').prepend('<i class="livicon" data-s="16" data-n="user" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.users li').prepend('<i class="livicon" data-s="16" data-n="users" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.warning li').prepend('<i class="livicon" data-s="16" data-n="warning" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.warning-alt li').prepend('<i class="livicon" data-s="16" data-n="warning-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.wrench li').prepend('<i class="livicon" data-s="16" data-n="wrench" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.zoom-in li').prepend('<i class="livicon" data-s="16" data-n="zoom-in" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.zoom-out li').prepend('<i class="livicon" data-s="16" data-n="zoom-out" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-down li').prepend('<i class="livicon" data-s="16" data-n="angle-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-left li').prepend('<i class="livicon" data-s="16" data-n="angle-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-right li').prepend('<i class="livicon" data-s="16" data-n="angle-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-up li').prepend('<i class="livicon" data-s="16" data-n="angle-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-double-down li').prepend('<i class="livicon" data-s="16" data-n="angle-double-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-double-left li').prepend('<i class="livicon" data-s="16" data-n="angle-double-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-double-right li').prepend('<i class="livicon" data-s="16" data-n="angle-double-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-double-up li').prepend('<i class="livicon" data-s="16" data-n="angle-double-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-wide-down li').prepend('<i class="livicon" data-s="16" data-n="angle-wide-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-wide-left li').prepend('<i class="livicon" data-s="16" data-n="angle-wide-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-wide-right li').prepend('<i class="livicon" data-s="16" data-n="angle-wide-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.angle-wide-up li').prepend('<i class="livicon" data-s="16" data-n="angle-wide-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-down li').prepend('<i class="livicon" data-s="16" data-n="arrow-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-left li').prepend('<i class="livicon" data-s="16" data-n="arrow-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-right li').prepend('<i class="livicon" data-s="16" data-n="arrow-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-up li').prepend('<i class="livicon" data-s="16" data-n="arrow-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-circle-down li').prepend('<i class="livicon" data-s="16" data-n="arrow-circle-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-circle-left li').prepend('<i class="livicon" data-s="16" data-n="arrow-circle-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-circle-right li').prepend('<i class="livicon" data-s="16" data-n="arrow-circle-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.arrow-circle-up li').prepend('<i class="livicon" data-s="16" data-n="arrow-circle-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.caret-down li').prepend('<i class="livicon" data-s="16" data-n="caret-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.caret-left li').prepend('<i class="livicon" data-s="16" data-n="caret-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.caret-right li').prepend('<i class="livicon" data-s="16" data-n="caret-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.caret-up li').prepend('<i class="livicon" data-s="16" data-n="caret-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.chevron-down li').prepend('<i class="livicon" data-s="16" data-n="chevron-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.chevron-left li').prepend('<i class="livicon" data-s="16" data-n="chevron-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.chevron-right li').prepend('<i class="livicon" data-s="16" data-n="chevron-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.chevron-up li').prepend('<i class="livicon" data-s="16" data-n="chevron-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.exchange li').prepend('<i class="livicon" data-s="16" data-n="exchange" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.external-link li').prepend('<i class="livicon" data-s="16" data-n="external-link" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.hand-down li').prepend('<i class="livicon" data-s="16" data-n="hand-down" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.hand-left li').prepend('<i class="livicon" data-s="16" data-n="hand-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.hand-right li').prepend('<i class="livicon" data-s="16" data-n="hand-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.hand-up li').prepend('<i class="livicon" data-s="16" data-n="hand-up" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.recycled li').prepend('<i class="livicon" data-s="16" data-n="recycled" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.redo li').prepend('<i class="livicon" data-s="16" data-n="redo" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.refresh li').prepend('<i class="livicon" data-s="16" data-n="refresh" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-big li').prepend('<i class="livicon" data-s="16" data-n="resize-big" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-big-alt li').prepend('<i class="livicon" data-s="16" data-n="resize-big-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-horizontal li').prepend('<i class="livicon" data-s="16" data-n="resize-horizontal" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-horizontal-alt li').prepend('<i class="livicon" data-s="16" data-n="resize-horizontal-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-small li').prepend('<i class="livicon" data-s="16" data-n="resize-small" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-small-alt li').prepend('<i class="livicon" data-s="16" data-n="resize-small-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-vertical li').prepend('<i class="livicon" data-s="16" data-n="resize-vertical" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.resize-vertical-alt li').prepend('<i class="livicon" data-s="16" data-n="resize-vertical-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.rotate-left li').prepend('<i class="livicon" data-s="16" data-n="rotate-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.rotate-right li').prepend('<i class="livicon" data-s="16" data-n="rotate-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.undo li').prepend('<i class="livicon" data-s="16" data-n="undo" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.align-center li').prepend('<i class="livicon" data-s="16" data-n="align-center" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.align-justify li').prepend('<i class="livicon" data-s="16" data-n="align-justify" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.align-left li').prepend('<i class="livicon" data-s="16" data-n="align-left" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.align-right li').prepend('<i class="livicon" data-s="16" data-n="align-right" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bold li').prepend('<i class="livicon" data-s="16" data-n="bold" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.columns li').prepend('<i class="livicon" data-s="16" data-n="columns" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.font li').prepend('<i class="livicon" data-s="16" data-n="font" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.italic li').prepend('<i class="livicon" data-s="16" data-n="italic" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.list li').prepend('<i class="livicon" data-s="16" data-n="list" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.list-ol li').prepend('<i class="livicon" data-s="16" data-n="list-ol" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.list-ul li').prepend('<i class="livicon" data-s="16" data-n="list-ul" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.table li').prepend('<i class="livicon" data-s="16" data-n="table" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.underline li').prepend('<i class="livicon" data-s="16" data-n="underline" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-play li').prepend('<i class="livicon" data-s="16" data-n="video-play" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-play-alt li').prepend('<i class="livicon" data-s="16" data-n="video-play-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-stop li').prepend('<i class="livicon" data-s="16" data-n="video-stop" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-pause li').prepend('<i class="livicon" data-s="16" data-n="video-pause" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-eject li').prepend('<i class="livicon" data-s="16" data-n="video-eject" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-backward li').prepend('<i class="livicon" data-s="16" data-n="video-backward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-step-backward li').prepend('<i class="livicon" data-s="16" data-n="video-step-backward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-fast-backward li').prepend('<i class="livicon" data-s="16" data-n="video-fast-backward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-forward li').prepend('<i class="livicon" data-s="16" data-n="video-forward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-step-forward li').prepend('<i class="livicon" data-s="16" data-n="video-step-forward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.video-fast-forward li').prepend('<i class="livicon" data-s="16" data-n="video-fast-forward" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.screen-full li').prepend('<i class="livicon" data-s="16" data-n="screen-full" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.screen-full-alt li').prepend('<i class="livicon" data-s="16" data-n="screen-full-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.screen-small li').prepend('<i class="livicon" data-s="16" data-n="screen-small" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.screen-small-alt li').prepend('<i class="livicon" data-s="16" data-n="screen-small-alt" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.speaker li').prepend('<i class="livicon" data-s="16" data-n="speaker" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.facebook li').prepend('<i class="livicon" data-s="16" data-n="facebook" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.facebook-alt li').prepend('<i class="livicon" data-s="16" data-n="facebook-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.flickr li').prepend('<i class="livicon" data-s="16" data-n="flickr" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.flickr-alt li').prepend('<i class="livicon" data-s="16" data-n="flickr-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.google-plus li').prepend('<i class="livicon" data-s="16" data-n="google-plus" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.google-plus-alt li').prepend('<i class="livicon" data-s="16" data-n="google-plus-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.linkedin li').prepend('<i class="livicon" data-s="16" data-n="linkedin" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.linkedin-alt li').prepend('<i class="livicon" data-s="16" data-n="linkedin-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.pinterest li').prepend('<i class="livicon" data-s="16" data-n="pinterest" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.pinterest-alt li').prepend('<i class="livicon" data-s="16" data-n="pinterest-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.rss li').prepend('<i class="livicon" data-s="16" data-n="rss" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.skype li').prepend('<i class="livicon" data-s="16" data-n="skype" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.twitter li').prepend('<i class="livicon" data-s="16" data-n="twitter" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.twitter-alt li').prepend('<i class="livicon" data-s="16" data-n="twitter-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.wordpress li').prepend('<i class="livicon" data-s="16" data-n="wordpress" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.wordpress-alt li').prepend('<i class="livicon" data-s="16" data-n="wordpress-alt" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.youtube li').prepend('<i class="livicon" data-s="16" data-n="youtube" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.android li').prepend('<i class="livicon" data-s="16" data-n="android" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.ios li').prepend('<i class="livicon" data-s="16" data-n="ios" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.windows li').prepend('<i class="livicon" data-s="16" data-n="windows" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.windows8 li').prepend('<i class="livicon" data-s="16" data-n="windows8" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.chrome li').prepend('<i class="livicon" data-s="16" data-n="chrome" data-hovercolor="#959595"></i>');
	jQuery('.livicon-bullet.firefox li').prepend('<i class="livicon" data-s="16" data-n="firefox" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.ie li').prepend('<i class="livicon" data-s="16" data-n="ie" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.safari li').prepend('<i class="livicon" data-s="16" data-n="safari" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.bootstrap li').prepend('<i class="livicon" data-s="16" data-n="bootstrap" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.jquery li').prepend('<i class="livicon" data-s="16" data-n="jquery" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.raphael li').prepend('<i class="livicon" data-s="16" data-n="raphael" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.paypal li').prepend('<i class="livicon" data-s="16" data-n="paypal" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.livicon-2 li').prepend('<i class="livicon" data-s="16" data-n="livicon" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-one li').prepend('<i class="livicon" data-s="16" data-n="spinner-one" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-two li').prepend('<i class="livicon" data-s="16" data-n="spinner-two" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-three li').prepend('<i class="livicon" data-s="16" data-n="spinner-three" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-four li').prepend('<i class="livicon" data-s="16" data-n="spinner-four" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-five li').prepend('<i class="livicon" data-s="16" data-n="spinner-five" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-six li').prepend('<i class="livicon" data-s="16" data-n="spinner-six" data-color="#363636" data-hc="#959595"></i>');
	jQuery('.livicon-bullet.spinner-seven li').prepend('<i class="livicon" data-s="16" data-n="spinner-seven" data-color="#363636" data-hc="#959595"></i>');

}