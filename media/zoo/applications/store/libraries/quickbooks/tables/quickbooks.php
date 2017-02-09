<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/*
	Class: ItemTable
		The table class for items.
*/
class QuickbooksTable extends AppTable {

	public function __construct($app) {
		parent::__construct($app, 'qb_');

		$this->_database = $this->setDBO();
	}


	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function setDBO() {

		// set database
		$option['driver']   = 'mysqli';            // Database driver name
        $option['host']     = '162.144.127.22:3306';    // Database host name
        $option['user']     = 'ttopcove_admin';       // User for database authentication
        $option['password'] = 'dXX0@wWCn6l!';   // Password for database authentication
        $option['database'] = 'ttopcove_qb';      // Database name
        $option['prefix']   = '';             // Database prefix (may be empty)
		$db = JDatabaseDriver::getInstance( $option );
		$this->name      = $db->name;

		return $db;


		
	}

	/*
		Function: save
			Override. Save object to database table.

		Returns:
			Boolean.
	*/
	public function save($object) {

		$object->orderDate = $this->app->date->create($object->orderDate)->toSQL();
		$result = parent::save($object);
		return $result;
	}

	protected function _initObject($object) {

		parent::_initObject($object);
	
		// add to cache
		$key_name = $this->key;

		if ($object->$key_name && !key_exists($object->$key_name, $this->_objects)) {
			$this->_objects[$object->$key_name] = $object;
		}

		// trigger init event
		$this->app->event->dispatcher->notify($this->app->event->create($object, 'orderdev:init'));

		return $object;
	}
}

/*
	Class: ItemTableException
*/
class OrderTableException extends AppException {}