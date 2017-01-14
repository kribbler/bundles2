<?php $header_search = ot_get_option('header_search');?>

<?php if($header_search != "none"){ ?>
<div class="header-middle-search">
	
	<?php if($header_search == "shop_search"){ ?>
		<form role="form" method="get" class="" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<input type="hidden" name="post_type" value="product" />
		    <input type="text" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search For Products', GETTEXT_DOMAIN ); ?>">
			<button type="submit" class="search-btn"></button>
		</form>
	<?php } elseif($header_search == "theme_search"){?>
		<form role="form" method="get" class="" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		    <input type="text" class="form-control" id="s" name="s" placeholder="<?php _e( 'Search Site', GETTEXT_DOMAIN ); ?>">
			<button type="submit" class="search-btn"></button>
		</form>
	<?php }?>
	
</div>
<?php }?>