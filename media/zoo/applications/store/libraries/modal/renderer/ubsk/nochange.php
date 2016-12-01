<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>The measurements on the order form are initially set to the lowest sizes that will work with the Boat Shade Kit. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Cancel to correct them.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#ubsk-nochange-modal').on('save', function(e, data){
			measurements_changed = true;
			$('#atc-ubsk').trigger('click');
			data.result = true;
        });
        $('#ubsk-nochange-modal').on('cancel', function(e, data){
        	$('button#measurements-aft').trigger('click');
			data.result = true;
        });
	})

})
</script>