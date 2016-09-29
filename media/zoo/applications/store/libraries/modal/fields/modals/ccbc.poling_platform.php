<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-5-6 uk-container-center">	
		<img src="/images/helpers/poling_platform/diagram.png" alt="" vspace="10" />
	</div>
	<div class="uk-width-1-1">
		<label><input name="ccbc.poling_platform_modal_helper_a" type="radio" value="n" class="uk-margin-right"/>I do not have a poling platform.</label>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-width-1-1">
			<label><input name="ccbc.poling_platform_modal_helper_b" type="radio" value="y" class="uk-margin-right"/>I have a poling platform.</label>
		</div>
		<div id="poling-height-helper" class="uk-width-3-4 uk-container-center uk-hidden">
			<label>My poling platform is <input type="text" readonly style="border:0; font-weight:bold; width: 30px; font-size:20px;" id="poling-platform-height-helper" class="uk-text-danger uk-text-center" /> inches high.</label>
			<div id="slider-range-min-helper"></div>
			<div class="uk-text-small uk-text-center"><i class="uk-icon-arrow-left uk-margin-right"></i>Slide the bar to adjust the poling platform height.<i class="uk-icon-arrow-right uk-margin-left"></i></div>
		</div>
	</div>
	<input type="hidden" name="ccbc.poling_platform_modal_value" data-field-id="<?php echo $field; ?>"/>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){

		var elem = $('[name="ccbc.poling_platform_modal_value"]');
		var hgt = $('#poling-platform-height-helper');
	    
	    $( "#slider-range-min-helper" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 50,
			slide: function( event, ui ) {
			$( "#poling-platform-height-helper" ).val( ui.value );
			}
	    });
	    $( "#poling-platform-height-helper" ).val( $( "#slider-range-min-helper" ).slider( "value" ) );




		
		$('[name="ccbc.poling_platform_modal_helper_a"]').on('change', function(){
			$('[name="ccbc.poling_platform_modal_helper_b"]:checked').removeAttr('checked').trigger('change');
			elem.val($(this).val());
		});
		$('[name="ccbc.poling_platform_modal_helper_b"]').on('change', function(){
			if($(this).attr('checked')) {
				$('#poling-height-helper').removeClass('uk-hidden');
				$('[name="ccbc.poling_platform_modal_helper_a"]:checked').removeAttr('checked');
				elem.val($(this).val());
			} else {
				$('#poling-height-helper').addClass('uk-hidden');
			}
			
		});
		$('.modal-save').on('click', function() {
			$("#poling-platform-slider-range-min").slider('value', hgt.val());
			$("#poling-platform-height").val(hgt.val());
		});
	});
});
</script>