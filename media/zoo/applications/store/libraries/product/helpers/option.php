<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/**
 * Helper class to create JSONData object representing parameters
 * 
 * @package Framework.Helpers
 */
class OptionHelper extends AppHelper {

    protected $_options;
    protected $_xml;
    public $productType = 'ccbc';

    public function __construct($app) {
        parent::__construct($app);
        $this->app->loader->register('JSONData', 'data:json.php');
        $this->app->loader->register('ParameterData', 'data:parameter.php');
        $this->app->loader->register('Options', 'classes:options.php');
        $this->_options = $this->app->data->create();
        
    }

    /**
     * Get a ParameterData object
     * 
     * @param array $params The list of params to convert
     * 
     * @return ParameterData The object representing the params
     * 
     * @since 1.0.0
     */
    public function create($type) {
        $options = new Options($this->app, $type);
        return $options;
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
    public function isPriceOption($option) {
        $types = explode('|', $option->get('type'));
        if(in_array('price', $types)) {
            return true;
        }
        return;
    }

    public function getOptionText($name, $value) {
        $xml = $this->_xml;
        foreach($xml->field as $field) {
            if($field->attributes()->name == $name) {
                foreach($field->option as $option) {
                   return (string) $option; 
                }
            }
        }
        return;
    }

    public function getOptionCost($name, $value) {
        $xml = $this->_xml;
        foreach($xml->field as $field) {
            if($field->attributes()->name == $name) {
                foreach($field->option as $option) {
                   if($option->attributes()->value == $value) {
                    return (float) $option->attributes()->cost;
                   }
                }
            }
        }
        return;
    }

    public function getOptionFromXML($name) {
        $xml = $this->_xml;
        foreach($xml->field as $field) {
            if($field->attributes()->name == $name) {
                $option = $this->app->parameter->create();
                foreach ($field->attributes() as $key => $param) {
                    $option->set($key, (string) $param);
                }
                return $option;
            }
        }
        return $this->app->parameter->create();
    }

}
