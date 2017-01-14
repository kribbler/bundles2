<form role="search" method="get" id="searchform" class="hide-input" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
	<input type="submit" value="<?php esc_attr_e( '', ETHEME_DOMAIN ); ?>" class="button" />
	<input type="hidden" name="post_type" value="product" />
</form>