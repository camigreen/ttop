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
        

    }

    public function create($item, $resource = null) {
        $this->app->loader->register('Price','classes:price.php');
        // if(!isset($this->_prices[$item->sku])) {
        //     $this->_prices[$item->sku] = new Price($this->app, $item, $resource);
        // }
        // var_dump($this->_prices);
        // return $this->_prices[$item->sku];
        return new Price($this->app, $item, $resource);
    }

    public function createdev($product) {
        $this->app->loader->register('Price','classes:pricedev.php');
        if($this->app->customer->isReseller()) {
            $class = 'ResellerPrice';
            $this->app->loader->register('ResellerPrice','classes:reseller.php');
        } else {
            $class = 'Price';
        }
        $data = array();
        $data['path.rules.item'] = $this->app->path->path('rules:'.$product->type.'.php');
        $data['path.rules.global'] = $this->app->path->path('rules:global.php');
        $data['product.type'] = $product->type;
        $data['rule'] = $product->getPriceRule();
        $options = array_merge(array(), $product->options->getByType('price', array())->getArrayCopy(), $product->options->getByType('price.adj', array())->getArrayCopy());
        $data['options.product'] = $options;
        $price = new $class($this->app, $data);
        return $price;
    }

}