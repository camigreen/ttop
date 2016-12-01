<?php 

$bsk = $this->app->bsk;
$kind = $config->get('args')['kind'];
$makes = $bsk->getMakes($kind);

?>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">
       	<p class="uk-text-center ttop-modal-subtitle" >For your convenience, we have collected measurements for the following boats.  If you do not see your boat listed, don't worry you can enter your own measurements on the order page.</p>
    </div>
    <div class="uk-width-1-1">
    	<div class="uk-grid">
			<div class="uk-width-1-2">
				<label>Boat Make</label>
				<select id="boatmake" name="boatmake" class="uk-width-1-1">
					<option value="0">- Select -</option>
					<?php foreach($makes as $value => $make) : ?>
						<option value="<?php echo $value; ?>"><?php echo $make; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="uk-width-1-2">
				<label>Boat Model</label>
				<select id="boatmodel" name="boatmodel" class="uk-width-1-1" disabled>
					<option value="0">- Select -</option>
				</select>
			</div>
		</div>
    </div>
</div>

<script>

	jQuery(function($) {
	  	$(document).ready(function() {
	  		$('#ccc-boatchooser-modal .modal-save').prop('disabled', true);
	  		$('[name="boatmake"]').on('change', function() {
	  			var elem = $('[name="boatmodel"]');
	  			var make = $('#boatmake option:selected').val();
	  			$.ajax({
	                type: 'POST',
	                url: "?option=com_zoo&controller=test&task=testBoatModel&format=json",
	                data: {kind: '<?php echo $kind; ?>', make: make},
	                success: function(data){
	                	elem.children('option').remove('option.mod_dynamic');
	                    $.each(data, function(k,v) {
	                    	elem.append('<option value="'+k+'" class="mod_dynamic">'+v+'</option>')
	                    })
	                    elem.trigger('change');
	                },
	                error: function(data, status, error) {
	                	console.log('error');
	                },
	                dataType: 'json'
            	});
	  		})
		  	console.log($('#ccc-boatchooser-modal'));
		  	$('#ccc-boatchooser-modal').on('save', function(e, data){
		  		var make = $('[name="boatmake"] option:selected');
                var model = $('[name="boatmodel"] option:selected');
                $('[name="make"]').val(make.text()).trigger('input');
                $('[name="model"]').val(model.text()).trigger('input');
                var measurements = model.val().split(','), proceed = true;

                // Transfer TTop2Deck Measurement
                $('#ttop2deck').val(parseInt(measurements[0]));
                if($('#OrderForm-ccc').trigger('measure', {location: 'ttop2deck'})) {
                	$('#helm2console').val(parseInt(measurements[1]));
                	console.log('Passed');
                } else {
                	$('#ttop2deck').val(CCC.options.ttop2deck.default);
                	proceed = false;
                }
                if(proceed && $('#OrderForm-ccc').trigger('measure',{adjustHSW: false, location: 'helm2console'})) {
                    $('#helmSeatWidth').val(parseInt(measurements[2]));
                } else {
                    $('#helm2console').val(CCC.options.helm2console.default);
                    proceed = false;
                }
	            if(proceed && !$('#OrderForm-ccc').trigger('measure',{item: self.item, adjustHSW: false, location: 'helmSeatWidth'})) {
	                $('#helmSeatWidth').val(CCC.options.helmSeatWidth.default);
	                proceed = false;
	            }
	            if(proceed) {
                    CCC.measurements_changed = 'T-Top';
                    $('.chosen_boat').text('Chosen Boat: '+make.text()+' - '+model.text());
                    $('.ccc-measurement').hide();
                    CCC.mode = 'CYB';
                } else {
                    $('#OrderForm-ccc').trigger('backToDefaults');
                    $('#OrderForm-ccc').trigger('measure');
                }
                data.result = 'break';
		  		return data;

	        });
	        $('#ccc-boatchooser-modal').on('cancel', function(e, data){
	        	console.log('Enter My Own');
	        	$('.ccc-measurement').show();
                $('#OrderForm-ccc').trigger('backToDefaults', {mode: 'EMM'});
                CCC.mode = 'EMM';
                $('#OrderForm-ccc').trigger('measure', {});
                data.result = true;
	        	return data;
	        });

	  		$('#ccc-boatchooser-modal select').on('change', function() {
	  			var make = $('#boatmake option:selected').val();
	  			var model = $('#boatmodel option:selected').val();

	  			if(make == 0 || model == 0) {
                    $('#ccc-boatchooser-modal .modal-save').prop('disabled', true);
                } else {
                    $('#ccc-boatchooser-modal .modal-save').prop('disabled', false);
                }
            	if(make == 0) {
                    $('[name="boatmodel"]').prop('disabled',true);
                } else {
                	$('[name="boatmodel"]').prop('disabled', false);
                }
	  		})

	  		
	  		
	  	})
	 })

</script>