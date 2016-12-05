<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// set attributes
$product = $parent->getValue('product');
$start = $parent->getValue('year.start', 2000);
$end = $parent->getValue('year.end', 0);
$fieldtype = $node->attributes()->option ? ' item-option' : '';
$xml = simplexml_load_file($this->app->path->path('fields:options/'.$product->type.'.xml'));
$fieldOptions = (string) $node->attributes()->options ? (string) $node->attributes()->options : $name;
$opt = $product->getOption($fieldOptions);
if($opt) {
	$value = $opt->get('value', $value);
}

foreach ($xml->field as $field) {
	if((string) $field->attributes()->name == $name) {
		$optionData['visible'] = (string) $field->attributes()->visible == 'true' ? true : false; 
	}
}
switch($end) {
	case 0:
		if (intval(date('m')) > 5) {
			$end = date('Y') + 1;
		} else {
			$end = date('Y');
		}
		break;
	default:
		$end = intval($end);
}

$diff = $end - $start;

$options[0] = '- SELECT -';
$options[$end] = $end;

for ($i = $diff;$i>=0;$i--) {
    $year = $start + $i;
    $options[$year] = $year;  
}

$attributes = array('name' => $name, 'class' => 'uk-width-1-1'.$fieldtype.($required ? ' required' : ''));
if($node->attributes()->option) {
	$attributes['data-option'] = json_encode($optionData);
}
$disabled = $disabled ? $disabled : false;
if($disabled) {
	$attributes['disabled'] = true;
}

printf('<select %s>', $this->app->field->attributes($attributes));

foreach ($options as $val => $text) {

	// set attributes
	$attributes = array('value' => $val);

	// is checked ?
	if ($val == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), $text);
}

printf('</select>');

?>