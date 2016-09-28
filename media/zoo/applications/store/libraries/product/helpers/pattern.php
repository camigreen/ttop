<?php defined('_JEXEC') or die('Restricted access');

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
class PatternHelper extends AppHelper {

	/**
	 * @var [array]
	 */
	protected $_patterns = array();	

	/**
	 * @var [simpleXmlElement]
	 */
	protected $_xml;	
	

	public function __construct($app) {
		parent::__construct($app);
		$this->_xml = simplexml_load_file($this->app->path->path('library.product:items.xml'));
	}

	public function get($name) {
		$xml = simplexml_load_file($this->app->path->path('library.product:/patterns.xml'));
        foreach($xml as $patterns) {
            if($patterns->attributes()->name == $name) {
       			$p = array();
       			foreach($patterns->pattern as $pattern) {
       				$id = (string) $pattern->attributes()->id;
       				$p[$id] = array();
       				foreach($pattern->option as $option) {
       					$p[$id][(string) $option->attributes()->name] = (string) $option->attributes()->value;
       				}
       				
       			}
       			
            }
        }
        return $p;
	}

}

?>