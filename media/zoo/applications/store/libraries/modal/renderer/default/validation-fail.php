<?php 
$fields = array();
foreach($config->fields as $field) {
	$fields[] = $field['label'];	
}
?>

<div class="uk-grid">
	<div class="uk-width-1-1 uk-text-center">
		<?php echo $config['message']; ?>
	</div>
	<div class="uk-width-1-1 uk-text-center">
		<ul class="uk-list uk-text-danger">
			<?php foreach($fields as $field) : ?>
				<li><?php echo $field; ?></li>	
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#default-validation-fail-modal').on('save', function(e){
				
			});
			$('#default-validation-fail-modal').on('cancel', function(e){
				
			});
		})
	})
</script>