			<?php $front_callout_checkbox = get_post_meta($post->ID, 'front_callout_checkbox', true); ?>
			<?php $front_widget_checkbox = get_post_meta($post->ID, 'front_widget_checkbox', true); ?>
			<?php $front_widget_title = get_post_meta($post->ID, 'front_widget_title', true); ?>
			<?php $front_widget_content = get_post_meta($post->ID, 'front_widget_content', true); ?>
			<?php $front_widget_navigation = get_post_meta($post->ID, 'front_widget_navigation', true); ?>
			<?php $front_widget_type = get_post_meta($post->ID, 'front_widget_type', true); ?>
			<?php $front_widget_style = get_post_meta($post->ID, 'front_widget_style', true); ?>
			<?php $front_options_select = get_post_meta($post->ID, 'front_options_select', true); ?>
			
			<?php $filter = get_post_meta($post->ID, 'page_front_slider_filter', true); ?>
			<?php $page_front_slider_select = get_post_meta($post->ID, 'page_front_slider_select', true); ?>
			<?php $page_front_slider_duration = get_post_meta($post->ID, 'page_front_slider_duration', true); ?>
			<?php $page_front_slider_transition = get_post_meta($post->ID, 'page_front_slider_transition', true); ?>
			<?php $page_front_slider_control = get_post_meta($post->ID, 'page_front_slider_control', true); ?>
			
			<?php if($front_options_select=="style1"){?>
				<?php $front_style1_select = get_post_meta($post->ID, 'front_style1_select', true); ?>
			<?php }?>
			
			<?php if ($front_style1_select=="front_slider") { ?>
			
			<script type="text/javascript">
			
				/* GALLERY CALLBACKS */
				function multiGallerySetupDone(){
					/* called when component is ready to receive public function calls */
					//console.log('multiGallerySetupDone');
				}
				function beforeSlideChange(slideNum){
					//function called before slide change (plus slide number returned, counting starts from 0)
					//console.log('beforeSlideChange, slideNum = ', slideNum);
				}
				function afterSlideChange(slideNum){
					//function called after slide change (plus slide number returned, counting starts from 0)
					//console.log('afterSlideChange, slideNum = ', slideNum);
				}
				/* END GALLERY CALLBACKS */
			
				/* VIDEO PLAYER SETTINGS FLASH */
				//flash embed part
				var flashvars = {};
				var params = {};
				var attributes = {};
				attributes.id = "flashPreview";
				params.quality = "high";
				params.scale = "noscale";
				params.salign = "tl";
				params.wmode = "transparent";
				params.bgcolor = "#111";
				params.devicefont = "false";
				params.allowfullscreen = "true";
				params.allowscriptaccess = "always";
				swfobject.embedSWF("preview.swf", "flashPreview", "100%", "100%", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
				
				//functions called from flash
				var jsReady = false;//for flash/js communication
				function flashVideoEnd() {jQuery.fn.videoGallery.flashVideoEnd();}
				function flashVideoStart() {jQuery.fn.videoGallery.flashVideoStart();}
				function dataUpdateFlash(bl,bt,t,d) {jQuery.fn.videoGallery.dataUpdateFlash(bl,bt,t,d);}
				function flashVideoPause() {jQuery.fn.videoGallery.flashVideoPause();}
				function flashVideoResume() {jQuery.fn.videoGallery.flashVideoResume();}
				function flashMainPreviewOff() {jQuery.fn.videoGallery.flashMainPreviewOff();}
				function flashResizeControls() {jQuery.fn.videoGallery.flashResizeControls();}
				function getSlideshowForcePause() {return jQuery.fn.multiGallery.getSlideshowForcePause();}
				function videoEnd() {jQuery.fn.multiGallery.videoEnd();}
				function isReady() {return jsReady;}
				/* END VIDEO PLAYER SETTINGS FLASH */
				
				/* AUDIO PLAYER SETTINGS */
				
				
				/* END AUDIO PLAYER SETTINGS */
				
				/* GALLERY SETTINGS */
				var kb_settings = {
					/* GENERAL */
					/* componentHolder: dom element which holds the whole component */
					componentHolder: '#componentWrapper',
					/* componentFixedSize: true/false. Responsive = false, fixed = true */
					componentFixedSize: false,
					/* disableRightClick: true/false  */
					disableRightClick: true,
					/* forceImageFitMode: true/false. By default, only images bigger than component size will get proportionally resized to 'fit inside' or 'fit outside' mode. If this is true, all images will be forced into that mode, even smaller ones. */
					forceImageFitMode: true,
					
					/* DEEPLINKING SETTINGS */
					/* useDeeplink: true/false */
					useDeeplink:true,
					/* startUrl: deeplink start url, enter 'div' data-address/'li' data-address (two levels). Or just 'div' data-address (single level). */
					startUrl: '<?php if($page_front_slider_select=='ken_burns'){?>front_slider_ken_burns<?php } elseif($page_front_slider_select=="alpha") {?>front_slider_alpha<?php } elseif($page_front_slider_select=="zoom") {?>front_slider_zoom<?php } elseif($page_front_slider_select=="slide") {?>front_slider_slide<?php } elseif($page_front_slider_select=="split") {?>front_slider_split<?php } elseif($page_front_slider_select=="reveal") {?>front_slider_reveal<?php }?>/image1',
					
					/* NO DEEPLINKING SETTINGS */
					/* activeCategory: active category to start with (counting starts from zero, 0=first category, 1=second category, 2=third category... etc) */
					activeCategory:0,
					
					/* SLIDESHOW */
					/* slideshowOn; true, false */
					slideshowOn: true,
					/* useGlobalDelay; true, false (use same timer delay for all slides, if false you need to set individual delays for every slide -> data-duration attribute) */
					useGlobalDelay: true,
					/* slideshowAdvancesToNextCategory: true/false. On the end/beginning of current category, go to next/previous one, instead of loop current one. */
					slideshowAdvancesToNextCategory: false,
					/* randomPlay; true, false (random image play in category) */
					randomPlay: false,
					
					/* DESCRIPTION */
					/* autoOpenDescription; true/false (automatically open description, if exist)  */
					autoOpenDescription: false,
					/* maxDescriptionWidth: max width of the description */
					maxDescriptionWidth: 250,
					
					/* PLAYLIST */
					/* autoAdjustPlaylist: true/false (auto adjust thumb playlist and playlist buttons) */
					autoAdjustPlaylist: true,
					/* playlistPosition: top, right, left, bottom  */
					playlistPosition: 'left',
					/* autoOpenPlaylist: true/false. Auto open playlist on beginning */
					autoOpenPlaylist: true,
					/* playlistHidden: true/false. (leave css display none on componentPlaylist) */
					playlistHidden: true,
					/* playlistIndex: inside/outside ('outside' opens above the image, while 'inside' sits outside of the image area and cannot be closed)  */
					playlistIndex: 'inside',
					
					/* MENU */
					/* menuOrientation: horizontal/vertical  */
					menuOrientation: 'vertical',
					/* menuItemOffOpacity: opacity of menu item when inactive */
					menuItemOffOpacity:0.4,
					/* menuBtnSpace: space between menu buttons and the menu (enter 0 or more) */
					menuBtnSpace: 30,
					/* visibleMenuItems: visible menu items by default. Enter number (if they dont fit into provided area, the code will automatically reduce this number) or 'max' (maximum number that fits). */
					visibleMenuItems: 'max',
					/* fixMenu: true/false. false by default (menu centered). Can be true ONLY if 'visibleMenuItems' != 'max'. 
					Set this to true to fix it to one side. */
					fixMenu: false,
					/* fixMenuSettings: (if fixMenu = true), param1: side: -> left/right if menuOrientation = horizontal, top/bottom if menuOrientation = vertical, 
															 param2: value -> offset value in px from that side */
					fixMenuSettings: {side: 'top',value: 100},
					
					/* THUMBNAILS */
					/* thumbOrientation: horizontal/vertical  */
					thumbOrientation: 'vertical',
					/* thumbOffOpacity: opacity of thumb when inactive */
					thumbOffOpacity:0.4,
					/* visibleThumbs: visible thumb items by default. Enter number (if they dont fit into provided area, the code will automatically reduce this number) or 'max' (maximum number that fits). */
					visibleThumbs: 'max',
					/* thumbBtnSpace:  space between thumb buttons and the thumbs (enter 0 or more) */
					thumbBtnSpace: 30,
					/* fixThumbs: true/false. false by default (thumbs centered). Can be true ONLY if 'visibleThumbs' != 'max'. 
					Set this to true to fix it to one side. */
					fixThumbs: false,
					/* fixThumbsSettings:  (if fixThumbs = true), param1: side -> left/right if thumbOrientation = horizontal, top/bottom if thumbOrientation = vertical,
																  param2: value -> offset value in px from that side */
					fixThumbsSettings: {side: 'top',value: 100},
					
					/* VIDEO SETTINGS */
					/* useVideo: true/false */
					useVideo: true,
					/* videoVolume: default volume for video (0-1) */
					videoVolume: 0.5,
					/* videoAutoPlay: true/false (Defaults to false on mobile) */
					videoAutoPlay: false,
					/* includeVideoInSlideshow: true/false (on video end resume slideshow, only if slideshow was playing before video request) */
					includeVideoInSlideshow: false,
					/* videoLoop: true/false (only if includeVideoInSlideshow = false) */
					videoLoop: false,
					/*playerBgOpacity: background opacity behind the video player when its opened (0-1) */
					playerBgOpacity:0.8,
					/*playerHolder: dom elements which holds the whole player */
					playerHolder:'#componentWrapper .videoPlayer',
					/*flashHolder: id of the flash movie */
					flashHolder:'#flashPreview',
					
					/* AUDIO SETTINGS */
					/* useAudio: true/false */
					useAudio: false
				};
				
				/* END GALLERY SETTINGS */
				
				//gallery instances
				var gallery1;  
				
				jQuery(document).ready(function($) {
					jsReady = true;
					gallery1 = $('#componentWrapper').multiGallery(kb_settings);
					kb_settings = null;
				});
			
				//icons
				var ic_pause = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/pause.png';
				var ic_pause_on = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/pause_on.png';
				
				var ic_prev = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/prev.png';
				var ic_prev_on = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/prev_on.png';
				
				var ic_play = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/play.png';
				var ic_play_on = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/play_on.png';
				
				var ic_next = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/next.png';
				var ic_next_on = '<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/next_on.png';
	
	        </script>
	        
	        
	      
	         <!-- wrapper for the whole component -->
	         <div id="componentWrapper" class="front_slider">
	         
	          	  <div class="componentHolder">
	         
	                  <div class="mediaHolder1"></div>
	                  <div class="mediaHolder2"></div>
	                      
	                  <!-- playlist -->
	                  <div class="componentPlaylist">
	                      
	                     <div class="menuHolder">
	                         <div class="menuWrapper">
	                         </div>
	                     </div>
	                     
	                     <div class="thumbHolder">
	                         <div class="thumbWrapper">
	                         
									<?php if($page_front_slider_select=='ken_burns'){?>
									<div class="playlist" data-address='front_slider_ken_burns' data-title='front_slider' data-transitionType='ken_burns' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>' data-duration="<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>25000<?php }?>">
									<?php } elseif($page_front_slider_select=="alpha") {?>
									<div class="playlist" data-address='front_slider_alpha' data-title='front_slider' data-transitionType='alpha' data-imageFitMode='fit-outside' data-duration='<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>4000<?php }?>' data-transitionTime='<?php if($page_front_slider_transition){?><?php echo $page_front_slider_transition;?><?php } else{?>1000<?php }?>' data-transitionEase='easeOutSine' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>'>
									<?php } elseif($page_front_slider_select=="zoom") {?>
									<div class="playlist" data-address='front_slider_zoom' data-title='front_slider' data-transitionType='zoom' data-imageFitMode='fit-outside' data-duration='<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>4000<?php }?>' data-transitionTime='<?php if($page_front_slider_transition){?><?php echo $page_front_slider_transition;?><?php } else{?>1000<?php }?>' data-transitionEase='easeOutSine' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>'>
									<?php } elseif($page_front_slider_select=="slide") {?>
									<div class="playlist" data-address='front_slider_slide' data-title='front_slider' data-transitionType='slide' data-imageFitMode='fit-outside' data-duration='<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>4000<?php }?>' data-transitionTime='<?php if($page_front_slider_transition){?><?php echo $page_front_slider_transition;?><?php } else{?>1000<?php }?>' data-transitionEase='easeInOutExpo' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>'>
									<?php } elseif($page_front_slider_select=="split") {?>
									<div class="playlist" data-address='front_slider_split' data-title='front_slider' data-transitionType='split' data-imageFitMode='fit-outside' data-duration='<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>4000<?php }?>' data-transitionTime='<?php if($page_front_slider_transition){?><?php echo $page_front_slider_transition;?><?php } else{?>1000<?php }?>' data-transitionEase='easeInOutExpo' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>'>
									<?php } elseif($page_front_slider_select=="reveal") {?>
									<div class="playlist" data-address='front_slider_reveal' data-title='front_slider' data-transitionType='reveal' data-imageFitMode='fit-outside' data-duration='<?php if($page_front_slider_duration){?><?php echo $page_front_slider_duration;?><?php } else{?>4000<?php }?>' data-transitionTime='<?php if($page_front_slider_transition){?><?php echo $page_front_slider_transition;?><?php } else{?>1000<?php }?>' data-transitionEase='easeInOutExpo' data-bgColor='<?php if($page_gradient_bg_color_1){echo $page_gradient_bg_color_1;}else{ echo "#ebebeb";};?>'>
									<?php }?>
									
	                                   <ul> 
	                                   
										<?php $query = new WP_Query();?>
										<?php $i = 1;?>
										<?php if($filter){?>
										    <?php $query->query('post_type=front_slider&front_slider_category='. $filter .'&posts_per_page=-1');?>
										<?php }else{?>
										    <?php $query->query('post_type=front_slider&posts_per_page=-1');?>
										<?php }?>
										<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
										
										<?php $count = $i++;?>
										
										<?php $front_slider_options_video = get_post_meta($post->ID, 'front_slider_options_video', true); ?>
										<?php $front_slider_options_video_id = get_post_meta($post->ID, 'front_slider_options_video_id', true); ?>
	                                   
	                                      <li data-address='image<?php echo $count;?>' class='playlistItem' data-caption-id="#caption_<?php echo $count;?>" data-imagePath='<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'front-page-header' ); echo $image[0];?>' data-startScale="1.4" data-endScale="0.5" data-startPosition="tl" data-endPosition="br" 
										<?php if($front_slider_options_video=="youtube") {?>
											<?php echo $video = "data-youtube='". $front_slider_options_video_id."'";?>
										<?php } elseif($front_slider_options_video=="vimeo") {?>
											<?php echo $video = "data-vimeo='".$front_slider_options_video_id."'";?>
										<?php }?>
	                                      ></li>
	                                      
										<?php endwhile; endif; ?> 
	
	                                  </ul> 
	                             </div>

	                        </div>
	                     </div>  
	                     
	                     <div class="caption_holder">
	                     
                        <?php $i = 1;?>
                        <?php if($filter){?>
                            <?php $query->query('post_type=front_slider&front_slider_category='. $filter .'&posts_per_page=-1');?>
                        <?php }else{?>
                            <?php $query->query('post_type=front_slider&posts_per_page=-1');?>
                        <?php }?>
                        <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
                        
                        <?php $front_slider_options_select = get_post_meta($post->ID, 'front_slider_options_select', true); ?>
                        
	                    <?php $count = $i++;?>
	                    
	                    <?php if (get_the_content()||get_the_title()){?>
	                       
	                       <div id="caption_<?php echo $count;?>" class="caption container">
	                            <div class="captionItem" data-startX="100" data-startY="-100" data-endX="400" data-endY="240" data-time="300" data-ease="easeOutBack" data-delay="0">
	                            	<?php if($front_slider_options_select){?>
	                            		<?php $headeing = $front_slider_options_select;?>
	                            	<?php }else{?>
	                            		<?php $headeing = "h1";?>
	                            	<?php }?>
	                            	<<?php echo $headeing;?>><?php the_title(); ?></<?php echo $headeing;?>>
		                            <?php the_content(); ?>
	                            </div>
	                       </div>
	                       
	                    <?php }?>
	                       
	                     <?php endwhile; endif; wp_reset_query();?> 
	               
	                  </div>         
	                     
	                     <!-- menu buttons -->
	                     <div class="prevMenuBtn"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/gallery_icons/playlist_prev_v.png' width='18' height='12' alt=''/></div>   
	                     <div class="nextMenuBtn"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/gallery_icons/playlist_next_v.png' width='18' height='12' alt=''/></div> 
	                     
	                     <!-- thumb buttons -->
	                     <div class="prevThumbBtn"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/gallery_icons/playlist_prev_v.png' width='18' height='12' alt=''/></div>   
	                     <div class="nextThumbBtn"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/gallery_icons/playlist_next_v.png' width='18' height='12' alt=''/></div>  
	                     
	                     <!-- playlist toggle -->
	                     <div class="playlist_toggle"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/gallery_icons/plus.png' width='30' height='30' alt='playlist_toggle'/></div>
	                  
	                  </div>
	                  
	              </div> 
				    
	              <!-- slideshow controls - previous,pause/play,next -->
	              <div class="slideshow_controls container">
	              <?php if(!$page_front_slider_control){?>
	              	  <div class="controls_next"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/next.png' width='24' height='24' alt='controls_next'/></div>
	                  <div class="controls_toggle"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/play.png' width='30' height='24' alt='controls_toggle'/></div>
	                  <div class="controls_prev"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_gallery_icons/prev.png' width='24' height='24' alt='controls_prev'/></div>
	              <?php }?>
	              </div>
	              
	              <!-- preloader for images -->
	              <div class="componentPreloader"></div>  
	               
	              <!-- big play for video player toggle -->
	              <div class="player_bigPlay"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/new_video_icons/big_play.png' width='64' height='64' alt=''/></div>
	              
	              <!-- darken area behind the video player -->
	              <div class="player_bg"></div>
	              
	              <!-- video player -->
	              <div class="videoPlayer">
             
             	 <!-- media holders for youtube and vimeo -->
                 <div class="youtubeWrapper"><div class="youtubeHolder"></div></div>
                 <div class="vimeoHolder"></div>
                 
                 <!-- preloader for local video -->
                 <div class="mediaPreloader"></div>
                 
                 <!-- big play for local video toggle -->
                 <div class="bigPlay"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/video_icons/big_play.png' width='76' height='76' alt=''/></div>
                 
                 <!-- video player close -->
                 <div class="player_close"><img src='<?php echo THEME_ASSETS; ?>mt_gallery/media/data/video_icons/close.png' width='30' height='30' alt='player_close'/></div>
                 
             </div>
	             
	        </div> 
	      
	   		<!-- public API -->
	    	<div id='publicFunctions'>
	       		<p>PUBLIC API</p><br/>
	            <ul>
	                 <!-- toggle slideshow, (pass true (play), false (stop) as parameter, or none for simple toggle). -->
	                <li><a href='#' onClick="gallery1.toggleSlideshow(); return false;">toggle slideshow</a></li>
	                
	                <!-- toggle playlist (open /close) -->
	                <li><a href='#' onClick="gallery1.togglePlaylist(); return false;">toggle playlist</a></li>
	                
	                <!-- open next media -->
	                <li><a href='#' onClick="gallery1.nextItem(); return false;">next media</a></li>
	                
	                <!-- open previous media -->
	                <li><a href='#' onClick="gallery1.previousItem(); return false;">previous media</a></li>
	                
	                <!-- Open media, pass number (counting starts from 0), or data-address as string (for deeplink). -->
	                <li><a href='#' onClick="gallery1.loadItem(2); return false;">Open media number 2</a></li>
	                <li><a href='#' onClick="gallery1.loadItem('image5'); return false;">Open media 'image5'</a></li>
	                
	                <!-- Open new category, pass number (counting starts from 0), or data-address as string (for deeplink).
	                This will open first image in category. -->
	                <li><a href='#' onClick="gallery1.loadCategory(2); return false;">Open category number 2</a></li>
	                <li><a href='#' onClick="gallery1.loadCategory('wellness_reveal'); return false;">Open category name 'wellness_reveal'</a></li>
	                
	            </ul>
	         </div>
	
	         
	         <?php }?>