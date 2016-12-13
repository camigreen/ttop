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
class UBSKProduct extends Product {

	public $type = 'ubsk';

    public function __construct($app, $product) {
        parent::__construct($app, $product);

    }

	public function bind($product = array()) {
        $this->options = $this->type;
		parent::bind($product);
		$this->id = 'ubsk';
		$this->name = 'Ultimate Boat Shade Kit';
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
        $rules[] = $this->getOption('kit_class')->get('value');
        $rules[] = $this->getOption('kit_options')->get('value');
        if($this->getOption('shade_type')->get('value') != 'regular') {
            $rules[] = $this->getOption('shade_type')->get('value');
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
        return parent::getSKU();
    }

    public function toJson($encode = false) {
        return parent::toJson($encode);
    }
}