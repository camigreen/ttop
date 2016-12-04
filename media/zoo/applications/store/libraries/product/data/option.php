<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

/**
 * Class for reading and writing parameters in Joomla JRegistry format 
 * 
 * @package Framework.Data
 */
class OptionData extends ParameterData {

	/**
	 * Describe the Function
	 *
	 * @param 	datatype		Description of the parameter.
	 *
	 * @return 	datatype	Description of the value returned.
	 *
	 * @since 1.0
	 */
	public function getValue($default = 0) {
		return $this->get('value', $default);
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
	public function setValue($value = null) {
		if($value === null) {
			return $this;
		}
		if($choice = $this->get('choices.'.$value)) {
			$this->set('value', $choice->get('value'));
			$this->set('text', $choice->get('text'));
		} else {
			$this->set('value', $value);
			$this->set('text', $value);
		}
        
        return $this;
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
	public function setText($value = null) {
		$this->set('text', $value);
		return $this;
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
	public function getText($default = null) {
		return $this->get('text', $default);
	}

	    /**
     * Describe the Function
     *
     * @param     datatype        Description of the parameter.
     *
     * @return     datatype    Description of the value returned.
     *
     * @since 1.0
     */
    public function isPriceOption() {
    	$types = explode('|', $this->type);
    	return in_array('price', $types);
        
    }
}

?>