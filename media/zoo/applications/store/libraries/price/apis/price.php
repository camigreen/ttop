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
class PriceAPI extends API {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function init() {
		return 'Price API Initialized';
	}

	public function getPrice(&$params = array()) {
        $product = $this->app->product->create($params['args']['product']);
        $price = array(
            'price' =>  $product->getTotalPrice($name),
            'product' => $product->toJson(),
            'rule' => $product->getPriceRule()
        );
        return $price;
	}

	
}

class PriceAPIException extends APIException {}

?>