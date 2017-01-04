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
    public function merchant($oid) {
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
    public function address($address) {
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
    public function shipRates($oid) {

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

	
}

class TestAPIException extends APIException {}

?>