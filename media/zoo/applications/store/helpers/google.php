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

        $gtm = array();

        $gtm['event'] = 'transactionComplete';
        $gtm['ecommerce'] = array();
        $gtm['ecommerce']['purchase'] = array();
        $gtm['ecommerce']['purchase']['actionField'] = array();
        $gtm['ecommerce']['purchase']['actionField']['id'] = $order->id;
        $gtm['ecommerce']['purchase']['actionField']['affiliation'] = "LaPorte's Products, Inc";
        $gtm['ecommerce']['purchase']['actionField']['revenue'] = (float) $order->getTotal('charge');
        $gtm['ecommerce']['purchase']['actionField']['tax'] = (float) $order->getTaxTotal();
        $gtm['ecommerce']['purchase']['actionField']['shipping'] = (float) $order->getShippingTotal();
        $gtm['ecommerce']['purchase']['actionField']['coupon'] = $order->params->get('coupon');
        $gtm['ecommerce']['purchase']['actionField']['dimension1'] = $order->elements->get('referral');
        $gtm['ecommerce']['purchase']['products'] = array();
        foreach($order->getItems() as $sku => $item) {
            $itm = array();
            $itm['id'] = $item->id;
            $itm['name'] = $item->name;
            $itm['price'] = $item->price->get('charge');
            $itm['brand'] = $item->params->get('brand', "LaPorte's Products");
            $itm['category'] = $item->type;
            $itm['quantity'] = (int) $item->getQty();
            $itm['coupon'] = $item->params->get('coupon');
            $itm['variant'] = $item->getOption('fabric');
            $itm['dimension1'] = $item->getOption('color');
            $gtm['ecommerce']['purchase']['products'][] = $itm;
        }

        

        $renderer = $this->app->renderer->create();
        $renderer->addPath($this->app->path->path('library.product:'));
        return $renderer->render('google.ecommerce', array('gtm' => json_encode($gtm)));
    }
}

?>