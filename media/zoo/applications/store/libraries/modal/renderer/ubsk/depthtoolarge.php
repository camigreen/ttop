<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>Boats with a bridge to rod holder measurement more than <?php echo $value; ?> inches are too large for our Ultimate Boat Shade Kit.</p>
		<p>However we may be able to customize the Ultimate Boat Shade Kit to fit your needs.  Click the contact us button below to send us an email.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#ubsk-depthtoolarge-modal').on('save', function(e, data){
			window.location = '/about-us/contact-us';
			data.result = true;
        });
        $('#ubsk-depthtoolarge-modal').on('cancel', function(e, data){
			data.result = true;
        });
	})

})
</script>