<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-1-1">
		<div class="uk-text-center">If the trolling motor is not removable or you choose to leave it in place, there is a $175 trolling motor modification option available. However this option may cause water to collect in the bow and it may not be a custom fit.</div>
		<div class="uk-text-center">If you need this option we will be contacting you by phone or email so that we can get the proper measurements of your trolling motor to ensure that the T-Top Boat Cover fits properly.</div>
	</div>
	<div class="uk-width-1-2 uk-container-center">
		<div>
			<label><input name="ccbc.trolling_motor_modal_helper" type="radio" value="Y" class="uk-margin-right" />Yes, I need this option.</label>
		</div>
		<div>
			<label><input name="ccbc.trolling_motor_modal_helper" type="radio" value="R" class="uk-margin-right" checked/>I will remove my trolling motor.</label>
		</div>
	</div>
</div>
<input type="text" name="ccbc.trolling_motor_modal_value" data-field-id="<?php echo $field; ?>" value="R" />

<script>
jQuery(function($){
	$(document).ready(function(){
		var elem = $('[name="ccbc.trolling_motor_modal_value"]');
		$('[name="ccbc.trolling_motor_modal_helper"]').on('change', function(){
			elem.val($(this).val());
		});
	})

})
</script>