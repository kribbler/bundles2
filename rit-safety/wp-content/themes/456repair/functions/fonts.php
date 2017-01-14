<?php function lpd_fonts_styles() {
	
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	
?>

<?php $body_font_family = ot_get_option('body_font_family');
	
	if ($body_font_family==""){
		$body_font_family = "Raleway";
	}
?>

<?php $heading_font_family = ot_get_option('heading_font_family');
	
	if ($heading_font_family==""){
		$heading_font_family = "Raleway";
	}
?>

<?php $elements_font_family = ot_get_option('elements_font_family');
	
	if ($elements_font_family==""){
		$elements_font_family = "Lato";
	}
?>

<?php $body_font_size  = ot_get_option('body_font_size');
	
	if ($body_font_size == ""){
		$body_font_size  = "13";
	}
?>

<?php $navigation_font_size  = ot_get_option('navigation_font_size');
	
	if ($navigation_font_size == ""){
		$navigation_font_size  = "13";
	}
?>

<?php $dropdown_font_size  = ot_get_option('dropdown_font_size');
	
	if ($dropdown_font_size == ""){
		$dropdown_font_size  = "13";
	}
?>

<?php $navigation_font_style  = ot_get_option('navigation_font_style');
	
	if ($navigation_font_style == ""){
		$navigation_font_style  = "700";
	}
?>

<?php $dropdown_font_style  = ot_get_option('dropdown_font_style');
	
	if ($dropdown_font_style == ""){
		$dropdown_font_style  = "normal";
	}
?>

<?php $bold_elements_font_style  = ot_get_option('bold_elements_font_style');
	
	if ($bold_elements_font_style == ""){
		$bold_elements_font_style  = "900";
	}
?>

<style>
.lpd-shopping-cart .lpd-cart-total span,
.lpd-cart-list-title a,
.comment-author{
	font-weight: <?php echo $bold_elements_font_style;?>;
}
.menu3dmega > ul > li > a, .menu3dmega > ul > li > span{
	font-weight: <?php echo $navigation_font_style;?>;
	font-size: <?php echo $navigation_font_size;?>px;
}
.menu3dmega > ul ul li > a{
	font-weight: <?php echo $dropdown_font_style;?>;
	font-size: <?php echo $dropdown_font_size;?>px;
}
.form-control,
body{
	font-size: <?php echo $body_font_size;?>px;
}
.header-content-wrap,.widget .title,.comment-author,.btn,.tagcloud a,.tags a,.footer-menu,.footer-meta,#footer .footer-meta .social-media,.menu3dmega .menu-title,.halflings-icon-list,.lpd_header_content.font_type_2,.wordpress-456repair .wpb_toggle, .wordpress-456repair #content h4.wpb_toggle,.wordpress-456repair .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header,.mm5_title,.mm4_title,.mm3_description,.mm2_description,.mm1_description,.featured-module-3-content .featured-module-3-label,
.owl-theme .owl-controls,.vc_lpd_testiomonial .testiomonial_content .tc_title,.tmc_title,.iconitem h5.title,.wpb_content_element .messagebox_text,.lpd-banner .lpd-b-sub-title,.cbp-l-project-details-list .amount,.lpd-cbp-product-price,ul.lpd-products li.type-product .price,.lpd-product-thumbnail .loop-shop-btn,.lpd-out-of-s,.lpd-onsale,.wordpress-456repair .woocommerce #content div.product p.price, .wordpress-456repair .woocommerce #content div.product span.price, .wordpress-456repair .woocommerce div.product p.price, .wordpress-456repair .woocommerce div.product span.price, .wordpress-456repair.woocommerce-page #content div.product p.price, .wordpress-456repair.woocommerce-page #content div.product span.price, .wordpress-456repair.woocommerce-page div.product p.price, .wordpress-456repair.woocommerce-page div.product span.price,.wordpress-456repair.woocommerce-page div.product form.cart .group_table td.price .price-wrap,.wordpress-456repair .woocommerce ul.product_list_widget li .amount,.wordpress-456repair.woocommerce-page ul.product_list_widget li .amount,.wordpress-456repair .woocommerce .widget_price_filter .price_slider_amount,.wordpress-456repair.woocommerce-page .widget_price_filter .price_slider_amount,.wordpress-456repair.woocommerce-page .quantity,.lpd-shopping-cart .lpd-cart-total span,.lpd-cart-list-meta .quantity,.cart-icon .count,.cart-button-total{
	font-family:
    <?php if($elements_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($elements_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($elements_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($elements_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($elements_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($elements_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Unna'){
        echo "'Unna', serif";
    }elseif($elements_font_family == 'Rokkitt'){
        echo "'Rokkitt', serif";
    }elseif($elements_font_family == 'Merriweather'){
        echo "'Merriweather', serif";
    }elseif($elements_font_family == 'Bitter'){
        echo "'Bitter', serif";
    }elseif($elements_font_family == 'Kreon'){
        echo "'Kreon', serif";
    }elseif($elements_font_family == 'Playfair+Display'){
        echo "'Playfair Display', serif";
    }elseif($elements_font_family == 'Roboto+Slab'){
        echo "'Roboto Slab', serif";
    }elseif($elements_font_family == 'Bree+Serif'){
        echo "'Bree Serif', serif";
    }elseif($elements_font_family == 'Libre+Baskerville'){
        echo "'Libre Baskerville', serif";
    }elseif($elements_font_family == 'Cantata+One'){
        echo "'Cantata One', serif";
    }elseif($elements_font_family == 'Alegreya'){
        echo "'Alegreya', serif";
    }elseif($elements_font_family == 'Noto+Serif'){
        echo "'Noto Serif', serif";
    }elseif($elements_font_family == 'EB+Garamond'){
        echo "'EB Garamond', serif";
    }elseif($elements_font_family == 'Noticia+Text'){
        echo "'Noticia Text', serif";
    }elseif($elements_font_family == 'Old+Standard+TT'){
        echo "'Old Standard TT', serif";
    }elseif($elements_font_family == 'Crimson+Text'){
        echo "'Crimson Text', serif";
    }elseif($elements_font_family == 'Josefin+Sans'){
        echo "'Josefin Sans','Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($elements_font_family == 'Ubuntu'){
        echo "'Ubuntu','Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $elements_font_family; 
    }?>;
}
body{
	font-family:
    <?php if($body_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($body_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($body_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($body_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($body_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($body_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Unna'){
        echo "'Unna', serif";
    }elseif($body_font_family == 'Rokkitt'){
        echo "'Rokkitt', serif";
    }elseif($body_font_family == 'Merriweather'){
        echo "'Merriweather', serif";
    }elseif($body_font_family == 'Bitter'){
        echo "'Bitter', serif";
    }elseif($body_font_family == 'Kreon'){
        echo "'Kreon', serif";
    }elseif($body_font_family == 'Playfair+Display'){
        echo "'Playfair Display', serif";
    }elseif($body_font_family == 'Roboto+Slab'){
        echo "'Roboto Slab', serif";
    }elseif($body_font_family == 'Bree+Serif'){
        echo "'Bree Serif', serif";
    }elseif($body_font_family == 'Libre+Baskerville'){
        echo "'Libre Baskerville', serif";
    }elseif($body_font_family == 'Cantata+One'){
        echo "'Cantata One', serif";
    }elseif($body_font_family == 'Alegreya'){
        echo "'Alegreya', serif";
    }elseif($body_font_family == 'Noto+Serif'){
        echo "'Noto Serif', serif";
    }elseif($body_font_family == 'EB+Garamond'){
        echo "'EB Garamond', serif";
    }elseif($body_font_family == 'Noticia+Text'){
        echo "'Noticia Text', serif";
    }elseif($body_font_family == 'Old+Standard+TT'){
        echo "'Old Standard TT', serif";
    }elseif($body_font_family == 'Crimson+Text'){
        echo "'Crimson Text', serif";
    }elseif($body_font_family == 'Josefin+Sans'){
        echo "'Josefin Sans','Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_font_family == 'Ubuntu'){
        echo "'Ubuntu','Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $body_font_family; 
    }?>;
}
h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{
	font-family:
    <?php if($heading_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($heading_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($heading_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($heading_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($heading_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($heading_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Unna'){
        echo "'Unna', serif";
    }elseif($heading_font_family == 'Rokkitt'){
        echo "'Rokkitt', serif";
    }elseif($heading_font_family == 'Merriweather'){
        echo "'Merriweather', serif";
    }elseif($heading_font_family == 'Bitter'){
        echo "'Bitter', serif";
    }elseif($heading_font_family == 'Kreon'){
        echo "'Kreon', serif";
    }elseif($heading_font_family == 'Playfair+Display'){
        echo "'Playfair Display', serif";
    }elseif($heading_font_family == 'Roboto+Slab'){
        echo "'Roboto Slab', serif";
    }elseif($heading_font_family == 'Bree+Serif'){
        echo "'Bree Serif', serif";
    }elseif($heading_font_family == 'Libre+Baskerville'){
        echo "'Libre Baskerville', serif";
    }elseif($heading_font_family == 'Cantata+One'){
        echo "'Cantata One', serif";
    }elseif($heading_font_family == 'Alegreya'){
        echo "'Alegreya', serif";
    }elseif($heading_font_family == 'Noto+Serif'){
        echo "'Noto Serif', serif";
    }elseif($heading_font_family == 'EB+Garamond'){
        echo "'EB Garamond', serif";
    }elseif($heading_font_family == 'Noticia+Text'){
        echo "'Noticia Text', serif";
    }elseif($heading_font_family == 'Old+Standard+TT'){
        echo "'Old Standard TT', serif";
    }elseif($heading_font_family == 'Crimson+Text'){
        echo "'Crimson Text', serif";
    }elseif($heading_font_family == 'Josefin+Sans'){
        echo "'Josefin Sans','Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($heading_font_family == 'Ubuntu'){
        echo "'Ubuntu','Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $heading_font_family; 
    }?>;
}
</style>

<?php }?>
<?php add_action( 'wp_head', 'lpd_fonts_styles' );?>