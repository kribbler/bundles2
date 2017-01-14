<?php $navigation_search= ot_get_option('navigation_search');?>
<?php $header_search = ot_get_option('header_search');?>

<?php if($header_search == "none"){ ?>
<?php if($navigation_search != "none"){ ?>
<div class="header-middle-search visible-xs visible-sm">
	
	<?php if($navigation_search == "shop_search"){ ?>
		<form role="form" method="get" class="" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<input type="hidden" name="post_type" value="product" />
		    <input type="text" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search For Products', GETTEXT_DOMAIN ); ?>">
			<button type="submit" class="search-btn"></button>
		</form>
	<?php } elseif($navigation_search == "theme_search"){?>
		<form role="form" method="get" class="" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		    <input type="text" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search Site', GETTEXT_DOMAIN ); ?>">
			<button type="submit" class="search-btn"></button>
		</form>
	<?php }?>
	
</div>
<?php }?>
<?php }?>