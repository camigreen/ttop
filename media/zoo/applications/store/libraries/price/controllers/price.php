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
class PriceController extends AppController {

    
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

            // execute task
        var_dump($this->pathway);
            $model = $this->request->get('model', 'string');
            $make = $this->app->request->get('make', 'string');
            echo 'Make: '.($make ? $make : 'No Make Chosen').'</br>';
            echo 'Model: '.($model ? $model : 'No Model Chosen').'</br>';
            echo 'Task: '.$this->task.'</br>';
            $this->taskMap['display'] = null;
            $this->taskMap['__default'] = null;
            
            
    }

    public function getPrice() {
        $product = $this->app->request->get('product', 'array', array());
        $product = $this->app->product->create($product);
        $this->app->document->setMimeEncoding('application/json');
        $price = array(
            'price' =>  $product->getPrice(),
            'product' => $product->toJson()
        );
        echo json_encode($price);
    }





}

/*
    Class: StoreControllerException
*/
class StoreControllerException extends AppException {}