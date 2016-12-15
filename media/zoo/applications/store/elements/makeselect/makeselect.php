<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// register ElementOption class
$zoo = App::getInstance('zoo');
$zoo->loader->register('ElementOption', 'elements:option/option.php');
$media_path = JPATH_ROOT.'/media/zoo';
$zoo->path->register($media_path.'/applications/store', 'store');
$zoo->path->register($media_path.'/applications/store/libraries', 'store.lib');
include_once $zoo->path->path('store.lib:/product/config.php');

/*
	Class: ElementSelect
		The select element class
*/
class ElementMakeSelect extends Element {

	/*
	   Function: edit
	       Renders the edit form field.

	   Returns:
	       String - html
	*/
	public function edit(){

		$makes = $this->app->boat->getBoatMakes();
		$opts = array();
        $name = $this->config->get('name');
		$default = $this->get('default');
		$values['make'] = $this->get('make');
		$values['model'] = $this->get('model');
		foreach($makes as $make) {
			$opts[] = array(
				'name' => $make->get('label'),
				'value' => $make->get('name')
				);
		}

		// set default, if item is new
		if ($default != '' && $this->_item != null && $this->_item->id == 0) {
			$this->set('option', $default);
		}

		$options['make'] = array();
		$options['model'] = array();

		if(!$default) {
			$options['make'][] = '<option value="">- Select Boat Make -</option>';
		}

        foreach ($opts as $option) {
			$options['make'][] = '<option value="'.$option['value'].'" '.($values['make'] == $option['value'] ? 'selected' : '').'>'.$option['name'].'</option>';
		}

		if($values['make']) {
			$disabled = false;
			$options['model'][] = '<option value="">- Select Boat Model -</option>';
			$make = $this->app->boat->getBoatMake($values['make']);
        	$models = $make->get('models');
        	foreach($models as $model) {
        		$options['model'][] = '<option value="'.$model->get('name').'" '.($values['model'] == $model->get('name') ? 'selected' : '').'>'.$model->get('label').'</option>';
        	}
		} else {
			$disabled = true;
			$options['model'][] = '<option value="">- Select Boat Make First -</option>';
		}

		
		$html = $this->renderLayout($this->app->path->path('elements:makeselect/tmpl/default.php'), compact('name','options','params', 'disabled'));
		return $html;
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
	public function hasValue($params = array()) {
		return ($this->get('make') && $this->get('model'));
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
	public function render($params = array()) {
		$boat = $this->app->boat->create($this->get('make'), $this->get('model'));
		return $boat->get('label').' '.$boat->getModel()->get('label');
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
	public function getSearchData() {
		return $this->get('make');
	}

}