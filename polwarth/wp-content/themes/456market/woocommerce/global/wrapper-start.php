<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */?>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>

<?php global $post;?>

<?php if (is_shop()){?>
	<?php if (!is_search()){?>
		<?php $shop_page = get_post( woocommerce_get_page_id( 'shop' ) ); ?>
		<?php $sidebar_checkbox = get_post_meta($shop_page->ID, 'sidebar_checkbox', true);?>
	<?php }?>
<?php } elseif (is_singular( 'product' )){?>
	<?php $sidebar_checkbox = get_post_meta($post->ID, 'sidebar_checkbox', true); ?>
<?php }?>

		<?php get_template_part('includes/heading' ) ?>
		<div id="main" class="page-title-template <?php if ($sidebar_checkbox){?>left-sidebar-template<?php }?>">
			<div class="container">
				<div class="row-fluid">
					<?php if(is_singular( 'product' )){ ?>
						<?php if ( is_active_sidebar(6) ){?>
							<div class="span10 page-content">
						<?php } else{?>
							<div class="span12 page-content">
						<?php } ?>
					<?php } else{?>
						<?php if ( is_active_sidebar(5) ){?>
							<div class="span9 page-content">
						<?php } else{?>
							<div class="span12 page-content">
						<?php } ?>
					<?php } ?>