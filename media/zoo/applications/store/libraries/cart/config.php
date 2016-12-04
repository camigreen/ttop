<?php
$zoo->path->register($zoo->path->path('store.lib:/cart'), 'library.cart');
$path = $zoo->path->path('library.cart:');
$zoo->path->register($path.'/controllers', 'controllers');
$zoo->path->register($path.'/classes', 'classes');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/fields', 'fields');
$zoo->path->register($path.'/data', 'data');
$zoo->path->register($path.'/events', 'events');

// register and connect events
$zoo->event->register('CartEvent');
$zoo->event->dispatcher->connect('cart:init', array('CartEvent', 'init'));

?>