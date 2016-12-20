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
class PriceHelper extends AppHelper {

    /**
     * @var [array]
     */
    protected $_prices = array();
    

    public function __construct($app) {
        parent::__construct($app);
        $this->app->loader->register('Price','classes:price.php');

    }

    public function create($product) {
        
        if($this->app->customer->isReseller()) {
            $class = 'ResellerPrice';
            $this->app->loader->register('ResellerPrice','classes:reseller.php');
        } else {
            $class = 'Price';
        }
        $type = $product->getParam('priceType', $product->type);
        $data = array();
        $data['path.rules.item'] = $this->app->path->path('rules:'.$type.'.php');
        $data['path.rules.global'] = $this->app->path->path('rules:global.php');
        $data['product.type'] = $type;
        $data['rule'] = $product->getPriceRule();
        $options = array_merge(array(), $product->options->getByType('price', array())->getArrayCopy(), $product->options->getByType('price.adj', array())->getArrayCopy());
        $data['options.product'] = $options;
        if($product->getParam('tempMarkup') != null)
            $data['tempMarkup'] = $product->getParam('tempMarkup');
        $price = new $class($this->app, $data);
        return $price;
    }

}