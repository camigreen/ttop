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
class ProductController extends AppController {

    
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

        
        $this->type = $this->app->request->get('product', 'string');
        $this->process = $this->app->request->get('process', 'string');

        $this->xml['config'] = simplexml_load_file($this->getLayoutPath().'/'.$this->type.'/config.xml');
        $this->xml['items'] = simplexml_load_file($this->app->path->path('library.product:/items.xml'));
        $this->url = '/store/'.$this->process.'/'.$this->type.'/';
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

    public function chooseBoatManufacturer() {
        $product = $this->app->request->get('product', 'string');
        $layout = 'manufacturers';
        $this->boats = $this->getManufacturers();   
        // switch($task) {
        //     case 'manufacturers':
                
        //     case 'models':
        //         $layout = 'models';
        //         $manufacturer = $this->app->request->get('m', 'string');
        //         $this->manufacturer = $this->getBoat($manufacturer);
        //         break;
        //     case 'orderform':
        //         $layout = 'full';
        //         $values = array();
        //         $values['year.start'] = $this->item->models->get('24')->params->get('years.start');
        //         $values['year.end'] = $this->item->models->get('24')->params->get('years.end');
        //         $xml = $this->xml['config']; 
        //         $this->form = $this->app->form->create(array($xml->form, compact('layout')));
        //         $this->form->setAsset((string) $xml->assetName);
        //         $this->form->setValues($values);
        //         //$this->item = $this->getBoat($manufacturer);
        //         break;
        // }
        
        $this->getView()->addTemplatePath($this->getLayoutPath().'/'.$this->type);
        $this->getView()->setLayout($layout)->display();
    }

    public function chooseBoatModel() {
        $layout = 'models';
        $manufacturer = $this->app->request->get('make', 'string');
        $this->url;
        $this->manufacturer = $this->getManufacturer($manufacturer);
        $this->getView()->addTemplatePath($this->getLayoutPath().'/'.$this->type);
        $this->getView()->setLayout($layout)->display();
    }

    public function orderForm() {
        $manufacturer = $this->app->request->get('make', 'string');
        $model = $this->app->request->get('model', 'string');
        $product = array(
            'type' => $this->type,
            'params' => array(
                'boat.manufacturer' => $manufacturer,
                'boat.model' => $model
            )
        );
        $this->product = $this->app->product->create($product);
        $layout = 'full';
        $values = array();
        $values['product'] = $this->product;
        $xml = $this->xml['config']; 
        $this->form = $this->app->orderform->create(array($xml->form, compact('layout')));
        $this->form->setAsset((string) $xml->assetName);
        $this->form->setValues($values);
        
        $this->getView()->addTemplatePath($this->getLayoutPath().'/'.$this->product->type);
        $this->getView()->setLayout($layout)->display();
    }

    public function getLayoutPath() {
        return $this->app->path->path('library.product:/layouts');
    }

    protected function getManufacturer($make) {
        $xml = $this->xml['items'];
        $make = str_replace('_', '-', $make);
        $boat = $this->app->data->create();
        foreach($xml->boats->boat as $item) {
            if($item->name != $make) {
                continue;
            }
            $params = $this->app->parameter->create();
            foreach($item as $key => $value) {
                if($key == 'models') {
                    $boat->set('models', $this->getModels($item));
                } else if($key == 'name') {
                    $name = (string) str_replace('-', '_', $value);
                    $boat->set($key, (string) $value);
                } else {
                    $boat->set($key, (string) $value);
                }
            }
            foreach($item->attributes() as $param => $value) {
                $params->set($param, (string) $value);
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'))) {
                $params->set('images.thumb', $this->app->path->url('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'));
            } else {
                $params->set('images.thumb', $this->app->path->url('images.boats:/PNA/thumbs/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/'.$name.'.png'))) {
                $params->set('images.full', $this->app->path->url('images.boats:/'.$name.'/ccbc/'.$name.'.png'));
            } else {
                $params->set('images.full', $this->app->path->url('images.boats:/PNA/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.logos:/'.$name.'.png'))) {
                $params->set('images.logo', $this->app->path->url('images.logos:/'.$name.'.png'));
            }
            $boat->set('params', $params);
        }
        
        return $boat;

    }

    protected function getManufacturers() {
        $xml = $this->xml['items'];
        $boats = $this->app->data->create();
        foreach($xml->boats->boat as $item) {
            if(!$this->app->xml->getBool($item->attributes()->published) || $item->name == '') {
                continue;
            }

            $boat = $this->app->data->create();
            $params = $this->app->parameter->create();
            foreach($item as $key => $value) {
                if($key == 'models') {
                    $boat->set('models', $this->getModels($item));
                } else if($key == 'name') {
                    $name = (string) str_replace('-', '_', $value);
                    $boat->set($key, (string) $value);
                } else {
                    $boat->set($key, (string) $value);
                }
            }
            foreach($item->attributes() as $param => $value) {
                $params->set($param, (string) $value);
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'))) {
                $params->set('images.thumb', $this->app->path->url('images.boats:/'.$name.'/ccbc/thumbs/'.$name.'.png'));
            } else {
                $params->set('images.thumb', $this->app->path->url('images.boats:/PNA/thumbs/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.boats:/'.$name.'/ccbc/'.$name.'.png'))) {
                $params->set('images.full', $this->app->path->url('images.boats:/'.$name.'/ccbc/'.$name.'.png'));
            } else {
                $params->set('images.full', $this->app->path->url('images.boats:/PNA/PNA.png'));
            }
            if(file_exists($this->app->path->path('images.logos:/'.$name.'.png'))) {
                $params->set('images.logo', $this->app->path->url('images.logos:/'.$name.'.png'));
            }
            $boat->set('params', $params);
            $boats->set($name, $boat);
        }
        
        return $boats;

    }

    protected function getModels($xml = null) {

        if($xml) {
            $models = $this->app->data->create();
            foreach($xml->models->model as $xModel) {
                $model = $this->app->data->create();
                foreach($xModel as $key => $value) {
                    if($key == 'name') {
                        $name = (string) $value;
                    }
                    $model->set($key, (string) $value);
                }
                $params = $this->app->parameter->create();
                foreach($xModel->attributes() as $param => $value) {
                    $params->set($key, (string) $value);
                }
                $model->set('params', $params);
                $models->set($name, $model);

            }
            return $models;
        }

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
class StoreControllerException extends AppException {}