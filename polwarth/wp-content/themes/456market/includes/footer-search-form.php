<?php 
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
    /* Footer Options
    ================================================== */
    $footer_search = get_option_tree('footer_search',$theme_options);
    $ccard = get_option_tree('ccard',$theme_options);   
}
?>

					<?php if($footer_search != "none"){ ?>
						<form class="form-search" role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
							<?php if($footer_search == "shop_search"){ ?>
							<input type="hidden" name="post_type" value="product" />
							<input id="s" name="s" type="text" class="input-medium" value="<?php _e( 'search entire store here', GETTEXT_DOMAIN ); ?>">
							<button type="submit" class="btn btn-normal"><?php _e( 'Search', GETTEXT_DOMAIN ); ?></button>
							<?php }else{?>
							<input id="s" name="s" type="text" class="input-medium" value="<?php _e( 'search site', GETTEXT_DOMAIN ); ?>">
							<button type="submit" class="btn btn-normal"><?php _e( 'Search', GETTEXT_DOMAIN ); ?></button>
							<?php }?>
						</form>
					<?php }?>