<?php $value = $config->get('value'); ?>
<div class="uk-grid">
	<div class="uk-width-1-1">
		<p>Boats with a T-Top width measurement less than <?php echo $value; ?> inches are too small for our Boat Shade Kit.</p>
		<p>Give us a call and we may be able to make a custom shade kit for your boat.  Click the contact us button below to send us an email.</p>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		$('#bsk-ttoptoosmall-modal').on('save', function(e, data){
			window.location = '/about-us/contact-us';
			data.result = true;
        });
        $('#bsk-ttoptoosmall-modal').on('cancel', function(e, data){
        	$('button#measurements-aft').trigger('click');
			data.result = true;
        });
	})

})
</script>