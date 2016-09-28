<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// Get Variables
$fieldtype = $node->attributes()->fieldtype ? (string) $node->attributes()->fieldtype : 'option';
$xml = simplexml_load_file($this->app->path->path('fields:config.xml'));

foreach ($xml->field as $field) {
	if((string) $field->attributes()->name == $name) {
		$options['0'] = '- SELECT -'; 
		foreach($field->option as $option) {
			$options[(string) $option->attributes()->value] = (string) $option;
		}
	}
}
// Set Attributes
$attributes['id'] = $id;
$attributes['name'] = "{$control_name}[{$name}]";
$class = 'uk-width-1-1';
$class .= ' item-'.$fieldtype;

if(!isset($options)) {
	echo 'Error - No Options Available.';
	return;
}

$attributes['class'] = $class;

$disabled = $disabled ? $disabled : !$user->canEdit($assetName);
if($disabled) {
	$attributes['disabled'] = true;
}

printf('<select %s>', $this->app->field->attributes($attributes));

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

?>