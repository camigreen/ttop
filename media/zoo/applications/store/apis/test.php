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

	
}

class TestAPIException extends APIException {}

?>