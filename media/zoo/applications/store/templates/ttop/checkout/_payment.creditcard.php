<?php
    $elements = $order->elements;
    $params = $order->params;
?>
<div class="uk-grid">
    <div class="uk-width-1-1 uk-text-center">
        We Accept
        <img class="uk-align-center" style="width:225px;" src="images/cc/cc_all.png" />
    </div>
    <div class="uk-width-1-1">
        <label>Card Number</label>

        <input type="text" name="creditcard[cardNumber]" class="ttop-checkout-field required" placeholder="Credit Card Number" value='<?php echo $params->get('payment.creditcard.cardNumber') ?>'/>
    </div>
    <div class="uk-width-1-1">
        <div class="uk-grid">
            <div class="uk-width-medium-2-6 uk-width-small-1-1">
                <label>Exp Month</label>
                <?php echo $this->app->field->render('ccmonthlist', 'expMonth', $params->get('payment.creditcard.expMonth'), null, array('control_name' => 'creditcard', 'class' => 'ttop-checkout-field required uk-width-1-1')); ?>
            </div>
            <div class="uk-width-medium-2-6 uk-width-small-1-1">
                <label>Exp Year</label>
                <?php echo $this->app->field->render('ccyearlist', 'expYear', $params->get('payment.creditcard.expYear'), null, array('control_name' => 'creditcard', 'class' => 'ttop-checkout-field required uk-width-1-1')); ?>
            </div>
            <div class="uk-width-medium-2-6 uk-width-small-1-1">
                <label>CVV Code</label>
                <input id="card_code" type="text" name="creditcard[card_code]" class="ttop-checkout-field required" placeholder="CVV Number" value='<?php echo $params->get('payment.creditcard.card_code'); ?>'/>
            </div>
        </div>
    </div>
</div> 
<div class="uk-width-1-3">
    <input type="hidden" name="creditCard[auth_code]" value="<?php echo $params->get('payment.creditcard.auth_code'); ?>"/>
    <input type="hidden" name="creditCard[card_type]" value="<?php echo $params->get('payment.creditcard.card_type'); ?>" />
    <input type="hidden" name="creditCard[card_name]" value="<?php echo $params->get('payment.creditcard.card_name'); ?>" />
</div>
<script>
jQuery(function($) {
    $(document).ready(function(){
        // $('[name="creditCard[cardNumber]"]').rules({
        //         creditcard: true
        // })
        $('#card_code').rules('add',{
            minlength: 3
        });  
    });
})
</script>