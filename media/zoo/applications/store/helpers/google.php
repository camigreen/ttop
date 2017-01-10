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
class GoogleHelper extends AppHelper {

    public function __construct($app) {
        parent::__construct($app);
    }

    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function ecommerce($oid) {

        $order = $this->app->orderdev->get($oid);

        $transaction = array();
        $transaction['id'] = $order->id;
        $transaction['affiliation'] = 'T-Top Boat Covers';
        $transaction['revenue'] = $order->getTotal('charge');
        $transaction['shipping'] = $order->getShippingTotal();
        $transaction['tax'] = $order->getTaxTotal();
        $transaction['currency'] = 'USD';
        $items = array();
        foreach($order->getItems() as $sku => $item) {
            $itm = array();
            $itm['id'] = $order->id;
            $itm['name'] = $item->name;
            $itm['sku'] = $sku;
            $itm['category'] = $item->type;
            $itm['quantity'] = $item->getQty();
            $itm['price'] = $item->price->get('charge');
            $items[] = $itm;
        }

        $google = array('transaction' => json_encode($transaction), 'items' => json_encode($items));

        $renderer = $this->app->renderer->create();
        $renderer->addPath($this->app->path->path('library.product:'));
        return $renderer->render('google.ecommerce', array('google' => $google));
    }
}