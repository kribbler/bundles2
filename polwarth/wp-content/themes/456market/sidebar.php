	    
<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
		
		<?php if (is_page_template('template-contact.php')) { ?>
		    <?php if ( is_active_sidebar(3) ){?>
		    <div class="span3 sidebar">
		        <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Contact Page Sidebar') ) ?>
		    </div>
		    <?php } ?>
		<?php }elseif(is_singular( 'portfolio' )){ ?>
		<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
        <?php $terms = get_the_terms( get_the_ID(), 'portfolio_tags' ); ?>
		<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>
		<?php $gallery_type = get_post_meta($post->ID, 'portfolio_options_select', true);?>
		    
		    <?php if ( is_active_sidebar(4) || !empty($details) || $terms || !$share ){?>
		    	
		    	
		    	<div class="span3 sidebar">
		        <?php if ($gallery_type == 'sidebar') {?>
		        <?php $args = array(
		        'numberposts' => 9999, // change this to a specific number of images to grab
		        'offset' => 0,
		        'post_parent' => $post->ID,
		        'post_type' => 'attachment',
		        'nopaging' => false,
		        'post_mime_type' => 'image',
		        'order' => 'ASC', // change this to reverse the order
		        'orderby' => 'menu_order ID', // select which type of sorting
		        'post_status' => 'any'
		        );
		        $attachments =& get_children($args);?>
		            
				<?php if ($attachments) {?>
					<div class="widget gallery-widget">
				<div id="megafolio">
					<div class="container">
						<!-- The GRID System -->
						<div class="megafolio-container noborder">
					
				                <?php foreach($attachments as $attachment) {
				                $title = $attachment->post_title;
				                $image = wp_get_attachment_image_src($attachment->ID, 'blog-page', false);?> 
								<!-- A GALLERY ENTRY -->
								<div class="mega-entry cat-one cat-all" data-src="<?php echo $image[0] ?>" data-width="551" data-height="500">
									<div class="mega-hover">
												<div class="mega-hovertitle"><?php echo $title ?></div>
												<a class="fancybox" rel="group" href="<?php echo $image[0] ?>"><div class="mega-livicon"><span class="livicon" data-n="zoom-in" data-c="#fff" data-hc="#fff" data-s="32"></span></div></a>
										</div>
								</div>
								<?php }?>
					
						</div>
					</div>
				</div>
				
				<!--
				##############################
				 - ACTIVATE THE BANNER HERE -
				##############################
				-->
				<script type="text/javascript">
				
				
					jQuery(document).ready(function() {
				
						var api=jQuery('.megafolio-container').megafoliopro(
							{
								filterChangeAnimation:"rotatescale",	// fade, rotate, scale, rotatescale, pagetop, pagebottom,pagemiddle
								filterChangeSpeed:800,					// Speed of Transition
								filterChangeRotate:99,					// If you ue scalerotate or rotate you can set the rotation (99 = random !!)
								filterChangeScale:0.6,					// Scale Animation Endparameter
								delay:20,								// The Time between the Animation of single mega-entry points
								paddingHorizontal:10,					// Padding between the mega-entrypoints
								paddingVertical:10,
								layoutarray:[2]		// Defines the Layout Types which can be used in the Gallery. 2-9 or "random". You can define more than one, like {5,2,6,4} where the first items will be orderd in layout 5, the next comming items in layout 2, the next comming items in layout 6 etc... You can use also simple {9} then all item ordered in Layout 9 type.
				
							});
				
						// THE FANCYBOX PLUGIN INITALISATION
						jQuery(".fancybox").fancybox();
				
				
					});
				
				</script>
			</div>
		        <?php } unset($args);?>
		        
		        <?php }?>
		                        
		        <?php if ( !empty($details) || $terms || !$share ){?>
		        <div class="widget portfolio-info-widget">
	            <ul class="unstyled">
	                <?php if($details){ ?>
	                <?php $separator = "%%";
	                $output = '';
	                foreach ($details as $item) {
	                    if($item){
	                        list($item_text1, $item_text2) = explode($separator, trim($item));
	                        $output .= '<li><strong>' . $item_text1 . ':</strong> ' . do_shortcode($item_text2) . '</li>';
	                    }
	                }
	                echo $output;?>
	                <?php } ?>
	                <?php if($terms){?>
	                <li class="tags">
	                    <?php if($terms) : foreach ($terms as $term) { ?>
	                        <?php echo '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_tags').'">'.$term->name.'</a>'?>
	                    <?php } endif;?>
	                    <div class="clearfix"></div>
	                </li>
	                <?php }?>
	                <?php if(!$share){?>
	                <li class="share"><strong><?php _e( 'Share', GETTEXT_DOMAIN);?>:</strong>
	                    <ul>
	                        <li><iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=0&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></li>
	                        <li>
	                            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
	                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	                        </li>
	                        <li>
	                            <!-- Place this tag where you want the +1 button to render -->
	                            <div class="g-plusone" data-size="medium" data-annotation="none" data-href="<?php the_permalink(); ?>"></div>
	                            <!-- Place this render call where appropriate -->
	                            <script type="text/javascript">
	                              (function() {
	                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	                                po.src = 'https://apis.google.com/js/plusone.js';
	                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	                              })();
	                            </script>
	                        </li>
	                        <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {?>
	                        <li>
	                            <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio-post' ); echo $image[0];?>&description=<?php the_title();?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
	                        </li>
	                        <?php }?>
	                    </ul>
	                </li>
	                <?php }?>
	            </ul>
	        </div>
		        <?php }?>
		        
		        <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Portfolio Post Sidebar') ) ?>
		        
				</div>
				
				
		    <?php } ?>

		<?php }elseif(is_shop()||is_product_category()||is_product_tag()){ ?>
		
			<?php if ( is_active_sidebar(5) ){?>
				<div class="span3 sidebar">
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Shop Sidebar') ) ?>
				</div>
			<?php } ?>
		
		<?php } elseif (is_singular( 'product' )){?>
		
			<?php if ( is_active_sidebar(6) ){?>
				<div class="span2 sidebar">
				<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Product Post Sidebar') ) ?>
				</div>
			<?php } ?>	
		
		<?php } elseif ( is_active_sidebar(1) ){?>
	    <div class="span3 sidebar">
	    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Main Sidebar') ) ?>
	    </div>
	    <?php } ?>
	    
<?php } else{?>

		<?php if (is_page_template('template-contact.php')) { ?>
		    <?php if ( is_active_sidebar(3) ){?>
		    <div class="span3 sidebar">
		        <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Contact Page Sidebar') ) ?>
		    </div>
		    <?php } ?>
		<?php }elseif(is_singular( 'portfolio' )){ ?>
		<?php $details = get_post_meta($post->ID, 'portfolio_options_repeatable', true); if($details){$details = array_filter($details);};?>
        <?php $terms = get_the_terms( get_the_ID(), 'portfolio_tags' ); ?>
		<?php $share = get_post_meta($post->ID, 'portfolio_options_share', true);?>
		<?php $gallery_type = get_post_meta($post->ID, 'portfolio_options_select', true);?>
		    
		    <?php if ( is_active_sidebar(4) || !empty($details) || $terms || !$share ){?>
		    	
		    	
		    	<div class="span3 sidebar">
		        <?php if ($gallery_type == 'sidebar') {?>
		        <?php $args = array(
		        'numberposts' => 9999, // change this to a specific number of images to grab
		        'offset' => 0,
		        'post_parent' => $post->ID,
		        'post_type' => 'attachment',
		        'nopaging' => false,
		        'post_mime_type' => 'image',
		        'order' => 'ASC', // change this to reverse the order
		        'orderby' => 'menu_order ID', // select which type of sorting
		        'post_status' => 'any'
		        );
		        $attachments =& get_children($args);?>
		            
				<?php if ($attachments) {?>
					<div class="widget gallery-widget">
				<div id="megafolio">
					<div class="container">
						<!-- The GRID System -->
						<div class="megafolio-container noborder">
					
				                <?php foreach($attachments as $attachment) {
				                $title = $attachment->post_title;
				                $image = wp_get_attachment_image_src($attachment->ID, 'blog-page', false);?> 
								<!-- A GALLERY ENTRY -->
								<div class="mega-entry cat-one cat-all" data-src="<?php echo $image[0] ?>" data-width="551" data-height="500">
									<div class="mega-hover">
												<div class="mega-hovertitle"><?php echo $title ?></div>
												<a class="fancybox" rel="group" href="<?php echo $image[0] ?>"><div class="mega-livicon"><span class="livicon" data-n="zoom-in" data-c="#fff" data-hc="#fff" data-s="24"></span></div></a>
										</div>
								</div>
								<?php }?>
					
						</div>
					</div>
				</div>
				
				<!--
				##############################
				 - ACTIVATE THE BANNER HERE -
				##############################
				-->
				<script type="text/javascript">
				
				
					jQuery(document).ready(function() {
				
						var api=jQuery('.megafolio-container').megafoliopro(
							{
								filterChangeAnimation:"rotatescale",	// fade, rotate, scale, rotatescale, pagetop, pagebottom,pagemiddle
								filterChangeSpeed:800,					// Speed of Transition
								filterChangeRotate:99,					// If you ue scalerotate or rotate you can set the rotation (99 = random !!)
								filterChangeScale:0.6,					// Scale Animation Endparameter
								delay:20,								// The Time between the Animation of single mega-entry points
								paddingHorizontal:10,					// Padding between the mega-entrypoints
								paddingVertical:10,
								layoutarray:[2]		// Defines the Layout Types which can be used in the Gallery. 2-9 or "random". You can define more than one, like {5,2,6,4} where the first items will be orderd in layout 5, the next comming items in layout 2, the next comming items in layout 6 etc... You can use also simple {9} then all item ordered in Layout 9 type.
				
							});
				
						// THE FANCYBOX PLUGIN INITALISATION
						jQuery(".fancybox").fancybox();
				
				
					});
				
				</script>
			</div>
		        <?php } unset($args);?>
		        
		        <?php }?>
		                        
		        <?php if ( !empty($details) || $terms || !$share ){?>
		        <div class="widget portfolio-info-widget">
	            <ul class="unstyled">
	                <?php if($details){ ?>
	                <?php $separator = "%%";
	                $output = '';
	                foreach ($details as $item) {
	                    if($item){
	                        list($item_text1, $item_text2) = explode($separator, trim($item));
	                        $output .= '<li><strong>' . $item_text1 . ':</strong> ' . do_shortcode($item_text2) . '</li>';
	                    }
	                }
	                echo $output;?>
	                <?php } ?>
	                <?php if($terms){?>
	                <li class="tags">
	                    <?php if($terms) : foreach ($terms as $term) { ?>
	                        <?php echo '<a title="'.$term->name.'" href="'.get_term_link($term->slug, 'portfolio_tags').'">'.$term->name.'</a>'?>
	                    <?php } endif;?>
	                    <div class="clearfix"></div>
	                </li>
	                <?php }?>
	                <?php if(!$share){?>
	                <li class="share"><strong><?php _e( 'Share', GETTEXT_DOMAIN);?>:</strong>
	                    <ul>
	                        <li><iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=0&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe></li>
	                        <li>
	                            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
	                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	                        </li>
	                        <li>
	                            <!-- Place this tag where you want the +1 button to render -->
	                            <div class="g-plusone" data-size="medium" data-annotation="none" data-href="<?php the_permalink(); ?>"></div>
	                            <!-- Place this render call where appropriate -->
	                            <script type="text/javascript">
	                              (function() {
	                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	                                po.src = 'https://apis.google.com/js/plusone.js';
	                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	                              })();
	                            </script>
	                        </li>
	                        <?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {?>
	                        <li>
	                            <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio-post' ); echo $image[0];?>&description=<?php the_title();?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
	                        </li>
	                        <?php }?>
	                    </ul>
	                </li>
	                <?php }?>
	            </ul>
	        </div>
		        <?php }?>
		        
		        <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Portfolio Post Sidebar') ) ?>
		        
				</div>
				
				
		    <?php } ?>	
		
		<?php } elseif ( is_active_sidebar(1) ){?>
	    <div class="span3 sidebar">
	    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Main Sidebar') ) ?>
	    </div>
	    <?php } ?>

<?php } ?>