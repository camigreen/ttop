<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

class StoreApplication extends Application {
    
    public function __construct() {
        parent::__construct();

        $zoo = App::getInstance('zoo');

        // Set defines

        JFactory::getLanguage()->load('' , dirname(__FILE__));

        
//        Register Paths
        $path = dirname(__FILE__);
        $zoo->path->register($path.'/elements', 'elements');
        $zoo->path->register($path.'/assets', 'assets');
        $zoo->path->register($path.'/controllers', 'controllers');
        $zoo->path->register($path.'/prices', 'prices');
        $zoo->path->register($path.'/classes', 'classes');
        $zoo->path->register($path.'/helpers', 'helpers');
        $zoo->path->register($path.'/merchant', 'merchant');
        $zoo->path->register($path.'/site', 'component.site');
        $zoo->path->register($path.'/pdf', 'pdf');
        $zoo->path->register($path.'/tables', 'tables');
        $zoo->path->register($path.'/classes/data', 'data');
        $zoo->path->register($path.'/events', 'events');
        $zoo->path->register($path.'/notifications', 'notifications');
        $zoo->path->register($path.'/fields', 'fields');
        $zoo->path->register($path.'/libraries', 'store.lib');
        $zoo->path->register($path.'/logs', 'logs');
        $zoo->path->register($path.'/views', 'views');
        $zoo->path->register($path.'/apis', 'apis');
        $zoo->path->register(JPATH_ROOT.'/templates/yoo_eat', 'template');
        $zoo->path->register(JPATH_ROOT.'/images/logos', 'images.logos');
        $zoo->path->register(JPATH_ROOT.'/images/boats', 'images.boats');
        include_once $path.'/vendor/autoload.php';

        // Load libraries
        $libraries = array('product', 'modal', 'price', 'cart', 'api');
        foreach($libraries as $library) {
            include_once $zoo->path->path('store.lib:/'.$library.'/config.php');
        }

//        Load Classes
        $zoo->loader->register('ElementStore','elements:element/element.php');
        $zoo->loader->register('ElementStore','elements:elementstore/elementstore.php');
        $zoo->user->get();

        // register and connect events
        $zoo->event->register('OrderEvent');
        $zoo->event->dispatcher->connect('order:paymentFailed', array('OrderEvent', 'paymentFailed'));
        $zoo->event->dispatcher->connect('order:init', array('OrderEvent', 'init'));
        $zoo->event->register('AccountEvent');
        $zoo->event->dispatcher->connect('account:init', array('AccountEvent', 'init'));
        $zoo->event->register('StoreUserEvent');
        $zoo->event->dispatcher->connect('storeuser:init', array('StoreUserEvent', 'init'));
        $zoo->event->dispatcher->connect('storeuser:saved', array('StoreUserEvent', 'saved'));
        $zoo->event->register('StoreItemEvent');
        $zoo->event->dispatcher->connect('storeitem:init', array('StoreItemEvent', 'init'));
        $zoo->event->register('CouponEvent');
        $zoo->event->dispatcher->connect('coupon:init', array('CouponEvent', 'init'));
//        Add CSS
        $zoo->document->addStyleSheet('assets:css/ttop.css');

        
//        Add Scripts
        

        
    }


}