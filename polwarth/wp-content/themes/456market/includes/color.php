<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');

    /* Theme Options
    ================================================== */
    $theme_color = get_option_tree('theme_color',$theme_options);
    $theme_color_2 = get_option_tree('theme_color_2',$theme_options);

}
?>

<?php if($theme_color&&$theme_color_2){?>
<style>

/* megafolio theme color
}*/
.mega-black{
	background:<?php echo $theme_color; ?>;
}
.mega-socialbar	.tw:hover,
.mega-socialbar	.fb:hover,
.mega-comments span:hover{
	color: <?php echo $theme_color; ?>;
}

<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
/* woocommerce theme color
}*/
.widget_product_categories ul li a:hover,
.woocommerce-456market.woocommerce div.product form.cart .group_table td.price .amount,
.woocommerce-456market.woocommerce-page div.product form.cart .group_table td.price .amount,
.woocommerce-456market.woocommerce #content div.product form.cart .group_table td.price .amount,
.woocommerce-456market.woocommerce-page #content div.product form.cart .group_table td.price .amount,
.woocommerce-456market.woocommerce div.product form.cart .group_table td.price ins,
.woocommerce-456market.woocommerce-page div.product form.cart .group_table td.price ins,
.woocommerce-456market.woocommerce #content div.product form.cart .group_table td.price ins,
.woocommerce-456market.woocommerce-page #content div.product form.cart .group_table td.price ins,
.product-item .extras a:hover,
.woocommerce-456market.woocommerce div.product .product-content p.price
.woocommerce-456market.woocommerce div.product .single_variation1 span.price,
.woocommerce-456market.woocommerce div.product .single_variation span.price,
.woocommerce-456market.woocommerce-page div.product .single_variation span.price,
.woocommerce-456market.woocommerce #content div.product .single_variation span.price,
.woocommerce-456market.woocommerce-page #content div.product .single_variation span.price,
.woocommerce-456market.woocommerce div.product .single_variation p.price,
.woocommerce-456market.woocommerce-page div.product .single_variation p.price,
.woocommerce-456market.woocommerce #content div.product .single_variation p.price,
.woocommerce-456market.woocommerce-page #content div.product .single_variation p.price{
	color: <?php echo $theme_color; ?>;
}
.woocommerce-456market .woocommerce .widget_layered_nav ul li.chosen a,
.woocommerce-456market.woocommerce-page .widget_layered_nav ul li.chosen a,
.woocommerce-456market .woocommerce .widget_layered_nav_filters ul li a,
.woocommerce-456market.woocommerce-page .widget_layered_nav_filters ul li a{
	background-color: <?php echo $theme_color; ?>;
}
<?php }?>


/* bootstrap theme color
}*/

/*.navbar .nav li.dropdown.open > .dropdown-toggle,
.navbar .nav li.dropdown.active > .dropdown-toggle,
.navbar .nav li.dropdown.open.active > .dropdown-toggle,
.navbar .nav > .active > a,
.navbar .nav > .active > a:hover,
.navbar .nav > .active > a:focus,*/
.navbar .menu-item-language a:focus,
.navbar .menu-item-language a:hover,
.navbar .nav > li > a:focus,
.navbar .nav > li > a:hover,
.navbar-link,
.nav-tabs .open .dropdown-toggle,
.nav-pills .open .dropdown-toggle,
.nav > li.dropdown.open.active > a:hover,
.nav > li.dropdown.open.active > a:focus,
.nav-pills > .active > a,
.nav-pills > .active > a:hover,
.nav-pills > .active > a:focus,
.nav-tabs > li > a:hover,
.nav-tabs > li > a:focus,
.btn-link:hover,
.btn-link:focus,
.btn-link,
a:hover,
a:focus,
a {
  color: <?php echo $theme_color; ?>;
}
.btn-primary {
  background-color: <?php echo $theme_color; ?>;
  *background-color: <?php echo $theme_color; ?>;
}
.nav-list > .active > a,
.nav-list > .active > a:hover,
.nav-list > .active > a:focus,
.btn-group.open .btn-primary.dropdown-toggle {
  background-color: <?php echo $theme_color; ?>;
}
.navbar .nav li.dropdown.open > .dropdown-toggle .caret,
.navbar .nav li.dropdown.active > .dropdown-toggle .caret,
.navbar .nav li.dropdown.open.active > .dropdown-toggle .caret,
.navbar .nav li.dropdown > .dropdown-toggle .caret,
.navbar .nav li.dropdown > a:hover .caret,
.navbar .nav li.dropdown > a:focus .caret,
.nav li.dropdown.open .caret,
.nav li.dropdown.open.active .caret,
.nav li.dropdown.open a:hover .caret,
.nav li.dropdown.open a:focus .caret,
.nav .dropdown-toggle:hover .caret,
.nav .dropdown-toggle:focus .caret
.nav .dropdown-toggle .caret {
  border-top-color: <?php echo $theme_color; ?>;
  border-bottom-color: <?php echo $theme_color; ?>;
}
.navbar .nav > li > .dropdown-menu:before {
	border-bottom-color: <?php echo $theme_color; ?>;
}
a.thumbnail:hover,
a.thumbnail:focus{
  border-color: <?php echo $theme_color; ?>;
}
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-submenu:hover > a,
.dropdown-submenu:focus > a,
.nav-collapse .dropdown-menu > .active > a,
.nav-collapse .dropdown-menu > .active > a:hover,
.nav-collapse .dropdown-menu > .active > a:focus,
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus,
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-submenu:hover > a,
.dropdown-submenu:focus > a {
  background-color: <?php echo $theme_color; ?>;
  background-image: -moz-linear-gradient(top, <?php echo $theme_color; ?>, <?php echo $theme_color; ?>);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(<?php echo $theme_color; ?>), to(<?php echo $theme_color; ?>));
  background-image: -webkit-linear-gradient(top, <?php echo $theme_color; ?>, <?php echo $theme_color; ?>);
  background-image: -o-linear-gradient(top, <?php echo $theme_color; ?>, <?php echo $theme_color; ?>);
  background-image: linear-gradient(to bottom, <?php echo $theme_color; ?>, <?php echo $theme_color; ?>);
  background-repeat: repeat-x;
}

/* bulleted list theme color
}*/
#footer .style2 li a:hover,
#footer .advanced li a:hover{
	color: <?php echo $theme_color; ?>;
}

/* application theme color
}*/
.option-set a:hover,
.tagcloud a:hover,
.tags a:hover,
.dropcap,
.breadcrumb-wrap{
	background: <?php echo $theme_color; ?>;
}
.light-skin .sb-readmore a:hover,
.sb-readmore a:hover,
.widget-container .item:hover .title a,
.widget.widget_pages ul a:hover,
.widget.widget_nav_menu ul a:hover,
.widget.widget_login ul a:hover,
.widget.widget_meta ul a:hover,
.widget.widget_categories ul a:hover,
.widget.widget_archive ul a:hover,
.widget.widget_recent_comments ul a:hover,
.widget.widget_recent_entries ul a:hover,
.cart-title:hover,
.portfolio-item:hover .title a,
.about-post .member:hover .name,
.callout .content .selected,
.footer-bottom-right a:hover,
.post-meta a:hover{
	color: <?php echo $theme_color; ?>;
}
.option-set a:hover,
.tagcloud a:hover,
.tags a:hover{
	border: 2px solid <?php echo $theme_color; ?>;
}
.callout-button,
.header_icon.icon_64 span.icon-bg,
.header_icon.icon_32 span.icon-bg,
.mega-livicon{
	background-color: <?php echo $theme_color; ?>;
}
.option-set a{
	color: <?php echo $theme_color; ?> !important;  
}
.dropdown-menu {
  border: 1px solid <?php echo $theme_color; ?>
}
.dg-add-content-wrap {
	background: <?php echo $theme_color; ?> !important;
}

<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
/* woocommerce theme color 2
}*/
.woocommerce-456market a#cloud-link:hover,
.woocommerce-456market .woo_compare_clear_all_container a:hover,
.woocommerce-456market #wl-wrapper .wl-manage .row-actions small a:hover,
.woo_compare_button_container1 .woo_bt_view_compare:hover,
.woocommerce-456market.woocommerce .woocommerce-breadcrumb a:hover,
.woocommerce-456market.woocommerce-page .woocommerce-breadcrumb a:hover{
	color: <?php echo $theme_color_2; ?>;
}
.woocommerce-456market .woocommerce .widget_layered_nav ul li.chosen a:hover,
.woocommerce-456market.woocommerce-page .widget_layered_nav ul li.chosen a:hover,
.woocommerce-456market .woocommerce .widget_layered_nav_filters ul li a:hover,
.woocommerce-456market.woocommerce-page .widget_layered_nav_filters ul li a:hover{
	background-color: <?php echo $theme_color_2; ?>;
}

/* bootstrap theme color 2
}*/
.btn-primary:active,
.btn-primary.active,
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.btn-primary.disabled,
.btn-primary[disabled] {
  background-color: <?php echo $theme_color_2; ?>;
  *background-color: <?php echo $theme_color_2; ?>;
}
<?php }?>

/* application theme color 2
}*/
.light-skin .sb-post-details a:hover,
.sb-post-details a:hover,
.widget-container .item .post_meta a:hover
.portfolio-categories a:hover,
.testimonial .cite a:hover,
.post_tabs_widget .content a.date:hover,
.posts_widget .content a.date:hover,
.second-menu ul li a:hover{
	color: <?php echo $theme_color_2; ?>;
}
#featured-widget .featured-label,
.callout-button:hover,
.header_icon.icon_64:hover span.icon-bg,
.header_icon.icon_32:hover span.icon-bg,
.mega-livicon:hover{
	background-color: <?php echo $theme_color_2; ?>;
}
.light-skin .sb-post-details a:hover,
.sb-post-details a:hover{
	border-bottom: 1px dotted <?php echo $theme_color_2; ?>;
}

</style>
<?php }?>