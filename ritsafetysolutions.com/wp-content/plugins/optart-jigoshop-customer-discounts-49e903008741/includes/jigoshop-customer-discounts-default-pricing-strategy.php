<?php


class jigoshopCustomerDiscountsDefaultPricingStrategy implements jigoshopCustomerDiscountsPricingStrategy {
	public function getPrice($discount, $product, $original_price)
	{
		$price = (float)$original_price;

		switch($discount->type)
		{
			// Cart discounts
			case 'cart_value':
				$quantity = 0;

				foreach(jigoshop_cart::get_cart() as $item)
				{
					$quantity += $item['quantity'];
				}

				$discountValue = $this->_getDiscountValue($price, $discount->value);
				$price = $discountValue/(float)$quantity;
				break;
			case 'cart_quantity':
				$price -= $this->_getDiscountValue($price, $discount->value);
				break;
			case 'cart_threshold':
				$value = $this->_getCartValue();
				$discountValue = $this->_getDiscountValue($price, $discount->value);

				if(strpos($discount->value, '%') !== false)
				{
					// Percentage value
					$price -= $discountValue;
				}
				else
				{
					// Fixed value
					$price = $price - (float)$discountValue*$price/$value;
				}
				break;
			// Product discounts
			case 'fixed_price':
				$price -= (float)$discount->value;
				break;
			case 'percentage_price':
				$price = round($price * (100 - (float)$discount->value) / 100, 2);
				break;
			case 'product_quantity':
				if($this->_hasProduct($product, $discount))
				{
					$price -= $this->_getDiscountValue($price, $discount->value);
				}
				break;
			case 'each_x_products':
				$quantity = $this->_getProductQuantity($product, $discount);

				if($quantity >= $discount->quantity)
				{
					$discountValue = $this->_getDiscountValue($price, $discount->value);

					if($quantity%$discount->quantity == 0)
					{
						$price -= $discountValue/$discount->quantity;
					}
					else
					{
						$discounted = (int)($quantity/$discount->quantity);
						$price -= $discountValue*$discounted/$quantity;
					}
				}
				break;
			case 'from_x_products':
				$quantity = $this->_getProductQuantity($product, $discount);

				if($quantity >= $discount->quantity)
				{
					$discountValue = $this->_getDiscountValue($price, $discount->value);
					$overallPrice = $discount->quantity * $price + ($quantity - $discount->quantity)*($price - $discountValue);
					$price = $overallPrice/$quantity;
				}
				break;
			case 'give_away':
				$quantity = $this->_getProductQuantity($product, $discount);
				$discountValue = $this->_getDiscountValue($price, $discount->value);

				$overall = $discount->quantity * ($price - $discountValue) + ($quantity - $discount->quantity) * $price;
				$price = $overall / $quantity;
				break;
		}

		return $price < 0 ? 0 : $price;
	}

	public function isApplicable($discount, $product, $customer)
	{
		$id = $this->_getProductId($product);
		$parent_id = $product->id;

		// Check if discount is applicable to the product
		if(!empty($discount->products) && !in_array($id, $discount->products) && !in_array($parent_id, $discount->products))
		{
			return false;
		}

		// Check if it is discount only for first time purchasers
		if($discount->firstPurchase && ((Jigoshop_Base::get_options()->get_option('jigoshop_customer_discounts_first_purchase_visible', 'yes') == 'no' && $customer === false) || ($customer !== false && $this->_hasOrdered($customer))))
		{
			return false;
		}

		// Check if product matches quantity discounts
		switch($discount->type)
		{
			case 'cart_threshold':
				$value = $this->_getCartValue();

				if($value < $discount->quantity)
				{
					return false;
				}
				break;
			case 'cart_quantity':
				$quantity = 0;

				foreach(jigoshop_cart::get_cart() as $item)
				{
					$quantity += $item['quantity'];
				}

				if($quantity < $discount->quantity)
				{
					return false;
				}
				break;
			case 'product_quantity':
				$quantity = 0;

				foreach(jigoshop_cart::get_cart() as $cartItem)
				{
					if(in_array($cartItem['product_id'], array($id, $parent_id)))
					{
						$quantity += $cartItem['quantity'];
					}
				}

				if($quantity < $discount->quantity)
				{
					return false;
				}
				break;
		}

		// Check if it is applicable to current user
		if(!empty($discount->users) && (!$customer || !in_array($customer->ID, $discount->users)))
		{
			return false;
		}

		// Check if current user is in an applicable group
		if(!empty($discount->groups) && (!$customer || array_intersect($customer->roles, $discount->groups) == array() && array_intersect($customer->groupsGroups, $discount->groups) == array()))
		{
			return false;
		}

		// Check if product is in a category of discount
		if(!empty($discount->categories) && !empty($product->categories))
		{
			$intersection = array_intersect($product->categories, $discount->categories);
			if(empty($intersection))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns real discount value.
	 *
	 * @param $price float Original price.
	 * @param $value string Raw value from discount.
	 * @return float Calculated discount value.
	 */
	protected function _getDiscountValue($price, $value)
	{
		if(strpos($value, '%') !== false)
		{
			return round($price * (float)rtrim($value, '%') / 100, 2);
		}
		else
		{
			return (float)$value;
		}
	}

	/**
	 * Calculates product quantity in the cart for the discount or explicitly specified.
	 *
	 * @param $product stdClass Specified product
	 * @param $discount stdClass Discount
	 * @return int Product quantity.
	 */
	protected function _getProductQuantity($product, $discount)
	{
		$quantity = 0;

		foreach(jigoshop_cart::get_cart() as $item)
		{
			// Specified product || Simple product || Variable product
			if($item['product_id'] == $product->id || in_array($item['product_id'], $discount->products) || isset($item['variation_id']) && in_array($item['variation_id'], $discount->products))
			{
				$quantity += $item['quantity'];
			}
		}

		return $quantity;
	}

	/**
	 * Checks if product is in the cart for the discount or explicitly specified.
	 *
	 * @param $product stdClass Specified product
	 * @param $discount stdClass Discount
	 * @return boolean Is in cart?
	 */
	protected function _hasProduct($product, $discount)
	{
		foreach(jigoshop_cart::get_cart() as $item)
		{
			// Specified product || Simple product || Variable product
			if($item['product_id'] == $product->id || in_array($item['product_id'], $discount->products) || isset($item['variation_id']) && in_array($item['variation_id'], $discount->products))
			{
				return true;
			}
		}

		return false;
	}

	protected function _hasOrdered($customer)
	{
		/** @var $wpdb wpdb */
		global $wpdb;

		// Check if user has some orders already
		$results = $wpdb->get_row($wpdb->prepare(
		                               'SELECT COUNT(p.ID) AS count FROM '.$wpdb->posts.' p
						LEFT JOIN '.$wpdb->postmeta.' pm ON pm.post_id = p.ID
						WHERE p.post_type = %s AND pm.meta_key = %s AND pm.meta_value = %d',
			                               array('shop_order', 'customer_user', $customer->ID)
		));

		if($results && $results->count > 0)
		{
			return true;
		}

		return false;
	}

	/**
	 * @return float Current value of the whole cart.
	 */
	protected function _getCartValue()
	{
		$value = 0.0;

		foreach(jigoshop_cart::get_cart() as $item)
		{
			$price = $item['data']->meta['regular_price'];

			if(is_array($price))
			{
				$price = array_shift($price);
			}

			$value += $item['quantity'] * $price;
		}

		return $value;
	}

	/**
	 * Returns proper product ID for variations and products.
	 *
	 * @param $product jigoshop_product Product object.
	 * @return int Product ID.
	 */
	protected function _getProductId($product)
	{
		if($product instanceof jigoshop_product_variation)
		{
			return $product->variation_id;
		}

		return $product->id;
	}
}