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
class CCCProduct extends Product {

	public $type = 'ccc';

    public function __construct($app, $product) {
        parent::__construct($app, $product);

    }

	public function bind($product = array()) {
        $this->options = $this->type;
		parent::bind($product);
		$this->id = 'ccc';
		$this->name = 'Center Console Curtain';

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
        $rules[] = $this->getOption('fabric')->get('value');
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
}