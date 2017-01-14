		<?php $portfolio_header_image = get_post_meta($post->ID, 'portfolio_header_image', true); ?>
		<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php if(is_shop()){?>
				<?php $shop_id = woocommerce_get_page_id('shop');?>
				<?php $page_header_image = get_post_meta($shop_id, 'page_header_image', true); ?>
			<?php }else{?>
				<?php $page_header_image = get_post_meta($post->ID, 'page_header_image', true); ?>
			<?php }?>
		<?php }else{?>
			<?php $page_header_image = get_post_meta($post->ID, 'page_header_image', true); ?>
		<?php }?>
		<?php $post_header_image = get_post_meta($post->ID, 'post_header_image', true); ?>
		<?php $front_callout_checkbox = get_post_meta($post->ID, 'front_callout_checkbox', true); ?>
		<?php $front_widget_checkbox = get_post_meta($post->ID, 'front_widget_checkbox', true); ?>
		<?php $front_widget_title = get_post_meta($post->ID, 'front_widget_title', true); ?>
		<?php $front_widget_content = get_post_meta($post->ID, 'front_widget_content', true); ?>
		<?php $front_widget_navigation = get_post_meta($post->ID, 'front_widget_navigation', true); ?>
		<?php $front_widget_type = get_post_meta($post->ID, 'front_widget_type', true); ?>
		<?php $front_widget_style = get_post_meta($post->ID, 'front_widget_style', true); ?>
		<?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>
		
		<?php $page_front_slider_select = get_post_meta($post->ID, 'page_front_slider_select', true); ?>
		<?php $page_front_slider_duration = get_post_meta($post->ID, 'page_front_slider_duration', true); ?>
		<?php $page_front_slider_transition = get_post_meta($post->ID, 'page_front_slider_transition', true); ?>
		
		<?php $page_front_youtube_video = get_post_meta($post->ID, 'page_front_youtube_video', true); ?>
		<?php $page_front_youtube_autoplay = get_post_meta($post->ID, 'page_front_youtube_autoplay', true); ?>
		<?php $page_front_youtube_seekbar = get_post_meta($post->ID, 'page_front_youtube_seekbar', true); ?>
		<?php $page_front_youtube_control = get_post_meta($post->ID, 'page_front_youtube_control', true); ?>
		
		<?php if($front_options_select=="style1"){?>
			<?php $front_style1_select = get_post_meta($post->ID, 'front_style1_select', true); ?>
		<?php }?>
		
		<?php $portfolio_header_image_bg = wp_get_attachment_image_src( $portfolio_header_image, 'page-header' );?>
		<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'front-page-header' );?>
		<?php }else{?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'page-header' );?>
		<?php }?>
		<?php $post_header_image_bg = wp_get_attachment_image_src( $post_header_image, 'page-header' );?>
		
		<?php #remove it if($blog_header_image){ $blog_header_image = get_attachment_id_from_src($blog_header_image); }?>
		<?php #remove it $blog_header_image_bg = wp_get_attachment_image_src( $blog_header_image, 'page-header' );?>
		
				
				<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
				
					<?php get_template_part('includes/front_slider' ) ?>
				
					<?php if ($front_style1_select=="youtube") { ?>
					
						<?php if ($page_front_youtube_video) { ?>
						
							<script type="text/javascript">
				
					function videoGallerySetupDone(){
						/* This will get called when component is ready to receive public function calls. */
						//console.log('videoGallerySetupDone');
					}
				
					// FLASH EMBED PART
					var flashvars = {},params = {},attributes = {};
					params.quality = "high";
					params.scale = "noscale";
					params.salign = "tl";
					params.wmode = "transparent";
					params.bgcolor = "#111111";
					params.devicefont = "false";
					params.allowfullscreen = "true";
					params.allowscriptaccess = "always";
					attributes.id = "flashPreview";
					swfobject.embedSWF("preview.swf", "flashPreview", "100%", "100%", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
					
					//functions called from flash
					var jsReady = false;//for flash/js communication
					function flashVideoEnd() {jQuery.videoGallery.flashVideoEnd();}
					function flashVideoStart() {jQuery.videoGallery.flashVideoStart();}
					function togglePlayBtn(on) {jQuery.videoGallery.togglePlayBtn(on);}
					function visitUrl() {jQuery.videoGallery.visitUrl();}
					function dataUpdateFlash(bl,bt,t,d) {jQuery.videoGallery.dataUpdateFlash(bl,bt,t,d);}
					function flashWaitingHandler() {jQuery.videoGallery.flashWaitingHandler();}
					function flashPlayingHandler() {jQuery.videoGallery.flashPlayingHandler();}
					function isReady() {return jsReady;}
					
					// SETTINGS
					var vg_settings = {
						/* componentFixedSize: true/false. Responsive = false, fixed = true */
						componentFixedSize: false,
						/*defaultVolume: 0-1 */
						defaultVolume:0.5,
						/*autoPlay: true/false (default false on mobile) */
						autoPlay:<?php if ($page_front_youtube_autoplay) { ?>true<?php }else{?>false<?php }?>,
						/*randomPlay: true/false */
						randomPlay:false,
						/* loopingOn: on playlist end rewind to beginning (last item in playlist) */
						loopingOn: true,
						/* defaultGallerySide: bottom / right (default thumbnail side)  */
						defaultGallerySide: 'right',
						/* scrollType: buttons / scroll  */
						scrollType: 'scroll',
						/* autoOpenPlaylist: true/false. Auto open playlist on beginning */
						autoOpenPlaylist: true,
						/* closePlaylistOnVideoSelect: close playlist on video select */
						closePlaylistOnVideoSelect: false,
						/* onPlaylistEndGoToUrl: true/false, navigate to url on playlist end (last item in playlist). Note: this will override loopingOn! */
						onPlaylistEndGoToUrl: false,
						/* onPlaylistEndUrl: url to redirect to */
						onPlaylistEndUrl: 'http://www.google.com/',
						/* onPlaylistEndTarget: _blank (open in new window) / _parent (open in same window) */
						onPlaylistEndTarget: '_parent',
						/*useCookieDetection; use detection with local storage/cookies of skipping intro if already visited (true/false). 'onPlaylistEndGoToUrl' must be 'true' for this to happen. */
						useCookieDetection: false,
						/* useKeyboardNavigation: true/false (left arrow=previous media, right arrow=next media, space=pause/play, m=mute/unmute) */
						useKeyboardNavigation: false,
						/* useYoutubeHighestQuality: true/false (use highest available quality for youtube video, if false, then it set to default)  */
						useYoutubeHighestQuality:false,
						
						/* DEEPLINKING SETTINGS */
						/* useDeeplink: true, false */
						useDeeplink:true,
						/* startUrl: deeplink start url, enter 'ul' data-address/'li' data-address (two levels). Or just 'ul' data-address (single level). */
						startUrl: 'playlist/youtube_single1',
						/* outputDeeplinkData: console.log out playlist deeplink data */
						outputDeeplinkData:false,
						
						/* NO DEEPLINKING SETTINGS */
						/*activePlaylist: enter element 'id' attributte */
						activePlaylist:'playlist'
					};
					
					var ic_play = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/play.png';
					var ic_play_on = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/play_on.png';
					
					var ic_pause = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/pause.png';
					var ic_pause_on = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/pause_on.png';
							
					var ic_mute = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/mute.png';
					var ic_mute_on = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/mute.png';
					
					var ic_volume = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/volume.png';
					var ic_volume_on = '<?php echo THEME_ASSETS; ?>video_bg/data/new_icons/volume.png';
					
					jQuery(document).ready(function($) {
						jsReady = true;
					    //init component
					    $.videoGallery('#componentWrapper', '#flashPreview', vg_settings);
					    vg_settings = null;
		    	    });
				
		        </script>
								
							<!-- wrapper for the whole component -->
							<div id="componentWrapper">
		             
		             <div class="mediaWrapper">
		    
		                 <!-- local video holder -->
		                 <div class="mediaHolder"></div>
		                 <!-- preview image holder -->
		                 <div class="previewHolder"></div>
		                 <!-- youtube holder -->
		                 <div class="youtubeHolder"></div>
		                 
		                <?php if (!$page_front_youtube_seekbar) { ?>
		                <!-- seekbar -->
		                 <div class="seekbar">
		                      <div class="seekbar_hit"></div>
		                      <div class="load_progress"></div>
		                      <div class="play_progress"></div>
		                 </div>
		                 <?php }?>
		                 
		                 <?php if (!$page_front_youtube_control) { ?>
		                 <div class="vg-navigation container">
			                 <div class="controls_vol_fs">
			                     <div class="controls_volume">
			                          <div class="volume_toggle"></div>
			                          <div class="volume_seekbar">
			                             <div class="volume_bg"></div>
			                             <div class="volume_level"></div>
			                          </div>
			                     </div>
			                 </div>
			                 <!-- controls -->
			                 <div class="controls">
			                      <div class="controls_toggle"></div>
			                 </div>
		                 </div>
		                 <?php }?>
		                 
		                 <!-- big play button for media -->
		             	 <div class="big_play"><img src='<?php echo THEME_ASSETS; ?>video_bg/data/new_icons//big_play.png' width='64' height='64' alt='big_play'/></div>
		                 
		                 <!-- media preloader -->
		             	 <div class="mediaPreloader"></div>
		             </div>
		             
		             <!-- playlist data (hidden) -->
		             <div class="componentPlaylist">
		                  <ul id='playlist' data-address="playlist">
		                     <li data-address="youtube_single1" class='playlistItem' data-type='youtube_single' data-path="<?php echo $page_front_youtube_video; ?>" data-aspectRatio='2' data-width="640" data-height="360" ></li>
		                  </ul>            
		             </div>
		              
		        </div>
							
								<!-- public function calls -->
							<div id='publicFunctions'>
		       		<p>PUBLIC METHODS</p><br/>
		            <ul>
		                <!-- toggle playback, (pass true (play), false (stop) as parameter, or none for simple toggle). -->
		                <li><a href='#' onClick="jQuery.videoGallery.togglePlayback(); return false;">toggle playback</a></li>
		                
		                <!-- toggle playlist -->
		                <li><a href='#' onClick="jQuery.videoGallery.togglePlaylist(); return false;">toggle playlist</a></li>
		                
		                <!-- switch layout -->
		                <li><a href='#' onClick="jQuery.videoGallery.switchLayout(); return false;">Switch layout</a></li>
		                
		                <!-- open next media -->
		                <li><a href='#' onClick="jQuery.videoGallery.nextMedia(); return false;">next media</a></li>
		                
		                <!-- open previous media -->
		                <li><a href='#' onClick="jQuery.videoGallery.previousMedia(); return false;">previous media</a></li>
		                
		                <!-- destroy media -->
		                <li><a href='#' onClick="jQuery.videoGallery.destroyMedia(); return false;">destroy media</a></li>
		                
		                <!-- set volume (0-1) -->
		                <li><a href='#' onClick="jQuery.videoGallery.setVolume(0.5); return false;">set volume (50%)</a></li>
		                
		            </ul>
		         </div>
						
						<?php }?>
					
					<?php }?>
				
				<?php }?>