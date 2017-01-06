<?php
$item = $params['item'];
$type = $params['type'];
$price = $item->getPrice();

?>
<div id="<?php echo $item->id.'-price'; ?>">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->precision($price, 2); ?></span>
	<a id="price_options_<?php echo $item->id.'-'.$type; ?>" href="#" class="uk-icon-button uk-icon-info-circle uk-text-top markup-modal" style="margin-left:10px;" data-uk-tooltip title="Click here for pricing info!"></a>
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#price_options_<?php echo $item->id."-".$type; ?>').on('click', function(e) {
				lpiModal.getModal({
                                type: 'bsk',
                                name: 'resellerMarkup',
                                item: items['bsk-<?php echo $type; ?>']
                            });
			})
		})
		
	})

</script>