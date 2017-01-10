<h1>Ecommerce</h1>

<script>
	jQuery(function($) {
		var transaction = <?php echo $google['transaction']; ?>;
		var items = <?php echo $google['items']; ?>;
		console.log(transaction);
		console.log(items);
		$(document).ready(function(){
			ga('require', 'ecommerce');

			ga('ecommerce:addTransaction', transaction);

			$.each(items, function(k, item) {
				console.log(item);
				ga('ecommerce:addItem', item);
			}) 

			ga('ecommerce:send');
			ga('ecommerce:clear');
		});
	});
</script>