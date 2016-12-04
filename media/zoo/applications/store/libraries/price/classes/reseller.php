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
	public function init($data) {
		parent::init($data);
		$user = $this->app->customer->get();

		if(isset($data['tempMarkup'])) {
			// Set Markup to Temporary Setting
			$this->setMarkupRate('reseller', $data['tempMarkup']);
		} else {

			// Set Markup by User Account
			
			$this->setMarkupRate('reseller', $user->params->get('margin', 0));
		}
		//$this->setMarkupRate('msrp', 0.15);

		// Set User Account Discount
		if(!$this->getDiscountRate()) {
			$this->setDiscountRate($user->params->get('discount', 0));
		}
		

	}

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
		
		// Calculate the Base
		$base = $this->get('base');
				
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
		$reseller = $base*$discount;
		$reseller += $addons;
		$this->setPrice('reseller', $reseller);

		// Calculate Reseller Customer Price

		$customer = $base*$resellerMkup;
		$customer += $addons;
		$this->setPrice('customer', $customer);

		// Calculate Reseller Display
		$this->setPrice('display', $customer);
		

		// Calculate Reseller Profit

		$profit = $this->get('customer') - $this->get('reseller');
		$this->setPrice('profit', $profit);

		// Calculate Reseller Profit Rate
		if($this->get('customer') > 0) {
			$profitRate = $profit/$this->get('customer');
			$this->setPrice('profitRate', $profitRate);
		}
		

	}
}