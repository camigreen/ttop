<?php
/**
 * @package   com_zoo
 * @author    YOOtheme http://www.yootheme.com
 * @copyright Copyright (C) YOOtheme GmbH
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

echo '<div>';
$makes = $this->app->boat->getBoatMakes();
$options = array();
$options[] = '- Select -';

foreach($makes as $make) {
	$options[$make->name] = $make->label;
}
printf('<div %s>', $this->app->field->attributes(array('class' => 'row')));
printf('<select %s>', $this->app->field->attributes(compact('name', 'class')));

foreach ($options as $key => $option) {

	// set attributes
	$attributes = array('value' => $key);

	// is checked ?
	if ($key == $value) {
		$attributes['selected'] = 'selected';
	}

	printf('<option %s>%s</option>', $this->app->field->attributes($attributes), JText::_($option));
}

printf('</select></div>');
printf('<div %s>', $this->app->field->attributes(array('class' => 'row')));
printf('<select %s>', $this->app->field->attributes(array('name' => 'model')));
printf('<option %s>%s</value>', 'value="0"', JText::_('- Select -'));
printf('</select></div>');
echo '</div>';
?>

<script>

jQuery(function($){
	$(document).ready(function(){
		$('select[name="make"]').on('change', function(){
			$.ajax({
				type: 'POST',
				url: '?option=com_zoo&controller=product&task=getBoatModels&format=raw',
				data: {make: $('select[name="make"]').val()},
				success: function(data) {
					console.log(data);
				}
			})
		})
		var elem = $('select[name="model"]');
	});
});

</script>