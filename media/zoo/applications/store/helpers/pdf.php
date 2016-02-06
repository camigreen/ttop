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
class PDFHelper extends AppHelper {
    //put your code here
    
    
    public function __construct($app) {
        parent::__construct($app);
        $this->_path = $this->app->object->create('PathHelper', array($app));
        // load class
        $this->app->loader->register('FPDF', 'classes:fpdf/fpdf.php');
        $this->app->loader->register('GridPDF', 'classes:fpdf/scripts/grid.php');
        $this->app->loader->register('FormPDF', 'classes:fpdf/scripts/form.php');
                
    }

    public function create($form, $type = 'default') {

        
        if (file_exists($this->app->path->path('classes:fpdf/scripts/'.$type.'/'.$form.'.xml')) && file_exists($this->app->path->path('classes:fpdf/scripts/'.$type.'/'.$form.'.xml'))) {
            $class = $form.'FormPDF';
            $this->app->loader->register($class, 'classes:fpdf/scripts/'.$type.'/'.$form.'.php');
        } else {
            $class = 'FormFPDF';
        }


        
        $object = new $class();

        $object->app = $this->app;
        
        return $object;
    }
    
    public function __get($name) {
        return $this->create($name);
    }
        
        

}
