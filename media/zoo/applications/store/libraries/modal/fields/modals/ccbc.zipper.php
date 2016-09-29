<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-1-1">
		<p>Please select a port or starboard side zipper entry for your cover. The zipper entry will be located in-line with the helm seat.</p>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-width-2-3 uk-align-center">
			<img src="/images/helpers/port-starboard.png" />
		</div>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-margin">
			<p>I would like the zipper to be:</p>
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="ZP" class="uk-margin-right" <?php echo $value == 'ZP' ? 'checked' : '' ?> />Port Side Access</label><br />
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="ZS" class="uk-margin-right" <?php echo $value == 'ZS' ? 'checked' : '' ?> />Starboard Side Access</label><br />
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="CR" class="uk-margin-right" <?php echo $value == 'CR' ? 'checked' : '' ?> />Center Rear Access (Twin Hull Only)</label></div>
			<input type="hidden" name="ccbc.zipper_modal_value" data-field-id="<?php echo $field; ?>" />
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var elem = $('[name="ccbc.zipper_modal_value"]');
		//elem.val($('[name="ccbc.zipper_modal_helper"]').val());
		$('[name="ccbc.zipper_modal_helper"]').on('change', function(){
			elem.val($(this).val());
		});
	})

})
</script>