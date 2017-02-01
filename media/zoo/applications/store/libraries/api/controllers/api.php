<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
    Class: DefaultController
        Site controller class
*/
class ApiController extends AppController {

    protected $_api;

    
    public function __construct($default = array()) {
        parent::__construct($default);

        // get application
        $this->application = $this->app->zoo->getApplication();

        // get Joomla application
        $this->joomla = $this->app->system->application;

        // get params
        $this->params = $this->joomla->getParams();

        // get pathway
        $this->pathway = $this->joomla->getPathway();

        // registers tasks
//      $this->registerTask('checkout', 'checkout');
        //$this->registerTask('getMake', 'display');
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

        $this->app->document->setMimeEncoding('application/json');

        $name = $this->app->request->get('api', 'string');

        $task = $this->getTask();

        $result = array();
        $result['errors'] = array();

        $args = $this->app->request->get('post:', 'array', array());

        try {
            $this->_api = $this->app->api->create($name);
        } catch(Exception $e) {
            $result['errors'][] = $e->getMessage();
        }
        
        if($this->_api) {

            try {
                $result['result'] = call_user_func_array(array($this->_api, $task), $args);
            } catch (Exception $e) {
                $result['errors'][] = $e->getMessage();
            }

        }
        if(isset($result['result']['output']) && $result['result']['output']) {
            echo json_encode($result);
        }
        
            
            
    }





}

/*
    Class: StoreControllerException
*/
class ApiControllerException extends AppException {}