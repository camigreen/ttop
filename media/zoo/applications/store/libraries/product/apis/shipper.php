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
class ShipperAPI extends API {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function init() {
		return 'Shipper API Initialized';
	}
	
}

class ShipperAPIException extends APIException {}

?>