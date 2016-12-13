<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */


$boats = $this->app->boat->getBoatMakes();
$options = array();
$options[] = '- Select -';

foreach($boats as $boat) {
	$options[$boat->name] = $boat->label;
}

printf('<select %s>', $this->app->field->attributes(compact('name', 'class')));

foreach ($options as $key => $option) {

	// set attributes
	$attributes = array('value' => $key);

	// is checked ?
	if ($key == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option));
}

printf('</select>');