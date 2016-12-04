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
class Options {

	protected $_storage;
    protected $_xml;
    public $type;

    public function __construct($app, $type) {
    	$this->app = $app;
        $this->app->loader->register('JSONData', 'data:json.php');
        $this->_storage = $this->app->data->create();
        $this->type = $type;
        if(file_exists($this->app->path->path('fields:options/'.$type.'.xml'))) {
            $this->_xml = simplexml_load_file($this->app->path->path('fields:options/'.$type.'.xml'));
        } else {
            $this->_xml = null;
        }
        
        $this->init();
        
    }

    /**
     * Describe the Function
     *
     * @param 	datatype		Description of the parameter.
     *
     * @return 	datatype	Description of the value returned.
     *
     * @since 1.0
     */
    protected function init() {
    	$this->loadFromXML();
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
    public function set($name, $value = array()) {
        $this->_storage->set($name, $this->app->data->create($value, 'option'));
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
    public function setValue($name, $value) {
        if($option = $this->get($name)) {
            $option->setValue($value);
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
    public function get($name, $default = null) {
        return $this->_storage->get($name, $default);
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
    public function getAll() {
        return $this->_storage;
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
    public function getByType($type) {
        $options = array();
        foreach($this->_storage as $name => $option) {
            $types = explode('|', $option->get('type'));
            if(in_array($type, $types)) {
                $options[$name] = $option;
            }
        }
        return $this->app->data->create($options);
    }


    /**
     * Describe the Function
     *
     * @param 	datatype		Description of the parameter.
     *
     * @return 	datatype	Description of the value returned.
     *
     * @since 1.0
     */
    protected function loadFromXML($xml = null) {
        if(!$this->_xml) {
            return $this;
        }
        if(!$xml) {
            $xml = $this->_xml;
        }  	
    	$option = array();
        foreach($xml->field as $field) {
            $option = array();
            foreach ($field->attributes() as $key => $param) {
                switch($key) {
                    case 'default':
                        $option['value'] = (string) $param;
                        break;
                    case 'name':
                        $name = (string) $param;
                    default:
                        $option[$key] = (string) $param;
                }
            }
            foreach($field->option as $choice) {
                $choices = array();
                $key = (string) $choice->attributes()->value;
                $choices['text'] = (string) $choice;
                $choices['value'] = (string) $choice->attributes()->value;
                $option['choices.'.$key] = $this->app->data->create($choices);
            }
            $this->set($name, $option);
            if(isset($option['value'])) {
                $this->setValue($name, $option['value']);
            }
        }
    	return $this;
    }

    public function toJson($encode = false) {
        
        return $encode ? json_encode($this->_storage) : $this->_storage;
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
       function jsonSerialize() {
           return $this->_storage;// Encode this array instead of the current element
    }

}