<?php
/**
 * Plugin Name: Spiralps Shipping
 * Plugin URI: 
 * Description: Weight based shipping method for Woocommerce.
 * Version: 1.0.
 * Author: INTERNET MARKETING SOLUTIONS SARL

*/

add_action('plugins_loaded', 'init_spiralps_shipping', 0);

function init_spiralps_shipping() {

    if ( ! class_exists( 'WC_Shipping_Method' ) ) return;
    
class spiralps_Shipping extends WC_Shipping_Method {

    function __construct() { 
     
                $this->id 			= 'spiralps_shipping';
                $this->method_title 		= __( 'Spiralps Weight', 'woocommerce' );
		
		$this->admin_page_heading 	= __( 'Weight based shipping', 'woocommerce' );
		$this->admin_page_description 	= __( 'Define shipping by weight and country', 'woocommerce' );
              
               
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( &$this, 'sync_countries' ) );
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( &$this, 'process_admin_options' ) );

    	$this->init();
        $this->display_country_groups();        
    }

    /**
     * init function
     */
    function init() {
    
            $this->init_form_fields();
            $this->init_settings();

                $this->enabled		  = $this->settings['enabled'];
                $this->title 		  = $this->settings['title'];
                
                $this->swisspost_username = $this->settings['swisspost_username'];
                $this->swisspost_password = $this->settings['swisspost_password'];
                //$this->swisspost_franking = $this->settings['swisspost_franking'];
                $this->swisspost_franking = '60082076';
                
                $this->country_group_no   = $this->settings['country_group_no'];
                $this->sync_countries     = $this->settings['sync_countries'];
                $this->availability       = 'specific';
                $this->countries 	  = $this->settings['countries'];
                $this->type               = 'order';
                $this->tax_status	  = $this->settings['tax_status'];
                $this->fee                = $this->settings['fee'];
                $this->options 		  = isset( $this->settings['options'] ) ? $this->settings['options'] : '';
                $this->options		  = (array) explode( "\n", $this->options );
    }
    
    function init_form_fields() {

    global $woocommerce;

        $this->form_fields = array(
			'enabled' => array(
				'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
				'type' 			=> 'checkbox',
				'label' 		=> __( 'Enable this shipping method', 'woocommerce' ),
				'default' 		=> 'no',
			),
			
			'title' => array(
				'title' 		=> __( 'Method Title', 'woocommerce' ),
				'type' 			=> 'text',
				'description' 	=> __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default'		=> __( 'Weight Based Shipping', 'woocommerce' ),
			),

			'swisspost_username' => array(
				'title'			=> 'Username (Swisspost API)',
				'type'			=> 'text',
			),
			
			'swisspost_password' => array(
				'title'			=> 'Password (Swisspost API)',
				'type'			=> 'text',
			),
			
			'swisspost_franking' => array(
				'title'			=> 'Franking Licence (Swisspost API)',
				'type'			=> 'text',
			),
			
			
			
        			'tax_status' => array(
							'title' 		=> __( 'Tax Status', 'woocommerce' ),
							'type' 			=> 'select',
							'description' 	=> '',
							'default' 		=> 'taxable',
							'options'		=> array(
								'taxable' 	=> __( 'Taxable', 'woocommerce' ),
								'none' 		=> __( 'None', 'woocommerce' ),
							),
						),
                           'fee' => array(
                                                    'title' 		=> __( 'Handling Fee', 'woocommerce' ),
                                                    'type' 			=> 'text',
                                                    'description'	=> __( 'Fee excluding tax. Enter an amount, e.g. 2.50. Leave blank to disable.', 'woocommerce' ),
                                                    'default'		=> '',
                                            ),
                       'options' => array(
                                                    'title' 		=> __( 'Shipping Rates', 'woocommerce' ),
                                                    'type' 			=> 'textarea',
                                                    'description'	=> __( 'Set your weight based rates for country groups (one per line). Example: <code>Max weight|Cost|country group number</code>. Example: <code>100|6.95|3</code>.', 'woocommerce' ),
                                                    'default'		=> '',
                                            ),
              'country_group_no' => array(
                                                    'title' 		=> __( 'Number of country groups', 'woocommerce' ),
                                                    'type' 			=> 'text',
                                                    'description'	=> __( 'Number of groups of countries sharing delivery rates (hit "Save changes" button after you have changed this setting).' ),
                                                    'default' 		=> '3',
                                            ),
                'sync_countries' => array(
                                                    'title' 		=> __( 'Add countries to allowed', 'woocommerce' ),
                                                    'type' 			=> 'checkbox',
                                                    'label' 		=> __( 'Countries added to country groups will be automatically added to Allowed Countries 
                                                                                    in <a href="/wp-admin/admin.php?page=woocommerce_settings&tab=general">General settings tab.</a>
                                                                                    This makes sure countries defined in country groups are visible on checkout.
                                                                                    Deleting country from country group will not delete country from Allowed Countries.', 'woocommerce' ),
                                                    'default' 		=> 'no',
                                            )
                                            );
    }

    /*
    * Displays country group selects in shipping method's options
    */
    function display_country_groups() {

        global $woocommerce;  
    //   echo prp($this->settings['countries1']);
        $number = $this->country_group_no;
        for($counter = 1; $number >= $counter; $counter++) {

            $this->form_fields['countries'.$counter] =  array(
                    'title'     => sprintf(__( 'Country Group %s', 'woocommerce' ), $counter),
                    'type'      => 'multiselect',
                    'class'     => 'chosen_select',
                    'css'       => 'width: 450px;',
                    'default'   => '',
                    'options'   => $woocommerce->countries->countries
            );
        }    
    }

    /*
    * This method is called when shipping is calculated (or re-calculated)
    */  
    function calculate_shipping($package = array()) {

        global $woocommerce;

            $rates      = $this->get_rates_by_countrygroup($this->get_countrygroup($package));
            $weight     = $woocommerce->cart->cart_contents_weight;
            $final_rate = $this->pick_smallest_rate($rates, $weight);
            
            if($final_rate === false) return false;
            
            $taxable    = ($this->tax_status == 'taxable') ? true : false;
            
            
            if($this->fee > 0 && $package['destination']['country']) $final_rate = $final_rate + $this->fee;

                $rate = array(
                'id'        => $this->id,
                'label'     => $this->title,
                'cost'      => $final_rate,
                'taxes'     => '',
                'calc_tax'  => 'per_order'
                );
                
        $this->add_rate( $rate );
    }
    
    /*
    * Retrieves the number of country group for country selected by user on checkout 
    */        
    function get_countrygroup($package = array()) {    

            $counter = 1;

            while(is_array($this->settings['countries'.$counter])) {
                if (in_array($package['destination']['country'], $this->settings['countries'.$counter])) 
                    $country_group = $counter;

                $counter++;
            }
        return $country_group;
    }

    /*
    * Retrieves all rates available for selected country group
    */
    function get_rates_by_countrygroup($country_group = null) {

        $rates = array();
                if ( sizeof( $this->options ) > 0) foreach ( $this->options as $option => $value ) {

                    $rate = preg_split( '~\s*\|\s*~', trim( $value ) );

                    if ( sizeof( $rate ) !== 3 )  {
                        continue;
                    } else {
                        $rates[] = $rate;

                    }
                }

                foreach($rates as $key) {
                    if($key[2] == $country_group) {
                        $countrygroup_rate[] = $key;
                    }
                }
        return $countrygroup_rate;
    }

    /*
    * Picks the right rate from available rates based on cart weight
    */        
    function pick_smallest_rate($rates,$weight) {

    if($weight == 0) return 0; // no shipping for cart without weight

        if( sizeof($rates) > 0) foreach($rates as $key => $value) {

                if($weight <= $value[0]) {
                    $postage[] = $value[1];   
                }
                $postage_all_rates[] = $value[1];
        }

        if(sizeof($postage) > 0) {
            return min($postage);
                } else {
                if (sizeof($postage_all_rates) > 0) return max($postage_all_rates);
                }
        return false;    
    }

    /*
    * Uptades Allowed Countries with countries added to country groups
    */
    function sync_countries() {

        if($this->settings['sync_countries'] == 'yes') {
            $countries = $this->get_cg_countries();
            update_option('woocommerce_specific_allowed_countries', $countries);
        } 
    }
    /*
     * Retrieves countries from country groups and merges them with Allowed Countries array
     */
    function get_cg_countries() {    

                $counter = 1;
                $countries = array();

                    while(is_array($this->settings['countries'.$counter])) {
                        $countries = array_merge($countries, $this->settings['countries'.$counter]);

                    $counter++;
                    }
                    
            $allowed_countries = get_option( 'woocommerce_specific_allowed_countries' );

            if (is_array($allowed_countries)) $countries = array_merge($countries, $allowed_countries);
            $countries = array_unique($countries);
        return $countries;
    }

    function etz($etz) {
        
        if(empty($etz) || !is_numeric($etz)) {
            return 0.00;
        }
    }
    
    public function admin_options() {

    	?>
    	<h3><?php _e('Weight and Country based shipping', 'woocommerce'); ?></h3>
    	<p><?php _e('Lets you calculate shipping based on Country and weight of the cart. Lets you set unlimited weight bands on per country basis and group countries 
            that share same delivery cost/bands. For help and how to use go <a href="http://www.andyswebdesign.ie/blog/free-woocommerce-weight-and-country-based-shipping-extension-plugin/" target="_blank">here</a>', 'woocommerce'); ?></p>
    	<table class="form-table">
    	<?php
    		// Generate the HTML For the settings form.
    		$this->generate_settings_html();
    	?>
		</table><!--/.form-table-->
    	<?php
    }

  } // end spiralps_Shipping
}

/**
 * Add shipping method to WooCommerce
 **/
function add_spiralps_shipping( $methods ) {
	$methods[] = 'spiralps_shipping'; return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_spiralps_shipping' );

/**
 * shipping barcodes
 */

add_action( 'add_meta_boxes', 'woocommerce_meta_boxes_spiralps_labels' );

function woocommerce_meta_boxes_spiralps_labels($mb){
	add_meta_box( 
		'woocommerce-spiralps_labels', 
		__( 'Spiralps Printed Delivery', 'woocommerce' ), 
		'woocommerce_spiralps_labels', 
		'shop_order', 
		'side', 
		'default'
	);
	return $mb;
}

function woocommerce_spiralps_labels(){
	global $post, $wpdb, $thepostid, $woocommerce, $theorder;
	
	$options = get_option( 'woocommerce_spiralps_shipping_settings' );
	
	$the_date = convert_date($theorder->order_date);
	
	$order = $theorder;
	$pdf_order = array(); $k = 0;
	foreach ($order->get_items() as $item){
		
		$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
		$pdf_order['items'][$k]['name'] = $item['name'];
		$pdf_order['items'][$k]['line_total'] = strip_tags(html_entity_decode($item['line_total']));
		$pdf_order['items'][$k]['qty'] = $item['qty'];
		$k++;
	}
	
	if ( $totals = $order->get_order_item_totals() ) {
		//var_dump($totals);
		foreach ( $totals as $key=>$value ) :
			if ($key == 'order_total') : 	
				$pdf_order['total']['label'] = $value['label'];
				$pdf_order['total']['value'] = strip_tags(html_entity_decode($value['value']));
			endif;
		endforeach;
	}
	$pdf_order['translate']['product'] = __( 'Product', 'woocommerce' );
	$pdf_order['translate']['total'] = __( 'Total', 'woocommerce' );

	/**
	 * added on 20140214 to include tax row on pdf
	 */
	
	$t=0;$ttax=0;
	$is = $order->get_items();
	foreach ($is as $i){
		$t = $t + $i['line_total'];
		$ttax = $ttax + $i['line_tax'];
	}
	$t=round($t);$ttax = round($ttax);
	/*
	 * the end
	 */
	?>
	
	<input type="hidden" id="spiralps_address" value="<?php echo $theorder->get_formatted_billing_address()?>" />
	<input type="hidden" id="spiralps_order_details" value="Order Details" />
	
	<input type="hidden" id="spiralps_shipping_cost" value="<?php echo $theorder->order_shipping?>" />
	<input type="hidden" id="spiralps_shipping_method" value="<?php _e($theorder->get_shipping_method(), 'theretailer')?>" />
	
	<input type="hidden" value="<?php echo $options['swisspost_username']?>" name="swisspost_username" id="swisspost_username" />
	<input type="hidden" value="<?php echo $options['swisspost_password']?>" name="swisspost_password" id="swisspost_password" />
	<input type="hidden" value="<?php echo $options['swisspost_franking']?>" name="swisspost_franking" id="swisspost_franking" />
	
	<input type="hidden" value="<?php echo $theorder->shipping_first_name?>" id="spiralps_shipping_first_name" />
	<input type="hidden" value="<?php echo $theorder->shipping_last_name?>" id="spiralps_shipping_last_name" />
	<input type="hidden" value="<?php echo $theorder->shipping_company?>" id="spiralps_shipping_company" />
	<input type="hidden" value="<?php echo $theorder->shipping_address_1?>" id="spiralps_shipping_address_1" />
	<input type="hidden" value="<?php echo $theorder->shipping_address_2?>" id="spiralps_shipping_address_2" />
	<input type="hidden" value="<?php echo $theorder->shipping_postcode?>" id="spiralps_shipping_postcode" />
	<input type="hidden" value="<?php echo $theorder->shipping_city?>" id="spiralps_shipping_city" />
	<input type="hidden" value="<?php echo $theorder->billing_phone?>" id="spiralps_billing_phone" />
	<input type="hidden" value="<?php echo $theorder->billing_email?>" id="spiralps_billing_email" />
	
	<input type="hidden" id="spiralps_order_number" value="<?php _e( 'Order Number', 'spiralps_Shipping' )?>: <b><?php echo $post->ID?></b>" />
	<input type="hidden" id="spiralps_invoice_number" value="<?php _e( 'Invoice Number', 'spiralps_Shipping' )?>: <b><?php echo $post->ID?></b>" />
	<input type="hidden" id="spiralps_date_number" value="<?php _e( 'Invoice Date', 'spiralps_Shipping' )?>: <b><?php echo convert_date(date("Y-m-d"))?></b>" />
	<input type="hidden" id="spiralps_side_number" value="<?php _e( 'Side', 'spiralps_Shipping' )?>: <b>1/1</b>" />
	
	<input type="hidden" id="spiralps_cart_subtotal" value="<?php _e( 'Cart Subtotal', 'spiralps_Shipping' ) ?>" />
	
	<?php 
	$order_meta = get_post_meta($theorder->id, "swisspost_shipping_file");
	$shipping_image = "";
	if ($order_meta){
		//$shipping_image = plugins_url("/" . $order_meta[0], __FILE__);
		$shipping_image = plugins_url("/swisspost/outputfolder/" . $order_meta[0], __FILE__);
	}
	
	?>
	
	<input type="button" class="button" id="spiralps_generate_labels" value="Generate API Labels" />
	<?php if (file_exists(plugin_dir_path( __FILE__ ) . "" . $order_meta[0])){?>
	<span id="spiralps_generate_labels_gif_file"><span style="color: green">Done</span></span>
	<?php }?>
	
	<input type="button" class="button" id="spiralps_generate_labels_pdf" value="Generate Labels PDF" />
	<span id="spiralps_generate_labels_pdf_file">
	    <?php if (file_exists(plugin_dir_path( __FILE__ ) . "export_labels_" . $theorder->id . '.pdf')){?>
	    <span style="color: green">Done</span>
	    <?php } ?>
	</span>
	
	<input type="button" class="button" id="spiralps_generate_invoice_pdf" value="Generate Invoice PDF" />
	<span id="spiralps_generate_invoice_pdf_file">
	    <?php if (file_exists(plugin_dir_path( __FILE__ ) . "export_invoice_" . $theorder->id . '.pdf')){?>
	    <span style="color: green">Done</span>
	    <?php }?>
	</span>
	
	<input type="button" class="button" id="spiralps_generate_delivery_note_pdf" value="Generate Delivery Note PDF" />
	<span id="spiralps_generate_delivery_note_pdf_file">
	    <?php if (file_exists(plugin_dir_path( __FILE__ ) . "export_delivery_note_" . $theorder->id . '.pdf')){?>
	    <span style="color: green">Done</span>
	    <?php }?>
	</span>
	
	<a id="generated_response_a" href="#" target="_blank" style="margin-top:10px; display: block">
		<img id="generated_response_img" src="<?php echo $shipping_image?>" style="width:100%" />
	</a>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#spiralps_generate_labels').click(function(){
			var order_id = "<?php echo $theorder->id?>";

			var swisspost_username = $('#swisspost_username').val();
			var swisspost_password = $('#swisspost_password').val();
			var swisspost_franking = $('#swisspost_franking').val();
			
			var address = $('#spiralps_address').val();
			var shipping_address = $('#spiralps_shipping_address').val();

			var shipping_first_name = $('#spiralps_shipping_first_name').val();
			var shipping_last_name = $('#spiralps_shipping_last_name').val();
			var shipping_company = $('#spiralps_shipping_company').val();
			var shipping_address_1 = $('#spiralps_shipping_address_1').val();
			var shipping_address_2 = $('#spiralps_shipping_address_2').val();
			var billing_phone = $('#spiralps_billing_phone').val();
			var billing_email = $('#spiralps_billing_email').val();

			
			if (shipping_address_2) {
				shipping_address_1 += ' ' + shipping_address_2;
			}
			var shipping_zip = $('#spiralps_shipping_postcode').val();
			var shipping_city = $('#spiralps_shipping_city').val();
			
			var info_account = $('#spiralps_account_number').val();
			var info_order = $('#spiralps_order_number').val();
			var info_invoice = $('#spiralps_invoice_number').val();
			var info_date = $('#spiralps_date_number').val();
			var info_side = $('#spiralps_side_number').val();
			var order_details = $('#spiralps_order_details').val();

			var shipping_cost = $('#spiralps_shipping_cost').val();
			var shipping_method = $('#spiralps_shipping_method').val();
			var cart_subtotal = $('#spiralps_cart_subtotal').val();
			var shipping_text = $('#spiralps_shipping_text').val();

			var item_total_label = '<?php echo $pdf_order['total']['label']?>';
			var item_total_value = '<?php echo $pdf_order['total']['value']?>';
			<?php foreach ($pdf_order['items'] as $key=>$value){
				echo "var item_name_$key = '" . $value['name'] . "';";
			}
			?>


			var data = {
				action: 'spiralps_generate',
				'order_id'			: order_id,
				'swisspost_username': swisspost_username,
				'swisspost_password': swisspost_password, 
				'swisspost_franking': swisspost_franking,
				'address'			: address,
				'shipping_address'	: shipping_address,
				'shipping_first_name'	: shipping_first_name,
				'shipping_last_name'	: shipping_last_name,
				'shipping_name'		: shipping_first_name + ' ' + shipping_last_name,
				'shipping_company'	: shipping_company,
				'shipping_address_1': shipping_address_1,
				'shipping_zip'		: shipping_zip,
				'shipping_city'		: shipping_city,
				'billing_phone'		: billing_phone,
				'billing_email'		: billing_email,
				'info_account'		: info_account,
				'info_order'		: info_order,
				'info_invoice'		: info_invoice,
				'info_date'			: info_date,
				'info_side'			: info_side,
				'order_details'		: order_details,
				'items_json'		: '<?php echo serialize($pdf_order)?>',
				'item_total'		: '<?php echo count($order->get_items())?>',
				'item_total_label'	: item_total_label,
				'item_total_value'	: item_total_value,
				'shipping_cost'		: shipping_cost,
				'shipping_method'	: shipping_method,
				'cart_subtotal'		: cart_subtotal,
				'shipping_text'		: shipping_text,
				<?php foreach ($pdf_order['items'] as $key=>$value){
					echo "'item_name_$key' : '" . $value['name'] . "',";
				}
				?>
			};

			jQuery.post('<?php echo admin_url('admin-ajax.php')?>', data, function(response) {
			    var folder = '<?php echo plugins_url(NULL, __FILE__)?>';
			    var image_location = folder + '/swisspost/outputfolder/' + response.f_name;
			    $('#generated_response_img').attr('src', image_location);
			    $('#generated_response_a').attr('href', image_location);
			}, 'json');
			return false;
		});
	});
	</script>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#spiralps_generate_labels_pdf').click(function(){
			var order_id	= "<?php echo $theorder->id?>";
			var label_gif	= "<?php echo $shipping_image?>";
			$.ajax({
				url: '<?php echo plugins_url( 'generate_labels_pdf.php' , __FILE__ )?>',
				data: {
					'order_id'			: order_id, 
					'label_gif'			: label_gif
				},
				type: "POST",
				success: function(){
				    $('#spiralps_generate_labels_pdf_file').html('<span style="color: green">Done</span>');
				    window.open('<?php echo plugins_url( 'export_labels_'.$theorder->id.'.pdf' , __FILE__ )?>', 'g');
				}
			});
			
		});
	});
	</script>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#spiralps_generate_invoice_pdf').click(function(){
			var order_id = "<?php echo $theorder->id?>";
			var logo = "<?php echo (plugins_url( 'include/images/logo-v2.png' , __FILE__ ))?>";
			var title = "<?php _e( 'Invoice', 'spiralps_Shipping' )?>";

			var address = $('#spiralps_address').val();
			var shipping_address = "Recipient";
			var info_account = "<?php echo $bacs_settings['account_number']?>";
			var info_order = $('#spiralps_order_number').val();
			var info_invoice = $('#spiralps_invoice_number').val();
			var info_date = $('#spiralps_date_number').val();
			var info_side = $('#spiralps_side_number').val();
			var order_details = $('#spiralps_order_details').val();
			var bellow0 = $('#aurelie_bellow0').val();
			var bellow1 = $('#aurelie_bellow1').val();
			var bellow2 = $('#aurelie_bellow2').val();

			var shipping_cost = $('#spiralps_shipping_cost').val();
			var shipping_method = $('#spiralps_shipping_method').val();
			var cart_subtotal = $('#spiralps_cart_subtotal').val();
			var shipping_text = $('#spiralps_shipping_text').val();
			
			
			var item_total_label = '<?php echo $pdf_order['total']['label']?>';
			var item_total_value = '<?php echo $pdf_order['total']['value']?>';
			<?php foreach ($pdf_order['items'] as $key=>$value){
				echo "var item_name_$key = '" . $value['name'] . "';";
				echo "var item_qty_$key = '" . $value['qty'] . "';";
			}
			?>
			
			$.ajax({
				url: '<?php echo plugins_url( 'generate_invoice_pdf.php' , __FILE__ )?>',
				data: {
					'order_id'			: order_id, 
					'logo'				: logo,
					'title'				: title,
					'address'			: address,
					'shipping_address'	: shipping_address,
					'info_account'		: info_account,
					'info_order'		: info_order,
					'info_invoice'		: info_invoice,
					'info_date'			: info_date,
					'info_side'			: info_side,
					'order_details'		: order_details,
					'items_json'		: '<?php echo serialize($pdf_order)?>',
					'item_total'		: '<?php echo count($order->get_items())?>',
					'item_total_label'	: item_total_label,
					'item_total_value'	: item_total_value,
					'shipping_cost'		: shipping_cost,
					'shipping_method'	: shipping_method,
					'cart_subtotal'		: cart_subtotal,
					//'order_tax'			: order_tax,
					'total_order'		: '<?php echo $t?>',
					'total_tax'			: '<?php echo $ttax?>',
					'tax_label'			: '<?php _e( 'Incl. tax', 'aurelie_Printed_Delivery_Confirmation' )?>',
					'shipping_text'		: shipping_text,
					<?php foreach ($pdf_order['items'] as $key=>$value){
						echo "'item_name_$key' : '" . $value['name'] . "',";
						echo "'item_qty_$key' : '" . $value['qty'] . "',";
					}
					?>
				},
				type: "POST",
				success: function(){
				    $('#spiralps_generate_invoice_pdf_file').html('<span style="color: green">Done</span>');
				    window.open('<?php echo plugins_url( 'export_invoice_'.$theorder->id.'.pdf' , __FILE__ )?>', 'g');
				}
			});
			
		});
	});
	</script>
	
	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#spiralps_generate_delivery_note_pdf').click(function(){
			var order_id = "<?php echo $theorder->id?>";
			var logo = "<?php echo (plugins_url( 'include/images/logo-v2.png' , __FILE__ ))?>";
			var title = "<?php _e( 'Delivery Note', 'spiralps_Shipping' )?>";

			var address = $('#spiralps_address').val();
			var shipping_address = "Recipient";
			var info_account = "<?php echo $bacs_settings['account_number']?>";
			var info_order = $('#spiralps_order_number').val();
			var info_invoice = $('#spiralps_invoice_number').val();
			var info_date = $('#spiralps_date_number').val();
			var info_side = $('#spiralps_side_number').val();
			var order_details = $('#spiralps_order_details').val();
			var bellow0 = $('#aurelie_bellow0').val();
			var bellow1 = $('#aurelie_bellow1').val();
			var bellow2 = $('#aurelie_bellow2').val();

			var shipping_cost = $('#spiralps_shipping_cost').val();
			var shipping_method = $('#spiralps_shipping_method').val();
			var cart_subtotal = $('#spiralps_cart_subtotal').val();
			var shipping_text = $('#spiralps_shipping_text').val();
			
			
			var item_total_label = '<?php echo $pdf_order['total']['label']?>';
			var item_total_value = '<?php echo $pdf_order['total']['value']?>';
			<?php foreach ($pdf_order['items'] as $key=>$value){
				echo "var item_name_$key = '" . $value['name'] . "';";
				echo "var item_qty_$key = '" . $value['qty'] . "';";
			}
			?>
			
			$.ajax({
				url: '<?php echo plugins_url( 'generate_delivery_note_pdf.php' , __FILE__ )?>',
				data: {
					'order_id'			: order_id, 
					'logo'				: logo,
					'title'				: title,
					'address'			: address,
					'shipping_address'	: shipping_address,
					'info_account'		: info_account,
					'info_order'		: info_order,
					'info_invoice'		: info_invoice,
					'info_date'			: info_date,
					'info_side'			: info_side,
					'order_details'		: order_details,
					'items_json'		: '<?php echo serialize($pdf_order)?>',
					'item_total'		: '<?php echo count($order->get_items())?>',
					'item_total_label'	: item_total_label,
					'item_total_value'	: item_total_value,
					'shipping_cost'		: shipping_cost,
					'shipping_method'	: shipping_method,
					'cart_subtotal'		: cart_subtotal,
					//'order_tax'			: order_tax,
					'total_order'		: '<?php echo $t?>',
					'total_tax'			: '<?php echo $ttax?>',
					'tax_label'			: '<?php _e( 'Incl. tax', 'aurelie_Printed_Delivery_Confirmation' )?>',
					'shipping_text'		: shipping_text,
					<?php foreach ($pdf_order['items'] as $key=>$value){
						echo "'item_name_$key' : '" . $value['name'] . "',";
						echo "'item_qty_$key' : '" . $value['qty'] . "',";
					}
					?>
				},
				type: "POST",
				success: function(){
				    $('#spiralps_generate_delivery_note_pdf_file').html('<span style="color: green">Done</span>');
				    window.open('<?php echo plugins_url( 'export_delivery_note_'.$theorder->id.'.pdf' , __FILE__ )?>', 'g');
				}
			});
			
		});
	});
	</script>
	<?php 
}

function convert_date($date){
	$date = explode(" ", $date);
	$date = $date[0];
	$date = explode("-", $date);
	foreach ($date as $key=>$value){
		$date[$key] = (int)$value;
	}
	$date = $date[2] . '/' . $date[1] . ', ' . $date[0];
	
	return $date;
}

function ajax_spiralps_generate(){
	$frankinglicense = $_POST['swisspost_franking'];
	
	$items = unserialize(stripcslashes($_POST['items_json']));
	$cart_cost = 0;

	foreach ($items['items'] as $item){
		$cart_cost += $item['line_total'];
	}
	
	$cart_cost += $_POST['shipping_cost'];
	
	//$username = $_POST['swisspost_username'];
	//$password = $_POST['swisspost_password'];
	//$endpoint_url = 'https://www.mypostbusiness.ch/wsbc/barcode/v2_2';
	
	$username = 'TUW003217';
	$password = 'X5Afld6m[oC_';
	$endpoint_url = 'https://wsbc.post.ch/wsbc/barcode/v2_2';
	
	$SOAP_wsdl_file_path=plugins_url('/swisspost/barcode_v2_2.wsdl', __FILE__);
	
	
	
	$SOAP_config = array(
		'location' => $endpoint_url,
		'login' => $username,
		'password' => $password,
	);
	try {
		$SOAP_Client = new SoapClient($SOAP_wsdl_file_path, $SOAP_config);
	}
	catch (SoapFault $fault) {
		echo('Error in SOAP Initialization: '. $fault -> __toString() .'<br/>');
		exit;
	}
	
	//include(plugins_url('/swisspost/wsbc-utils.php', __FILE__));
	//include("wsbc-utils.php");
	
	
	$generateLabelRequest = array(
	    'Language' => 'de',
	    'Envelope' => array(
	       	'LabelDefinition' => array(
		       	'LabelLayout' => 'A5',
		        'PrintAddresses' => 'RecipientAndCustomer',
		        'ImageFileType' => 'GIF',
		        'ImageResolution' => 300,
				'PrintPreview' => false
	        ),
	        'FileInfos' => array(
		         'FrankingLicense' => $frankinglicense,
				 'PpFranking' => false,
		         'Customer' => array(
			         'Name1' => 'SpirAlps SA',
			         'Street' => 'Rue du Rhône 12',
			         'ZIP' => '1963',
			         'City' => 'Vétroz'
			         /*
			         'Name1' => $_POST['shipping_name'],
	         		 // 'Name2' => 'Generalagentur',
			         'Street' => $_POST['shipping_address_1'],
			         // 'POBox' => 'Postfach 600',
			         'ZIP' => $_POST['shipping_zip'],
			         'City' => $_POST['shipping_city'],
			         // 'Country' => 'CH',
			         // 'Logo' => $logo_binary_data,
	         		 // 'LogoFormat' => 'GIF',
			         //'DomicilePostOffice' => '3000 Bern'
					  * */
	      		 ),
				 'CustomerSystem' => 'PHP Client System'
	   		),
		    'Data' => array(
		        'Provider' => array(
		            'Sending' => array(
		            	//'SendingID' => 'auftragsreferenz',
						'Item' => array(
							array( // 1.Item ...
								'ItemID' => $_POST['order_id'],
								// 'ItemNumber' => '12345678',
								 //'IdentCode' => $_POST['order_id'],
								'Recipient' => array(
									//'PostIdent' => 'IdentCodeUser',
	//								'Title' => 'Frau',
									'Vorname' => $_POST['shipping_first_name'],
									//'Name1' => $_POST['shipping_last_name'],
									'Name1'	=> htmlspecialchars_decode($_POST['shipping_name']),
									'Name2' => $_POST['shipping_company'],
									'Street' => str_replace("\\", "", $_POST['shipping_address_1']),
	//								'HouseNo' => '21',
									//'FloorNo' => '1',
									//'MailboxNo' => '1111',
									'ZIP' => $_POST['shipping_zip'],
									'City' => $_POST['shipping_city'],
									//'Country' => 'CH',
									'Phone' => $_POST['billing_phone'],
									'EMail' => $_POST['billing_email']
								),
								'Attributes' => array(
									'PRZL' => array(
										// At least one code is required (schema validation)
	
										// Basic service code(s) (optional, default="ECO"):
										'PRI',
										// Additional service codes (optional)
										//'N',
										//'FRA',
										// Delivery instruction codes (optional)
										//'ZAW3211',
										//'ZAW3213'
									),
	
									// Cash on delivery amount in CHF for service 'N':
									//'Amount' => $cart_cost,
									//'FreeText' => 'Freitext',
									// 'DeliveryDate' => '2010-06-19',
									// 'ParcelNo' => 2,
									// 'ParcelTotal' => 5,
									// 'DeliveryPlace' => 'Vor der Haustüre',
									//'ProClima' => true
								)
							)
						)
					)
				)
			)
		)
	);

//var_dump($generateLabelRequest);
	
	
	// 2. Web service call
	$response = null;
	try {
		$response = $SOAP_Client -> GenerateLabel($generateLabelRequest);
	}
	catch (SoapFault $fault) {
		echo('Error in GenerateLabel: '. $fault -> __toString() .'<br />');
	}
	//var_dump($response);
	// 3. Process requests: save label images and check for errors
	// (see documentation of structure in "Handbuch Webservice Barcode", section 4.3.2)
	foreach (getElements($response->Envelope->Data->Provider->Sending->Item) as $item) {
		if (@$item->Errors != null) {
	
	      	// Error in Label Request Item:
	      	// This barcode label was not generated due to errors.
	      	// The received error messages are returned in the specified language of the request.
	      	// This means, that the label was not generated,
	      	// but other labels from other request items in same call
	      	// might have been generated successfully anyway.
	      	$errorMessages = "";
	      	$delimiter="";
	      	foreach (getElements($item->Errors->Error) as $error) {
	      		$errorMessages .= $delimiter.$error->Message;
	      		$delimiter=",";
	      	}
	      	echo '<p>ERROR for item with itemID='.$item->ItemID.": ".$errorMessages.'.<br/></p>';
	
		}
	    else {
	      	// Get successfully generated label as binary data:
	      	$identCode = $item->IdentCode;
	   		$labelBinaryData = $item->Label;
	
		   	// Save the binary image data to image file:
		   	
	   		$f_name = 'testOutput_GenerateLabel_'.$identCode.'.gif';
	   		
		   	$filename = 'outputfolder/' . $f_name;
		   	$filename = '../wp-content/plugins/spiralps-shipping/swisspost/outputfolder/' . $f_name;
		   	file_put_contents($filename, $labelBinaryData);
		   	
			//also add the file in root of plugin
			$f_name1 = "GenerateLabel_" . $_POST['order_id'] . '.gif';
			$filename1 = 'outputfolder/' . $f_name1;
		   	$filename1 = '../wp-content/plugins/spiralps-shipping/' . $f_name1;
			file_put_contents($filename1, $labelBinaryData);
			
			
			
		   	/**
		   	 * it's used in my plugin
		   	 */
		   	delete_post_meta($_POST['order_id'], "swisspost_shipping_file");
		   	delete_post_meta($_POST['order_id'], "swisspost_shipping_ident_code");
		   	
		   	add_post_meta($_POST['order_id'], "swisspost_shipping_file", $f_name);
		   	add_post_meta($_POST['order_id'], "swisspost_shipping_ident_code", $identCode);
		   	
		   	$message = array();
		   	$message['identCode'] = $identCode;
		   	$message['f_name'] = $f_name;
		   	$message['fileName'] = $filename;
		   	$message['ok'] = "OK";
		   	echo json_encode($message);die();
		   	
		   	// Printout some label information (and warnings, if any):
			echo '<p>Label generated successfully for identCode='.$identCode.': <br/>';
			if (isset($item->Warnings) && $item->Warnings != null) {
				$warningMessages = "";
		      	foreach (getElements($item->Warnings->Warning) as $warning) {
		      		$warningMessages .= $warning->Message.",";
		      	}
		      	echo 'with WARNINGS: '.$warningMessages.'.<br/>';
		    }
			echo $filename.':<br/><img src="'.$filename.'"/><br/>';
			echo '</p>';
		}
	}
	
	echo "</body></html>";
	
	
	/**
	 * save post meta;
	 */
}

add_action('wp_ajax_spiralps_generate', 'ajax_spiralps_generate');


if ( !function_exists( 'getElements' ) ){
	function getElements($root) {
		if ($root==null) {
			return array();
		}
		if (is_array($root)) {
			return $root;
		}	
		else {
			// simply wrap a single value or object into an array		
			return array($root);
		}
	}
}
/*
function toCommaSeparatedString($strings) {
	$res = "";
	$delimiter = "";
	foreach ($strings as $str) {
		$res .= $delimiter.$str;		
		$delimiter = ", ";
	}
	return $res;
} */ 


add_action('wp_email_to_admin_the_documents', 'email_to_admin_the_documents');

function email_to_admin_the_documents(){
    //mail("daniel.oraca@gmail.com", 'test', 'wpw');
}


add_filter('woocommerce_email_attachments','handle_my_auto_email_attachments', 10, 3); 
function handle_my_auto_email_attachments($attachment = "", $emailtype = '', $args){
    global $post, $theorder, $order, $checkout;
    if (isset($post)){
        $order = $post;
    } else {
        $order = $args;
    }
    
    $order_meta = get_post_meta($order->id, "swisspost_shipping_file");
    //echo '<pre>';var_dump($order_meta);var_dump($order);die();
    if ($emailtype == "new_order"){
        //echo "<pre>";var_dump($order_meta);die();
        inside_generate_labels($args);
        inside_generate_invoice_pdf($args);
        inside_generate_delivery_note_pdf($args);
        //mail("daniel.oraca@gmail.com", 'dee reached!', serialize($args));
        $myFile = plugin_dir_path( __FILE__ ) . 'test.log';
        $fh = fopen($myFile, 'w');
        fwrite($fh, time().'---');
        fwrite($fh, $order->id.'----');
        fwrite($fh, $order_meta[0]);
        fclose($fh);
        
        if (isset($order->ID)){
            $order_id = $order->ID;
        } else if (isset($order->id)){
            $order_id = $order->id;
        }
        
	$attachment = array(
            //plugin_dir_path( __FILE__ ) . "GenerateLabel_360.gif",
            
	    //plugin_dir_path( __FILE__ ) . "swisspost/outputfolder/" . $order_meta[0],
            plugin_dir_path( __FILE__ ) . "GenerateLabel_" . $order_id . '.gif',
            plugin_dir_path( __FILE__ ) . "swisspost/outputfolder/testOutput_GenerateLabel_" . $order_id . '.gif',
	    //plugin_dir_path( __FILE__ ) . "export_labels_" . $order->ID . '.pdf',
	    plugin_dir_path( __FILE__ ) . "export_invoice_" . $order_id . '.pdf',
	    plugin_dir_path( __FILE__ ) . "export_delivery_note_" . $order_id . '.pdf'
	);
    }
    //echo "<pre>";var_dump($attachment); die();
    return $attachment;
}

function inside_generate_delivery_note_pdf($order){
    
    $pdf_order = array(); $k = 0;
    foreach ($order->get_items() as $item){
		
    	$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
	$pdf_order['items'][$k]['name'] = $item['name'];
	$pdf_order['items'][$k]['line_total'] = strip_tags(html_entity_decode($item['line_total']));
	$pdf_order['items'][$k]['qty'] = $item['qty'];
	$k++;
}
	
    if ( $totals = $order->get_order_item_totals() ) {
	//var_dump($totals);
	foreach ( $totals as $key=>$value ) :
            if ($key == 'order_total') : 	
                $pdf_order['total']['label'] = $value['label'];
                $pdf_order['total']['value'] = strip_tags(html_entity_decode($value['value']));
            endif;
        endforeach;
	}
	
        $pdf_order['translate']['product'] = __( 'Product', 'woocommerce' );
	$pdf_order['translate']['total'] = __( 'Total', 'woocommerce' );

	$t=0;$ttax=0;
	$is = $order->get_items();
	foreach ($is as $i){
		$t = $t + $i['line_total'];
		$ttax = $ttax + $i['line_tax'];
	}
	$t=round($t);$ttax = round($ttax);
        
    $order_id = $order->id;
    $logo = plugins_url( 'include/images/logo-v2.png' , __FILE__ );
    $title = __( 'Order Details', 'spiralps_Shipping' );
    $greetings = $_POST['greetings'];
    $thankyou = nl2br($_POST['thankyou']);
    $footer = $_POST['footer'];
    $shipping_address = __( "Recipient", 'spiralps_Shipping' );
    $address = $order->get_formatted_billing_address();
    $info_order = __( 'Order Number', 'spiralps_Shipping' ) . ': <b>' . $order->id . '</b>';
    $info_invoice = __( 'Invoice Number', 'spiralps_Shipping' ) . ': <b>' . $order->id . '</b>';
    $info_date = __( 'Invoice Date', 'spiralps_Shipping' ) . ': <b>' . convert_date(date("Y-m-d")) . '</b>';
    $info_side = __( 'Side', 'spiralps_Shipping' ) . ': <b>1/1</b>';
    $order_details = __( 'Order Details', 'spiralps_Shipping' );
    $item_total = count($order->get_items());
    $items_json = $pdf_order;
    $shipping_cost = $order->order_shipping;
    $shipping_method = $order->get_shipping_method();
    $cart_subtotal = __( 'Cart Subtotal', 'spiralps_Shipping' );
    $shipping_text = "";
    $total_order = $t;
    $total_tax = $total_order +  $shipping_cost;
    $tax_label = __( 'Incl. tax', 'spiralps_Shipping' ); 
    

    $items_table = '<br /><h3 style="padding:30px 0;margin:0;border-bottom: 1px solid #000000;">'.$order_details.'</h3>';
    $items_table .= '<table cellpadding="5px" style="margin-top:20px;">';

    $items_table .= '<thead>';
            $items_table .= '<tr>';
                    $items_table .= '<th style="width:535px;padding:5px 0;font-weight:bold;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['product']) . '</th>';
                    $items_table .= '<th style="width:100px;padding:5px 0;font-weight:bold;text-align:right;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['total']) . '</th>';
            $items_table .= '</tr>';
    $items_table .= '</thead>';

    $items_table .= '<tbody>';
    $lines = 0;
    foreach ($items_json['items'] as $item){
            $lines++;
            if ($lines < count($items_json['items'])){
                    $border = "border-bottom:1px solid #cccccc";
            } else $border = "";
            $items_table .= '<tr>';
            $items_table .= '<td style="line-height:2px;'.$border.'">' . $item['name'] . '<b>&times;' . $item['qty'] . '</b></td>';
            $items_table .= '<td style="text-align:right;'.$border.'">CHF ' . number_format($item['line_total'], 0, '.', ' ') . '</td>';
            $items_table .= '</tr>';
    }

    if ($shipping_cost > 0){
            $subtotal = filter_var($items_json['total']['value'], FILTER_SANITIZE_NUMBER_INT);
            $subtotal = $subtotal - $shipping_cost;
            $subtotal = number_format( $subtotal , 0, '.', ' ');
            $shipping_cost = number_format( $shipping_cost , 0, '.', ' ');
            $items_table .= '<tr>';
                    $items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($cart_subtotal) . ':</th>';
                    $items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $subtotal . '</b></td>';
            $items_table .= '</tr>';
            $items_table .= '<tr>';
                    $items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($shipping_text) . ' <span style="font-size:10px">('.$shipping_method.')</span>:</th>';
                    $items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $shipping_cost . '</b></td>';
            $items_table .= '</tr>';
    }
    $items_table .= '</tbody>';

    $items_table .= '<tfoot>';
            //$items_table .= '<tr>';
            //	$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($items_json['total']['label']) . '</th>';
            //	$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>' . $items_json['total']['value'] . ',-</b></td>';
            //$items_table .= '</tr>';
            $items_table .= '<tr>';
                    $items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($items_json['total']['label']) . '</th>';
                    $items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $total_tax . '</b></td>';
            $items_table .= '</tr>';
    $items_table .= '</tfoot>';

    $items_table .='</table>';

    //echo $items_table;die();
    require_once('include/tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Spiralps.ch');
    $pdf->SetTitle('Spiralps.ch - Printed delivery note');
    //$pdf->SetSubject('TCPDF Tutorial');
    //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $pdf->setFooterData(array(0,0,0), array(0,0,0), $footer);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 10, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

    $html = <<<EOD
<div style="text-align:right"><img width="270px" src="$logo" align="right" /></div>
<table>
		<tr>
			<td colspan="2">
				<h2>$title</h2>
				<br />
				<br />
				<h4 style="font-weight:bold">$shipping_address</h4>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left">$address</td>
			<td valign="top" align="right">
				$info_invoice<br />
				$info_date<br />
				$info_side<br />
			</td>
		</tr>

		<tr>
			<td colspan="2">$items_table</td>
		</tr>
		
	</table>
EOD;
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdf->Output(plugin_dir_path( __FILE__ ) . 'export_delivery_note_'.$order_id.'.pdf', 'F');
}

function inside_generate_invoice_pdf($order){
    
    $pdf_order = array(); $k = 0;
    foreach ($order->get_items() as $item){
		
    	$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
	$pdf_order['items'][$k]['name'] = $item['name'];
	$pdf_order['items'][$k]['line_total'] = strip_tags(html_entity_decode($item['line_total']));
	$pdf_order['items'][$k]['qty'] = $item['qty'];
	$k++;
}
	
    if ( $totals = $order->get_order_item_totals() ) {
	//var_dump($totals);
	foreach ( $totals as $key=>$value ) :
            if ($key == 'order_total') : 	
                $pdf_order['total']['label'] = $value['label'];
                $pdf_order['total']['value'] = strip_tags(html_entity_decode($value['value']));
            endif;
        endforeach;
	}
	
        $pdf_order['translate']['product'] = __( 'Product', 'woocommerce' );
	$pdf_order['translate']['total'] = __( 'Total', 'woocommerce' );

	$t=0;$ttax=0;
	$is = $order->get_items();
	foreach ($is as $i){
		$t = $t + $i['line_total'];
		$ttax = $ttax + $i['line_tax'];
	}
	$t=round($t);$ttax = round($ttax);
        
    $order_id = $order->id;
    $logo = plugins_url( 'include/images/logo-v2.png' , __FILE__ );
    $title = __( 'Invoice', 'spiralps_Shipping' );
    $greetings = $_POST['greetings'];
    $thankyou = nl2br($_POST['thankyou']);
    $footer = $_POST['footer'];
    $shipping_address = __( "Recipient", 'spiralps_Shipping' );
    $address = $order->get_formatted_billing_address();
    $info_account = $_POST['info_account']; ////
    $info_order = __( 'Order Number', 'spiralps_Shipping' ) . ': <b>' . $order->id . '</b>';
    $info_invoice = __( 'Invoice Number', 'spiralps_Shipping' ) . ': <b>' . $order->id . '</b>';
    $info_date = __( 'Invoice Date', 'spiralps_Shipping' ) . ': <b>' . convert_date(date("Y-m-d")) . '</b>';
    $info_side = __( 'Side', 'spiralps_Shipping' ) . ': <b>1/1</b>';
    //$bellow0 = nl2br($_POST['bellow0']);
    //$bellow1 = nl2br($_POST['bellow1']);
    //$bellow2 = nl2br($_POST['bellow2']);
    $order_details = __( 'Order Details', 'spiralps_Shipping' );
    $item_total = count($order->get_items());
    $items_json = $pdf_order;
    $shipping_cost = $order->order_shipping;
    $shipping_method = $order->get_shipping_method();
    $cart_subtotal = __( 'Cart Subtotal', 'spiralps_Shipping' );
    $shipping_text = "";
    $total_order = $t;
    $total_tax = $total_order +  $shipping_cost;
    $tax_label = __( 'Incl. tax', 'spiralps_Shipping' ); 
    
    $items_table = '<br /><h3 style="padding:30px 0;margin:0;border-bottom: 1px solid #000000;">'.$order_details.'</h3>';
    $items_table .= '<table cellpadding="5px" style="margin-top:20px;">';
    
    $items_table .= '<thead>';
	$items_table .= '<tr>';
		$items_table .= '<th style="width:535px;padding:5px 0;font-weight:bold;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['product']) . '</th>';
		$items_table .= '<th style="width:100px;padding:5px 0;font-weight:bold;text-align:right;border-bottom:1px solid #cccccc">' . strtoupper($items_json['translate']['total']) . '</th>';
	$items_table .= '</tr>';
    $items_table .= '</thead>';

    $items_table .= '<tbody>';
    $lines = 0;
    
    foreach ($items_json['items'] as $item){
	$lines++;
	if ($lines < count($items_json['items'])){
		$border = "border-bottom:1px solid #cccccc";
	} else $border = "";
	$items_table .= '<tr>';
	$items_table .= '<td style="line-height:2px;'.$border.'">' . $item['name'] . '<b>&times;' . $item['qty'] . '</b></td>';
	$items_table .= '<td style="text-align:right;'.$border.'">CHF ' . number_format($item['line_total'], 0, '.', ' ') . '</td>';
	$items_table .= '</tr>';
    }
    
    if ($shipping_cost > 0){
	$subtotal = filter_var($items_json['total']['value'], FILTER_SANITIZE_NUMBER_INT);
	$subtotal = $subtotal - $shipping_cost;
	$subtotal = number_format( $subtotal , 0, '.', ' ');
	$shipping_cost = number_format( $shipping_cost , 0, '.', ' ');
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($cart_subtotal) . ':</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $subtotal . '</b></td>';
	$items_table .= '</tr>';
	$items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($shipping_text) . ' <span style="font-size:10px">('.$shipping_method.')</span>:</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $shipping_cost . '</b></td>';
	$items_table .= '</tr>';
    }
    $items_table .= '</tbody>';

    $items_table .= '<tfoot>';
    
    $items_table .= '<tr>';
		$items_table .= '<th style="border-top:1px solid #000000; text-align:right; color: #999">' . strtoupper($items_json['total']['label']) . '</th>';
		$items_table .= '<td style="border-top:1px solid #000000; text-align:right"><b>CHF ' . $total_tax . '</b></td>';
	$items_table .= '</tr>';
    $items_table .= '</tfoot>';

    $items_table .='</table>';
    
    require_once('include/tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Spiralps.ch');
    $pdf->SetTitle('Spiralps.ch - Printed invoice');

    $pdf->setFooterData(array(0,0,0), array(0,0,0), $footer);

    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
    }
    
    $pdf->setFontSubsetting(true);
    $pdf->SetFont('dejavusans', '', 10, '', true);
    $pdf->AddPage();
    $pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    
    $html = <<<EOD
<div style="text-align:right"><img width="270px" src="$logo" align="right" /></div>
<table>
		<tr>
			<td colspan="2">
				<h2>$title</h2>
				<br />
				<br />
				<h4 style="font-weight:bold">$shipping_address</h4>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left">$address</td>
			<td valign="top" align="right">
				$info_invoice<br />
				$info_date<br />
				$info_side<br />
			</td>
		</tr>

		<tr>
			<td colspan="2">$items_table</td>
		</tr>
		
	</table>
EOD;
    
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    
    $pdf->Output(plugin_dir_path( __FILE__ ) . 'export_invoice_'.$order_id.'.pdf', 'F');
    
}

function inside_generate_labels($order){
    $options = get_option( 'woocommerce_spiralps_shipping_settings' );
	
    $the_date = convert_date($order->order_date);
	
    $pdf_order = array(); $k = 0;
    foreach ($order->get_items() as $item){
		
    	$_product = get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );
	$pdf_order['items'][$k]['name'] = $item['name'];
	$pdf_order['items'][$k]['line_total'] = strip_tags(html_entity_decode($item['line_total']));
	$pdf_order['items'][$k]['qty'] = $item['qty'];
	$k++;
}
	
    if ( $totals = $order->get_order_item_totals() ) {
	//var_dump($totals);
	foreach ( $totals as $key=>$value ) :
            if ($key == 'order_total') : 	
                $pdf_order['total']['label'] = $value['label'];
                $pdf_order['total']['value'] = strip_tags(html_entity_decode($value['value']));
            endif;
        endforeach;
	}
	
        $pdf_order['translate']['product'] = __( 'Product', 'woocommerce' );
	$pdf_order['translate']['total'] = __( 'Total', 'woocommerce' );

	$t=0;$ttax=0;
	$is = $order->get_items();
	foreach ($is as $i){
		$t = $t + $i['line_total'];
		$ttax = $ttax + $i['line_tax'];
	}
	$t=round($t);$ttax = round($ttax);
    
    $spiralps_address = $order->get_formatted_billing_address();
    $spiralps_order_details = "Order Details";
    $spiralps_shipping_cost = $order->order_shipping;
    $spiralps_shipping_method = _e($order->get_shipping_method(), 'theretailer');
    $swisspost_username = $options['swisspost_username'];
    $swisspost_password = $options['swisspost_password'];
    $swisspost_franking = $options['swisspost_franking'];
    $spiralps_shipping_first_name = $order->shipping_first_name;
    $spiralps_shipping_last_name = $order->shipping_last_name;
    $spiralps_shipping_company = $order->shipping_company;
    $spiralps_shipping_address_1 = $order->shipping_address_1;
    $spiralps_shipping_address_2 = $order->shipping_address_2;
    $spiralps_shipping_postcode = $order->shipping_postcode;
    $spiralps_shipping_city = $order->shipping_city;
    $spiralps_billing_phone = $order->billing_phone;
    $spiralps_billing_email = $order->billing_email;
    $spiralps_order_number = _e( 'Order Number', 'spiralps_Shipping' );
    $spiralps_invoice_number = _e( 'Invoice Number', 'spiralps_Shipping' );
    $spiralps_date_number = _e( 'Invoice Date', 'spiralps_Shipping' );
    $spiralps_side_number = _e( 'Side', 'spiralps_Shipping' );
    $spiralps_cart_subtotal = _e( 'Cart Subtotal', 'spiralps_Shipping' );
	
    $order_meta = get_post_meta($order->id, "swisspost_shipping_file");
    $shipping_image = "";
    if ($order_meta){
	$shipping_image = plugins_url("/" . $order_meta[0], __FILE__);
    }
	
    //start swisspost labels::
    
    $frankinglicense = $swisspost_franking;
    $items = $pdf_order;
    $cart_cost = 0;
    foreach ($items['items'] as $item){
	$cart_cost += $item['line_total'];
    }
    $cart_cost += $_POST['shipping_cost'];
    $username = $swisspost_username;
    $password = $swisspost_password;
    $endpoint_url = 'https://www.mypostbusiness.ch/wsbc/barcode/v2_2';
	
	$username = $_POST['TUW003217'];
	$password = $_POST['X5Afld6m[oC_'];
	$endpoint_url = 'https://wsbc.post.ch/wsbc/barcode/v2_2';
	
    //$SOAP_wsdl_file_path=plugins_url('barcode_v2_2.wsdl', __FILE__);
	$SOAP_wsdl_file_path=plugins_url('/swisspost/barcode_v2_2.wsdl', __FILE__);
	
//echo $SOAP_wsdl_file_path;

    $SOAP_config = array(
            'location' => $endpoint_url,
            'login' => $username,
            'password' => $password,
    );
    try {
            $SOAP_Client = new SoapClient($SOAP_wsdl_file_path, $SOAP_config);
    }
    catch (SoapFault $fault) {
            echo('Error in SOAP Initialization: '. $fault -> __toString() .'<br/>');
            exit;
    }
    include("swisspost/wsbc-utils.php");
    
    $generateLabelRequest = array(
        'Language' => 'de',
        'Envelope' => array(
            'LabelDefinition' => array(
                    'LabelLayout' => 'A5',
                    'PrintAddresses' => 'RecipientAndCustomer',
                    'ImageFileType' => 'GIF',
                    'ImageResolution' => 300,
                            'PrintPreview' => false
            ),
            'FileInfos' => array(
                     'FrankingLicense' => $frankinglicense,
                             'PpFranking' => false,
                     'Customer' => array(
                             //'Name1' => $spiralps_shipping_first_name . ' ' . $spiralps_shipping_last_name,
                             //'Street' => $spiralps_shipping_address_1,
                             //'ZIP' => $spiralps_shipping_postcode,
                             //'City' => $spiralps_shipping_city,
                             'Name1' => 'SpirAlps SA',
					         'Street' => 'Rue du Rhône 12',
					         'ZIP' => '1963',
					         'City' => 'Vétroz'
                     ),
                             'CustomerSystem' => 'PHP Client System'
                    ),
                'Data' => array(
                    'Provider' => array(
                        'Sending' => array(
                                            'Item' => array(
                                                    array( // 1.Item ...
                                                            'ItemID' => $order->id,
                                                            'Recipient' => array(
                                                                'Title' => 'Frau',
                                                                    //'Vorname' => $spiralps_shipping_first_name,
                                                                    'Name1' => $spiralps_shipping_first_name . ' ' . $spiralps_shipping_last_name,
                                                                    'Name2' => $spiralps_shipping_company,
                                                                    'Street' => $spiralps_shipping_address_1,
                                                                    'HouseNo' => '21',
                                                                    'ZIP' => $spiralps_shipping_postcode,
                                                                    'City' => $spiralps_shipping_city,
                                                                    //'Country' => 'CH',
                                                                    'Phone' => $spiralps_billing_phone,
                                                                    'EMail' => $spiralps_billing_email
                                                            ),

                                                            'Attributes' => array(
                                                                    'PRZL' => array(
                                                                            'PRI',
                                                                            //'N',
                                                                            //'FRA',
                                                                            //'ZAW3211',
                                                                            //'ZAW3213'
                                                                    ),

                                                                    // Cash on delivery amount in CHF for service 'N':
                                                                    //'Amount' => $cart_cost,
                                                                    //'ProClima' => true
                                                            )
                                                    )
                                            )
                                    )
                            )
                    )
            )
    );
    
    $response = null;
    try {
            $response = $SOAP_Client -> GenerateLabel($generateLabelRequest);
    }
    catch (SoapFault $fault) {
            echo('Error in GenerateLabel: '. $fault -> __toString() .'<br />');
    }
    
    foreach (getElements($response->Envelope->Data->Provider->Sending->Item) as $item) {
	if (@$item->Errors != null) {

      	// Error in Label Request Item:
      	// This barcode label was not generated due to errors.
      	// The received error messages are returned in the specified language of the request.
      	// This means, that the label was not generated,
      	// but other labels from other request items in same call
      	// might have been generated successfully anyway.
      	$errorMessages = "";
      	$delimiter="";
      	foreach (getElements($item->Errors->Error) as $error) {
      		$errorMessages .= $delimiter.$error->Message;
      		$delimiter=",";
      	}
      	echo '<p>ERROR for item with itemID='.$item->ItemID.": ".$errorMessages.'.<br/></p>';

	}
    else {
      	// Get successfully generated label as binary data:
      	$identCode = $item->IdentCode;
   		$labelBinaryData = $item->Label;

	   	// Save the binary image data to image file:
                $dir = plugin_dir_path( __FILE__ );
                $f_name = 'GenerateLabel_'.$order->id.'.gif';
	   	//$filename = $dir . 'swisspost/outputfolder/' . $f_name;
                $filename = $dir . '/' . $f_name;
                
	   	file_put_contents($filename, $labelBinaryData);

                
                delete_post_meta($order->id, "swisspost_shipping_file");
		delete_post_meta($order->id, "swisspost_shipping_ident_code");
                add_post_meta($order->id, "swisspost_shipping_file", $f_name);
		add_post_meta($order->id, "swisspost_shipping_ident_code", $identCode);
                
                        
	   	// Printout some label information (and warnings, if any):
	   	
	   	/**
	   	 * it's used in my plugin
	   	 */
	   	
	   	$message = array();
	   	$message['identCode'] = $identCode;
	   	$message['filename'] = $filename;
	   	
                
                //echo json_encode($message);die();
	   	
	   	
		//echo '<p>Label generated successfully for identCode='.$identCode.': <br/>';
		if (isset($item->Warnings) && $item->Warnings != null) {
			$warningMessages = "";
	      	foreach (getElements($item->Warnings->Warning) as $warning) {
	      		$warningMessages .= $warning->Message.",";
	      	}
	      	//echo 'with WARNINGS: '.$warningMessages.'.<br/>';
	    }
		//echo $filename.':<br/><img src="'.$filename.'"/><br/>';
		//echo '</p>';
	}
}

echo "</body></html>";
    
    //mail("daniel.oraca@gmail.com", 'dee reached!', $order_id);
}