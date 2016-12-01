<?php
$item = $params['item'];
$price = $item->getPrice();

?>
<div id="<?php echo $item->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->precision($price, 2); ?></span>
	<a id="price_options_<?php echo $item->id; ?>" href="#" class="uk-icon-button uk-icon-info-circle uk-text-top markup-modal" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
	<input type="text" name="markup" data-name="Markup" value="<?php echo $item->getMarkupRate(); ?>" />
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#price_options_<?php echo $item->id; ?>').on('click', function(e) {
				lpiModal.getModal({
                                type: 'default',
                                name: 'resellerMarkup',
                                item: <?php echo $item->toJson(true); ?>
                            });
			})
		})
		
	})

</script>