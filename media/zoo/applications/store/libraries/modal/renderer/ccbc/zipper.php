<?php 
$value = $config->get('args')['value'];
?>

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
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="ZP" class="uk-margin-right" checked />Port Side Access</label><br />
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="ZS" class="uk-margin-right" />Starboard Side Access</label><br />
			<label><input name="ccbc.zipper_modal_helper" type="radio" value="CR" class="uk-margin-right" />Center Rear Access (Twin Hull Only)</label></div>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var value = $('[name="zipper"]').val();
		$('input[name="ccbc.zipper_modal_helper"][value="'+value+'"]').prop('checked', 'checked');
		
		$('#ccbc-zipper-modal').on('save', function(e, data){
			console.log(data);
			var name = data.name;
            var elem = $('[name="'+name+'"]');
            console.log(elem);
            var value = $('[name="ccbc.zipper_modal_helper"]:checked').val()
            value = typeof value === 'undefined' ? 0 : value;
            data.result = true;
            elem.val(value).trigger('change');
        });

	})

})
</script>