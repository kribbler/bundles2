<?php
function lpd_portfolio_tags_add_new_meta_field() {
	wp_enqueue_media();
	?>
	<div class="form-field">
		<label><?php _e( 'Header Image', GETTEXT_DOMAIN );?></label>
		<div id="category_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo THEME_ASSETS.'images/placeholder.png'; ?>" width="60px" height="60px" /></div>
		<div style="line-height:60px;">
			<input type="hidden" id="term_meta[custom_term_meta]" class="category_thumbnail_id" name="term_meta[custom_term_meta]" />
			<button type="submit" class="upload_image_button2 button"><?php _e( 'Upload/Add image', GETTEXT_DOMAIN ); ?></button>
			<button type="submit" class="remove_image_button2 button"><?php _e( 'Remove image', GETTEXT_DOMAIN ); ?></button>
		</div>
		<script type="text/javascript">

			 // Only show the "remove image" button when needed
			 if ( ! jQuery('.category_thumbnail_id').val() )
				 jQuery('.remove_image_button2').hide();

			// Uploading files
			var file_frame;

			jQuery(document).on( 'click', '.upload_image_button2', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php _e( 'Choose an image', GETTEXT_DOMAIN ); ?>',
					button: {
						text: '<?php _e( 'Use image', GETTEXT_DOMAIN ); ?>',
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').first().toJSON();

					jQuery('.category_thumbnail_id').val( attachment.id );
					jQuery('#category_thumbnail img').attr('src', attachment.url );
					jQuery('.remove_image_button2').show();
				});

				// Finally, open the modal.
				file_frame.open();
			});

			jQuery(document).on( 'click', '.remove_image_button2', function( event ){
				jQuery('#category_thumbnail img').attr('src', '<?php echo THEME_ASSETS.'images/placeholder.png'; ?>');
				jQuery('.category_thumbnail_id').val('');
				jQuery('.remove_image_button2').hide();
				return false;
			});

		</script>
		<div class="clear"></div>
	</div>
	<div class="form-field">
		<label for="term_meta[custom_term_meta1]"><?php _e( 'Background Type', GETTEXT_DOMAIN );?></label>
		<select name="term_meta[custom_term_meta1]" id="term_meta[custom_term_meta1]">
			<option value="full"><?php _e( 'Full Width', GETTEXT_DOMAIN );?></option>
			<option value="parallax"><?php _e( 'Parallax', GETTEXT_DOMAIN );?></option> 
			<option value="repeat"><?php _e( 'Repeat', GETTEXT_DOMAIN );?></option> 
		</select>
	</div>
	<div class="form-field">
		<label for="term_meta[custom_term_meta2]"><?php _e( 'Sidebar', GETTEXT_DOMAIN );?></label>
		<select name="term_meta[custom_term_meta2]" id="term_meta[custom_term_meta2]">
			<option value="none"><?php _e( 'None', GETTEXT_DOMAIN );?></option>
			<option value="right"><?php _e( 'Right Sidebar', GETTEXT_DOMAIN );?></option> 
			<option value="left"><?php _e( 'Left Sidebar', GETTEXT_DOMAIN );?></option> 
		</select>
	</div>
<?php
}
add_action( 'portfolio_tags_add_form_fields', 'lpd_portfolio_tags_add_new_meta_field', 10, 2 );

function lpd_portfolio_tags_edit_meta_field($term) {
	
 	wp_enqueue_media();

	$t_id = $term->term_id;
 
	$term_meta = get_option( "portfolio_tags_$t_id" );
	
	$image = '';
	$thumbnail_id 	= $term_meta['custom_term_meta'];
	if ($thumbnail_id) :
		$image = wp_get_attachment_thumb_url( $term_meta['custom_term_meta']);
	else :
		$image = THEME_ASSETS.'images/placeholder.png';
	endif;?>
	
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Header Image', GETTEXT_DOMAIN );?></label></th>
		<td>
			<div id="category_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $image;?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="term_meta[custom_term_meta]" class="category_thumbnail_id" name="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>" />
				<button type="submit" class="upload_image_button2 button"><?php _e( 'Upload/Add image', GETTEXT_DOMAIN ); ?></button>
				<button type="submit" class="remove_image_button2 button"><?php _e( 'Remove image', GETTEXT_DOMAIN ); ?></button>
			</div>
			<script type="text/javascript">

				// Uploading files
				var file_frame;

				jQuery(document).on( 'click', '.upload_image_button2', function( event ){

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', GETTEXT_DOMAIN ); ?>',
						button: {
							text: '<?php _e( 'Use image', GETTEXT_DOMAIN ); ?>',
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();

						jQuery('.category_thumbnail_id').val( attachment.id );
						jQuery('#category_thumbnail img').attr('src', attachment.url );
						jQuery('.remove_image_button2').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on( 'click', '.remove_image_button2', function( event ){
					jQuery('#category_thumbnail img').attr('src', '<?php echo THEME_ASSETS.'images/placeholder.png'; ?>');
					jQuery('.category_thumbnail_id').val('');
					jQuery('.remove_image_button2').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta1]"><?php _e( 'Background Type', GETTEXT_DOMAIN );?></label></th>
		<td>
			<select name="term_meta[custom_term_meta1]" id="term_meta[custom_term_meta1]">
				<option <?php echo esc_attr( $term_meta['custom_term_meta1']=="full" ) ? 'selected="selected"' : ''; ?> value="full"><?php _e( 'Full Width', GETTEXT_DOMAIN );?></option>
				<option <?php echo esc_attr( $term_meta['custom_term_meta1']=="parallax" ) ? 'selected="selected"' : ''; ?> value="parallax"><?php _e( 'Parallax', GETTEXT_DOMAIN );?></option> 
				<option <?php echo esc_attr( $term_meta['custom_term_meta1']=="repeat" ) ? 'selected="selected"' : ''; ?> value="repeat"><?php _e( 'Repeat', GETTEXT_DOMAIN );?></option> 
			</select>
		</td>
	</tr>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta2]"><?php _e( 'Sidebar', GETTEXT_DOMAIN );?></label></th>
		<td>
			<select name="term_meta[custom_term_meta2]" id="term_meta[custom_term_meta2]">
				<option <?php echo esc_attr( $term_meta['custom_term_meta2']=="none" ) ? 'selected="selected"' : ''; ?> value="none"><?php _e( 'None', GETTEXT_DOMAIN );?></option>
				<option <?php echo esc_attr( $term_meta['custom_term_meta2']=="right" ) ? 'selected="selected"' : ''; ?> value="right"><?php _e( 'Right Sidebar', GETTEXT_DOMAIN );?></option> 
				<option <?php echo esc_attr( $term_meta['custom_term_meta2']=="left" ) ? 'selected="selected"' : ''; ?> value="left"><?php _e( 'Left Sidebar', GETTEXT_DOMAIN );?></option> 
			</select>
		</td>
	</tr>
<?php
}
add_action( 'portfolio_tags_edit_form_fields', 'lpd_portfolio_tags_edit_meta_field', 10, 2 );

function lpd_portfolio_tags_save_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "portfolio_tags_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "portfolio_tags_$t_id", $term_meta );
	}
}  
add_action( 'edited_portfolio_tags', 'lpd_portfolio_tags_save_custom_meta', 10, 2 );  
add_action( 'create_portfolio_tags', 'lpd_portfolio_tags_save_custom_meta', 10, 2 );