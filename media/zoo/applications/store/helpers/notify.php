<?php defined('_JEXEC') or die('Restricted access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Shawn
 */
class NotifyHelper extends AppHelper {

	public function __construct($app) {
		parent::__construct($app); 
		$this->app->loader->register('Notification', 'classes:notification.php');
	}

	public function create($type, $object) {
		$class = $type.'Notification';
		if(file_exists($this->app->path->path('notifications:'.$type.'.php'))) {
			$this->app->loader->register($class, 'notifications:'.$type.'.php');
		}
		
		$notify = new $class($this->app, $object);
		return $notify;
	}

}