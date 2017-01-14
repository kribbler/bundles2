<?php $forrst = ot_get_option('forrst');$dribbble = ot_get_option('dribbble');$twitter = ot_get_option('twitter');$flickr = ot_get_option('flickr');$twitter_1 = ot_get_option('twitter_1');$facebook = ot_get_option('facebook');$skype = ot_get_option('skype');$digg = ot_get_option('digg');$google= ot_get_option('google');$html5 = ot_get_option('html5');$linkedin = ot_get_option('linkedin');$last_fm = ot_get_option('last_fm');$vimeo = ot_get_option('vimeo');$yahoo = ot_get_option('yahoo');$tumblr = ot_get_option('tumblr');$apple = ot_get_option('apple');$windows = ot_get_option('windows');$youtube = ot_get_option('youtube');$delicious = ot_get_option('delicious');$rss = ot_get_option('rss');$picasa = ot_get_option('picasa');$deviantart = ot_get_option('deviantart');$technorati = ot_get_option('technorati');$stumbleupon = ot_get_option('stumbleupon');$blogger = ot_get_option('blogger');$wordpress = ot_get_option('wordpress');$amazon = ot_get_option('amazon');$appstore = ot_get_option('appstore');$paypal = ot_get_option('paypal');$myspace = ot_get_option('myspace');$dropbox = ot_get_option('dropbox');$windows8 = ot_get_option('windows8');$pinterest = ot_get_option('pinterest');$soundcloud = ot_get_option('soundcloud');$google_drive = ot_get_option('google_drive');$android = ot_get_option('android');$behance = ot_get_option('behance');$instagram = ot_get_option('instagram');$ebay = ot_get_option('ebay');$google_plus = ot_get_option('google_plus');$forrst1 = ot_get_option('forrst1');$dribbble1 = ot_get_option('dribbble1');$twitter1 = ot_get_option('twitter1');$flickr1 = ot_get_option('flickr1');$twitter_11 = ot_get_option('twitter_11');$facebook1 = ot_get_option('facebook1');$skype1 = ot_get_option('skype1');$digg1 = ot_get_option('digg1');$google1= ot_get_option('google1');$html51 = ot_get_option('html51');$linkedin1 = ot_get_option('linkedin1');$last_fm1 = ot_get_option('last_fm1');$vimeo1 = ot_get_option('vimeo1');$yahoo1 = ot_get_option('yahoo1');$tumblr1 = ot_get_option('tumblr1');$apple1 = ot_get_option('apple1');$windows1 = ot_get_option('windows1');$youtube1 = ot_get_option('youtube1');$delicious1 = ot_get_option('delicious1');$rss1 = ot_get_option('rss1');$picasa1 = ot_get_option('picasa1');$deviantart1 = ot_get_option('deviantart1');$technorati1 = ot_get_option('technorati1');$stumbleupon1 = ot_get_option('stumbleupon1');$blogger1 = ot_get_option('blogger1');$wordpress1 = ot_get_option('wordpress1');$amazon1 = ot_get_option('amazon1');$appstore1 = ot_get_option('appstore1');$paypal1 = ot_get_option('paypal1');$myspace1 = ot_get_option('myspace1');$dropbox1 = ot_get_option('dropbox1');$windows81 = ot_get_option('windows81');$pinterest1 = ot_get_option('pinterest1');$soundcloud1 = ot_get_option('soundcloud1');$google_drive1 = ot_get_option('google_drive1');$android1 = ot_get_option('android1');$behance1 = ot_get_option('behance1');$instagram1 = ot_get_option('instagram1');$ebay1 = ot_get_option('ebay1');$google_plus1 = ot_get_option('google_plus1');?>

<?php $social_media = $forrst||$dribbble||$twitter||$flickr||$twitter_1||$facebook||$skype||$digg||$google||$html5||$linkedin||$last_fm||$vimeo||$yahoo||$tumblr||$apple||$windows||$youtube||$delicious||$rss||$picasa||$deviantart||$technorati||$stumbleupon||$blogger||$wordpress||$amazon||$appstore||$paypal||$myspace||$dropbox||$windows8||$pinterest||$soundcloud||$google_drive||$android||$behance||$instagram||$ebay||$google_plus||$forrst1||$dribbble1||$twitter1||$flickr1||$twitter_11||$facebook1||$skype1||$digg1||$google1||$html51||$linkedin1||$last_fm1||$vimeo1||$yahoo1||$tumblr1||$apple1||$windows1||$youtube1||$delicious1||$rss1||$picasa1||$deviantart1||$technorati1||$stumbleupon1||$blogger1||$wordpress1||$amazon1||$appstore1||$paypal1||$myspace1||$dropbox1||$windows81||$pinterest1||$soundcloud1||$google_drive1||$android1||$behance1||$instagram1||$ebay1||$google_plus1;

$footer_meta_color = ot_get_option('footer_meta_color');
$column1 = ot_get_option('fm_column1');
$column2 = ot_get_option('fm_column2');
$column3 = ot_get_option('fm_column3');
$column4 = ot_get_option('fm_column4');
$sm_label = ot_get_option('sm_label');
	
$column_1 = ($social_media)||$column1;

if($column_1&&$column2&&$column3&&$column4){
	$column_type = "col-md-3";
} elseif($column_1&&$column2&&$column3){
	$column_type = "col-md-4";
} elseif($column_1&&$column2){
	$column_type = "col-md-6";
}else{
	$column_type = "col-md-12";
}

$footer_meta_a_type = ot_get_option('footer_meta_a_type');
$footer_meta_a_speed = ot_get_option('footer_meta_a_speed');
$footer_meta_a_delay = ot_get_option('footer_meta_a_delay');
$footer_meta_a_offset = ot_get_option('footer_meta_a_offset');
$footer_meta_a_easing = ot_get_option('footer_meta_a_easing');

if(!$footer_meta_a_speed){
	$footer_meta_a_speed = '1000';
}
if(!$footer_meta_a_delay){
	$footer_meta_a_delay = '0';
}

if(!$footer_meta_a_offset){
	$footer_meta_a_offset = '80';
}

$animation_att = ' data-animation="'.$footer_meta_a_type.'" data-speed="'.$footer_meta_a_speed.'" data-delay="'.$footer_meta_a_delay.'" data-offset="'.$footer_meta_a_offset.'" data-easing="'.$footer_meta_a_easing.'"';

?>

<?php $footer_meta_background = ot_get_option('footer_meta_background');?>
<?php $fm_custom_pattern = ot_get_option('fm_custom_pattern');?>

	<?php if($column_1||$column2||$column3||$column4){?>
	<div class="footer-meta<?php if ($footer_meta_background) { ?> footer-meta-pattern-bg<?php } ?>"<?php if ($footer_meta_color||$footer_meta_background=='custom') {?> style="background-color:<?php echo $footer_meta_color;?>;<?php if ($fm_custom_pattern) {?>background-image:url(<?php echo $fm_custom_pattern;?>);<?php } ?>"<?php } ?>>
		<div class="footer-meta-border-top"></div>
		<div class="footer-meta-border-bottom"></div>
		<div class="container">
			<div class="row">
				<?php if($column_1){?>
				<div class="<?php echo $column_type;?><?php if($footer_meta_a_type){?> cre-animate<?php }?>"<?php if($footer_meta_a_type){ echo $animation_att;}?>>
					<?php if($social_media){?>
					<div class="social-media clearfix lpd-animated-link">
					
						<?php if($sm_label){?><span class="sm_label"><?php echo $sm_label;?></span><?php }?>
						<?php get_template_part('includes/footer_social_media' ) ?>
						
					</div>
					<?php }else{?>
						<div class="item"><?php echo do_shortcode($column1);?></div>
					<?php }?>
				</div>
				<?php }?>
				<?php if($column2){?>
					<div class="<?php echo $column_type;?><?php if($footer_meta_a_type){?> cre-animate<?php }?>"<?php if($footer_meta_a_type){ echo $animation_att;}?>><div class="item"><?php echo do_shortcode($column2);?></div></div>
				<?php }?>
				<?php if($column3){?>
					<div class="<?php echo $column_type;?><?php if($footer_meta_a_type){?> cre-animate<?php }?>"<?php if($footer_meta_a_type){ echo $animation_att;}?>><div class="item"><?php echo do_shortcode($column3);?></div></div>
				<?php }?>
				<?php if($column4){?>
					<div class="<?php echo $column_type;?><?php if($footer_meta_a_type){?> cre-animate<?php }?>"<?php if($footer_meta_a_type){ echo $animation_att;}?>><div class="item"><?php echo do_shortcode($column4);?></div></div>
				<?php }?>
			</div>
		</div>
	</div>
	<?php }?>