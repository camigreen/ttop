<?php
/**
 * @package   Package Name
 * @author    Shawn Gibbons http://www.palmettoimages.com
 * @copyright Copyright (C) Shawn Gibbons
 * @license   
 */

/**
 * Class Description
 *
 * @package Class Package
 */
class Price {


	/**
	 * @var [ArrayObject]
	 */
	protected $_storage;

	/**
	 * @var [float]
	 */
	public $base;

	/**
	 * @var [type]
	 */
	public $group;

	/**
	 * @var [type]
	 */
	protected $params;

	/**
	 * @var [type]
	 */
	public $resource;

	/**
	 * @var [App Object]
	 */
	public $app;
	

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		//$this->app = $app;
		$this->_storage = $this->app->data->create();
		$this->resource = $this->app->path->path('lists:');
		var_dump($this);

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
	public function get() {
		return 0.00;
	}
}

?>