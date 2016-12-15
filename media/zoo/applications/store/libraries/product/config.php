<?php
$zoo->path->register($zoo->path->path('store.lib:/product'), 'library.product');
$path = $zoo->path->path('library.product:');
$zoo->path->register($path.'/controllers', 'controllers');
$zoo->path->register($path.'/classes', 'classes');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/fields', 'fields');
$zoo->path->register($path.'/data', 'data');
$zoo->path->register($path.'/events', 'events');
$zoo->path->register($path.'/apis', 'apis');

// register and connect events
$zoo->event->register('ProductEvent');
$zoo->event->dispatcher->connect('product:init', array('ProductEvent', 'init'));

?>