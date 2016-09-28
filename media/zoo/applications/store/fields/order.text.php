<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// set attributes

$disabled = $disabled ? $disabled : !$user->canEdit($assetName);

$attributes = array('type' => 'text', 'name' => "{$control_name}[{$name}]", 'value' => $value, 'class' => 'uk-width-1-1');
if($disabled) {
	$attributes['disabled'] = true;
}

printf('<input %s />', $this->app->field->attributes($attributes, array('label', 'description', 'default')));