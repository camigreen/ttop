<?php
$zoo->path->register($zoo->path->path('store.lib:/api'), 'library.api');
$path = $zoo->path->path('library.api:');
$zoo->path->register($path.'/controllers', 'controllers');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/classes', 'apis');
?>