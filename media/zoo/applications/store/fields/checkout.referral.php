<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// Get Variables
$options = array(
	'' => '- SELECT -',
	'google' => 'Google Search',
	'THT' => 'thehulltruth.com',
	'friend' => 'Friend',
	'facebook' => 'Facebook',
	'youtube' => 'YouTube',
	'other' => 'Other'
);
$control_name = $control_name == 'null' ? $name : $control_name."[$name]";
// Set Attributes
$attributes['id'] = 'checkout.referral';
$attributes['name'] = $control_name;
$class = 'uk-width-1-1';
$class .= ' required';

$attributes['class'] = $class;

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