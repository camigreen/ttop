<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


/*
	Class: ElementSelect
		The select element class
*/
class ElementPrice extends ElementStore {
    
        public function __construct() {
            parent::__construct();
        }

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit() {
                return false;
	}
        
    public function render($params = array())
    {
        $account = $this->app->storeuser->get()->getAccount();
        $layout = str_replace('user.','',$account->type);
        $allowMarkups = $params['item']->allowMarkups();
        if(file_exists($this->app->path->path('elements:price/tmpl/reseller.php')) && $this->app->storeuser->get()->isReseller() && $allowMarkups) {
            return $this->renderLayout($this->app->path->path('elements:price/tmpl/reseller.php'), compact('params'));
        } else {
            return $this->renderLayout($this->app->path->path('elements:price/tmpl/default.php'), compact('params'));
        }
        

    }
    
    public function hasValue($params = array())
    {
        return true;
    }

}