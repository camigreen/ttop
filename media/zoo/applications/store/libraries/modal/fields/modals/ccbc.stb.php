<div class="uk-grid" data-uk-grid-margin>
	<ul class="uk-grid" data-uk-grid-margin data-uk-grid-match>
		<li class="uk-width-1-2">
			<div class="uk-thumbnail">
				<div class="uk-thumbnail-caption">
					<label><input name="ccbc.stb_modal_helper" type="radio" value="N" class="ccbc.stb_helper" /> I do not have a ski or tow bar.</label>
					<img src="/images/helpers/ski_poles/NOPOLES.png" alt="NOPOLES" class="uk-thumbnail-medium" style="margin-top:25px;" />
				</div>
			</div>
		</li>
		<li class="uk-width-1-2">
			<div class="uk-thumbnail">
				<div class="uk-thumbnail-caption">
					<label><input name="ccbc.stb_modal_helper" type="radio" value="above" class="ccbc.stb_helper" /> My bar is above the engine.</label>
					<img src="/images/helpers/AE.png" alt="AE" class="uk-thumbnail-medium" />
				</div>
			</div>
		</li>
		<li class="uk-width-1-2">
			<div class="uk-thumbnail">
				<div class="uk-thumbnail-caption">
					<label><input name="ccbc.stb_modal_helper" type="radio" value="in_front" class="ccbc.stb_helper" /> My bar is in front of the engine.</label>
					<img src="/images/helpers/BE.png" alt="BE" class="uk-thumbnail-medium" />
				</div>
			</div>
		</li>
	</ul>
	<div class="uk-width-1-1">
		<label><input name="ccbc.stb_modal_helper" type="radio" value="other" class="ccbc.stb_helper" />Other<span class="uk-text-danger"> (explain in "Additional Info" box)</span></label>
	</div>
	<input type="text" name="ccbc.stb_modal_value" data-field-id="<?php echo $field; ?>"/>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var elem = $('[name="ccbc.stb_modal_value"]');
		$('[name="ccbc.stb_modal_helper"]').on('change', function(){
			elem.val($(this).val());
		});
	})
})
</script>