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
class CCBCProduct extends Product {

	public $type = 'ccbc';

	public function bind($product) {
		$this->id = 'ccbc';
		$this->name = 'Center Console Boat Cover';
		
		$data = $this->app->parameter->create();
		$data->set('name', 'style');
		$data->set('value', 'CC');
		$data->set('label', 'Style');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', 'Center Console');
		$this->setOption('style', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'motors');
		$data->set('value', 'S');
		$data->set('label', 'Motors');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', 'Single Engine');
		$this->setOption('motors', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'bow_rails');
		$data->set('value', 'L');
		$data->set('label', 'Bow Rails');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', 'Low Rails');
		$this->setOption('bow_rails', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'trolling_motor');
		$data->set('value', 'y');
		$data->set('label', 'Trolling Motor');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('priced', true);
		$data->set('text', 'Yes');
		$this->setOption('trolling_motor', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'jack_plate');
		$data->set('value', 'JP4');
		$data->set('label', 'Jack Plate');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', '4 inch');
		$this->setOption('jack_plate', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'poling_platform');
		$data->set('value', 'PO41');
		$data->set('label', 'Poling Platform');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', '41 inch');
		$this->setOption('poling_platform', $data);

		$data = $this->app->parameter->create();
		$data->set('name', 'year');
		$data->set('value', '2015');
		$data->set('label', 'Year');
		$data->set('visible', true);
		$data->set('type', 'variable');
		$data->set('text', '2015');
		$this->setOption('year', $data);

		return parent::bind($product);
	}
}