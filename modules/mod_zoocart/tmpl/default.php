<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = $zoo->customer->getUser();
$testMode = $zoo->merchant->testMode();
?>

<ul id="cart-module" class="uk-list uk-hidden-small uk-navbar-flip">
    <li class="uk-parent" data-uk-dropdown>
        <a href="#">
            <div class="uk-grid"> 
                <div class="uk-width-1-1">
                    <span class="icon"></span>
                    <span class="currency">$</span>
                    <span data-cart="total">0.00</span>
                    <span class="items">(<span data-cart="quantity">0</span> Items)</span>
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





