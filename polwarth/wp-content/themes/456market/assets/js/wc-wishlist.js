/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
	wc_wishlist();
});


function wc_wishlist() {
	jQuery("#wishlist_description, .form-row textarea, .wl-form select, .find-input, .wl-priv-sel, .wl-sel").addClass("form-control");
	jQuery(".wl-search-form .button, .cart_item .button, .cart_table_item .button, .form-row .button, .modal-footer .button").removeClass("button alt").addClass("btn btn-primary");
	jQuery(".modal-header .close").removeClass("button alt").addClass("btn btn-default btn-xs");
	jQuery("#wl-wrapper .wl-row .button, .wl-but, .wl-add-all").removeClass("button alt").addClass("btn btn-default");
}