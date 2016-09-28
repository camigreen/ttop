<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package   Manufacturer Class
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class Manufacturer {

    public $name;

    public $skucode;

    public $label;

    public $description;

    protected $_models = array();

    public $params;

    /**
     * Class constructor
     *
     * @param datatype    $app    Parameter Description
     */
    public function __construct($app) {

        $this->app = $app;
        $this->_models = $this->app->data->create($this->_models);
        $this->params = $this->app->parameter->create($this->params);

    }

    public function bind($manufacturer) {
        foreach($manufacturer as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        $this->_models = $manufacturer->get('models');

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
    public function getModel($name = 'default', $default = null) {
        if($name == 'default') {
            $name = $this->getParam('choosenModel');
        }
        return $this->_models->get($name, $default);
    }
    public function setModel($name, $value) {
        $this->_models->set($name, $value); 
        
        return $this;
    }

    public function getModels() {
        return $this->_models;
    }
    
}