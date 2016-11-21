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
class ModalController extends AppController {

    
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
        // $this->registerTask('checkout', 'checkout');
        // $this->registerTask('products', 'product');
    }
    
    /*
            Function: display
                    View method for MVC based architecture

            Returns:
                    Void
    */
    public function display($cachable = false, $urlparams = false) {

            // execute task

    }

    public function getModal() {
        $this->app->document->setMimeEncoding('application/json');
        $config = $this->app->request->get('config', 'array', array());
        $html = array();
        $html['content'] = $this->app->modal->create($config);
        echo json_encode($html);
    }

    

}

/*
    Class: StoreControllerException
*/
class ModalControllerException extends AppException {}
