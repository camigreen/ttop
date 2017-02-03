<?php 
/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class TestAPI extends API {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function init() {
		return 'Test API Initialized';
	}

	public function cart() {
        $items = $this->app->cart->getAll();
        $cart = array(
            'items' =>  $items
        );
        return $cart;
	}

	public function price() {
		$product = array(
            'type' => 'ccbc',
            'params' => array(
                'boat.manufacturer' => 'pathfinder',
                'boat.model' => '2200-TRS'
            ),
            'options' => array(
            	'trolling_motor' => array(
            		'value' => 'Y'
            	)
            )
        );
        $product = $this->app->product->create($product);
        var_dump($product->debug());
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
    public function merchant(&$params = array()) {
        $oid = $params['args']['oid'];
        $order = $this->app->orderdev->get($oid);
        $merchant = $this->app->merchant;
        return $merchant->prepareOrder($order);
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
    public function address(&$params = array()) {
        $address = $params['args']['address'];
        $shipper = $this->app->shipper;

        $address = $shipper->createAddress($address);
        $valid = $shipper->validateAddress($address);
        $rates = $shipper->getRates();

        return $valid;

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
    public function closeOrder(&$params = array()) {
        $oid = $params['args']['oid'];
        $order = $this->app->orderdev->get($oid);
            $order->params->set('payment.status', 3);
            $order->params->set('payment.type', 'CC');
            $order->params->set('payment.approved', true);
            $order->save(true);
        
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
    public function shipRates(&$params = array()) {
        $oid = $params['args']['oid'];
        $shipper = $this->app->shipper;
        $order = $this->app->orderdev->get($oid);
        $service = $order->elements->get('shipping_method');
        $result = array();

        $shipRates = $shipper->getRates($order);
        $rates = array();
        foreach($shipRates as $shippingMethod) {
            if($shippingMethod->getService()->getCode() == $service) {
                $rates[$service] = $shippingMethod->getTotalCharges();
            }
        }
        $result['rates'] = $rates;
        return $result;
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
    public function convertOrderItemIDtoHash() {
        $orders = $this->app->table->orderdev->all();
        $results = array();
        foreach($orders as $order) {
            
            $items = $order->getItems();
            $order->elements->remove('items.');
            foreach($items as $item) {
                $order->elements->set('items.'.$item->getHash(), $item);
            }
            $order->save();
            $results[] = $order->id;
        }
        return $results;

        
    }

    /**
     * Describe the Function
     *
     * @param   datatype        Description of the parameter.
     *
     * @return  datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function quickbooks(&$params = array()) {
        $params['args']['output'] = false;
        $params['args']['encoding'] = 'text/xml';

        $this->app->quickbooks->start();
        return;
    }

    public function qbqueue() {
        $id = 1;
        $Queue = $this->app->quickbooks->queue();
        $Queue->enqueue(QUICKBOOKS_IMPORT_INVENTORYASSEMBLYITEM, $id);
    }

    public function qbmod(&$params = array()) {
        $table = $this->app->table->get('qb_test', '#__');
        $table->key = 'listid';
        $item = $table->first(array('conditions' => array("listid = '".$params['args']['id']."'")));
        $item->purchasedesc = $params['args']['purchdesc'];
        $item->salesdesc = $params['args']['salesdesc'];
        $item->fullname = $params['args']['fullname'];
        $result = $table->save($item);
        $Queue = $this->app->quickbooks->queue();
        $Queue->enqueue(QUICKBOOKS_MOD_INVENTORYASSEMBLYITEM, $params['args']['id']);
        return $result;
    }

    

	
}

class TestAPIException extends APIException {}

?>