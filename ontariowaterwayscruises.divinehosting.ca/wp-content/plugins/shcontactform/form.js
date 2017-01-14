jQuery(document).ready(function($) {
	$('.contactformitem').each(function() {
		var fid=$('form:eq(0)',this);
		fid.fadeIn('slow');
		var did=$(this);
		var img=did.data('img');
		if (img) {
			var i=$('<img/>');
			i.attr('src',img);	
		}
		var spinner=null;
		var startload=function() {
			var ty=did.data('type');
			switch (ty) {
				case 'fancybox':
					$.fancybox.showLoading();
					break;
				case 'spin':
					var opts={};
					var col=did.data('col');
					if (col)
						opts.color=col;
					spinner=new Spinner(opts).spin($(did)[0]);
					break;
			}
			did.addClass('loading');
		};
		var endload=function() {
			var ty=did.data('type');
			switch (ty) {
				case 'fancybox':
					$.fancybox.hideLoading();
					break;
				case 'spin':
					spinner.stop();
					break;
			}
			did.removeClass('loading');
		}
		fid.submit(function() {
			$('.invalid[disabled]',fid).removeClass('invalid');
			$('.required:not([disabled])',fid).each(function() {
				var m=$(this).data('match');
				var t=$(this).val();
				var valid=false;
				switch (m) {
					case 'email':
						valid=t.match(/.@[a-z\-]+\.[a-z\.]+$/i);
						break;
					default:
						valid=(t!=='');
				}
				$(this).toggleClass('invalid',!valid);
			});
			if ($('.invalid:not([disabled])',fid).length>0) {
				$('.error',did).html('Error: Please fill in all fields marked in red.');
				return false;
			} else
				$('.error',did).html('');
			startload();
			var i=fid.find('input,textarea,select').filter(':not([disabled])');
			$.ajax({
				url:window.location.href,
				data:i.serialize(),
				type:'post',
				loading:false,
				success:function(c) {
					var sent=c.indexOf('EMAIL_SENT_SUCCESSFULLY')!=-1;
					if (sent) {
						did.hide();
						endload();
						fid.html('<div class="success">'+did.data('success')+'</div>');
						fid.css({paddingBottom:40});
						did.fadeIn();
						if (window.parent && window.parent.jQuery && window.parent.jQuery.fancybox && window.location.pathname.indexOf('tmpl=component')!=-1) {
							window.setTimeout(function() {
								window.parent.jQuery.fancybox.close();
							},2000);
						}
					} else {
						endload();
						$('.error',did).html('Error: Unable to send the email at this time');						
					}
				},
				error:function() {
					endload();
					$('.error',did).html('Error: Unable to send the email at this time');
				}
			});
			return false;
		});
	});
	
	var showcontactforms=function() {
		$('.contacttype > div').each(function() {
			var s=($(this).hasClass('checked')) ? true : false;
			var m=$(this).data('id');
			$('.contactformitem[data-whichform]').each(function() {
				var w=$(this).data('whichform');
				
				if (w==m) {
					$(this).toggle(s);
					console.log(w,m,s);
				}
			});
		});
	}
	$('.contacttype').click(function(event) {
		var t=event.target;
		var p=$(t).parent();
		if (p.length==0 || !p.hasClass('contacttype'))
			return;
		$('> div',p).removeClass('checked');
		$(t).addClass('checked');
		showcontactforms();
	});
	showcontactforms();
});
