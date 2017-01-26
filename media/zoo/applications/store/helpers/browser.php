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
class BrowserHelper extends AppHelper {

	protected $_browser;

	public function __construct($app) {
		parent::__construct($app);

		$this->_browser = JBrowser::getInstance();

		

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
	public function isMobile() {

		$mobile = $this->_browser->isMobile();

		$lowerAgent = strtolower($this->_browser->getAgentString());

		if(strpos($lowerAgent, 'mobi') !== false) {
			$mobile = true;
		}
		// if(strpos($lowerAgent, 'ipad') !== false) {
		// 	$mobile = false;
		// }

		return $mobile;
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
	public function __call($name, $args) {
		return $this->_browser->$name($args);
	}
    
}