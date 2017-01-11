<?php
/**
 * @package   com_zoo.store
 * @author    Shawn Gibbons
 */
$options = array(
	'' => '- SELECT -',
	'google' => 'Google Search',
	'THT' => 'thehulltruth.com',
	'friend' => 'Friend',
	'facebook' => 'Facebook',
	'youtube' => 'YouTube',
	'other' => 'Other'
);
$opts = array();
foreach ($options as $key => $option) {

	// set attributes
	$attributes = array('value' => $key);

	$opts[] = sprintf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option));
}


$name = 'referral';
// Set Attributes
$attributes['id'] = 'checkout.referral.select';
$attributes['name'] = $name;
$class = 'uk-width-1-1';
$class .= ' required';

$attributes['class'] = $class;

$select = sprintf('<select %s>%s</select>', $this->app->field->attributes($attributes), implode("\n", $opts));
?>

<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-form uk-width-1-2 uk-container-center">
		<?php echo $select; ?>
	</div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){

		$('#checkout-referral-modal').on('save', function(e, data){
			console.log('Save');
			console.log(data);
			var value = $('[name="referral"]').val();
			$('[name="elements[referral]"]').val(value);
			$('button#proceed').trigger('click');
        });
	})

})
</script>