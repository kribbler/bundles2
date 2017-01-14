/*global jQuery:false*/

jQuery(document).ready( function(){
	"use strict";
	jQuery(".newsticker").css("visibility", "hidden");
    var to=setTimeout("showNewsticker()",500);
    livicons();        
});

function showNewsticker(){
	"use strict";
    jQuery(".newsticker").css("visibility", "visible");
}

function livicons(){
	"use strict";
    jQuery("#meta .newsticker_controls .previous").css("background", "none").html('<i class="livicon" data-color="#fff" data-hovercolor="#fff" data-name="video-fast-backward" data-size="14"></i>');
    jQuery("#meta .newsticker_controls .next").css("background", "none").html('<i class="livicon" data-color="#fff" data-hovercolor="#fff" data-name="video-fast-forward" data-size="14"></i>');
}