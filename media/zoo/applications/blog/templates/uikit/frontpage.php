<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//$this->app->document->addScript('assets:js/lightbox.js');

// show description only if it has content
if (!$this->application->description) {
	$this->params->set('template.show_description', 0);
}

// show title only if it has content
if (!$this->application->getParams()->get('content.title')) {
	$this->params->set('template.show_title', 0);
}

// show image only if an image is selected
if (!($image = $this->application->getImage('content.image'))) {
	$this->params->set('template.show_image', 0);
}

$css_class = $this->application->getGroup().'-'.$this->template->name;

?>

<div class="yoo-zoo <?php echo $css_class; ?> <?php echo $css_class.'-frontpage'; ?>">

	<?php if ($this->params->get('template.show_title') || $this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>

		<?php if ($this->params->get('template.show_title')) : ?>
		<h1 class="uk-h1 <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>"><?php echo $this->application->getParams()->get('content.title') ?></h1>
		<?php endif; ?>

		<?php if ($this->application->getParams()->get('content.subtitle')) : ?>
		<p class="uk-text-large <?php echo 'uk-text-'.$this->params->get('template.alignment'); ?>"><?php echo $this->application->getParams()->get('content.subtitle') ?></p>
		<?php endif; ?>

		<?php if ($this->params->get('template.show_description') || $this->params->get('template.show_image')) : ?>
		<div class="uk-margin">
			<?php if ($this->params->get('template.show_image')) : ?>
			<img class="<?php echo 'uk-align-'.($this->params->get('template.alignment') == "left" || $this->params->get('template.alignment') == "right" ? 'medium-' : '').$this->params->get('template.alignment'); ?>" src="<?php echo $image['src']; ?>" <?php echo $image['width_height']; ?> title="<?php echo $this->application->getParams()->get('content.title'); ?>" alt="<?php echo $this->application->getParams()->get('content.title'); ?>" />
			<?php endif; ?>
			<?php if ($this->params->get('template.show_description')) echo $this->application->getText($this->application->description); ?>
		</div>
		<?php endif; ?>

	<?php endif; ?>
	<table class="uk-table-hover uk-table-striped">
		<thead>
			<td class="uk-width-2-10">Job Title</td>
			<td class="uk-width-6-10">Job Description</td>
			<td class="uk-width-2-10">Posting Dates</td>
		</thead>
		<tbody>
			<?php

				// render items
				if (count($this->items)) {
					echo $this->partial('items');
				}

			?>
			
		</tbody>
	</table>

	<p>
		<a class="uk-button uk-button-primary" href="images/documents/LPI_Employment_Application.pdf" target="_window"><span class="uk-icon-download uk-margin-right"></span>Employment Application</a>
	</p>


</div>
