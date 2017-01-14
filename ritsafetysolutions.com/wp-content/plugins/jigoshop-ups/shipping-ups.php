<?php
/*
Plugin Name: Jigoshop UPS Shipping Method
Plugin URI: http://jigoshop.com
Description: A UPS Shipping Module for Jigoshop.
Version: 1.0.11
Author: Sixty-One Designs, Inc
Author URI: http://www.sixtyonedesigns.com
Requires at least: 3.1
Tested up to: 3.3
 
@copyright  Copyright (c) Sixty-One Designs, Inc.
@license    Commercial License
*/
add_action('jigoshop_shipping_init', 'jigoshop_ups_init');
function jigoshop_ups_init() {
	if ( ! class_exists( 'jigoshop_licence_validator' ) ) {
		require_once( 'licence-validator/licence-validator.php' );
	}	
	/**
	 * Shipping method class
	 * */
if(class_exists('jigoshop_calculable_shipping')){
	
	class ups extends jigoshop_calculable_shipping {
		var $weight;
		var $destination;
		const HOME_SHOP_URL = 'http://jigoshop.com/'; 
		const IDENTIFIER    = '9444'; 
		const TEXT_DOMAIN   = 'sod-jigoshop-ups'; 
		function __construct() { 
			$base_country = get_option('jigoshop_default_country');
			if(strlen($base_country)>2){
				$country_code = explode(":",$base_country);	
			}else{
				$country_code[0] = $base_country;
			}
			
			// Define user set variables
			$this->id 			= 'ups';
	        $this->enabled		= get_option('jigoshop_ups_enabled');
			$this->title 		= get_option('jigoshop_ups_title');
			$this->availability = get_option('jigoshop_ups_availability');
			$this->countries 	= get_option('jigoshop_ups_countries');
			$this->tax_status	= get_option('jigoshop_ups_tax_status');
			$this->cost 		= get_option('jigoshop_ups_cost');
			$this->fee 			= get_option('jigoshop_ups_handling_fee'); 
			$this->api_key		= get_option('jigoshop_ups_api_key');
			$this->shipper_number = get_option('jigoshop_ups_shipper_number');
			$this->ups_username	= get_option('jigoshop_ups_username');
			$this->ups_password	= get_option('jigoshop_ups_password');
			$this->source_zip	= get_option('jigoshop_ups_source_zip');
			$this->services		= get_option('jigoshop_ups_services'); 
			$this->url			= "https://onlinetools.ups.com/ups.app/xml/Rate";
			$this->user_id		= get_option('jigoshop_ups_username');
			$this->type 		="order";
			$this->shipping_label 		="UPS";
			$this->weight_unit  = "";
			$this->length		= false;
			$this->width		= false;
			$this->height		= false;
			$this->insured_value = 0;
			$this->country_code = $country_code[0];
			$this->dimension_unit = strtoupper(get_option('jigoshop_dimension_unit'));
			//$this->dest_zip 	= jigoshop_session::instance()->customer{shipping_postcode};
			//$this->dest_country = jigoshop_session::instance()->customer{shipping_country}; 
			$this->licence_validator = new jigoshop_licence_validator(
											__FILE__, 
											self::IDENTIFIER, 
											self::HOME_SHOP_URL
										);
			
			if ( ! $this->licence_validator->is_licence_active() ) {
				
					$options = Jigoshop_Base::get_options();
					$options->set_option( 'jigoshop_ups_enabled', 'no' );
				return;
			}else{
				add_action('jigoshop_update_options', array(&$this, 'process_admin_options'));
				add_option('jigoshop_ups_availability', 'all');
				add_option('jigoshop_ups_title', 'UPS');
				add_option('jigoshop_ups_status', 'taxable');
				add_action('woocommerce_process_product_meta', array(&$this, 'ups_process_individual_package'), 999, 1);
				add_action('woocommerce_product_options_shipping', array(&$this,  'fedex_individual_package' ),999);
				add_action('jigoshop_product_write_panel_tabs',array(&$this,'sod_fedex_options'),99);
				add_action('jigoshop_product_write_panels',array(&$this,'fedex_write_panel'),99);
				add_action('jigoshop_process_product_meta',array(&$this, 'fedex_process_individual_package'), 999, 1);
			}
		} 

		
		function sod_fedex_options(){?>
			<li class="ups_tab ups_options"><a href="#ups_data"><?php _e('UPS Shipping', 'sod_fedex'); ?></a></li>
		<?php }
		/*
		 * Fedex Write Panel Tab Content
		 */
		
		function fedex_write_panel($post) {
			global $post;
			$fedex_settings	 = get_post_meta($post->ID,'_ups_ships_separate',true);
			if(isset($fedex_settings)):
				if($fedex_settings == "yes"):
					$checked='checked="checked"';
				else:
					$checked='';
				endif;
			endif;?>
			<div id="ups_data" class="panel jigoshop_options_panel">
				<p class="form-field">
					<label for="_ups_ships_separate"><?php _e('Ships Separately?', 'sod_ups');?></label>
					<input name="_ups_ships_separate" class="checkbox" <?php echo $checked;?> type="checkbox"/>
				</p>
			</div>	
		<?php 	
		}
		/*
		 * Product Data Save - Admin
		 */
		
		function fedex_process_individual_package($post_id){
			if (isset($_POST['_ups_ships_separate'])):
				update_post_meta( $post_id, '_ups_ships_separate', 'yes' );
			else:
				update_post_meta( $post_id, '_ups_ships_separate', 'no' );
			endif;
		}   
		/**
	     * Calculate the shipping cost based on weight, source and destination
	     */
	    function calculate_shipping() {
	    	global $current_user;
	    	$available_services = unserialize($this->services);
			$this->shipping_total 	= 0;
			$this->shipping_tax 	= 0;
			$this->insured_value 	= 0;
			$this->length			= false;
			$this->width			= false;
			$this->height			= false;
	    	$weight 				= 0;
			$rates 					= array();
    		$this->combined 		= false;
    		$this->separate			= false;
			$weight_unit = get_option('jigoshop_weight_unit');
			switch($weight_unit){
				case "lbs":
					$this->weight_unit = "LBS";
					break;
				case "kg":
					$this->weight_unit = "KGS";
			}
	    	// Get the weight of the cart
    		if (sizeof(jigoshop_cart::get_cart())>0) : 
				foreach (jigoshop_cart::get_cart() as $item_id => $values) :
					$_product = $values['data'];
					$_product = new jigoshop_product( $_product->id );
					
					/*DW Added Qty for items in cart*/ 
					 if( jigoshop_cart::needs_shipping() ) :
						$ships_separate = get_post_meta($_product->id, '_ups_ships_separate',true);
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
	                        	$this->ind_length = $_product->get_length();
		                        // determine widest product in cart
	    	                    $this->ind_width = $_product->get_width();
	            	            // determine overall height of products in the cart
	    	                    $this->ind_height = $_product->get_height();
								$this->ind_insured_value = $_product->get_price_excluding_tax($values['quantity']); 
	        	       	 	endif;
							$ind_dimensions = false;
							if($this->ind_length > 0 && $this->ind_width > 0  && $this->ind_height > 0 ):
								$ind_dimensions =  true;
							endif;
							
							$this->package_count += $values['quantity'];
							$i = 1;
							
							while($i <= $values['quantity']):
								if($ind_dimensions):
									$this->separate[] =	'<Package>  
												<PackagingType>  
					    							<Code>02</Code> 
													</PackagingType>
													<Dimensions>
														<UnitOfMeasurement>
															<Code>'.$this->dimension_unit.'</Code>
														</UnitOfMeasurement>
														<Length>'.$this->ind_length.'</Length>
														<Width>'.$this->ind_width.'</Width>
														<Height>'.$this->ind_height.'</Height>
													</Dimensions>  
													<PackageWeight>  
						    							<UnitOfMeasurement>  
														<Code>'.$this->weight_unit.'</Code>  
						    							</UnitOfMeasurement>  
						    							<Weight>'.$separate_weight.'</Weight>  
													</PackageWeight>
													<PackageServiceOptions>
														<InsuredValue>
															<CurrencyCode>USD</CurrencyCode>
															<MonetaryValue>'.$this->ind_insured_value.'</MonetaryValue>
														</InsuredValue>
													</PackageServiceOptions>  
				    						</Package>';  
							    else:
									$this->separate[] = '<Package>  
												<PackagingType>  
					    							<Code>02</Code> 
													</PackagingType>
													<PackageWeight>  
						    							<UnitOfMeasurement>  
														<Code>'.$this->weight_unit.'</Code>  
						    							</UnitOfMeasurement>  
						    							<Weight>'.$separate_weight.'</Weight>  
													</PackageWeight>
													<PackageServiceOptions>
														<InsuredValue>
															<CurrencyCode>USD</CurrencyCode>
															<MonetaryValue>'.$this->ind_insured_value.'</MonetaryValue>
														</InsuredValue>
													</PackageServiceOptions>  
				    					</Package>';
							    endif;
								$i +=1;	
							endwhile;
							
						endif;
						
					endif;
    			endforeach; 
    		endif;
			
			if($weight > 0 && $weight < 1):
				$weight = 1;
			endif;
			
			$this->weight = $weight;
			//Make UPS call for the order
			/*DW 3/5/2011*/
			$this->dest_zip 	= jigoshop_customer::get_shipping_postcode();
			$this->dest_country = jigoshop_customer::get_shipping_country();
			
			if(!$this->dest_zip ):
				$this->set_error_message('Please enter a postal code to receive UPS rates');
			endif;
	     	$this->calculate_rate();
			$cheapest_price = $this->get_cheapest_price();
			
            if (!empty($cheapest_price) && $cheapest_price > 0 &&  $cheapest_price!= NULL) :
                $this->shipping_total = $cheapest_price;
			else:
				$this->has_error = empty($this->rates);
            endif;
			
		}
		
		/*
		 * Abstract Function: build services array to display labels
		 */
	    function filter_services(){
	    	$rates = unserialize($this->services);
			$filtered = array();
			$services = $this->get_available_services();
			if($rates && !empty($rates)){
				foreach($rates as $key=>$value){
					$filtered[] = $services[$key]; 
				}
			}
			
			return $filtered; 
		}
		/*
		 * Abstract Funcion: return UPS request
		 */
	    function create_mail_request($service=""){
	    	$services = $this->get_available_services();
			$services = apply_filters('sod_jigoshop_ups_available_service', $services);
	    	$code 	 = $this->get_code($service, $services);
			$request = $this->rate_request($code);
			
			return $request;
			
	    }
		/*
		 * Parse out the response from UPS and add any fees associated with the method from wp-admi
		 */
		function retrieve_rate_from_response($array_response, $service = ''){
			
			$shipping_amount = -1;
			if($array_response && array_key_exists('RATEDSHIPMENT', $array_response['RATINGSERVICESELECTIONRESPONSE'])):
				$array_response 	= apply_filters('sod_jigoshop_ups_response', $array_response);
				$shipping_amount 	= $array_response['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE'];
				if($shipping_amount){
					$this->fee		= get_option('jigoshop_ups_handling_fee');
					$shipping_amount;	
				}else{
					$shipping_amount = -1;
					$this->fee 		= false;
				}
				else:
					$shipping_amount = -1;
					$this->fee 		= false;
			endif;
			       
            return $shipping_amount;
		}
		/*
		 * Build the UPS request
		 */
	 	function rate_request($service) {
	 		$dimensions = '';
			$for_display = false;
			$apply_discount_and_shipping = false;
			$insurance = jigoshop_cart::get_cart_subtotal($for_display,$apply_discount_and_shipping);
			
	 		//Check for dimensions - All sides need to be greater than zero
	 		if($this->length > 0 && $this->width > 0  & $this->height > 0 ):
				$dimensions .='<Dimensions>
							<UnitOfMeasurement>
								<Code>'.$this->dimension_unit.'</Code>
							</UnitOfMeasurement>
							<Length>'.$this->length.'</Length>
							<Width>'.$this->width.'</Width>
							<Height>'.$this->height.'</Height>
						</Dimensions>';
			endif;
	 		$data ="<?xml version=\"1.0\"?>  
				<AccessRequest xml:lang=\"en-US\">  
				    <AccessLicenseNumber>$this->api_key</AccessLicenseNumber>  
				    <UserId>".$this->ups_username."</UserId>  
				    <Password>".$this->ups_password."</Password>  
				</AccessRequest>  
				<?xml version=\"1.0\"?>  
				<RatingServiceSelectionRequest xml:lang=\"en-US\">  
				    <Request>  
					<TransactionReference>  
					    <CustomerContext>Bare Bones Rate Request</CustomerContext>  
					    <XpciVersion>1.0001</XpciVersion>  
					</TransactionReference>  
					<RequestAction>Rate</RequestAction>  
					<RequestOption>Rate</RequestOption>  
				    </Request>  
				<PickupType>  
				    <Code>01</Code>  
				</PickupType>  
				<Shipment>  
				    <Shipper>  
					<Address>  
					    <PostalCode>".$this->source_zip."</PostalCode>  
					    <CountryCode>".$this->country_code."</CountryCode>  
					</Address>  
				    <ShipperNumber>".$this->shipper_number."</ShipperNumber>  
				    </Shipper>  
				    <ShipTo>  
					<Address>  
					    <PostalCode>".$this->dest_zip."</PostalCode>  
					    <CountryCode>".$this->dest_country."</CountryCode>  
					<ResidentialAddressIndicator/>  
					</Address>  
				    </ShipTo>
				    <ShipFrom>  
					<Address>  
					    <PostalCode>".$this->source_zip."</PostalCode>  
					    <CountryCode>".$this->country_code."</CountryCode>  
					</Address>  
				    </ShipFrom>  
				    <Service>  
					<Code>".$service."</Code>  
				    </Service>";
				    /*
					 * One box, everything in it
					 */
				    if($this->combined == true):
				    	$data .="<Package>  
									<PackagingType>  
					    				<Code>02</Code> 
									</PackagingType>".$dimensions."  
									<PackageWeight>  
					    				<UnitOfMeasurement>  
											<Code>".$this->weight_unit."</Code>  
					    				</UnitOfMeasurement>  
					    				<Weight>".$this->weight."</Weight>  
									</PackageWeight>
									<PackageServiceOptions>
										<InsuredValue>
											<CurrencyCode>USD</CurrencyCode>
											<MonetaryValue>".$this->insured_value."</MonetaryValue>
										</InsuredValue>
									</PackageServiceOptions>  
				    			</Package>";
					endif;
					/*
					 * Start adding some indvl packages as they exist
					 */
					if($this->separate):
					
						foreach($this->separate as $package){
							$data .= $package;				
						}
					endif;			  
				$data.="</Shipment>  
				</RatingServiceSelectionRequest>";  
			$data = apply_filters('sod_jigoshop_ups_raw_request', $data );	
			return $data;
		}  
		
	    /**
		 * Admin Panel Options 
		 * - Options for bits like 'title' and availability on a country-by-country basis
		 *
		 * @since 1.0.0
		 */
	  public function process_admin_options() {
	   		if(isset($_POST['jigoshop_ups_tax_status'])) update_option('jigoshop_ups_tax_status', jigowatt_clean($_POST['jigoshop_ups_tax_status'])); else @delete_option('jigoshop_ups_tax_status');
	   		if(isset($_POST['jigoshop_ups_services'])){
	   				$services = array();
	   				$services = (array)$_POST['jigoshop_ups_services'];
	   					update_option('jigoshop_ups_services', jigowatt_clean(serialize($services)));
	   			} else{
	   				@delete_option('jigoshop_ups_services');
	   			} 
	   		if(isset($_POST['jigoshop_ups_enabled'])) update_option('jigoshop_ups_enabled', jigowatt_clean($_POST['jigoshop_ups_enabled'])); else @delete_option('jigoshop_ups_enabled');
	   		if(isset($_POST['jigoshop_ups_shipper_number'])) update_option('jigoshop_ups_shipper_number', jigowatt_clean($_POST['jigoshop_ups_shipper_number'])); else @delete_option('jigoshop_ups_shipper_number');
	   		if(isset($_POST['jigoshop_ups_title'])) update_option('jigoshop_ups_title', jigowatt_clean($_POST['jigoshop_ups_title'])); else @delete_option('jigoshop_ups_title');
	   		if(isset($_POST['jigoshop_ups_availability'])) update_option('jigoshop_ups_availability', jigowatt_clean($_POST['jigoshop_ups_availability'])); else @delete_option('jigoshop_ups_availability');
	   		if(isset($_POST['jigoshop_ups_handling_fee'])) update_option('jigoshop_ups_handling_fee', jigowatt_clean($_POST['jigoshop_ups_handling_fee'])); else @delete_option('jigoshop_ups_handling_fee');
			if(isset($_POST['jigoshop_ups_enabled'])) update_option('jigoshop_ups_enabled', jigowatt_clean($_POST['jigoshop_ups_enabled'])); else @delete_option('jigoshop_ups_status');
	   		if(isset($_POST['jigoshop_ups_title'])) update_option('jigoshop_ups_title', jigowatt_clean($_POST['jigoshop_ups_title'])); else @delete_option('jigoshop_ups_cost');
	   		if(isset($_POST['jigoshop_ups_username'])) update_option('jigoshop_ups_username', jigowatt_clean($_POST['jigoshop_ups_username'])); else @delete_option('jigoshop_ups_username');
	   		if(isset($_POST['jigoshop_ups_api_key'])) update_option('jigoshop_ups_api_key', jigowatt_clean($_POST['jigoshop_ups_api_key'])); else @delete_option('jigoshop_ups_api_key');
	   		if(isset($_POST['jigoshop_ups_password'])) update_option('jigoshop_ups_password', jigowatt_clean($_POST['jigoshop_ups_password'])); else @delete_option('jigoshop_ups_password');
			if(isset($_POST['jigoshop_ups_source_zip'])) update_option('jigoshop_ups_source_zip', jigowatt_clean($_POST['jigoshop_ups_source_zip'])); else @delete_option('jigoshop_ups_source_zip');
	   		if(isset($_POST['jigoshop_ups_cost'])) update_option('jigoshop_ups_cost', jigowatt_clean($_POST['jigoshop_ups_cost'])); else @delete_option('jigoshop_ups_cost');
	   		if (isset($_POST['jigoshop_ups_countries'])) $selected_countries = $_POST['jigoshop_ups_countries']; else $selected_countries = array();
		    update_option('jigoshop_ups_countries', $selected_countries);
	   		
	    }
	 public function admin_options() {
	 	?>
    	<thead>
			<tr>
				<th scope="col" colspan="2"><h3 class="title"><?php _e('UPS Rates', 'jigoshop'); ?></h3><p><?php _e('UPS Rates let you pull in real-time UPS shipping rates for your orders.', 'jigoshop'); ?></p></th>
			</tr>
		</thead>
    	<tr>
	        <td class="titledesc"><?php _e('Enable UPS Rates', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_ups_enabled" id="jigoshop_ups_enabled" style="min-width:100px;">
		            <option value="yes" <?php if (get_option('jigoshop_ups_enabled') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'jigoshop'); ?></option>
		            <option value="no" <?php if (get_option('jigoshop_ups_enabled') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'jigoshop'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('This controls the title which the user sees during checkout.','jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('Method Title', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <input type="text" name="jigoshop_ups_title" id="jigoshop_ups_title" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_title')) echo $value; else echo 'Flat Rate'; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your www.ups.com username.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS Username', 'jigoshop') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_ups_username" id="jigoshop_ups_username" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_username')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your www.ups.com password.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS Password', 'jigoshop') ?>:</td>
	        <td class="forminp">
		      <input type="password" name="jigoshop_ups_password" id="jigoshop_ups_password" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_password')) echo $value; ?>" />
	        </td>
	    </tr>
	     <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('You\'ll need to sign-up for a free API key. Once you have that, enter it here.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS API Key', 'jigoshop') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_ups_api_key" id="jigoshop_ups_api_key" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_api_key')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your UPS Account Number. If you don\'t have a UPS Account Number, you can get one at htp://www.ups.com.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS Shipper Number', 'jigoshop') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_ups_shipper_number" id="jigoshop_ups_shipper_number" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_shipper_number')) echo $value; ?>" />
	        </td>
	    </tr>
	     <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Enter your postal code.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS Source Postal Code', 'jigoshop') ?>:</td>
	        <td class="forminp">
		      <input type="text" name="jigoshop_ups_source_zip" id="jigoshop_ups_source_zip" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_source_zip')) echo $value; ?>" />
	        </td>
	    </tr>
	    <?php $_tax = new jigoshop_tax(); ?>
	    <tr>
	        <td class="titledesc"><?php _e('Tax Status', 'jigoshop') ?>:</td>
	        <td class="forminp">
	        	<select name="jigoshop_ups_tax_status">
	        		<option value="taxable" <?php if (get_option('jigoshop_ups_tax_status')=='taxable') echo 'selected="selected"'; ?>><?php _e('Taxable', 'jigoshop'); ?></option>
	        		<option value="none" <?php if (get_option('jigoshop_ups_tax_status')=='none') echo 'selected="selected"'; ?>><?php _e('None', 'jigoshop'); ?></option>
	        	</select>
	        </td>
	    </tr>
	    <tr>
	    	<td class="titledesc"><a href="#" tip="<?php _e('UPS Shipping Methods you\'d like to offer to your customers based on what services UPS offers from your country.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('UPS Methods', 'jigoshop') ?>:</td>
	        <td class="forminp">
	        	<ul>
	        	<?php  
	        		
	        		$services = $this->get_available_services();
					if(is_serialized(get_option('jigoshop_ups_services'))){
						$methods = (unserialize(get_option('jigoshop_ups_services')));	
					}else{
						$methods = get_option('jigoshop_ups_services');
					}
					if($services && !empty($services)){
						foreach($services as $key=>$value){
							$checked = null;
							if(isset($methods[$key])):
								$checked = $methods[$key] =='on'?'checked="checked"':"";
							endif; 
					?>		<li><input type="checkbox" name="jigoshop_ups_services[<?php echo $key;?>]" id="jigoshop_ups_services[<?php echo $key;?>]" style="min-width:50px;" <?php echo $checked;?> /><?php echo $value;?></li>
		        <?php }
					};?>
		        </ul>
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><a href="#" tip="<?php _e('Fee excluding tax. Enter an amount, e.g. 2.50, or a percentage, e.g. 5%. Leave blank to disable.', 'jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('Handling Fee', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <input type="text" name="jigoshop_ups_handling_fee" id="jigoshop_ups_handling_fee" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_ups_handling_fee')) echo $value; ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td class="titledesc"><?php _e('Method available for', 'jigoshop') ?>:</td>
	        <td class="forminp">
		        <select name="jigoshop_ups_availability" id="jigoshop_ups_availability" style="min-width:100px;">
		            <option value="all" <?php if (get_option('jigoshop_ups_availability') == 'all') echo 'selected="selected"'; ?>><?php _e('All allowed countries', 'jigoshop'); ?></option>
		            <option value="specific" <?php if (get_option('jigoshop_ups_availability') == 'specific') echo 'selected="selected"'; ?>><?php _e('Specific Countries', 'jigoshop'); ?></option>
		        </select>
	        </td>
	    </tr>
	    <?php
    	$countries = jigoshop_countries::$countries;
    	asort($countries);
    	$selections = get_option('jigoshop_ups_countries', array());
    	?><tr class="multi_select_countries">
            <td class="titledesc"><?php _e('Specific Countries', 'jigoshop'); ?>:</td>
            <td class="forminp">
            	<div class="multi_select_countries"><ul><?php
        			if ($countries) foreach ($countries as $key=>$val) :
            			                    			
        				echo '<li><label><input type="checkbox" name="jigoshop_ups_countries[]" value="' . esc_attr( $key ) . '" ';
        				if (in_array($key, $selections)) echo 'checked="checked"';
        				echo ' />'. __($val, 'jigoshop') .'</label></li>';

            		endforeach;
       			?></ul></div>
       		</td>
       	</tr>
       	<script type="text/javascript">
		jQuery(function() {
			jQuery('select#jigoshop_ups_availability').change(function(){
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
			$country_code = $this->country_code;
			$eu_array = array(
				//'Poland - PL not included because they have their own rates for UPS
				'FR','BE','LU','NL','DE','IT','GB','IE','DK','GR','PT','ES','SE','FI','AT',	'MT','HU','EE','CZ','LV','CY',"LT",'SI','SK','BG','RO'
			);
			if(in_array($this->country_code,$eu_array) && !$country_code!=="PL"){
				$country_code = "EU";
			};
				switch($country_code){
					case("EU"):
						$services = array(
							'07' => 'UPS Express',
							'08' => 'UPS ExpeditedSM',
							'11' => 'UPS Standard',
							'54' => 'UPS Worldwide Express PlusSM',
							'65' => 'UPS Saver',
						);	
						break;		
					case("US"):
						$services = array(
							'14' 	=> 	'Next Day Air Early AM',
							'01' 	=> 	'Next Day Air',
							'13' 	=> 	'Next Day Air Saver',
							'02' 	=> 	'2nd Day Air',
							'59' 	=> 	'2nd Day Air AM',
							'12'	=> 	'3 Day Select',
							'03' 	=> 	'Ground',
							'07'	=>	'UPS Worldwide ExpressSM',
							'08'	=>	'UPS Worldwide ExpeditedSM',
							'11'	=>	'UPS Standard',
							'65'	=> 	'UPS Saver'
						);
						break;
					case("CA"):
						$services = array(
							'01' 	=> 	'UPS Express',
							'02'	=>	'UPS Worldwide ExpeditedSM',
							'11'	=>	'UPS Standard',
							'12'	=> 	'UPS Three-Day Select?',
							'13'	=> 	'UPS Saver SM',
							'14' 	=> 	'UPS Express Early A.M. SM',
							'07'    =>  'UPS Express (to US)' 
						);
						break;
					case("MX"):
						$services = array(
							'07' => 'UPS Express',
							'08' => 'UPS ExpeditedSM',
							'11' => 'UPS Standard',
							'54' => 'UPS Express Plus',
							'65' => 'UPS Saver',
						);	
						break;
					case("PL"):
						$services = array(
							'07' => 'UPS Express',
							'08' => 'UPS ExpeditedSM',
							'11' => 'UPS Standard',
							'54' => 'UPS Worldwide Express PlusSM',
							'65' => 'UPS Saver',
							'82' => 'UPS Today StandardSM',
							'83' => 'UPS Today Dedicated CourrierSM',
							'85' => 'UPS Today Express',
							'86' => 'UPS Today Express Saver',
						);	
						break;
					default:
						$services = array(
							'07' => 'UPS Express',
							'08' => 'UPS ExpeditedSM',
							'11' => 'UPS Standard',
							'54' => 'UPS Worldwide Express PlusSM',
							'65' => 'UPS Saver',
						);	
						break;
				};
			
				return $services;
		}
		function get_code($selected_service, $services){
			foreach($services as $key=>$value){
				if($selected_service == $value){
					$code = $key;
				}	
			}	
			return $code;
		}
	}
}
}
add_filter('jigoshop_shipping_methods', 'add_ups_rate_method' );
function add_ups_rate_method( $methods ) {
	$methods[] = 'ups'; return $methods;
}