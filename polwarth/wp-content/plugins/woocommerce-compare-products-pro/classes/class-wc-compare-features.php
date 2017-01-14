<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Handles compare categories in admin
 *
 */
class WC_Admin_Compare_Features {
	
	public $default_types = array(
		'input-text' => array('name' => 'Input Text', 'description' => 'Enter Attribute compare data in single line text box'),
		'text-area' => array('name' => 'Text Area', 'description' => 'Enter Attribute compare data in paragraph text box'),
		'checkbox' => array('name' => 'Check Box', 'description' => 'Attribute Terms show as multi select check boxes'),
		'radio' => array('name' => 'Radio button', 'description' => 'Attribute Terms show as single select check boxes'),
		'drop-down' => array('name' => 'Drop Down', 'description' => 'Attribute Terms show in dropdown, single select'),
		'multi-select' => array('name' => 'Multi Select', 'description' => 'Attribute Terms show in dropdown, multi select'),
		'wp-video'	=> array('name' => 'Video Player', 'description' => 'Attribute with text field to add Video URL'),
		'wp-audio'	=> array('name' => 'Audio Player', 'description' => 'Attribute with text field to add Audio URL'),
	);

	/**
	 * Constructor
	 */
	public function __construct() {

		// Include script
		add_action( 'admin_footer', array( $this, 'include_script' ) );
		
		// Add / Edit attribute hook
		add_action( 'woocommerce_attribute_added', array( $this, 'create_feature_fields' ), 10, 2 );
		add_action( 'woocommerce_attribute_updated', array( $this, 'update_feature_fields' ), 10, 2 );
		
		// Delete attribute hook
		add_action( 'woocommerce_attribute_deleted', array( $this, 'delete_feature_fields' ), 10, 3 );
		
	}
	
	/**
	 * Add Compare Feature fields.
	 *
	 * @access public
	 * @return void
	 */
	public function create_feature_fields( $attribute_id , $attribute = array() ) {
		
		if ( $attribute_id && isset( $_POST['have_compare_feature_field'] ) ) {
			$field_unit   = ( isset( $_POST['field_unit'] ) )   ? (string) stripslashes( $_POST['field_unit'] ) : '';
			$field_type   = ( isset( $_POST['field_type'] ) )   ? (string) stripslashes( $_POST['field_type'] ) : '';
			$field_cats   = ( isset( $_POST['field_cats'] ) )   ? $_POST['field_cats'] : array();
			
			WC_Compare_Functions::update_compare_attribute_meta( $attribute_id, 'field_unit', $field_unit );
			WC_Compare_Functions::update_compare_attribute_meta( $attribute_id, 'field_type', $field_type );
			
			WC_Compare_Categories_Fields_Data::delete_row( "field_id='".$attribute_id."'" );
			if ( count( $field_cats ) > 0 ) {
				foreach ( $field_cats as $cat_id ) {
					WC_Compare_Categories_Fields_Data::insert_row( $cat_id, $attribute_id );
				}
			}
		}
	}
	
	/**
	 * Update Compare Feature fields.
	 *
	 * @access public
	 * @return void
	 */
	public function update_feature_fields( $attribute_id , $attribute = array() ) {
		
		if ( $attribute_id && isset( $_POST['have_compare_feature_field'] ) ) {
			$field_unit   = ( isset( $_POST['field_unit'] ) )   ? (string) stripslashes( $_POST['field_unit'] ) : '';
			$field_type   = ( isset( $_POST['field_type'] ) )   ? (string) stripslashes( $_POST['field_type'] ) : '';
			$field_cats   = ( isset( $_POST['field_cats'] ) )   ? $_POST['field_cats'] : array();
			
			WC_Compare_Functions::update_compare_attribute_meta( $attribute_id, 'field_unit', $field_unit );
			WC_Compare_Functions::update_compare_attribute_meta( $attribute_id, 'field_type', $field_type );
			
			if ( count( $field_cats ) > 0 ) {
				foreach ( $field_cats as $cat_id ) {
					$check_existed = WC_Compare_Categories_Fields_Data::get_count( "cat_id='".$cat_id."' AND field_id='".$attribute_id."'" );
					if ( $check_existed == 0 ) {
						WC_Compare_Categories_Fields_Data::insert_row( $cat_id, $attribute_id );
					}
					WC_Compare_Categories_Fields_Data::delete_row( "field_id='".$attribute_id."' AND cat_id NOT IN(".implode( ',', $field_cats ).")" );
				}
			} else {
				WC_Compare_Categories_Fields_Data::delete_row( "field_id='".$attribute_id."'" );
			}
		}
	}
	
	/**
	 * Delete Compare Feature fields.
	 *
	 * @access public
	 * @return void
	 */
	public function delete_feature_fields( $attribute_id, $attribute_name, $taxonomy ) {
		
		if ( $attribute_id > 0 ) {
			
			global $wpdb;
			$wpdb->query( "DELETE FROM {$wpdb->woo_compare_attributemeta} WHERE `woo_compare_attribute_id` = " . $attribute_id );
			
			WC_Compare_Categories_Fields_Data::delete_row( "field_id='".$attribute_id."'" );
		}
	}

	/**
	 * Include script to append the Compare Feature meta fields into Product Attribute page.
	 *
	 */
	public function include_script( ) {
		if ( ! isset( $_REQUEST['page'] ) || ! in_array( $_REQUEST['page'], array( 'product_attributes' ) ) ) return;
		?>
        <style>
		.a3rev_panel_container {
			border-top:1px dotted #666;
			border-bottom:1px dotted #666;
			margin-bottom:30px;
		}
		#col-container, #col-left {
			overflow:visible !important;
		}
		div.form-field .chosen-container-single .chosen-results {
			max-height:200px !important;	
		}
		div.form-field .chosen-container-multi .chosen-results {
			max-height:160px !important;	
		}
		.a3rev_panel_container div.form-field label {
			display: inline-block !important;	
		}
		.a3rev_panel_container span.help_tip {
			float:none !important;	
		}
		.a3rev_panel_container .help_tip {
			margin-right:-20px;	
		}
		</style>
        <?php
		if ( isset( $_GET['edit'] ) && $_GET['edit'] > 0 ) {
			$html_append = trim( $this->edit_feature_fields( $_GET['edit'] ) );
		?>
		<script>
		jQuery(document).ready(function($) {
			$(document).find('input[name="save_attribute"]').parent('p.submit').before('<?php echo $html_append; ?>');
		});
		</script>
    	<?php
		} else {
			$html_append = trim( $this->add_feature_fields() );
		?>		
		<script>
		jQuery(document).ready(function($) {
			$(document).find('input[name="add_new_attribute"]').parent('p.submit').before('<?php echo $html_append; ?>');
		});
		</script>
    	<?php
		}
	}
	
	/**
	 * Compare Feature fields.
	 *
	 * @access public
	 * @return void
	 */
	public function add_feature_fields() {
		ob_start();
		?>
        <div class="a3rev_panel_container">
            <h3><?php _e( 'Attribute Comparison Data', 'woo_cp' ); ?></h3>
            <input type="hidden" name="have_compare_feature_field" value="yes"  />
            <div class="form-field">
                <label for="field_type"><?php _e('Select Categories', 'woo_cp'); ?></label> 
                <span class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Attribute can be assigned to any Product Category that is activated for Product Comparisons. Attributes show on the comparison table as the Comparable Product Attributes.", 'woo_cp') ?>"></span> 
                <div></div>
                <?php
				$compare_cats = WC_Compare_Functions::get_all_compare_cats();
				?>
				<select multiple="multiple" name="field_cats[]" data-placeholder="<?php _e('Select Compare Categories', 'woo_cp'); ?>" style="width:95%;" class="chzn-select">
				<?php
                if ( is_array( $compare_cats ) && count( $compare_cats ) > 0 ) {
                    foreach ( $compare_cats as $cat ) {
					?>
                        <option value="<?php echo $cat->term_id; ?>"><?php echo esc_html( $cat->name ); ?></option>
                    <?php
                    }
                }
                ?>
				</select>
            </div>
            <div class="form-field">
                <label for="field_type"><?php _e('Attribute and Terms Compare data Input type', 'woo_cp'); ?></label> 
                <span class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Use these fields to determine how this Attribute with display its compare data. Text input fields are for adding custom compare data and ignore the Attribute Terms or set to show the Attributes Terms as single or multi select Compare data options that are quick and easy to set for each product.", 'woo_cp') ?>"></span> 
                <div></div>
                <select name="field_type" id="field_type" class="chzn-select" style="width:95%;">
				<?php
				foreach ( $this->default_types as $type => $type_name) {
					echo '<option value="'.$type.'">'.$type_name['name'].' - '.$type_name['description'].'</option>';
				}
				?>
                </select>
            </div>
            <div class="form-field">
                <label for="field_unit"><?php _e('Attribute Unit of Measurement', 'woo_cp'); ?></label> 
                <span class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Attribute name in (brackets). If you leave this blank you will just see the Attribute name.", 'woo_cp') ?>"></span> 
                <div></div>
                <input type="text" name="field_unit" id="field_unit" value="" />
            </div>
        </div>
		<?php
		$ouput = ob_get_clean();
		$ouput = addslashes( str_replace( array( "\r\n", "\r", "\n" ), "", $ouput ) );
		return $ouput;
	}

	/**
	 * Edit Compare Feature field.
	 *
	 * @access public
	 * @param mixed $term Term (category) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 */
	public function edit_feature_fields( $term_id ) {
		
		$field_unit = WC_Compare_Functions::get_compare_attribute_meta( $term_id, 'field_unit' );
		$field_type = WC_Compare_Functions::get_compare_attribute_meta( $term_id, 'field_type' );
		$field_cats = WC_Compare_Categories_Fields_Data::get_catid_results( $term_id );
		
		if ( ! is_array( $field_cats ) ) $field_cats = array();
		
		ob_start();
		?>
        <div class="a3rev_panel_container">
            <h3><?php _e( 'Attribute Comparison Data', 'woo_cp' ); ?></h3>
            <input type="hidden" name="have_compare_feature_field" value="yes"  />
            <table class="form-table">
                <tbody>
                	<tr class="form-field">
                        <th scope="row" valign="top">
                        <div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Attribute can be assigned to any Product Category that is activated for Product Comparisons. Attributes show on the comparison table as the Comparable Product Attributes.", 'woo_cp') ?>"></div>
                        <label for="field_type"><?php _e('Select Categories', 'woo_cp'); ?></label> 
                        </th>
                        <td>
                            <?php
							$compare_cats = WC_Compare_Functions::get_all_compare_cats();
							?>
							<select multiple="multiple" name="field_cats[]" data-placeholder="<?php _e('Select Compare Categories', 'woo_cp'); ?>" style="width:95%;" class="chzn-select">
							<?php
							if ( is_array( $compare_cats ) && count( $compare_cats ) > 0 ) {
								foreach ( $compare_cats as $cat ) {
								?>
									<option value="<?php echo $cat->term_id; ?>" <?php echo ( in_array( $cat->term_id, $field_cats ) ? 'selected="selected"' : '' ) ?> ><?php echo esc_html( $cat->name ); ?></option>
								<?php
								}
							}
							?>
							</select>
                        </td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row" valign="top">
                        <div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("Use these fields to determine how this Attribute with display its compare data. Text input fields are for adding custom compare data and ignore the Attribute Terms or set to show the Attributes Terms as single or multi select Compare data options that are quick and easy to set for each product.", 'woo_cp') ?>"></div>
                        <label for="field_type"><?php _e('Attribute and Terms Compare data Input type', 'woo_cp'); ?></label> 
                        </th>
                        <td>
                            <select name="field_type" id="field_type" class="chzn-select" style="width:95%">
							<?php
                            foreach ( $this->default_types as $type => $type_name) {
                            ?>
                            	<option value="<?php echo $type; ?>" <?php selected( $field_type, $type ) ?>><?php echo $type_name['name'].' - '.$type_name['description']; ?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="form-field">
                        <th scope="row" valign="top">
                        <div class="help_tip a3-plugin-ui-icon a3-plugin-ui-help-icon" data-tip="<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Attribute name in (brackets). If you leave this blank you will just see the Attribute name.", 'woo_cp') ?>"></div>
                        <label for="field_unit"><?php _e('Attribute Unit of Measurement', 'woo_cp'); ?></label> 
                        </th>
                        <td>
                            <input type="text" name="field_unit" id="field_unit" value="<? echo esc_attr( $field_unit ); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
		<?php
		$ouput = ob_get_clean();
		$ouput = addslashes( str_replace( array( "\r\n", "\r", "\n" ), "", $ouput ) );
		return $ouput;
	}

}

global $wc_admin_compare_features;

$wc_admin_compare_features = new WC_Admin_Compare_Features();
