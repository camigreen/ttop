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
		$this->_storage = $this->app->data->create();
		$this->start();
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
	public function start() {
		$cart = $this->app->session->get('cart', array(), 'checkout');
		if($cart) {
			$cart = $this->app->data->create($cart);
		} else {
			$cart = $this->app->data->create();
		}
		foreach($cart as $hash => $product) {
			$product = $this->app->product->create($product);
			$this->_storage->set($hash, $product);
		}
		$this->updateSession();
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
	public function add($products) {
		foreach($products as $hash => $product) {
			if($cProduct = $this->exists($hash)) {
				$cProduct->increaseQty($product->getQty());
			} else {
				$this->_storage->set($hash, $product);
			}
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
	public function remove($hash) {
		$this->_storage->remove($hash);
		$this->updateSession();
		return $this;
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
	public function get($name) {
		return $this->_storage->get($name);
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
	public function getAll() {
		return $this->_storage;
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
	public function updateQty($hash, $qty) {
		if($qty === 0) {
			$this->remove($hash);
		} else {
			$this->_storage->get($hash)->setQty($qty);
		}

		$this->updateSession();
		
		return $this;
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
		//$this->app->session->clear('cart', 'checkout');
		$data = array();
		foreach($this->_storage as $hash => $product) {
			$data[$hash] = $product->toJson();
		}
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
	public function clear() {
		$this->_storage = $this->app->data->create();
		$this->updateSession();
		return $this;
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
		if($product = $this->_storage->get($hash)) {
			return $product;
		}
		
		return;
		
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
	public function getItemCount() {
		$count = 0;
		foreach($this->getAll() as $item) {
			$count += $item->getQty();
		}
		return $count;
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
	public function isEmpty() {
		return ($this->getItemCount() == 0);
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
	public function getTotal() {
		$total = 0.00;
		foreach($this->getAll() as $item) {
			$total += $item->getTotalPrice();
		}
		return $this->app->number->precision($total, 2);
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
	public function render() {
		$data = array(
			'count' => 0,
			'total' => 0.00,
			'render' => array()
		);
		foreach($this->getAll() as $hash => $item) {
			$i = $item->getCartDetails();
			$data['count'] += $i->get('qty', 0);
			$data['total'] += $i->get('price', 0.00);
			$data['items'][$hash] = $i;
		}
		$layout = $this->app->path->path('library.cart:layouts/cart.php');
		ob_start();
		include($layout);
		$output = ob_get_contents();
		ob_end_clean();

		// set body
		return $output;
		
	}


}

?>