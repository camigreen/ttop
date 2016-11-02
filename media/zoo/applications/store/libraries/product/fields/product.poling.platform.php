<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// Get Variables
$product = $parent->getValue('product');
$xml = simplexml_load_file($this->app->path->path('fields:/'.$product->type.'/config.xml'));

$fieldOptions = (string) $node->attributes()->options ? (string) $node->attributes()->options : $name;

$opt = $product->getOption($fieldOptions);
if($opt) {
	$value = $opt->getValue();
}
foreach ($xml->field as $field) {
	if((string) $field->attributes()->name == $name) {
		$options['0'] = '- SELECT -'; 
		foreach($field->option as $option) {
			$options[(string) $option->attributes()->value] = (string) $option;
		}
	}
}
// Set Attributes
$attributes['id'] = $id;
$attributes['name'] = $name.'-select';
$class = 'uk-width-1-1';

if(!isset($options)) {
	echo 'Error - No Options Available.';
	return;
}
$attributes['class'] = $class;

$disabled = $disabled ? $disabled : !$user->canEdit($assetName);
if($disabled) {
	$attributes['disabled'] = true;
}
printf('<select %s>', $this->app->field->attributes($attributes));

foreach ($options as $key => $option) {

	// set attributes
	$attributes = array('value' => $key);
	// is checked ?
	if ($key === $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option));
}

printf('</select>');

?>

<div class="uk-width-1-1 uk-margin-top">
	<div id="poling-platform-slider" class="uk-width-1-1 uk-container-center uk-hidden">
		<label>My poling platform is <input type="text" readonly style="border:0; font-weight:bold; width: 40px; font-size:20px;" id="poling-platform-height" class="uk-text-danger uk-text-center" /> inches high.</label>
		<div id="poling-platform-slider-range-min"></div>
		<div class="uk-text-small uk-text-center"><i class="uk-icon-arrow-left uk-margin-right"></i>Slide the bar to adjust the poling platform height.<i class="uk-icon-arrow-right uk-margin-left"></i></div>
	</div>
</div>
<input type="hidden" class="item-option" name="poling_platform" value="<?php echo ($value !== 0 ? '' : 'N'); ?>" />
<script>
jQuery(function($){
	$(document).ready(function(){
	    $( "#poling-platform-slider-range-min" ).slider({
			range: "min",
			value: <?php echo $value == 'N' ? 0 : $value; ?>,
			min: 0,
			max: 50,
			slide: function( event, ui ) {
				$( "#poling-platform-height" ).val( ui.value );
				
			}, 
			change: function(event, ui) {
				if(ui.value === 0) {
					$( '[name="poling_platform"]' ).val( 'N' ).trigger('input');
				} else {
					$( '[name="poling_platform"]' ).val( ui.value ).trigger('input');
				}
			}
	    });
	    $( "#poling-platform-height" ).val( $( "#poling-platform-slider-range-min" ).slider( "value" ) );

	    $('#<?php echo $id; ?>').on('change', function(e) {
	    	if($(this).val() == 'Y') {
	    		$('#poling-platform-slider').removeClass('uk-hidden');
	    		$( '[name="poling_platform"]' ).val($( "#poling-platform-slider-range-min" ).slider( "value" )).trigger('input');

	    	} else {
	    		$('#poling-platform-slider').addClass('uk-hidden');
	    		$( '[name="poling_platform"]' ).val( 'N' ).trigger('input');
	    	}
	    })
	});
});
</script>