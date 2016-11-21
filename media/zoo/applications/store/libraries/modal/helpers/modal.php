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
        $this->xml = simplexml_load_file($this->app->path->path('library.modal:/fields/modals/'.$config->get('type').'/modals.xml'));
        
        $name = $config->get('name');
        $type = $config->get('type', 'default');
        if(!$node = $this->getNode($name)) {
            return 'Error loading modal from XML';
        }

        $title = $node->attributes()->title ? (string) $node->attributes()->title : null;
        $subtitle = $node->attributes()->subtitle ? (string) $node->attributes()->subtitle : null;
        $scroll = $this->getBool($node->attributes()->scroll);
        $scrolltext = $node->attributes()->scrolltext ? (string) $node->attributes()->scrolltext : 'Scroll down for more info.';
        $layout = (string) $node->attributes()->layout;
        $file = 'fields:/modals/'.$type.'/'.$layout.'.php';
        $save = $node->attributes()->save ? (string) $node->attributes()->save : null;
        $cancel = $node->attributes()->cancel ? (string) $node->attributes()->cancel : 'Ok';
        $html[] = '<div class="uk-modal-header uk-text-center">';
        if($title) {
            $html[] = '<div class="modal-title">';
            $html[] = '<span class="uk-article-title">'.$title.'</span>';
            $html[] = '</div>';
        }
        if($subtitle) {
            $html[] = '<div class="modal-subtitle">';
            $html[] = '<span class="uk-article-lead">'.$subtitle.'</span>';
            $html[] = '</div>';
        }
        if($scroll) {
            $html[] = '<div class="modal-scroll-title">';
            $html[] = '<span class="uk-text-small">'.$scrolltext.'<i class="uk-icon uk-icon-arrow-down" style="margin-left:5px;"></i></span>';
            $html[] = '</div>';
        }
        $html[] = '</div>';
        $html[] = '<div class="modal-content'.($scroll ? ' uk-overflow-container' : '').'">';

        if(file_exists($this->app->path->path($file))) {
            $html[] = $this->app->field->render('modals/'.$config->get('type','default').'/'.$layout, $config, $config->get('value'), $node, array('save' => $save, 'cancel' => $cancel, 'config' => $config)); 
        } else {
            $html[] = 'Modal layout '.$layout.' not found!';
        }

        $html[] = '</div>';

        $html[] = '<div class="uk-modal-footer uk-text-right">';
        $html[] = '<ul class="uk-grid" data-uk-grid-margin>';
        if($save) {
            $html[] = '<li class="uk-width-1-4 uk-push-2-4">';
            $html[] = "<button class=\"modal-save uk-button uk-button-primary uk-width-1-1\" >".$save."</button>";
            $html[] = '</li>';
        }
        $html[] = '<li class="uk-width-1-4'.($save ? " uk-push-2-4" : " uk-push-3-4").'">';
        $html[] = "<button class=\"modal-cancel uk-button uk-width-1-1\" >".$cancel."</button>";
        $html[] = '</li>';
        $html[] = '</ul>';
        $html[] = '</div>';

        return sprintf('<div id="'.$config->get('type').'-'.$config->get('name').'-modal" class="uk-modal ttop" data-config=\''.json_encode($config).'\'><div class="uk-modal-dialog"> <div class="contents">%s</div></div></div>', implode('',$html));


        
    }

    protected function getNode($name) {
        foreach($this->xml->modal as $modal) {
            if((string) $modal->attributes()->name == $name) {
                return $modal;
            }
        }
    }
        
        

}
