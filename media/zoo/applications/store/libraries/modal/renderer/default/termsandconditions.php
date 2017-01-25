<?php 

$article = JTable::getInstance("content"); 
$article->load(22); // Get Article ID  
 

?>

<div class="uk-grid">
	<div class="uk-width-1-1 uk-margin-top">
		<?php echo $article->get('introtext'); ?>
	</div>
</div>

<script>
	jQuery(function($){
		$(document).ready(function(){
			$('#default-termsandconditions-modal').on('save', function(e){
				$('[name="TC_Agree"]').prop('checked', true);
			});
			$('#default-termsandconditions-modal').on('cancel', function(e){
				$('[name="TC_Agree"]').prop('checked', false);
			});
		})
	})
</script>