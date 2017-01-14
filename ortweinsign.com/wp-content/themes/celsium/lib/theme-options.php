<?php
// admin_menu hook
function afl_theme_options_hook() {
    if ( ! current_user_can('edit_theme_options') )
        return;
    $page = 'theme-options';
    if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme-options' && $_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['save_changes'])){
            check_admin_referer('theme-option');
        global $__OPTIONS;
        $option_keys = array_keys( $__OPTIONS );
        $changes = array();
        foreach($_POST as $k => $v){
            if(in_array($k, $option_keys)){
                $v = trim(stripslashes($v));
                update_option($k, $v);
                $changes[$k] = $v;
            }
        }
        //for each checkboxes
        foreach(array('default_comment_status','afl_readmore_enable') as $k){
            if(in_array($k, $option_keys)){
                if(isset($_POST[$k])&&$_POST[$k]=='open'){
                    $v = 'open';
                }
                else{
                    $v = 'closed';
                }
                update_option($k, $v);
                $changes[$k] = $v;
            }
        }
        if(isset($_POST['afl_social_url'])){
            $socials = array();
            foreach($_POST['afl_social_url'] as $k => $v){
                if( strlen($v)>0 && strlen($_POST['afl_social_image'][$k])>0 ){
                    $socials[] = array('url' => trim(stripslashes($v)), 'title'=> trim(stripslashes($_POST['afl_social_title'][$k])),'image' => trim(stripslashes($_POST['afl_social_image'][$k])));
                }
            }
            $changes['afl_social'] = json_encode($socials);
            update_option('afl_social', $changes['afl_social']);
        }
        if(isset($_POST['afl_font_selector'])){
            $fonts = array();
            foreach($_POST['afl_font_selector'] as $k => $v){
                $sel = trim(stripslashes($v));
                $font = trim(stripslashes($_POST['afl_font_name'][$k]));
                $color = trim(stripslashes($_POST['afl_font_color'][$k]));
                if(strlen($sel)>0 && strlen($font)>0){
                    $fonts[] = array('selector'=>$sel, 'font'=>$font, 'color'=>$color);
                }
            }
            $changes['afl_font'] = serialize($fonts);
            update_option('afl_font', $changes['afl_font']);
        }
		if(isset($_POST['afl_counter_code'])){
			update_option('afl_counter_code', trim(stripslashes($_POST['afl_counter_code'])));
		}
		if(isset($_POST['afl_footer_copyright'])){
			update_option('afl_footer_copyright', trim(stripslashes($_POST['afl_footer_copyright'])));
		}
		if(isset($_POST['afl_footer_cols'])){
			update_option('afl_footer', $_POST['afl_footer_cols']);
		}
        afl_refresh_options($changes);
        }
    }

	$my_theme = wp_get_theme();

	add_menu_page('Theme settings', $my_theme->Name , 'manage_options', $page, 'afl_theme_options_view','',58);
	add_submenu_page($page,'Theme Options','Theme Options','manage_options',$page,'afl_theme_options_view');
}
add_action('admin_menu', 'afl_theme_options_hook');

function afl_theme_options_load_hook() {
    wp_enqueue_script('afl-theme-options', TEMPLATEURL.'/lib/js/theme-options.js', array( 'jquery', 'jqueryUI' ));

    $fonts = array();
    foreach(afl_get_google_font_list() as $font){
        $fonts[] = str_replace(' ', '+', trim($font));
    }
    if (!empty($fonts)){
        wp_enqueue_style('afl-google-fonts-all', 'http://fonts.googleapis.com/css?family='.  implode('|', $fonts));
    }
}
add_action("admin_enqueue_scripts", 'afl_theme_options_load_hook');

function afl_theme_options_view() {
    global $__OPTIONS;
    global $domain_key;
	$my_theme = wp_get_theme();?>

	<form enctype="multipart/form-data" method="POST" id="afl-form-options" action="">
		<div class="afl-options-page afl-sidebar-active">
			<div class="afl-options-page-sidebar">
            	<div class="afl-options-header"></div>
                <div class="afl-sidebar-content">
					<div class="afl-section-header afl-active-nav" id="tab-general" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/hammer_screwdriver.png);">Theme Options </strong></div>
                    <div class="afl-section-header" id="tab-social" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/palette.png);">Social Networks </strong></div>
                    <div class="afl-section-header" id="tab-fonts" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/blueprint_horizontal.png);">Font Replace </strong></div>
                    <div class="afl-section-header" id="tab-footer" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/layout_select_footer.png);">Footer </strong></div>
                    <div class="afl-section-header" id="tab-dummy" style="display: block;"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/photo_album.png);">Dummy Import </strong></div>
                </div>
			</div>
            <div class="afl-options-page-content">
                <div class="afl-options-header">
                    <h2 class="afl-logo"><?php echo $my_theme->Name; ?> Theme Options</h2>
                    <span class="afl-loading"></span>
                    <span class="afl-style-wrap">
						<a class="afl-button afl-submit" href="#">Save all changes</a>
                    </span>
                </div>
                <div class="afl-options-container">
					<div id="afl-tab-general" class="afl-subpage-container afl-active-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/hammer_screwdriver.png);">Theme Options </strong></div>
						<?php foreach($__OPTIONS as $k => $v): ?>
						<?php if( $v['type'] == 'social' || $v['type'] == 'font' || $v['type'] == 'footer' ) continue; ?>
						<div id="<?php echo $k ?>" class="afl-section <?php echo $v['attributes']['class'] ?>">
							<h4><?php echo $v['label'] ?></h4>
							<div class="afl-control-container">
								<div class="afl-description"><?php echo $v['description'] ?></div>
								<div class="afl-control">
								<?php if($v['uploadable']) {
									echo '<div class="afl-upload-container afl-upload-container_'.$k.'">
											<span class="afl-style-wrap afl-upload-style-wrap">'.afl_render_theme_option($k, $v).'</span>
											<div id="'.$k.'-div" class="afl-preview-pic"></div>
										</div>';
								} else { ?>
									<div class="afl-style-wrap"><?php print afl_render_theme_option($k, $v); ?></div>
								<?php } ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
                    </div>
                    <div id="afl-tab-social" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/palette.png);">Theme Options </strong></div>
						<?php
						$next_value = 0;
						$socials = (false===($socials = unserialize($__OPTIONS['afl_social']['default_value']))?json_decode($__OPTIONS['afl_social']['default_value'], true):$socials);
							if(is_array($socials)){
								foreach($socials as $social){
									?>
									<div class="afl-single-set">
										<div class="afl-section afl-text afl-3columns afl-col-1">
											<h4>Social url</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_social_url_{$next_value}", array('type' => 'text', 'default_value' => $social['url'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_url[{$next_value}]"))); ?>
													</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-2">
											<h4>Social title</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_social_title_{$next_value}", array('type' => 'text', 'default_value' => $social['title'], 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_title[{$next_value}]"))); ?>
													</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-3">
											<h4>Social image</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
													<span class="afl-style-wrap">
													<?php print afl_render_theme_option("afl_social_image_{$next_value}", array('type' => 'text', 'default_value' => $social['image'], 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_image[{$next_value}]"))); ?>
													</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<a class="afl-social-delete afl-remove-set" href="#">Delete</a>
									</div>
									<?php
									$next_value++;
								}
							}
						?>
									<div class="afl-single-set">
										<div class="afl-section afl-text afl-3columns afl-col-1">
											<h4>Social url</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
																<span class="afl-style-wrap">
																<?php print afl_render_theme_option("afl_social_url_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_url[{$next_value}]"))); ?>
																</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-2">
											<h4>Social title</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
																<span class="afl-style-wrap">
																<?php print afl_render_theme_option("afl_social_title_{$next_value}", array('type' => 'text', 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_title[{$next_value}]"))); ?>
																</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
										<div class="afl-section afl-text afl-3columns afl-col-3">
											<h4>Social image</h4>
											<div class="afl-control-container">
												<div class="afl-description"></div>
												<div class="afl-control">
																<span class="afl-style-wrap">
																<?php print afl_render_theme_option("afl_social_image_{$next_value}", array('type' => 'text', 'uploadable' => true, 'attributes' => array('class' => 'regular-text', 'name' => "afl_social_image[{$next_value}]"))); ?>
																</span>
												</div>
												<div class="afl-clear"></div>
											</div>
										</div>
                                        <a class="afl-social-add afl-clone-set" href="#">Add another Form Element</a>
									</div>
                    </div>
                    <div id="afl-tab-fonts" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/hammer_screwdriver.png);">Font Replace </strong></div>
						<?php
						//prepare select options
						$fonts = afl_get_google_font_list();
						$options = array();
						$tooltip = 'Meta tags'.implode(', ', array_keys(afl_get_meta_tag_list()));
						$options[""] = "--Select font--";
						foreach($fonts as $font){
							$options[str_replace(' ', '+', trim($font))] = $font;
						}

						?>
						<?php
						$next_value = 0;
						if(is_array($fonts = unserialize($__OPTIONS['afl_font']['default_value']))){
							foreach($fonts as $font){
								?>
								<div class="afl-single-set">
									<div class="afl-section afl-text afl-3columns afl-col-1">
										<h4>Tag name(Selector)</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap">
												<?php print afl_render_theme_option("afl_font_selector_{$next_value}", array('type' => 'text', 'default_value' => $font['selector'], 'attributes' => array('title' => $tooltip, 'class' => 'regular-text', 'name' => "afl_font_selector[{$next_value}]"))); ?>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
									<div class="afl-section afl-text afl-3columns afl-col-2">
										<h4>Color</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap afl-colorpicker-style-wrap">
													<?php print afl_render_theme_option("afl_font_color_{$next_value}", array('type' => 'text', 'default_value' => (!empty($font['color'])?$font['color']:'#'), 'attributes' => array('name' => "afl_font_color[{$next_value}]", 'class' => "afl-color-picker"))); ?>
													<span class="afl_color_picker_div" style="background-color: <?php echo (!empty($font['color'])?$font['color']:'#000000') ?>;"></span>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
									<div class="afl-section afl-text afl-3columns afl-col-3">
										<h4>Font</h4>
										<div class="afl-control-container">
											<div class="afl-description"></div>
											<div class="afl-control">
												<span class="afl-style-wrap afl-select-style-wrap">
													<span class="afl-select-unify">
													<?php print afl_render_theme_option("afl_font_name_{$next_value}", array('type' => 'select', 'default_value' => $font['font'], 'options' => $options,'attributes' => array('class' => 'regular-text', 'name' => "afl_font_name[{$next_value}]"))); ?>
														<span class="afl-select-fake-val" <?php echo (!empty($font['color'])? 'style="color:'.$font['color'].';"':'') ?>></span>
													</span>
												</span>
											</div>
											<div class="afl-clear"></div>
										</div>
									</div>
                                    <a class="afl-font-delete afl-remove-set" href="#">Delete</a>
								</div>
								<?php
								$next_value++;
							}
						}
						?>
                        <div class="afl-single-set">
                            <div class="afl-section afl-text afl-3columns afl-col-1">
                                <h4>Tag name(Selector)</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap">
										<?php print afl_render_theme_option("afl_font_selector_{$next_value}", array('type' => 'text', 'attributes' => array('title' => $tooltip, 'class' => 'regular-text', 'name' => "afl_font_selector[{$next_value}]"))); ?>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-2">
                                <h4>Color</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap afl-colorpicker-style-wrap">
											<?php print afl_render_theme_option("afl_font_color_{$next_value}", array('type' => 'text', 'default_value' => '#000000', 'attributes' => array('name' => "afl_font_color[{$next_value}]", 'class' => "afl-color-picker"))); ?>
											<span class="afl_color_picker_div" style="background-color: #000000;"></span>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <div class="afl-section afl-text afl-3columns afl-col-3">
                                <h4>Font</h4>
                                <div class="afl-control-container">
                                    <div class="afl-description"></div>
                                    <div class="afl-control">
										<span class="afl-style-wrap afl-select-style-wrap">
											<span class="afl-select-unify">
											<?php print afl_render_theme_option("afl_font_name_{$next_value}", array('type' => 'select', 'options' => $options,'attributes' => array('class' => 'regular-text', 'name' => "afl_font_name[{$next_value}]"))); ?>
                                            <span class="afl-select-fake-val"></span>
											</span>
										</span>
                                    </div>
                                    <div class="afl-clear"></div>
                                </div>
                            </div>
                            <a class="afl-font-add afl-clone-set" href="#">Add another Form Element</a>
                        </div>
                    </div>
                    <div id="afl-tab-dummy" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/hammer_screwdriver.png);">Import Dummy Content </strong></div>
                        <div id="afl-import" class="afl-section afl-import">
                            <div id="dummy" style="text-align: right; width:8px; height:5px; cursor:pointer; float:right;"><img src="<?php echo TEMPLATEURL; ?>/images/link-marker.gif" alt="Export Dummy"/></div>
                            <script type="text/javascript">
                                function perform_import(container, url, loading_text){
                                    jQuery(container).click(function(){
                                        jQuery(".afl-import-wait").css({'display':'block'}).html(loading_text);
                                        jQuery('#import_result').load(url, function(response, status, xhr){
                                            if (status == "error") {
                                                var msg = "Sorry but there was an error: ";
                                                jQuery(".afl-import-wait").html(msg + xhr.status + " " + xhr.statusText);
                                            } else {
                                                jQuery(".afl-import-wait").html('Success!');
                                            }
                                        });
                                    });
                                }

                                jQuery.ajaxSetup({
                                    cache:false,
                                    beforeSend: function() {
                                        jQuery('.afl-import-loading').css({'visibility':'visible'});
                                    },
                                    success: function() {
                                        jQuery('.afl-import-loading').css({'visibility':'hidden'});
                                    }
                                });
                                var ajax_load = 'Please wait for Export Complete message!<br/>It might take a couple of minutes.';
                                var loadUrl = "<?php echo TEMPLATEURL."/lib/ajax.php"; ?>";
                                perform_import("#dummy", loadUrl, ajax_load);
                            </script>
                            <h4>Import Dummy Content: Posts, Pages, Categories</h4>
                            <div class="afl-control-container">
                                <div class="afl-description">Dummy Import provides you with pre-created content so you could see the abilities of this template. If you need such a help, go ahead and push the Button.<br/>Note: Dummy Import overwrites your settings(if there is any).</div>
								<span class="afl-style-wrap">
									<span class="afl-button afl-import-button" id="dummy_import">Import dummy data</span>
								</span>
                                <span class="afl-loading afl-import-loading"><img src="<?php echo TEMPLATEURL."/lib/css/images/file-preloader.gif"; ?>" alt="Loading..."/></span>
								<span id="import_result" style="display:none;"></span>
                                <div class="afl-import-wait">
                                    <strong>Import started.</strong>
                                    <br>
                                    Please wait a few seconds and don't reload the page. You will be notified as soon as the import has finished! :)
                                </div>
                                <div class="afl-import-result"></div>
                                <script type="text/javascript">
                                    var ajax_import = 'Please wait for Import Complete message!<br/>It might take a couple of minutes.';
                                    var OutUrl = "<?php echo TEMPLATEURL."/inc/import.php"; ?>";
                                    perform_import("#dummy_import", OutUrl, ajax_import);
                                </script>
							</div>
                            <div class="afl-clear"></div>
						</div>
                    </div>
                    <div id="afl-tab-footer" class="afl-subpage-container">
                        <div class="afl-section-header"><strong class="afl-page-title" style="background-Image:url(<?php echo TEMPLATEURL; ?>/lib/css/images/icons/hammer_screwdriver.png);">Footer </strong></div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_footer']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_footer']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap afl-select-style-wrap">
										<span class="afl-select-unify">
										<?php print afl_render_theme_option("afl_footer_cols", array('type' => 'select', 'options' => array(1,2,3,4), 'default_value' => get_option('afl_footer'),'attributes' => array('class' => 'regular-text', 'name' => "afl_footer_cols"))); ?>
                                            <span class="afl-select-fake-val"><?php $num_cols = get_option('afl_footer') + 1; echo "{$num_cols}";?></span>
										</span>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_footer_copyright']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_footer_copyright']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_footer_copyright", array('type' => 'textarea', 'default_value' => get_option('afl_footer_copyright'),'attributes' => array('class' => 'regular-text', 'name' => "afl_footer_copyright"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
                        <div class="afl-section afl-text">
                            <h4><?php echo $__OPTIONS['afl_counter_code']['label']?></h4>
                            <div class="afl-control-container">
                                <div class="afl-description"><?php echo $__OPTIONS['afl_counter_code']['description']?></div>
                                <div class="afl-control">
									<span class="afl-style-wrap">
									<?php print afl_render_theme_option("afl_counter_code", array('type' => 'textarea', 'default_value' => get_option('afl_counter_code'),'attributes' => array('class' => 'regular-text', 'name' => "afl_counter_code"))); ?>
									</span>
                                </div>
                                <div class="afl-clear"></div>
                            </div>
                        </div>
					</div>
                </div>
                <div class="afl-options-footer">
					<?php wp_nonce_field('theme-option'); ?>
                    <input type="hidden" name="afl_theme_tab" id="afl-theme-tab" value="<?php print intval($_POST['afl_theme_tab']); ?>" />
                    <input type="hidden" name="save_changes" value="true" />
					<ul class="afl-footer-links">
                        <li class="afl-footer-save"><span class="afl-style-wrap"><a class="afl-button afl-submit" href="#">Save all changes</a></span></li>
					</ul>
                </div>
			</div>
            <div class="afl-clear"></div>
		</div>
	</form>
    <div class="afl-clear"></div>
    <script type="text/javascript">
		jQuery('select').selectbox();
		check();
	</script>
<?php
}

?>
