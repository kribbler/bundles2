/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
	wc_catalog();
});


function wc_catalog() {
	jQuery(".location-picker .country_to_state").addClass("form-control");
	jQuery(".location-picker input[type='submit']").addClass("btn btn-primary");
}