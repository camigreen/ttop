<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>Boats with a T-Top width measurement more than <?php echo $value; ?> inches are too large for our Boat Shade Kit.</p>
		<p>Check out our Ultimate Boat Shade Kit for larger boats.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#bsk-ttoptoolarge-modal').on('save', function(e, data){
			window.location = '/products/ultimate-boat-shade';
			data.result = true;
        });
        $('#bsk-ttoptoolarge-modal').on('cancel', function(e, data){
        	$('button#measurements-aft').trigger('click');
			data.result = true;
        });
	})

})
</script>