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
class CCBCProduct extends Product {

	public $type = 'ccbc';

    protected $_defaultOptions = array(
        'ccbc.fabric', 
        'boat_length', 
        'color',
        'boat_style', 
        'zipper', 
        'storage', 
        'motors',
        'motor_make',
        'motor_size',
        'jack_plate',
        'power_poles',
        'year',
        'poling_platform',
        'bow_rails',
        'casting_platform',
        'trolling_motor',
        'ski_tow_bar'
    );

    public function __construct($app) {
        parent::__construct($app);

    }

	public function bind($product) {
		parent::bind($product);
        $this->setOption('ccbc.fabric', '9oz');
		$this->id = 'ccbc';
		$this->name = 'Center Console Boat Cover';
		return $this;
	}

	    /**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getPriceGroup() {
    	$priceGroup[] = parent::getPriceGroup();
    	$make = $this->getParam('boat.manufacturer');
    	//$priceGroup[] = $make->getModel()->get('length');
    	$priceGroup[] = $this->getOption('ccbc.fabric')->get('value');

        return implode('.', $priceGroup);
        
    }

    public function getSKU() {
        if($this->_patternID) {
            $this->sku = $this->_patternID.'-'.$this->getOption('ccbc.fabric')->get('value').'-'.$this->getOption('color')->get('value');
        }
        return parent::getSKU();
    }
}