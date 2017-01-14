jQuery(document).ready(function($) {
	var gourl=function(d) {
		var t=get;
		var c=0;
		for (k in d) {
			if (!d.hasOwnProperty(k))
				continue;
			if (d[k]==t[k])
				continue;
			t[k]=d[k];
			c+=1;
		}
		if (c) {
			var b=[];
			for (k in t) {
				if (!t.hasOwnProperty(k))
					continue;				
				b.push(urlencode(k)+'='+urlencode(t[k]));
			}
			window.location='index.php?'+b.join('&');
		}
	};
	$('.carry').livequery('click',function() {
		var d=$(this).data();
		gourl(d);
		return false;
	});
	$('.down').livequery('click',function() {
		var d=$(this).data();
		d.path=get.path+'/'+d.path;
		gourl(d);
		return false;
	});
	window.setInterval(function() {
		var m=false;
		if (window.opener && window.opener.thismedialibrary)
			m=window.opener.thismedialibrary;
		if (window.parent && window.parent.thismedialibrary)
			m=window.parent.thismedialibrary;
		if (!m)
			window.close();		
	},1000);
	$('.selected input[type="button"]').click(function() {
		var m=false,using=false;
		if (window.opener && window.opener.thismedialibrary) {
			m=window.opener.thismedialibrary;
			using=1;
		}
		if (window.parent && window.parent.thismedialibrary) {
			m=window.parent.thismedialibrary;
			using=0;
		}
		var s=$('.selected input:eq(0)');
		var d={
			name:s.data('name'),
			friendly:s.val(),
			dir:get.path,
			filetype:s.data('filetype')
		};
		if (m) {
			var e=$.extend({},m.enc);
			e.image=d.name;
			e.friendly=d.friendly;
			e.newpath=d.dir;
			e.ft=d.filetype;
			m.u(e);
			if (using==0 && window.parent.jQuery && window.parent.jQuery.fancybox)
				window.parent.jQuery.fancybox.close();
		}

	});
	var meta={};
	var timer=null;
	var getfile=null;
	var metali=null;
	var metadiv=$('<div class="filemeta"></div>').hide();
	$('body').append(metadiv);
	var showmeta=function(m) {
		if (!metali)
			return;
		var p=metali.position();
		metadiv.html(meta[m]);
		metadiv.show();
		
		metadiv.hide();
		//metadiv.css({top:p.top+20,left:p.left});
		metadiv.fadeIn();
	};
	var getmeta=function() {
		timer=null;
		if (!metali)
			return;
		$.ajax({
			url:'index.php?seoheap=filemeta&path='+urlencode(get.path)+'&file='+urlencode(getfile),
			file:getfile,
			success:function(c) {
				meta[this.file]=c;
				showmeta(this.file);
			}
		});
	};
	$('.files > li').click(function() {
		metadiv.hide();
		var s=$('.selected input:eq(0)');
		s.val($('> span',this).text());
		s.data('name',$(this).data('name'));
		s.data('filetype',$(this).attr('class').replace(/^ft\-/,''));
	}).dblclick(function() {
		$(this).click();
		$('.selected input[type="button"]').click();
	}).hover(function() {
		getfile=$(this).data('name');
		var cfile=$(this).data('name');
		metali=$(this);
		if (meta[getfile]) {
			timer=window.setTimeout(function() {
				showmeta(cfile);
			},500);
		} else
			timer=window.setTimeout(getmeta,800);
	},function() {
		if (timer) {
			clearTimeout(timer);
			timer=null;
		}
		metali=null;
		metadiv.fadeOut();		
	});
	var filter=function(t) {
		if (localStorage)
			localStorage['medialib_filter']=t;
		t=t.toLowerCase();
		if (t=='') {
			$('.files > li').show();
			return;
		}
		$('.files > li').each(function() {
			var i=$(this).data('lname');
			if (!i) {
				var i=$(this).data('name').toLowerCase().replace(/^[a-f0-9]{12,}\-/);
				$(this).data('lname',i);
			}
			$(this).toggle(i.indexOf(t)!==-1);
		});
	};
	$('.filter > input[type="text"]').keyup(function() {
		filter($(this).val());
	});
	if (localStorage && localStorage['medialib_filter'])
		$('.filter > input[type="text"]').val(localStorage['medialib_filter']);
	var f=$('.filter > input[type="text"]').val()
	if (f) {
		filter(f);
	}
});