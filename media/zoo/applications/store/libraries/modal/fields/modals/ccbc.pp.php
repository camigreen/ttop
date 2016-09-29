<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-1-1">
		<label><input name="ccbc.pp_modal_helper_c" type="radio" value="N" class="uk-margin-right" />I do not have a power pole.</label>
	</div>
	<div class="uk-width-1-1">
		<p class="uk-h3 uk-text-center">Choose your mount.</p>
	</div>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<label>Motor Bracket Mount<br /></label>
			</div>
			<img src="/images/helpers/power_poles/MotorBracketEX.png" alt="MotorBracketEX" width="400" height="343" />
		</div>
	</div>
	<div class="uk-width-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<label>Transom Mount</label>
			</div>
			<img src="/images/helpers/power_poles/TransomMounted.png" alt="TransomMounted" width="400" height="343" />
		</div>
	</div>
	<div class="uk-width-1-1">
		<div  class="uk-width-1-1">
			<label><input name="ccbc.pp_modal_helper_b" type="radio" value="EB" class="uk-margin-right"/>Engine Bracket Mount</label>
		</div>
		<div class="uk-width-1-1">
			<label><input name="ccbc.pp_modal_helper_b" type="radio" value="TM" class="uk-margin-right" />Transom Mount</label>
		</div>
	</div>
	<div class="uk-width-1-1">
		<p class="uk-h3 uk-text-center">Which side are your power poles mounted on?</p>
		<div class="uk-width-1-2 uk-container-center">
			<div class="uk-thumbnail">
				<img src="/images/helpers/port-starboard.png" alt="BracketMount" width="400" height="520" />
			</div>
		</div>
	</div>
	<div class="uk-width-1-1">
		<div  class="uk-width-1-1">
			<label><input name="ccbc.pp_modal_helper_a" type="radio" value="S" class="uk-margin-right" />Starboard Side</label>
		</div>
		<div class="uk-width-1-1">
			<label><input name="ccbc.pp_modal_helper_a" type="radio" value="P" class="uk-margin-right" />Port Side</label>
		</div>
		<div  class="uk-width-1-1">
			<label><input name="ccbc.pp_modal_helper_a" type="radio" value="D" class="uk-margin-right" />Port and Starboard Sides</label>
		</div>
	</div>
	<div class="uk-width-1-1 uk-margin-top">
		<label><input name="ccbc.pp_modal_helper_c" type="radio" value="other" class="uk-margin-right" />Other<span class="uk-text-danger"> (explain in "Additional Info" box)</span></label>
	</div>
	<input type="text" name="ccbc.pp_modal_value" data-field-id="<?php echo $field; ?>"/>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		var val_a = "none", val_b = "none";
		var elem = $('[name="ccbc.pp_modal_value"]');
		$('[name="ccbc.pp_modal_helper_c"]').on('change', function(){
			$('[name="ccbc.pp_modal_helper_a"], [name="ccbc.pp_modal_helper_b"]').removeAttr('checked');
			val_a = $(this).val();
			val_b = $(this).val();
			elem.val($(this).val());
		});
		$('[name="ccbc.pp_modal_helper_a"]').on('change', function(){
			$('[name="ccbc.pp_modal_helper_c"]').removeAttr('checked');
			val_a = $(this).val();
			val_b = $('[name="ccbc.pp_modal_helper_b"]:checked').val();
			elem.val(val_a+val_b);
		});
		$('[name="ccbc.pp_modal_helper_b"]').on('change', function(){
			$('[name="ccbc.pp_modal_helper_c"]').removeAttr('checked');
			val_b = $(this).val();
			val_a = $('[name="ccbc.pp_modal_helper_a"]:checked').val();
			elem.val(val_a+val_b);
		});
		$('.modal-save').on('click', function(e){

			if(typeof val_a === 'undefined') {
				alert('Please choose which side your power poles are mounted on.');
				e.stopPropagation();
			}
			if(typeof val_b === 'undefined') {
				alert('Please choose which power pole mount that you have.');
				e.stopPropagation();
			}

		});

	})
})
</script>