<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	
    /* General Settings
    ================================================== */
    $theme_layouts = get_option_tree('theme_layouts',$theme_options);
    $header_meta_layouts = get_option_tree('meta_layouts',$theme_options);
    $left_headermeta = get_option_tree('left_headermeta',$theme_options);
    $right_headermeta = get_option_tree('right_headermeta',$theme_options);
    $header_meta_c = get_option_tree('header_meta_c',$theme_options);
    
    /* Theme Options
    ================================================== */
    $theme_style = get_option_tree('theme_style',$theme_options);
    $bg_pattern = get_option_tree('bg_pattern',$theme_options);
    $bg_custom_pattern = get_option_tree('bg_custom_pattern',$theme_options);
    $bg_custom_img = get_option_tree('bg_custom_img',$theme_options);
    
    /* Page Options
    ================================================== */
    $page_gradient_bg_color_1 = get_option_tree('page_gradient_bg_color_1',$theme_options);
    
    /* Blog Options
    ================================================== */
    $blog_tagline_title = get_option_tree('blog-tagline-title',$theme_options);
    $blog_tagline_description = get_option_tree('blog-tagline-description',$theme_options);
    $blog_header_image = get_option_tree('blog-header-image',$theme_options);
    
    /* Shop Options
    ================================================== */
    $shop_search_header_image_raw = get_option_tree('shop_search_header_image',$theme_options);
    $shop_tag_header_image_raw = get_option_tree('shop_tag_header_image',$theme_options);
    $shop_category_header_image_raw = get_option_tree('shop_category_header_image',$theme_options);
    
    /* Header Background
    ================================================== */
    $tax_category_header_image_raw = get_option_tree('tax_category_header_image',$theme_options);
    $tax_post_tag_header_image_raw = get_option_tree('tax_post_tag_header_image',$theme_options);
    $archive_header_image_raw = get_option_tree('archive_header_image',$theme_options);
    $search_header_image_raw = get_option_tree('search_header_image',$theme_options);
    $tax_portfolio_category_header_image_raw = get_option_tree('tax_portfolio_category_header_image',$theme_options);
    $tax_portfolio_tags_header_image_raw = get_option_tree('tax_portfolio_tags_header_image',$theme_options);

}
?>
		<?php if(!is_page_template('template-front.php')&&!is_page_template('template-front-blog.php')&&!is_page_template('template-front-blog-sidebar.php')){?>
		<div id="page-breadcrumb">
			<div class="container">
				<div class="row-fluid">
					<div class="span6"><div class="breadcrumb-wrap">
					<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
						<?php if ( is_shop()||is_tax('product_cat')||is_tax('product_tag') ) {?>
							<?php do_action('woocommerce_page_breadcrumb');?>
						<?php }else{?>
							<?php echo the_breadcrumb()?>
						<?php }?>
					<?php }else{?>
						<?php echo the_breadcrumb()?>
					<?php }?>
					</div></div>
				</div>
			</div>
		</div>
		<?php $portfolio_tagline_text = get_post_meta($post->ID, 'portfolio_tagline_text', true); ?>
		<?php $portfolio_tagline_textarea = get_post_meta($post->ID, 'portfolio_tagline_textarea', true); ?>
		
		<?php $product_tagline_text = get_post_meta($post->ID, 'product_tagline_text', true); ?>
		<?php $product_tagline_textarea = get_post_meta($post->ID, 'product_tagline_textarea', true); ?>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php if(is_shop()){?>
				<?php $shop_id = woocommerce_get_page_id('shop');?>
				<?php $page_tagline_text = get_post_meta($shop_id, 'page_tagline_text', true); ?>
				<?php $page_tagline_textarea = get_post_meta($shop_id, 'page_tagline_textarea', true); ?>
			<?php }else{?>
				<?php $page_tagline_text = get_post_meta($post->ID, 'page_tagline_text', true); ?>
				<?php $page_tagline_textarea = get_post_meta($post->ID, 'page_tagline_textarea', true); ?>
			<?php }?>
		<?php }else{?>
			<?php $page_tagline_text = get_post_meta($post->ID, 'page_tagline_text', true); ?>
			<?php $page_tagline_textarea = get_post_meta($post->ID, 'page_tagline_textarea', true); ?>
		<?php }?>
		
		<?php $post_tagline_text = get_post_meta($post->ID, 'post_tagline_text', true); ?>
		<?php $post_tagline_textarea = get_post_meta($post->ID, 'post_tagline_textarea', true); ?>
			
		<?php // Order of replacement
		$order   = array("<br />", "<br/>", "<br>");
		$replace = '</span><br /><span class="highlight">';

		$portfolio_tagline_textarea_newstr = str_replace($order, $replace, $portfolio_tagline_textarea);
		$page_tagline_textarea_newstr = str_replace($order, $replace, $page_tagline_textarea);
		$product_tagline_textarea_newstr = str_replace($order, $replace, $product_tagline_textarea);
		$post_tagline_textarea_newstr = str_replace($order, $replace, $post_tagline_textarea);
		$blog_tagline_description_newstr = str_replace($order, $replace, $blog_tagline_description);
		$member_terms = get_the_terms( get_the_ID(), 'about_category' );?>
		
		<?php if($portfolio_tagline_text||$portfolio_tagline_textarea||$page_tagline_text||$page_tagline_textarea||$product_tagline_text||$product_tagline_textarea||$post_tagline_text||$post_tagline_textarea||$blog_tagline_title||$blog_tagline_description||$member_terms){?>
		<div id="page-tagline">
			<div class="container">
				<div class="row-fluid">
					<div class="span6">
						<div class="wrap-tagline">
							<?php if(is_singular('portfolio')){?>
								<?php if($portfolio_tagline_text){?>
								<h3><?php echo $portfolio_tagline_text;?></h3>
								<?php }?>
								<?php if($portfolio_tagline_textarea){?>
								<div class="description"><span class="highlight"><?php echo $portfolio_tagline_textarea_newstr;?></span></div>
								<?php }?>
							<?php }?>
							<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
								<?php if(!is_shop()){?>
									<?php if($page_tagline_text){?>
									<h3><?php echo $page_tagline_text;?></h3>
									<?php }?>
									<?php if($page_tagline_textarea){?>
									<div class="description"><span class="highlight"><?php echo $page_tagline_textarea_newstr;?></span></div>
									<?php }?>
								<?php }?>
							<?php }else{?>
								<?php if($page_tagline_text){?>
								<h3><?php echo $page_tagline_text;?></h3>
								<?php }?>
								<?php if($page_tagline_textarea){?>
								<div class="description"><span class="highlight"><?php echo $page_tagline_textarea_newstr;?></span></div>
								<?php }?>
							<?php }?>
							<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
								<?php if(is_shop()){?>
									<?php if(!is_search()){?>
										<?php if($page_tagline_text){?>
										<h3><?php echo $page_tagline_text;?></h3>
										<?php }?>
										<?php if($page_tagline_textarea){?>
										<div class="description"><span class="highlight"><?php echo $page_tagline_textarea_newstr;?></span></div>
										<?php }?>
									<?php }?>
								<?php }?>
								<?php if(!is_shop()&&!is_product_category()&&!is_tax("product_tag")){?>
									<?php if($product_tagline_text){?>
									<h3><?php echo $product_tagline_text;?></h3>
									<?php }?>
									<?php if($product_tagline_textarea){?>
									<div class="description"><span class="highlight"><?php echo $product_tagline_textarea_newstr;?></span></div>
									<?php }?>
								<?php }?>
							<?php }?>
							<?php if(!is_home()&&!is_archive()){?>
								<?php if($post_tagline_text){?>
								<h3><?php echo $post_tagline_text;?></h3>
								<?php }?>
								<?php if($post_tagline_textarea){?>
								<div class="description"><span class="highlight"><?php echo $post_tagline_textarea_newstr;?></span></div>
								<?php }?>
							<?php }?>
							<?php if(is_home()){?>
							<?php if($blog_tagline_title){?>
								<h3><?php echo $blog_tagline_title;?></h3>
								<?php }?>
								<?php if($blog_tagline_description){?>
								<div class="description"><span class="highlight"><?php echo $blog_tagline_description_newstr;?></span></div>
								<?php }?>
							<?php }?>
			                <?php if($member_terms) : foreach ($member_terms as $term) { echo '<h3>'.$term->name.'</h3>'; } endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
		<?php }?>
		
		<?php $portfolio_header_image = get_post_meta($post->ID, 'portfolio_header_image', true); ?>
		<?php $product_header_image = get_post_meta($post->ID, 'product_header_image', true); ?>

		<?php $page_header_image = get_post_meta($post->ID, 'page_header_image', true); ?>
		
		<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
			<?php if(is_shop()){?>
				<?php $shop_id = woocommerce_get_page_id('shop');?>
				<?php $page_header_image = get_post_meta($shop_id, 'page_header_image', true); ?>
			<?php }?>
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
		<?php }else{?>
			<?php $front_style1_select = ""; ?>
		<?php }?>
		
		<?php $portfolio_header_image_bg = wp_get_attachment_image_src( $portfolio_header_image, 'page-header' );?>
		<?php $product_header_image_bg = wp_get_attachment_image_src( $product_header_image, 'page-header' );?>
		<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'front-page-header' );?>
		<?php }else{?>
			<?php $page_header_image_bg = wp_get_attachment_image_src( $page_header_image, 'page-header' );?>
		<?php }?>
		<?php $post_header_image_bg = wp_get_attachment_image_src( $post_header_image, 'page-header' );?>
		<?php if($blog_header_image){ $blog_header_image = get_attachment_id_from_src($blog_header_image); }?>
		<?php $blog_header_image_bg = wp_get_attachment_image_src( $blog_header_image, 'page-header' );?>
		
		<?php $shop_search_header_image = get_attachment_id_from_src($shop_search_header_image_raw);?>
		<?php $shop_tag_header_image = get_attachment_id_from_src($shop_tag_header_image_raw);?>
		<?php $shop_category_header_image = get_attachment_id_from_src($shop_category_header_image_raw);?>
		<?php $shop_search_header_image_bg = wp_get_attachment_image_src( $shop_search_header_image, 'page-header' );?>
		<?php $shop_tag_header_image_bg = wp_get_attachment_image_src( $shop_tag_header_image, 'page-header' );?>
		<?php $shop_category_header_image_bg = wp_get_attachment_image_src( $shop_category_header_image, 'page-header' );?>
		
		<?php $tax_category_header_image = get_attachment_id_from_src($tax_category_header_image_raw);?>
		<?php $tax_post_tag_header_image = get_attachment_id_from_src($tax_post_tag_header_image_raw);?>
		<?php $archive_header_image = get_attachment_id_from_src($archive_header_image_raw);?>
		<?php $search_header_image = get_attachment_id_from_src($search_header_image_raw);?>
		<?php $tax_portfolio_category_header_image = get_attachment_id_from_src($tax_portfolio_category_header_image_raw);?>
		<?php $tax_portfolio_tags_header_image = get_attachment_id_from_src($tax_portfolio_tags_header_image_raw);?>
		<?php $tax_category_header_image_bg = wp_get_attachment_image_src( $tax_category_header_image, 'page-header' );?>
		<?php $tax_post_tag_header_image_bg = wp_get_attachment_image_src( $tax_post_tag_header_image, 'page-header' );?>
		<?php $archive_header_image_bg = wp_get_attachment_image_src( $archive_header_image, 'page-header' );?>
		<?php $search_header_image_bg = wp_get_attachment_image_src( $search_header_image, 'page-header' );?>
		<?php $tax_portfolio_category_header_image_bg = wp_get_attachment_image_src( $tax_portfolio_category_header_image, 'page-header' );?>
		<?php $tax_portfolio_tags_header_image_bg = wp_get_attachment_image_src( $tax_portfolio_tags_header_image, 'page-header' );?>
		
		
		<div id="page-header" class="<?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?><?php if($front_options_select=="style1"){?>front-page-header<?php } elseif($front_options_select=="style2"){?>front-page-header-2<?php }else{?>front-page-header<?php }?><?php }?> <?php if(is_page_template('template-front.php')||is_page_template('template-front-blog.php')||is_page_template('template-front-blog-sidebar.php')){?><?php if(!$front_callout_checkbox){?>front-page-header-no-callout<?php }?> <?php if(!$front_widget_checkbox){?>front-page-header-no-featured-w<?php }?> <?php if(!$front_widget_checkbox&&!$front_callout_checkbox){?>front-page-header-no-featured-callout<?php }?> <?php if ($front_style1_select=="youtube") { ?>front-youtube<?php }?><?php }?> page-header-image"
		
			<?php if ($front_style1_select!="front_slider"&&$front_style1_select!="youtube") { ?>
				<?php if(is_singular('portfolio')){?>
					<?php if($portfolio_header_image){?> style="background: url('<?php echo $portfolio_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
					<?php if(!is_shop()){?>
						<?php if($page_header_image){?> style="background: url('<?php echo $page_header_image_bg[0]; ?>');"<?php }?>
					<?php }?>
				<?php }else{?>
					<?php if($page_header_image){?> style="background: url('<?php echo $page_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
					<?php if(is_shop()){?>
						<?php if(is_search()){?>
							<?php if($shop_search_header_image){?> style="background: url('<?php echo $shop_search_header_image_bg[0]; ?>')"<?php }?>
						<?php } else{?>
							<?php if($page_header_image){?> style="background: url('<?php echo $page_header_image_bg[0]; ?>');"<?php }?>
						<?php }?>
					<?php } elseif(is_product_category()){ ?>
						<?php if($shop_category_header_image){?> style="background: url('<?php echo $shop_category_header_image_bg[0]; ?>');"<?php }?>
					<?php } elseif(is_tax("product_tag")){?>
						<?php if($shop_tag_header_image){?> style="background: url('<?php echo $shop_tag_header_image_bg[0]; ?>');"<?php }?>
					<?php }?>
					<?php if(!is_shop()&&!is_product_category()&&!is_tax("product_tag")){?>
						<?php if($product_header_image){?> style="background: url('<?php echo $product_header_image_bg[0]; ?>');"<?php }?>
					<?php }?>
				<?php }?>
				<?php if(is_singular()){?>
					<?php if($post_header_image){?> style="background: url('<?php echo $post_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if(is_category()){?>
					<?php if($tax_category_header_image){?> style="background: url('<?php echo $tax_category_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if(is_tag()){?>
					<?php if($tax_post_tag_header_image){?> style="background: url('<?php echo $tax_post_tag_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if(is_archive()){?>
					<?php if(is_tax("portfolio_category")){?>
						<?php if($tax_portfolio_category_header_image){?> style="background: url('<?php echo $tax_portfolio_category_header_image_bg[0]; ?>');"<?php }?>
					<?php } elseif(is_tax("portfolio_tags")){?>
						<?php if($tax_portfolio_tags_header_image){?> style="background: url('<?php echo $tax_portfolio_tags_header_image_bg[0]; ?>');"<?php }?>
					<?php } else{?>
						<?php if($archive_header_image){?> style="background: url('<?php echo $archive_header_image_bg[0]; ?>');"<?php }?>
					<?php }?>
				<?php }?>
				<?php if(is_search()){?>
					<?php if($search_header_image){?> style="background: url('<?php echo $search_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
				<?php if(is_home()){?>
					<?php if($blog_header_image){?> style="background: url('<?php echo $blog_header_image_bg[0]; ?>');"<?php }?>
				<?php }?>
			<?php }?>
		
		>
			<?php if($front_options_select!="style2"){?> <?php get_template_part('includes/front_style2' ) ?><?php }?>
			<?php if($front_options_select=="style1"){?><?php get_template_part('includes/front_style1' ) ?><?php }?>
			
		</div>