jQuery(document).ready(function($) {
	var sethash=function(hash) {
		var d=$(hash);
		if (d.length==0)
			return;
		if (d.hasClass('below')) {
			$('#tabs > .below').hide();
			$('a.tabbutton.belowbutton').removeClass('active');	
		} else {
			$('#tabs > *:not(.below)').hide();
			$('a.tabbutton:not(.belowbutton)').removeClass('active');	
		}
		$('a.tabbutton[href="'+hash+'"]').addClass('active');
		
		d.show();
		var o=d.offset();
		var t=window.pageYOffset+100;
		if (t>o.top) {
			$('html, body').animate({
				scrollTop:o.top-100
			},t-o.top);
		}
	};
	$('.choosecruise').change(function() {
		console.log('Triggered');
		window.location=$(this).val();
		return false;
	});
	$('#tabs').children().each(function() {
		var id=$(this).attr('id');
		if (!id)
			return;
		if ($(this).hasClass('default'))
			$(this).show();
		else {
			var cls=$('<a href="#">Close</a>');
			$(this).prepend(cls);
			cls.click(function() {
				if (!$(this).parent().hasClass('below'))
					$('#tabs .default').show();
				$(this).parent().hide();
				return false;
			});
			$(this).hide();
		}
		$('a[href$="#'+id+'"]').click(function() {
			sethash($(this).attr('href'));
			return false;
		}).addClass('tabbutton').toggleClass('belowbutton',$(this).hasClass('below'));
	});
	$('.gallery-icon a,a.lightbox').fancybox();
	
	$('.UnSelectedRouteText').click(function() {
		var swtitle=$('.switch_title',this);
		if (swtitle.length==0)
			return;
		var sel=$('.SelectedRouteText');
		if (sel.length==0)
			return;
		var s=sel.text();
		sel.text(swtitle.text());
		swtitle.text(s);
		
		$('.return').toggle();
		$('.departure').toggle();
		return false;
	});
});