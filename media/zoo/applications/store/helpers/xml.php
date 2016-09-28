<?php defined('_JEXEC') or die('Restricted access');

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
class XMLHelper extends AppHelper {


    public function getBool($value = null, $default = true) {
        if((string) $value == 'true') {
            return true;
        } else if ($value === null) {
            return $default;
        }

        return false;
    }

}