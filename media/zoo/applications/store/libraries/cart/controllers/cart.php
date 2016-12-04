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
class CartController extends AppController {

    
    public function __construct($default = array()) {
        parent::__construct($default);

        // get application
        $this->application = $this->app->zoo->getApplication();

        $this->cart = $this->app->cart;

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

    public function add() {
        $stuff = array();
        $products = $this->app->request->get('items', 'array', array());
        foreach($products as $product) {
            $product = $this->app->product->create($product);
            $hash = $product->getHash();
            $stuff[$hash] = $product;
        }

        $this->cart->add($stuff);
        
        $this->output();

    }

    public function updateQty() {
        $hash = $this->app->request->get('hash','string');
        $qty = $this->app->request->get('qty','int');
        $this->cart->updateQty($hash, $qty);
        $this->output();
    }

    public function clear() {
        $this->cart->clear();
        $this->output();
    }

    public function load() {
        $this->output();
    }

    public function remove() {
        $hash = $this->app->request->get('hash','string');
        $this->cart->remove($hash);
        $this->output();
    }

    public function output() {
        $this->app->document->setMimeEncoding('application/json');
        $arr = array();
        foreach ($this->cart->getAll() as $item) {
            $arr[] = get_class($item);
        }
        $result = array(
            'result' => true,
            'items' => $arr,
            'total' => $this->cart->getTotal(),
            'count' => $this->cart->getItemCount(),
            'render' => $this->cart->render()
        );
        echo json_encode($result);
    }

}

/*
    Class: StoreControllerException
*/
class StoreControllerException extends AppException {}