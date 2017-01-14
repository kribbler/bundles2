<?php
/*==========================================================================================

shortcodes.php
This file contains custom shortcodes for the theme

==========================================================================================

- Flex Slider
- Text Slider
- Slogan
- Divider
- Full Width
- 2,3,4-Column Structures
- Contact Form
- User Map
- User Button
- User Quote
- User Boxes
- Custom Image
- Tooltip
- Vimeo
- Youtube
- Posts Strip
- User Posts Strip
- Testimonials
- User Recents
- Accordions
- Recent Posts
- Advanced Recent Posts

*/
/******************** Shortcodes Initialization ******************/
    $__SHORTCODES = array(
		'afl_flex-slider' => array(
			'name' => 'Flex slider',
			'description' => 'Flex slider',
			'image' => 'css/images/nivo-tip.png'
		),
		'afl_text_slider' => array(
            'name' => 'Text slider',
            'description' => 'Text slider - no images just text carousel ',
			'image' => 'css/images/text-tip.png'
        ),
        'afl_full_width' => array(
            'name' => 'Full width',
            'description' => 'Full width block for content ',
			'image' => 'css/images/full-width-tip.png'
        ),
        'afl_2_columns' => array(
            'name' => '2 columns',
            'description' => '2 column content ',
			'image' => 'css/images/2-columns-tip.png'
        ),
        'afl_3_columns' => array(
            'name' => '3 columns',
            'description' => '3 column content ',
			'image' => 'css/images/3-columns-tip.png'
        ),
        'afl_4_columns' => array(
            'name' => '4 columns',
            'description' => '4 column content ',
			'image' => 'css/images/4-columns-tip.png'
        ),
		'afl_one_third_block' => array(
            'name' => 'One third',
            'description' => 'One third and two third columns content',
			'image' => 'css/images/one-third-tip.png'
        ),
		'afl_one_third_last_block' => array(
            'name' => 'One third last',
            'description' => 'Two third and one third columns content',
			'image' => 'css/images/one-third-last-tip.png'
        ),
        'afl_slogan' => array(
            'name' => 'Slogan',
            'description' => 'Slogan shortcode ',
			'image' => 'css/images/slogan-tip.png'
        ),
		'afl_divider' => array(
            'name' => 'Divider',
            'description' => 'Divider with text',
			'image' => 'css/images/divider-tip.png'
        ),
		'afl_recent_projects' => array(
			'name' => 'Recent Projects',
			'description' => 'Recent projects',
			'image' => 'css/images/recent-posts-tip.png'
		),
		'afl_advanced_recent_projects' => array(
			'name' => 'Advanced Recent Projects',
			'description' => 'Recent projects with Intro and Title',
			'image' => 'css/images/recent-posts-tip.png'
		),
		'afl_recent_posts' => array(
            'name' => 'Recent Posts',
            'description' => 'Recent posts',
			'image' => 'css/images/recent-posts-tip.png'
        ),
		'afl_advanced_recent_posts' => array(
            'name' => 'Advanced Recent Posts',
            'description' => 'Recent posts with Intro and Title',
			'image' => 'css/images/recent-posts-tip.png'
        ),
    );

/******************** Begin Flex Slider ******************/
function afl_flex_slider_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	$out = '';
	//var_export($atts);
	if ($atts['fullwidth'] == 'open') $out .= '<section class="container">';
	$out .= '<div id="flexslider-'.$suf.'" class="flexslider">
				'.afl_do_shortcode($content).'
				<script type="text/javascript">
					$(document).ready(function() {
						$("#flexslider-'.$suf.'").flexslider({';
							if (isset($atts['animation']) && ($atts['animation'])) $out .= 'animation: "'.$atts['animation'].'",';
							$out .= 'useCSS: false,
							easing: "'.(isset($atts['effect']) ? $atts['effect'] : 'swing').'",';
							$out .= 'direction: "'. ($atts['direction'] == 'vertical' ?  'vertical' : 'horizontal') .'",
							reverse: false,
							controlNav: '. ($atts['navigation'] == 'true' ?  'true' : 'false') .',
							animationLoop: '. ($atts['loop'] == 'true' ?  'true' : 'false') .',
							smoothHeight: true,
							slideshow: true,
							slideshowSpeed: '. (intval($atts['slideshowspeed']) > 0 ?  intval($atts['slideshowspeed']) : '7000') .',
							animationSpeed: '. (intval($atts['slidespeed']) > 0 ?  intval($atts['slidespeed']) : '600') .',
							randomize: '. ($atts['randomize'] == 'open' ?  'true' : 'false') .',
							pauseOnHover: '. ($atts['hoverpause'] == 'true' ?  'true' : 'false') .',';
						$out .= '});
					});
					</script>
                </div>';
	if ($atts['fullwidth'] == 'open')
		$out .= '</section>';
	else {
		$atts['custom_class'] = 'flex_slider';
		$out = afl_container_wrap($atts, $out);
	}

	return $out;
}

add_shortcode('flex-slider', 'afl_flex_slider_shortcode');
/******************** End Flex Slider ******************/

/******************** Begin Text Slider ******************/
	function afl_text_slider_shortcode($atts, $content = null){
        $suf = rand(100000,999999);

		if(!empty($atts['content_types'])){
			$data = array();
			$contents = get_posts( array( 'posts_per_page' => isset($atts['content_count'])? $atts['content_count'] : 5, 'offset' => 0, 'post_type' => $atts['content_types'] ) );
			foreach( $contents as $post ){
				setup_postdata($post);
				$post_title = get_the_title($post->ID);
				$post_content = $post->post_excerpt;
				$author_name = '';
				$author_desc = '';
				$button_text = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
				$button_link = get_permalink();
				switch($atts['content_types']){
					case 'testimonials':
						$author_desc = get_url_desc_box($post->ID);
						$author_name = $post_title;
						$post_title = $button_text = $button_link = '';
						break;
					default: break;
				}
				$data[] = array('post_id' => $post->ID,'title' => $post_title, 'content' => $post_content, 'author_name' => $author_name, 'author_desc' => $author_desc, 'button_text' => $button_text, 'button_link' => $button_link);
			}
			$contents = '';
			if(!empty($data)){
				foreach($data as $slide){
					if(isset($slide['content'])){
						$content = $slide['content'];
						unset($slide['content']);
					}
					$contents .= ' [text_slide '.afl_render_shortcode_attributes('text_slider',$slide).'] '.$content.' [/text_slide] ';
				}
			}
		} else {
			$contents = $content;
		}

        $out = '<!--text-slider-->
        <div id="text-slider-'.$suf.'" class="carousel bttop">
            <div class="carousel-wrapper">
                <ul class="text-slider">'.afl_do_shortcode($contents).'</ul>
            </div>
        </div>

        <script type="text/javascript">
            $(window).load(function(){
            	logit = $("#text-slider-'.$suf.'").parent().parent().find(".title-divider h3");
                $("#text-slider-'.$suf.'").elastislide({
                	imageW: 1200,
                    margin  : 30
                });
                if(logit.length > 0) $("#text-slider-'.$suf.' .es-nav").css({"top": "-50px"});
			});
		</script>';
		$atts['custom_class'] = 'text_slider_block';
		if(!isset($atts['level'])) $out = afl_container_wrap($atts, $out);
        return $out;
    }
    add_shortcode('text_slider', 'afl_text_slider_shortcode');

    function afl_text_slide_shortcode($atts, $content = null){
        extract($atts);

		if(has_post_thumbnail($post_id))
			$thumbnail = get_the_post_thumbnail($post_id, 'popular-post-thumbnail');
		else
			$thumbnail = '';
        $out = '<li>';
					if (!empty($title)) {
                        $out.='<h4>';
					    if (!empty($icon)) $out.='<img alt="" src="'.$icon.'"/>';
					    $out.= $title.'</h4>';
                    }
					if (!empty($content))  $out.='<p>'.afl_do_shortcode($content).'</p>';
					if (!empty($author_name)) {
						$out .= $thumbnail.'<h4>';
						if (!empty($icon)) $out.='<img alt="" src="'.$icon.'"/>';
						$out .= $author_name;
						if(!empty($author_desc)) $out.='<small>'.$author_desc.'</small>';
						$out .= '</h4>';
					}
					if (!empty($button_link) || !empty($button_text)) $out.='<a href="'.$button_link.'">'.$button_text.'</a>';
				$out.='</li>';
        return $out;
    }
    add_shortcode('text_slide', 'afl_text_slide_shortcode');
/******************** End Text Slider ******************/

/******************** Begin Slogan ******************/
    function afl_slogan($atts, $content = null){
        $out = '<div class="container slogan">
            <section id="welcome">';
            if($atts['title']) $out.='<h1>'.$atts['title'].'</h1>';
			if($content && $content != ' ' && $content != '') $out.='<p>'.afl_do_shortcode($content).'</p>';
            if ($atts['button_link'] && $atts['button_text']){ $out.='<a href="'.$atts['button_link'].'" class="btn-info btn">'.$atts['button_text'].'</a>';
            }
            $out .= '</section>
            </div>';
        return $out;
    }
    add_shortcode('slogan', 'afl_slogan');
/******************** End Slogan ******************/

/******************** Begin Divider ******************/
function afl_divider($atts){
        $out = '';
		if(!empty($atts['title'])){
            $out .= '<div class="divider-title">'.$atts["title"].'</div>';
        }
		$out .= '<div class="div-horizontal"></div>';
		$atts['custom_class'] = 'divider_block';
		return afl_container_wrap($atts, $out);
}
add_shortcode('divider', 'afl_divider');
/******************** End Divider ******************/

/******************** Begin Full Screen ******************/
function afl_full_screen($content = null){
	return '<section class="container">'.afl_do_shortcode(apply_filters('the_content',$content)).'</section>';
}
add_shortcode('full_screen', 'afl_full_screen');
/******************** End Full Screen ******************/

/******************** Begin Full Width ******************/
function afl_full_width($atts, $content = null){
    $out = '<div class="container full_width"><div class="row-fluid">
                <div class="span12">';
	if($atts['title']){
		$out.='<h3>';
		if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
		$out.=$atts['title'].'</h3>';
	}
    if ($content)  { $out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>'; }
    if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
    $out.= '</div>
        </div></div>';
    return $out;
}
add_shortcode('full_width', 'afl_full_width');
/******************** End Full Width ******************/

/******************** Begin 2,3,4-Column Structures ******************/
    function afl_2_columns($atts, $content = null){
		$atts['custom_class'] = 'two_columns';
        return afl_container_wrap($atts, $content);
    }
    add_shortcode('2_columns', 'afl_2_columns');
	
	function afl_one_third_block($atts, $content = null){
		$atts['custom_class'] = 'one_third_columns';
        return afl_container_wrap($atts, $content);
    }
    add_shortcode('one_third_block', 'afl_one_third_block');
	
	function afl_one_third_last_block($atts, $content = null){
		$atts['custom_class'] = 'one_third_last_columns';
        return afl_container_wrap($atts, $content);
    }
    add_shortcode('one_third_last_block', 'afl_one_third_last_block');
	
    function afl_3_columns($atts, $content = null){
		$atts['custom_class'] = 'three_columns';
        return afl_container_wrap($atts, $content);
    }
    add_shortcode('3_columns', 'afl_3_columns');
    
    function afl_4_columns($atts, $content = null){
		$atts['custom_class'] = 'four_columns';
        return afl_container_wrap($atts, $content);
    }
    add_shortcode('4_columns', 'afl_4_columns');
	
	function afl_one_third($atts, $content = null){
        $out = '<div class="span4">';
		if ($atts['title']) {
			$out.= '<div class="title-divider"><h3>';
			if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
			$out .= $atts['title'].'</h3></div>';
		}
		
         if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
         if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
                $out.= '</div>';
        return $out;
    }
    add_shortcode('one_third', 'afl_one_third');
	
	function afl_two_third($atts, $content = null){
        $out = '<div class="span8">';
		if ($atts['title']) {
			$out.= '<div class="title-divider"><h3>';
			if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
			$out .= $atts['title'].'</h3></div>';
		}
		
         if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
         if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
                $out.= '</div>';
        return $out;
    }
    add_shortcode('two_third', 'afl_two_third');
	
	
    function afl_2_column($atts, $content = null){
        $out = '<div class="span6">';
		if ($atts['title']) {
			$out.= '<div class="title-divider"><h3>';
			if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
			$out .= $atts['title'].'</h3></div>';
		}
		
         if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
         if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
                $out.= '</div>';
        return $out;
    }
    add_shortcode('2_column', 'afl_2_column');
	
    function afl_3_column($atts, $content = null){
       $out = '<div class="span4">';
		if ($atts['title']) {
			$out.= '<div class="title-divider"><h3>';
			if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
			$out .= $atts['title'].'</h3></div>';
		}
		
         if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
         if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
                $out.= '</div>';
        return $out;
    }
    add_shortcode('3_column', 'afl_3_column');
	

    function afl_4_column($atts, $content = null){
        $out = '<div class="span3">';
		if ($atts['title']) {
			$out.= '<div class="title-divider"><h3>';
			if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
			$out .= $atts['title'].'</h3></div>';
		}
		
         if ($content)  {$out.= '<div class="text">'.afl_do_shortcode(apply_filters('the_content',$content)).'</div>';}
         if ($atts['button_link'] || $atts['button_text'] ) {$out.='<p><a href="'.$atts['button_link'].'" class="link">'.$atts['button_text'].'</a></p>';}
                $out.= '</div>';
        return $out;
    }
	add_shortcode('4_column', 'afl_4_column');
/******************** End 2,3,4-Column Structures ******************/

/******************** Begin Contact Form ******************/
    function user_contact_form($atts, $content = null){
        $suf = rand(100000,999999);
        $baseurl = TEMPLATEURL;
        $form = '
        <form name="contact" method="post" action="'.$baseurl.'/lib/mail.php" class="af-form" id="af-form-'.$suf.'" novalidate="novalidate">
			<div class="af-outer af-required">
				<div class="af-inner">
					<label for="name-'.$suf.'" id="name_label">Your Name:</label>
					<input type="text" name="name" id="name-'.$suf.'" size="30" value="" class="text-input input-xlarge required" />
				</div>
			</div>
			<div class="af-outer af-required">
				<div class="af-inner">
					<label for="email-'.$suf.'" id="email_label">Your Email:</label>
					<input type="text" name="email" id="email-'.$suf.'" size="30" value="" class="text-input input-xlarge required" />
				</div>
			</div>
			<div class="af-outer">
				<div class="af-inner">
					<label for="site-'.$suf.'" id="site_label">Your Website URL:</label>
					<input type="text" name="site" id="site-'.$suf.'" size="30" value="" class="text-input input-xlarge" />
				</div>
			</div>
			<div class="af-outer af-required">
				<div class="af-inner">
					<label for="input-message-'.$suf.'" id="message_label">Your Message:</label>
					<textarea name="message" id="input-message-'.$suf.'" cols="30" class="text-input required"></textarea>
				</div>
			</div>
			<div class="af-outer">
				<div class="af-inner">
					<input type="submit" name="submit" class="form-button btn" id="submit_btn" value="Send Message!" />
				</div>
			</div>
		</form>
		<script type="text/javascript">
		  $(document).ready(function(){
			$("#af-form-'.$suf.'").validate({
				submitHandler: function(form) {
				 $(form).ajaxSubmit().clearForm();
				 $("#af-form-'.$suf.'").prepend("<div class=\"alert alert-success fade in\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button><strong>Contact Form Submitted!</strong> We will be in touch soon.</div>");
			   },
				rules: {
				 name: "required",
				 email: {
				   required: true,
				   email: true
				 },
				 message: "required"
			   },
			   messages: {
				 name: "Please specify your name",
				 email: {
				   required: "We need your email address to contact you",
				   email: "Your email address must be in the format of name@domain.com"
				 },
				 message: "Enter your message!"
			   }
			});
		  });
		</script>
		';
        return $form;
    }
    add_shortcode('contact_form', 'user_contact_form');
/******************** End Contact Form ******************/

/******************** Begin User Map ******************/
    function user_map($atts, $content = null){
        $map = '';
        if(isset($atts['src'])){
            $atts['width'] = (intval($atts['width'])>0?intval($atts['width']):300);
            $atts['height'] = (intval($atts['height'])>0?intval($atts['height']):300);

            $map = '<iframe width="100%" height="'.$atts['height'].'" class="map-container" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$atts['src'].'&amp;output=embed'.'"></iframe>';
        }
        return $map;
    }
    add_shortcode('map', 'user_map');
/******************** End User Map ******************/

/******************** Begin User Button ******************/
	function user_button($atts, $content = null){
        $button = '';
        if((isset($atts['link'])) && (isset($content))){
            $button = '<a href="'.$atts['link'].'" class="user_button"';
			if(isset($atts['color'])) $button.=' style="background-color:'.$atts['color'].';"';
			$button.='>'.$content.'</a>';
        }
        return $button;
    }
    add_shortcode('button', 'user_button');
/******************** End User Button ******************/

/******************** Begin User Quote ******************/
	function user_quote($atts, $content = null){
        $quote = '';
        if(isset($content)){
            $quote = '<blockquote>';
			if(isset($atts['title'])) $quote .= '<h5>'.$atts['title'].'</h5>';
			$quote .= '<p>'.$content.'</p>';
			$quote .= '</blockquote>';
        }
        return $quote;
    }
    add_shortcode('quote', 'user_quote');
/******************** End User Quote ******************/

/******************** Begin User Boxes ******************/
	function user_warning_box($atts, $content = null){
        return true;
    }
    add_shortcode('warning_box', 'user_warning_box');

	function user_success_box($atts, $content = null){
		return true;
	}
	add_shortcode('success_box', 'user_success_box');

	function user_info_box($atts, $content = null){
		return true;
	}
	add_shortcode('info_box', 'user_info_box');

	function user_error_box($atts, $content = null){
		return true;
	}
	add_shortcode('error_box', 'user_error_box');

	function afl_box($atts, $content = null){
	$quote = '';
	if(isset($content)){
		if(!isset($atts['type']) || $atts['type'] == '') $atts['type'] = 'block';
		$quote = '<div class="alert alert-'.$atts['type'].'"><button type="button" class="close" data-dismiss="alert">×</button>';
		if(isset($atts['title'])) $quote .= '<h4>'.$atts['title'].'</h4>';
		$quote .= do_shortcode($content);
		$quote .= '</div>';
	}
	return $quote;
}
add_shortcode('box', 'afl_box');
/******************** End User Boxes ******************/

/******************** Begin Accordion ******************/
function user_accordion_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	$out = '<div id="accordion-'.$suf.'" class="accordion">'.afl_do_shortcode($content).'</div>

        <script type="text/javascript">
        	$(window).load(function(){
				$.each($("#accordion-'.$suf.' a.accordion-toggle"), function(i, link){
			var $collapsible = $(this.getAttribute("href"));

			$collapsible.collapse({
				parent : "#accordion-'.$suf.'"
			});

			$(link).on("click",
				function(){
					$collapsible.collapse("toggle"); // Here is the magic trick
				}
			);
		});
		});
		</script>';
	return $out;
}
add_shortcode('accordion', 'user_accordion_shortcode');

function afl_accordion_unit_shortcode($atts, $content = null){
	$suf = rand(100000,999999);
	extract($atts);

	$out = '<div class="accordion-group">';
	if (!empty($title)) {
		$out.='<div class="accordion-heading"><a href="#collapse'.$suf.'" data-toggle="collapse" class="accordion-toggle"><i class="icon-plus icon-white"></i>'.$title.'<span></span></a></div>';
	}
	if (!empty($content)) {
		$out .= '<div class="accordion-body collapse" id="collapse'.$suf.'" style="height: 0"><div class="accordion-inner">';
		$out.='<p>'.afl_do_shortcode($content).'</p>';
		if (!empty($url) || !empty($link_text)) $out.='<a href="'.$url.'" class="read-more">'.$link_text.'</a>';
		$out .= '</div></div>';
	}

	$out.='</div>';
	return $out;
}
add_shortcode('accordion_unit', 'afl_accordion_unit_shortcode');
/******************** End Accordion ******************/

/******************** Begin Tooltip ******************/
	function user_tooltip($atts, $content = null) {
		if(isset($content)){
			if (!empty($atts['text'])) {
				$res = '<a href="#" rel="tooltip" data-original-title="'.$atts['text'].'" data-placement="top">'.do_shortcode($content).'</a>';
				return $res;
			}
		}
		return '';
	}
	add_shortcode('tooltip', 'user_tooltip');
/******************** End Tooltip ******************/

/******************** Begin Vimeo ******************/
	function user_video($atts, $content = null) {
			if(isset($atts['id'])) {
				if(isset($atts['type']) && $atts['type'] = "vimeo")
					$url = 'http://vimeo.com/moogaloop.swf?clip_id='.$atts['id'];
				else
					$url = 'http://www.youtube.com/v/'.$atts['id'];
				if($atts['width']) $width = $atts['width']; else $width="100%";
				if($atts['height']) $height = $atts['height']; else $height="200";
				$videoString = "";
				$videoString .= '<div class="video-wrap">';
				$videoString .= '<object type="application/x-shockwave-flash" data="'.$url.'" width="'.$width.'" height="'.$height.'">';
				$videoString .= '<param name="allowScriptAccess" value="always" />';
				$videoString .= '<param name="allowFullScreen" value="true" />';
				$videoString .= '<param name="movie" value="'.$url.'" />';
				$videoString .= '<param name="quality" value="high" />';
				$videoString .= '<param name="wmode" value="transparent" />';
				$videoString .= '<param name="bgcolor" value="#ffffff" />';
				$videoString .= '</object>';
				$videoString .= '</div>';
				return do_shortcode($videoString);
			}
		return '';
	}
	add_shortcode('video', 'user_video');
/******************** End Video ******************/

/******************** Begin Posts Strip ******************/
        function afl_posts_strip($atts, $content = null){
            $use_pager = (bool)$atts['use_pager'];
            $per_page = intval($atts['per_page']);
            $type = trim($atts['type']);
            $offset = intval($atts['offset']);
            $count = wp_count_posts($type)->publish;
            if ($use_pager){
                $paged = intval(get_query_var('paged'));
                if(empty($paged) || $paged == 0) $paged = 1;
            }
            $posts = get_posts( array( 'posts_per_page' => $per_page, 'offset'=> $offset+($use_pager?($paged-1)*$per_page:0), 'post_type' => $type ) );
            $content = '<div class="row-fluid our-news">';
            if ($posts){
                foreach ($posts as $post){
                    setup_postdata($post);
                    $content .= '<article class="divider-blok ' . join( ' ', get_post_class('',$post->ID) ) . '" id="post-'.$post->ID.'">';
					$content .= '<div class="news-data"><span>'.get_the_time( 'd', $post->ID ).'</span>'.get_the_time( 'M', $post->ID ).'</div>';
					$content .= '<h4 class="title"><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h4>';
                    $content .= excerpt();
					$content .= '<a href="'.get_permalink($post->ID).'">'.$readmore.'</a></article>';

                }
                if($use_pager){
                    $content .= afl_pager($count, $per_page, $paged, 2, false);
                }
            }
            else{
                $content .= 'None Found';
            }
            $content .= '</div>';
			$atts['custom_class'] = 'posts_strip';
			if(!isset($atts['level']))
				return $content = afl_container_wrap($atts, $content);
			else
				return do_shortcode($content);
        }
        add_shortcode('posts_strip', 'afl_posts_strip');
/******************** End Posts Strip ******************/

/******************** Begin User Posts Strip ******************/
		function user_posts_strip($atts, $content = null){
            return do_shortcode('[posts_strip type="'.$atts['type'].'" offset="'.$atts['offset'].'" per_page="'.$atts['per_page'].'" level="inside"] [/posts_strip]');
        }
        add_shortcode('user_posts_strip', 'user_posts_strip');
/******************** End User Posts Strip ******************/

/******************** Begin Testimonials ******************/
        function user_testimonials($atts = null, $content = null){
            return do_shortcode('[text_slider content_types="testimonials" level="inside"] [/text_slider]');
        }
        add_shortcode('testimonials', 'user_testimonials');
/******************** End Testimonials ******************/

/******************** Begin User Recents ******************/
        function user_recents($atts, $content = null){
            return do_shortcode('[recent_posts] [/recent_posts]');
        }
        add_shortcode('recents', 'user_recents');
/******************** End User Recents ******************/

/******************** Begin Recent Projects ******************/
function afl_recent_projects($atts, $content = null){
	global $post;
	$number = (isset($atts['number']) && $atts['number'] > 0) ? $atts['number'] : 4;
	$args = array( 'posts_per_page' => $number, 'post_type' => 'portfolio');
	$myposts = get_posts( $args );
	$suf = rand(100000,999999);
	$res = '<div class="container recent_projects"><div class="row-fluid">';
	if ($atts['title']) {
		$res.= '<div class="title-divider"><h3>';
		if ($atts['icon']) {$res.='<img src="'.$atts['icon'].'"/>';}
		$res .= $atts['title'].'</h3></div>';
	}
	$res .= '<div id="our-projects-'.$suf.'" class="carousel">
            <div class="carousel-wrapper">
                <ul class="da-thumbs">';
	foreach( $myposts as $post ) : setup_postdata($post);
		$res .= '<li>';
		if (has_post_thumbnail()) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
			$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			$res .= '<a href="'.$src[0].'" rel="prettyPhoto"><img src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';

			$res .= '<div>
						<a href="'.$src[0].'" class="p-view" data-rel="prettyPhoto"></a>
						<a href="'.get_permalink($post->ID).'" class="p-link"></a>
					</div>
				</li>';
		}
	endforeach;
	$res.='</ul>';
	$res .= '<script type="text/javascript">
            $(window).load(function(){
                $("#our-projects-'.$suf.'").elastislide({
                    imageW  : 270,
                    margin  : 29
                });
                $("#our-projects-'.$suf.' .es-nav").css({"top": "-30px", "right": 0, "position": "absolute"});
			});
			</script>';
	$res .= '</div></div></div></div>';

	return $res;
}
add_shortcode('recent_projects', 'afl_recent_projects');
/******************** End Recent Projects ******************/

/******************** Begin Advanced Recent Projects ******************/
function afl_advanced_recent_projects($atts, $content = null){
	$suf = rand(100000,999999);
	$out = '<div class="container adv_recent_projects"><div class="row-fluid">';
	$out .= '<div class="span3">';
	if($atts['title']){
		$out.='<h3>';
		if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
		$out.=$atts['title'].'</h3>';
	}

	if ($content)  {$out.= '<p>'.afl_do_shortcode(apply_filters('the_content',$content)).'</p>';}
	if ($atts['button_link'] || $atts['button_text'] ) {$out.='<a href="'.$atts['button_link'].'" class="btn">'.$atts['button_text'].'</a>';}
	$out.= '</div>';
	//recent projects
	$out .= '<div class="span9"><div id="our-projects-'.$suf.'" class="carousel btleft">
            <div class="carousel-wrapper">
                <ul class="da-thumbs">';
	$number = (isset($atts['number']) && $atts['number'] > 0) ? $atts['number'] : 4;
	$myposts = get_posts(array( 'posts_per_page' => $number, 'post_type' => 'portfolio') );
	foreach( $myposts as $post ) : setup_postdata($post);
		$out .= '<li>';
		if (has_post_thumbnail()) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
			$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			$out .= '<a href="'.$src[0].'" rel="prettyPhoto"><img src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';

			$out .= '<div>
						<a href="'.$src[0].'" class="p-view" data-rel="prettyPhoto"></a>
						<a href="'.get_permalink($post->ID).'" class="p-link"></a>
					</div>
				</li>';
		}
	endforeach;
	$out .= '</ul>';
	$out .= '<script type="text/javascript">
            $(window).load(function(){
                $("#our-projects-'.$suf.'").elastislide({
                    imageW  : 270,
                    margin  : 28
                });
			});
			</script>';
	$out .= '</div></div></div></div></div>';
	return $out;
}
add_shortcode('advanced_recent_projects', 'afl_advanced_recent_projects');
/******************** End Advanced Recent Projects ******************/

/*********************** Begin Recent Posts *************************/
function afl_recent_posts($atts, $content = null){
    global $post;
	if(!isset($atts['number'])) $atts['number'] = 4;
	switch($atts['number']){
		case 2:$span='span6';break;
		case 3:$span='span4';break;
		default:$span='span3';break;
	}
    $args = array(
					'numberposts'=>$atts['number'],
					'offset' => (isset($atts['offset']) && intval($atts['offset']) > 0) ? intval($atts['offset']) : '',
					'category' => (isset($atts['category']) && intval($atts['category']) > 0) ? intval($atts['category']) : ''
	);
    $myposts = get_posts( $args );
    $res = '<div class="container recent_posts">';
	if ($atts['title']) {
		$res.= '<div class="title-divider"><h3>';
		if ($atts['icon']) {$res.='<img src="'.$atts['icon'].'"/>';}
		$res .= $atts['title'].'</h3></div>';
	}
	$res .= '<div class="row-fluid our-blog">';
    foreach( $myposts as $post ) : setup_postdata($post);
        $res .= '<article class="'.$span.'">';
        $num_comments = get_comments_number($post->ID);
        if($num_comments == 0){
            $comments = __('No Comments');
        }
        elseif($num_comments > 1){
            $comments = $num_comments. __('Comments');
        }
        else{
            $comments ="1 Comment";
        }
        $write_comments = ' <a href="' . get_comments_link() .'">'. $comments.'</a>';

        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			$res .= '<a href="'.$src[0].'" rel="prettyPhoto"><img src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';
        }

		$year = get_the_time( 'Y', $post->ID );$month = get_the_time( 'm', $post->ID );$day = get_the_time( 'd', $post->ID );

		$post_categories = wp_get_post_categories( $post->ID );
		$cat = get_category( $post_categories[0] );

		$res .= '<p class="l-meta"><span>By <a href="'. get_author_posts_url(get_the_author_meta("ID")).'">'.get_the_author().'</a>  | On <a href="'.get_day_link( $year, $month, $day ).'">'.get_the_time('F j, Y', $post->ID).'</a> | In <a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></span></p>';

		$res .= '<h4 class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>';

		$res .= '<p>'.((!empty($post->post_excerpt)) ? $post->post_excerpt : content()).'</p>';
		$readmore = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
		$res .= '<a href="'.get_permalink($post->ID).'">'.$readmore.'</a>
				 </article>';
    endforeach;
    $res.='</div>
    </div>';
    return $res;
}
add_shortcode('recent_posts', 'afl_recent_posts');
/************************* End Recent Posts ************************/

/******************** Begin Advanced Recent Posts ******************/
        function afl_advanced_recent_posts($atts, $content = null){
			if(!isset($atts['number'])) $atts['number'] = 3;
			switch($atts['number']){
				case 1:$span='span6';break;
				case 2:$span='span4';break;
				default:$span='span3';break;
			}
			$args = array(
				'numberposts'=>$atts['number'],
				'offset' => (isset($atts['offset']) && intval($atts['offset']) > 0) ? intval($atts['offset']) : '',
				'category' => (isset($atts['category']) && intval($atts['category']) > 0) ? intval($atts['category']) : ''
			);
            $out = '<div class="container adv_recent_posts"><div class="row-fluid our-blog">';
			    $out .= '<div class="'.$span.'">';
			if($atts['title']){
				$out.='<h3>';
				if ($atts['icon']) {$out.='<img src="'.$atts['icon'].'"/>';}
				$out.=$atts['title'].'</h3>';
			}
				
				if ($content)  {$out.= '<p>'.afl_do_shortcode(apply_filters('the_content',$content)).'</p>';}
				if ($atts['button_link'] || $atts['button_text'] ) {$out.='<a href="'.$atts['button_link'].'" class="btn">'.$atts['button_text'].'</a>';}
						$out.= '</div>';
            //recent posts
            $myposts = get_posts( $args );

            foreach( $myposts as $post ) : setup_postdata($post);
              $out .= '	<article class="'.$span.'">';

	      if (get_post_thumbnail_id( $post->ID )) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'portfolio' );
                $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                $out .= '<a href="'.$src[0].'" rel="prettyPhoto"><img src="'.$image[0].'" alt="'.$post->post_title.'"/></a>';
		  }

			  $year = get_the_time( 'Y', $post->ID );$month = get_the_time( 'm', $post->ID );$day = get_the_time( 'd', $post->ID );

				$post_categories = wp_get_post_categories( $post->ID );
				$cat = get_category( $post_categories[0] );

			  $out .= '<p class="l-meta"><span>By <a href="'. get_author_posts_url(get_the_author_meta("ID")).'">'.get_the_author().'</a>  | On <a href="'.get_day_link( $year, $month, $day ).'">'.get_the_time('F j, Y', $post->ID).'</a> | In <a href="'.get_category_link( $cat->cat_ID ).'">'.$cat->name.'</a></span></p>';

			  $out .= '<h4 class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>';
			  
              $out .= '<p>'.((!empty($post->post_excerpt)) ? $post->post_excerpt : content()).'</p>';
			  $readmore = (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore');
			  $out .= '<a href="'.get_permalink($post->ID).'">'.$readmore.'</a>';
              $out .= '</article>';
 	    endforeach;
            $out .= '</div></div>';
            return $out;
        }
        add_shortcode('advanced_recent_posts', 'afl_advanced_recent_posts');
/******************** End Advanced Recent Posts *******************/
?>
