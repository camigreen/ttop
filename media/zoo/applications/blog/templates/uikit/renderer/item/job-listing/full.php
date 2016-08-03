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
$align = ($this->checkPosition('media')) ? $view->params->get('template.item_media_alignment') : '';

$status = 'closed';
$endDate = $item->getElement('d245f61b-58aa-47e2-9221-6943ed4d68f2')->get('value');
$endDate = $this->app->date->create($endDate);
$now = $this->app->date->create();

if($endDate > $now) {
	$status = 'open';
}

?>
<div class="uk-grid">
	<div class="uk-width-1-1 uk-margin-bottom">
		<a href="/careers/"><span class="uk-icon-arrow-left uk-margin-right"></span>Back to Job Listings</a>
	</div>
	<div class="uk-width-1-1">
		<?php if ($this->checkPosition('top')) : ?>
			<?php echo $this->renderPosition('top', array('style' => 'uikit_block')); ?>
		<?php endif; ?>
	</div>
	<div class="uk-width-1-1">
		<?php if ($align == "above") : ?>
			<?php echo $this->renderPosition('media', array('style' => 'uikit_block')); ?>
		<?php endif; ?>
	</div>
	<div class="uk-width-1-1">
		<?php if ($this->checkPosition('title')) : ?>
		<h1 class="uk-article-title">
			<?php echo $this->renderPosition('title'); ?>
			<?php if($status == 'closed') : ?>
				<p class="uk-article-meta uk-text-danger">This position is currently closed.</p>
			<?php endif; ?>
		</h1>
			
		<?php endif; ?>
	</div>
	<div class="uk-width-1-1">
		<?php if ($this->checkPosition('subtitle')) : ?>
			<p class="uk-article-lead">
				<?php echo $this->renderPosition('subtitle'); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php if ($align == "top") : ?>
	<div class="uk-width-1-1">
		<?php echo $this->renderPosition('media', array('style' => 'uikit_block')); ?>
	</div>
	<?php endif; ?>
	<?php if ($align == "left") : ?>
	<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-margin">
		<div class="uk-align-medium-<?php echo $align; ?>">
			<?php echo $this->renderPosition('media'); ?>
		</div>
	</div>
	<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-margin">
		<?php if ($this->checkPosition('content')) : ?>
			<?php echo $this->renderPosition('content'); ?>
		<?php endif; ?>
		<?php if ($this->checkPosition('taxonomy') && $status != 'closed') : ?>
			<?php echo $this->renderPosition('taxonomy', array('style' => 'uikit_block')); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if ($align == "right") : ?>
	<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-margin">
		<?php if ($this->checkPosition('content')) : ?>
			<?php echo $this->renderPosition('content'); ?>
		<?php endif; ?>
		<?php if ($this->checkPosition('taxonomy')) : ?>
			<?php echo $this->renderPosition('taxonomy', array('style' => 'uikit_block')); ?>
		<?php endif; ?>
	</div>
	<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-margin">
		<div class="uk-align-medium-<?php echo $align; ?>">
			<?php echo $this->renderPosition('media'); ?>
		</div>
	</div>	
	<?php endif; ?>
	</div>
</div>
<?php if ($this->checkPosition('meta')) : ?>
<p class="uk-article-meta">
	<?php echo $this->renderPosition('meta'); ?>
</p>
<?php endif; ?>

<?php if ($align == "bottom") : ?>
	<?php echo $this->renderPosition('media', array('style' => 'uikit_block')); ?>
<?php endif; ?>



<?php if ($this->checkPosition('bottom')) : ?>
	<?php echo $this->renderPosition('bottom', array('style' => 'uikit_block')); ?>
<?php endif; ?>

<?php if ($this->checkPosition('related')) : ?>
	<h3><?php echo JText::_('Related Articles'); ?></h3>
	<?php echo $this->renderPosition('related'); ?>
<?php endif; ?>

<?php if ($this->checkPosition('author')) : ?>
<div class="uk-panel uk-panel-box">
	<?php echo $this->renderPosition('author', array('style' => 'uikit_author')); ?>
</div>
<?php endif;
