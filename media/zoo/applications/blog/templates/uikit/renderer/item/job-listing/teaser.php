<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// init vars
$params = $item->getParams('site');

/* set media alignment */
$align = ($this->checkPosition('media')) ? $params->get('template.teaseritem_media_alignment') : '';

?>

<tr>
	<td>
		<?php if ($this->checkPosition('title')) : ?>
			<?php echo $this->renderPosition('title'); ?>
		<?php endif; ?>
	</td>
	<td>
		<?php if ($this->checkPosition('content')) : ?>
			<?php echo $this->renderPosition('content'); ?>
		<?php endif; ?>
	</td>
	<td>
		<?php if ($this->checkPosition('meta')) : ?>
		<p class="uk-article-meta">
		    <?php echo $this->renderPosition('meta'); ?>
		</p>
		<?php endif; ?>
	</td>
</tr>
