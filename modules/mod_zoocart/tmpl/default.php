<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = $zoo->customer->getUser();
$cart = $zoo->cart;
$count = $cart->getItemCount();
?>


<div class="cart cart-large uk-hidden-small">
    <a href="#">
        <span class="currency" data-cart="currency">$<span data-cart="total"><?php echo $cart->getTotal(); ?></span></span>
        <span class="cart-icon">
            <span class="cart-count single-digit" data-cart="quantity"><?php echo $count; ?></span>
        </span>
    </a>
</div>
<div class="cart cart-small uk-visible-small">
    <a class="cart-icon" href="#">
        <span class="cart-count single-digit" data-cart="quantity"><?php echo $count; ?></span>
    </a>
</div>
    
<div id="cart-modal" class="uk-modal">
</div>
<script>
jQuery(function($){
    $(document).ready(function(){
        lpiCart.init();
    })
})
</script>





