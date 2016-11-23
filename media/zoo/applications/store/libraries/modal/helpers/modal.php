<?php

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
class ModalHelper extends AppHelper {
    //put your code here
    
    
    public function __construct($app) {
        parent::__construct($app);
                
    }

    public function getBool($value) {
        switch((string) $value) {
            case 'true':
                return true;
                break;
            case 'false':
            default:
                return false;
        }

    }

    public function create($config) {
        $config = $this->app->data->create($config);
        $this->xml = simplexml_load_file($this->app->path->path('library.modal:/renderer/'.$config->get('type').'/modals.xml'));
        
        $name = $config->get('name');
        $type = $config->get('type', 'default');
        if(!$node = $this->getNode($name)) {
            return 'Error loading modal from XML';
        }
        $data['scroll'] = $this->getBool($node->attributes()->scroll);
        $data['scrolltext'] = $node->attributes()->scrolltext ? (string) $node->attributes()->scrolltext : 'Scroll down for more info.';
        $data['subtitle'] = $node->attributes()->subtitle ? (string) $node->attributes()->subtitle : null;
        $data['title'] = $node->attributes()->title ? (string) $node->attributes()->title : null;
        $data['save'] = $node->attributes()->save ? (string) $node->attributes()->save : null;
        $data['cancel'] = $node->attributes()->cancel ? (string) $node->attributes()->cancel : 'Ok';
        $renderer = $this->app->renderer->create();
        $renderer->addPath($this->app->path->path('library.modal:'));
        $content = $renderer->render($type.'.'.$name, array('config' => $config));
        return $renderer->render('modal', array('config' => $config, 'content' => $content, 'data' => $data));

    }

    protected function getNode($name) {
        foreach($this->xml->modal as $modal) {
            if((string) $modal->attributes()->name == $name) {
                return $modal;
            }
        }
    }
        
        

}
