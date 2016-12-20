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
class API {

	/**
	 * @var [type]
	 */
	public $app;

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		$this->app = $app;
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
	public function init() {

		return 'API Class Loaded';
	}

	public function __call($name, $arguments) {
		throw new APIException('API Method {'.$name.'} does not exist.');
	}

}

class APIException extends Exception {}

?>