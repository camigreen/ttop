<?php
$item = $params['item'];
$discountPrice = $item->getPrice();
$msrp = $item->getPrice('msrp');
?>
<div class="uk-grid uk-grid-small">
	<div class="uk-width-1-1 original-price">
		<span>Was</span>
		<span class="price"><?php echo $this->app->number->currency($msrp, array('currency' => 'USD')); ?></span>
	</div>
	<div id="<?php echo $item->id; ?>-price" class="uk-width-1-1 sale-price">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-1-1">
				
				<div class="sale-price-container">
					<i class="currency"></i>
					<span class="price"><?php echo number_format($discountPrice, 2, '.', ''); ?></span>
				</div>
				<div class="sale-price-title">Sale Price</div>
			</div>
		</div>
	</div>
</div>