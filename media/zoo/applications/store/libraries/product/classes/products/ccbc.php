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

    protected $boat_lengths = array(
            '17' => '17',
            '1819' => '18.19',
            '2021' => '20.21',
            '2223' => '22.23',
            '2425' => '24.25',
            '26' => '26'

        );

    public function __construct($app) {
        parent::__construct($app);

    }

	public function bind($product) {
		parent::bind($product);
		$this->id = 'ccbc';
		$this->name = 'Center Console Boat Cover';
        $boat_make = $this->getParam('boat.manufacturer');
        $boat_model = $this->getParam('boat.model');
        $this->setParam('boat.manufacturer', $this->app->boat->create($boat_make, $boat_model));
        $this->setParam('boat.model',$this->getParam('boat.manufacturer')->getModel());
        $this->setBoatLength();
        foreach($this->getParam('boat.model')->get('options', array()) as $option) {
            $this->setOption($option->get('name'), $option);
        }
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
        if($parent = parent::getPriceRule()) {
            $priceRule[] = $parent;
        }
    	$priceRule[] = $this->getOption('boat_length')->getText();
    	$priceRule[] = $this->getOption('fabric')->getValue();

        return implode('.', $priceRule);
        
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
        $exclude = array('app', 'boat_lengths', '_patternID', 'price', '_priceRule', 'params', 'options');
        $data = $this->app->data->create();
        foreach($this as $key => $value) {
            if(!in_array($key, $exclude)) {
                $data->set($key, $value);
            }
        }
        $make = $this->getParam('boat.manufacturer');
        $data->set('boat.manufacturer', $make->name);
        $data->set('boat.model', $make->getModel()->get('name'));
        $data->set('options', $this->options->toJson());
        $data->set('sku', $this->getSKU());
        $data->set('pattern', $this->getPatternID());
        return $encode ? json_encode($data) : $data;
    }
}