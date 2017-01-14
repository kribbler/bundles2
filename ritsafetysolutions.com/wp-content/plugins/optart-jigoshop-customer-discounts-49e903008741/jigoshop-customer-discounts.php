<?php
/**
Plugin Name:       Jigoshop Customer Discounts
Plugin URI:        http://www.jigoshop.com
Description:       Define custom discounts for every customer or group of customers.
Version:           2.5.6
Author:            Jigoshop | Amadeusz Starzykiewicz
Author URI:        http://www.jigoshop.com
Requires at least: 3.5
Tested up to:      3.9.1
Requires:          Jigoshop 1.9 or better
*/

// Define plugin directory for inclusions
if(!defined('JIGOSHOP_CUSTOMER_DISCOUNTS_DIR'))
{
	define('JIGOSHOP_CUSTOMER_DISCOUNTS_DIR', dirname(__FILE__));
}

class jigoshopCustomerDiscounts
{
	const VERSION = '2.5.5';
	private $_discountTypes;
	private $_discounts;
	/** @var jigoshopCustomerDiscountsPricingStrategy */
	private $_pricingStrategy;

	public function __construct()
	{
		$this->_pricingStrategy = new jigoshopCustomerDiscountsDefaultPricingStrategy();
		$this->_discountTypes = array(
			'fixed_price' => __('Fixed Price', 'jigoshop_customer_discounts'),
			'percentage_price' => __('Percentage Price', 'jigoshop_customer_discounts'),
			'product_quantity' => __('Product Quantity', 'jigoshop_customer_discounts'),
			'each_x_products' => __('Each X products', 'jigoshop_customer_discounts'),
			'from_x_products' => __('From X products', 'jigoshop_customer_discounts'),
			'cart_quantity' => __('Products in cart', 'jigoshop_customer_discounts'),
			'cart_threshold' => __('Cart threshold', 'jigoshop_customer_discounts'),
			'cart_value' => __('Cart value', 'jigoshop_customer_discounts'),
			'give_away' => __('Give away', 'jigoshop_customer_discounts'),
		);

		register_post_type('customer_discount', array(
			'labels' => array(
				'menu_name' => __('Discounts', 'jigoshop_customer_discounts'),
				'name' => __('Discounts', 'jigoshop_customer_discounts'),
				'singular_name' => __('Discount', 'jigoshop_customer_discounts'),
				'add_new' => __('Add Discount', 'jigoshop_customer_discounts'),
				'add_new_item' => __('Add New Discount', 'jigoshop_customer_discounts'),
				'edit' => __('Edit', 'jigoshop_customer_discounts'),
				'edit_item' => __('Edit Discount', 'jigoshop_customer_discounts'),
				'new_item' => __('New Discount', 'jigoshop_customer_discounts'),
				'view' => __('View Discounts', 'jigoshop_customer_discounts'),
				'view_item' => __('View Discount', 'jigoshop_customer_discounts'),
				'search_items' => __('Search Discounts', 'jigoshop_customer_discounts'),
				'not_found' => __('No Discounts found', 'jigoshop_customer_discounts'),
				'not_found_in_trash' => __('No Discounts found in trash', 'jigoshop_customer_discounts'),
				'parent' => __('Parent Discount', 'jigoshop_customer_discounts')
			),
			'description'  => __('This is where you can add new discounts that customers can use in your store.', 'jigoshop_customer_discounts'),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => true,
			'supports' => array('title', 'page-attributes'),
			'show_in_nav_menus' => false,
			'show_in_menu' => 'jigoshop'
		));

		add_action('wp_enqueue_scripts', array($this, 'frontStyles'));
		add_action('jigoshop_after_review_order_items', array($this, 'savingsDisplayInCheckout'));

		add_filter('jigoshop_product_get_regular_price', array($this, 'getPrice'), 10, 2);
		add_filter('jigoshop_product_get_price_html', array($this, 'getHtmlPrice'), 10, 3);
		add_filter('jigoshop_product_price_display_in_cart', array($this, 'savingsDisplayInCart'), 10, 10);
		add_filter('jigoshop_product_subtotal_display_in_cart', array($this, 'savingsDisplaySubtotalInCart'), 10, 10);

		if(is_admin())
		{
			Jigoshop_Base::get_options()->install_external_options_tab(__('Customer Discounts', 'jigoshop'), $this->jigoshopOptionsTab());
			add_action('admin_enqueue_scripts', array($this, 'adminScripts'));
			add_action('admin_enqueue_scripts', array($this, 'adminStyles'));
			add_action('add_meta_boxes', array($this, 'adminMetaBoxes'));
			add_action('save_post', array($this, 'adminSaveMeta'));
			add_action('wp_ajax_jigoshop_json_search_products', array($this, 'ajaxSearchProducts'));
			add_action('wp_ajax_jigoshop_json_search_products_and_variations', array($this, 'ajaxSearchProductsVariations'));
			add_filter('manage_edit-customer_discount_columns', array($this, 'adminColumns'));
			add_action('manage_customer_discount_posts_custom_column', array($this, 'adminColumn'), 10, 2);
		}
	}

	/**
	 * @param jigoshopCustomerDiscountsPricingStrategy $pricingStrategy
	 */
	public function setPricingStrategy(jigoshopCustomerDiscountsPricingStrategy $pricingStrategy)
	{
		$this->_pricingStrategy = $pricingStrategy;
	}

	/**
	 * @return jigoshopCustomerDiscountsPricingStrategy
	 */
	public function getPricingStrategy()
	{
		return $this->_pricingStrategy;
	}

	public function jigoshopOptionsTab()
	{
		return array(
				array(
					'name' => __('Main settings', 'jigoshop_customer_discounts'),
					'type' => 'title',
					'desc' => ''
				),
				array(
					'name' => __('Show old price', 'jigoshop_customer_discounts'),
					'desc' => __('Setting this to "Yes" will show old price of the product.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_show_old_price',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Include discount when coupon is used?', 'jigoshop_customer_discounts'),
					'desc' => __('Setting this to "Yes" will enable discounts on products when using coupons. Attention! When coupon + discount means free item - discount is dropped when "Allow free products with coupons" is set to "No".', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_include_with_coupons',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Allow free products', 'jigoshop_customer_discounts'),
					'desc' => __('Setting this to "Yes" will allow you to create discounts making products free.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_allow_free',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Allow free products with coupons', 'jigoshop_customer_discounts'),
					'desc' => __('Setting this to "Yes" will allow your customers to get free products when coupons are used. When it is set to "No" your customers can still use coupons, but when product price when coupon is used will be 0 then coupon is discarded.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_allow_free_with_coupons',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Show first time purchase discounts', 'jigoshop_customer_discounts'),
					'desc' => __('Setting this to "No" will hide first purchase discounts to not logged in clients.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_first_purchase_visible',
					'std' => 'yes',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Displaying "How much you saved"', 'jigoshop_customer_discounts'),
					'type' => 'title',
					'desc' => ''
				),
				array(
					'name' => __('Display on product page', 'jigoshop_customer_discounts'),
					'desc' => '',
					'id' => 'jigoshop_customer_discounts_savings_product',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Display in cart', 'jigoshop_customer_discounts'),
					'desc' => __('This option means you want to display savings in unit price.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_savings_cart',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Display in subtotal cart', 'jigoshop_customer_discounts'),
					'desc' => __('This option means you want to display savings in subtotal.', 'jigoshop_customer_discounts'),
					'id' => 'jigoshop_customer_discounts_savings_subtotal_cart',
					'std' => 'yes',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
				array(
					'name' => __('Display on checkout', 'jigoshop_customer_discounts'),
					'desc' => '',
					'id' => 'jigoshop_customer_discounts_savings_checkout',
					'std' => 'no',
					'type' => 'checkbox',
					'choices' => array(
						'no' => __('No', 'jigoshop'),
						'yes' => __('Yes', 'jigoshop')
					)
				),
			);
	} // end jigoshopOptionsTab();

	public function adminScripts()
	{
		global $typenow;

		wp_enqueue_script('jquery-ui-datepicker');
		jigoshop_add_script('jigoshop-select2', jigoshop::assets_url().'/assets/js/select2.min.js', array('jquery'));
		jigoshop_add_script('jigoshop_backend', jigoshop::assets_url().'/assets/js/jigoshop_backend.js', array('jquery'), array('version' => '1.0'));

		if($typenow == 'customer_discount')
		{
			add_filter('script_loader_src', 'jigoshop_disable_autosave', 10, 2);
		}

	} // end adminScripts();

	public function adminStyles()
	{
		/* Jigoshop styles */
		jigoshop_add_style('jigoshop_admin_icons_style', jigoshop::assets_url().'/assets/css/admin-icons.css');
		jigoshop_add_style('jigoshop_admin_styles', jigoshop::assets_url().'/assets/css/admin.css');
		jigoshop_add_style('jigoshop-select2', jigoshop::assets_url().'/assets/css/select2.css');
		wp_enqueue_style('thickbox');

		jigoshop_add_style('jigoshop_customer_discounts_admin', plugin_dir_url(__FILE__).'assets/css/admin.css');
	} // end adminStyles();

	public function frontStyles()
	{
		jigoshop_add_style('jigoshop_customer_discounts', plugin_dir_url(__FILE__).'assets/css/style.css');
	} // end frontStyles();

	public function adminMetaBoxes()
	{
		add_meta_box('jigoshop_customer_discounts_data', __('Discount Data', 'jigoshop_customer_discounts'), array($this, 'adminBoxData'), 'customer_discount', 'normal', 'high');
	} // end adminMetaBoxes();

	public function adminBoxData($post)
	{
		include(JIGOSHOP_CUSTOMER_DISCOUNTS_DIR.'/templates/admin_box.php');
	} // end adminBoxData();

	/**
	 * Discount Data Save
	 *
	 * Function for processing and storing all discount data.
	 */
	public function adminSaveMeta($postId)
	{
		if(!$_POST)
		{
			return $postId;
		}

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		{
			return $postId;
		}

		if(!isset($_POST['jigo_cd_meta_nonce']) || (isset($_POST['jigo_cd_meta_nonce']) && !wp_verify_nonce($_POST['jigo_cd_meta_nonce'], 'jigo_cd_save_meta')))
		{
			return $postId;
		}

		if(!current_user_can('edit_post', $postId))
		{
			return $postId;
		}

		$type = jigowatt_clean($_POST['type']);
		$quantity = jigowatt_clean($_POST['quantity']);
		$value = jigowatt_clean($_POST['value']);

		if(in_array($type, array('fixed_price', 'percentage_price')))
		{
			$value = (float)rtrim($value, '%');
		}

		$free_shipping = isset($_POST['free_shipping']);

		if(isset($_POST['products']))
		{
			$products = jigowatt_clean($_POST['products']);

			if($products == 'Array')
			{
				$products = '';
			}

			$products = $products != '' ? explode(',', $products) : array();
		}
		else
		{
			$products = array();
		}

		if(isset($_POST['categories']))
		{
			$categories = $_POST['categories'];
		}
		else
		{
			$categories = array();
		}

		if(isset($_POST['users']))
		{
			$users = $_POST['users'];
		}
		else
		{
			$users = array();
		}

		if(isset($_POST['groups']))
		{
			$groups = $_POST['groups'];
		}
		else
		{
			$groups = array();
		}

		$firstPurchase = isset($_POST['first_purchase']) && $_POST['first_purchase'] ? true : false;

		update_post_meta($postId, 'type', $type);
		update_post_meta($postId, 'quantity', $quantity);
		update_post_meta($postId, 'value', $value);
		update_post_meta($postId, 'free_shipping', $free_shipping);
		update_post_meta($postId, 'products', $products);
		update_post_meta($postId, 'categories', $categories);
		update_post_meta($postId, 'users', $users);
		update_post_meta($postId, 'groups', $groups);
		update_post_meta($postId, 'first_purchase', $firstPurchase);

		return $postId;
	} // end adminSaveMeta();

	public function adminColumns()
	{
		return array(
			'cb' => '<input type="checkbox" />',
			'title' => __('Name', 'jigoshop_customer_discounts'),
			'type' => __('Type', 'jigoshop_customer_discounts'),
			'value' => __('Value', 'jigoshop_customer_discounts'),
			'users' => __('Users', 'jigoshop_customer_discounts'),
			'groups' => __('Groups', 'jigoshop_customer_discounts'),
			'date' => __('Date', 'jigoshop_customer_discounts'),
		);
	} // end adminColumns();

	public function adminColumn($column, $postId)
	{
		switch($column)
		{
			case 'type':
				$type = get_post_meta($postId, 'type', true);
				echo count($type) == 1 ? $this->getDiscountType($type) : '-';
				break;
			case 'value':
				$value = get_post_meta($postId, 'value', true);
				echo $value ? $value : '-';
				break;
			case 'users':
				$ids = get_post_meta($postId, 'users', true);

				if(empty($ids))
				{
					return;
				}

				$links = '';
				$users = get_users(array('include' => $ids, 'fields' => array('ID', 'display_name')));

				foreach($users as $item)
				{
					$links .= '<a href="/wp-admin/user-edit.php?user_id='.$item->ID.'">'.$item->display_name.'</a>, ';
				}

				echo rtrim($links, ', ');
				break;
			case 'groups':
				$groups = get_post_meta($postId, 'groups', true);

				if(empty($groups))
				{
					return;
				}

				$links = '';
				$groups = $this->getRoles(array('include' => $groups));

				foreach($groups as $role => $name)
				{
					$links .= '<a href="/wp-admin/user-edit.php?user_id='.$role.'">'.$name.'</a>, ';
				}

				echo rtrim($links, ', ');
				break;
		}
	} // end adminColumn();

	/**
	 * Search for products and return json
	 */
	public function ajaxSearchProducts($x = '', $post_types = array('product'))
	{
		check_ajax_referer('search-products', 'security');

		$term = (string)urldecode(stripslashes(strip_tags($_GET['term'])));

		if(empty($term))
		{
			die();
		}

		if(strpos($term, ',') !== false)
		{
			$term = (array)explode(',', $term);
			$args = array('post_type' => $post_types, 'post_status' => 'publish', 'posts_per_page' => -1, 'post__in' => $term, 'fields' => 'ids');
			$posts = get_posts($args);
		}
		elseif(is_numeric($term))
		{
			$args = array('post_type' => $post_types, 'post_status' => 'publish', 'posts_per_page' => -1, 'post__in' => array(0, $term), 'fields' => 'ids');
			$posts = get_posts($args);
		}
		else
		{
			$args = array('post_type' => $post_types, 'post_status' => 'publish', 'posts_per_page' => -1, 's' => $term, 'fields' => 'ids');
			$args2 = array('post_type' => $post_types, 'post_status' => 'publish', 'posts_per_page' => -1, 'meta_query' => array(array('key' => 'sku', 'value' => $term, 'compare' => 'LIKE')), 'fields' => 'ids');
			$posts = array_unique(array_merge(get_posts($args), get_posts($args2)));
		}

		$found_products = array();

		if($posts)
		{
			foreach($posts as $post)
			{
				$SKU = get_post_meta($post, '_sku', true);

				if(isset($SKU) && $SKU)
				{
					$SKU = ' (SKU: '.$SKU.')';
				}

				$found_products[] = array('id' => $post, 'text' => get_the_title($post).$SKU);
			}
		}

		echo json_encode($found_products);
		die();
	} // end ajaxSearchProducts();

	public function ajaxSearchProductsVariations()
	{
		jigoshop_json_search_products('', array('product', 'product_variation'));
	} // end ajaxSearchProductsVariations();

	public function getUsersWithGroups()
	{
		global $wp_roles;

		$roles = array();

		foreach($wp_roles->role_names as $role => $role_name)
		{
			$users = get_users(array('role' => $role));

			foreach($users as $user)
			{
				$roles[$role][$user->ID] = $user->display_name;
			}
		}

		return $roles;
	} // end getUsersWithGroups();

	public function getRoles($args = array())
	{
		global $wp_roles;

		$defaults = array('include' => array());
		$args = array_merge($defaults, $args);
		$roles = array();

		if(empty($args['include']))
		{
			foreach($wp_roles->role_names as $role => $role_name)
			{
				$roles[$role] = $role_name;
			}
		}
		else
		{
			foreach($wp_roles->role_names as $role => $role_name)
			{
				if(in_array($role, $args['include']))
				{
					$roles[$role] = $role_name;
				}
			}
		}

		if(defined('GROUPS_CORE_VERSION'))
		{
			/**
			 * @var $wpdb wpdb
			 */
			global $wpdb;

			/** @noinspection PhpUndefinedFunctionInspection */
			$query = $wpdb->get_results('SELECT group_id, name FROM '._groups_get_tablename('group').' ORDER BY name ASC');

			foreach($query as $item)
			{
				$roles[$item->group_id] = $item->name;
			}
		}

		return $roles;
	} // end getRoles();

	public function getUsers()
	{
		$users_data = get_users();
		$users = array();

		foreach($users_data as $user)
		{
			$users[$user->ID] = $user->display_name;
		}

		return $users;
	} // end getUsers();

	public function getDiscountTypes()
	{
		return $this->_discountTypes;
	} // end getDiscountTypes();

	public function getDiscountType($key)
	{
		return isset($this->_discountTypes[$key]) ? $this->_discountTypes[$key] : null;
	} // end getDiscountType();

	public function getDiscountValue($discount, $value)
	{
		switch($discount->type)
		{
			case 'fixed_price':
				return jigoshop_price($value);
			case 'percentage_price':
				return "$value&#37;";
		}

		return '';
	} // end getDiscountValue();

	public function getCustomerDiscounts($product, $customerId = false)
	{
		if($this->_discounts === null)
		{
			$this->_getDiscounts();
		}

		if(!$customerId)
		{
			$customerId = get_current_user_id();
		}

		$id = $this->_getProductId($product);
		$parent_id = $product->id;

		$product->categories = wp_get_post_terms($id, 'product_cat', array('fields' => 'ids'));
		if($id != $product->id)
		{
			$product->categories = array_merge(
				$product->categories,
				wp_get_post_terms($parent_id, 'product_cat', array('fields' => 'ids'))
			);
		}
		$product->price = get_post_meta($id, 'regular_price', true);

		$customer = false;
		if($customerId != 0)
		{
			$customer = get_userdata($customerId);
			$customer->groupsGroups = array();
		}

		if($customer !== false && defined('GROUPS_CORE_VERSION'))
		{
			/** @noinspection PhpUndefinedClassInspection */
			$groupsUser = new Groups_User($customerId);
			$groupsGroups = array();

			/** @noinspection PhpUndefinedFieldInspection */
			if(is_array($groupsUser->groups))
			{
				/** @noinspection PhpUndefinedFieldInspection */
				foreach($groupsUser->groups as $item)
				{
					$groupsGroups[] = $item->group_id;
				}
			}

			$customer->groupsGroups = $groupsGroups;
		}

		$discounts = array();

		foreach($this->_discounts as $discount)
		{
			if($this->_pricingStrategy->isApplicable($discount, $product, $customer))
			{
				$discounts[] = $discount;
			}
		}

		// Sort discounts with their "power"
		$that = $this;
		usort($discounts, function ($a, $b) use ($that, $product)
		{
			$aPrice = $that->getPricingStrategy()->getPrice($a, $product, $product->price);
			$bPrice = $that->getPricingStrategy()->getPrice($b, $product, $product->price);

			return $aPrice == $bPrice ? 0 : ($aPrice > $bPrice ? 1 : -1);
		});

		return $discounts;
	} // end getCustomerDiscounts();

	public function getPrice($price, $productId)
	{
		$product = new jigoshop_product($productId);

		// Check if it is variation
		if(isset($product->meta['variation_data']))
		{
			$product = new jigoshop_product_variation($productId);
		}

		if($product->is_on_sale())
		{
			return $price;
		}

		$discounts = $this->getCustomerDiscounts($product);
		$oldPrice = $price;

		if(!empty($discounts))
		{
			do
			{
				$discount = array_shift($discounts);

				// Check for coupons
				$newPrice = $this->_pricingStrategy->getPrice($discount, $product, $price);
				$couponPrice = $this->_getCouponPrice($productId, $newPrice);

				// Check if coupon is used
				if($couponPrice < $newPrice)
				{
					if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_include_with_coupons', 'no') == 'yes' && (Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free_with_coupons', 'no') == 'yes' || $couponPrice > 0))
					{
						// Check if product is not free with coupon customer have used.
						$price = ((Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free', 'no') == 'yes' && Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free_with_coupons', 'no') == 'yes') || $newPrice > 0) ? $newPrice : $price;
					}
				}
				else
				{
					$price = (Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free', 'no') == 'yes' || $newPrice > 0) ? $newPrice : $price;
				}
			}
			while(!empty($discounts) && $price == $oldPrice);
		}

		return $price;
	} // end getPrice();

	/**
	 * Return HTML price value.
	 *
	 * @param $html string Current HTML price.
	 * @param $product jigoshop_product The product.
	 * @param $price float Current price.
	 * @return mixed|string|void
	 */
	public function getHtmlPrice($html, $product, $price)
	{
		if($product->is_on_sale())
		{
			return $html;
		}

		if($product->product_type == 'variable')
		{
			return $html;
		}

		$oldPrice = $price;
		$discounts = $this->getCustomerDiscounts($product);

		if(!empty($discounts))
		{
			$discount = array_shift($discounts);

			// Check for coupons
			$newPrice = $this->_pricingStrategy->getPrice($discount, $product, $price);
			$couponPrice = $this->_getCouponPrice($product->ID, $newPrice);

			// Check if coupon is used
			if($couponPrice < $newPrice)
			{
				if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_include_with_coupons', 'no') == 'yes' && (Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free_with_coupons', 'no') == 'yes' || $couponPrice > 0))
				{
					// Check if product is not free with the coupon customer has used.
					$price = (Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free', 'no') == 'yes' || $couponPrice > 0) ? $newPrice : $oldPrice;
				}
			}
			else
			{
				$price = $newPrice;
			}

			if((Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_allow_free', 'no') == 'yes' || $price > 0) && $price < $oldPrice)
			{
				if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_show_old_price', 'no') == 'yes')
				{
					$html = '<del>'.jigoshop_price($oldPrice).'</del>'.(is_single() ? __('Your price: ', 'jigoshop_customer_discounts') : '').'<ins>'.jigoshop_price($price).'</ins>';
				}
				else
				{
					$html = jigoshop_price($price);
				}

				if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_savings_product', 'no') == 'yes' && !is_product_list())
				{
					$html .= '<span class="customer-product-savings">'.__('You save', 'jigoshop_customer_discounts').': '.jigoshop_price($oldPrice-$price).'</span>';
				}
			}
		}

		return $html;
	} // end getHtmlPrice();

	public function savingsDisplayInCart($price, $product, $values)
	{
		if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_savings_cart', 'no') == 'yes')
		{
			/** @var jigoshop_product $product */
			$product = $values['data'];
			$savings = (float)$product->meta['regular_price'][0] - $product->get_price();
			if($savings > 0)
			{
				$price .= '<span class="customer-savings">'.__('You save', 'jigoshop_customer_discounts').': '.jigoshop_price($savings).'</span>';
			}
		}

		return $price;
	} // end savingsDisplayInCart();

	public function savingsDisplaySubtotalInCart($price, $product, $values)
	{
		if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_savings_subtotal_cart', 'yes') == 'yes')
		{
			/** @var jigoshop_product $product */
			$product = $values['data'];
			$savings = ((float)$product->meta['regular_price'][0] - $product->get_price())*$values['quantity'];

			if($savings > 0)
			{
				$price .= '<span class="customer-subtotal-savings">'.__('You save', 'jigoshop_customer_discounts').': '.jigoshop_price($savings).'</span>';
			}
		}

		return $price;
	} // end savingsDisplaySubtotalInCart();

	public function savingsDisplayInCheckout()
	{
		if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_savings_checkout', 'no') == 'yes')
		{
			$savings = 0.0;

			foreach(jigoshop_cart::get_cart() as $item)
			{
				/** @var jigoshop_product $product */
				$product = $item['data'];
				$savings += ((float)$product->meta['regular_price'][0] - $product->get_price())*$item['quantity'];
			}

			if($savings > 0)
			{
				?>
				<tr class="customer-savings">
					<td colspan="2"><?php _e('You saved', 'jigoshop_customer_discounts'); ?></td>
					<td><?php echo jigoshop_price($savings); ?></td>
				</tr>
			<?php
			}
		}
	} // end savingsDisplaySubtotalInCart();

	/**
	 * Returns proper product ID for variations and products.
	 *
	 * @param $product jigoshop_product Product object.
	 * @return int Product ID.
	 */
	private function _getProductId($product)
	{
		if($product instanceof jigoshop_product_variation)
		{
			return $product->variation_id;
		}

		return $product->id;
	}

	/**
	 * Returns price when coupon is used.
	 *
	 * @param $productId int Product ID.
	 * @param $price float Original price
	 * @return float
	 */
	private function _getCouponPrice($productId, $price)
	{
		$couponPrice = $price;

		if(isset(jigoshop_session::instance()->coupons) && !empty(jigoshop_session::instance()->coupons))
		{
			if(Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_include_with_coupons', 'no') == 'no')
			{
				return 0;
			}

			$cart = jigoshop_cart::get_cart();
			$cartProduct = false;

			foreach($cart as $productInCart)
			{
				if($productInCart['product_id'] == $productId)
				{
					$cartProduct = $productInCart;
					break;
				}
			}

			if(is_array($cartProduct))
			{
				$coupons = new JS_Coupons();
				foreach(jigoshop_session::instance()->coupons as $code)
				{
					$coupon = $coupons->get_coupon($code);

					if($coupons->is_valid_coupon_for_product($code, $cartProduct))
					{
						if($coupon['type'] == 'fixed_product')
						{
							$couponPrice -= $coupon['amount'] * $cartProduct['quantity'];
						}
						else if($coupon['type'] == 'percent_product')
						{
							$couponPrice -= ($price * $cartProduct['quantity'] / 100 ) * $coupon['amount'];
						}
					}
				}

				if($couponPrice <= 0)
				{
					return 0;
				}
			}
		}

		return $couponPrice;
	} // end _getCouponPrice();

	private function _getDiscounts()
	{
		$this->_discounts = array();

		$discounts = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'customer_discount',
		));

		foreach($discounts as $item)
		{
			$discount = new stdClass();
			$discount->id = $item->ID;
			$discount->name = $item->post_title;
			$discount->priority = $item->menu_order;
			$discount->type = get_post_meta($discount->id, 'type', true);
			$discount->quantity = (int)get_post_meta($discount->id, 'quantity', true);
			$discount->value = get_post_meta($discount->id, 'value', true);
			$discount->products = get_post_meta($discount->id, 'products', true);
			$discount->categories = get_post_meta($discount->id, 'categories', true);
			$discount->groups = get_post_meta($discount->id, 'groups', true);
			$discount->users = get_post_meta($discount->id, 'users', true);
			$discount->firstPurchase = get_post_meta($discount->id, 'first_purchase', true);

			if(is_string($discount->products))
			{
				$discount->products = empty($discount->products) ? array() : explode(',', $discount->products);
			}

			$this->_discounts[] = $discount;
		}
	} // end _getDiscounts();
} // end jigoshopCustomerDiscounts;

function init_jigoshop_customer_discounts()
{
	// CHECK IF JIGOSHOP IS ACTIVE!
	if(class_exists('jigoshop'))
	{
		$licence = new jigoshop_licence_validator(__FILE__, '13384', 'http://www.jigoshop.com');
		if(!$licence->is_licence_active())
		{
			return;
		}
		require_once(JIGOSHOP_CUSTOMER_DISCOUNTS_DIR.'/includes/jigoshop-customer-discounts-pricing-strategy.php');
		require_once(JIGOSHOP_CUSTOMER_DISCOUNTS_DIR.'/includes/jigoshop-customer-discounts-default-pricing-strategy.php');


		load_plugin_textdomain('jigoshop_customer_discounts', false, dirname(plugin_basename(__FILE__)).'/languages/');
		global $jigoshop_customer_discounts;
		$jigoshop_customer_discounts = new jigoshopCustomerDiscounts();
	}
}
add_action('init', 'init_jigoshop_customer_discounts');
