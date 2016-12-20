<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class ApiHelper extends AppHelper {

    protected $_apis = array();
    

    public function __construct($app) {
        parent::__construct($app);
        $this->app->loader->register('API','apis:api.php');

    }

    public function create($name = null) {
        $class = $name.'API';

        if(!file_exists($this->app->path->path('apis:'.$name.'.php'))) {
            throw new Exception('API {'.$name.'} does not exist.');
        }

        $this->app->loader->register($class, 'apis:'.$name.'.php');

        $api = new $class($this->app);

        $this->_apis[$name] = $api;

        return $this->_apis[$name];
    }

}