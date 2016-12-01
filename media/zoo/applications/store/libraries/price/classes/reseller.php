<?php
/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class ResellerPrice extends Price {

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function calculate() {
		$user = $this->app->customer->get();
		// Calculate the Base
		$base = $this->get('base');

		// Get markups
		$this->setMarkupRate('reseller', $user->params->get('margin', 0));
		$this->setMarkupRate('msrp', 0.15);

		// Get Discounts
		$this->setDiscountRate($user->params->get('discount', 0));
		
		// Assign Variables
		$msrpMkup = $this->getMarkupRate('msrp');
		$resellerMkup = $this->getMarkupRate('reseller');
		$discount = $this->getDiscountRate();
		$addons = $this->get('addons');

		// Calculate MSRP
		$msrp = $base*$msrpMkup;
		$msrp += $addons;
		$this->setPrice('msrp', $msrp);

		// Calculate Reseller

		$display = $base*$discount;
		$display += $addons;
		$this->setPrice('reseller', $display);

		// Calculate Reseller Customer Price
		
		$customer = $base*$resellerMkup;
		$customer += $addons;
		$this->setPrice('customer', $customer);

		// Calculate Reseller Display

		$this->setPrice('display', $customer);
		

	}
}