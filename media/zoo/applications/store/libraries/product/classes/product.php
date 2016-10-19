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
    protected $_patternID;
    
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
     * @var [array]  Will be one of three categories. (price, base, pattern)
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
     * String that identifies the pricing group of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    protected $_defaultOptions = array();

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
        $exclude = array('options', 'params');
        foreach($product as $key => $value) {
            if(property_exists($this, $key) && !in_array($key, $exclude)) {
                $this->$key = $value;
            } else if (!in_array($key, $exclude)) {
                $this->setParam($key, $value);
            }
        }
        foreach($this->_defaultOptions as $option) {
            $this->setOption($option);
        }
        foreach($product->get('options', array()) as $key => $value) {
            $this->options->set($key, $this->app->parameter->create($value));
        }
        foreach($product->get('params', array()) as $key => $value) {
            $this->params->set($key, $this->app->parameter->create($value));
        }
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

    public function getPatternOptions($name = null) {
        $result = array();
        foreach($this->options as $option) {
            if($option->get('type') == 'pattern') {
                $result[$option->get('name')] = $option;
            }
        }
        return $result;
    }

    public function setOption($name, $value = null) {
        if($option = $this->getOption($name)) {
            $option->set('value', $value);
            return $this;
        }
        if($option = $this->app->option->create($name, $value)) {
            $this->options->set($name, $option);
        }
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

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function getPrice() {
        if(!$this->price) {
            $this->price = $this->app->price->create($this);
        }
        return $this->price;
        
    }

    /**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getPriceGroup() {
        return $this->type;
        
    }

    public function getHash() {}

    public function getPatternID() {
        if($this->_patternID) {
            return $this->_patternID;
        }
        $type = $this->type;
        $make = $this->app->boat->create($this->getParam('boat.manufacturer'), $this->getParam('boat.model'));
        $model = $make->getModel();
        if($type && $make && $model) {
            $code = strtoupper($type).'-'.$make->skucode.$model->get('skucode');
        } else {
            return $this->_patternID = null;
        }
        $patterns = $this->app->pattern->get($code);
        foreach($patterns as $id => $option) {
                $match = true;
            foreach($option as $key => $value) {
                if(is_array($value)) {
                    $min = $value['min'];
                    $max = $value['max'];
                    switch($key) {
                        case 'year':
                            $year = $this->options->get('year');
                            
                            if($year = $this->getOption('year')) {
                                $max = $max ? $max : (date('m') < 5 ? date('Y') : date('Y')+1);
                                if(!$this->checkRange($year->value, $min, $max)) {
                                    $match = false;
                                }
                            }
                            break;
                        default:
                            $val = $this->options->get($key);
                            if($val && !$this->checkRange($val->value, $min, $max)) {
                                $match = false;
                            }
                    }
                } else if(!$this->options->get($key) || $this->options->get($key)->get('value') != $value) {
                    $match = false;
                }
                var_dump($key.' - '.($match ? 'True' : 'False'));
                if(!$match) {
                    break;
                }
            }

            if($match) {
                $this->_patternID = $code.'-'.$id;
                return $this->_patternID;
            } else {
                $this->_patternID = null;
            }
        }
        return $this->_patternID;
    }

    public function checkRange($value, $min, $max) {
        $result = false;
        if(!$min || $value >= $min) {
            $result = true;
        }
        if($result && (!$max || $value <= $max)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    public function __get($name) {
        return $this->getParam($name);
    }

    public function __toString() {
        $exclude = array('app');
        $data = array();
        foreach($this as $key => $value) {
            if(!in_array($key, $exclude)) {
                $data[$key] = $value;
            }
        }
        $data = $this->app->data->create($data);
        return (string) $data;
    }
    
}