<?php

$params = $this->manufacturer->get('params');
$models = $this->manufacturer->get('models');

?>
<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-1-1">
		<a class="uk-text-large" href="<?php echo $this->url; ?>"><i class="uk-icon uk-icon-caret-left uk-margin-right"></i>Back to Manufacturers</a>
	</div>
	<div class="uk-width-1-1 uk-text-center">
		<p class="uk-article-title">Center Console Boat Cover</p>
		<p class="uk-article-lead">Choose your boat model.</p>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-article-title uk-text-center"><?php echo $this->manufacturer->get('label'); ?></div>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-width-3-6 uk-container-center">
			<img src="<?php echo $params->get('images.full'); ?>" />
		</div>
	</div>
	<div class="uk-width-1-1 uk-text-center">
		<span class="uk-h3">Available Models</span>
	</div>
	<?php foreach($models as $model) : ?>
	
		<div class="uk-width-medium-1-3">
			<a href="<?php echo $this->url.$this->manufacturer->name.'/'.$model->name; ?>">
			<div class="uk-panel uk-panel-box uk-panel-box-primary">
				<div class="uk-h4">
					<?php echo $model->label; ?>
				</div>
			</div>
			</a>
		</div>
	
	<?php endforeach; ?>
</div>