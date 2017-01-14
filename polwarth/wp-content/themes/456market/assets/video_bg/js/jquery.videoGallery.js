
/*
 * HTML5 Video & Youtube Background v2.21
 */

(function($) {

	$.videoGallery = function (wrapper, flashHolder, settings) {
	
	var _componentInited=false;
	var baseURL = window.location.href;
	//console.log(baseURL);

	var componentWrapper = $(wrapper);
	var mediaPreloader = componentWrapper.find('.mediaPreloader').css('display','block');
	
	var isMobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent));
	//isMobile=true;

	var ipadOrientation=Math.abs(window.orientation) == 90 ? 'landscape' : 'portrait';
	//console.log(ipadOrientation);
	window.onorientationchange = detectOrientation;
	function detectOrientation(){
		if(typeof window.onorientationchange != 'undefined'){
			//alert(window.orientation);
			if ( orientation == 0 ) {
				ipadOrientation='portrait';
				//Do Something In Portrait Mode
				// alert('Portrait 0');
			}
			else if ( orientation == 90 ) {
				ipadOrientation='landscape';
				 //Do Something In Landscape Mode
				 //alert('Landscape 90 The screen is turned to the left.');
			}
			else if ( orientation == -90 ) {
				ipadOrientation='landscape';
				 //Do Something In Landscape Mode
				 //alert('Landscape -90 The screen is turned to the right.');
			}
			else if ( orientation == 180 ) {
				ipadOrientation='portrait';
				 //Do Something In Portrait Mode
				 //alert('Portrait 180 Upside down portrait.');
			}
		}
	}
	
	var isIOS=false, agent = navigator.userAgent;
	var isAndroid = agent.indexOf("Android") > -1;
	var isiPhoneIpod = agent.indexOf('iPhone') > -1 || agent.indexOf('iPod') > -1;//ios webview issue!, we cant have video below playlist, so no aspect ratio on these devices (ipad is fine because of youtube chromeless)
	//isiPhoneIpod = true;
	var isipad = agent.indexOf('iPad') > -1;
	
	if(agent.indexOf('iPhone') > -1 || agent.indexOf('iPod') > -1 || agent.indexOf('iPad') > -1) {
		 isIOS=true;
		 //ios safari orientation change bug
		 var metas = document.getElementsByTagName('meta'),i;
		 for (i=0; i<metas.length; i++) {
		    if (metas[i].name == "viewport") {
			  metas[i].content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
		    }
		 }
		 document.addEventListener("gesturestart", gestureStart, false);
		 function gestureStart() {
			for (i=0; i<metas.length; i++) {
			  if (metas[i].name == "viewport") {
				metas[i].content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";
			  }
			}
		 }
	}

	var retina = window.devicePixelRatio > 1 ? true : false;
	if (retina) {
		//alert('retina');
	}
	//alert(window.devicePixelRatio);
	
	
	var isIE = false, isIEBelow8 = false;
	var ie_check = getInternetExplorerVersion();
	if (ie_check != -1){
		isIE = true;
		if(ie_check < 8)isIEBelow8 = true;
	} 
	//console.log(isIEBelow8);
	
	//http://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser
	var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
	//console.log(isSafari);
	
	//opera  (yt events not heard? pause/play handler)
	var isOpera = !!(window.opera && window.opera.version);
	//console.log(isOpera);
	
	function getInternetExplorerVersion(){
	 //http://msdn.microsoft.com/en-us/library/ms537509%28v=vs.85%29.aspx
	 //Returns the version of Internet Explorer or a -1 (indicating the use of another browser).
	  var rv = -1; // Return value assumes failure.
	  if (navigator.appName == 'Microsoft Internet Explorer'){
		var ua = navigator.userAgent;
		var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		if (re.exec(ua) != null){
		  rv = parseFloat( RegExp.$1 );
		}
	  }
	  return rv;
	}
	
	
	var vorbisSupport = canPlayVorbis();
	var mp4Support = canPlayMP4();
	var webMsupport = canPlayWebM();
	//console.log("vorbisSupport = " + vorbisSupport, ", mp4Support = " + mp4Support, ", webMsupport = " + webMsupport);
	
	var _body = $('body');
	var _window = $(window);
	var _doc = $(document);
	
	var _downEvent = "";
	var _moveEvent = "";
	var _upEvent = "";
	var hasTouch;
	var touchOn=true;
	if("ontouchstart" in window) {
		hasTouch = true;
		_downEvent = "touchstart.ap";
		_moveEvent = "touchmove.ap";
		_upEvent = "touchend.ap";
	}else{
		hasTouch = false;
		_downEvent = "mousedown.ap";
		_moveEvent = "mousemove.ap";
		_upEvent = "mouseup.ap";
	}
	
	//************* dom elements
	var mediaWrapper = componentWrapper.find('.mediaWrapper');
	var mediaHolder = componentWrapper.find('.mediaHolder');
	var previewHolder = componentWrapper.find('.previewHolder');
	var youtubeHolder = componentWrapper.find('.youtubeHolder');
	var big_play=componentWrapper.find('.big_play').css('cursor','pointer').bind('click', togglePlayback);
	var playlistHolder = componentWrapper.find('.playlistHolder');
	var componentPlaylist = componentWrapper.find('.componentPlaylist').css('display', 'none');
	var playlistControls = componentWrapper.find('.playlistControls');
	var thumbContainer=componentWrapper.find('.thumbContainer');
	var thumbInnerContainer = componentWrapper.find('.thumbInnerContainer');
	var thumbHolder;
	if(componentWrapper.find('.thumbHolder').length>0){
		thumbHolder=componentWrapper.find('.thumbHolder');
	}
	preventSelect([previewHolder, big_play]);
	
	
	
	
	
	//************* settings
	var scrollType = settings.scrollType;
	var useCookieDetection=settings.useCookieDetection;
	var componentFixedSize=settings.componentFixedSize;
	var useKeyboardNavigation=settings.useKeyboardNavigation;
	var onPlaylistEndGoToUrl=settings.onPlaylistEndGoToUrl;
	var onPlaylistEndUrl =settings.onPlaylistEndUrl;
	var onPlaylistEndTarget=settings.onPlaylistEndTarget;
	var autoPlay= settings.autoPlay;
	var yt_autoPlay= settings.autoPlay;
	var initialAutoplay= settings.autoPlay;
	var useYoutubeHighestQuality = settings.useYoutubeHighestQuality;
	if(isMobile){
		autoPlay =false;
		yt_autoPlay = false;
	}
	var randomPlay=settings.randomPlay;
	var loopingOn=settings.loopingOn;
	var initialLoopingOn= settings.loopingOn;
	if(onPlaylistEndGoToUrl) loopingOn=false;
	var _autoOpenPlaylist = settings.autoOpenPlaylist;
	var _closePlaylistOnVideoSelect=settings.closePlaylistOnVideoSelect;
	var useDeeplink=settings.useDeeplink;
	var outputDeeplinkData=useDeeplink ? settings.outputDeeplinkData : false;
	var deeplinkData = [];
	
	if(checkCookies())return;
	
	
	//************* vars
	var scrollPane, scrollPaneApi;
	var html5video_inited=false, mac_asr1_fix=false;
	var _activePlaylist;
	var liProcessArr=[];
	var processPlaylistLength, processPlaylistCounter;
	var playlistLength;
	var dataInterval = 50;//video data 
	var dataIntervalID;
	var mediaPlaying=false;
	var singleVideo=false;
	var video;
	var videoUp2Js;
	var mediaWidth;
	var mediaHeight;
	var mediaType;
	var local_mediaPath;
	var yt_mediaPath;
	var imagePath;
	var aspectRatio;
	var currentAspectRatio;
	var ytSizeSet=false;
	var videoInited=false;
	var fadeTime=400;
	var fadeEase='easeOutSine';
	var flashReadyInterval = 100;
	var flashReadyIntervalID;
	var flashCheckDone=false;
	var flashPreview = $(flashHolder);
	var playlistOpened=false;
	var _playlistTransitionOn=false;
	var _lastThumbOrientation='';
	var _thumbInnerContainerSize = 0;//for scroll math
	var _thumbScrollIntervalID;
	var _playlistOpened =false;
	var _thumbHolderArr = [];
	var _thumbsScrollValue=50;
	
	var _lastVolume;//for mute/unmute
	var defaultVolume =settings.defaultVolume;
	if(defaultVolume<0) defaultVolume=0;
	else if(defaultVolume>1)defaultVolume=1;
	
	//youtube
	var _youtubePlayer, _videoProcessCounter=0,_videoProcessData=[],playlistStartCounter, playlistEnlargeCounter=50, youtubePlaylistPath, 
	_youtubeInited=false, _youtubeChromeless=true, ytSizeSet=false, currentObj;
	
	var defaultGallerySide=settings.defaultGallerySide;
	if(defaultGallerySide=='bottom'){
		var _thumbOrientation = 'horizontal';	
	}else if(defaultGallerySide=='right'){
		var _thumbOrientation = 'vertical';	
	}
	_lastThumbOrientation = _thumbOrientation;
	
	var windowResizeTimeoutID;
	var windowResizeTimeout = 250;//execute resize after time 
	
	var playlistHitArea;
	var thumbHolderSize;
	var _thumbBackwardSize;
	var _thumbForwardSize;
	
	//************* icons url (they repeat through the code)
	var ic_thumb_prev = 'data/icons/thumb_prev.png';
	var ic_thumb_prev_on = 'data/icons/thumb_prev_on.png';
	
	var ic_thumb_prev_v = 'data/icons/thumb_prev_v.png';
	var ic_thumb_prev_v_on = 'data/icons/thumb_prev_v_on.png';
	
	var ic_thumb_next = 'data/icons/thumb_next.png';
	var ic_thumb_next_on = 'data/icons/thumb_next_on.png';
	
	var ic_thumb_next_v = 'data/icons/thumb_next_v.png';
	var ic_thumb_next_v_on = 'data/icons/thumb_next_v_on.png';
	
	var ic_switch= 'data/icons/switch.png';
	var ic_switch_on= 'data/icons/switch_on.png';
	
	var ic_controls_prev = 'data/icons/controls_prev.png';
	var ic_controls_prev_on = 'data/icons/controls_prev_on.png';
	
	var ic_controls_next = 'data/icons/controls_next.png';
	var ic_controls_next_on = 'data/icons/controls_next_on.png';
	
	var ic_fullscreen_enter = 'data/icons/fullscreen_enter.png';
	var ic_fullscreen_enter_on = 'data/icons/fullscreen_enter_on.png';
	
	var ic_fullscreen_exit = 'data/icons/fullscreen_exit.png'; 
	var ic_fullscreen_exit_on = 'data/icons/fullscreen_exit_on.png'; 
	
	var ic_active_thumb = 'data/icons/active_item.png';
	
	//preload icons 
	var ic_preloadArr=[ic_thumb_prev,ic_thumb_prev_on,ic_thumb_prev_v,ic_thumb_prev_v_on,ic_thumb_next,ic_thumb_next_on,ic_thumb_next_v,ic_thumb_next_v_on,ic_switch,ic_switch_on,ic_mute,ic_mute_on,ic_volume,ic_volume_on,ic_play,ic_play_on,ic_pause,ic_pause_on,ic_controls_prev,ic_controls_prev_on,ic_controls_next,ic_controls_next_on,ic_fullscreen_enter,ic_fullscreen_enter_on,ic_fullscreen_exit,ic_fullscreen_exit_on,ic_active_thumb];
	//console.log(ic_preloadArr.length);
	var t = 0,tlen = ic_preloadArr.length, timg;
	for(t;t<tlen;t++){
		timg = $(new Image()).load(function() {}).error(function(e) {}).attr('src', ic_preloadArr[t]);
	}
	
	
	//************* mouse wheel
	if(scrollType == 'buttons' && thumbHolder && !isMobile){
		thumbHolder.bind('mousewheel', function(event, delta, deltaX, deltaY){
			//console.log(event);
			if(!_componentInited || _playlistTransitionOn) return false;
			var d = delta > 0 ? 1 : -1, value, w = _getComponentSize('w'), h =_getComponentSize('h');//normalize
			if(_thumbOrientation =='horizontal'){
				if(_thumbInnerContainerSize < w-_thumbBackwardSize-_thumbForwardSize) return;//if centered
				value = parseInt(thumbInnerContainer.css('left'),10);
				value+=_thumbsScrollValue*d;
				if(value > 0){
					value=0;	
				}else if(value < w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					value=w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}
				thumbInnerContainer.css('left', value+'px');
			}else{
				if(_thumbInnerContainerSize < h-_thumbBackwardSize-_thumbForwardSize) return;
				value = parseInt(thumbInnerContainer.css('top'),10);
				value+=_thumbsScrollValue*d;
				if(value > 0){
					value=0;	
				}else if(value < h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					value=h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}
				thumbInnerContainer.css('top', value+'px');
			}
			return false;
		});
	}
	
	//**********************

	function initTouch(){
		var startX,
			startY,
			touchStartX,
			touchStartY,
			moved,
			moving = false;

		thumbInnerContainer.unbind('touchstart.ap touchmove.ap touchend.ap click.ap-touchclick').bind(
			'touchstart.ap',
			function(e){
				if(!_componentInited || _playlistTransitionOn) return false;
				if(!touchOn){//if touch disabled we want click executed
					return true;
				}
				var touch = e.originalEvent.touches[0];
				startX = thumbInnerContainer.position().left;
				startY = thumbInnerContainer.position().top;
				touchStartX = touch.pageX;
				touchStartY = touch.pageY;
				moved = false;
				moving = true;
			}
		).bind(
			'touchmove.ap',
			function(ev){
				if(!moving){
					return;
				}
				var touchPos = ev.originalEvent.touches[0];
				if(_thumbOrientation =='horizontal'){
					var value = startX - touchStartX + touchPos.pageX, w = _getMediaWrapperSize('w');
					
					//toggle advance buttons
					if(value > 0){
						value=0;	
						//togglePrevBtn('off');
					}else{
						//togglePrevBtn('on');
					}
					if(value < w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
						value=w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
						//toggleNextBtn('off');
					}else{
						//toggleNextBtn('on');
					}
								
					thumbInnerContainer.css('left',value+'px');
				}else{
					var value=startY - touchStartY + touchPos.pageY, h = _getMediaWrapperSize('h');
					
					//toggle advance buttons
					if(value > 0){
						value=0;	
						//togglePrevBtn('off');
					}else{
						//togglePrevBtn('on');
					}
					if(value < h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
						value=h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
						//toggleNextBtn('off');
					}else{
						//toggleNextBtn('on');
					}
					
					thumbInnerContainer.css('top',value+'px');
				}
				moved = moved || Math.abs(touchStartX - touchPos.pageX) > 5 || Math.abs(touchStartY - touchPos.pageY) > 5;
				
				return false;
			}
		).bind(
			'touchend.ap',
			function(e){
				moving = false;
			}
		).bind(
			'click.ap-touchclick',
			function(e){
				if(moved) {
					moved = false;
					return false;
				}
			}
		);
	}
	
	if(scrollType == 'buttons'){
		if(hasTouch)initTouch();
	
		//************* thumb scrolling
		var thumbBackward = componentWrapper.find('.thumbBackward').css({cursor:'pointer', display:'none'})
		.bind(_downEvent, function(){
			if(!_componentInited) return false;
			if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
			_thumbScrollIntervalID = setInterval(function() { _scrollThumbsBack(); }, 100);
			return false;
		}).bind(_upEvent, function(){
			if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
			return false;
		});
		
		var thumbForward = componentWrapper.find('.thumbForward').css({cursor:'pointer', display:'none'})
		.bind(_downEvent, function(){
			if(!_componentInited) return false;
			if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
			_thumbScrollIntervalID = setInterval(function() { _scrollThumbsForward(); }, 100);
			return false;
		}).bind(_upEvent, function(){
			if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
			return false;
		});
		
		function _scrollThumbsBack() {
			var value;
			if(_thumbOrientation == 'horizontal'){
				value = parseInt(thumbInnerContainer.css('left'),10);
				value+=_thumbsScrollValue;
				if(value > 0){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=0;	
				}
				thumbInnerContainer.css('left', value+'px');
			}else{
				value = parseInt(thumbInnerContainer.css('top'),10);
				value+=_thumbsScrollValue;
				if(value > 0){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=0;	
				}
				thumbInnerContainer.css('top', value+'px');
			}
		}
		
		function _scrollThumbsForward() {
			if(_thumbOrientation == 'horizontal'){
				var value = parseInt(thumbInnerContainer.css('left'),10), w = _getComponentSize('w');
				value-=_thumbsScrollValue;
				if(value < w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}
				thumbInnerContainer.css('left', value+'px');
			}else{
				var value = parseInt(thumbInnerContainer.css('top'),10), h = _getComponentSize('h');
				value-=_thumbsScrollValue;
				if(value < h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}
				thumbInnerContainer.css('top', value+'px');
			}
		}
	
	}
	
	//************* playlist buttons
	var playlist_toggle = componentWrapper.find('.playlist_toggle').css('cursor', 'pointer').bind('click', function(){
		if(!_componentInited || _playlistTransitionOn || !thumbHolder) return false;
		_togglePlaylist();
		return false;
	});
	var playlist_switch;
	if(componentWrapper.find('.playlist_switch').length>0){
	 	playlist_switch = componentWrapper.find('.playlist_switch').css('cursor', 'pointer').bind('click', function(){
			if(!_componentInited || _playlistTransitionOn || !thumbHolder) return false;
			_switchLayout();
			return false;
		});
	}
	
	var controls_prev, controls_toggle, controls_next;
	if(componentWrapper.find('.controls').length){
	//************* control buttons
		controls_prev = componentWrapper.find('.controls_prev').css('cursor', 'pointer').bind('click', function(){
			if(!_componentInited || _playlistTransitionOn) return false;
			previousMedia();
			return false;
		});
		controls_toggle = componentWrapper.find('.controls_toggle').css('cursor', 'pointer').bind('click', function(){
			if(!_componentInited || _playlistTransitionOn) return false;
			togglePlayback();
			return false;
		});
		controls_next = componentWrapper.find('.controls_next').css('cursor', 'pointer').bind('click', function(){
			if(!_componentInited || _playlistTransitionOn) return false;
			nextMedia();
			return false;
		});
		if(isiPhoneIpod){
			componentWrapper.find('.controls').css('top', componentWrapper.height()+'px');
		}
	}
	
	//************* fullscreen
	var useFullscreen=false, controls_fullscreen;
	var html5Support=(!!document.createElement('video').canPlayType);
	//html5Support=false;
	if(!html5Support){
		mp4Support=true;
		componentWrapper.find('.controls_fullscreen').remove();	
	}else{
		//console.log(checkFullScreenSupport());
		if(componentWrapper.find('.controls_fullscreen').length>0 && checkFullScreenSupport()){
			useFullscreen=true;
			controls_fullscreen = componentWrapper.find('.controls_fullscreen').css('cursor', 'pointer').bind('click', function(){
				if(!_componentInited) return false;
				toggleFullscreen();
				return false;
			});
		}else{
			componentWrapper.find('.controls_fullscreen').remove();	
		}
	}
	
	var skipIntroExist = false, skipIntro, skipIntroTop = false;
	if(componentWrapper.find('.skip_intro').length>0){
		skipIntro = componentWrapper.find('.skip_intro').css('cursor','pointer').bind('click', function(){
			if(!html5Support) getFlashMovie('flashPreview').pb_dispose();
			if(onPlaylistEndGoToUrl && useCookieDetection) saveData('page_intro', 'visited');
			goToUrl();
			return false;	
		});	
		preventSelect([skipIntro]);
		skipIntroExist = true;
	};
	
	function goToUrl(){
		//console.log('goToUrl');
		if(onPlaylistEndTarget=='_parent'){
			window.location.href=onPlaylistEndUrl;
		}else if(onPlaylistEndTarget=='_blank'){
			window.open(onPlaylistEndUrl, onPlaylistEndTarget);
		}
	}
	
	//************* rollovers
	if(!isMobile){
		//************* playlist buttons
		if(playlist_toggle)playlist_toggle.bind('mouseover', function(){
			if(!_componentInited) return false;
			if(_playlistOpened){
				var url = _thumbOrientation == 'horizontal' ? ic_thumb_next_v_on : ic_thumb_next_on;
				$(this).css('backgroundImage', 'url('+url+')');
			} else{
				var url = _thumbOrientation == 'horizontal' ? ic_thumb_prev_v_on : ic_thumb_prev_on;
				$(this).css('backgroundImage', 'url('+url+')');
			}
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			if(_playlistOpened){
				var url = _thumbOrientation == 'horizontal' ? ic_thumb_next_v : ic_thumb_next;
				$(this).css('backgroundImage', 'url('+url+')');
			} else{
				var url = _thumbOrientation == 'horizontal' ? ic_thumb_prev_v : ic_thumb_prev;
				$(this).css('backgroundImage', 'url('+url+')');
			}
			return false;
		});
		
		if(playlist_switch)playlist_switch.bind('mouseover', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_switch_on : ic_switch_on;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_switch : ic_switch;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		//************* thumbnail buttons
		if(thumbForward)thumbForward.bind('mouseover', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_next_on : ic_thumb_next_v_on;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_next : ic_thumb_next_v;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		if(thumbBackward)thumbBackward.bind('mouseover', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_prev_on : ic_thumb_prev_v_on;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_prev : ic_thumb_prev_v;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		//************* controls
		componentWrapper.find('.controls').css('display','block');
		
		if(controls_prev)controls_prev.bind('mouseover', function(){
			if(!_componentInited) return false;
			var url = ic_controls_prev_on;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			var url = ic_controls_prev;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		if(controls_toggle)controls_toggle.bind('mouseover', function(){
			if(!_componentInited) return false;
			if(mediaPlaying){
				var url = ic_pause_on;
			}else{
				var url = ic_play_on;
			}
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			if(mediaPlaying){
				var url = ic_pause;
			}else{
				var url = ic_play;
			}
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		if(controls_next)controls_next.bind('mouseover', function(){
			if(!_componentInited) return false;
			var url = ic_controls_next_on;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			var url = ic_controls_next;
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		//************* fullscreen
		if(controls_fullscreen)controls_fullscreen.bind('mouseover', function(){
			if(!_componentInited) return false;
			if ((document.fullScreenElement && document.fullScreenElement !== null) ||   
			  (!document.mozFullScreen && !document.webkitIsFullScreen)) { 
			    var url = ic_fullscreen_enter_on;
			}else{
				var url = ic_fullscreen_exit_on; 
			}
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			if ((document.fullScreenElement && document.fullScreenElement !== null) ||   
			  (!document.mozFullScreen && !document.webkitIsFullScreen)) { 
			    var url = ic_fullscreen_enter;
			}else{
				var url = ic_fullscreen_exit;  
			}
			$(this).css('backgroundImage', 'url('+url+')');
			return false;
		});
		
		//skip intro
		if(skipIntro)skipIntro = componentWrapper.find('.skip_intro').bind('mouseover', function(){
			if(!_componentInited) return false;
			if(!skipIntroTop){
				$(this).removeClass().addClass('skip_intro_on');
			}else{
				$(this).removeClass().addClass('skip_intro_top_on');
			}
			return false;
		}).bind('mouseout', function(){
			if(!_componentInited) return false;
			if(!skipIntroTop){
				$(this).removeClass().addClass('skip_intro');
			}else{
				$(this).removeClass().addClass('skip_intro_top');
			}
			return false;
		});
		
	}
	
	//************* volume
	if(!isIOS){
		var vol_seekbar_opened=false;//for mobile (we cant use rollover to open vol seekbar and click on vol toggle btn to toggle mute/unmute, so we use vol toggle btn just to open/close vol seekbar on mobile)
		var volumeTimeoutID;
		var volumeTimeout = 3000;//hide volume time
		function hideVolume(){
			if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
			volume_seekbar.css('display','none');
			vol_seekbar_opened=false;
		}
		
		var volume_toggle =componentWrapper.find('.volume_toggle');
		var volume_seekbar = componentWrapper.find('.volume_seekbar').bind(_downEvent,function(e){
			_onDragStartVol(e);
			return false;		
		});
		
		if(!isMobile){
			volume_seekbar.css('cursor', 'pointer').bind('mouseover', function(){
				if(!_componentInited) return false;
				if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
				return false;
			}).bind('mouseout', function(){
				if(!_componentInited) return false;
				if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
				volumeTimeoutID = setTimeout(hideVolume,volumeTimeout);
				return false;
			}) ;
		}
		
		var volume_bg = componentWrapper.find('.volume_bg');
		var volume_level = componentWrapper.find('.volume_level');
		var _lastVolume = defaultVolume;
		var volumebarDown=false;
		var volumeSize=volume_bg.width();
		volume_level.css('width', defaultVolume*volumeSize+'px');
		if(defaultVolume == 0){
			_lastVolume=0.5;//if we click unmute from mute on the beginning
			var url = ic_mute;	
		}else if(defaultVolume > 0){
			var url = ic_volume;	
		}
		function toggleVolume(){
			if(!_componentInited || _playlistTransitionOn) return false;
			if(defaultVolume == 0){//is muted
				defaultVolume = _lastVolume;//restore last volume
				//if(html5Support) videoUp2Js.muted = false;
				setVolume();
				var url = ic_volume_on;
			}else{
				_lastVolume = defaultVolume;//remember last volume
				//if(html5Support) videoUp2Js.muted = true;
				defaultVolume = 0;//set mute on (volume to 0)
				setVolume();
				var url = ic_mute_on;
			}
		}
		
		if(isMobile){
			volume_toggle.css('backgroundImage', 'url('+url+')').bind('click',function(e){
				if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
				if(!vol_seekbar_opened){
					volume_seekbar.css('display','block');
					vol_seekbar_opened=true;
					//additional hide volume on timer 
					volumeTimeoutID = setTimeout(hideVolume,volumeTimeout);	
				}else{
					volume_seekbar.css('display','none');
					vol_seekbar_opened=false;
				}
				return false;		
			});
		}else{
			volume_toggle.css('backgroundImage', 'url('+url+')').bind('click', function(){
				if(!_componentInited || _playlistTransitionOn) return false;
				if(defaultVolume == 0){//is muted
					defaultVolume = _lastVolume;//restore last volume
					//if(html5Support) videoUp2Js.muted = false;
					setVolume();
					var url = ic_volume_on;
				}else{
					_lastVolume = defaultVolume;//remember last volume
					//if(html5Support) videoUp2Js.muted = true;
					defaultVolume = 0;//set mute on (volume to 0)
					setVolume();
					var url = ic_mute_on;
				}
				$(this).css('backgroundImage', 'url('+url+')');
				return false;
			}).bind('mouseover', function(){
				if(!_componentInited) return false;
				
				//show volume seekbar
				if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
				volume_seekbar.css('display','block');
				vol_seekbar_opened=true;
				
				if(defaultVolume == 0){
					var url = ic_mute_on;
				}else{
					var url = ic_volume_on;
				}
				$(this).css('backgroundImage', 'url('+url+')');
				return false;
			}).bind('mouseout', function(){
				if(!_componentInited) return false;
				
				if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
				volumeTimeoutID = setTimeout(hideVolume,volumeTimeout);
				
				if(defaultVolume == 0){
					var url = ic_mute;
				}else{
					var url = ic_volume;
				}
				$(this).css('backgroundImage', 'url('+url+')');
				return false;
			}).css('cursor', 'pointer');
		}
		
	}else{//no volume on ios
		componentWrapper.find('.controls_volume').remove();
	}
	
	
	//********* volume
	
	// Start dragging 
	function _onDragStartVol(e) {
		if(!_componentInited || _playlistTransitionOn) return;
		if(seekBarDown) return;
		if(!volumebarDown){					
			var point;
			if(hasTouch){
				var currTouches = e.originalEvent.touches;
				if(currTouches && currTouches.length > 0) {
					point = currTouches[0];
				}else{	
					return false;						
				}
			}else{
				point = e;								
				e.preventDefault();						
			}
			volumebarDown = true;
			_doc.bind(_moveEvent, function(e) { _onDragMoveVol(e); });
			_doc.bind(_upEvent, function(e) { _onDragReleaseVol(e); });		
		}
		return false;	
	}
				
	function _onDragMoveVol(e) {	
		var point;
		if(hasTouch){
			var touches;
			if(e.originalEvent.touches && e.originalEvent.touches.length) {
				touches = e.originalEvent.touches;
			}else if(e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
				touches = e.originalEvent.changedTouches;
			}else{
				return false;
			}
			// If touches more then one, so stop sliding and allow browser do default action
			if(touches.length > 1) {
				return false;
			}
			point = touches[0];	
			e.preventDefault();				
		} else {
			point = e;
			e.preventDefault();		
		}
		volumeTo(point.pageX);
		
		return false;		
	}
	
	function _onDragReleaseVol(e) {
		if(volumebarDown){	
			volumebarDown = false;			
			_doc.unbind(_moveEvent).unbind(_upEvent);	
			
			var point;
			if(hasTouch){
				var touches;
				if(e.originalEvent.touches && e.originalEvent.touches.length) {
					touches = e.originalEvent.touches;
				}else if(e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
					touches = e.originalEvent.changedTouches;
				}else{
					return false;
				}
				// If touches more then one, so stop sliding and allow browser do default action
				if(touches.length > 1) {
					return false;
				}
				point = touches[0];	
				e.preventDefault();				
			} else {
				point = e;
				e.preventDefault();		
			}
			
			volumeTo(point.pageX);
			
			if(defaultVolume == 0){
				var url = ic_mute;
				volume_toggle.css('backgroundImage', 'url('+url+')');
				//if(html5Support)videoUp2Js.muted = true;
			}else if(defaultVolume > 0){
				var url = ic_volume;
				volume_toggle.css('backgroundImage', 'url('+url+')');
				//if(html5Support)videoUp2Js.muted = false;
			}
		}
		return false;
	}	
	
	function volumeTo(x) {
		defaultVolume = Math.max(0, Math.min(1, (x - volume_bg.offset().left) / volumeSize));
	 	setVolume();
	}
	
	
	
	
	
	//************* seekbar
	var useSeekbar=false;
	if(!isiPhoneIpod && componentWrapper.find('.seekbar').length>0){
		useSeekbar=true;
		var seekPercent;
		var seekBarDown=false;
		var seekbar = componentWrapper.find('.seekbar').css({display: 'none',cursor: 'pointer'}).bind(_downEvent,function(e){
			_onDragStartSeek(e);
			return false;		
		}); 
		var seekbar_hit = seekbar.find('.seekbar_hit');
		if(isMobile)seekbar_hit.height(20);//for tablet
		var playProgress = seekbar.find('.play_progress');
		var loadProgress = seekbar.find('.load_progress');
	}else{
		componentWrapper.find('.seekbar').remove();
	}
	
	// Start dragging 
	function _onDragStartSeek(e) {
		if(!_componentInited) return;
		if(!seekBarDown){					
			var point;
			if(hasTouch){
				var currTouches = e.originalEvent.touches;
				if(currTouches && currTouches.length > 0) {
					point = currTouches[0];
				}else{	
					return false;						
				}
			}else{
				point = e;								
				e.preventDefault();						
			}
			seekBarDown = true;
			_doc.bind(_moveEvent, function(e) { _onDragMoveSeek(e); });
			_doc.bind(_upEvent, function(e) { _onDragReleaseSeek(e); });		
		}
		return false;	
	}
				
	function _onDragMoveSeek(e) {	
		var point;
		if(hasTouch){
			var touches;
			if(e.originalEvent.touches && e.originalEvent.touches.length) {
				touches = e.originalEvent.touches;
			}else if(e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
				touches = e.originalEvent.changedTouches;
			}else{
				return false;
			}
			// If touches more then one, so stop sliding and allow browser do default action
			if(touches.length > 1) {
				return false;
			}
			point = touches[0];	
			e.preventDefault();				
		} else {
			point = e;
			e.preventDefault();		
		}
		setProgress(point.pageX);
		
		return false;		
	}
	
	function _onDragReleaseSeek(e) {
		if(seekBarDown){	
			seekBarDown = false;			
			_doc.unbind(_moveEvent).unbind(_upEvent);	
			
			var point;
			if(hasTouch){
				var touches;
				if(e.originalEvent.touches && e.originalEvent.touches.length) {
					touches = e.originalEvent.touches;
				}else if(e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
					touches = e.originalEvent.changedTouches;
				}else{
					return false;
				}
				// If touches more then one, so stop sliding and allow browser do default action
				if(touches.length > 1) {
					return false;
				}
				point = touches[0];	
				e.preventDefault();				
			} else {
				point = e;
				e.preventDefault();		
			}
			setProgress(point.pageX);
		}
		return false;
	}	
	
	function setProgress(x) {
		var newPercent,ct,ct2f, seekBarSize = _getComponentSize('w');
		if(mediaType == 'local'){
			if(html5Support){
				newPercent = Math.max(0, Math.min(1, (x - seekbar.offset().left) / seekBarSize));
				ct = newPercent * videoUp2Js.duration;
				ct2f = ct.toFixed(1);
				videoUp2Js.currentTime = ct2f;
				playProgress.width((videoUp2Js.currentTime / videoUp2Js.duration) * seekBarSize);	
			}else{
				newPercent = Math.max(0, Math.min(1, (x - seekbar.offset().left) / seekBarSize));
				var d=getFlashMovie('flashPreview').pb_getFlashDuration(); 
				ct= newPercent * d;
				//console.log(newPercent, d, ct);
				getFlashMovie('flashPreview').pb_playTo(ct); 
				playProgress.width((ct / d) * _getComponentSize('w'));	
			}
		}else if(mediaType == 'youtube'){
			
			if(_youtubePlayer){
				newPercent = Math.max(0, Math.min(1, (x - seekbar.offset().left) / seekBarSize));
				ct = newPercent * _youtubePlayer.getDuration();
				ct2f = ct.toFixed(1);
				_youtubePlayer.seek(ct2f);
			}
		}
	}
	
	//***************** playlist manager
	
	var pm_settings = {'randomPlay': randomPlay, 'loopingOn': loopingOn};
	var _playlistManager = $.playlistManager(pm_settings);
	$(_playlistManager).bind('ap_PlaylistManager.COUNTER_READY', function(){
		//console.log('COUNTER_READY');
		
		if(useDeeplink){
			if(!_addressSet){
				//console.log('...1');
				$.address.value(findAddress2(_playlistManager.getCounter()));
				if(!$.address.history()) $.address.history(true);//restore history
			}else{
				//console.log('...2');
				_addressSet=false;
				_disableActiveItem();
				_findMedia();
			}
		}else{
			_disableActiveItem();
			_findMedia();
		}
	});
	$(_playlistManager).bind('ap_PlaylistManager.PLAYLIST_END', function(){
		//console.log('PLAYLIST_END');
		_disableActiveItem();
		playlistEndAction();
	});
	
	//*************** deeplinking
	/*
	IMPORTANT!
	Since we cant see all the deplinks before each playlist has been processed (this would be valid only for single video links), first search for first level url on each playlist, then process this playlist and create deeplinking for this category (playlist).
	1. on each deeplink change check first level, find if already loaded, if not load, if yes, find second level from there. If not found - 404
	*/
	
	if(useDeeplink){
		
		var categoryArr=[],cat;
		componentPlaylist.children("ul[data-address]").each(function(){
				var obj = {};
				cat = $(this);
				obj.categoryName = cat.attr('data-address');
				obj.id = cat.attr('id');
				categoryArr.push(obj);
		});
		//console.log(categoryArr);
		var categoryLength = categoryArr.length;
		//console.log('categoryLength = ', categoryLength);
			
		var loc_path, loc_name, getDeeplinkData=false;
		var strict = $.address.strict() ? '#/' : '#';
		var dlink;
		var secondLevelExist=false;
		var secondLevel;
		var firstLevel;
		var deepLink;
		var _addressSet=false;
		var _addressInited=false;
		var addressTimeout=500;
		var addressTimeoutID;
		var _externalChangeEvent;
		var startUrl=settings.startUrl;
		var activeCategory;
		var currentCategory;
		var activeItem;
		var transitionFinishInterval=100;
		var transitionFinishIntervalID;
		var reCheckAddressTimeoutID;
		var reCheckAddressTimeout = 250;//address sometimes doesnt fire on beginning
	
		//console.log($.address.strict());
		//$.address.strict(false);
		//$.address.init(initAddress);
		$.address.internalChange(function(e){
			e.stopPropagation();
			//console.log("internalChange: ", e.value);
			if(reCheckAddressTimeoutID) clearTimeout(reCheckAddressTimeoutID);
			onChange(e);
		});
		$.address.externalChange(function(e){
			e.stopPropagation();
			//console.log("externalChange: ", e.value);
			if(reCheckAddressTimeoutID) clearTimeout(reCheckAddressTimeoutID);
			_externalChangeEvent = e;
			if(!_playlistTransitionOn){
				if(!_addressInited){
					//on the beginning onExternalChange fires first, then onInternalChange immediatelly, so skip onExternalChange call
	
					if(e.value == "/"){
						//console.log('strict mode off, skip /');
						
						_addressSet=true;
						$.address.history(false);//skip the "/"
						
						if(!isEmpty(startUrl)){
							$.address.value(startUrl);
							if(!$.address.history()) $.address.history(true);//restore history
						}else{
							//open menu
							//toggleMenuHandler(true);
						}
						
					}else if(isEmpty(e.value)){
						//console.log('strict mode on');
						_addressSet=true;
						$.address.history(false);//skip the ""
						
						if(!isEmpty(startUrl)){
							$.address.value(startUrl);
							if(!$.address.history()) $.address.history(true);//restore history
						}else{
							//open menu
							//toggleMenuHandler(true);
						}
					}else{
						//console.log('other deeplink start');
						onChange(e);
					}
					
					return;
				}
				if(addressTimeoutID) clearTimeout(addressTimeoutID);
				addressTimeoutID = setTimeout(swfAddressTimeoutHandler, addressTimeout);
			}else{
				if(addressTimeoutID) clearTimeout(addressTimeoutID);
				//wait for transition finish
				if(transitionFinishIntervalID) clearInterval(transitionFinishIntervalID);
				transitionFinishIntervalID = setInterval(transitionFinishHandler, transitionFinishInterval);
			}
		});
	}else{//no deeplink
		_activePlaylist=settings.activePlaylist;
		_setPlaylist();	
	}
	
	function transitionFinishHandler() {
		//console.log('transitionFinishHandler');
		if(!_playlistTransitionOn){//when module transition finishes
			if(transitionFinishIntervalID) clearInterval(transitionFinishIntervalID);
			if(addressTimeoutID) clearTimeout(addressTimeoutID);
			onChange(_externalChangeEvent);
		}
	}
	
	function reCheckAddress() {
		//console.log('reCheckAddress');
		if(reCheckAddressTimeoutID) clearTimeout(reCheckAddressTimeoutID);
		_addressSet=true;
		$.address.history(false);//skip the "/"
		
		if(!isEmpty(startUrl)){
			$.address.value(startUrl);
			if(!$.address.history()) $.address.history(true);//restore history
		}else{
			//open menu
			//toggleMenuHandler(true);
		}
	}
	
	function swfAddressTimeoutHandler() {
		//timeout if user repeatedly pressing back/forward browser buttons to stop default action executing immediatelly
		if(addressTimeoutID) clearTimeout(addressTimeoutID);
		onChange(_externalChangeEvent);
	}
	
	//fix for window.load instead of document.ready
	/*if(var reCheckAddressTimeoutID) clearTimeout(var reCheckAddressTimeoutID);
	var reCheckAddressTimeoutID = setTimeout(function(){
		if(reCheckAddressTimeoutID) clearTimeout(reCheckAddressTimeoutID);
		reCheckAddress();
	},var reCheckAddressTimeout);*/
	
	//************************** deeplinking	
			
	/*
	http://www.asual.com/jquery/address/docs/
				
	internalChange is called when we set value ourselves; 
	externalChange is called when the URL is changed or the browser backward or forward button is pressed. 
	
	I don't want to an AJAX request if there are no query parameters in the URL, which is why I test for an empty object.
	if($.isEmptyObject(event.parameters))
	return;
	  
	jQuery.address.strict(false);//Note that you need to disable plugin's strict option, otherwise it would add slash symbol immediately after hash symbol, like this: #/11.
	*/
	
	function filterAllowedChars(str) {
		var allowedChars = "_-";
		var n = str.length;
		var returnStr = "";
		var i = 0;
		var _char;
		var z;
		for (i; i < n; i++) {
			_char = str.charAt(i).toLowerCase(); //convert to lowercase
			if (_char == "\\") _char = "/";
			z = getCharCode(_char);			
			if ((z >= getCharCode("a") && z <= getCharCode("z")) || (z >= getCharCode("0") && z <= getCharCode("9")) || allowedChars.indexOf(_char) >= 0) {
				//only accepted characters (this will remove the spaces as well)
				returnStr += _char;
			}
		}
		return returnStr;
	}
	
	function getCharCode(s) {
		return s.charCodeAt(0);
	}
	
	function initAddress(e) {
		e.stopPropagation();
		//console.log("init: ", e.value);
	}
	
	function onChange(e) {
		e.stopPropagation();
		//console.log("onChange: ", e.value);
		
		if(!_addressInited){
			_addressInited = true;
		}
		
		deepLink = e.value;
		if(deepLink.charAt(0) == "/") deepLink = deepLink.substring(1)//check if first character is slash
		if(deepLink.charAt(deepLink.length - 1) == "/") deepLink = deepLink.substring(0, deepLink.length - 1)//check if last character is slash
		//console.log("onChange after trim: ", deepLink);

		//check if first level exist
		var first_level = findFirstLevel(deepLink);
		if(!findCategoryByName(first_level)){
			alert('404 page not found, check your deeplinks first level!');
			$.address.history(false);//skip invalid url
			return false;
		}
		
		_addressSet=false;

		//check for category change
		if(currentCategory == undefined || currentCategory != activeCategory){
			if(currentCategory != undefined)_cleanPlaylist();
			//process new playlist and get deeplink data
			_setPlaylist();	
			return;
		}
		
		//console.log('console.log(_playlistManager.getCounter(), activeItem); = ', _playlistManager.getCounter(), ' , ', activeItem);
		if(secondLevel){
			if(!findCounterByName(secondLevel)){//if second level exist but invalid
				alert('404 page not found, check your deeplinks second level!');
				$.address.history(false);//skip invalid url
				return;	
			}
		}else{//back from 2 level to one level
			destroyMedia();
			//console.log('here destroyMedia');
			return;
		}
		
		if(_playlistManager.getCounter() != activeItem){
			//console.log('1a.......');
			_addressSet=true;
			if(_playlistManager.getCounter()!=-1)_enableActiveItem();
			_playlistManager.setCounter(activeItem, false);
		}else{
			//console.log('2a.......');
			_disableActiveItem();
			_findMedia();
		}
	}
	
	function findAddress(value){

		//console.log('findAddress');
		
		//var currentURL = window.location.href;
		//console.log(currentURL);
		
		var arr = value.split('/'), single_level = false;
		if(arr.length!=2){
			single_level = true;
			nameFound=true;
		}
		//console.log(arr);
		var category_name=arr[0],categoryFound=false,nameFound=false,i = 0, len = categoryArr.length;
		
		for(i; i < len;i++){
			if(categoryArr[i].categoryName == category_name){
				//console.log('activeCategory = ', i, ' , category_name = ', category_name);
				activeCategory = i;
				categoryFound=true;
				break;	
			}
		}
		if(!categoryFound) return false;
	
		if(single_level){
			media_name=arr[1];
			
			i = 0, arr = categoryArr[activeCategory].mediaName;
			var len = arr.length;
			for(i; i < len;i++){
				if(arr[i] == media_name){
					//console.log('activeItem = ', i, ' , media_name = ', media_name);
					activeItem = i;
					nameFound=true;
					break;	
				}
			}
		}
		
		if(!categoryFound || !nameFound){
			return false;
		}else{
			return true;	
		}
	}
	
	function findCounterByName(value){
		var found=false, i = 0, arr = categoryArr[activeCategory].mediaName, len = arr.length;
		for(i; i < len;i++){
			if(arr[i] == value){
				//console.log('findCounterByName: ', i, ' ', value);
				activeItem = i;
				found=true;
				break;	
			}
		}
		if(!found){
			return false;
		}else{
			return true;	
		}
	}
	
	function findCategoryByName(value){
		var found=false, i = 0;
		for(i; i < categoryLength;i++){
			if(categoryArr[i].categoryName == value){
				//console.log('findCategoryByName: ', i, value);
				activeCategory = i;
				_activePlaylist = categoryArr[i].id;//get id attributte from current deepling
				found=true;
				break;	
			}
		}
		if(!found){
			return false;
		}else{
			return true;	
		}
	}
	
	function findAddress2(i){//return media name with requested counter
		//console.log('findAddress2');
		var arr = categoryArr[activeCategory].mediaName;
		return categoryArr[activeCategory].categoryName+'/'+arr[i];
	}
	 
	function findFirstLevel(value){
		var str_to_filter, result;
		if(value.indexOf('/') > 0){//two level
			secondLevelExist=true;
			str_to_filter = value.substr(0, value.indexOf('/'));
			firstLevel=str_to_filter;
			secondLevel = value.substr(value.indexOf('/')+1);//remember second part url
			//console.log('secondLevel = ', secondLevel);
		}else{
			firstLevel=value;
			//console.log('firstLevel = ', firstLevel);
			secondLevelExist=false;
			secondLevel=null;
			str_to_filter = value;//single level
		}
		result = filterAllowedChars(str_to_filter);
		return result;
	}
	
	//*************
	
	if(useKeyboardNavigation){
		_window.keyup(function(e){
			if(!_componentInited || _playlistTransitionOn) return false;
			if (!e) var e = window.event;
			if(e.cancelBubble) e.cancelBubble = true;
			else if (e.stopPropagation) e.stopPropagation();

			//console.log(e.keyCode);
			var key = e.keyCode;
			if(key == 37) {//left arrow
			    previousMedia();
			} 
			else if(key == 39) {//right arrow
				nextMedia();
			}
			else if(key == 32) {//space
				togglePlayback();
			}
			else if(key == 77) {//m
				toggleVolume();
			}
			return false;
		});
	}
	
	//************************* YOUTUBE
	
	function _getPlaylist() {
		
		currentCategory = activeCategory;
		
		//deeplink data, not in build playlist since we execute it every time
		if(useDeeplink){
			deeplinkData = [];
			getDeeplinkData=false;
			if(!categoryArr[activeCategory].mediaName){//if not already processed
				getDeeplinkData=true;
				var tempArr=[];
				categoryArr[activeCategory].mediaName=tempArr;
			}
		}
		
		/*
		https://developers.google.com/youtube/2.0/developers_guide_jsonc
		&start-index=1&max-results=50&v=2&alt=jsonc
		*/
		mediaPreloader.css('display','block');
		
		var i = 0, playlist, div;
		
	    //reset
		singleVideo=false;
		playlistLength=0;
	  	processPlaylistCounter = -1;
		_videoProcessData=[];
		liProcessArr = [];
		_thumbHolderArr=[];
			
		//get new playlist
		playlist = $(componentPlaylist.find("ul[id="+_activePlaylist+"]"));
		//console.log(playlist.length);
		if(playlist.length==0){
			alert('Failed playlist selection, no deeplink version!');
			return;	
		}

		liProcessArr = playlist.find("li[class='playlistItem']");//process one by one
		processPlaylistLength = liProcessArr.length;
		//console.log('processPlaylistLength = ', processPlaylistLength);
		checkPlaylistProcess();
	}
	
	function checkPlaylistProcess() {
		processPlaylistCounter++;
		
		if(processPlaylistCounter < processPlaylistLength){
			_videoProcessData=[];//reset
			_processPlaylistItem();
		}else{
			//console.log('finished processing playlist');
			//console.log(playlistLength);
			
			if(!flashCheckDone){
				flashCheckDone=true;
				if(html5Support){
					flashPreview.remove();//remove flash
					mediaHolder.css('display', 'block');
				}else{
					mediaHolder.css('display', 'none');
					flashPreview.css('display', 'block');
					flashReadyIntervalID = setInterval(checkFlashReady, flashReadyInterval);	
					return;
				}
			}
			
			if(playlistLength==1) singleVideo=true;
			if(!html5Support) getFlashMovie('flashPreview').pb_resetSingleVideo();
			if(!html5Support) getFlashMovie('flashPreview').pb_setSingleVideo(singleVideo);
			
			_playlistManager.setPlaylistItems(playlistLength);
			
			if(outputDeeplinkData){
			  try{ 
				  console.log(deeplinkData);	
			  }catch(e){}
			}
			
			mediaPreloader.css('display','none');
			
			doneResizing(true);
			_playlistTransitionOn=false;
			
			if(thumbHolder){
				if(_autoOpenPlaylist){
					setTimeout(function(){_togglePlaylist();},500);
				}else{
					//_playlistOpened=true;//reverse to close component
					//_togglePlaylist();
				}
			}
			
			if(!_componentInited){
				_componentInited=true;
				componentWrapper.stop().animate({ 'opacity': 1},  {duration: 500, easing: 'easeOutSine'});//show component
				videoGallerySetupDone();
			}
			
			if(useDeeplink){
				//check second level
				if(secondLevelExist){
					if(!findCounterByName(secondLevel)){//if second level exist but invalid
						alert('404 page not found, check your deeplinks second level!');
						$.address.history(false);//skip invalid url
						return;	
					}
					//console.log(activeItem);
					_addressSet=true;
					_playlistManager.setCounter(activeItem, false);
				}
			}else{
				_playlistManager.setCounter(0, false);//first video active by default
			}
		}
	}
	
	function _processPlaylistItem() {
		//console.log('_processPlaylistItem');
		
		var _item, youtube_path, path, type;
		
		_item = $(liProcessArr[processPlaylistCounter]);
		
		type = _item.attr('data-type');
	
		if(type == 'local'){
			var obj = {};
			obj.type = 'local';
			obj.mp4Path = _item.attr('data-mp4Path');
			obj.ogvPath = _item.attr('data-ogvPath');
			if(_item.attr('data-webmPath') != undefined && !isEmpty(_item.attr('data-webmPath'))){
				obj.webmPath = _item.attr('data-webmPath');
			}
			obj.imagePath = _item.attr('data-imagePath');
			obj.thumbnail = _item.attr('data-thumbPath');
			if(useDeeplink)obj.deeplink = _item.attr('data-address');
			if(_item.attr('data-aspectRatio') != undefined && !isEmpty(_item.attr('data-aspectRatio'))){
				obj.aspectRatio=parseInt(_item.attr('data-aspectRatio'),10);
			}else{
				obj.aspectRatio=2;//default
			}
			_videoProcessData.push(obj);
			_buildPlaylist();
		}else if(type == 'youtube_single'){
			path = _item.attr('data-path');
			youtube_path="http://gdata.youtube.com/feeds/api/videos/"+path+"?v=2&format=5&alt=jsonc";
			
			currentObj={};
			if(useDeeplink)currentObj.deeplink = _item.attr('data-address');
			if(_item.attr('data-width') != undefined && !isEmpty(_item.attr('data-width')) && _item.attr('data-height') != undefined && !isEmpty(_item.attr('data-height'))){
				//we need both width and height
				currentObj.mediaWidth=parseInt(_item.attr('data-width'),10);
				currentObj.mediaHeight=parseInt(_item.attr('data-height'),10);
				
				//check aspect ratio if we have size
				if(_item.attr('data-aspectRatio') != undefined && !isEmpty(_item.attr('data-aspectRatio'))){
					currentObj.aspectRatio=parseInt(_item.attr('data-aspectRatio'),10);
				}else{
					currentObj.aspectRatio=2;//default
				}
				currentObj.ytSizeSet=true;
			}else{
				currentObj.ytSizeSet=false;	
			}
			
			_processYoutube(type, youtube_path);
		}else if(type == 'youtube_playlist'){
			path = _item.attr('data-path');
			//check for 'PL'
			if(_item.attr('data-path').substr(0,2).toUpperCase() == 'PL'){
				//path = _item.attr('data-path').substring(2);
			}
			youtubePlaylistPath=path;
			//console.log(path);
			playlistStartCounter = 1;
			
			youtube_path = "http://gdata.youtube.com/feeds/api/playlists/"+youtubePlaylistPath+"?start-index="+playlistStartCounter+"&max-results=50&v=2&format=5&alt=jsonc";
			
			currentObj={};
			if(useDeeplink)currentObj.deeplink = _item.attr('data-address');
			if(_item.attr('data-width') != undefined && !isEmpty(_item.attr('data-width')) && _item.attr('data-height') != undefined && !isEmpty(_item.attr('data-height'))){
				//we need both width and height
				currentObj.mediaWidth=parseInt(_item.attr('data-width'),10);
				currentObj.mediaHeight=parseInt(_item.attr('data-height'),10);
				
				//check aspect ratio if we have size
				if(_item.attr('data-aspectRatio') != undefined && !isEmpty(_item.attr('data-aspectRatio'))){
					currentObj.aspectRatio=parseInt(_item.attr('data-aspectRatio'),10);
				}else{
					currentObj.aspectRatio=2;//default
				}
				currentObj.ytSizeSet=true;
			}else{
				currentObj.ytSizeSet=false;	
			}
			
			_processYoutube(type, youtube_path);
					
		}
	}
	
	function _processYoutube(type, path) {
		//console.log('_processYoutube: ', type, path);
		jQuery.ajax({
			 url: path,
			 dataType: 'jsonp', 
			 success:function(data){
				 type == 'youtube_single' ? _processYoutubeSingleSuccess(data) : _processYoutubeSuccess(data);
			 },
			 error:function(er){
				 _processYoutubeError(er);
			 }
		});	
	}
	function _processYoutubeSuccess(response) {//for playlist
		 //console.log('_processYoutubeSuccess');
		 //console.log(response);
		 
		 if(response.error){
			alert(response.error.message);
			return;	
		 } 
		 
		 if(response.data.items){
		 
			 var len = response.data.items.length, i = 0, _item, type, path;
			 //console.log('response.data.items.length = ', len);
			 
			 for(i; i < len; i++){
				_item = response.data.items[i].video;
				
				if(!_item || !_item.accessControl){//skip deleted, private videos
					//http://apiblog.youtube.com/2011/12/understanding-playback-restrictions.html
					//https://developers.google.com/youtube/2.0/developers_guide_protocol_uploading_videos#Setting_Access_Controls
					//console.log(i, _item.status.value);	
					continue;
				}
				
				obj = {};
				obj.type = 'youtube';
				if(useDeeplink)obj.deeplink = currentObj.deeplink+(i+1).toString();
				obj.id = _item.id;
				obj.title=_item.title?_item.title:'';
				obj.description=_item.description?_item.description:'';
				if(_item.thumbnail)obj.thumbnail=_item.thumbnail.hqDefault ? _item.thumbnail.hqDefault : _item.thumbnail.sqDefault;
				
				_videoProcessData.push(obj); 
			 }
			 
			 playlistStartCounter += playlistEnlargeCounter;
			 //console.log('playlistStartCounter = ', playlistStartCounter);
			 
			 type = 'youtube_playlist';
			 path = "http://gdata.youtube.com/feeds/api/playlists/"+youtubePlaylistPath+"?start-index="+playlistStartCounter+"&max-results=50&v=2&format=5&alt=jsonc";
			_processYoutube(type, path);
		 
		 }else{//on the end
			_buildPlaylist();
		 }
	}
	
	function _processYoutubeSingleSuccess(response) {
		 //console.log(response);
		 /*
		 console.log(response.data);
		 console.log(response.data.title);
		 console.log(response.data.description);
		 console.log(response.data.id);
		 console.log(response.data.thumbnail.sqDefault);
		 console.log(response.data.thumbnail.hqDefault);
		 */
		 
		 var obj = {}, _item;
		 _item = response.data;
		 
		 if(!_item){
			checkPlaylistProcess();
			return;	 
		 }
		 
		 if(!_item.accessControl){//skip deleted, private videos
			//http://apiblog.youtube.com/2011/12/understanding-playback-restrictions.html
			//https://developers.google.com/youtube/2.0/developers_guide_protocol_uploading_videos#Setting_Access_Controls
			//console.log(_item.status.value);
			checkPlaylistProcess();
		 }else{
			 obj.type = 'youtube';
			 if(useDeeplink)obj.deeplink = currentObj.deeplink;
			 obj.id = _item.id;
			 obj.title=_item.title?_item.title:'';
			 obj.description=_item.description?_item.description:'';
			 if(_item.thumbnail)obj.thumbnail=_item.thumbnail.hqDefault ? _item.thumbnail.hqDefault : _item.thumbnail.sqDefault;
			 _videoProcessData.push(obj);
			 
			 _buildPlaylist();
		 }
	}

	function _processYoutubeError(er) {
		//console.log(er);
	}
	
	//************
	
	function _buildPlaylist() {
		//console.log('_buildPlaylist');
		
		_lastThumbOrientation=null;//important, make thumb holder every time on new playlist
		_playlistOpened=false;//reset for bottom this._autoOpenPlaylist selection
		
		var len = _videoProcessData.length, i = 0, thumb, div, _item, active_icon;
		//console.log('len = ', len);
		
		if(getDeeplinkData){
			dlink = baseURL + strict + firstLevel + '/';
			var str_to_filter, tempArr = categoryArr[activeCategory].mediaName;
		}
		
		for (i; i < len; i++) {
			//console.log(_item.description);
			
			_item = _videoProcessData[i];
			
			//deeplinks
			if(useDeeplink && getDeeplinkData){
				str_to_filter = filterAllowedChars(_item.deeplink);
				//console.log(str_to_filter);
				tempArr.push(str_to_filter);
			}

			playlistLength+=1;
			
			if(outputDeeplinkData){
				if(_item.type == 'local'){//aspect ratio always present
					if(mp4Support){
						loc_path = _item.mp4Path;
					}else if(vorbisSupport){
						loc_path = _item.ogvPath;
					}else if(webmSupport){
						if(_item.webmPath)loc_path = _item.webmPath;
					}
					if(loc_path.lastIndexOf('/')){
						loc_name = loc_path.substr(loc_path.lastIndexOf('/')+1);
					}else{
						loc_name = loc_path;
					}
					deeplinkData.push({'id': playlistLength, 'name': loc_name, 'type':_item.type ,'video-id': loc_path, 'deeplink': dlink+_item.deeplink});
				}else{
					deeplinkData.push({'id': playlistLength, 'name': _item.title?_item.title:'', 'type':_item.type ,'video-id': _item.id, 'deeplink': dlink+_item.deeplink});
				}
			}
			
			div = $('<div/>').addClass('thumbs').attr({'data-id': playlistLength-1, 'data-type': _item.type});
			if(thumbHolder)div.appendTo(thumbInnerContainer).bind('click', clickPlaylistItem);
			
			if(_item.type == 'local'){//aspect ratio always present
				div.attr({'mp4Path': _item.mp4Path, 'ogvPath': _item.ogvPath, 'webmPath': _item.webmPath?_item.webmPath:'', 'imagePath': _item.imagePath, 'data-aspectRatio': _item.aspectRatio});
			}else{
				div.attr('path', _item.id);
				if(currentObj.ytSizeSet){//if we have width and height, aspect ratio always present
					div.attr({'data-width': currentObj.mediaWidth, 'data-height': currentObj.mediaHeight, 'data-aspectRatio': currentObj.aspectRatio});
				}
			}
			
			if(thumbHolder){
				//create thumb
				if(_item.thumbnail){
					thumb=$(new Image()).addClass('thumb_img').appendTo(div).attr('alt', _item.title?_item.title:'').css({
					   cursor:'pointer',
					   opacity:0
					}).load(function() {
						//console.log($(this))
						$(this).stop().animate({ 'opacity':1}, {duration: 500, easing: 'easeOutSine'});//fade in thumb
					}).error(function(e) {
						//console.log("thumb error " + e);
					}).attr('src', _item.thumbnail);
				}
				
				//active icon
				active_icon = $(new Image()).appendTo(div).css({
					position: 'absolute',
					display: 'none'
				}).load(function() {
					//console.log(width,height);
					$(this).css({
						width: this.width,
						height: this.height,
						left: 50+'%',
						top: 50+'%',
						marginLeft: -this.width/2+'px',
						marginTop: -this.height/2+'px'
					})
				}).error(function(e) {
					//console.log("error " + e);
				}).attr('src', ic_active_thumb);
				
				div.data('active_icon',active_icon);
			}
			
			_thumbHolderArr.push(div);//we need to have data to manipulate
		}
		
		checkPlaylistProcess();
	}
	
	//*******************
	
	function clickPlaylistItem(e){
		if(!_componentInited || _playlistTransitionOn) return false;
		//console.log('clickPlaylistItem');
		if (!e) var e = window.event;
		if(e.cancelBubble) e.cancelBubble = true;
		else if (e.stopPropagation) e.stopPropagation();
		
		var currentTarget = $(e.currentTarget);
		var id = currentTarget.attr('data-id');
		//console.log('id = ', id);
		//if(id == _playlistManager.getCounter()) return;//active item
		
		_enableActiveItem();
		_playlistManager.processPlaylistRequest(id);
		
		if(thumbHolder && _closePlaylistOnVideoSelect) {
			_togglePlaylist();
		}
		
		return false;
	}
	
	function _enableActiveItem(){
		//console.log('_enableActiveItem');
		if(_playlistManager.getCounter()!=-1){
			var _item = $(_thumbHolderArr[_playlistManager.getCounter()])
			if(_item){
				_item.removeClass('playlistSelected').addClass('playlistNonSelected');
				if(_item.data('active_icon'))_item.data('active_icon').css('display','none');
			}
		}
	}
	
	function _disableActiveItem(){
		//console.log('_disableActiveItem');
		var _item = $(_thumbHolderArr[_playlistManager.getCounter()]);
		if(_item){
			_item.removeClass('playlistNonSelected').addClass('playlistSelected');
			if(_item.data('active_icon'))_item.data('active_icon').css('display','block');
		}
	}
	
	function nextMedia(){
		if(!_componentInited) return;
		_enableActiveItem();
		_playlistManager.advanceHandler(1, true);
	}
	
	function previousMedia(){
		if(!_componentInited) return;
		_enableActiveItem();
		_playlistManager.advanceHandler(-1, true);
	}	
	
	function destroyMedia(){
		//console.log('destroyMedia');
		if(!_componentInited || !mediaType) return;
		if(mediaType)cleanMedia();
		_enableActiveItem();
		_playlistManager.reSetCounter();
	}
	
	function cleanMedia(){
		//console.log('cleanMedia');
		if(dataIntervalID) clearInterval(dataIntervalID);
		
		if(mediaType && mediaType == 'local'){
			cleanVideo();
		}else if(mediaType && mediaType == 'youtube'){
			if(_youtubePlayer) _youtubePlayer.stop();
			youtubeHolder.css('left', -10000+'px');
		}
		mediaPlaying=false;
		if(isMobile)componentWrapper.find('.controls').css('display','none');
		var url = ic_play_on;
		if(controls_toggle)controls_toggle.css('backgroundImage', 'url('+url+')');
		videoInited=false;
		togglePlayBtn();
		
		if(useSeekbar){
			seekbar.css('display', 'none');
			playProgress.width(0);
			loadProgress.width(0);
		} 
		mac_asr1_fix=false;
	}
	
	function _cleanPlaylist() {
		//console.log('_cleanPlaylist');
		if(scrollType == 'buttons'){
			thumbBackward.css('display','none');
			thumbForward.css('display','none');
		}
		touchOn=false;
		cleanMedia();
		_playlistManager.reSetCounter();
		thumbInnerContainer.empty();
		_thumbInnerContainerSize = 0;
		_thumbHolderArr=[];
		if(_thumbOrientation == 'horizontal'){//scroll on beginning
			thumbInnerContainer.css('left', 0+'px');
		}else{
			thumbInnerContainer.css('top', 0+'px');
		}
		mediaHolder.html('').css('display', 'none');
		html5video_inited=false;
		videoInited=false;
	}
	
	function _setPlaylist() {
		_playlistTransitionOn=true;
		mediaPreloader.css('display','block');
		_getPlaylist();
	}
	
	function _findMedia(){
		//console.log('_findMedia');
		if(!singleVideo) cleanMedia();
		videoInited=false;
		
		var div=$(_thumbHolderArr[_playlistManager.getCounter()]);
		mediaType=div.attr('data-type');
		
		if(mediaType == 'local'){
			mediaPreloader.css('display','block');
			
			if(mp4Support){
				local_mediaPath = div.attr('mp4Path');
			}else if(vorbisSupport){
				local_mediaPath = div.attr('ogvPath');
			}else if(webmSupport){
				if(div.attr('data-webmPath') != undefined && !isEmpty(div.attr('data-webmPath'))){
					local_mediaPath = div.attr('webmPath');
				}
			} 
			imagePath = div.attr('imagePath');
			
			if(div.attr('data-aspectRatio') != undefined && !isEmpty(div.attr('data-aspectRatio'))){
				aspectRatio=parseInt(div.attr('data-aspectRatio'),10);
			}else{
				aspectRatio=2;//default
			}
			if(isiPhoneIpod)aspectRatio=1;//must fit inside!
			
			if(!autoPlay){
				loadPreview();
			}else{
				if(html5Support){
					initVideo();
				}else{
					getFlashMovie('flashPreview').pb_play(local_mediaPath,aspectRatio);
					if(useSeekbar) seekbar.css('display', 'block');
				}
			}
			
		}else if(mediaType == 'youtube'){//youtube
		
			yt_mediaPath=div.attr('path');
		
			ytSizeSet=false;//reset
			//check if size exist
			if(!isiPhoneIpod){//!!keep 100% size, otherwise video would go under playlist, which means we loose buttons! (ipad is fine becuase of youtube chromeless)
				if(div.attr('data-width') != undefined && !isEmpty(div.attr('data-width')) && div.attr('data-height') != undefined && !isEmpty(div.attr('data-height'))){
					//we need both width and height
					mediaWidth=parseInt(div.attr('data-width'),10);
					mediaHeight=parseInt(div.attr('data-height'),10);
					
					//check aspect ratio if we have size
					if(div.attr('data-aspectRatio') != undefined && !isEmpty(div.attr('data-aspectRatio'))){
						aspectRatio=parseInt(div.attr('data-aspectRatio'),10);
					}else{
						aspectRatio=2;//default
					}
					ytSizeSet=true;
				}
				currentAspectRatio = aspectRatio;//always remember original	
			}
			_initYoutube();
		}
	}
	
	//**************** YOUTUBE	
	
	function _initYoutube() {
		//console.log('_initYoutube');
		if(!_youtubeInited){
			var data={'autoPlay': yt_autoPlay, 'defaultVolume': defaultVolume, 
			'mediaPath': yt_mediaPath, 'youtubeHolder': youtubeHolder, 'youtubeChromeless': _youtubeChromeless, 
			'isMobile': isMobile, 'initialAutoplay': initialAutoplay, 'isIE':isIE, 'quality':useYoutubeHighestQuality};
			_youtubePlayer = $.youtubePlayer(data);
			$(_youtubePlayer).bind('ap_YoutubePlayer.YT_READY', function(){
				//console.log('ap_YoutubePlayer.YT_READY');
				videoInited=true;
				resizeVideo();
			});
			$(_youtubePlayer).bind('ap_YoutubePlayer.START_PLAY', function(){
				//console.log('ap_YoutubePlayer.START_PLAY');
				youtubeHolder.css('left', 0+'px');
				resizeVideo();
				if(useSeekbar){
					if(dataIntervalID) clearInterval(dataIntervalID);
					dataIntervalID = setInterval(dataUpdate, dataInterval);	
					seekbar.css('display', 'block');
				} 
				if(!mac_asr1_fix && aspectRatio == 1){
					doneResizing();
				}
				if(isMobile)componentWrapper.find('.controls').css('display','block');
			});
			$(_youtubePlayer).bind('ap_YoutubePlayer.END_PLAY', function(){
				//console.log('ap_YoutubePlayer.END_PLAY');
				if(!singleVideo){
					cleanMedia();
					nextMedia();	
				}else{
					playlistEndAction();
				}
			});
			$(_youtubePlayer).bind('ap_YoutubePlayer.STATE_PLAYING', function(){
				//console.log('ap_YoutubePlayer.STATE_PLAYING');
				togglePlayBtn();
			});
			$(_youtubePlayer).bind('ap_YoutubePlayer.STATE_PAUSED', function(){
				//console.log(_youtubePlayer.getCurrentTime(), _youtubePlayer.getDuration());
				//console.log('ap_YoutubePlayer.STATE_PAUSED');
				if(!isIE){
					togglePlayBtn(true);
				}else{
					if(_youtubePlayer.getCurrentTime()!= _youtubePlayer.getDuration())togglePlayBtn(true);//if single video loops we dont want play btn appean on beginning
				} 
			});
			$(_youtubePlayer).bind('ap_YoutubePlayer.ERROR_HANDLER', function(){
				//console.log('ap_YoutubePlayer.ERROR_HANDLER');
				cleanMedia();
				nextMedia();
			});
			_youtubeInited=true;
		}else{
			youtubeHolder.css('left', 0+'px');
			_youtubePlayer.initVideo(yt_mediaPath);
		}
		if(_playlistManager.getCounter()!=-1){
			if(ytSizeSet){
				resizeMedia();
			}else{
				youtubeHolder.css({
					left: isIE ? -1 : 0+'px', 
					top: isIE ? -1 : 0+'px', 
					width: 100+'%',
					height: 100+'%'
				});
			} 
		}
		//console.log('ytSizeSet = ', ytSizeSet);
		if(!autoPlay) togglePlayBtn(true,true);
	}

	//************************* LOCAL VIDEO
	
	function loadPreview(){
		//console.log('loadPreview');
		previewHolder.empty().css({opacity: 0,display: 'block'});
		var img = $(new Image()).css({
			position: 'relative',
			display: 'block',
			width:100+'%',
			height:100+'%'
		}).load(function() {
			mediaWidth = this.width;
			mediaHeight = this.height;
			//console.log(mediaWidth, mediaHeight);
			previewHolder.append(this);
			resizePreview();
			previewHolder.stop().animate({ 'opacity':1},  {duration: fadeTime, easing: fadeEase});
			togglePlayBtn(true);
			mediaPreloader.css('display','none');
		}).error(function(e) {
			//console.log("error " + e);
		}).attr('src', imagePath);
	}
	
	function cleanVideo(){
		//console.log('cleanVideo');
		previewHolder.empty().css('display','none');
		if(dataIntervalID) clearInterval(dataIntervalID);
		
		if(videoUp2Js){
			videoUp2Js.pause();
			try{
				videoUp2Js.currentTime = 0;
			}catch(er){}
			videoUp2Js.src = '';
		}
		//video.find('source').attr('src','');
		if(video)video.unbind("ended", videoEndHandler).unbind("loadedmetadata", videoMetadata).unbind("waiting",waitingHandler).unbind("playing", playingHandler);
		//video.unbind("canplaythrough", canplaythroughHandler).unbind("canplay", canplayHandler).unbind("play", playHandler).unbind("pause", pauseHandler).unbind("timeupdate", dataUpdate).unbind("volumechange", volumechangeHandler);
		mediaHolder.css('display', 'none');
		if(!isMobile & html5Support){
			mediaHolder.html('');
			html5video_inited=false;	
		}

		if(big_play) big_play.css('display', 'none'); 
		if(useSeekbar){
			seekbar.css('display', 'none');
			playProgress.width(0);
			loadProgress.width(0);
		} 
		if(!html5Support) getFlashMovie('flashPreview').pb_dispose();
		mediaPreloader.css('display','none');
	}
	
	function initVideo(){
		//console.log('initVideo');
		var videoCode='';
		
		if(!html5video_inited){//we need one video source if we want to auto-advance on ios6 (with no click)
		
			if(mp4Support){
				if(!isAndroid){
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'"  type="video/mp4" />';
					videoCode += '</video>';
				}else{//no type for android (http://www.broken-links.com/2010/07/08/making-html5-video-work-on-android-phones/)
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'" />';
					videoCode += '</video>';
				}
			}else if(vorbisSupport){
				if(!isAndroid){
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'"  type="video/ogg" />';
					videoCode += '</video>';
				}else{
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'" />';
					videoCode += '</video>';
				}
			}else if(webMsupport){
				if(!isAndroid){
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'"  type="video/webm" />';
					videoCode += '</video>';
				}else{
					videoCode += '<video class="video_cont" width="'+mediaWidth+'" height="'+mediaHeight+'" >';
					videoCode += '<source src="'+local_mediaPath+'" />';
					videoCode += '</video>';
				}
			} 
			
			mediaHolder.css('display','block').html(videoCode);
			
			video = componentWrapper.find('.video_cont');//get player reference
			videoUp2Js = video[0];
			//console.log(video, videoUp2Js);
			
		}else{
			
			mediaHolder.css('display','block');
			videoUp2Js.src = local_mediaPath;
			videoUp2Js.load();
			
		}
		
		videoUp2Js.volume = defaultVolume;
		video.bind("ended", videoEndHandler).bind("loadedmetadata", videoMetadata).bind("waiting",waitingHandler).bind("playing", playingHandler);
		//video.bind("canplaythrough", canplaythroughHandler).bind("canplay", canplayHandler).bind("play", playHandler).bind("pause", pauseHandler).bind("timeupdate", dataUpdate).bind("volumechange", volumechangeHandler);
			
		if(isIOS && !html5video_inited){
			videoUp2Js.src = local_mediaPath;
			videoUp2Js.load();
		}
		else if(isAndroid && !html5video_inited){
			videoUp2Js.play();
			togglePlayBtn();
			previewHolder.stop().animate({ 'opacity':0},  {duration: fadeTime, easing: fadeEase, complete:function(){
				previewHolder.empty().css('display','none');
			}});
			videoInited=true;
		}
		
		if(useSeekbar) seekbar.css('display', 'block');
		
		html5video_inited=true;
	}
	
	function waitingHandler(){//show preloader
		//console.log('waitingHandler');
		mediaPreloader.css('display','block');
	}
	
	function playingHandler(){//hide preloader
		//console.log('playingHandler');
		mediaPreloader.css('display','none');
		if(!mac_asr1_fix && aspectRatio == 1){
			mac_asr1_fix=true;
			doneResizing();
		}
	}
	
	function playHandler(e){
		togglePlayBtn();
		mediaPlaying=true;
	}
	
	function pauseHandler(e){
		togglePlayBtn(true);
		mediaPlaying=false;
	}
	
	function dataUpdate(){
		//console.log('dataUpdate');
		var percent;
		if(mediaType == 'local'){
			if(useSeekbar && !seekBarDown){
				playProgress.width((videoUp2Js.currentTime / videoUp2Js.duration) * _getComponentSize('w'));
				try{
					var buffered = Math.floor(videoUp2Js.buffered.end(0));
				}catch(error){}
				percent = buffered / Math.floor(videoUp2Js.duration);
				//console.log(buffered);
				if(!isNaN(percent)){//opera has no buffered 
					loadProgress.width(percent * _getComponentSize('w'));	
				}else{
					//console.log(videoUp2Js.readyState);
					if(videoUp2Js.readyState == 4){//for opera
						//loadProgress.width(getPlayerSize('w'));
					}
				}
			}
		}else if(mediaType == 'youtube'){
			if(useSeekbar && !seekBarDown && _youtubePlayer){
				//console.log(_youtubePlayer.getCurrentTime(), _youtubePlayer.getDuration());
				playProgress.width((_youtubePlayer.getCurrentTime() / _youtubePlayer.getDuration()) * _getComponentSize('w'));
				//console.log(_youtubePlayer.getVideoLoadedFraction());
				if(_youtubePlayer.getVideoLoadedFraction() > 0.95){//on some browsers value never gets 1, it stops slightly before 1, so seekbar is never 100% length
					loadProgress.width(_getComponentSize('w'));
				}else{
					loadProgress.width(_youtubePlayer.getVideoLoadedFraction() * _getComponentSize('w'));
				}
			}
		}
	};
	
	function videoEndHandler(){
		//console.log('videoEndHandler');
		if(!singleVideo){
			mediaHolder.stop().animate({ 'opacity':0},  {duration: fadeTime, easing: fadeEase, complete:function(){
				cleanMedia();
				nextMedia();	
			}});
		}else{
			playlistEndAction();
		}
	}
	
	function playlistEndAction(){
		//console.log('playlistEndAction');
		if(onPlaylistEndGoToUrl){//override looping on
			goToUrl();
		}else{
			if(mediaType == 'local'){
				videoUp2Js.currentTime=0;
				//console.log(videoUp2Js.paused);
				if(videoUp2Js.paused)videoUp2Js.play();
				if(!autoPlay){
					videoUp2Js.pause();
					togglePlayBtn(true);
					setTimeout(function(){mediaPreloader.css('display','none');},500);//remove preloader after waiting event
				}
			}else if(mediaType == 'youtube'){
				if(autoPlay){
					if(loopingOn){
						_youtubePlayer.play();
					}else{
						togglePlayBtn();//yt has its own btn
					}
				}else{
					togglePlayBtn();//yt has its own btn
				}
			}
		}
	}
	
	function videoMetadata(e){
		//console.log("videoMetadata: ", videoUp2Js.duration, videoUp2Js.videoWidth, videoUp2Js.videoHeight);
		resizeMedia();
		mediaHolder.stop().animate({ 'opacity':1},  {duration: fadeTime, easing: fadeEase});
		setVolume();
		if(dataIntervalID) clearInterval(dataIntervalID);
		dataIntervalID = setInterval(dataUpdate, dataInterval);
		
		videoUp2Js.play();
		videoInited=true;
		togglePlayBtn();
		if(isMobile)componentWrapper.find('.controls').css('display','block');

		if(initialAutoplay) autoPlay=true;
	}
	
	function togglePlayback(){
		 //console.log('togglePlayback');
		 if(mediaType == 'local'){
			 
			 if(!videoInited && !autoPlay){
				togglePlayBtn();
				previewHolder.stop().animate({ 'opacity':0},  {duration: fadeTime, easing: fadeEase, complete:function(){
					previewHolder.empty().css('display','none');
				}});
				if(html5Support){
					initVideo();
				}else{
					getFlashMovie('flashPreview').pb_play(local_mediaPath,aspectRatio); 
					if(useSeekbar) seekbar.css('display', 'block');
				}
			 }else{
				 if(html5Support){
					if(videoUp2Js.paused) {
						  videoUp2Js.play();
						  togglePlayBtn();
					}else{
						  videoUp2Js.pause();
						  togglePlayBtn(true);
					}
				 }else{
					getFlashMovie('flashPreview').pb_togglePlayback(); 
				 }
			 }
			 videoInited=true;
		 
		 }else if(mediaType == 'youtube'){
			  if(!isOpera){
				  if(_youtubePlayer){
					  _youtubePlayer.togglePlayback();
				  } 
			  }else{//opera fix
				if(mediaPlaying){
					_youtubePlayer.pause();
					pauseHandler();
				}else{
					_youtubePlayer.play();
					playHandler();
				}  
			  }
	   	 }
		 return false;
	}
	
	function togglePlayback2(state){
		  //console.log('togglePlayback2');
		 if(mediaType == 'local'){
			 
			 if(state){//start
					
				if(!videoInited && !autoPlay){
					 togglePlayBtn();
					 previewHolder.stop().animate({ 'opacity':0},  {duration: fadeTime, easing: fadeEase, complete:function(){
						previewHolder.empty().css('display','none');
					}});
					if(html5Support){
						initVideo();
					}else{
						getFlashMovie('flashPreview').pb_play(local_mediaPath,aspectRatio); 
						if(useSeekbar) seekbar.css('display', 'block');
					}
				}else{
					 if(html5Support){
					     if(videoUp2Js.paused) {
							 videoUp2Js.play();
							 togglePlayBtn();
					  	 }
					 }else{
						 getFlashMovie('flashPreview').pb_togglePlayback2(true); 
					 }
				}
				videoInited=true;	
					
			 }else{//stop
			
				 if(videoInited){
					
					if(html5Support){
						 if(!videoUp2Js.paused) {
							 videoUp2Js.pause();
							 togglePlayBtn(true);
						 }
					}else{
						getFlashMovie('flashPreview').pb_togglePlayback2(false); 
					}
				 }
			 }
		 
		 }else if(mediaType == 'youtube'){
			  if(_youtubePlayer) _youtubePlayer.togglePlayback();
	   	 }
	}
	
	function togglePlayBtn(on, dontShowBigPlay){
		//console.log('togglePlayBtn');
		if(on){
			if(!dontShowBigPlay){
				big_play.css('display', 'block').stop().animate({ 'opacity':1},  {duration: fadeTime, easing: fadeEase});
			}
			if(controls_toggle){
				var url = ic_play;
				controls_toggle.css('backgroundImage', 'url('+url+')');
			}
			mediaPlaying=false;
		}else{
			big_play.stop().animate({ 'opacity':0},  {duration: fadeTime, easing: fadeEase, complete: function(){
			   big_play.css('display', 'none');  
			}});
			if(controls_toggle){
				var url = ic_pause;
				controls_toggle.css('backgroundImage', 'url('+url+')');
			}
			mediaPlaying=true;
		}
	}
	
	function setVolume(){
		if(volume_level)volume_level.css('width',defaultVolume*volumeSize+'px');
		//if(!videoInited)return;
		//console.log('setVolume ', defaultVolume);
		if(mediaType == 'local'){
			if(html5Support){
				if(videoUp2Js)videoUp2Js.volume = defaultVolume;
			}else{
				getFlashMovie('flashPreview').pb_setVolume(defaultVolume); 
			}
			if(defaultVolume == 0){
				//if(html5Support) videoUp2Js.muted = true;
				var url = ic_mute;
			}else if(defaultVolume > 0){
				//if(html5Support) videoUp2Js.muted = false;
				var url = ic_volume;
			}
			if(volume_toggle){
				volume_toggle.css('backgroundImage', 'url('+url+')');
			} 
		}else if(mediaType == 'youtube'){
			if(_youtubePlayer) _youtubePlayer.setVolume(defaultVolume);
			if(defaultVolume == 0){
				var url = ic_mute;
			}else if(defaultVolume > 0){
				var url = ic_volume;
			}
			if(volume_toggle){
				volume_toggle.css('backgroundImage', 'url('+url+')');
			} 
		}
		
		if(isMobile){//additional hide volume on timer after we use vol seekbar so vol toggle btn doesnt have to be used to close vol seekbar
			if(volumeTimeoutID) clearTimeout(volumeTimeoutID);
			volumeTimeoutID = setTimeout(hideVolume,volumeTimeout);	
		}
	}
	
	//************** flash
	
	function checkFlashReady(){
		//console.log('checkFlashReady');
		if(getFlashMovie("flashPreview").setData != undefined){
			if(flashReadyIntervalID) clearInterval(flashReadyIntervalID);
			getFlashMovie('flashPreview').setData(settings, useSeekbar);//pass data to flash
			checkPlaylistProcess();
		}
	 }
	
	function getFlashMovie(name) {
		return (navigator.appName.indexOf("Microsoft") != -1) ? window[name] : document[name];
	}	
	
	//*********** flash callbacks
	
	$.videoGallery.flashWaitingHandler = function() {
		mediaPreloader.css('display','block');
	}
	
	$.videoGallery.flashPlayingHandler = function() {
		mediaPreloader.css('display','none');
	}
	
	$.videoGallery.flashVideoEnd = function() {
		nextMedia();
	}
	
	$.videoGallery.flashVideoStart= function() {}
	
	$.videoGallery.togglePlayBtn= function(on) {
		togglePlayBtn(on);	
	}
	
	$.videoGallery.visitUrl= function() {
		goToUrl();
	}
	
	$.videoGallery.dataUpdateFlash= function(bl,bt,t,d) {
		if(useSeekbar){
			loadProgress.width((bl/bt) * _getComponentSize('w'));	
			playProgress.width((t/d) * _getComponentSize('w'));
		}
	}
	
	//************
	
	function canPlayVorbis() {
		var v = document.createElement('video');
		return !!(v.canPlayType && v.canPlayType('video/ogg; codecs="theora, vorbis"').replace(/no/, ''));
	}
	
	function canPlayMP4() {
		var v = document.createElement('video');
		return !!(v.canPlayType && v.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/no/, ''));
	}
	
	function canPlayWebM() {
		var v = document.createElement('video');
		return !!(v.canPlayType && v.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/no/, ''));
	}
	
	function preventSelect(arr){
		$(arr).each(function() {           
		$(this).attr('unselectable', 'on')
		   .css({
			   '-moz-user-select':'none',
			   '-webkit-user-select':'none',
			   'user-select':'none'
		   })
		   .each(function() {
			   this.onselectstart = function() { return false; };
		   });
		});
	}	
	
	function isEmpty(str) {
	    return str.replace(/^\s+|\s+$/g, '').length == 0;
	}
	
	function checkCookies(){//intro
		//console.log('checkCookies');
		if(onPlaylistEndGoToUrl && useCookieDetection && loadData('page_intro') == 'visited'){
			goToUrl();	
			return true;		
		}else{
			return false;	
		}
	}
	
	//******** fullscreen
	
	if(useFullscreen){
		_doc.on("fullscreenchange mozfullscreenchange webkitfullscreenchange", function(){
			//console.log('fullScreenStatus()');
			setFullscreenIcon();
		});
	}
	
	function setFullscreenIcon(){
		if ((document.fullScreenElement && document.fullScreenElement !== null) ||   
			(!document.mozFullScreen && !document.webkitIsFullScreen)) { 
			 var url = ic_fullscreen_enter; 
		}else{
			 var url = ic_fullscreen_exit; 
		}
		if(controls_fullscreen)controls_fullscreen.css('backgroundImage', 'url('+url+')');
	}
	
	function toggleFullscreen(){
	   if(html5Support){
		  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    // alternative standard method
			  (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // current working methods
			if (document.documentElement.requestFullScreen) {
			  document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
			  document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
			  document.documentElement.webkitRequestFullScreen();
			}else if(isIOS){
				try{
					if(videoUp2Js && typeof videoUp2Js.webkitEnterFullScreen !== "undefined")videoUp2Js.webkitEnterFullScreen();
				}catch(error){}
			}else{
				//console.log('no fullscreen');
			}
		  } else {
				if (document.cancelFullScreen) {
				  document.cancelFullScreen();
				} else if (document.mozCancelFullScreen) {
				  document.mozCancelFullScreen();
				} else if (document.webkitCancelFullScreen) {
				  document.webkitCancelFullScreen();
				}
		  }
		  setFullscreenIcon();
	    }
	}
	
	function checkFullScreenSupport() {
	   var support=false;
		if (document.documentElement.requestFullScreen) {
		  support=true;
		} else if (document.documentElement.mozRequestFullScreen) {
		   support=true;
		} else if (document.documentElement.webkitRequestFullScreen) {
		   support=true;
		}
		return support;
	}
	
	/***************** RESIZE *******************/
	
	function resizePreview() {
		//console.log('resizePreview');
		if(previewHolder.children().length==0)return;
		var o, x, y;
		
		if(aspectRatio == 0) {//normal media dimensions
			o=getMediaSize();
		}
		else if(aspectRatio == 1) {//fitscreen
			o = retrieveObjectRatio(true);
		}
		else if(aspectRatio == 2) {//fullscreen
			o = retrieveObjectRatio(false);
		}
		x = (_getMediaWrapperSize('w') - o.width) / 2;
		y = (_getMediaWrapperSize('h') - o.height) / 2;
		//console.log(x, ' , ', y,  ' , ',o.width,  ' , ',o.height);
		previewHolder.css({width: o.width+ 'px',height: o.height+ 'px',left:x+'px', top:y+'px'});
	}
	
	function resizeMedia() {
		//console.log('resizeMedia');
		var o, x, y;
		
		if(mediaType=='local'){
			if(aspectRatio == 0) {//normal media dimensions
				o=getMediaSize();
			}
			else if(aspectRatio == 1) {//fitscreen
				o = retrieveObjectRatio(true);
			}
			else if(aspectRatio == 2) {//fullscreen
				o = retrieveObjectRatio(false);
			}
			video.css({width: o.width+ 'px', height: o.height+ 'px'});
			x = (_getMediaWrapperSize('w') - o.width) / 2;
			y = (_getMediaWrapperSize('h') - o.height) / 2;
			mediaHolder.css({left:x+'px', top:y+'px'});
		}else{
			if(isipad && ytSizeSet && ipadOrientation=='landscape' && thumbHolder){//fix
				aspectRatio=1;
			}else{
				aspectRatio=currentAspectRatio;//restore
			}
			
			if(aspectRatio == 0) {//normal media dimensions
				o=getMediaSize();
			}
			else if(aspectRatio == 1) {//fitscreen
				o = retrieveObjectRatio(true);
			}
			else if(aspectRatio == 2) {//fullscreen
				o = retrieveObjectRatio(false);
			}
			x = (_getMediaWrapperSize('w') - o.width) / 2;
			y = (_getMediaWrapperSize('h') - o.height) / 2;
			if(isIE){
				youtubeHolder.css({width:o.width+2+'px', height:o.height+2+'px', left:x-1+'px', top:y-1+'px'});
			}else{
				youtubeHolder.css({width:o.width+'px', height:o.height+'px', left:x+'px', top:y+'px'});
			}			
		}
	}
	
	 function retrieveObjectRatio( _fitScreen ) {
		 
		var _paddingX=0;
		var _paddingY=0;
	 
		var w = _getMediaWrapperSize('w');
	 	var h = _getMediaWrapperSize('h');
		//console.log('retrieveObjectRatio: ', w, ' , ' , h);
	 
		var o = getMediaSize();
		var targetWidth, targetHeight;
		targetWidth = o.width;
		targetHeight = o.height;
		
		var destinationRatio = (w - _paddingX) / (h - _paddingY);
		var targetRatio = targetWidth / targetHeight;

		if (targetRatio < destinationRatio) {
			if (!_fitScreen) {//fullscreen
				o.height = ((w - _paddingX) /targetWidth) * targetHeight;
				o.width = (w - _paddingX);
			} else {//fitscreen
				o.width = ((h - _paddingY) / targetHeight) *targetWidth;
				o.height = (h - _paddingY);
			}
		} else if (targetRatio > destinationRatio) {
			if (_fitScreen) {//fitscreen
				o.height = ((w - _paddingX) /targetWidth) * targetHeight;
				o.width = (w - _paddingX);
			} else {//fullscreen
				o.width = ((h - _paddingY) / targetHeight) *targetWidth;
				o.height = (h - _paddingY);
			}
		} else {//fitscreen & fullscreen
			o.width = (w - _paddingX);
			o.height = (h - _paddingY);
		}
		return o;
	}
	
	function getMediaSize() {
		//console.log('getMediaSize: ', mediaWidth, ', ', mediaHeight);
		var o={};
		if(mediaType=='local'){
			if(!mediaWidth || isNaN(mediaWidth) || !mediaHeight || isNaN(mediaHeight)){
				o.width = videoUp2Js.videoWidth;
				o.height = videoUp2Js.videoHeight;
			}else{
				o.width=mediaWidth;
				o.height=mediaHeight;	
			}
		}else{//youtube
			if(!mediaWidth || isNaN(mediaWidth) || !mediaHeight || isNaN(mediaHeight)){
				o.width = 640;//default youtube values (16:9)
				o.height = 360;
			}else{
				o.width=mediaWidth;
				o.height=mediaHeight;	
			}
		}
		return o;
	}
	
	function _getComponentSize(type) {
		if(type == "w"){//width
			return componentWrapper.width();
		}else{//height
			if(!skipIntroExist){
				return componentWrapper.height();
			}else{
				if(!skipIntroTop){
					return componentWrapper.height();
				}else{
					return componentWrapper.height() - skipIntro.height();
				}
			}
		}
	}
	
	function _getComponentSizeClear(type) {
		if(type == "w"){//width
			return componentWrapper.width();
		}else{//height
			return componentWrapper.height();
		}
	}
	
	function _getMediaWrapperSize(type) {
		if(type == "w"){//width
			return mediaWrapper.width();
		}else{//height
			return mediaWrapper.height();
		}
	}
	
	if(!componentFixedSize){
		_window.resize(function() {
			if(windowResizeTimeoutID) clearTimeout(windowResizeTimeoutID);
			windowResizeTimeoutID = setTimeout(doneResizing, windowResizeTimeout);
		});
	}
	
	function resizeVideo(){
		if(_playlistManager.getCounter()==-1)return;
		//console.log('resizeVideo');
		if(mediaType=='local'){
			if(videoInited){
				if(html5Support){
					resizeMedia();
				}
			}else if(!autoPlay){
				resizePreview();
			}
		}else{
			if(ytSizeSet)resizeMedia();
		}
	}
	
	function checkScroll(){
		//console.log('checkScroll');
		if(!scrollPane){
			
			scrollPane = thumbContainer;
			scrollPane.jScrollPane();
			scrollPaneApi = scrollPane.data('jsp');
			
			scrollPane.bind('jsp-initialised',function(event, isScrollable){
				//console.log('Handle jsp-initialised', this,'isScrollable=', isScrollable);
			});
			
			if(!isMobile)thumbContainer.bind('mousewheel', horizontalMouseWheel);//init on both sides (not just horizontal) because layout can be switched!
			
		}else{
			scrollPaneApi.reinitialise();
			if(_thumbOrientation == 'vertical'){
				scrollPaneApi.scrollToY(0);
				$('.jspPane').css('left',0+'px');
			}else{
				scrollPaneApi.scrollToX(0);
				$('.jspPane').css('top',0+'px');
			}
		}
	}
	
	function horizontalMouseWheel(event, delta, deltaX, deltaY){//for thumb scroll
		if(!_componentInited || _playlistTransitionOn) return false;
		if(_thumbOrientation == 'horizontal'){
			var d = delta > 0 ? -1 : 1;//normalize
			if(scrollPaneApi) scrollPaneApi.scrollByX(d * 100);
		}
		return false;
	}
	
	function doneResizing(start){//called in window resize
		//console.log('doneResizing');
		var w = _getComponentSizeClear('w'), h = _getComponentSizeClear('h');
		
		//chek for position of skip intro
		if(skipIntroExist){
			if(isiPhoneIpod || w < 500){
				skipIntroTop=true;
				if(!isIEBelow8)skipIntro.removeClass().addClass('skip_intro_top');
				mediaWrapper.css('top', skipIntro.height()+'px');
				if(useSeekbar)seekbar.css('top',3+'px');//separate it from intro at the top
			}else{
				skipIntroTop=false;
				if(!isIEBelow8)skipIntro.removeClass().addClass('skip_intro');
				mediaWrapper.css('top',0+'px');
				if(useSeekbar)seekbar.css('top',0+'px');
			}
		}
		
		if(_thumbOrientation != _lastThumbOrientation){//not if already applied
			_makeThumbHolder();
			_lastThumbOrientation = _thumbOrientation;//save new 
		}else{
			_resizeElements();
		}
		
		if(thumbHolder){
			if(scrollType == 'buttons'){
				_checkThumbPosition();
			}else{
				checkScroll();
			}
		}
		if(!start)resizeVideo();
		if(useSeekbar)seekbar_hit.width(_getComponentSize('w'));
	}
	
	function _makeThumbHolder(){//resize with thumbnails layout change
		//console.log('makeThumbHolder ', _thumbOrientation);
		var val, w = _getComponentSize('w'), h = _getComponentSize('h');
		
		if(thumbHolder){
			_thumbInnerContainerSize=0;//reset
			thumbContainer.css({width: '', height: ''});
			thumbInnerContainer.css({width: '', height: ''});
		}
		
		if(_thumbOrientation == 'horizontal'){
			
			if(thumbHolder){
				thumbHolder.removeClass().addClass('thumbHolder');
				playlistControls.removeClass().addClass('playlistControls');
				playlistHitArea = playlistControls.height();
				thumbHolderSize = thumbHolder.height();
				
				if(scrollType == 'buttons'){
					thumbBackward.removeClass().addClass('thumbBackward');
					thumbForward.removeClass().addClass('thumbForward');
					_thumbBackwardSize = parseInt(thumbBackward.css('width'),10);
					_thumbForwardSize = parseInt(thumbForward.css('width'),10);
				}
			}else{
				thumbHolderSize=0;
				playlistHitArea = 0;
			}
			
			if(_playlistOpened){
				val = h - thumbHolderSize;
				if(thumbHolder)thumbHolder.css('bottom', 0+'px');
			}else{
				val = h - playlistHitArea;
				if(thumbHolder)thumbHolder.css('bottom', -thumbHolderSize+playlistHitArea+'px');
			}
			
			mediaWrapper.removeClass().addClass('mediaWrapper').css({width: 100+'%', height: val+'px'});
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					thumbContainer.removeClass().addClass('thumbContainer').css({width: w-_thumbBackwardSize-_thumbForwardSize+'px', left: _thumbBackwardSize+'px', top:''});
				}else{
					thumbContainer.removeClass().addClass('thumbContainer').css('width', w+'px');
				}
				thumbInnerContainer.removeClass().addClass('thumbInnerContainer').css({top: 0+'px', left: 0+'px'});
				
				//align playlist buttons
				if(playlist_switch){
					if(w > 250){
						playlist_toggle.removeClass().addClass('playlist_toggle');
					}else{
						playlist_toggle.removeClass().addClass('playlist_toggle_left');
					}
					playlist_switch.removeClass().addClass('playlist_switch');
				}else{
					playlist_toggle.removeClass().addClass('playlist_toggle');
				}
				
				var i = 0, len = _thumbHolderArr.length, div;
				$(_thumbHolderArr[len-1]).css({marginRight: 0+'px'});//before we measure _thumbInnerContainerSize
				for(i;i<len;i++){
					div = $(_thumbHolderArr[i]).removeClass().addClass('thumbs');
					_thumbInnerContainerSize+=div.outerWidth(true);
				}
				thumbInnerContainer.css('width', _thumbInnerContainerSize+'px');//only for horizontal
			}
			
		}else{//vertical
			
			if(thumbHolder){
				thumbHolder.removeClass().addClass('thumbHolder_v');
				playlistControls.removeClass().addClass('playlistControls_v');
				playlistHitArea = playlistControls.width();
				thumbHolderSize = thumbHolder.width();
				
				if(scrollType == 'buttons'){
					thumbBackward.removeClass().addClass('thumbBackward_v');
					thumbForward.removeClass().addClass('thumbForward_v');
					_thumbBackwardSize = parseInt(thumbBackward.css('height'),10);
					_thumbForwardSize = parseInt(thumbForward.css('height'),10);
				}
			}else{
				thumbHolderSize=0;
				playlistHitArea = 0;
			}
			
			if(_playlistOpened){
				val = w - thumbHolderSize;
				if(thumbHolder)thumbHolder.css('right', 0+'px');
			}else{
				val = w - playlistHitArea;
				if(thumbHolder)thumbHolder.css('right', -thumbHolderSize+playlistHitArea+'px');
			}
			
			mediaWrapper.removeClass().addClass('mediaWrapper_v').css({width: val+'px', height: 100+'%'});
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					thumbContainer.removeClass().addClass('thumbContainer_v').css({height: h-_thumbBackwardSize-_thumbForwardSize+'px',top: _thumbBackwardSize+'px', left:''});
				}else{
					var vt = skipIntroTop ? skipIntro.height() : 0;
					thumbContainer.removeClass().addClass('thumbContainer_v').css({height: h+vt+'px'});
				}
				thumbInnerContainer.removeClass().addClass('thumbInnerContainer_v').css({top: 0+'px', left: 0+'px'});
				
				//align playlist buttons
				if(playlist_switch){
					if(h > 250){
						playlist_toggle.removeClass().addClass('playlist_toggle_v');
					}else{
						playlist_toggle.removeClass().addClass('playlist_toggle_v_bottom');
					}
					playlist_switch.removeClass().addClass('playlist_switch_v');
				}else{
					playlist_toggle.removeClass().addClass('playlist_toggle_v');
				}
				
				var i = 0, len = _thumbHolderArr.length, div;
				$(_thumbHolderArr[len-1]).css({marginBottom: 0+'px'});//before we measure _thumbInnerContainerSize
				for(i;i<len;i++){
					div = $(_thumbHolderArr[i]).removeClass().addClass('thumbs_v');
					_thumbInnerContainerSize+=div.outerHeight(true);
				}
			}
		}
		
		if(thumbHolder){
			_disableActiveItem();//reapply title	
		
			var url;
			//change playlist icons
			if(_playlistOpened){
				url = _thumbOrientation == 'horizontal' ? ic_thumb_next_v : ic_thumb_next;
				playlist_toggle.css('backgroundImage', 'url('+url+')');
			} else{
				url = _thumbOrientation == 'horizontal' ? ic_thumb_prev_v : ic_thumb_prev;
				playlist_toggle.css('backgroundImage', 'url('+url+')');
			}
	
			/*
			url = _thumbOrientation == 'horizontal' ? ic_switch : ic_switch;
			playlist_switch.css('backgroundImage', 'url('+url+')');
			*/
			if(scrollType == 'buttons'){
				url = _thumbOrientation == 'horizontal' ? ic_thumb_next : ic_thumb_next_v;
				thumbForward.css('backgroundImage', 'url('+url+')');
			
				url = _thumbOrientation == 'horizontal' ? ic_thumb_prev : ic_thumb_prev_v;
				thumbBackward.css('backgroundImage', 'url('+url+')');
			}
		}
	}
	
	function _resizeElements() {//resize with NO thumbnails layout change
		//console.log('_resizeElements');

		var val, w = _getComponentSize('w'), h = _getComponentSize('h');
		if(_thumbOrientation == 'horizontal'){
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					_thumbBackwardSize = parseInt(thumbBackward.css('width'),10);
					_thumbForwardSize = parseInt(thumbForward.css('width'),10);
				}
				playlistHitArea = playlistControls.height();
				thumbHolderSize = thumbHolder.height();
			}else{
				thumbHolderSize=0;
				playlistHitArea = 0;
			}
			
			if(_playlistOpened){
				val = h - thumbHolderSize;
				if(thumbHolder)thumbHolder.css('bottom', 0+'px');
			}else{
				val = h - playlistHitArea;
				if(thumbHolder)thumbHolder.css('bottom', -thumbHolderSize+playlistHitArea+'px');
			}
			
			mediaWrapper.css('height', val+'px');
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					thumbContainer.css('width', w-_thumbBackwardSize-_thumbForwardSize+'px');
				}else{
					thumbContainer.css('width', w+'px');	
				}
				
				//align playlist buttons
				if(playlist_switch){
					if(w > 250){
						playlist_toggle.removeClass().addClass('playlist_toggle');
					}else{
						playlist_toggle.removeClass().addClass('playlist_toggle_left');
					}
				}
			}
			
		}else{
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					_thumbBackwardSize = parseInt(thumbBackward.css('height'),10);
					_thumbForwardSize = parseInt(thumbForward.css('height'),10);
				}
				playlistHitArea = playlistControls.width();
				thumbHolderSize = thumbHolder.width();
			}else{
				thumbHolderSize=0;
				playlistHitArea = 0;
			}
			
			if(_playlistOpened){
				val = w - thumbHolderSize;
				if(thumbHolder)thumbHolder.css('right', 0+'px');
			}else{
				val = w - playlistHitArea;
				if(thumbHolder)thumbHolder.css('right', -thumbHolderSize+playlistHitArea+'px');
			}
			
			mediaWrapper.css('width', val+'px');
			
			if(thumbHolder){
				if(scrollType == 'buttons'){
					thumbContainer.css('height', h-_thumbBackwardSize-_thumbForwardSize+'px');
				}else{
					thumbContainer.css({height: h+'px'});
				}
				
				//align playlist buttons
				if(playlist_switch){
					if(h > 250){
						playlist_toggle.removeClass().addClass('playlist_toggle_v');
					}else{
						playlist_toggle.removeClass().addClass('playlist_toggle_v_bottom');
					}
				}
			}
		}
	}
	
	function _switchLayout(){//switch thumb layout
		var h = _getComponentSize('h'), w = _getComponentSize('w');
		if(_thumbOrientation == 'horizontal'){
			_thumbOrientation = 'vertical';
		}else{
			_thumbOrientation = 'horizontal';
		}
		_makeThumbHolder();
		_lastThumbOrientation = _thumbOrientation;//save new 
		if(scrollType == 'buttons'){
			_checkThumbPosition();
		}else{
			checkScroll();	
		}
		resizeVideo();
	}
	
	/*function _centerComponent(){
		var w = _window.width(),h = _window.height(),w1 = _getComponentSize('w'),h1 = _getComponentSize('h');
		if(w<=w1){
			componentWrapper.css({
				left:0+'px',
				marginLeft:0+'px'
			});
		}else{
			componentWrapper.css({
				left:50+'%',
				marginLeft:-w1/2+'px'
			});
		}
		if(h<=h1){
			componentWrapper.css({
				top:0+'px',
				marginTop:0+'px'
			});
		}else{
			componentWrapper.css({
				top:50+'%',
				marginTop:-h1/2+'px'
			});
		}
	}*/
	
	function _checkThumbPosition() {//check thumbs and thumb buttons
		//console.log('_checkThumbPosition');
		if(_thumbOrientation == 'horizontal'){
			var w = _getComponentSize('w'), value;
			if(_thumbInnerContainerSize > w-_thumbBackwardSize-_thumbForwardSize){
				thumbBackward.css('display','block');
				thumbForward.css('display','block');
				touchOn=true;
				value = parseInt(thumbInnerContainer.css('left'),10);
				if(value < w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=w- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}else if(value > 0){
					value=0;
				}
				thumbInnerContainer.css('left', value+'px');
			}else{
				//center thumbs if less
				thumbBackward.css('display','none');
				thumbForward.css('display','none');
				touchOn=false;
				thumbInnerContainer.css('left', w / 2 - _thumbInnerContainerSize / 2 - _thumbBackwardSize +'px');
			}
		}else{
			var h = _getComponentSize('h'), value;
			if(_thumbInnerContainerSize > h-_thumbBackwardSize-_thumbForwardSize){
				thumbBackward.css('display','block');
				thumbForward.css('display','block');
				touchOn=true;
				value = parseInt(thumbInnerContainer.css('top'),10);
				if(value < h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize){
					if(_thumbScrollIntervalID) clearInterval(_thumbScrollIntervalID);
					value=h- _thumbInnerContainerSize - _thumbForwardSize - _thumbBackwardSize;	
				}else if(value > 0){
					value=0;
				}
				thumbInnerContainer.css('top', value+'px');
			}else{
				//center thumbs if less
				thumbBackward.css('display','none');
				thumbForward.css('display','none');
				touchOn=false;
				thumbInnerContainer.css('top', h / 2 - _thumbInnerContainerSize / 2 - _thumbBackwardSize +'px');
			}
		}
	}
	
	function _togglePlaylist() {
		//console.log('_togglePlaylist');
		var size, time=500;
		if(_playlistOpened){
			_playlistOpened=false;//before buttons change so rollout gets triggered properly
			
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_prev_v : ic_thumb_prev;
			playlist_toggle.css('backgroundImage', 'url('+url+')');
			
			if(_thumbOrientation=='horizontal'){
				size = _getComponentSize('h')-playlistHitArea;
				thumbHolder.stop().animate({ 'bottom': -thumbHolderSize+playlistHitArea+'px'},  {duration: time, easing: 'easeOutQuart', complete: function(){
					mediaWrapper.height(size);
					resizeVideo();	
				}});
			}else{
				size = _getComponentSize('w')-playlistHitArea;
				thumbHolder.stop().animate({ 'right': -thumbHolderSize+playlistHitArea+'px'},  {duration: time, easing: 'easeOutQuart', complete: function(){
					mediaWrapper.width(size);
					resizeVideo();	
				}});
			}
		} else{
			_playlistOpened=true;
			
			var url = _thumbOrientation == 'horizontal' ? ic_thumb_next_v : ic_thumb_next;
			playlist_toggle.css('backgroundImage', 'url('+url+')');
			
			if(_thumbOrientation=='horizontal'){
				size = _getComponentSize('h')-thumbHolderSize;
				thumbHolder.stop().animate({ 'bottom': 0+'px'},  {duration: time, easing: 'easeOutQuart', complete: function(){
					mediaWrapper.height(size);
					resizeVideo();	
				}});
			}else{
				size = _getComponentSize('w')-thumbHolderSize;
				thumbHolder.stop().animate({ 'right': 0+'px'},  {duration: time, easing: 'easeOutQuart', complete: function(){
					mediaWrapper.width(size);
					resizeVideo();	
				}});
			}
		}
	}
	
	
	
	
	
	
	
	// ******************************** PUBLIC FUNCTIONS **************** //
	
	$.videoGallery.getSingleVideo = function() {
		if(!_componentInited) return;
		return singleVideo;
	}
	
	$.videoGallery.getLooping = function() {
		if(!_componentInited) return;
		return loopingOn;
	}
	
	$.videoGallery.getAutoplay = function() {
		if(!_componentInited) return;
		return initialAutoplay;
	}
	
	$.videoGallery.getOnPlaylistEndGoToUrl = function() {
		if(!_componentInited) return;
		return onPlaylistEndGoToUrl;
	}
	
	$.videoGallery.togglePlayback = function(state) {
		if(!_componentInited) return;
		if(state == undefined){
			togglePlayback();
		}else{
			togglePlayback2(state);
		}
	}
	
	$.videoGallery.togglePlaylist = function() {
		if(!_componentInited) return;
		if(!thumbHolder) return;
		_togglePlaylist();
	}
	
	$.videoGallery.switchLayout = function() {
		if(!_componentInited || _playlistTransitionOn) return;
		if(!thumbHolder) return;
		_switchLayout();
	}
	
	$.videoGallery.nextMedia = function() {
		if(!_componentInited) return;
		nextMedia();
	}
	
	$.videoGallery.previousMedia = function() {
		if(!_componentInited) return;
		previousMedia();
	}
	
	$.videoGallery.destroyMedia = function() {
		if(!_componentInited) return;
		destroyMedia();
	}
	
	$.videoGallery.setVolume = function(vol) {
		if(!_componentInited) return;
		if(!videoInited) return;
		if(vol<0) vol=0;
		else if(vol>1) vol=1;
		defaultVolume = vol;
		setVolume();
	}
	
	$.videoGallery.loadMedia = function(value) {
		if(!_componentInited || _playlistTransitionOn) return;
		if(useDeeplink){
			if(typeof(value) === 'string'){
				$.address.value(value);
			}else{
				alert('Invalid value loadMedia Deeplink!');
				return false;	
			}
		}else{
			if(typeof(value) === 'number'){
				if(value<0)value=0;
				else if(value>playlistLength-1)value=playlistLength-1;
				_enableActiveItem();
				_playlistManager.processPlaylistRequest(value);
			}else if(typeof(value) === 'string'){
				_activePlaylist=value;
				_cleanPlaylist();
				_setPlaylist();			
			}else{
				alert('Invalid value loadMedia no Deeplink!');
				return false;	
			}
		}
	}
	
	}
	
})(jQuery);

