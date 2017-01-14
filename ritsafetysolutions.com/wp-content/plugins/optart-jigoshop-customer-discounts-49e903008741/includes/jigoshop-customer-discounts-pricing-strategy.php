<?php

interface jigoshopCustomerDiscountsPricingStrategy {
	public function getPrice($discount, $product, $original_price);
	public function isApplicable($discount, $product, $customer);
}