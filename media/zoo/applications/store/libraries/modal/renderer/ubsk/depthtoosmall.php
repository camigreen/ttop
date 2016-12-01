<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>Boats with a bridge to rod holder measurement less than <?php echo $value; ?> inches are too small for our Ultimate Boat Shade Kit.</p>
		<p>Take a look at our Boat Shade Kit for smaller boats.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#ubsk-depthtoosmall-modal').on('save', function(e, data){
			window.location = '/products/boat-shade-kit';
			data.result = true;
        });
        $('#ubsk-depthtoosmall-modal').on('cancel', function(e, data){
			data.result = true;
        });
	})

})
</script>