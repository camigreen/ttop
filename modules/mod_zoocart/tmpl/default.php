<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = $zoo->customer->getUser();
$cart = $zoo->cart;
$count = $cart->getItemCount();
?>

<ul id="cart-module" class="uk-list uk-hidden-small uk-navbar-flip">
    <li class="uk-parent" data-uk-dropdown>
        <a href="#">
            <div class="uk-grid"> 
                <div class="uk-width-1-1">
                    <span class="icon"></span>
                    <span class="currency" data-cart="currency">$</span>
                    <span data-cart="total"><?php echo $cart->getTotal(); ?></span>
                    <span data-cart="quantity">(<?php echo $count; ?> <?php echo $count > 1 ? 'Items)' : 'Item)'; ?></span>
                </div>
            </div>
        </a>
    </li>
</ul>
<div id="cart-modal" class="uk-modal">
</div>
<script>
jQuery(function($){
    $(document).ready(function(){
        lpiCart.init();
    })
})
</script>





