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
		$user = $this->getParam('user');

		if(isset($data['tempMarkup'])) {
			// Set Markup to Temporary Setting
			$this->setMarkupRate('reseller', $data['tempMarkup']);
		} else {

			// Set Markup by User Account
			
			$this->setMarkupRate('reseller', $user->getAccount()->getMarkupRate(0));
		}
		//$this->setMarkupRate('msrp', 0.15);
		if(!$this->getParam('discount.reseller')) {
			$this->setDiscountRate('reseller', $user->getAccount()->params->get('discount'));
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
		parent::calculate();
		
		// Calculate the Base
		$base = $this->get('base');
				
		// Assign Variables
		$msrpMkup = $this->getMarkupRate('msrp');
		$resellerMkup = $this->getMarkupRate('reseller');
		$discount = $this->getDiscountRate('reseller');
		$addons = $this->get('addons');

		// Calculate Reseller
		$reseller = $base*$discount;
		$reseller += $addons;
		$this->setPrice('reseller', $reseller);

		// Calculate Reseller Customer Price

		$customer = $base*$resellerMkup;
		$customer += $addons;
		$this->setPrice('customer', $customer);

		// Calculate Reseller Display
		$display = $this->getParam('display', 'customer');
		$this->setPrice('display', $this->get($display));

		// Calculate Reseller Display
		$charge = $this->get($this->getParam('charge', 'reseller'));
		$this->setPrice('charge', $charge);

		// Calculate Reseller Profit
		$profit = $this->get('customer') - $this->get('reseller');
		$this->setPrice('profit', $profit);

		// Calculate Reseller Profit Rate
		if($this->get('customer') > 0) {
			$profitRate = $profit/$this->get('customer');
			$this->setPrice('profitRate', $profitRate);
		}

		$overstock = $this->get('msrp')*$this->getParam('discount.overstock');

		$this->setPrice('overstock', $overstock);
		
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
	public function getAll($recalc = false) {
		if($recalc) {
			$this->calculate();
		}
		$prices = $this->app->parameter->create($this->getParam('price.'));
		$prices->set('markupRate', $this->getParam('markup.reseller'));
		$prices->set('msrpMarkup', $this->getParam('markup.msrp'));
		$prices->set('discountRate', $this->getDiscountRate());
		return $prices;

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
	public function getDiscountRate($name = 'reseller', $default = 0) {
		return parent::getDiscountRate($name, $default);
	}

}