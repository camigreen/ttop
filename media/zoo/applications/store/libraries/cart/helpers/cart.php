<?php defined('_JEXEC') or die('Restricted access');

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
class CartHelper extends AppHelper {

	protected $_storage;

	public function __construct($app) {
		parent::__construct($app);
		
		$this->init();
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
	public function init() {
		$cart = $this->app->session->get('cart',array(),'checkout');
		if($cart) {
			var_dump('Cart Exists');
			$this->_storage = $this->app->data->create($cart['storage']);
		} else {
			var_dump('New Cart');
			$this->_storage = $this->app->data->create($this->_storage);
		}
		foreach($this->_storage as $hash => $product) {
			$product = $this->app->product->create($product);
		}
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
	public function add($product) {
		$hash = $product->getHash();
		if($this->exists($hash)) {
			$this->_storage->get($hash)->qty += 1;
		} else {
			$this->_storage->set($hash, $product);
		}
		$this->updateSession();
		
		//var_dump($this->_storage->get($hash));
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
	public function updateSession() {
		$this->app->session->clear('cart', 'checkout');
		foreach($this->_storage as $hash => $product) {
			$data[$hash] = $product->toJson();
		}
		var_dump($data);
		$this->app->session->set('cart',json_encode($data),'checkout');

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
	public function exists($hash) {
		if($this->_storage->get($hash)) {
			return true;
		}
		
		return;
		
	}


}

?>