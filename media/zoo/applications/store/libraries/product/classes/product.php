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
    public $options;

    /**
     * Description of the item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $description;
    
    /**
     * String that identifies the pricing rule of an item.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $_priceRule;

    /**
     * Array object containing the prices.
     *
     * @var [string]
     * @since 1.0.0
     */
    public $price;

    /**
     * Storage of the price object.
     *
     * @var [string]
     * @since 1.0.0
     */
    protected $_price;

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
    public function __construct($app, $product) {

        $this->app = $app; 
        $this->bind($product);
        $this->initPrice();
        

    }

    public function bind($product = array()) {

        // Bind all variable except options and params
        $exclude = array('options', 'params', 'price', 'locked');
        foreach($product as $key => $value) {
            if(property_exists($this, $key) && !in_array($key, $exclude)) {
                $this->$key = $value;
            } 
        }

        
        // Bind options
        $this->options = $this->app->option->create($this->options);
        foreach($product->get('options', array()) as $name => $value) {
            if(isset($value['value']) && $value['value']) {
                try{
                    $this->setOptionValue($name, $value['value']);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                
            }
        }
        // Bind Params
        $this->params = $this->app->parameter->create($product->get('params'));
        // foreach($product->get('params', array()) as $key => $value) {
        //     $this->params->set($key, $value);
        // }
        if(!$this->params->get('confirmed')) {
            $this->params->set('confirmed', false);
        }

        $this->setParam('locked', $product->get('locked', $this->getParam('locked', false)));

        if($oid = $this->app->session->get('orderID', null, 'checkout')) {
            $order = $this->app->orderdev->get($oid);
            $this->setParam('user', $order->getUser());
        }

        if($this->isLocked()) 
            $this->price = $product->get('price');

        $this->setPriceRule();

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

    public function getOptions($type = null) {
        if ($type == null) {
            return $this->options->getAll();
        }
        $result = array();
        foreach($this->options as $option) {
            $types = explode('|', $option->get('type'));
            if(in_array($type, $types)) {
                $result[$option->get('name')] = $option;
            }
        }
        return $this->app->data->create($result);
        
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
    public function increaseQty($qty = 1) {
        $this->qty += $qty;
        return $this;
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
    public function decreaseQty($qty = 1) {
        $this->qty -= $qty;
        return $this;
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
    public function setQty($qty) {
        $this->qty = $qty;
        return $this;
    }

    public function getQty() {
        return $this->qty;
    }

    public function setOption($name, $value = array()) {
        $this->options->set($name, $value);
        return $this;
    }

    public function setOptionValue($name, $value = null) {
        $this->options->setValue($name, $value);
        if($this->getOption($name) && $this->getOption($name)->isPriceOption() && $this->price) {
            $this->refreshPrice();
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

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function getWeight() {
        return $this->getParam('weight', 0);
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
    public function initPrice() {
        if(!$this->isLocked()) {
            $this->_price = $this->app->price->create($this);
            $this->setDiscountRate($this->getParam('discount'));
            $this->price = $this->_price->getAll();
            $this->setParam('weight', $this->_price->getParam('weight',0));
        } else {
            try {
                $this->price = $this->app->data->create($this->price);
            } catch (Exception $e) {
                throw new Exception('Problem Initializing Price Object', 1001);
            }
            
        }
        return $this;
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
    public function refreshPrice() {
        if(!$this->isLocked()) {
            $this->_price->calculate();
            $this->price = $this->_price->getAll();
        }
        return $this;
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
    public function getPrice($name = 'display', $default = 0.00, $formatted = false) {
        // Workaround for older orders without the charge variable
        if($name == 'charge' && is_null($default)) {
            $default  = $this->price->get('display');
        }
        $price = $this->price->get($name, $default);

        if($formatted) {
            $price = $this->app->number->currency($price, array('currency' => 'USD'));
        }
        return $price;

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
    public function setAllowMarkup($bool = true) {
        $this->_price->setAllowMarkup($bool);
        $this->refreshPrice();
    }

    /**
     * Is the user allowed to markup the price of this item?
     *
     * @return     boolean    True or False
     *
     * @since 1.0
     */
    public function allowMarkups() {
        return $this->_price->allowMarkups();
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
    public function getMarkupRate($default = 0) {
        $markup = $this->price->get('markupRate', $default);
        $markup = $markup >=1 ? ($markup - 1)*100 : $markup;
        return $markup; 
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
    public function getMsrpMarkup($default = 0) {
        return $this->price->get('msrpMarkup', $default);
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
    public function getDiscountRate($default = 0) {
        return (1-$this->_price->getDiscountRate())*100;
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
    public function setDiscountRate($name = 'default', $rate = null) {
        if($rate) {
            $this->_price->setDiscountRate($name, $rate);
            $this->refreshPrice();
        }
        return $this;
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
    public function setChargePrice($price = 'display') {
        $this->_price->register('charge', $price);
        $this->refreshPrice();
        return $this;
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
    public function setDisplayPrice($price = 'retail') {
        $this->_price->register('display', $price);
        $this->refreshPrice();
        return $this;
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
    public function getTotalPrice($name = 'display', $formatted = false) {
        $total = $this->getPrice($name) * $this->getQty();
        if($formatted) {
            $total = $this->app->number->currency($total, array('currency' => 'USD'));
        }
        return $total;
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
    public function lock() {
        $this->setParam('locked', true);
        $product = $this->toJson();
        return $product;
        
    }

    /**
     * Determines if the product is locked.
     *
     * @return     bool    Locked status.
     *
     * @since 1.0
     */
    public function isLocked() {
        return $this->getParam('locked', false) == 'true' ? true : false;
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
    protected function _lockPrice() {
        if(!$this->price || !$this->price->get('lock')) {
            $this->price = $this->app->price->create($this);
        } 
        $this->price = $this->price->lock();
        return $this->price;
    }

    /**
     * Get the price group for the item.
     *
     * @return     string    the price group.
     *
     * @since 1.0
     */
    public function getPriceRule() {
        return $this->_priceRule = $this->type;
        
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
    public function setPriceRule() {
        $this->_priceRule = $this->type;
        return $this;
    }

    public function getHash() {
        $sku = array();
        foreach($this->getOptions() as $option) {
            $sku[] = $option->get('name').$option->get('value');
        }
        $sku[] = $this->getPrice();
        $sku[] = $this->name;
        $sku[] = $this->id;
        return hash('md5', implode('.', $sku));
    }

    public function getPatternID() {
        if($this->_patternID) {
            return $this->_patternID;
        }
        $type = $this->type;
        $make = $this->getParam('boat.manufacturer');
        $model = $make->getModel();
        if($type && $make && $model) {
            $code = strtoupper($type).'-'.$make->skucode.$model->get('skucode');
        } else {
            return $this->_patternID = null;
        }
        $patterns = $this->app->pattern->get($code);
        if(!$patterns) {
            $this->_patternID = null;
            return;
        }
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
                // var_dump($key.' - '.($match ? 'True' : 'False'));
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

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function isTaxable() {
        return true;
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
    public function getCartDetails() {
        $details = $this->app->parameter->create();
        $details->set('name', $this->name);
        $details->set('qty', $this->getQty());
        $details->set('price', $this->getTotalPrice());
        $details->set('description', $this->description);
        foreach($this->getOptions() as $option) {
            if($option->get('visible')) {
                $details->set('options.'.$option->get('label'), $option->get('text'));
            }
        }
        return $details;
    }

    public function toJson($encode = false) {
        $exclude = array('app', 'options', '_price', 'price', '_patternID', '_priceRule', 'boat_lengths');
        $data = array();
        foreach($this as $key => $value) {
            if(!in_array($key, $exclude)) {
                $data[$key] = $value;
            }
        }
        $options = array();
        foreach($this->options->getAll() as $name => $option) {
            $option->remove('choices.');
            $options[$name] = $option;
        }
        $data['options'] = $options;
        if($this->isLocked()) {
            $data['price'] = $this->price;
        }

        return $encode ? json_encode($data) : $data;
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
    public function debug() {
        $this->_price->debug(true);
    }
    
}