<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	defined('_JEXEC') or die('Restricted access');

?>
<ul class="uk-list">
	<?php foreach($output as $html) : ?>
	<li><?php echo $html; ?></li>
	<?php endforeach; ?>
</ul>