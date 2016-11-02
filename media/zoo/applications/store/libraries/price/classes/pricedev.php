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
class Price {


	/**
	 * @var [ArrayObject]
	 */
	protected $_storage;

	/**
	 * @var [type]
	 */
	public $debug = false;

	/**
	 * @var [type]
	 */
	public $app;
	

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		$this->app = $app;
		$this->_storage = $this->app->parameter->create();
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
		if(!$this->_loadRules()) {
			return false;
		}
		if(!$this->_addOptions()) {
			return false;
		}
		
		$base = $this->get('base');
		$msrpMkup = $this->getParam('markup.msrp')+1;
		
		$discount = $this->getDiscount();
		$addons = $this->get('addons');
		$msrp = $base*$msrpMkup;
		$msrp += $addons;
		$this->setPrice('msrp', $msrp);
		$rDisplay = $msrp*$discount;
		$this->setPrice('display', $rDisplay);

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
	protected function _loadRules() {
		if($this->getParam('path.rules.item')) {
			include $this->getParam('path.rules.item');
		}
		if($this->getParam('path.rules.global')) {
			include $this->getParam('path.rules.global');
		}

		$rules = $this->app->parameter->create($rules);
		
		if (!$rules->get($this->getGroup().'.')) {
            return false;
        }
		
		$data = $this->app->parameter->create();

		$data = $this->_addGlobalRules($rules, $data);

		$data = $this->_addTypeRules($rules, $data);

		$data = $this->_addItemRules($rules, $data);

		$this->register('options.price', $data->get('options.'));
		$this->register('weight', $data->get('weight'));
		$this->setPrice('base', $data->get('base', 0.00));
		$this->register('discount', $data->get('discount', 0.00));
		$this->register('markup.msrp', $data->get('markup.msrp', 0.00));
		return $this;
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
	protected function _addGlobalRules($rules, $data) {
		foreach($rules->get('global.', array()) as $key => $option) {
			$data->set($key, $option);
		}
		$weight = $data->get('weight');
		$data->set('weight', $rules->get('global.shipping.weight', $weight));
		return $data;
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
	protected function _addTypeRules($rules, $data) {
		$type = $this->getParam('product.type');
		foreach($rules->get($type.'.', array()) as $key => $option) {
			$data->set($key, $option);
		}
		$weight = $data->get('weight');
		$data->set('weight', $rules->get($type.'.shipping.weight', $weight));
		return $data;
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
	protected function _addItemRules($rules, $data) {
		foreach($this->getParam('group.', array()) as $part) {
			$group = isset($group) ? $group .= '.'.$part : $part;
			$ruleset = $rules->get($group.'.', array());
			foreach($ruleset as $key => $value) {
				$data->set($key, $value);
			}
			$weight = $data->get('weight');
			$data->set('weight', $rules->get($group.'.shipping.weight', $weight));
		}
		return $data;
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
	protected function _addOptions() {
		$addons = 0.00;
		$productOptions = $this->getParam('options.product');
		$rules = $this->getPriceOptionRules();
		foreach($productOptions as $option) {
			$price = $rules->get($option->get('name').'.'.$option->getValue(), 0.00);
			$qty = $option->get('qty', 1);
			$addons += ($price*$qty);

		}
		$this->setPrice('addons', $addons);
		return $this;
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
	public function getParam($name, $default = null) {
		return $this->_storage->get($name, $default);
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
	public function get($name = 'display', $default = 0.00, $formatted = false) {
		if($name == 'lock') {
			return false;
		}

		$price = $this->getParam('price.'.$name, $default);
		
		if($formatted) {
			$price = $this->app->number->currency($price, array('currency' => 'USD'));
		}

		if($this->debug) {
			var_dump($this);
		}

		return $price;
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
	public function lock() {
		$price = $this->app->data->create($this->getParam('price.'));
		$price->set('discount', $this->getParam('discount', 0.00));
		$price->set('markup.', $this->getParam('markup.'));
		$price->set('lock', true);
		return $price;
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
	public function setPrice($name, $value = 0.00) {
		$value = $this->app->number->precision($value, 2);
		$this->register('price.'.$name, (float) $value);
		return $this;
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
	public function getDiscount() {
		return $this->getParam('discount')+1;
		
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
	public function register($name, $value = 0.00) {
		$this->_storage->set($name, $value);
		return $this;
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
	public function setGroup($priceGroup) {
		$parts = explode('.', $priceGroup);
		$this->register('group.', $parts);
		return $this;
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
	public function getGroup($default = null) {
		$group = $this->getParam('group.');
		if(!$group) {
			return $default;
		}
		return implode('.', $group);
		
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
	public function getPriceOptionRules() {

		return $this->app->data->create($this->getParam('options.price', array()));
		
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
	public function toJson($encode = false) {
		$data = $this->lock();
		$data->remove('lock');
		return $encode ? json_encode($data) : $data;
	}	
}

?>