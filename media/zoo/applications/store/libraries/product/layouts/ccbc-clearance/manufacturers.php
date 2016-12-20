


<div class="uk-grid uk-grid-match boat-manufacturers" data-uk-grid-match="{target:'.uk-panel'}" data-uk-grid-margin>
<div class="uk-width-1-1 uk-text-center">
	<p class="uk-article-title">Center Console Boat Cover</p>
	<p class="uk-article-lead">Choose the manufacturer of your boat</p>
</div>

<?php foreach($this->boats as $boat) : ?>
	<?php if(count($boat->models) > 0) : ?>
		<?php $params = $boat->get('params');?>
		<div class="uk-width-medium-1-4">
			<div class="uk-panel product-container">
				<a href="<?php echo $this->url.$boat->get('name'); ?>">
					<div class="uk-panel-title uk-text-center">
						<?php if($params->get('images.logo')) : ?>
							<img src="<?php echo $params->get('images.logo'); ?>" />
						<?php else : ?>
							<span><?php echo $boat->label; ?></span>
						<?php endif; ?>
					</div>
					<div class="uk-width-9-10 uk-container-center">
						<img src="<?php echo $params->get('images.thumb'); ?>" />
					</div>
				</a>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>