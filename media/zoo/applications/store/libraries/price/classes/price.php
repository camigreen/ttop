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
	public function __construct($app, $data) {
		$this->app = $app;
		$this->_storage = $this->app->parameter->create();
		$this->init($data);
		$this->calculate();
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
	public function init($data) {
		$this->register('path.rules.item', $data['path.rules.item']);
		$this->register('path.rules.global', $data['path.rules.global']);
		$this->register('product.type', $data['product.type']);
		$this->setRule($data['rule']);
		$this->register('options.product.', $data['options.product']);
		if(!$this->_loadRules()) {
			return false;
		}
		if(!$this->_addOptions()) {
			return false;
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
		
		$base = $this->get('base');
		$msrpMkup = $this->getMarkupRate('msrp');
		
		$discount = $this->getDiscountRate();
		$addons = $this->get('addons');
		$msrp = $base*$msrpMkup;
		$msrp += $addons;
		$this->setPrice('msrp', $msrp);
		$display = $msrp*$discount;
		$this->setPrice('display', $display);
		$this->setPrice('charge', $display);

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
	protected function _loadRules() {

		if($this->getParam('path.rules.global')) {
			include $this->getParam('path.rules.global');
		}		
		if($this->getParam('path.rules.item')) {
			include $this->getParam('path.rules.item');
		}

		$rules = $this->app->parameter->create($rules);
		
		if (!$rules->get($this->getRule().'.')) {
            return false;
        }
		$data = $this->app->parameter->create();

		$data = $this->_addGlobalRules($rules, $data);

		$data = $this->_addTypeRules($rules, $data);

		$data = $this->_addItemRules($rules, $data);

		$this->register('options.price.', $data->get('options.'));
		$this->register('allowMarkup', $data->get('allowMarkup'));
		$this->register('weight', $data->get('weight'));
		$this->setPrice('base', $data->get('base', 0.00));
		if($this->app->storeuser->get()->isReseller()) {
			$this->setDiscountRate($data->get('discount.reseller'));
		} else {
			$this->setDiscountRate($data->get('discount.retail'));
		}
		$this->setMarkupRate('msrp', $data->get('markup.msrp', 0.00));
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
		foreach($this->getParam('rule.', array()) as $part) {
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
		$productOptions = $this->getParam('options.product.', array());
		$rules = $this->getPriceOptionRules();
		foreach($productOptions as $name => $option) {
			$value = $option->get('type') == 'price.adj' ? null : '.'.$option->get('value');
			$price = $rules->get($name.$value, 0.00);
			$price = $option->get('cost', $price);
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

	public function getParams() {
		return $this->_storage;
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

		if($name == 'charge') {
			$price = $this->getParam('price.charge', $this->getParam('price.display', $default));
		} else {
			$price = $this->getParam('price.'.$name, $default);
		}
		
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
	public function getAll() {
		$prices = $this->app->parameter->create($this->getParam('price.'));
		$prices->set('markupRate', $this->getParam('markup.msrp'));
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
	public function lock() {
		$price = $this->app->parameter->create($this->getParam('price.'));
		$price->set('discount', $this->getParam('discount'));
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
	public function getDiscountRate($default = 0) {
		$discount = (float) $this->getParam('discount', $default);
		if($discount == 0) {
			$discount = 1;
		}
		
		return $discount;
		
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
	public function setDiscountRate($value = 0) {
		if(is_null($value)) {
			return $this;
		}
		$value = $value >= 1 ? $value/100 : $value;
		$this->register('discount', (float) 1 - $value);
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
	public function getMarkupRate($name = 'msrp', $default = 0) {
		return $this->getParam('markup.'.$name, (float) $default);
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
	public function setMarkupRate($name, $value = 0) {
		if($name == 'reseller' && !$this->allowMarkups()) {
			$value = 0;
		}
		$value = $value >= 1 ? $value/100 : $value;
		$this->register('markup.'.$name, (float) $value + 1);
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
	public function allowMarkups() {
		return $this->_storage->get('allowMarkup', true);		
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
	public function setRule($rule) {
		$parts = explode('.', $rule);
		$this->register('rule.', $parts);
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
	public function getRule($default = null) {
		$rule = $this->getParam('rule.');
		if(!$rule) {
			return $default;
		}
		return implode('.', $rule);
		
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

		return $this->app->data->create($this->getParam('options.price.', array()));
		
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

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function debug($toDisplay = false) {
		if($toDisplay) {
			var_dump($this->_storage);
		}
		return $this->_storage;
		
	}
}

?>