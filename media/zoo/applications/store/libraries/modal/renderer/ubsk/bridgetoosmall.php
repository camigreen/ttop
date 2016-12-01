<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>Boats with a bridge with measurement less than <?php echo $value; ?> inches are too small for our Ultimate Boat Shade Kit.</p>
		<p>Take a look at our Boat Shade Kit for smaller boats.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#ubsk-bridgetoosmall-modal').on('save', function(e, data){
			window.location = '/products/boat-shade-kit';
			data.result = true;
        });
        $('#ubsk-bridgetoosmall-modal').on('cancel', function(e, data){
			data.result = true;
        });
	})

})
</script>