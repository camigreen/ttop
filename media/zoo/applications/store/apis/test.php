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

	
}

class TestAPIException extends APIException {}

?>