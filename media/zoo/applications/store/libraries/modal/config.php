<?php

$zoo->path->register($zoo->path->path('store.lib:/modal'), 'library.modal');
$path = $zoo->path->path('library.modal:');
$zoo->path->register($path.'/controllers', 'controllers');
$zoo->path->register($path.'/classes', 'classes');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/fields', 'fields');

?>