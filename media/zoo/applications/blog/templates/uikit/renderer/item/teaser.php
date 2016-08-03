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
$link = $this->app->route->item($this->_item);

$status = 'closed';
$endDate = $item->getElement('d245f61b-58aa-47e2-9221-6943ed4d68f2')->get('value');
$endDate = $endDate ? $this->app->date->create($endDate) : null;
$now = $this->app->date->create();

if($endDate && $endDate > $now) {
	$status = 'open';
}

?>

<tr>
	
	<td>
		<?php if ($this->checkPosition('title')) : ?>
		<a href="<?php echo $link; ?>">
			<?php echo $this->renderPosition('title', array('style' => 'uikit_blank')); ?>
		</a>
		<?php endif; ?>
	</td>
	<td>
		<?php if ($this->checkPosition('content')) : ?>
		<a href="<?php echo $link; ?>">
			<?php echo $this->renderPosition('content', array('style' => 'uikit_blank')); ?>
		</a>
		<?php endif; ?>
	</td>
	<td>
		<a href="<?php echo $link; ?>">
			<?php if($status == 'closed') : ?>
				<p class="uk-text-danger">This position is currently closed.</p>
			<?php else : ?>
				<ul class="uk-list">
			    	<?php echo $this->renderPosition('meta', array('style' => 'uikit_job_dates_teaser')); ?>
				</ul>
			<?php endif; ?>
		</a>
	</td>
	</a>
</tr>
