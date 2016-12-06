<ul class="uk-grid" data-uk-grid-margin data-uk-grid-match>
	<li class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<label><input name="stb_modal_helper" type="radio" value="N" class="stb_helper" /> I do not have a ski or tow bar.</label>
				<img src="/images/helpers/ski_poles/NOPOLES.png" alt="NOPOLES" class="uk-thumbnail-medium" style="margin-top:25px;" />
			</div>
		</div>
	</li>
	<li class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<label><input name="stb_modal_helper" type="radio" value="above" class="stb_helper" /> My bar is above the engine.</label>
				<img src="/images/helpers/AE.png" alt="AE" class="uk-thumbnail-medium" />
			</div>
		</div>
	</li>
	<li class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<label><input name="stb_modal_helper" type="radio" value="in_front" class="stb_helper" /> My bar is in front of the engine.</label>
				<img src="/images/helpers/BE.png" alt="BE" class="uk-thumbnail-medium" />
			</div>
		</div>
	</li>
</ul>
<div class="uk-width-1-1">
	<label><input name="stb_modal_helper" type="radio" value="other" class="stb_helper" />Other<span class="uk-text-danger"> (explain in "Additional Info" box)</span></label>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var value = $('[name="ski_tow_bar"]').val();
		$('input[name="stb_modal_helper"][value="'+value+'"]').prop('checked', 'checked');
		
		$('#ccbc-stb-modal').on('save', function(e, data){
			var name = data.name;
            var elem = $('[name="ski_tow_bar"]');
            console.log(elem);
            var value = $('[name="stb_modal_helper"]:checked').val()
            data.result = true;
            elem.val(value).trigger('change');
        });
	})
})
</script>