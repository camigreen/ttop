<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// set attributes

$disabled = $disabled ? $disabled : !$user->canEdit($assetName);

$attributes = array('type' => 'text', 'name' => $name, 'class' => 'uk-width-1-1 item-option');
if($disabled) {
	$attributes['disabled'] = true;
}

printf('<textarea %s>%s</textarea>', $this->app->field->attributes($attributes, array('label', 'description', 'default')), $value);