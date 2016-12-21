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
		if($data instanceof Product) {
			return $data;
		}
		        
		if($data instanceof Item) {
			$data = $this->loadFromZoo($data);
		} else {
			$data = $this->app->data->create($data);
		}
		$type = $data->get('type');
		$class = $type.'Product';
		if(file_exists($this->app->path->path('library.product:classes/products/'.$type.'.php'))) {
			$this->app->loader->register($class, 'library.product:classes/products/'.$type.'.php');
		} else {
			$class = 'Product';
		}
		$product = new $class($this->app, $data);

		// trigger the init event
        $this->app->event->dispatcher->notify($this->app->event->create($product, 'product:init'));
		return $product;
	}

	public function loadFromZoo($data) {
		$item = $this->app->data->create();
		$item->set('name', $data->name);
		if($data->type == 'ttopboatcover') {
			$item->set('type', 'ttbc');
			foreach($data->getElementsByType('itemoptions') as $option) {
				if($option->config->get('field_name') == 'boat_length') {
					$opt = array('boat_length' => array('value' => $option->get('option')));
					$item->set('options', $opt);
				}
			}
			$data->params->set('make', $data->getPrimaryCategory()->name);
        	$data->params->set('model', $data->name);
		} else if($data->type == 'boat-shade-kit') {
			$item->set('type', 'bsk');
		} else if ($data->type == 'ultimate-boat-shade') {
			$item->set('type', 'ubsk');
		} else if ($data->type == 'ccbc-shelved') {
			$item->set('type', 'ccbcoverstock');
			$item->set('productName', 'Center Console Boat Cover');
			$options = array();
			foreach($data->getElements() as $key => $element) {
				if($element->getElementType() == 'optionselect') {
					if($key == 'fabric') {
						$options[$key] = array('value' => $element->get('option')[0]);
					} else {
						$options[$key] = array('value' => strtoupper($element->get('option')[0]));
					}
					
				}
				$item->set('options', $options);
				switch ($element->config->get('name')) {
					case 'Qty':
						$item->qty = $element->get('value');
						break;
					case 'Make / Model':
						$data->params->set('boat.manufacturer', $element->get('make'));
						$data->params->set('boat.model', $element->get('model'));
						break;
					case 'Boat Model':
						$data->params->set('model', $element->get('value'));
						break;
				}

			}
			$item->name = $data->getPrimaryCategory()->name;
			$data->params->set('category', 'ccbc');
			$data->params->set('priceType', 'ccbc');
			$data->params->set('optionType', 'ccbc');
			$data->params->set('inventory', true);
			$data->params->set('zoo_id', $data->id);
			$data->params->set('zoo_type', $data->type);
			$data->params->set('link', $this->app->route->item($data));
			$data->params->set('discount', 0.3);
		} else if ($data->type == 'ttbc-shelved') {
			$item->set('type', 'ttbcoverstock');
			$item->set('productName', 'T-Top Boat Cover');
			$options = array();
			foreach($data->getElements() as $key => $element) {
				if($element->getElementType() == 'optionselect') {
					if($key == 'fabric') {
						$options[$key] = array('value' => $element->get('option')[0]);
					} else {
						$options[$key] = array('value' => strtoupper($element->get('option')[0]));
					}
					
				}
				$item->set('options', $options);
				switch ($element->config->get('name')) {
					case 'Qty':
						$item->qty = $element->get('value');
						break;
				}

			}
			$item->name = $data->getPrimaryCategory()->name;
			$data->params->set('category', 'ttbc');
			$data->params->set('priceType', 'ttbc');
			$data->params->set('optionType', 'ttbc');
			$data->params->set('inventory', true);
			$data->params->set('zoo_id', $data->id);
			$data->params->set('zoo_type', $data->type);
			$data->params->set('link', $this->app->route->item($data));
			$data->params->set('discount', 0.3);
		} else {
			$item->set('type', $data->type);
		}
		$item->set('id', $data->id);
		$item->set('params', $data->params);

        list($make) = $data->getRelatedCategories();
        $attributes['oem'] = $this->app->data->create();
        $attributes['oem']->set('name', $make->name);
        $attributes['oem']->set('value', $make->id);
        $item->params->set('alias', $data->alias);
		return $item;
	}

	public function loadXML($type) { 
		$xml = simplexml_load_file($this->app->path->path('library.product:products/'.$type.'.xml'));
		$products = array();
		foreach($xml->product as $product) {
			var_dump($this->app->data->create(get_object_vars($product)));

		}
	}
}

?>