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
class ProductAPI extends API {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function init() {
		return 'Product API Initialized';
	}

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function subtract(&$params = array()) {
		$item = $this->app->table->item->get($params['id']);

		$qty = $item->getElement('ccbc-qty')->get('value');
		$qty = $qty - $params['num'];

		$item->getElement('ccbc-qty')->set('value', $qty);

		$this->app->table->item->save($item);

		return true;
		
	}
	
}

class ProductAPIException extends APIException {}

?>