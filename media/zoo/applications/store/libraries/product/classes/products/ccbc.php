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

    public function __construct($app) {
        parent::__construct($app);
        $fabric = array(
            'name' => 'fabric',
            'value' => '9oz',
        );
        $this->setOption('fabric', $this->app->parameter->create($fabric));
    }

	public function bind($product) {
		parent::bind($product);
		$make = $this->app->boat->create($product->get('make'), $product->get('model'));
		$this->setParam('boat.manufacturer', $make);
		$model = $make->getModel();
        foreach($model->get('options', array()) as $name => $option) {
            $this->setOption($name, $option);
        }
		
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
    	$priceGroup[] = $make->getModel()->get('length');
    	$priceGroup[] = $this->getOption('fabric')->get('value');

        return implode('.', $priceGroup);
        
    }
}