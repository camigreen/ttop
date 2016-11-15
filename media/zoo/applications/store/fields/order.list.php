<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// Get Variables
$product = $parent->getValue('product');
$fieldtype = $node->attributes()->option ? ' item-option' : '';
$xml = simplexml_load_file($this->app->path->path('fields:/'.$product->type.'/config.xml'));
$optionData = array(
	'name' => (string) $node->attributes()->name,
	'label' => (string) $node->attributes()->label,
	'type' => (string) $node->attributes()->option
);

$fieldOptions = (string) $node->attributes()->options ? (string) $node->attributes()->options : $name;

$opt = $product->getOption($fieldOptions);
if($opt) {
	$isPrice = $opt->isPriceOption();
	$value = $opt->getValue($value);
}
foreach ($xml->field as $field) {
	if((string) $field->attributes()->name == $fieldOptions) {
		$optionData['visible'] = (string) $field->attributes()->visible == 'true' ? true : false;
		$options['0'] = '- SELECT -'; 
		foreach($field->option as $option) {
			$options[(string) $option->attributes()->value] = (string) $option;
		}
	}
}
// Set Attributes
$attributes['id'] = $id;
$attributes['name'] = $name;
$class = 'uk-width-1-1 item-option';
$class .= $fieldtype;
$class .= $required ? ' required' : '';

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
	if ($key === $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option));
}

printf('</select>');

?>