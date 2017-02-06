<?php
$zoo->path->register($zoo->path->path('store.lib:/quickbooks'), 'library.quickbooks');
$path = $zoo->path->path('library.quickbooks:');
$zoo->path->register($path.'/classes', 'classes');
$zoo->path->register($path.'/helpers', 'helpers');
$zoo->path->register($path.'/apis', 'apis');
$zoo->path->register($path.'/tables', 'tables');

?>