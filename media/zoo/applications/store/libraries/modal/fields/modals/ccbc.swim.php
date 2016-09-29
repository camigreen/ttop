<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption"><label><input name="sl_modal_helper" type="radio" value="SL-P" />&nbsp; Platform Ladder<br /></label>&nbsp;<span style="font-size: 10pt;">(Pictured Below)</span></div>
			<img src="/images/helpers/swim_ladder/Universal.png" alt="" vspace="10" /></div>
	</div>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption"><label><input name="sl_modal_helper" type="radio" value="SL-I" />&nbsp; Inlaid Ladder<br /></label>&nbsp; <span style="font-size: 10pt;">(Pictured Below)</span></div>
			<img src="/images/helpers/swim_ladder/Inlaid.png" alt="" vspace="10" /></div>
	</div>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption"><label><input name="sl_modal_helper" type="radio" value="SL-R" />&nbsp; Removable Ladder<br /></label>&nbsp;<span style="font-size: 10pt;">(Pictured Below)</span></div>
			<img src="/images/helpers/swim_ladder/Removable.png" alt="" vspace="10" /></div>
	</div>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption"><label><input name="sl_modal_helper" type="radio" value="N" />&nbsp; None<br /></label>&nbsp;<span style="font-size: 10pt;">(Pictured Below)</span></div>
			<img src="/images/NoLadder.png" alt="NoLadder" vspace="10" /></div>
	</div>
	<div class="uk-width-1-1">
		<label><input name="sl_modal_helper" type="radio" value="other" />Other<span class="uk-text-danger">(explain in "Additional Info" box)</span></label>
	</span></div>
	<input type="hidden" name="ccbc.swim_modal_value" data-field-id="<?php echo $field; ?>"/>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var elem = $('[name="ccbc.swim_modal_value"]');
		$('[name="sl_modal_helper"]').on('change', function(){
			elem.val($(this).val());
		});
	})
})
</script>