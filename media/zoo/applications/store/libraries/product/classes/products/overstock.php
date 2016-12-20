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
class OverstockProduct extends Product {

    protected $boat_lengths = array(
            '17' => '17',
            '1819' => '18.19',
            '2021' => '20.21',
            '2223' => '22.23',
            '2425' => '24.25',
            '26' => '26'

        );

    public function __construct($app, $product) {
        parent::__construct($app, $product);

    }

    public function bind($product = array()) {
        $this->options = $product->params['optionType'];

        parent::bind($product);
        $this->name = $product->get('productName');
        $this->id = $this->id;
        $boat_make = $this->getParam('boat.manufacturer');
        $boat_model = $this->getParam('boat.model');
        $this->setParam('boat.manufacturer', $this->app->boat->create($boat_make, $boat_model));
        $this->setParam('boat.model',$this->getParam('boat.manufacturer')->getModel());
        $this->setOptionValue('boat_make', $this->getParam('boat.manufacturer')->label);
        $this->setOptionValue('boat_model', $this->getParam('boat.model')->label);
        foreach($this->getParam('boat.model')->get('options', array()) as $option) {
            $this->setOption($option->get('name'), $option);
        }
        $this->description = 'Custom fit for a '.$this->getParam('boat.manufacturer')->label.' '.$this->getParam('boat.model')->label;
        $this->setBoatLength();
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
    public function setPriceRule($value = null) {
        if($value) {
            $this->_priceRule = $value;
            return $this;
        }

        $priceRule[] = $this->getOption('boat_length')->getText();
        $priceRule[] = $this->getOption('fabric')->getValue();

        $this->_priceRule = implode('.', $priceRule);

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

    public function getHash() {
        $sku = array();
        $sku[] = $this->id;
        return hash('md5', implode('.', $sku));
    }

    public function setBoatLength() {
        $length = $this->getOption('boat_length')->get('value');
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
        $data = parent::toJson();
        $data['params']['boat.model'] = $this->getParam('boat.model')->name;
        $data['params']['boat.manufacturer'] = $this->getParam('boat.manufacturer')->name;

        return $encode ? json_encode($data) : $data;
    }
}