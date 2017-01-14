<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Footer Meta Widget
	Plugin URI: http://www.lpd-themes.com
	Description: A widget that allows to display footer meta (only for footer meta sidebar).
	Version: 1.0
	Author: lidplussdesign
	Author URI: http://www.lpd-themes.com

-----------------------------------------------------------------------------------*/


// add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'footer_meta_widget' );


// register widget.
function footer_meta_widget() {
	register_widget( 'Footer_Meta_Widget' );
}

// widget class.
class footer_meta_widget extends WP_Widget {


/* widget setup
================================================== */
	function Footer_Meta_Widget() {
	
		/* widget settings. */
		$widget_ops = array( 'classname' => 'footer_meta_widget', 'description' => __('A widget that allows to display footer meta (only for footer meta sidebar).', GETTEXT_DOMAIN) );

		/* widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'footer_meta_widget' );

		/* create the widget. */
		$this->WP_Widget( 'footer_meta_widget', __('Footer Meta Widget', GETTEXT_DOMAIN), $widget_ops, $control_ops );
	}

/* display widget
================================================== */	
	function widget( $args, $instance ) {
		extract( $args );

//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');

    /* Social Media
    ================================================== */
    $disable_social = get_option_tree('disable_social',$theme_options);
	$_500px = get_option_tree('500px',$theme_options);
	$about_me = get_option_tree('about_me',$theme_options);
	$add_this = get_option_tree('add_this',$theme_options);
	$amazon = get_option_tree('amazon',$theme_options);
	$aol = get_option_tree('aol',$theme_options);
	$app_store_alt = get_option_tree('app_store_alt',$theme_options);
	$app_store = get_option_tree('app_store',$theme_options);
	$apple = get_option_tree('apple',$theme_options);
	$bebo = get_option_tree('bebo',$theme_options);
	$behance = get_option_tree('behance',$theme_options);
	$bing = get_option_tree('bing',$theme_options);
	$blip = get_option_tree('blip',$theme_options);
	$blogger = get_option_tree('blogger',$theme_options);
	$coroflot = get_option_tree('coroflot',$theme_options);
	$daytum = get_option_tree('daytum',$theme_options);
	$delicious = get_option_tree('delicious',$theme_options);
	$design_bump = get_option_tree('design_bump',$theme_options);
	$designfloat = get_option_tree('designfloat',$theme_options);
	$deviant_art = get_option_tree('deviant_art',$theme_options);
	$digg_alt = get_option_tree('digg_alt',$theme_options);
	$digg = get_option_tree('digg',$theme_options);
	$dribbble = get_option_tree('dribbble',$theme_options);
	$drupal = get_option_tree('drupal',$theme_options);
	$ebay = get_option_tree('ebay',$theme_options);
	$email = get_option_tree('email',$theme_options);
	$ember_app = get_option_tree('ember_app',$theme_options);
	$etsy = get_option_tree('etsy',$theme_options);
	$facebook = get_option_tree('facebook',$theme_options);
	$feed_burner = get_option_tree('feed_burner',$theme_options);
	$flickr = get_option_tree('flickr',$theme_options);
	$foodspotting = get_option_tree('foodspotting',$theme_options);
	$forrst = get_option_tree('forrst',$theme_options);
	$foursquare = get_option_tree('foursquare',$theme_options);
	$friendsfeed = get_option_tree('friendsfeed',$theme_options);
	$friendstar = get_option_tree('friendstar',$theme_options);
	$gdgt = get_option_tree('gdgt',$theme_options);
	$github = get_option_tree('github',$theme_options);
	$google_buzz = get_option_tree('google_buzz',$theme_options);
	$google_talk = get_option_tree('google_talk',$theme_options);
	$gowalla_pin = get_option_tree('gowalla_pin',$theme_options);
	$gowalla = get_option_tree('gowalla',$theme_options);
	$grooveshark = get_option_tree('grooveshark',$theme_options);
	$heart = get_option_tree('heart',$theme_options);
	$hyves = get_option_tree('hyves',$theme_options);
	$icondock = get_option_tree('icondock',$theme_options);
	$icq = get_option_tree('icq',$theme_options);
	$identica = get_option_tree('identica',$theme_options);
	$imessage = get_option_tree('imessage',$theme_options);
	$itune = get_option_tree('itune',$theme_options);
	$last_fm = get_option_tree('last_fm',$theme_options);
	$linkedin = get_option_tree('linkedin',$theme_options);
	$meetup = get_option_tree('meetup',$theme_options);
	$metacafe = get_option_tree('metacafe',$theme_options);
	$mixx = get_option_tree('mixx',$theme_options);
	$mobileme = get_option_tree('mobileme',$theme_options);
	$mr_wong = get_option_tree('mr_wong',$theme_options);
	$msn = get_option_tree('msn',$theme_options);
	$myspace = get_option_tree('myspace',$theme_options);
	$newsvine = get_option_tree('newsvine',$theme_options);
	$paypal = get_option_tree('paypal',$theme_options);
	$photobucket = get_option_tree('photobucket',$theme_options);
	$picasa = get_option_tree('picasa',$theme_options);
	$pinterest = get_option_tree('pinterest',$theme_options);
	$podcast = get_option_tree('podcast',$theme_options);
	$posterous = get_option_tree('posterous',$theme_options);
	$qik = get_option_tree('qik',$theme_options);
	$quora = get_option_tree('quora',$theme_options);
	$reddit = get_option_tree('reddit',$theme_options);
	$retweet = get_option_tree('retweet',$theme_options);
	$rss = get_option_tree('rss',$theme_options);
	$scribd = get_option_tree('scribd',$theme_options);
	$share_this = get_option_tree('share_this',$theme_options);
	$skype = get_option_tree('skype',$theme_options);
	$slashdot = get_option_tree('slashdot',$theme_options);
	$slideshare = get_option_tree('slideshare',$theme_options);
	$smugmug = get_option_tree('smugmug',$theme_options);
	$sound_cloud = get_option_tree('sound_cloud',$theme_options);
	$spotify = get_option_tree('spotify',$theme_options);
	$squidoo = get_option_tree('squidoo',$theme_options);
	$stackoverflow = get_option_tree('stackoverflow',$theme_options);
	$star = get_option_tree('star',$theme_options);
	$stumbleupon = get_option_tree('stumbleupon',$theme_options);
	$technorati = get_option_tree('technorati',$theme_options);
	$tumblr = get_option_tree('tumblr',$theme_options);
	$twitter_bird = get_option_tree('twitter_bird',$theme_options);
	$twitter = get_option_tree('twitter',$theme_options);
	$viddler = get_option_tree('viddler',$theme_options);
	$vimeo = get_option_tree('vimeo',$theme_options);
	$virb = get_option_tree('virb',$theme_options);
	$w3 = get_option_tree('w3',$theme_options);
	$wikipedia = get_option_tree('wikipedia',$theme_options);
	$windows = get_option_tree('windows',$theme_options);
	$wordpress = get_option_tree('wordpress',$theme_options);
	$xing = get_option_tree('xing',$theme_options);
	$yahoo_buzz = get_option_tree('yahoo_buzz',$theme_options);
	$yahoo = get_option_tree('yahoo',$theme_options);
	$yelp = get_option_tree('yelp',$theme_options);
	$youtube = get_option_tree('youtube',$theme_options);
    
    /* Footer Options
    ================================================== */
	$footer_meta_1 = $instance['footer_meta_1'];
	$footer_meta_2 = $instance['footer_meta_2'];
	$footer_meta_3 = $instance['footer_meta_3'];
	$footer_meta_4 = $instance['footer_meta_4'];    
}

		/* before widget. */
		echo $before_widget;
		
if($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1 || $footer_meta_2 || $footer_meta_3 || $footer_meta_4){?> 
			  <div class="row-fluid">
				<div class="
<?php if($footer_meta_2 && $footer_meta_3 && $footer_meta_4 ){?>
				span3
<?php }elseif($footer_meta_2 && $footer_meta_3){?>
				span4
<?php }elseif($footer_meta_2){?>
				span6
<?php }else{?>
				span12
<?php }?>				
				
<?php if($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube){?> 
				social-media
<?php }?>
				">
<?php if($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube){?>
					<div class="social-media-wrap">
						<p><?php _e( 'Social Media:', GETTEXT_DOMAIN);?></p>
						<ul>
							<?php if($_500px){?> <li><a class="icon _500px" title="500px" href="<?php echo $_500px; ?>"><span>500px</span></a></li> <?php }?>
							<?php if($about_me){?> <li><a class="icon about_me" title="about me" href="<?php echo $about_me; ?>"><span>about_me</span></a></li> <?php }?>
							<?php if($add_this){?> <li><a class="icon add_this" title="add this" href="<?php echo $add_this; ?>"><span>add_this</span></a></li> <?php }?>
							<?php if($amazon){?> <li><a class="icon amazon" title="amazon" href="<?php echo $amazon; ?>"><span>amazon</span></a></li> <?php }?>
							<?php if($aol){?> <li><a class="icon aol" title="aol" href="<?php echo $aol; ?>"><span>aol</span></a></li> <?php }?>
							<?php if($app_store_alt){?> <li><a class="icon app_store_alt" title="app store alt" href="<?php echo $app_store_alt; ?>"><span>app_store_alt</span></a></li> <?php }?>
							<?php if($app_store){?> <li><a class="icon app_store" title="app_store" href="<?php echo $app_store; ?>"><span>app_store</span></a></li> <?php }?>
							<?php if($apple){?> <li><a class="icon apple" title="apple" href="<?php echo $apple; ?>"><span>apple</span></a></li> <?php }?>
							<?php if($bebo){?> <li><a class="icon bebo" title="bebo" href="<?php echo $bebo; ?>"><span>bebo</span></a></li> <?php }?>
							<?php if($behance){?> <li><a class="icon behance" title="behance" href="<?php echo $behance; ?>"><span>behance</span></a></li> <?php }?>
							<?php if($bing){?> <li><a class="icon bing" title="bing" href="<?php echo $bing; ?>"><span>bing</span></a></li> <?php }?>
							<?php if($blip){?> <li><a class="icon blip" title="blip" href="<?php echo $blip; ?>"><span>blip</span></a></li> <?php }?>
							<?php if($blogger){?> <li><a class="icon blogger" title="blogger" href="<?php echo $blogger; ?>"><span>blogger</span></a></li> <?php }?>
							<?php if($coroflot){?> <li><a class="icon coroflot" title="coroflot" href="<?php echo $coroflot; ?>"><span>coroflot</span></a></li> <?php }?>
							<?php if($daytum){?> <li><a class="icon daytum" title="daytum" href="<?php echo $daytum; ?>"><span>daytum</span></a></li> <?php }?>
							<?php if($delicious){?> <li><a class="icon delicious" title="delicious" href="<?php echo $delicious; ?>"><span>delicious</span></a></li> <?php }?>
							<?php if($design_bump){?> <li><a class="icon design_bump" title="design bump" href="<?php echo $design_bump; ?>"><span>design_bump</span></a></li> <?php }?>
							<?php if($designfloat){?> <li><a class="icon designfloat" title="designfloat" href="<?php echo $designfloat; ?>"><span>designfloat</span></a></li> <?php }?>
							<?php if($deviant_art){?> <li><a class="icon deviant_art" title="deviant art" href="<?php echo $deviant_art; ?>"><span>deviant_art</span></a></li> <?php }?>
							<?php if($digg_alt){?> <li><a class="icon digg_alt" title="digg alt" href="<?php echo $digg_alt; ?>"><span>digg_alt</span></a></li> <?php }?>
							<?php if($digg){?> <li><a class="icon digg" title="digg" href="<?php echo $digg; ?>"><span>digg</span></a></li> <?php }?>
							<?php if($dribbble){?> <li><a class="icon dribbble" title="dribbble" href="<?php echo $dribbble; ?>"><span>dribbble</span></a></li> <?php }?>
							<?php if($drupal){?> <li><a class="icon drupal" title="drupal" href="<?php echo $drupal; ?>"><span>drupal</span></a></li> <?php }?>
							<?php if($ebay){?> <li><a class="icon ebay" title="ebay" href="<?php echo $ebay; ?>"><span>ebay</span></a></li> <?php }?>
							<?php if($email){?> <li><a class="icon email" title="email" href="<?php echo $email; ?>"><span>email</span></a></li> <?php }?>
							<?php if($ember_app){?> <li><a class="icon ember_app" title="ember app" href="<?php echo $ember_app; ?>"><span>ember_app</span></a></li> <?php }?>
							<?php if($etsy){?> <li><a class="icon etsy" title="etsy" href="<?php echo $etsy; ?>"><span>etsy</span></a></li> <?php }?>
							<?php if($facebook){?> <li><a class="icon facebook" title="facebook" href="<?php echo $facebook; ?>"><span>facebook</span></a></li> <?php }?>
							<?php if($feed_burner){?> <li><a class="icon feed_burner" title="feed burner" href="<?php echo $feed_burner; ?>"><span>feed_burner</span></a></li> <?php }?>
							<?php if($flickr){?> <li><a class="icon flickr" title="flickr" href="<?php echo $flickr; ?>"><span>flickr</span></a></li> <?php }?>
							<?php if($foodspotting){?> <li><a class="icon foodspotting" title="foodspotting" href="<?php echo foodspotting; ?>"><span>foodspotting</span></a></li> <?php }?>
							<?php if($forrst){?> <li><a class="icon forrst" title="forrst" href="<?php echo $forrst; ?>"><span>forrst</span></a></li> <?php }?>
							<?php if($foursquare){?> <li><a class="icon foursquare" title="foursquare" href="<?php echo $foursquare; ?>"><span>foursquare</span></a></li> <?php }?>
							<?php if($friendsfeed){?> <li><a class="icon friendsfeed" title="friendsfeed" href="<?php echo $friendsfeed; ?>"><span>friendsfeed</span></a></li> <?php }?>
							<?php if($friendstar){?> <li><a class="icon friendstar" title="friendstar" href="<?php echo $friendstar; ?>"><span>friendstar</span></a></li> <?php }?>
							<?php if($gdgt){?> <li><a class="icon gdgt" title="gdgt" href="<?php echo $gdgt; ?>"><span>gdgt</span></a></li> <?php }?>
							<?php if($github){?> <li><a class="icon github" title="github" href="<?php echo $github; ?>"><span>github</span></a></li> <?php }?>
							<?php if($google_buzz){?> <li><a class="icon google_buzz" title="google buzz" href="<?php echo $google_buzz; ?>"><span>google_buzz</span></a></li> <?php }?>
							<?php if($google_talk){?> <li><a class="icon google_talk" title="google talk" href="<?php echo $google_talk; ?>"><span>google_talk</span></a></li> <?php }?>
							<?php if($gowalla_pin){?> <li><a class="icon gowalla_pin" title="gowalla pin" href="<?php echo $gowalla_pin; ?>"><span>gowalla_pin</span></a></li> <?php }?>
							<?php if($_gowalla){?> <li><a class="icon _gowalla" title="gowalla" href="<?php echo $gowalla; ?>"><span>gowalla</span></a></li> <?php }?>
							<?php if($_grooveshark){?> <li><a class="icon _grooveshark" title="grooveshark" href="<?php echo $grooveshark; ?>"><span>grooveshark</span></a></li> <?php }?>
							<?php if($heart){?> <li><a class="icon heart" title="heart" href="<?php echo $heart; ?>"><span>heart</span></a></li> <?php }?>
							<?php if($hyves){?> <li><a class="icon hyves" title="hyves" href="<?php echo $hyves; ?>"><span>hyves</span></a></li> <?php }?>
							<?php if($icondock){?> <li><a class="icon icondock" title="icondock" href="<?php echo $icondock; ?>"><span>icondock</span></a></li> <?php }?>
							<?php if($icq){?> <li><a class="icon icq" title="icq" href="<?php echo $icq; ?>"><span>icq</span></a></li> <?php }?>
							<?php if($identica){?> <li><a class="icon identica" title="identica" href="<?php echo $identica; ?>"><span>identica</span></a></li> <?php }?>
							<?php if($imessage){?> <li><a class="icon imessage" title="imessage" href="<?php echo $imessage; ?>"><span>imessage</span></a></li> <?php }?>
							<?php if($itune){?> <li><a class="icon itune" title="itune" href="<?php echo $itune; ?>"><span>itune</span></a></li> <?php }?>
							<?php if($last_fm){?> <li><a class="icon last_fm" title="last fm" href="<?php echo $last_fm; ?>"><span>last_fm</span></a></li> <?php }?>
							<?php if($linkedin){?> <li><a class="icon linkedin" title="linkedin" href="<?php echo $linkedin; ?>"><span>linkedin</span></a></li> <?php }?>
							<?php if($meetup){?> <li><a class="icon meetup" title="meetup" href="<?php echo $meetup; ?>"><span>meetup</span></a></li> <?php }?>
							<?php if($metacafe){?> <li><a class="icon metacafe" title="metacafe" href="<?php echo $metacafe; ?>"><span>metacafe</span></a></li> <?php }?>
							<?php if($mixx){?> <li><a class="icon mixx" title="mixx" href="<?php echo $mixx; ?>"><span>mixx</span></a></li> <?php }?>
							<?php if($mobileme){?> <li><a class="icon mobileme" title="mobileme" href="<?php echo $mobileme; ?>"><span>mobileme</span></a></li> <?php }?>
							<?php if($mr_wong){?> <li><a class="icon mr_wong" title="mr wong" href="<?php echo $mr_wong; ?>"><span>mr_wong</span></a></li> <?php }?>
							<?php if($msn){?> <li><a class="icon msn" title="msn" href="<?php echo $msn; ?>"><span>msn</span></a></li> <?php }?>
							<?php if($myspace){?> <li><a class="icon myspace" title="myspace" href="<?php echo $myspace; ?>"><span>myspace</span></a></li> <?php }?>
							<?php if($newsvine){?> <li><a class="icon newsvine" title="newsvine" href="<?php echo $newsvine; ?>"><span>newsvine</span></a></li> <?php }?>
							<?php if($paypal){?> <li><a class="icon paypal" title="paypal" href="<?php echo $paypal; ?>"><span>paypal</span></a></li> <?php }?>
							<?php if($photobucket){?> <li><a class="icon photobucket" title="photobucket" href="<?php echo $photobucket; ?>"><span>photobucket</span></a></li> <?php }?>
							<?php if($picasa){?> <li><a class="icon picasa" title="picasa" href="<?php echo $picasa; ?>"><span>picasa</span></a></li> <?php }?>
							<?php if($pinterest){?> <li><a class="icon pinterest" title="pinterest" href="<?php echo $pinterest; ?>"><span>pinterest</span></a></li> <?php }?>
							<?php if($podcast){?> <li><a class="icon podcast" title="podcast" href="<?php echo $podcast; ?>"><span>podcast</span></a></li> <?php }?>
							<?php if($posterous){?> <li><a class="icon posterous" title="posterous" href="<?php echo $posterous; ?>"><span>posterous</span></a></li> <?php }?>
							<?php if($qik){?> <li><a class="icon qik" title="qik" href="<?php echo $qik; ?>"><span>qik</span></a></li> <?php }?>
							<?php if($quora){?> <li><a class="icon quora" title="quora" href="<?php echo $quora; ?>"><span>quora</span></a></li> <?php }?>
							<?php if($reddit){?> <li><a class="icon reddit" title="reddit" href="<?php echo $reddit; ?>"><span>reddit</span></a></li> <?php }?>
							<?php if($retweet){?> <li><a class="icon retweet" title="retweet" href="<?php echo $retweet; ?>"><span>retweet</span></a></li> <?php }?>
							<?php if($rss){?> <li><a class="icon rss" title="rss" href="<?php echo $rss; ?>"><span>rss</span></a></li> <?php }?>
							<?php if($scribd){?> <li><a class="icon scribd" title="scribd" href="<?php echo $scribd; ?>"><span>scribd</span></a></li> <?php }?>
							<?php if($share_this){?> <li><a class="icon share_this" title="share this" href="<?php echo $share_this; ?>"><span>share_this</span></a></li> <?php }?>
							<?php if($skype){?> <li><a class="icon skype" title="skype" href="<?php echo $skype; ?>"><span>skype</span></a></li> <?php }?>
							<?php if($slashdot){?> <li><a class="icon slashdot" title="slashdot" href="<?php echo $slashdot; ?>"><span>slashdot</span></a></li> <?php }?>
							<?php if($smugmug){?> <li><a class="icon smugmug" title="smugmug" href="<?php echo $smugmug; ?>"><span>smugmug</span></a></li> <?php }?>
							<?php if($sound_cloud){?> <li><a class="icon sound_cloud" title="sound cloud" href="<?php echo $sound_cloud; ?>"><span>sound_cloud</span></a></li> <?php }?>
							<?php if($spotify){?> <li><a class="icon spotify" title="spotify" href="<?php echo $spotify; ?>"><span>spotify</span></a></li> <?php }?>
							<?php if($squidoo){?> <li><a class="icon squidoo" title="squidoo" href="<?php echo $squidoo; ?>"><span>squidoo</span></a></li> <?php }?>
							<?php if($stackoverflow){?> <li><a class="icon stackoverflow" title="stackoverflow" href="<?php echo $stackoverflow; ?>"><span>stackoverflow</span></a></li> <?php }?>
							<?php if($star){?> <li><a class="icon star" title="star" href="<?php echo $star; ?>"><span>star</span></a></li> <?php }?>
							<?php if($stumbleupon){?> <li><a class="icon stumbleupon" title="stumbleupon" href="<?php echo $stumbleupon; ?>"><span>stumbleupon</span></a></li> <?php }?>
							<?php if($technorati){?> <li><a class="icon technorati" title="technorati" href="<?php echo $technorati; ?>"><span>technorati</span></a></li> <?php }?>
							<?php if($tumblr){?> <li><a class="icon tumblr" title="tumblr" href="<?php echo $tumblr; ?>"><span>tumblr</span></a></li> <?php }?>
							<?php if($twitter_bird){?> <li><a class="icon twitter_bird" title="twitter bird" href="<?php echo $twitter_bird; ?>"><span>twitter_bird</span></a></li> <?php }?>
							<?php if($twitter){?> <li><a class="icon twitter" title="twitter" href="<?php echo $twitter; ?>"><span>twitter</span></a></li> <?php }?>
							<?php if($viddler){?> <li><a class="icon viddler" title="viddler" href="<?php echo $viddler; ?>"><span>viddler</span></a></li> <?php }?>
							<?php if($vimeo){?> <li><a class="icon vimeo" title="vimeo" href="<?php echo $vimeo; ?>"><span>vimeo</span></a></li> <?php }?>
							<?php if($virb){?> <li><a class="icon virb" title="virb" href="<?php echo $virb; ?>"><span>virb</span></a></li> <?php }?>
							<?php if($w3){?> <li><a class="icon w3" title="w3" href="<?php echo $w3; ?>"><span>w3</span></a></li> <?php }?>
							<?php if($wikipedia){?> <li><a class="icon wikipedia" title="wikipedia" href="<?php echo $wikipedia; ?>"><span>wikipedia</span></a></li> <?php }?>
							<?php if($windows){?> <li><a class="icon windows" title="windows" href="<?php echo $windows; ?>"><span>windows</span></a></li> <?php }?>
							<?php if($wordpress){?> <li><a class="icon wordpress" title="wordpress" href="<?php echo $wordpress; ?>"><span>wordpress</span></a></li> <?php }?>
							<?php if($xing){?> <li><a class="icon xing" title="xing" href="<?php echo $xing; ?>"><span>xing</span></a></li> <?php }?>
							<?php if($yahoo_buzz){?> <li><a class="icon yahoo_buzz" title="yahoo buzz" href="<?php echo $yahoo_buzz; ?>"><span>yahoo_buzz</span></a></li> <?php }?>
							<?php if($yahoo){?> <li><a class="icon yahoo" title="yahoo" href="<?php echo $yahoo; ?>"><span>yahoo</span></a></li> <?php }?>
							<?php if($yelp){?> <li><a class="icon yelp" title="yelp" href="<?php echo $yelp; ?>"><span>yelp</span></a></li> <?php }?>
							<?php if($youtube){?> <li><a class="icon youtube" title="youtube" href="<?php echo $youtube; ?>"><span>youtube</span></a></li> <?php }?>
						</ul>
					<div class="clearfix"></div>
					</div>
<?php }elseif($footer_meta_1){?><div class="item"><?php echo do_shortcode($footer_meta_1);?></div><?php }?>					
				</div>
				<?php if($footer_meta_2){?><div class="
<?php if(($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1) && $footer_meta_3 && $footer_meta_4){?>
				span3
<?php }elseif(($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1) && $footer_meta_3){?>
				span4
<?php }elseif($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1){?>
				span6
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($footer_meta_2);?></div></div><?php }?>
				<?php if($footer_meta_3){?><div class="
<?php if(($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1) && $footer_meta_2 && $footer_meta_4){?>
				span3
<?php }elseif(($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1) && $footer_meta_2){?>
				span4
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($footer_meta_3);?></div></div><?php }?>
				<?php if($footer_meta_4){?><div class="
<?php if(($_500px || $about_me || $add_this || $amazon || $aol || $app_store_alt || $app_store || $apple || $bebo || $behance || $bing || $blip || $blogger || $coroflot || $daytum || $delicious || $design_bump || $designfloat || $deviant_art || $digg_alt || $digg || $dribbble || $drupal || $ebay || $email || $ember_app || $etsy || $facebook || $feed_burner || $flickr || $foodspotting || $forrst || $foursquare || $friendsfeed || $friendstar || $gdgt || $github || $google_buzz || $google_talk || $gowalla_pin || $gowalla || $grooveshark || $heart || $hyves || $icondock || $icq || $identica || $imessage || $itune || $last_fm || $linkedin || $meetup || $metacafe || $mixx || $mobileme || $mr_wong || $msn || $myspace || $newsvine || $paypal || $photobucket || $picasa || $pinterest || $podcast || $posterous || $qik || $quora || $reddit || $retweet || $rss || $scribd || $share_this || $skype || $slashdot || $slideshare || $smugmug || $sound_cloud || $spotify || $squidoo || $stackoverflow || $star || $stumbleupon || $technorati || $tumblr || $twitter_bird || $twitter || $viddler || $vimeo || $virb || $w3 || $wikipedia || $windows || $wordpress || $xing || $yahoo_buzz || $yahoo || $yelp || $youtube || $footer_meta_1) && $footer_meta_2 && $footer_meta_3){?>
				span3
<?php }else{?>
				span12
<?php }?>
				"><div class="item"><?php echo do_shortcode($footer_meta_4);?></div></div><?php }?>
			  </div>
<?php }

		/* after widget (defined by themes). */
		echo $after_widget;
	}


/* widget update
================================================== */
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['footer_meta_1'] =  $new_instance['footer_meta_1'];
		$instance['footer_meta_2'] =  $new_instance['footer_meta_2'];
		$instance['footer_meta_3'] =  $new_instance['footer_meta_3'];
		$instance['footer_meta_4'] =  $new_instance['footer_meta_4'];
        
		/* no need to strip tags for.. */

		return $instance;
	}
	

/* widget settings
================================================== */
	 
	function form( $instance ) {

		/* set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'footer_meta_1' ); ?>"><?php _e('Column 1', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('footer_meta_1'); ?>" name="<?php echo $this->get_field_name('footer_meta_1'); ?>"><?php echo $instance['footer_meta_1']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'footer_meta_2' ); ?>"><?php _e('Column 2', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('footer_meta_2'); ?>" name="<?php echo $this->get_field_name('footer_meta_2'); ?>"><?php echo $instance['footer_meta_2']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'footer_meta_3' ); ?>"><?php _e('Column 3', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('footer_meta_3'); ?>" name="<?php echo $this->get_field_name('footer_meta_3'); ?>"><?php echo $instance['footer_meta_3']; ?></textarea>
        <p>
        
        <!-- textarea -->
        <p>
			<label for="<?php echo $this->get_field_id( 'footer_meta_4' ); ?>"><?php _e('Column 4', GETTEXT_DOMAIN) ?>:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('footer_meta_4'); ?>" name="<?php echo $this->get_field_name('footer_meta_4'); ?>"><?php echo $instance['footer_meta_4']; ?></textarea>
        <p>

	
	<?php
	}
}
?>