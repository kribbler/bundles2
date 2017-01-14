/*global jQuery:false */

jQuery(document).ready(function() {
	"use strict";	
    scaleWithGrid();
    scaleWithGridFront();
});


function scaleWithGrid() {
	"use strict";
	var $iframe = jQuery("iframe.scale-with-grid"),
	$fluid = jQuery("iframe.scale-with-grid").parent();

	$iframe.each(function() {
		jQuery(this)
			.data('aspectRatio', this.height / this.width)
			.removeAttr('height')
			.removeAttr('width');
	});

	jQuery(window).resize(function() {
		var newWidth = $fluid.width();
		$iframe.each(function() {
			var $el = jQuery(this);
			$el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
		});
	}).resize();

}
function scaleWithGridFront() {
	"use strict";
	var $iframe = jQuery("iframe.scale-with-grid-front"),
	$fluid = jQuery("iframe.scale-with-grid-front").parent();

	$iframe.each(function() {
		jQuery(this)
			.data('aspectRatio', this.height / this.width)
			.removeAttr('height')
			.removeAttr('width');
	});

	jQuery(window).resize(function() {
		var newWidth = $fluid.width();
		$iframe.each(function() {
			var $el = jQuery(this);
			$el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
		});
	}).resize();

}