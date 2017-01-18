<?php 

?>

<div class="uk-width-1-1 uk-text-center uk-vertical-align-middle ttop-checkout-thankyou-modal-content">
    <p class="uk-article-title">Your transaction has been approved!</p>
    <p class="uk-article-lead">Thank you for your business.</p>
    <p class="uk-article-lead">Please standby for your receipt.</p>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
    	$('#default-purchase-thankyou-modal').on('loaded', function(e, data){
    		setTimeout(function(){ 
    			$("#default-purchase-thankyou-modal").hide();
    		}, 5000);
    	});

    });
});
</script>