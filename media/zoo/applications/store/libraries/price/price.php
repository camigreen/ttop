<?php

/**
* 
*/
class Price 
{
	// Public Variables

	/**
	 * @var [string]
	 */
	public $resource = 'store.lib:/price/list.php';

	// Protected Variables

	/**
	 * The retail price of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_retail;
	
	/**
	 * The discount price of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_discount;

	/**
	 * The markup price of the item.
	 *
	 * @var [datatype]
	 * @since 1.0.0
	 */
	protected $_markup;

	/**
	 * The shipping weight of the item.
	 *
	 * @var [float]
	 * @since 1.0.0
	 */
	protected $_shipWeight;

	/**
	 * Price List for the provided group
	 *
	 * @var [ParameterData]
	 * @since 1.0.0
	 */
	protected $_priceList;

	/**
	 * @var [string]
	 */
	protected $_group;

	/**
	 * @var [float]
	 */
	protected $_base;

	/**
	 * @var [float]
	 */
	protected $_discountRate = 0;

	/**
	 * @var [float]
	 */
	protected $_markupRate = 0;

	/**
	 * @var [float]
	 */
	protected $_defaultMarkupRate = 0;

	/**
	 * @var [array]
	 */
	protected $_price_options;

	/**
	 * Item Object
	 *
	 * @var [StoreItem]
	 * @since 1.0.0
	 */
	public $_item;
	
	
	/*
	* Class Constructor
	*/
	public function __construct($app, StoreItem $item, $resource = null) {
		$this->app = $app;
		// Set the Markup
		$account = $this->app->storeuser->get()->getAccount();
		$this->_defaultMarkupRate = $account->params->get('margin') ? $account->params->get('margin')/100 : ($this->app->storeuser->get()->isReseller() ? 0.15 : 0);
		$this->_markupRate = $this->_defaultMarkupRate;

		// Set the Discount
		$this->_discountRate = $account->params->get('discount')/100;
		$this->setItem($item);

		if($path = $this->app->path->path($this->resource)) {
			include $path;
		}
		$prices = $this->app->parameter->create($price);
		$this->_price_options = $this->app->parameter->create($prices->get($this->_group.'.item.option.'));
		foreach($prices->get($this->_item->type.'.global.option.', array()) as $k => $global) {
			$this->_price_options->set($k, $global);
		}
		$this->allowMarkup = $prices->get($this->_item->type.'.global.allowMarkup', true);
		$this->allowMarkup = $prices->get($this->_group.'.item.allowMarkup', $this->allowMarkup);
		
		$this->_base = $prices->get($this->_group.'.item.base');
		$this->_shipWeight = $prices->get($this->_group.'.shipping.weight');
		if($this->app->storeuser->get()->isReseller()) {
			$this->_discountRate = $prices->get($this->_group.'.item.discount') ? $prices->get($this->_group.'.item.discount') : $this->_discountRate;
			$this->_markupRate = $this->allowMarkup ? $this->_markupRate : 0;
		}
		if($this->_item->discount) {
			$this->_discountRate = $this->_item->discount;
		}
		
	}
	public function get($name = 'retail', $formatted = false) {
		
		if(!method_exists($this, $name)) {
			$name = 'retail';
		}
		
		if ($formatted) {
			$price = $this->app->number->currency($this->$name(), array('currency' => 'USD'));
		} else {
			$price = (float) $this->$name();
		}
		
		return $price;
	}
	
	protected function reseller() {
		$base = $this->base();
		return (float) $base - ($base*$this->_discountRate);
	}
	protected function markup() {
		$base = $this->base();
		if($this->app->storeuser->get()->isReseller()) {
			//$base = $this->reseller();
		}
		return (float) $base + ($base*$this->_markupRate);
	}
	protected function retail($markup = null, $discount = null) {
		$retail = $this->base();
		$retail -= $retail*($discount ? $discount : $this->_discountRate);
		$retail += $retail*($markup ? $markup : $this->_markupRate);
		
		return (float) $retail;
	}
	protected function margin() {
		$margin = $this->markup() - $this->reseller();
		return (float) $margin;
	}

	protected function resellerMSRP() {
		$msrp = $this->base();
		$msrp += $msrp*$this->_defaultMarkupRate;
		return (float) $msrp;
	}
	protected function base() {
		$options = $this->getCalculatedOptions();
		return $this->_base + $options;
	}

	public function allowMarkups() {
		return $this->allowMarkup;
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
	public function getCalculatedOptions() {
		$total = 0;
		foreach($this->getItemOptions() as $key => $value) {
			if($value->get('value')) {
				$total += $this->_price_options->get($key.'.'.$value->get('value'), 0);
			}
		}
		return $total;		
	}
	public function setGroup($value = null) {
		$this->_group = $value;
		return $this;
	}
	public function getGroup() {
		return $this->_group;
	}
	public function getDiscountRate($format = false) {
		$result = $this->_discountRate;
		if($format) {
			return $this->app->number->toPercentage($result*100, 0);
		}
		return $result;
	}
	public function setDiscountRate($value = 0) {
		$this->_discountRate = (float) $value;
		return $this;
	}
	public function getMarkupRate($format = false) {
		$result = $this->_markupRate;
		if($format) {
			$result = $this->app->number->toPercentage($result*100, 0);
		}
		return $result;
	}
	public function setMarkupRate($value = null) {
		if(!is_null($value)) {
			$this->_markupRate = (float) $value;
		}
		return $this;
	}
	public function getProfitRate($format = false) {
		$profit = $this->_discountRate + $this->_markupRate;
		if($format) {
			$profit *= 100;
			$profit = $this->app->number->toPercentage($profit, 0);
		}
		return $profit;
	}
	/**
	 * Set the Item
	 *
	 * @param 	StoreItem	$item 	StoreItem Class Object
	 *
	 * @return 	Price 	$this	Support for chaining.
	 *
	 * @since 1.0
	 */
	public function setItem(StoreItem $item) {
		$this->_item = $item;
		$this->setGroup($item->getPriceGroup());
		$this->setMarkupRate($item->markup);
		return $this;
	}

	/**
	 * Get an Item Option
	 *
	 * @param 	string	$key	The option key
	 *
	 * @return 	mixed	The value of the option.
	 *
	 * @since 1.0
	 */
	protected function _getItemOption($key, $default = null) {
		return $this->_item->options->get($key, $default);
	}

	/**
	 * Get all Item Options
	 *
	 * @return 	ParameterData	ArrayObject Class containing all option data.
	 *
	 * @since 1.0
	 */
	public function getItemOptions() {
		return $this->_item->options;
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
	public function getMarkupList() {
        $default = $this->_markupRate;
        $store = $this->app->store->get();
        $margins = $store->params->get('options.margin.');
        $list = array();
        foreach($margins as $value => $text) {
            $base = $this->base();
            $reseller = $this->reseller();
            $markup = $base += $base*($value/100);
            $diff = $base - $reseller;
            $price = $base;
            $list[] = array('markup' => $value/100, 'price' => $price, 'formatted' => $this->app->number->currency($price, array('currency' => 'USD')), 'text' => ($value === 0 ? '<span class="uk-text-bold"> Base Price </span>' : '').'('.$value.'% Markup + '.($this->getDiscountRate()*100).'% Discount) = ', 'diff' => $diff,'default' => $default == $value/100 ? true : false);
        }
        //var_dump($list);
        return $list;
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
    public function getShippingWeight() {
    	return $this->_shipWeight;
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
    public function __get($name) {
    	return $this->get($name);
    }
}

/**
 * The Exception for the Price class
 *
 * @see Price
 */
class PriceException extends AppException {}

?>