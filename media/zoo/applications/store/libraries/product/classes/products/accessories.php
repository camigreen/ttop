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
class AccessoriesProduct extends Product {

	public $type = 'accessories';


    public function __construct($app, $product) {
        parent::__construct($app, $product);

    }

	public function bind($product = array()) {
        $this->options = $product->params['alias'];
		parent::bind($product);
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
        $rules = array();
        $rules[] = $this->getParam('alias');
        foreach($this->options->getByType('base') as $option) {
            $rules[] = $option->get('value');
        }
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

    public function getSKU() {
        if($this->_patternID) {
            $this->sku = $this->_patternID.'-'.$this->getOption('fabric')->get('value').'-'.$this->getOption('color')->get('text');
        }
        return parent::getSKU();
    }

    public function setBoatLength() {
        $length = $this->getParam('boat.model')->get('length');
        foreach($this->boat_lengths as $rule => $range) {
            $parts = explode('.', $range, 2);
            $min = $parts[0];
            $max = isset($parts[1]) ? $parts[1] : $min;
            if($this->checkRange($length, $min, $max)) {
                $this->getOption('boat_length')->setValue($length);
                $this->getOption('boat_length')->setText($rule);
            }
        } 
        return false;

    }

    public function toJson($encode = false) {
        return parent::toJson($encode);
    }
}