<?php 
$product = $this->app->product->create($config['item']);
$markups = array(0, 0.05, 0.10, 0.15, 0.20, 0.25);
$currentDiscount = ($product->getDiscountRate());
$mkupRate = $product->getMarkupRate('reseller');
$options = array();
$base = $product->getPrice('base')+$product->getPrice('addons');
$isBase = true;
foreach($markups as $markup) {
	$option = array();
	$text = array();
	if((string) $mkupRate == (string) $markup*100) {
		$option['selected'] = true;
	} else {
		$option['selected'] = false;
	}
	$option['markup'] = $markup;
	$price = $base*($markup+1);
	$text[] = $this->app->number->currency($price, array('currency' => 'USD'));
	if($isBase)
		$text[] = '<span class="uk-text-bold"> Base Price</span>';
	$text[] = '('.$this->app->number->toPercentage($markup*100, 0). ' Markup + '.$this->app->number->toPercentage($currentDiscount, 0).' Discount) =';
	$profit = $price - $product->getPrice('reseller');
	$text[] = $this->app->number->currency($profit, array('currency' => 'USD')).' Dealer Profit';
	$option['text'] = implode(' ', $text);
	$isBase = false;
	$options[] = $option;
}
?>


<div class="uk-h4">Dealer Price</div>
<div><?php echo $this->app->number->currency($product->getPrice('reseller'), array('currency' => 'USD')); ?></div>
<div class="uk-h4">MSRP</div>
<div><?php echo $this->app->number->currency($product->getPrice('msrp'), array('currency' => 'USD')); ?></div>
<div class="uk-h4">Choose your Margins</div>
<div>
	<ul class="uk-list">
		<?php foreach($options as $option) : ?>
			<li>
				<label><input type="radio" name="markup" class="uk-margin-right" value="<?php echo $option['markup']; ?>" <?php echo $option['selected'] ? 'checked' : ''; ?>/><?php echo $option['text']; ?></label>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
        $('#bsk-resellerMarkup-modal').on('save', function(e, data){
        	console.log('Price Options Saved');
        	console.log(data);
        	data.item.params.tempMarkup = $('[name="markup"]:checked').val();
        	$('#OrderForm-bsk').trigger('bskPrice', data);
        });

        $('#bsk-resellerMarkup-modal').on('cancel', function(e, data){
			console.log('Price Options Canceled');
        });
    });
});
</script>