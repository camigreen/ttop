<h1>Ecommerce</h1>

<script>
	jQuery(function($) {
		$(document).ready(function(){
			ga('require', 'ecommerce');

			ga('ecommerce:addTransaction', <?php echo $this->json; ?>);
			ga('ecommerce:addItem', <?php echo $this->item; ?>)

			ga('ecommerce:send');
		});
	});
</script>