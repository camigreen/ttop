<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');
print_r($output[0]);
?>
<div class="uk-width-1-1">
	<div class="uk-slidenav-position" data-uk-slider>

	    <div class="uk-slider-container">
	        <ul class="uk-slider uk-grid-width-medium-1-1">
	        	<?php foreach($output as $html) : ?>
	            	<li><?php echo $html; ?></li>
	        	<?php endforeach; ?>
	        </ul>
	    </div>
	</div>
</div>
<div class="uk-width-1-1 uk-text-center">
	<div><span class="uk-icon uk-icon-arrow-left uk-margin-right"></span>Swipe<span class="uk-icon uk-icon-arrow-right uk-margin-left"></span></div>
</div>