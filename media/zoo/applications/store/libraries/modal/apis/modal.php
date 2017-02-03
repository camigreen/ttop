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
class ModalAPI extends API {

	/**
	 * Class constructor
	 *
	 * @param datatype	$value	Parameter Description
	 */
	public function __construct($app) {
		parent::__construct($app);
	}

	public function init() {
		return 'Modal API Initialized';
	}

	public function get($params = array()) {
		$config = $params['config'];
		if(!isset($config['type'])) {
			throw new ModalAPIException('Modal Type Missing.');
		}
		if(!isset($config['name'])) {
			throw new ModalAPIException('Modal Name Missing.');
		}
		return $this->app->modal->create($config);        
	}

	
}

class ModalAPIException extends APIException {}

?>