<?php 

$product = $this->app->product->create($config['item']);
$add_info = $product->getOption('add_info')->get('value');
?>
<div class="uk-form">
	<div class="uk-width-1-1 uk-article-lead uk-text-center">
		<p>If you have added any aftermarket equipment that we do not have listed on our order form, please list it in the special instructions below.</p>
	</div>
	<div class="uk-width-1-1">
		<label>Special Instructions</label>
		<textarea name="add_info_helper" class="uk-width-1-1" style="height:100px;"><?php echo $add_info; ?></textarea>
	</div>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
        $('#default-additional_info-modal').on('cancel', function(e, data){
            console.log(data);
            var item = data.item;
            item.options.add_info.prompted = true;
            item.options.add_info.value = $('[name="add_info_helper"').val();
            $('#atc-'+item.id).trigger('click');
        });
    });
});
</script>