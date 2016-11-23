
<div class="uk-width-1-1 uk-margin"></div>
<div class="uk-width-1-1">

</div>

<div class="uk-grid" data-uk-grid-margin>
	<ul class="uk-grid" data-uk-grid-margin data-uk-grid-match>
		<li class="uk-width-1-1">
			<img src="/images/helpers/jackplatehelper.png" alt="jackplatehelper" width="468" height="471" style="display: block; margin-left: auto; margin-right: auto;" />
		</li>
		<li class="uk-width-1-1">
			<ul class="uk-list">
				<p>Choose one of the following:</p>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="N" class="uk-margin-right" />I do not have a jack plate.</label>
				</li>
				<p>I have a jack plate and it is:</p>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP4" class="uk-margin-right" />4 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP6" class="uk-margin-right" />6 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP8" class="uk-margin-right" />8 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP10" class="uk-margin-right" />10 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP12" class="uk-margin-right" />12 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="JP14" class="uk-margin-right" />14 inches</label>
				</li>
				<li>
					<label><input name="ccbc.jp_modal_helper" type="radio" value="other" class="uk-margin-right" />Other<span class="uk-text-danger"> (explain in "Additional Info" box)</span></label>
				</li>
			</ul>
		</li>
	</ul>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var value = $('[name="jack_plate"]').val();
		$('input[name="ccbc.jp_modal_helper"][value="'+value+'"]').prop('checked', 'checked');

		$('#ccbc-jp-modal').on('save', function(e, data){
			var name = data.name;
            var elem = $('[name="jack_plate"]');
            console.log(elem);
            var value = $('[name="ccbc.jp_modal_helper"]:checked').val()
            data.result = true;
            elem.val(value).trigger('change');
        });
	})

})
</script>