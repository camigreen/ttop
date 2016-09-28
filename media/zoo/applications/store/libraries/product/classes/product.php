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
class Product {

    /**
     * Item ID
     *
     * @var [int]
     * @since 1.0.0
     */
    public $id;

    /**
     * Item ID
     *
     * @var [int]
     * @since 1.0.0
     */
    public $type;
    
    /**
     * Item Name
     *
     * @var [string]
     * @since 1.0.0
     */
    public $name;

    /**
     * Item SKU
     *
     * @var [string]
     * @since 1.0.0
     */
    public $sku;

    /**
     * Pattern Code
     *
     * @var [string]
     * @since 1.0.0
     */
    protected $_patternCode;
    
    /**
     * Qty of the item.
     *
     * @var [int]
     * @since 1.0.0
     */
    public $qty = 1;

    /**
     * Contains the ParamterData Class to hold the item parameters.
     *
     * @var [ParameterData]
     * @since 1.0.0
     */
    public $params = array();
    
    /**
     * Array of options and thier values. An option is a variation of the product that will increase the price.
     *
     * @var [array]  Will be one of three categories. (priced, base, variable)
     * @since 1.0.0
     */
    public $options = array();

    /**
     * Description of the item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $description;
    
    /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $price_group;

    /**
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    protected $price;

    /**
     * Reference to the App Object.
     *
     * @var [App]
     * @since 1.0.0
     */
    public $app;

    /**
     * Class constructor
     *
     * @param datatype    $app    Parameter Description
     */
    public function __construct($app) {

        $this->app = $app;
        $this->params = $this->app->parameter->create($this->params);
        $this->options = $this->app->data->create($this->options);

    }

    public function bind($product) {
        return $this;
    }

    /**
     * Get a property
     *
     * @param   $name       String      Name of the property to get
     * @param   $default    Mixed       The default value if no value is found
     *  
     * @return  Mixed   The value of the property.
     *
     * @since 1.0
     */
    public function get($name, $default = null) {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return false;
    }

    public function set($name, $value) {
        if(property_exists($this, $name)) {
            $this->$name = $value;
        }
        return $this;
    }

    public function getParam($name, $default = null) {
        return $this->params->get($name, $default);
    }

    public function setParam($name, $value) {
        $this->params->set($name, $value);
        return $this;
    }

    public function getOption($name, $default = null) {
        return $this->options->get($name, $default);
    }

    public function setOption($name, $value) {
        $this->options->set($name, $value);
        return $this;
    }

    public function getAttribute($name, $default = null) {
        return $this->attributes->get($name, $default);
    }

    public function setAttribute($name, $value) {
        $this->attributes->set($name, $value); 
        
        return $this;
    }

    public function getSKU() {
        return $this->sku;
    }

    public function getHash() {}

    public function getPatternCode() {
        if($this->_patternCode) {
            return $this->_patternCode;
        }
        $type = $this->type;
        $make = $this->getParam('boat.manufacturer');
        $model = $make->getModel();
        if($type && $make && $model) {
            $code = strtoupper($type).'-'.$make->skucode.$model->get('skucode');
        } else {
            var_dump($type);
            var_dump($make->skucode);
            var_dump($model->get('skucode'));
            return $this->_patternCode = null;
        }
        $patterns = $this->app->pattern->get($code);
        foreach($patterns as $id => $option) {
                $match = true;
            foreach($option as $key => $value) {

                if($key == 'year') {
                    $year = (int) $this->options->get('year')->get('value');
                    var_dump($year);
                    //list($start, $end) = explode('|', $value);
                    $range = explode('|', $value);
                    if(count($range) == 1) {
                        $start = $range[0];
                        $end = date('m') < 5 ? date('Y') : date('Y')+1;
                    } else {
                        $start = (int) $range[0];
                        $end = (int) $range[1];
                    }
                    echo 'Year: '.$year.'</br>';
                    echo 'Start: '.$start.'</br>';
                    echo 'End: '.$end.'</br>';
                    if($year < $start) {
                        $match = false;
                        var_dump('too old');
                    }
                    if($year > $end) {
                        $match = false;
                        var_dump('too New');
                    }

                } else if(!$this->options->get($key) || $this->options->get($key)->get('value') != $value) {
                    $match = false;
                }
            }                
            if($match) {
                $this->_patternCode = $code.'-'.$id;
                return $this->_patternCode;
            } else {
                $this->_patternCode = null;
            }
        }
        return $this->_patternCode;
    }

    public function generateSKU() {
        
    }
    
}