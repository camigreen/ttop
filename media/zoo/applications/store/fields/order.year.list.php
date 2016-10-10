<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// set attributes

$start = $parent->getValue('year.start', 2000);
$end = $parent->getValue('year.end', 0);
$fieldtype = $node->attributes()->option ? ' item-option' : '';
$xml = simplexml_load_file($this->app->path->path('fields:config.xml'));
$optionData = array(
	'name' => (string) $node->attributes()->name,
	'label' => (string) $node->attributes()->label,
	'type' => (string) $node->attributes()->option
);
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

$attributes = array('name' => $name, 'class' => 'uk-width-1-1'.$fieldtype);
if($node->attributes()->option) {
	$attributes['data-option'] = json_encode($optionData);
}
$disabled = $disabled ? $disabled : !$user->canEdit($assetName);
if($disabled) {
	$attributes['disabled'] = true;
}

printf('<select %s>', $this->app->field->attributes($attributes));

foreach ($options as $year) {

	// set attributes
	$attributes = array('value' => $year);

	// is checked ?
	if ($year == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), $year);
}

printf('</select>');

?>