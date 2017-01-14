if (jQuery && jQuery.fn.uploadify) {
	jQuery(document).ready(function($) {
		if (shuploader.frontendimg)
			$('#uploadify').parent().addClass('frontimg');

		var o={
      	 	height        : 30,
   			hideButton    : true,
      	 	swf           : shuploader.path,
       		uploader      : shuploader.uploader,
       		width         : 120,
			fileObjName:'image',
			formData:{
				data:shuploader.data,
				is_flash:1
			},
			onUploadProgress:function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
            	var percent=parseInt((bytesTotal/bytesUploaded)*100);
				var tpercent=parseInt((totalBytesTotal/totalBytesUploaded)*100);
				$('#progress').attr('title',file);
				$('#progress > div:eq(0)').css({width:percent+'%'});
				$('#progress > div:eq(1)').css({width:tpercent+'%'});
        	},
			onUploadStart:function() {
				$('#progress').stop().show().attr('title','');
				$('#progress > div').css({width:0});
			},
			onQueueComplete : function(queueData) {
				$('#progress > div:eq(0)').css({width:'100%'});
				$('#progress > div:eq(1)').css({width:'100%'});
            	$('#progress').delay(1000).fadeOut();
        	},
			onUploadSuccess : function(file,data) {
				data=eval('('+data+')');
				if (!data) {
					alert('Unable to upload');
					return;
				}
				if (data.error) {
					alert(data.error);
					return;	
				}
				uploaded(data);
       		}
		};
		if (shuploader.filetype) {
			o.fileTypeDesc='Files';
        	var t=shuploader.filetype.split(',');
			var p=[];
			for (k in t) {
				if (!t.hasOwnProperty(k))
					continue;
				p.push('*.'+t[k]);					
			}
			if (p.length>0)
				o.fileTypeExts=p.join('; ');
		}
		if (shuploader.limit)
			o.queueSizeLimit=shuploader.limit;
		if (shuploader.frontendimg)
			o.buttonImage=shuploader.frontendimg;
		
		$('#uploadify').uploadify(o);
	});
}
function iniframe() {
	var ciframe=null;
	if (window.parent) {
		var arrFrames = parent.document.getElementsByTagName("IFRAME");
		for (var i = 0; i < arrFrames.length; i++) {
 			if (arrFrames[i].contentWindow === window)
				ciframe=arrFrames[i];
		}
	}
	return ciframe;	
}
function infancybox() {
	var j=window.parent.jQuery;
	var c=iniframe();
	if (!c)
		return false;
	return j(c).parents('#fancybox-content').length;
}
function uploaded(u) {
	var ciframe=iniframe();
	var j=window.parent.jQuery;
	var d=false;
	if (ciframe) {
		var cd=j(ciframe).prev();
		if (cd.hasClass('uploadfilecontainer'))
			d=cd;
	}
	if (!d)
		d=j('#'+u.id+'_uploads');
	if (!u.multi) {
		d.html('');
		j('#'+u.id+'.single').addClass('uploaded');
	}
	var t=j('<div><input type="hidden" name="" value=""> <span></span> <input type="button" class="delete" value="Remove" onclick="jQuery(this).parent().remove();jQuery(\'#'+u.id+'.single\').removeClass(\'uploaded\')" style="cursor:pointer"/>');
	var prefix=(typeof(u.prefix)!='undefined') ? u.prefix : '';
	var path=u.dir;
	var dopath='';
	if (u.newpath) {
		var np=u.newpath.replace(/(^[\\/]+|[\\/]+$)/g,'');
		if (np=='')
			var ap='/';
		else
			var ap='/'+np+'/';
		if (ap!=path) {
			dopath=ap;
			path=ap;
		}
	}	
	j('input:eq(0)',t).val(dopath+prefix+u.image);
	j('input:eq(0)',t).attr('name',u.name);
	j('span',t).text(u.friendly);

	if (u.labelname) {
		var lab=j('<input type="text" style="padding-left:30px;background:url(/img/label.png) no-repeat 3px 5px;margin-bottom:5px;margin-right:5px"/>');
		lab.attr('name',u.labelname).val(u.friendly);
		j('span',t).before(lab);	
	}
	switch (u.filetype) {
		case 'jpg':
		case 'gif':
		case 'png':
			/*
			if (typeof(u.x)=='undefined')
				u.x=50;
			if (typeof(u.y)=='undefined')
				u.y=0;			
			i=j('<img/>');
			j(t).prepend(i);
			j(i).attr('src',shroot+path+'thumb.'+u.x+'x'+u.y+'.'+u.image);
			*/
			break;
	}
	j(d).append(t);

	if (window.parent.fixformname && ((u.labelname && u.labelname.indexOf('_%"!%FORMITEMNAME%!"%')!=-1) || (u.name && u.name.indexOf('_%"!%FORMITEMNAME%!"%')!=-1)))
		window.parent.fixformname.call(t[0]);
	if (u.callback && typeof(window.parent[u.callback])=='function') {
		window.parent[u.callback].call(t[0],u);	
	}
}
if (jQuery) {
	closeon=null;
	window.parent.thismedialibrary=null;
	jQuery(document).ready(function($) {
		if (typeof(shuploaded)!='undefined')
			uploaded(shuploaded);
		if (window.parent && window.parent.jQuery && window.parent.jQuery.fn.fancybox) {
			var j=window.parent.jQuery;
			$('#choose').click(function() {
				var enc=$(this).data('enc');
				var lastpath=$(this).data('lastpath');
				var path=lastpath ? lastpath : (enc.dir) ? enc.dir : 'images';
				var cno=0;
				if (enc.customer) {
					var g=j(enc.customer);
					if (g.length>0) {
						var cno=g.eq(0).val();	
					}
				}
				var data={
					seoheap:'medialibrary',
					path:path,
					filetypes:enc.filetype,
					customer:cno
				};
				window.parent.thismedialibrary={u:uploaded,enc:enc};
				window.thismedialibrary={u:uploaded,enc:enc};
				var u=[];
				for (k in data) {
					if (!data.hasOwnProperty(k) || data[k]=='' || data[k]==0 || !data[k])
						continue;
					u.push(urlencode(k)+'='+urlencode(data[k]));	
				}

				if (infancybox()) {
					if (closeon && closeon.closed==false && closeon.focus) {
						try {
							closeon.focus();
						} catch (e) {
							closeon=null;	
						}
					}
					if (!closeon) {
						var a=window.open('index.php?'+u.join('&'),'media',"location=0,toolbar=0,status=0,menubar=0,directories=0,resizable=1,width=600,height=400");
						closeon=a;
					}
				} else {
					j.fancybox({
						href:'index.php?'+u.join('&'),
						type:'iframe',
						width:600,
						height:400
					});
				}
				return false;
			});
		} else {
			$('#choose').parent().remove();	
		}
	});
}
