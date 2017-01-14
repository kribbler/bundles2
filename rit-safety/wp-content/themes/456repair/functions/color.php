<?php function lpd_color_styles() {?>

<?php
$theme_color_1 = ot_get_option('theme_color');
$theme_color_2 = ot_get_option('theme_color_2');
$theme_color_3 = ot_get_option('theme_color_3');
$theme_color_4 = ot_get_option('theme_color_4');
$theme_color_4 = ot_get_option('theme_color_4');

if($theme_color_1==""){
	$theme_color_1 = "#0e5ba4";
}

if($theme_color_2==""){
	$theme_color_2 = "#0770b5";
}

if($theme_color_3==""){
	$theme_color_3 = "#fdb813";
}

if($theme_color_4==""){
	$theme_color_4 = "#ffc221";
}

?>
<?php $hm_custom_bg = ot_get_option('hm_custom_bg');?>

<?php if($hm_custom_bg||$theme_color_1||$theme_color_2||$theme_color_3||$theme_color_4||$hm_custom_bg){?>
<style>
a {
	  color: <?php echo $theme_color_1;?>;
}
.meta-menu a:hover{
	  color: <?php echo $theme_color_1;?>;
}
.email-container a:hover{
	color: <?php echo $theme_color_1;?>;
}
.lpd_breadcrumb a:hover{
	color: <?php echo $theme_color_1;?>;
}
.single-post-meta a:hover,
.blog-post-meta a:hover{
	color: <?php echo $theme_color_1;?>;
}
.text-primary {
  color: <?php echo $theme_color_1;?>;
}
.btn-primary {
  background-color: <?php echo $theme_color_1;?>;
  border-color: <?php echo $theme_color_1;?>;
}
.btn-primary.disabled,
.btn-primary[disabled],
fieldset[disabled] .btn-primary,
.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
.btn-primary.disabled:active,
.btn-primary[disabled]:active,
fieldset[disabled] .btn-primary:active,
.btn-primary.disabled.active,
.btn-primary[disabled].active,
fieldset[disabled] .btn-primary.active {
  background-color: <?php echo $theme_color_1;?>;
  border-color: <?php echo $theme_color_1;?>;
}
.btn-primary .badge {
  color: <?php echo $theme_color_1;?>;
}
.btn-link {
  color: <?php echo $theme_color_1;?>;
}
.btn-link:hover,
.btn-link:focus {
  color: <?php echo $theme_color_1;?>;
}
.label-primary {
  background-color: <?php echo $theme_color_1;?>;
}
.widget.widget_pages ul li a:hover:before,
.widget.widget_nav_menu ul li a:hover:before,
.widget.widget_login ul li a:hover:before,
.widget.widget_meta ul li a:hover:before,
.widget.widget_categories ul li a:hover:before,
.widget.widget_archive ul li a:hover:before,
.widget.widget_recent_comments ul li a:hover:before,
.widget.widget_recent_entries ul li a:hover:before,
.widget.widget_rss ul li a:hover,
.widget.widget_pages ul li a:hover,
.widget.widget_nav_menu ul li a:hover,
.widget.widget_login ul li a:hover,
.widget.widget_meta ul li a:hover,
.widget.widget_categories ul li a:hover,
.widget.widget_archive ul li a:hover,
.widget.widget_recent_comments ul li a:hover,
.widget.widget_recent_entries ul li a:hover{
	color: <?php echo $theme_color_1;?>;
}
.cbp-l-filters-alignLeft .cbp-filter-item-active,
.tagcloud a:hover,
.tags a:hover{
	border-color: <?php echo $theme_color_1;?>;
	background-color: <?php echo $theme_color_1;?>; 
}
.header-middle-search .search-btn{
  background-color: <?php echo $theme_color_1;?>;
}
.dropcap{
	background-color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair .wpb_tabs .wpb_tabs_nav li.ui-tabs-active a{
	color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair .wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav .ui-tabs-active a{
	color: <?php echo $theme_color_1;?>;
}
.mega-icon-bg{
	background-color: <?php echo $theme_color_1;?>;
}
.lpd-portfolio-item .title a:hover{
  color: <?php echo $theme_color_1;?>;
}
.owl-theme .owl-controls .owl-nav [class*=owl-]{
	background-color: <?php echo $theme_color_1;?>;
}
.lpd-product-thumbnail .loop-shop-btn{
	background-color: <?php echo $theme_color_1;?>;
}
.lpd-prodcut-accordion .panel-title a{
	color: <?php echo $theme_color_1;?>;
}
.pn-btn a:hover{
	color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair.woocommerce-page div.product form.cart .group_table td.label a:hover{
	color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair .woocommerce .widget_layered_nav_filters ul li a,
.wordpress-456repair.woocommerce-page .widget_layered_nav_filters ul li a,
.wordpress-456repair .woocommerce .widget_layered_nav ul li.chosen a,
.wordpress-456repair.woocommerce-page .widget_layered_nav ul li.chosen a{
	background-color: <?php echo $theme_color_1;?>;
}
.woocommerce .widget_layered_nav ul li a:hover,
.woocommerce-page .widget_layered_nav ul li a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.wordpress-456repair .widget_product_categories ul li a:hover{
	color: <?php echo $theme_color_1;?>;		
}
.wordpress-456repair .woocommerce ul.cart_list li a:hover,
.wordpress-456repair .woocommerce ul.product_list_widget li a:hover,
.wordpress-456repair.woocommerce-page ul.cart_list li a:hover,
.wordpress-456repair.woocommerce-page ul.product_list_widget li a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.wordpress-456repair div.product div.images a#cloud-link:hover{
	color: <?php echo $theme_color_1;?>;	
}
.lpd-cart-list-title a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.cbp-popup-singlePage .cbp-popup-navigation-wrap{
	background-color: <?php echo $theme_color_1;?>;
}
.cbp-item-wrapper:hover .cbp-l-grid-team-name{
	color: <?php echo $theme_color_1;?>;	
}
.cbp-item-wrapper:hover .cbp-l-grid-projects-title a{
	color: <?php echo $theme_color_1;?>;		
}

.ws-dropdown{
	border-color: <?php echo $theme_color_1;?>;
}
.ws-dropdown:before{
	border-bottom-color: <?php echo $theme_color_1;?>;
}
.ws-dropdown ul li a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.wpml-switcher-mobile .flag a:hover{
	color: <?php echo $theme_color_1;?>;
}
.booking_cont:before{
	background-color: <?php echo $theme_color_1;?>; 
}
.team-widget-social-details li:before{
	background-color: <?php echo $theme_color_1;?>; 
}
.team-widget-content .title a:hover{
	color: <?php echo $theme_color_1;?>;
}

#footer .footer-meta:before{
  background-color: <?php echo $theme_color_1;?>;
}
.ws-dropdown:before{
	border-bottom-color: <?php echo $theme_color_1;?>;
}
.ws-dropdown ul li a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.wpml-switcher-mobile .flag a:hover{
	color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair .cbp-l-filters-list .cbp-filter-item-active,
.wordpress-456repair .cbp-l-filters-dropdownWrap{
	background-color: <?php echo $theme_color_1;?>;
}
.wordpress-456repair .cbp-l-filters-list .cbp-filter-item{
	border-color: <?php echo $theme_color_1;?>;
}
.booking_cont:before{
	background-color: <?php echo $theme_color_1;?>; 
}
.team-widget-social-details li:before{
	background-color: <?php echo $theme_color_1;?>;
}
.team-widget-content .title a:hover{
	color: <?php echo $theme_color_1;?>;	
}
.lpd-shopping-cart-style-2 .cart-icon .count{
	border-color: <?php echo $theme_color_1;?>;
	background-color: <?php echo $theme_color_2;?>;
}
.header-top.header-meta-dark-bg{
	background-color: <?php echo $theme_color_1;?>;
}
.header-top.triangle-element:before{
	background-color: <?php echo $theme_color_1;?>;
}
.meta_colored_icons.picons_social .icon{
	border-color: <?php echo $theme_color_1;?>;
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary {
	background-color: <?php echo $theme_color_2;?>;
	border-color: <?php echo $theme_color_2;?>;
}

.team-widget-social-details li:hover:before{
	background-color: <?php echo $theme_color_3;?>;
}
.team-widget-item .member-position span,
.team-widget-item .member-position span.wrap:after,
.team-widget-item .member-position span.wrap:before{
	background-color: <?php echo $theme_color_3;?>;
}
.lpd-portfolio-item.widget_style_3 .mega-icon-border{
	background-color: <?php echo $theme_color_3;?>;
}
.dark-bg .cbp-item-wrapper:hover .cbp-l-grid-team-name{
	color: <?php echo $theme_color_3;?>;
}
.footer.dark-theme a{
	color: <?php echo $theme_color_3;?>;
}
.menu3dmega > ul li > a:before{
	background-color: <?php echo $theme_color_3;?>;
}
.footer.dark-theme .widget.widget_rss ul li a:hover,
.footer.dark-theme .widget.widget_pages ul li a:hover,
.footer.dark-theme .widget.widget_nav_menu ul li a:hover,
.footer.dark-theme .widget.widget_login ul li a:hover,
.footer.dark-theme .widget.widget_meta ul li a:hover,
.footer.dark-theme .widget.widget_categories ul li a:hover,
.footer.dark-theme .widget.widget_archive ul li a:hover,
.footer.dark-theme .widget.widget_recent_comments ul li a:hover,
.footer.dark-theme .widget.widget_recent_entries ul li a:hover{
	color: <?php echo $theme_color_3;?>;
}
.footer.dark-theme .widget.widget_pages ul li a:hover:before,
.footer.dark-theme .widget.widget_nav_menu ul li a:hover:before,
.footer.dark-theme .widget.widget_login ul li a:hover:before,
.footer.dark-theme .widget.widget_meta ul li a:hover:before,
.footer.dark-theme .widget.widget_categories ul li a:hover:before,
.footer.dark-theme .widget.widget_archive ul li a:hover:before,
.footer.dark-theme .widget.widget_recent_comments ul li a:hover:before,
.footer.dark-theme .widget.widget_recent_entries ul li a:hover:before,
.footer.dark-theme .widget.widget_rss ul li a:hover,
.footer.dark-theme .widget.widget_pages ul li a:hover,
.footer.dark-theme .footer.dark-theme .widget.widget_nav_menu ul li a:hover,
.footer.dark-theme .widget.widget_login ul li a:hover,
.footer.dark-theme .widget.widget_meta ul li a:hover,
.footer.dark-theme .widget.widget_categories ul li a:hover,
.footer.dark-theme .widget.widget_archive ul li a:hover,
.footer.dark-theme .widget.widget_recent_comments ul li a:hover,
.footer.dark-theme .widget.widget_recent_entries ul li a:hover{
	color: <?php echo $theme_color_3;?>;
}
.footer.dark-theme .tagcloud a:hover,
.footer.dark-theme .tags a:hover{
	border-color: <?php echo $theme_color_3;?>;;
	background-color: <?php echo $theme_color_3;?>; 
}
.btn-warning {
	background-color: <?php echo $theme_color_3;?>;
	border-color: <?php echo $theme_color_3;?>;
}
.btn-warning.disabled,
.btn-warning[disabled],
fieldset[disabled] .btn-warning,
.btn-warning.disabled:hover,
.btn-warning[disabled]:hover,
fieldset[disabled] .btn-warning:hover,
.btn-warning.disabled:focus,
.btn-warning[disabled]:focus,
fieldset[disabled] .btn-warning:focus,
.btn-warning.disabled:active,
.btn-warning[disabled]:active,
fieldset[disabled] .btn-warning:active,
.btn-warning.disabled.active,
.btn-warning[disabled].active,
fieldset[disabled] .btn-warning.active {
	background-color: <?php echo $theme_color_3;?>;
	border-color: <?php echo $theme_color_3;?>;
}
.dropcap1{
	background-color: <?php echo $theme_color_3;?>;
}
.mm1_content:hover .btn{
	background-color: <?php echo $theme_color_3;?>;
	border-color: <?php echo $theme_color_3;?>;
}
.lpd-portfolio-item:hover .mega-icon-bg{
	background-color: <?php echo $theme_color_3;?>;
}
.owl-theme .owl-controls .owl-nav [class*=owl-]:hover{
	background-color: <?php echo $theme_color_3;?>;
}
.wordpress-456repair .woocommerce .star-rating,
.wordpress-456repair.woocommerce-page .star-rating{
	color: <?php echo $theme_color_3;?>;
}
.lpd-onsale{
	background-color: <?php echo $theme_color_3;?>;
}
.wordpress-456repair .woocommerce p.stars a,
.wordpress-456repair.woocommerce-page p.stars a{
	color: <?php echo $theme_color_3;?>;
}
.cart-dropdown{
	border-color: <?php echo $theme_color_3;?>; 
}
.cart-dropdown:before{
	border-bottom-color: <?php echo $theme_color_3;?>; 
}
.btn-warning:hover,
.btn-warning:focus,
.btn-warning:active,
.btn-warning.active,
.open .dropdown-toggle.btn-warning {
	background-color: <?php echo $theme_color_4;?>;
	border-color: <?php echo $theme_color_4;?>;
}
.header-top.triangle-element:before{
	background-color: <?php echo $hm_custom_bg;?>;
}
.meta_colored_icons.picons_social .icon{
	border-color: <?php echo $hm_custom_bg;?>;
}
</style>
<?php }?>

<?php }?>
<?php add_action( 'wp_head', 'lpd_color_styles' );?>