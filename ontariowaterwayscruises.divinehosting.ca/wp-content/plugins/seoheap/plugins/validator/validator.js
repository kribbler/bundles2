jQuery(document).ready(function($) {
	$('.required').each(function() {
		var f=$(this).parents('form:eq(0)');
		$(this).find('input,textarea,select').addClass('required');
		if (f.length>0 && !f.hasClass('validator')) {
			f.addClass('validator');
			f.submit(function() {
				if (!validate.call(this,true)) {
					if (f.hasClass('highlight'))
						highlightinvalid.call(f);
					return false;
				}
			});
		}
	});
});
function validate(visible) {
	var $=jQuery;
	var nowhen=function() {
		return $(this).parents('.when.false').length==0;
	};
	var r=$('input,textarea,select',this).filter('.required'+((visible) ? ':visible' : ''));
	r.removeClass('invalid');
	r.parents('.required').removeClass('invalid');
	r=r.filter(nowhen);
	r.each(function() {
		var v=$(this).val();
		var m=$(this).data('match');
		var valid=false;
		switch (m) {
			case 'email':
				valid=v.match(/.@[a-z\-]+\.[a-z\.]+$/i);
				break;
			default:
				valid=(v!='');
		}
		$(this).toggleClass('invalid',!valid);
		$(this).parents('.required').toggleClass('invalid',!valid);
		var n=$(this).data('invalid');
		if (n) {
			n.remove();
			$(this).data('invalid',null);
		}
	});
	var i=$('.invalid',this).filter(nowhen);
	var v=i.length==0;
	$(this).toggleClass('invalid',v);
	if (!v) {
		setTimeout(function() {
			var t=i.eq(0).position();
			$(window).scrollTop(t.top-200);
			i[0].focus();
		},100);
	}
	return v;
}
function highlightinvalid() {
	var $=jQuery;
	var r=$('input,textarea,select',this).filter('.invalid');
	r.each(function() {
		var m=$(this).data('message');
		if (typeof(m)=='undefined')
			m='Error';
		if (!m)
			return;
		var p=$(this).offset();
		var w=$(this).outerWidth();
		var h=$(this).outerHeight();
		var n=$('<div class="invalidmessage"/>');
		n.text(m);
		n.css({position:'absolute',top:p.top,left:p.left+w});
		$('body').append(n);
		if ($(this).filter(':focus').length==0)
			n.hide();
		$(this).focus(function() {
			var m=$(this).data('invalid');
			if (m)
				m.show();
		}).blur(function() {
			var m=$(this).data('invalid');
			if (m)
				m.hide();			
		});
		n.data('input',$(this));
		$(this).data('invalid',n);
	});
}