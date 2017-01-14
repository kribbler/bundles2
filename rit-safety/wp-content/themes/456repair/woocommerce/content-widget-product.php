<?php global $product; ?>
<?php $catalog_type = ot_get_option('catalog_type'); ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
		<?php echo $product->get_title(); ?>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php if($catalog_type!="purchases_prices"){ echo $product->get_price_html(); } ?>
</li>