<?php
$product = $parent->getValue('product');
$price = $product->getPrice();
?>
<?php if(!$this->app->storeuser->get()->isReseller()) : ?>
	<div id="<?php echo $parent->getValue('product')->id; ?>-price">
		<i class="currency"></i>
		<span class="price"><?php echo $this->app->number->format($product->getPrice(), 2); ?></span>
	</div>
<?php else : ?>
	<div id="<?php echo $product->id; ?>-price">
		<i class="currency"></i>
		<span class="price"><?php echo $this->app->number->precision($price, 2); ?></span>
		<a id="price_options_<?php echo $product->id; ?>" href="#" class="uk-icon-button uk-icon-info-circle uk-text-top markup-modal" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
	</div>

	<script>
		jQuery(function($){
			$(document).ready(function(){
				$('#price_options_<?php echo $product->id; ?>').on('click', function(e) {
					lpiModal.getModal({
	                                type: 'default',
	                                name: 'resellerMarkup',
	                                item: $('#OrderForm-<?php echo $product->id; ?>').OrderForm('getItem')
	                            });
				})
			})
			
		})

	</script>
<?php endif; ?>