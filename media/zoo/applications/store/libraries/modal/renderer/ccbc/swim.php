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
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var value = $('[name="swim_ladder"]').val();
		$('input[name="sl_modal_helper"][value="'+value+'"]').prop('checked', 'checked');
		
		$('#ccbc-swim-modal').on('save', function(e, data){
			var name = data.name;
            var elem = $('[name="swim_ladder"]');
            console.log(elem);
            var value = $('[name="sl_modal_helper"]:checked').val()
            data.result = true;
            elem.val(value).trigger('change');
        });
	})
})
</script>