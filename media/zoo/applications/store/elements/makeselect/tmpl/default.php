<?php 
$style = '';

?>
<div class="row">
	<div class="row">
		<select name="<?php echo $this->getControlName('make'); ?>">
			<?php echo implode("\n", $options['make']); ?>
		</select>
	</div>
	<div class='row'>
		<select name="<?php echo $this->getControlName('model'); ?>" <?php echo $disabled ? 'disabled' : ''; ?>>
			<?php echo implode("\n", $options['model']); ?>
		</select>
	</div>
</div>

<script>

jQuery(function($) {

	$(document).ready(function() {
		$('[name="<?php echo $this->getControlName('make'); ?>"]').on('change', function(e) {
			console.log('changes');
			var elem = $('[name="<?php echo $this->getControlName('model'); ?>"]');
			$.ajax({
				type: 'POST',
				url: location.origin+'?option=com_zoo&controller=product&task=getBoatModels&format=raw',
				data: { make: $(e.target).val() },
				success: function(data) {
					elem.html('');
					elem.prop('disabled', false);
					elem.append('<option value="">- Select Model -</option>');
					$.each(data, function(k, v){
						elem.append('<option value="'+k+'">'+v.label+'</option>');
					})
					console.log(data);
				}
			})
		})

	});
});

</script>