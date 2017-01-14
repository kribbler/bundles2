<?php
/*
Plugin Name: Jigoshop FedEx Shipping Method
Plugin URI: http://jigoshop.com
Description: A FedEx Shipping Module for Jigoshop.
Version: 1.2.4
Author: Sixty-One Designs, Inc.
Author URI: http://www.sixtyonedesigns.com
Requires at least: 3.1
Tested up to: 3.3
 
@copyright  Copyright (c) 2013 Sixty-One Designs, Inc.
@license    Commercial License
*/



add_action('plugins_loaded', 'jigoshop_fedex_init', 0);
function jigoshop_fedex_init() {
	require_once('nusoap/nusoap.php');	
	if ( ! class_exists( 'jigoshop_licence_validator' ) ) {
		require_once( 'licence-validator/licence-validator.php' );
	}	
	
	/*
	 * Fedex Write Panel Tab
	 */
	
	add_action('jigoshop_product_write_panel_tabs','sod_fedex_options',99);
	function sod_fedex_options(){?>
		<li class="fedex_tab fedex_options"><a href="#fedex_data"><?php _e('FedEx Shipping', 'sod_fedex'); ?></a></li>
	<?php }
	/*
	 * Fedex Write Panel Tab Content
	 */
	add_action('jigoshop_product_write_panels','fedex_write_panel',99);
	function fedex_write_panel($post) {
		global $post;
		$fedex_settings	 = get_post_meta($post->ID,'_fedex_ships_separate',true);
		if(isset($fedex_settings)):
			if($fedex_settings == "yes"):
				$checked='checked="checked"';
			else:
				$checked='';
			endif;
		endif;?>
		<div id="fedex_data" class="panel jigoshop_options_panel">
			<p class="form-field">
				<label for="_fedex_ships_separate"><?php _e('Ships Separately?', 'sod_fedex');?></label>
				<input name="_fedex_ships_separate" class="checkbox" <?php echo $checked;?> type="checkbox"/>
			</p>
		</div>	
	<?php 	
	}
	/*
	 * Product Data Save - Admin
	 */
	add_action('jigoshop_process_product_meta', 'fedex_process_individual_package', 999, 1);
	function fedex_process_individual_package($post_id){
		if (isset($_POST['_fedex_ships_separate'])):
			update_post_meta( $post_id, '_fedex_ships_separate', 'yes' );
		else:
			update_post_meta( $post_id, '_fedex_ships_separate', 'no' );
		endif;
	}   
	
	/*
	 * Ajax calls to set / remove residential indicator from customer's session
	 */
	add_action('wp_ajax_set_admin_residential_indicator', 'ajax_admin_set_residential_indicator');
	add_action('wp_ajax_nopriv_set_admin_residential_indicator', 'ajax_user_set_residential_indicator');
	//If logged in as admin
	function ajax_admin_set_residential_indicator(){
		$nonce = $_POST['ajax_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ajax_nonce' ) )
	    die ( 'Busted!');
		$checked = array_key_exists('checked', $_POST)?$_POST['checked']:false;
		if($checked == "checked"):
			fedex_customer::set_residential_indicator(true);
		else:
			fedex_customer::set_residential_indicator(false);
			$checked = false;
		endif;
		echo $checked;
	}
	//if not logged in as admin
	function ajax_user_set_residential_indicator(){
		$nonce = $_POST['ajax_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ajax_nonce' ) )
	    die ( 'Busted!');
		$checked = array_key_exists('checked', $_POST)?$_POST['checked']:false;
		if($checked == "checked"):
			fedex_customer::set_residential_indicator(true);
		else:
			fedex_customer::set_residential_indicator(false);
			$checked = false;
		endif;
		echo $checked;
	}
	/*
	 * Filter fields for checkout page
	 */
	add_filter( 'jigoshop_billing_fields', 'sod_jigoshop_fedex_checkout_fields' );
	function sod_jigoshop_fedex_checkout_fields($fields){
		$new_fields = array( 'type'=>'checkbox','checked'=>'checked','name'=>'residential-indicator','label_class'=>array('fedex-residential'),'class'=>array('fedex-residential'),'label' => __('Residential Address?', 'sod-jigoshop-fedex') );
		array_push($fields,$new_fields);
		return $fields;
	}
	/*
	 * Plugin specific scripts
	 */
	function sod_jigoshop_fedex_scripts(){
			wp_register_script( 'fedex_plugin_js', plugins_url('assets/jigoshop.ajax.js',(__FILE__)));
			wp_register_style( 'fedex_plugin_css', plugins_url('assets/jigoshop.fedex.css',(__FILE__)));
			wp_enqueue_script('fedex_plugin_js');
			wp_enqueue_style('fedex_plugin_css');
			
			$args = array(
				'siteurl'=>get_site_url(),
				'ajax_nonce'=> wp_create_nonce('ajax_nonce'),
				'residential_customer'=>fedex_customer::get_residential_indicator()== true?true:false,
				'admin'=>is_admin()==true?"yes":"no"
			);
			wp_localize_script('fedex_plugin_js','fedex',$args);
		}
	add_action('wp_enqueue_scripts', 'sod_jigoshop_fedex_scripts');
	/*
	 * Override default jigoshop shipping calculator
	 * required until we can get the filter setup on the shipping calculator fields
	 */
	add_action('jigoshop_after_shipping_calculator_fields','sod_fedex_res_indicator');
	function sod_fedex_res_indicator(){
		$current_res_ind = fedex_customer::get_residential_indicator();
		$residential = esc_attr($current_res_ind) == true? 'checked="checked"':false;
		?>
		<div class="col1-set">
				<p class="form-row col-1 fedex-residential">
					<lablel for="calc_shipping_res_indic"><?php _e('Residential Address?','sod-jigoshop-fedex');?></lablel>
					<input type="checkbox" name="calc_shipping_res_indic" <?php echo esc_attr($residential) ;?> id="calc_shipping_res_indic" />
				</p>
			</div>
	<?php }
	
	/*
	 * Fedex Customer Class
	 * extends customer
	 * used to get/set residential indicator
	 */
	if(class_exists('jigoshop_customer')){
		class fedex_customer extends jigoshop_customer{
			/** Sets session data for the country */
			public static function set_residential_indicator( $indicator ) {
		        self::set_customer_session('res_indicator', $indicator);
			}
			public static function get_residential_indicator() {
				if (self::get_customer_session('res_indicator')) return self::get_customer_session('res_indicator');
			}
			private static function set_customer_session($array_index, $value) {
	        	$customer = (array) jigoshop_session::instance()->customer;
	        	$customer[$array_index] = $value;
	        	jigoshop_session::instance()->customer = $customer;
	    	}
		    private static function get_customer_session($array_index) {
		    	$customer = (array) jigoshop_session::instance()->customer;
				if(array_key_exists($array_index, $customer)):
	        		return $customer[$array_index];
				endif;
	    	}
		}
	}

/**
 * Shipping method class
 * */
if(class_exists('jigoshop_calculable_shipping')){
	class fedex extends jigoshop_calculable_shipping {
		var $weight;
		var $destination;
		const HOME_SHOP_URL = 'http://jigoshop.com/'; 
		const IDENTIFIER    = '9698'; 
		const TEXT_DOMAIN   = 'sod-jigoshop-fedex'; 
		function __construct() {
			 
			$base_country = get_option('jigoshop_default_country');
			if(strlen($base_country)>2){
				$country_code = explode(":",$base_country);	
			}else{
				$country_code[0] = $base_country;
			}
			
			// Define user set variables
			$this->id 			= 'fedex';
			$this->indv_boxes 	= get_option('jigoshop_fedex_enable_individual_packaging');
	        $this->enabled		= get_option('jigoshop_fedex_enabled');
			$this->title 		= get_option('jigoshop_fedex_title');
			$this->fedex_debug	= get_option('jigoshop_fedex_debug');
			$this->availability = get_option('jigoshop_fedex_availability');
			$this->countries 	= get_option('jigoshop_fedex_countries');
			$this->tax_status	= get_option('jigoshop_fedex_tax_status');
			$this->insurance 	= get_option('jigoshop_fedex_cart_total_insurance');
			$this->cost 		= get_option('jigoshop_fedex_cost');
			$this->drop_off_type = get_option('jigoshop_fedex_drop_off_type');
			$this->handling_fee = get_option('jigoshop_fedex_handling_fee'); 
			$this->meter_number	= get_option('jigoshop_fedex_meter_number');
			$this->shipper_number = get_option('jigoshop_fedex_shipper_number');
			$this->source_zip	= get_option('jigoshop_fedex_source_zip');
			$this->services		= maybe_unserialize(get_option('jigoshop_fedex_services'));
			//"https://gatewaybeta.fedex.com/GatewayDC" is being decommisionsed 3/2012 - use webservice instead 
			$this->url			= get_option('jigoshop_fedex_webservices_mode')=='sandbox'?'https://gatewaybeta.fedex.com/web-services':'https://ws.fedex.com:443/web-services/rate';//: 'https://ws.fedex.com:443/web-services/rate'
			$this->user_id		= get_option('jigoshop_fedex_username');
			$this->api_key 		= get_option('jigoshop_fedex_api_key');
			$this->password 	= get_option('jigoshop_fedex_password');
			$this->type 		="order";
			$this->shipping_label 	="FedEx";
			$this->weight_unit  = "";
			$this->country_code = $country_code[0];
			$this->dest_country = '';//$customer_country; 
			$this->wsdl 		= get_option('jigoshop_fedex_webservices_mode')=='sandbox'? plugins_url('/wsdl/RateService_v10.wsdl', __FILE__):plugin_dir_path( __FILE__ ).'/wsdl/RateService_v9.wsdl';
			$this->length		= false;
			$this->width		= false;
			$this->height		= false;
			$this->insured_value= 0;
			$this->separate		= array();
			$this->combined		= false;
			$this->package_count= 0;
			$this->dimension_unit = strtoupper(get_option('jigoshop_dimension_unit'));
			$this->current_service = "";
			$this->licence_validator = new jigoshop_licence_validator(
											__FILE__, 
											self::IDENTIFIER, 
											self::HOME_SHOP_URL
										);
			
			if ( ! $this->licence_validator->is_licence_active() ) {
				
					$options = Jigoshop_Base::get_options();
					$options->set_option( 'jigoshop_fedex_enabled', 'no' );
				return;
			}else{
				add_action('jigoshop_update_options', array(&$this, 'process_admin_options'));
				add_option('jigoshop_fedex_availability', 'all');
				add_option('jigoshop_fedex_title', 'FedEx');
				add_option('jigoshop_fedex_status', 'taxable');
			}
		} 
		function get_drop_off_types(){
			$drop_off_types = array(
				'REGULAR_PICKUP'			=>'Regular Pickup', 
				'REQUEST_COURIER'			=>'By Courier Request', 
				'DROP_BOX'					=>'FedEx Drop Box', 
				'BUSINESS_SERVICE_CENTER'	=>'FedEx Service Center',
				'STATION'					=>'FedEx Station'
			);
			$drop_off_types = apply_filters('sod_fedex_drop_off_types', $drop_off_types);
			return $drop_off_types;
		}
		/**
	     * Calculate the shipping cost based on weight, source and destination
	     */
	    function calculate_shipping() {
	    	/*
			 * Initialize
			 */
	    	$available_services 	= $this->services;
			$this->shipping_total 	= 0;
			$this->shipping_tax 	= 0;
			$weight 				= 0;
			$this->length			= false;
			$this->width			= false;
			$this->height			= false;
			$rates 					= array();
    		$this->insured_value 	= 0;
			$separate_weight	 	= 0;
			$weight_unit 			= get_option('jigoshop_weight_unit');
			/*Switch for Multiple Origins Weight Unit*/
			$weight_unit 		 = apply_filters('sod_wc_fedex_weight_unit', $weight_unit); 
			
			/*Switch for Multiple Origins Weight Unit*/
			$this->dimension_unit = apply_filters('sod_wc_fedex_dimensions_unit', $this->dimension_unit);
			/*
			 * Switch weight unit to Fedex specs
			 */
			switch($weight_unit){
				case "lbs":
					$this->weight_unit = "LB";
					break;
				case "kg":
					$this->weight_unit = "KG";
			}
			/*
			 * Get's the weight of the cart
			 */
    		if (sizeof(jigoshop_cart::get_cart())>0) : 
				foreach (jigoshop_cart::get_cart() as $item_id => $values) :
					$_product = $values['data'];
					$_product = new jigoshop_product( $_product->id );
					 if( jigoshop_cart::needs_shipping() ) :
						$ships_separate = get_post_meta($_product->id, '_fedex_ships_separate',true);
						
						$this->insured_value += $_product->get_price() * $values['quantity'];
						$this->package_count= 1;
						if($ships_separate !="yes"):
							$this->combined = true;
							$weight = $weight + ($_product->get_weight() * $values['quantity']);
							if ($_product->has_dimensions(true)) :
	                        	// determine longest product in cart
	                        	if (!$this->length || $this->length < $_product->get_length()) :
									$this->length = $_product->get_length();
		                        endif;
		                        // determine widest product in cart
	    	                    if (!$this->width || $this->width < $_product->get_width()) :
	        	                    $this->width = $_product->get_width();
	            	            endif;
		                        // determine overall height of products in the cart
	    	                    $this->height += $_product->get_height();
	        	       	 	endif;
						else:
							$separate_weight = $_product->get_weight();
							if ($_product->has_dimensions(true)) :
	                        	// determine longest product in cart
	                        	$this->length = $_product->get_length();
		                        // determine widest product in cart
	    	                    $this->width = $_product->get_width();
	            	            // determine overall height of products in the cart
	    	                    $this->height = $_product->get_height();
	        	       	 	endif;
							
							$dimensions = false;
							if($this->length > 0 && $this->width > 0  && $this->height > 0 ):
								$dimensions =  array(
									'Dimensions' => array(
										'Length' => $this->length,
	       								'Width' => $this->width,
	       								'Height' => $this->height,
	       								'Units' => $this->dimension_unit)
									);
									
							endif;
							
							if ($_product->has_dimensions(true)) :
	                        	// determine longest product in cart
	                        	$this->length = $_product->length;
		                        // determine widest product in cart
	    	                    $this->width = $_product->width;
	            	            // determine overall height of products in the cart
	    	                    $this->height = $_product->height;
	        	       	 	endif;
							
							$dimensions = false;
							if($this->length > 0 && $this->width > 0  && $this->height > 0 ):
								$dimensions =  true;
									
							endif;
							
							$this->package_count += $values['quantity'];
							$i = 1;
							while($i <= $values['quantity']):
								if($dimensions):
									$this->separate[] = array(
							    		'SequenceNumber' => $i + 1,
							    		'GroupPackageCount' => 1,
							    		'Weight' => array(
											'Value' => $separate_weight,
							    			'Units' => $this->weight_unit
							    		),
							    		'Dimensions' => array(
											'Length' => $this->length,
		       								'Width' => $this->width,
		       								'Height' => $this->height,
		       								'Units' => $this->dimension_unit)
										);
								else:
									$this->separate[] = array(
							    		'SequenceNumber' => $i + 1,
							    		'GroupPackageCount' => 1,
							    		'Weight' => array(
											'Value' => $separate_weight,
							    			'Units' => $this->weight_unit
							    		),
							    	);
								endif;
								$i +=1;	
							endwhile;
						endif;
					endif;
    			endforeach; 
    		endif;
			
			
			/*
			 * Set the cart's weight
			 */
			$this->weight = $weight;
			
			
			/*
			 * Get customer zip / country from session
			 */
			$this->from_zip_or_pac 	= jigoshop_session::instance()->customer['shipping_postcode'];
			$this->dest_country 	= jigoshop_session::instance()->customer['shipping_country']; 
			
			/*
			 * Calculate rate
			 */
			$this->calculate_rate();
			$this->rates = array_reverse($this->rates);
			/*
			 * Set the cheapest price
			 */
			$cheapest_price = $this->get_cheapest_price();
            if ($cheapest_price != NULL) :
                $this->shipping_total = $cheapest_price;
            endif;
		} 
		/*
		 * Abstract Function: build services array to display labels
		 */
	    function filter_services(){
	    	return false; 
			
		}
		function send_to_shipping_server($xml){
			try{
				$this->wsdl = apply_filters('sod_wc_fedex_wsdl', $this->wsdl); 
				$client = new nusoap_client($this->wsdl, 'wsdl');//$this->_createRateSoapClient();
				$response = $client->call('getRates', array('RateRequest' => $xml));
				return $response;
			}catch (Exception $e){
				return false;
			}
			
		}
		function convert_xml_to_array($xml){
			return $xml;
		}
		/*
		 * Build the Fedex request
		 */
	 	function create_mail_request($service=null) {
	 			/*Filters for switching origin*/ 
	 			$this->api_key 			= apply_filters('sod_wc_fedex_webservices_key', $this->api_key);
				$this->password 		= apply_filters('sod_wc_fedex_webservices_password', $this->password);
				$this->shipper_number 	= apply_filters('sod_wc_fedex_shipper_number', 	$this->shipper_number);
				$this->meter_number 	= apply_filters('sod_wc_fedex_meter_number', 	$this->meter_number);
				$this->source_zip	 	= apply_filters('sod_wc_fedex_source_zip', 	$this->source_zip);
				$this->country_code	 	= apply_filters('sod_wc_fedex_country_code', 	$this->country_code);
 				$request = null;
				$dimensions = false;
				if($this->length > 0 && $this->width > 0  & $this->height > 0 ):
					$dimensions = true;
				endif;
				$request['WebAuthenticationDetail'] = array(
					    'UserCredential' => array(
						'Key' => $this->api_key,
						'Password' => $this->password
					    )
					);
					$request['ClientDetail'] = array(
					    'AccountNumber' => $this->shipper_number,
					    'MeterNumber' => $this->meter_number
					);
					$request['TransactionDetail'] = array('CustomerTransactionId' => 'Rate Request');
					$request['Version'] = array(
					    'ServiceId' => 'crs',
					    'Major' => get_option('jigoshop_fedex_webservices_mode')=='sandbox'? '10':'9',
					    'Intermediate' => '0',
					    'Minor' => '0'
					);
					$request['ReturnTransitAndCommit'] = true;
					$request['RequestedShipment']['DropoffType'] 	= $this->drop_off;//'REGULAR_PICKUP'; // valid values REGULAR_PICKUP, REQUEST_COURIER, ...
					$request['RequestedShipment']['ShipTimestamp'] 	= date('c');
					if($this->insurance == "yes" && $this->insured_value < 10000):
						$request['RequestedShipment']['TotalInsuredValue'] 	= array(
								'Amount'	=>	$this->insured_value,
								'Currency'	=> 	get_option('jigoshop_currency', 'USD')
							);
					endif;
					$request['RequestedShipment']['Shipper'] = array(
					    'Address' => array(
							'PostalCode' => $this->source_zip,
							'CountryCode' => $this->country_code
					    )
					);
					//if($this->enable_res == "yes"):
						$request['RequestedShipment']['Recipient'] = array(
						    'Address' => array(
								'PostalCode' => $this->from_zip_or_pac,
								'CountryCode' => $this->dest_country,
								'Residential' => fedex_customer::get_residential_indicator()==true?true:false,
						    )
						);
					// else:
						// $request['RequestedShipment']['Recipient'] = array(
						    // 'Address' => array(
								// 'PostalCode' =>  $this->from_zip_or_pac,
								// 'CountryCode' => $this->dest_country,
							// )
						// );
					// endif;
					$request['RequestedShipment']['ShippingChargesPayment'] = array(
					    'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
					    'Payor' => array(
							'AccountNumber' => $this->shipper_number,
							'CountryCode' => $this->country_code
					    )
					);
					$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; // LIST or ACCOUNT
					//$request['RequestedShipment']['PackageDetail'] = 'PACKAGE_GROUPS';
					$request['RequestedShipment']['PackageCount'] = $this->package_count;
					if($this->combined):
						if($dimensions):
							$request['RequestedShipment']['RequestedPackageLineItems'][] = array(
							    'SequenceNumber' => 1,
							    'GroupPackageCount' => 1,
							    'Weight' => array(
									'Value' => $this->weight,
							    	'Units' => $this->weight_unit
							    ),
							    'Dimensions' => array(
									'Length' => $this->length,
		       						'Width' => $this->width,
		       						'Height' => $this->height,
		       						'Units' => $this->dimension_unit
								)
							);
							else:
							$request['RequestedShipment']['RequestedPackageLineItems'][] = array(
							    'SequenceNumber' => 1,
							    'GroupPackageCount' => 1,
							    'Weight' => array(
									'Value' => $this->weight,
							    	'Units' => $this->weight_unit
							    )
							);
							endif;
						
					endif;
					if($this->separate):
						foreach($this->separate as $package){
							$request['RequestedShipment']['RequestedPackageLineItems'][] = $package;				
						}
					endif;
					
					return $request;
		}  
	protected function get_services_from_response($array_response) {
			
			if (!$array_response || (is_array($array_response) && count($array_response) == 0))
                return array();
           	$services			= array();
			$filtered 			= array();
			$this->services 	= apply_filters('sod_wc_fedex_chosen_services', maybe_unserialize($this->services));
			$selected_services 	= maybe_unserialize($this->services);
			$available_services = $this->get_available_services();
			
			if($selected_services && !empty($selected_services)){
				foreach($selected_services as $key=>$value){
					$filtered[$key] = $available_services[$key]; 
				}
			}
			
			if(array_key_exists('RateReplyDetails', $array_response)):
					
	            foreach ($array_response['RateReplyDetails'] as $key => $value) :
					
					if(array_key_exists($value['ServiceType'], $filtered)):
	                    $services[] = $this->get_label($array_response['RateReplyDetails'][$key]['ServiceType']);
					endif;
	            endforeach;
			endif;
			
			return $services;
        }
	function retrieve_rate_from_response($object_response, $service = ''){
		if ( current_user_can( 'manage_options' ) ) :
			if($this->fedex_debug=="yes"):
				error_log(print_r('Retrieve Rate From Response Failure: ', true), 3, plugin_dir_path(__FILE__) . "/fedex.log");
				error_log(print_r($object_response, true), 3, plugin_dir_path(__FILE__) . "/fedex.log");
			endif;
		endif;
			
		$rate = null;
		$rates = array();
		
		if($object_response):
			
			if($object_response['RateReplyDetails']):
				
				//$rates = $object_response['RateReplyDetails'];
				
				if(count($object_response['RateReplyDetails']['RatedShipmentDetails']) > 2):
				
					foreach($object_response['RateReplyDetails'] as $rates){
						
						if($rates['ServiceType']==$this->get_code($service)):
							$rate = $rates['RatedShipmentDetails'][0]['ShipmentRateDetail']['TotalNetCharge']['Amount'];
							$rate = apply_filters('sod_fedex_rate_response', $rate, $rates, __FILE__ );
							if((int)$rate > 0):
								$this->fee	= get_option('jigoshop_fedex_handling_fee');
								return  $rate;	
							else:
								$this->fee = false;
								return false;
							endif;
						endif;
					}
				else:
					foreach($object_response['RateReplyDetails'] as $key=>$value){
						if($object_response['RateReplyDetails'][$key]['ServiceType']==$this->get_code($service)):
							$rate = $object_response['RateReplyDetails'][$key]['RatedShipmentDetails'][0]['ShipmentRateDetail']['TotalNetCharge']['Amount'];
							if((int)$rate > 0):
								$this->fee	= get_option('jigoshop_fedex_handling_fee');
								return  $rate;	
							else:
								$this->fee = false;
								return false;
							endif;
						endif;
					}
				endif;
			else:
				$this->fee = false;
				return false;
			endif;
		endif;
		
	}
	
	protected function calculate_shipping_tax($rate){
		$_tax = $this->get_tax();
        $tax_rate = $_tax->get_shipping_tax_rate();
        if ($tax_rate > 0) :
            return $_tax->calc_shipping_tax($rate, $tax_rate);
        endif;
        return 0;
	}
	    /**
		 * Admin Panel Options 
		 * - Options for bits like 'title' and availability on a country-by-country basis
		 *
		 * @since 1.0.0
		 */
	  public function process_admin_options() {
	   		if(isset($_POST['jigoshop_fedex_tax_status'])) update_option('jigoshop_fedex_tax_status', jigowatt_clean($_POST['jigoshop_fedex_tax_status'])); else @delete_option('jigoshop_fedex_tax_status');
	   		if(isset($_POST['jigoshop_fedex_services'])){
	   				$services = array();
	   				$services = (array)$_POST['jigoshop_fedex_services'];
	   					update_option('jigoshop_fedex_services', jigowatt_clean(serialize($services)));
	   			} else{
	   				@delete_option('jigoshop_fedex_services');
	   			} 
			
			if(isset($_POST['jigoshop_fedex_cart_total_insurance'])) update_option('jigoshop_fedex_cart_total_insurance', jigowatt_clean($_POST['jigoshop_fedex_cart_total_insurance'])); else @delete_option('jigoshop_fedex_cart_total_insurance');
	   		if(isset($_POST['jigoshop_fedex_enable_individual_packaging'])) update_option('jigoshop_fedex_enable_individual_packaging', jigowatt_clean($_POST['jigoshop_fedex_enable_individual_packaging'])); else @delete_option('jigoshop_fedex_enable_individual_packaging');
	   		if(isset($_POST['jigoshop_fedex_debug'])) update_option('jigoshop_fedex_debug', jigowatt_clean($_POST['jigoshop_fedex_debug'])); else @delete_option('jigoshop_fedex_debug');
	   		if(isset($_POST['jigoshop_fedex_enabled'])) update_option('jigoshop_fedex_enabled', jigowatt_clean($_POST['jigoshop_fedex_enabled'])); else @delete_option('jigoshop_fedex_enabled');
	   		if(isset($_POST['jigoshop_fedex_shipper_number'])) update_option('jigoshop_fedex_shipper_number', jigowatt_clean($_POST['jigoshop_fedex_shipper_number'])); else @delete_option('jigoshop_fedex_shipper_number');
	   		if(isset($_POST['jigoshop_fedex_title'])) update_option('jigoshop_fedex_title', jigowatt_clean($_POST['jigoshop_fedex_title'])); else @delete_option('jigoshop_fedex_title');
	   		if(isset($_POST['jigoshop_fedex_availability'])) update_option('jigoshop_fedex_availability', jigowatt_clean($_POST['jigoshop_fedex_availability'])); else @delete_option('jigoshop_fedex_availability');
	   		if(isset($_POST['jigoshop_fedex_handling_fee'])) update_option('jigoshop_fedex_handling_fee', jigowatt_clean($_POST['jigoshop_fedex_handling_fee'])); else @delete_option('jigoshop_fedex_handling_fee');
			if(isset($_POST['jigoshop_fedex_enabled'])) update_option('jigoshop_fedex_enabled', jigowatt_clean($_POST['jigoshop_fedex_enabled'])); else @delete_option('jigoshop_fedex_status');
	   		if(isset($_POST['jigoshop_fedex_title'])) update_option('jigoshop_fedex_title', jigowatt_clean($_POST['jigoshop_fedex_title'])); else @delete_option('jigoshop_fedex_cost');
	   		if(isset($_POST['jigoshop_fedex_username'])) update_option('jigoshop_fedex_username', jigowatt_clean($_POST['jigoshop_fedex_username'])); else @delete_option('jigoshop_fedex_username');
	   		if(isset($_POST['jigoshop_fedex_meter_number'])) update_option('jigoshop_fedex_meter_number', jigowatt_clean($_POST['jigoshop_fedex_meter_number'])); else @delete_option('jigoshop_fedex_meter_number');
	   		if(isset($_POST['jigoshop_fedex_password'])) update_option('jigoshop_fedex_password', jigowatt_clean($_POST['jigoshop_fedex_password'])); else @delete_option('jigoshop_fedex_password');
			if(isset($_POST['jigoshop_fedex_api_key'])) update_option('jigoshop_fedex_api_key', jigowatt_clean($_POST['jigoshop_fedex_api_key'])); else @delete_option('jigoshop_fedex_api_key');
			if(isset($_POST['jigoshop_fedex_webservices_mode'])) update_option('jigoshop_fedex_webservices_mode', jigowatt_clean($_POST['jigoshop_fedex_webservices_mode'])); else @delete_option('jigoshop_fedex_webservices_mode');
			if(isset($_POST['jigoshop_fedex_source_zip'])) update_option('jigoshop_fedex_source_zip', jigowatt_clean($_POST['jigoshop_fedex_source_zip'])); else @delete_option('jigoshop_fedex_source_zip');
	   		if(isset($_POST['jigoshop_fedex_cost'])) update_option('jigoshop_fedex_cost', jigowatt_clean($_POST['jigoshop_fedex_cost'])); else @delete_option('jigoshop_fedex_cost');
	   		if (isset($_POST['jigoshop_fedex_countries'])) $selected_countries = $_POST['jigoshop_fedex_countries']; else $selected_countries = array();
		    update_option('jigoshop_fedex_countries', $selected_countries);
	   		
	    }
	 public function admin_options() {
	 	?>
    	<thead><tr><th scope="col" colspan='2'><h3 class="title"><?php _e('FedEx Rates', 'sod-jigoshop-fedex'); ?></h3><p><?php _e('FedEx Rates let you pull in real-time FedEx shipping rates for your orders.', 'sod-jigoshop-fedex'); ?></p></th></tr></thead>
    	<tr>
	        <td class="titledesc"><?php _e('Enable FedEx Rates', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_fedex_enabled" id="jigoshop_fedex_enabled" style="min-width:100px;">
		            <option value="yes" <?php if (get_option('jigoshop_fedex_enabled') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'sod-jigoshop-fedex'); ?></option>
		            <option value="no" <?php if (get_option('jigoshop_fedex_enabled') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'sod-jigoshop-fedex'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('This controls the title which the user sees during checkout.','sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('Method Title', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <input type="text" name="jigoshop_fedex_title" id="jigoshop_fedex_title" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_title')) echo $value; else echo 'Flat Rate'; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Use FedEx Sandbox Mode for testing. Only use production mode if you have a Production API Key and Password from FedEx.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Webservices Mode', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
	        	<select name="jigoshop_fedex_webservices_mode" id="jigoshop_fedex_webservices_mode" style="min-width:50px;">
	        		<option value="sandbox" <?php if (get_option('jigoshop_fedex_webservices_mode')=="sandbox") echo 'selected="selected"'; ?>>Sandbox</option>
	        		<option <?php if (get_option('jigoshop_fedex_webservices_mode')=="production") echo 'selected="selected"'; ?> value="production" >Production</option>
	        	
	        	</select>
		    </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your FedEx Web Services Access Key.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Access Key', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_fedex_api_key" id="jigoshop_fedex_api_key" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_api_key')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your FedEx WebServices password. This should have been supplied to you when you requested Web Services Access.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Web Services Password', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		      <input type="password" name="jigoshop_fedex_password" id="jigoshop_fedex_password" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_password')) echo $value; ?>" />
	        </td>
	    </tr>
	     <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('You\'ll need to get your meter number. If you don\'t know what that is, please contact your FedEx account representative or go to http://www.fedex.com', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Meter Number', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_fedex_meter_number" id="jigoshop_fedex_meter_number" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_meter_number')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your FedEx Account Number. If you don\'t have a FedEx Account Number, you can get one at htp://www.fedex.com.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Account Number', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_fedex_shipper_number" id="jigoshop_fedex_shipper_number" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_shipper_number')) echo $value; ?>" />
	        </td>
	    </tr>
	     <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your postal code.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Source Postal Code', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_fedex_source_zip" id="jigoshop_fedex_source_zip" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_source_zip')) echo $value; ?>" />
	        </td>
	    </tr>
	    
	    <?php $_tax = new jigoshop_tax(); ?>
	    <tr>
	        <td class="titledesc"><?php _e('Tax Status', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
	        	<select name="jigoshop_fedex_tax_status">
	        		<option value="taxable" <?php if (get_option('jigoshop_fedex_tax_status')=='taxable') echo 'selected="selected"'; ?>><?php _e('Taxable', 'sod-jigoshop-fedex'); ?></option>
	        		<option value="none" <?php if (get_option('jigoshop_fedex_tax_status')=='none') echo 'selected="selected"'; ?>><?php _e('None', 'sod-jigoshop-fedex'); ?></option>
	        	</select>
	        </td>
	    </tr>
	    <tr>
	    	<td class="titledesc"><a href="#" tip="<?php _e('FedEx Shipping Methods you\'d like to offer to your customers based on what services FedEx offers from your country.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('FedEx Methods', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
	        	<ul>
	        	<?php  
	        		$checked="";
	        		$services = $this->get_available_services();
					$methods = maybe_unserialize(get_option('jigoshop_fedex_services'));	
					
					if($services && !empty($services)){
						foreach($services as $key=>$value){
							if($methods && array_key_exists($key,$methods)){
								$checked = $methods[$key] =='on'?'checked="checked"':"";
									
							}else{
								$checked = null;
							};
							 
					?>		<li><input type="checkbox" name="jigoshop_fedex_services[<?php echo $key;?>]" id="jigoshop_fedex_services[<?php echo $key;?>]" style="min-width:50px;" <?php echo $checked;?> /><?php echo $value;?></li>
		        <?php }
					};?>
		        </ul>
	        </td>
	    </tr>
	    <tr>
	    	<td class="titledesc"><?php _e('Drop-Off Type', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
	        	<select name="jigoshop_fedex_drop_off_type" id="jigoshop_fedex_drop_off_type" style="min-width:100px;">
		        	<?php 
		        		$dropoff_type = $this->get_drop_off_types();
		        		foreach($dropoff_type as $key=>$value):?>
		            		<option value="<?php echo $key;?>" <?php if (get_option('jigoshop_fedex_drop_off_type') == $key) echo 'selected="selected"'; ?>><?php _e($value, 'sod-jigoshop-fedex'); ?></option>
		           	<?php 
		           		endforeach;
		           	?>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enable the option to specify whether you\'d like the cart total to be used for the Declared Value in the FedEx Rate Request.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('Enable/Disable Declared Value in Rate Request', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_fedex_cart_total_insurance" id="jigoshop_fedex_cart_total_insurance" style="min-width:100px;">
		            <option value="yes" <?php if (get_option('jigoshop_fedex_cart_total_insurance') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'sod-jigoshop-fedex'); ?></option>
		            <option value="no" <?php if (get_option('jigoshop_fedex_cart_total_insurance') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'sod-jigoshop-fedex'); ?></option>
		        </select>
	        </td>
	    </tr>
	      <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enable the option to output the results of the FedEx response when logged in as an admin. The output of the FedEx response is written to /wp-content/plugins/jigoshop-fedex/fedex.log.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('Enable/Disable FedEx Rate Request Debugging', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_fedex_debug" id="jigoshop_fedex_debug" style="min-width:100px;">
		            <option value="yes" <?php if (get_option('jigoshop_fedex_debug') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'sod-jigoshop-fedex'); ?></option>
		            <option value="no" <?php if (get_option('jigoshop_fedex_debug') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'sod-jigoshop-fedex'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Fee excluding tax. Enter an amount, e.g. 2.50, or a percentage, e.g. 5%. Leave blank to disable.', 'sod-jigoshop-fedex') ?>" class="tips" tabindex="99"></a><?php _e('Handling Fee', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <input type="text" name="jigoshop_fedex_handling_fee" id="jigoshop_fedex_handling_fee" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_fedex_handling_fee')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><?php _e('Method available for', 'sod-jigoshop-fedex') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_fedex_availability" id="jigoshop_fedex_availability" style="min-width:100px;">
		            <option value="all" <?php if (get_option('jigoshop_fedex_availability') == 'all') echo 'selected="selected"'; ?>><?php _e('All allowed countries', 'sod-jigoshop-fedex'); ?></option>
		            <option value="specific" <?php if (get_option('jigoshop_fedex_availability') == 'specific') echo 'selected="selected"'; ?>><?php _e('Specific Countries', 'sod-jigoshop-fedex'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <?php
    	$countries = jigoshop_countries::$countries;
    	asort($countries);
    	$selections = get_option('jigoshop_fedex_countries', array());
    	?><tr class="multi_select_countries">
            <td class="titledesc"><?php _e('Specific Countries', 'sod-jigoshop-fedex'); ?>:</td>
            <td class="forminp">
            	<div class="multi_select_countries"><ul><?php
        			if ($countries) foreach ($countries as $key=>$val) :
            			                    			
        				echo '<li><label><input type="checkbox" name="jigoshop_fedex_countries[]" value="' . esc_attr( $key ) . '" ';
        				if (in_array($key, $selections)) echo 'checked="checked"';
        				echo ' />'. __($val, 'sod-jigoshop-fedex') .'</label></li>';

            		endforeach;
       			?></ul></div>
       		</td>
       	</tr>
       	<script type="text/javascript">
		jQuery(function() {
			jQuery('select#jigoshop_fedex_availability').change(function(){
				if (jQuery(this).val()=="specific") {
					jQuery(this).parent().parent().next('tr.multi_select_countries').show();
				} else {
					jQuery(this).parent().parent().next('tr.multi_select_countries').hide();
				}
			}).change();
		});
		</script>
    	<?php
    }
		function get_available_services(){
			$country_code = apply_filters('sod_wc_fedex_country_code_admin', 	$this->country_code);
			$eu_array = array(
				'FR','BE','LU','NL','DE','IT','GB','IE','DK','GR','PT','ES','SE','FI','AT',	'MT','HU','EE','CZ','PL','LV','CY',"LT",'SI','SK','BG','RO'
			);
			if(in_array($this->country_code,$eu_array)){
				$country_code = "EU";
			};
				switch($country_code){
					case("EU"):
						$services = array(
							'EUROPE_FIRST_INTERNATIONAL_PRIORITY' => 'Europe First',
							'INTERNATIONAL_ECONOMY' => 'International Economy',
							'INTERNATIONAL_FIRST' => 'International First',
							'INTERNATIONAL_PRIORITY' =>'International Priority',
						);	
						break;		
					case("US"):
						$services = array(
							'PRIORITY_OVERNIGHT'     => 'FedEx Priority Overnight',
							'STANDARD_OVERNIGHT'     => 'FedEx Standard Overnight',
							'FIRST_OVERNIGHT'        => 'FedEx First Overnight',
							'FEDEX_2_DAY'             => 'FedEx 2 Day',
							'FEDEX_EXPRESS_SAVER'     => 'FedEx Express Saver',
							'FEDEX_GROUND'           => 'FedEx Ground',
							'GROUND_HOME_DELIVERY'    => 'FedEx Home Delivery',
							'INTERNATIONAL_ECONOMY' => 'International Economy',
							'INTERNATIONAL_FIRST' => 'International First',
							'INTERNATIONAL_PRIORITY' =>'International Priority',
							'FEDEX_1_DAY_FREIGHT'		=> 'FedEx 1 Day Freight',
            				'FEDEX_2_DAY_FREIGHT'		=> 'FedEx 2 Day Freight',
            				'FEDEX_3_DAY_FREIGHT'		=> 'FedEx 3 Day Freight',
						);
						break;
					case("CA"):
						$services = array(
							'PRIORITY_OVERNIGHT'     => 'FedEx Priority Overnight',
							'STANDARD_OVERNIGHT'     => 'FedEx Standard Overnight',
							'FIRST_OVERNIGHT'        => 'FedEx First Overnight',
							'FEDEX_2_DAY'            => 'FedEx 2 Day',
							'FEDEX_EXPRESS_SAVER'    => 'FedEx Economy',
							'FEDEX_GROUND'           => 'FedEx Ground',
							//'FEDEX_ECONOMY'		     => 'FedEx Economy',
							'EUROPE_FIRST_INTERNATIONAL_PRIORITY' => 'Europe First',
							'INTERNATIONAL_ECONOMY' => 'International Economy',
							'INTERNATIONAL_FIRST' => 'International First',
							'INTERNATIONAL_PRIORITY' =>'International Priority',
						);
						break;
					case("SG"):
						$services = array(
							'INTERNATIONAL_ECONOMY' => 'International Economy',
							'INTERNATIONAL_FIRST' => 'International First',
							'INTERNATIONAL_PRIORITY' =>'International Priority',
						);
						break;

					default:
						$services = array(
						'PRIORITY_OVERNIGHT'     => 'FedEx Priority Overnight',
							'STANDARD_OVERNIGHT'     => 'FedEx Standard Overnight',
							'FIRST_OVERNIGHT'        => 'FedEx First Overnight',
							'FEDEX_2_DAY'             => 'FedEx 2 Day',
							'FEDEX_EXPRESS_SAVER'     => 'FedEx Express Saver',
							'FEDEX_GROUND'           => 'FedEx Ground',
							'GROUND_HOME_DELIVERY'    => 'FedEx Home Delivery',
						);	
						break;
				};
				apply_filters('sod_fedex_services', $services);
				return $services;
		}
		function get_label($selected_service_code){
			$services = $this->get_available_services();
			foreach($services as $key=>$value){
				if($selected_service_code == $key){
					$label = $value;
				}	
			}	
			return $label;
		}
		function get_code($selected_service_label){
			$services = $this->get_available_services();
			foreach($services as $key=>$value){
				if($selected_service_label == $value){
					$code = $key;
				}	
			}	
			return $code;
		}
	}
	}
}
add_filter('jigoshop_shipping_methods', 'add_fedex_rate_method' );
function add_fedex_rate_method( $methods ) {
	$methods[] = 'fedex'; return $methods;
}

