<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php global $post;?>

<?php $sidebar_checkbox =""; ?>

<?php if (is_shop()){?>
	<?php if (!is_search()){?>
		<?php $shop_page = get_post( woocommerce_get_page_id( 'shop' ) ); ?>
		<?php $sidebar_checkbox = get_post_meta($shop_page->ID, 'sidebar_checkbox', true);?>
	<?php }?>
<?php } elseif (is_singular( 'product' )){?>
	<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true); ?>
<?php }?>

<?php $shop_title = ot_get_option('shop_title');?>

<?php if (is_shop()){?>
	<?php if (!$shop_title){ get_template_part('includes/title-breadcrumb' );} ?>
<?php } else {?>
	<?php get_template_part('includes/title-breadcrumb' ); ?>
<?php }?>

<?php
$shop_category_sidebar=$shop_tag_sidebar='';

if(is_product_category()){
	$queried_object = get_queried_object();
	$tax_id = $queried_object->term_id;
	$product_cat_term_meta = get_option( "product_cat_$tax_id" );
	$shop_category_sidebar = $product_cat_term_meta['custom_term_meta2'];
}?>

<?php
if(is_tax("product_tag")){
	$queried_object = get_queried_object();
	$tax_id = $queried_object->term_id;
	$product_tag_term_meta = get_option( "product_tag_$tax_id" );
	$shop_tag_sidebar = $product_tag_term_meta['custom_term_meta2'];
}?>


<div id="main" class="inner-page<?php if ($sidebar_checkbox||$shop_category_sidebar=='left'||$shop_tag_sidebar=='left'){?> left-sidebar-template<?php }?><?php if (is_shop()){ if ($shop_title){?> no-shop-title<?php } }?>">
	<div class="container">
		<div class="row">
		<?php if(is_shop()){ ?>	
			
			<?php $shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
			$shop_content = apply_filters( 'the_content', $shop_page->post_content ); ?>
		
			<?php if ( $shop_content ) { ?><div class="col-md-12"><?php do_action( 'lpd_shop_content' ); ?></div><?php } ?>
			<?php if ( is_active_sidebar(4) ){?>
				<div class="col-md-9 page-content lpd-sidebar-page shop-page ">
			<?php } else{?>
				<div class="col-md-12 page-content shop-page">
			<?php } ?>
		<?php } elseif(is_product_category()||is_tax("product_tag")){ ?>
			<?php if ( is_active_sidebar(4) ){?>
				<?php if($shop_category_sidebar=="none"&&$shop_tag_sidebar=="none"){?>
					<div class="col-md-12 page-content page-content shop-page shop-taxo-page">
				<?php } else{?>
					<div class="col-md-9 page-content lpd-sidebar-page page-content shop-page shop-taxo-page">
				<?php } ?>
			<?php } else{?>
				<div class="col-md-12 page-content shop-page shop-taxo-page">
			<?php } ?>
		<?php } else{?>
				<div class="col-md-12 page-content shop-page shop-product-post">
		<?php } ?>