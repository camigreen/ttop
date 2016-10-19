<?php 
	$item = $parent->getValue('product');

	$attributes['id'] = 'qty-'.$item->id;
	$attributes['type'] = 'number';
	$attributes['class'] = 'uk-width-1-1';
	$attributes['name'] = 'qty';
	$attributes['min'] = '1';
	$attributes['value'] = $item->qty; 

	printf('<input %s />', $this->app->field->attributes($attributes));
?>
<div class="uk-margin-top">
    <button id="atc-<?php echo $item->id; ?>" class="uk-button uk-button-danger atc"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
</div>