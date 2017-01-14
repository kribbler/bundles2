jQuery(document).ready(function($) {
	window.initialise_schedule=function() {
		$('.schedule_view .months a').click(function() {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$('.schedule_table tbody tr').show();
			} else {
				$('.schedule_view .months a').removeClass('active');
				$(this).addClass('active');
				var m=$(this).data('month');
				
				$('.schedule_table tbody tr').each(function() {
					var tm=$(this).data('month');
					if (tm==m)
						$(this).show();
					else
						$(this).hide();
				});
			}
			return false;
		});
		$('.schedule_view .years a').click(function() {
			// load year through ajax and reinitialise links
			var data=$(this).data();
			data.action='schedule_ajax',
			$.ajax({
				url:ajaxurl,
				data:data,
				success:function(r) {
					$('#schedule_container').html('');
					$(r).children().each(function() {
						$('#schedule_container').append(this);
					});
					initialise_schedule();
				},
				error:function() {
					alert('Unable to load schedule');	
				}
			});
			return false;
		});
		if ($.fn.fancybox) {
			$('.popup .popup').each(function() {
				var c=$(this);
				$(this).parents('.popup').click(function() {
					$.fancybox({
						content:'<div>'+c.html()+'</div>'
					});
					return false;
				});
			});
		}
	};
	initialise_schedule();
});