<?php
$zoo->path->register($zoo->path->path('store.lib:/price'), 'library.price');
$path = $zoo->path->path('library.price:');
$zoo->path->register($path.'/controllers', 'controllers');
$zoo->path->register($path.'/classes', 'classes');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/rules', 'rules');

?>