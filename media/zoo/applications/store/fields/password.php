<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// set attributes
$attributes = array('id' => $name, 'type' => 'password', 'name' => "{$control_name}[{$name}]", 'value' => $value, 'class' => isset($class) ? $class : '');

$disabled = (bool) $node->attributes()->disabled ? 'disabled' : ''; 
printf('<input %s '.$disabled.' autocomplete="off"/>', $this->app->field->attributes($attributes, array('label', 'description', 'default')));
?>

