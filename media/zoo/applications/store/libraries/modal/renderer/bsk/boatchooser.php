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
	  		$('#bsk-boatchooser-modal .modal-save').prop('disabled', true);
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
		  	$('#bsk-boatchooser-modal').on('save', function(e, data){
		  		console.log(data);
		  		var item = items['bsk-aft'];

		  		var make = $('[name="boatmake"] option:selected');
                var model = $('[name="boatmodel"] option:selected');
                $('[name="boat_make"]').val(make.text()).trigger('input');
                $('[name="boat_model"]').val(model.text()).trigger('input');
                var measurements = model.val().split(','), proceed = true;

                // Transfer TTop2Deck Measurement
                item.options.beam.value = parseInt(measurements[0]);
                if($('#OrderForm-bsk').trigger('measure', {item: item, type: 'aft'})) {
                	item.options.ttop.value = parseInt(measurements[1]);
                	console.log('Beam Passed');
                } else {
                	item.options.ttop.value = defaults.aft.ttop.default;
                	proceed = false;
                }
                if(proceed && $('#OrderForm-bsk').trigger('measure',{item: item, type: 'aft'})) {
                    item.options.ttop2rod.value = parseInt(measurements[2]);
                    console.log('TTop Width Passed');
                } else {
                    item.options.ttop2rod.value = defaults.aft.ttop.default;
                    proceed = false;
                }
	            if(proceed && !$('#OrderForm-bsk').trigger('measure',{item: item, type: 'aft'})) {
	                item.options.ttop2rod.value = defaults.aft.ttop2rod.default;
	                proceed = false;
	            }
	            console.log('TTop2Rod Passed');
	            if(proceed) {
                    defaults.aft.changed = 'T-Top';
                    $('.chosen_boat').text('Chosen Boat: '+make.text()+' - '+model.text());
                    $('.bsk-measurement').hide();
                    mode = 'CYB';
                    data.result = proceed;
                } else {
                	data.result = false;
                }
		  		return data;

	        });
	        $('#bsk-boatchooser-modal').on('cancel', function(e, data){
	        	console.log('Enter My Own');
                $('#OrderForm-bsk').trigger('setMode', {mode: 'EMM'});
                $('#OrderForm-bsk').trigger('measure', {});
                data.result = true;
	        	return data;
	        });

	  		$('#bsk-boatchooser-modal select').on('change', function() {
	  			var make = $('#boatmake option:selected').val();
	  			var model = $('#boatmodel option:selected').val();
	  			if(make == 0 || model == 0) {
                    $('#bsk-boatchooser-modal .modal-save').prop('disabled', true);
                } else {
                    $('#bsk-boatchooser-modal .modal-save').prop('disabled', false);
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