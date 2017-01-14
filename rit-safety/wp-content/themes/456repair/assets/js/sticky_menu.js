/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
    sticky_menu();
    sticky_menu2();
});

function sticky_menu() {
    
jQuery('.header-bottom-wrap').waypoint(function (direction) {
        jQuery(this).toggleClass("affix", direction === "down");
    }, {
  offset: function (direction) {
    return -jQuery('#header').outerHeight()+150;
  }
});

jQuery('.header-bottom').waypoint(function (direction) {
        jQuery(this).toggleClass("affix", direction === "down");
    }, {
  offset: function (direction) {
    return -jQuery('#header').outerHeight()+110;
  }
});

};

function sticky_menu2() {
    
jQuery('.theme-header-wrap').waypoint(function (direction) {
        jQuery(this).toggleClass("affix", direction === "down");
    }, {
  offset: function (direction) {
    return -jQuery('#header').outerHeight()-43;
  }
});

jQuery('.theme-header').waypoint(function (direction) {
        jQuery(this).toggleClass("affix", direction === "down");
    }, {
  offset: function (direction) {
    return -jQuery('#header').outerHeight()-123;
  }
});

};