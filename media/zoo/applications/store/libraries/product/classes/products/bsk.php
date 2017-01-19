<?php defined('_JEXEC') or die('Restricted access');

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
class BSKProduct extends Product {

	public $type = 'bsk';

    public function __construct($app, $product) {
        parent::__construct($app, $product);

    }

	public function bind($product = array()) {
        $this->options = $this->type;
		parent::bind($product);
		$this->id = 'bsk';
		$this->name = 'Boat Shade Kit';
        $this->setPriceRule();
		return $this;
	}
    
    /**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function setPriceRule() {
        $rules[] = $this->getOption('class')->get('value');
        $rules[] = $this->getOption('bsk_kit')->get('value');
        $this->_priceRule = implode('.', $rules);
        return $this;  
    }
	/**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getPriceRule($default = null) {
        return $this->_priceRule ? $this->_priceRule : $default;
        
    }
    public function getHash() {
        $sku = array();
        foreach($this->getOptions() as $option) {
            $sku[] = $option->get('name').$option->get('value');
        }
        $sku[] = $this->getPrice();
        $sku[] = $this->name;
        $sku[] = $this->id;
        $sku[] = $this->getParam('location');
        return hash('md5', implode('.', $sku));
    }

    public function getHash() {
        $sku = array();
        foreach($this->getOptions() as $option) {
            $sku[] = $option->get('name').$option->get('value');
        }
        $sku[] = $this->getPrice();
        $sku[] = $this->name;
        $sku[] = $this->id;
        $sku[] = $this->getParam('location');
        return hash('md5', implode('.', $sku));
    }

    public function getSKU() {
        return parent::getSKU();
    }

    public function toJson($encode = false) {
        $json = parent::toJson();
        //$json['transferPrice'] = $this->getTotalPrice();
        return $encode ? json_encode($json) : $json;
    }
}