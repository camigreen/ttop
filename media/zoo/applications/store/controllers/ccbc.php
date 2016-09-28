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
class CCBCController extends AppController {

    
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

    public function getPath() {
        return $this->app->path->path('ccbc:');
    }

    public function orderform() {
        $product = 'ccbc';
        $task = $this->app->request->get('t', 'string', null);

        switch($task) {
            case 'manufacturers':
                $layout = 'manufacturers';
                $this->boats = $this->getBoats();
                break;
            case 'models':
                $layout = 'models';
                $manufacturer = $this->app->request->get('m', 'string');
                $this->manufacturer = $this->getBoat($manufacturer);
                break;
            case 'orderform':
                $layout = 'full';
                $values = array();
                $values['year.start'] = $this->item->models->get('24')->params->get('years.start');
                $values['year.end'] = $this->item->models->get('24')->params->get('years.end');
                $xml = $this->xml['config']; 
                $this->form = $this->app->form->create(array($xml->form, compact('layout')));
                $this->form->setAsset((string) $xml->assetName);
                $this->form->setValues($values);
                //$this->item = $this->getBoat($manufacturer);
                break;
        }
        
        $this->getView()->addTemplatePath($this->getPath());
        $this->getView()->setLayout($layout)->display();
    }

    protected function getItem($item) {
        
    }

    public function getModal() {
        $this->app->document->setMimeEncoding('application/json');
        $modal = $this->app->request->get('modal', 'array', array());
        $value = $this->app->request->get('v', 'string', null);
        $html = array();
        $html['content'] = $this->app->modal->create($modal);
        echo json_encode($html);
    }

    

}

/*
    Class: StoreControllerException
*/
class Store2ControllerException extends AppException {}
