<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */

// Get Variables
$fieldtype = $node->attributes()->option ? ' item-option' : '';
$xml = simplexml_load_file($this->app->path->path('fields:config.xml'));
$optionData = array(
	'name' => (string) $node->attributes()->name,
	'label' => (string) $node->attributes()->label,
	'type' => (string) $node->attributes()->option
);
foreach ($xml->field as $field) {
	if((string) $field->attributes()->name == $name) {
		$optionData['visible'] = (string) $xml->attributes()->visible == 'true' ? true : false;
		$options['0'] = '- SELECT -'; 
		foreach($field->option as $option) {
			$options[(string) $option->attributes()->value] = (string) $option;
		}
	}
}
// Set Attributes
$attributes['id'] = $id;
$attributes['name'] = $name;
$class = 'uk-width-1-1';
$class .= $fieldtype;

if(!isset($options)) {
	echo 'Error - No Options Available.';
	return;
}

$attributes['class'] = $class;
$attributes['data-option'] = json_encode($optionData);

$disabled = $disabled ? $disabled : !$user->canEdit($assetName);
if($disabled) {
	$attributes['disabled'] = true;
}
printf('<select %s>', $this->app->field->attributes($attributes));

foreach ($options as $key => $option) {

	// set attributes
	$attributes = array('value' => $key);

	// is checked ?
	if ($key == $value) {
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
<script>
jQuery(function($){
	$(document).ready(function(){
	    $( "#poling-platform-slider-range-min" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 50,
			slide: function( event, ui ) {
			$( "#poling-platform-height" ).val( ui.value );
			}
	    });
	    $( "#poling-platform-height" ).val( $( "#poling-platform-slider-range-min" ).slider( "value" ) );

	    $('#<?php echo $id; ?>').on('change', function(e) {
	    	console.log('change');
	    	if($(this).val() == 'y') {
	    		$('#poling-platform-slider').removeClass('uk-hidden');
	    	} else {
	    		$('#poling-platform-slider').addClass('uk-hidden');
	    	}
	    })
	});
});
</script>