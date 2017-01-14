<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    
    /* Typography
    ================================================== */
    $body_font_size = get_option_tree('body_font_size',$theme_options);
    $input_font_size = get_option_tree('input_font_size',$theme_options);
    $navigation_font_size = get_option_tree('navigation_font_size',$theme_options);
    $navigation_font_style = get_option_tree('navigation_font_style',$theme_options);
    $dropdown_font_size = get_option_tree('dropdown_font_size',$theme_options);
    $dropdown_font_style = get_option_tree('dropdown_font_style',$theme_options);
    $meta_font_size = get_option_tree('meta_font_size',$theme_options);
    
    $body_font_family = get_option_tree('body_font_family',$theme_options);
    $body_2_font_family = get_option_tree('body_2_font_family',$theme_options);
    $elements_font_family = get_option_tree('elements_font_family',$theme_options);
    $navigation_font_family = get_option_tree('navigation_font_family',$theme_options);
    $input_font_family = get_option_tree('input_font_family',$theme_options);

}
?>

<?php if($body_font_size != ''||$input_font_size != ''||$navigation_font_size!= ''||$navigation_font_style != 'bold'||$dropdown_font_size != ''||$dropdown_font_style != 'bold'||$meta_font_size != ''){?>
<style>
<?php if($body_font_size != ''){?>
/* woocommerce body font size
}*/
.woocommerce-456market .woocommerce table.my_account_orders,
.woocommerce-456market .woocommerce-page table.my_account_orders,
.woocommerce-456market .woocommerce-message a.button,
.woocommerce-456market .woocommerce-error a.button,
.woocommerce-456market .woocommerce-info a.button{
	font-size:
	<?php if($body_font_size){?>
		<?php echo $body_font_size;?>px;
	<?php }else{?>
		13px;
	<?php }?>
}

/* application body font size
}*/
#lang_sel_list a,
#lang_sel_list a:visited,
body{
	font-size:
	<?php if($body_font_size){?>
		<?php echo $body_font_size;?>px;
	<?php }else{?>
		13px;
	<?php }?>
}
<?php }?>

<?php if($input_font_size != ''){?>
/* application body font size
}*/
textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input, .chzn-container{ 
	font-size:
	<?php if($input_font_size){?>
		<?php echo $input_font_size;?>px !important;
	<?php }else{?>
		12px !important;
	<?php }?>
}
<?php }?>

<?php if($navigation_font_size != ''){?>
/* application body font size
}*/
.shopping-cart .title,
.navbar .menu-item-language a,
.navbar .nav > li > a{
	font-size:
	<?php if($navigation_font_size){?>
		<?php echo $navigation_font_size;?>px;
	<?php }else{?>
		12px;
	<?php }?>
}
<?php }?>

<?php if($dropdown_font_size != ''){?>
/* bootstrap body font size
}*/
.dropdown-menu > li > a{
	font-size:
	<?php if($dropdown_font_size){?>
		<?php echo $dropdown_font_size;?>px;
	<?php }else{?>
		13px;
	<?php }?>
}
<?php }?>

<?php if($navigation_font_style != 'bold'){?>
/* application body font size
}*/
.shopping-cart .title,
.navbar .menu-item-language a,
.navbar.bold-font .nav > li > a{
	font-weight: normal;
}
<?php }?>

<?php if($dropdown_font_style != 'bold'){?>
/* application body font size
}*/
.bold-font-dropdown-menu .dropdown-menu > li > a{
	font-weight: normal;
}
<?php }?>

<?php if($meta_font_size != ''){?>
/* application body font size
}*/
#meta{
	font-size:
	<?php if($meta_font_size){?>
		<?php echo $meta_font_size;?>px;
	<?php }else{?>
		12px;
	<?php }?>
}
<?php }?>

</style>
<?php }?>

<?php if($body_font_family != ''||$body_2_font_family != ''||$elements_font_family != ''||$navigation_font_family != ''||$input_font_family != ''){?>
<style>

<?php if($body_font_family != ''){?>
/* woocommerce body
}*/
.woocommerce-456market .woocommerce-message a.button,
.woocommerce-456market .woocommerce-error a.button,
.woocommerce-456market .woocommerce-info a.button{
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
    }else{
       echo $body_font_family; 
    }?>;
}

/* application body
}*/
button,
select,
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
    }else{
       echo $body_font_family; 
    }?>;
}
<?php }?>

<?php if($body_2_font_family != ''){?>
/* woocommerce
}*/
.woocommerce-456market a#cloud-link,
.woocommerce-456market .woo_compare_clear_all_container a,
.woocommerce-456market #wl-wrapper .wl-manage .row-actions small a,
.woocommerce-456market #wl-wrapper .wl-tabs > li,
.woocommerce-account #wl-wrapper h2,
.woo_compare_button_container1 .woo_bt_compare_this_button,
#wl-wrapper.woocommerce-456market .button1,
.woocommerce-456market .woocommerce .addresses .title h3,
.woocommerce-456market .woocommerce-page .addresses .title h3,
.my-account-title,
#checkout-accordion .accordion-heading,
.woocommerce-456market .woocommerce-message,
.woocommerce-456market .woocommerce-error,
.woocommerce-456market .woocommerce-info,
#order_review_heading,
.cart_totals h4,
.shipping_calculator h4,
.woocommerce-456market.woocommerce div.product form.cart table small.stock,
.woocommerce-456market.woocommerce-page div.product form.cart table small.stock,
.woocommerce-456market.woocommerce #content div.product form.cart table small.stock,
.woocommerce-456market.woocommerce-page #content div.product form.cart table small.stock,
.woocommerce-456market.woocommerce div.product p.stock,
.woocommerce-456market.woocommerce-page div.product p.stock,
.woocommerce-456market.woocommerce #content div.product p.stock,
.woocommerce-456market.woocommerce-page #content div.product p.stock,
.woocommerce-456market.woocommerce .woocommerce-tabs #reviews #comments ol.commentlist li .comment-text p.meta time,
.woocommerce-456market.woocommerce-page .woocommerce-tabs #reviews #comments ol.commentlist li .comment-text p.meta time
.woocommerce-456market.woocommerce div.product .woocommerce-tabs ul.tabs li a,
.woocommerce-456market.woocommerce-page div.product .woocommerce-tabs ul.tabs li a,
.woocommerce-456market.woocommerce #content div.product .woocommerce-tabs ul.tabs li a,
.woocommerce-456market.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a,
.woocommerce-456market.woocommerce .woocommerce-breadcrumb,
.woocommerce-456market.woocommerce-page .woocommerce-breadcrumb,
.woocommerce-456market.woocommerce .woocommerce-breadcrumb a,
.woocommerce-456market.woocommerce-page .woocommerce-breadcrumb a{
	font-family:
    <?php if($body_2_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($body_2_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($body_2_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($body_2_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($body_2_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($body_2_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $body_2_font_family; 
    }?>;
}

/* bootstrap
}*/
.accordion-heading .accordion-toggle{
	font-family:
    <?php if($body_2_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($body_2_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($body_2_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($body_2_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($body_2_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($body_2_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $body_2_font_family; 
    }?>;
}

/* application
}*/
.dg-add-content-wrap .dg-image-title,
.sb-post-details,
.sb-modern-skin .showbiz-title,
#featured-widget .featured-label .title-wrap,
.callout-button .title,
.widget-container .item .post_meta a,
.header_icon h4,
.cart-meta .remove,
.option-set a,
.about-post .member .info,
.callout h4,
.testimonial .cite a,
.tagcloud a,
.tags a,
.post_tabs_widget .content a.date,
.posts_widget .content a.date,
.widget_rss .rss-date,
h4.heading-title,
.social-media p,
.front_meta_widget .item,
.footer_meta_widget .item,
#reply-title,
.comment-info,
.comment-title,
.post-meta a,
.shopping-cart .total,
.second-menu ul,
#page-title h2{
	font-family:
    <?php if($body_2_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($body_2_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($body_2_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($body_2_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($body_2_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($body_2_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($body_2_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $body_2_font_family; 
    }?>;
}
<?php }?>

<?php if($elements_font_family != ''){?>
/* bootstrap
}*/
.tooltip{
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
    }else{
       echo $elements_font_family; 
    }?>;
}

/* application
}*/
.label,
.badge,
.btn.btn-large,
.btn.btn-mini,
.btn.btn-small,
.btn.btn-normal,
#page-breadcrumb{
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
    }else{
       echo $elements_font_family; 
    }?>;
}
<?php }?>


<?php if($navigation_font_family != ''){?>
/* application
}*/
.shopping-cart .title,
.navbar .menu-item-language a,
.navbar .nav > li > a{
	font-family:
    <?php if($navigation_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($navigation_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($navigation_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($navigation_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($navigation_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($navigation_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($navigation_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $navigation_font_family; 
    }?>;
}
<?php }?>


<?php if($input_font_family != ''){?>
/* application
}*/
textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input, .chzn-container{
	font-family: 
	<?php if($input_font_family == 'Open+Sans'){
        echo "'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Titillium+Web'){
        echo "'Titillium Web', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Oxygen'){
        echo "'Oxygen', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Quicksand'){
        echo "'Quicksand', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Lato'){
        echo "'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Raleway'){
        echo "'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Source+Sans+Pro'){
        echo "'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Dosis'){
        echo "'Dosis', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Exo'){
        echo "'Exo', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Arvo'){
        echo "'Arvo', serif";
    }elseif($input_font_family == 'Vollkorn'){
        echo "'Vollkorn', serif";
    }elseif($input_font_family == 'Ubuntu'){
        echo "'Ubuntu', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'PT+Sans'){
        echo "'PT Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'PT+Serif'){
        echo "'PT Serif', serif";
    }elseif($input_font_family == 'Droid+Sans'){
        echo "'Droid Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Droid+Serif'){
        echo "'Droid Serif', serif";
    }elseif($input_font_family == 'Cabin'){
        echo "'Cabin', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Lora'){
        echo "'Lora', serif";
    }elseif($input_font_family == 'Oswald'){
        echo "'Oswald', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }elseif($input_font_family == 'Varela+Round'){
        echo "'Varela Round', 'Helvetica Neue', Helvetica, Arial, sans-serif";
    }else{
       echo $input_font_family; 
    }?>;
}
<?php }?>

</style>
<?php }?>