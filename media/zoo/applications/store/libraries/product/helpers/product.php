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
class ProductHelper extends AppHelper {

	/**
	 * @var [array]
	 */
	protected $_products = array();	
	

	public function __construct($app) {
		parent::__construct($app);
		$this->app->loader->register('Product','classes:product.php');
		$this->xml = simplexml_load_file($this->app->path->path('library.product:items.xml'));
	}

	public function create($data = array()) {
		$data = $this->app->data->create($data);
		$type = $data->get('type');
		$class = $type.'Product';
		if(file_exists($this->app->path->path('library.product:classes/products/'.$type.'.php'))) {
			$this->app->loader->register($class, 'library.product:classes/products/'.$type.'.php');
		}

		$product = new $class($this->app);
		$product->bind($data);
		return $product;
	}

	public function loadXML($xml) {

	}
}

?>