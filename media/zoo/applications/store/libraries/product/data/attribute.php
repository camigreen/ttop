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
class AttributeData extends AppData {

	/**
     * Name
     *
     * @var [sting]
     * @since 1.0.0
     */
    public $name;

    /**
     * Type
     *
     * @var [sting]
     * @since 1.0.0
     */
    public $type;

    /**
     * value
     *
     * @var [mixed]
     * @since 1.0.0
     */
    public $value;

    /**
     * text
     *
     * @var [sting]
     * @since 1.0.0
     */
    public $text;

    /**
     * Label
     *
     * @var [sting]
     * @since 1.0.0
     */
    public $label;

    /**
     * Visible
     *
     * @var [bool]
     * @since 1.0.0
     */
    public $visible;

}

?>