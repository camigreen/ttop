<script>
	jQuery(function($) {
		var gtm = <?php echo $gtm; ?>;
		console.log(gtm);
		$(document).ready(function(){
			dataLayer.push(gtm);
		});
	});
</script>