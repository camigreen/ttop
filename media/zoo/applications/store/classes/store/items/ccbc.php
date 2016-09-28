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
class ccbcStoreItem extends StoreItem {

    public $type = "ccbc";

    public $make = 'LaPorte\'s Products, Inc.';
   	
    public function importItem($item = null) {
        parent::importItem($item);   
    }
    

}
