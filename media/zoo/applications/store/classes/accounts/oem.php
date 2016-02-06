<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn Gibbons
 */
class OEMAccount extends Account {

    public $type = 'oem';

    /**
     * Get an OEM account
     *
     * @return OEMAccount  Returns an OEM Account object.
     *
     * @since 1.0
     */
    public function getOEM($id) {

        return parent::getChild($id);
    }

    /**
     * Get all OEM accounts
     *
     * @return array  Returns an array of OEM Account objects.
     *
     * @since 1.0
     */
    public function getAllOEMs() {

        if($this->id) {
            $this->_loadMappedAccounts();
        }

        $oems = array();

        foreach($this->_mappedAccounts->get('children.') as $child) {
            if($child->type = 'oem') {
                $oems[$child->id] = $child;
            }
        }

        return $oems;
    }

    public function getOEMCategories($id) {
        $oems = $this->getOEMs();
        $categories = array();
        foreach($oems as $oem) {
            $categories[] = $oem->elements->get('category');
        }
        return $categories;
    }

}