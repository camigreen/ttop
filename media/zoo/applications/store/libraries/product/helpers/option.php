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

    /**
     * Get a ParameterData object
     * 
     * @param array $params The list of params to convert
     * 
     * @return ParameterData The object representing the params
     * 
     * @since 1.0.0
     */
    public function create($name, $value = null) {
        $this->app->loader->register('JSONData', 'data:json.php');
        $xml = simplexml_load_file($this->app->path->path('fields:config.xml'));
        $option = null;
        foreach ($xml->field as $field) {
            if((string) $field->attributes()->name == $name) {
                $option = $this->app->data->create(array(), 'option');
                foreach($field->attributes() as $key => $val) {
                    $option->set($key, (string) $val);
                }
                if($value) {
                    $option->set('value', $value);
                    foreach($field->option as $opt) {
                        if($opt->attributes()->value == $value) {
                            $option->set('text', (string) $opt);
                        }
                    }
                }
            }
        }
        return $option;
    }

}
