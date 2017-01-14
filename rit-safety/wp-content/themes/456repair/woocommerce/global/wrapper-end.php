<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */?>

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

            </div>
			
			<?php if(is_shop()){ ?>
				<?php if ( is_active_sidebar(4) ){?>
					<div class="col-md-3">
					    <div class="sidebar">
					    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Shop Sidebar') ) ?>
					    </div>
					</div>
				<?php } ?>
			<?php } elseif(is_product_category()||is_tax("product_tag")) {?>
				<?php if ( is_active_sidebar(4) ){?>
					<?php if ( $shop_tag_sidebar!="none"||$shop_category_sidebar!="none" ){?>
					<div class="col-md-3">
					    <div class="sidebar">
					    <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Shop Sidebar') ) ?>
					    </div>
					</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>