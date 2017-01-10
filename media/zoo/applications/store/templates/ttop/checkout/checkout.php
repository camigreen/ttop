<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$order = $this->order;

$this->app->document->addScript('assets:js/jquery-validate-1.14.1/jquery.validate.min.js');
$this->app->document->addScript('assets:js/jquery-validate-1.14.1/additional-methods.min.js');
$this->user = $order->getUser();
?>
<?php if($this->app->store->merchantTestMode()) : ?>

<div class="uk-width-1-1 uk-margin ttop-checkout">
    <div class="uk-width-1-1 uk-text-center">
        <span class="uk-text-danger uk-text-large testing-mode">TESTING MODE</span>
    </div>
    <div class="uk-width-1-1">
        <button class="uk-button uk-button-primary uk-width-1-3 uk-margin-bottom" data-uk-toggle="{target:'#variables'}">Show/Hide Variables</button>
    </div>
    <div id="variables" class="uk-width-1-1 uk-hidden">
        <?php var_dump($this->app->merchant->getParams()); ?>
        <?php var_dump($order); ?>
        <?php var_dump($this->cart->getAll()); ?>

    </div>
</div>
<?php endif; ?>
<div class="uk-clearfix ttop-checkout-title">
    <img src="<?php echo $this->app->path->url('assets:images/shopping_cart_full_128.png'); ?>" class="uk-align-medium-left" />
    <span class="uk-article-title">Checkout</span>
    <div class='uk-align-right'>
        <!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="d3b7044f-3c16-4fd1-9a4e-708ced7f70c0";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Credit Card Services</a> </div> 
    </div>
</div>
<div class="uk-width-1-1 uk-margin-bottom ttop-checkout-steps" data-uk-grid-margin>
    <ul class="uk-grid ttop-checkout-progress">
        <li class="uk-width-1-4">
            <div id="customer" >Customer<i class="uk-icon-arrow-right uk-align-right"></i></div>
        </li>
        <li class="uk-width-1-4">
            <div id="payment" >Payment Info<i class="uk-icon-arrow-right uk-align-right"></i></div>
        </li>
        <li class="uk-width-1-4">
            <div id="confirm" >Confirm Order<i class="uk-icon-arrow-right uk-align-right"></i></div>
        </li>
        <li class="uk-width-1-4">
            <div id="receipt" >Receipt</div>
        </li>
    </ul>

</div>
<form id="ttop-checkout" class="uk-form" action="/store/checkout" method="post">
    <div class="uk-width-1-1 uk-margin uk-text-center ttop-checkout-pagetitle">
        <div class="uk-article-title"><?php echo $this->title; ?></div>
        <div class="uk-article-lead"><?php echo $this->subtitle; ?></div>
    </div>
    <?php echo $this->partial($this->page,compact('order')); ?>
    <div class="uk-width-1-2 uk-container-center uk-margin-top">
        <div class="uk-grid">
            <?php if ($this->buttons['back']['active']) : ?>
            <div class="uk-width-1-2 uk-container-center">
                <button id="back" class="uk-width-1-1 uk-button uk-button-primary ttop-checkout-step-button" data-next="<?php echo $this->buttons['back']['next']; ?>" <?php echo ($this->buttons['back']['disabled'] ? 'disabled' : '') ?>><?php echo $this->buttons['back']['label']; ?></button>
            </div>
            <?php endif; ?>
            <?php if ($this->buttons['proceed']['active']) : ?>
            <div class="uk-width-1-2 uk-container-center">
                <button id="proceed" class="uk-width-1-1 uk-button uk-button-primary ttop-checkout-step-button" data-next="<?php echo $this->buttons['proceed']['next']; ?>" <?php echo ($this->buttons['proceed']['disabled'] ? 'disabled' : '') ?>><?php echo $this->buttons['proceed']['label']; ?></button>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <input type="hidden" name="task" value="<?php echo $this->task; ?>" />
    <input type="hidden" name="updated" value="false" />
    <input type="hidden" name="process" value="true" />
    <input type="hidden" name="next" />
    <input type="hidden" name="orderID" />
    <input type="hidden" name="bypass" value="0" />
</form>

<div id="processing-modal" class="uk-modal ttop-checkout-processing-modal">
    <div class="uk-modal-dialog ">
        <div class="uk-vertical-align" style="height:110px">
            <div class="uk-width-1-1 uk-text-center uk-vertical-align-middle ttop-checkout-processing-modal-content">
                <span><i class="uk-icon-spinner uk-icon-spin"></i>Processing</span>
                <div class="uk-text small uk-text-center">Please be patient...</div>
                <div class="uk-text-small uk-text-center">Processing your payment may take up to a minute,</div>
                <div class="uk-text-small uk-text-center">please do not hit the back button.</div>
            </div>
        </div>
        
        
    </div>
</div>

<div id="thankyou-modal" class="uk-modal ttop-checkout-thankyou-modal">
    <div class="uk-modal-dialog ">
        <div class="uk-vertical-align" style="height:200px">
            <div class="uk-width-1-1 uk-text-center uk-vertical-align-middle ttop-checkout-thankyou-modal-content">
                <p class="uk-article-title">Your transaction has been approved!</p>
                <p class="uk-article-lead">Thank you for your business.</p>
                <p class="uk-article-lead">Please standby for your receipt.</p>
            </div>
        </div>
        
        
    </div>
</div>


<script>
    jQuery(function($) { 

        var validator = $('#ttop-checkout').validate({
        debug: false,
        ignore: '.ignore',
        errorClass: "validation-fail",
        success: 'valid',
        rules: {
            'elements[billing.name]': {
                minlength: 5
            },
            'elements[shipping.name]': {
                minlength: 5
            },
            'elements[billing.phoneNumber]': {
                phoneUS: true
            },
            'elements[billing.altNumber]': {
                phoneUS: true
            },
            'elements[email]': {
                email: true
            },
            'elements[confirm_email]': {
                email: true,
                equalTo: '#email'
            }

        },
        messages: {
            'elements[confirm_email]': {
                equalTo: 'Your email addresses do not match.'
            }
        }
    });

        var pModal;
        function copyToShipping () {
            var billing = $('fieldset#billing');
            var shipping = $('fieldset#shipping');
            
            billing.find('input, select').each(function(k,v){
                var bName = $(this).prop('name');
                var sName = bName.replace('billing','shipping');
                console.log(sName);
                if($(this).is('select')) {
                    shipping.find('select[name="'+sName+'"]').val($(this).val());
                } else {
                    shipping.find('input[name="'+sName+'"]').val($(this).val());
                }
                $(this).trigger('input');
                
            });
        }
        function clearShipping () {
            $('fieldset#shipping').find('input, select').val('');
        }
        function ProcessingModal (state, payment) {
            var content = '<div class="uk-text-center uk-h2"><i class="uk-icon-spinner uk-icon-spin uk-margin-right"></i>Processing</div>';
            if(payment) {
                content = content + '<div class="uk-text small uk-text-center">Please be patient...</div> \
                    <div class="uk-text-small uk-text-center">Processing your payment may take up to a minute,</div> \
                    <div class="uk-text-small uk-text-center">please do not hit the back button.</div>'
            }
            if($.type(pModal) === 'undefined') {
                pModal = UIkit.modal.blockUI(content);
            }
                
            if (state === 'hide') {
                pModal.hide();
                pModal = null;
            }
        }
        function thankYouModal (state) {
            var modal = UIkit.modal("#thankyou-modal",{center:true,bgclose: false});
                
            if (state === 'hide') {
                modal.hide();
            } else {
                modal.show();
            }
        }
        function verifyCard() {
                console.log('Verifying Card');
                var ccImg = $('.cc-img');
                ccImg.fadeOut();
                ccImg.prop('class','cc-img');
                $('.ttop-checkout-validation-errors').html('');
                var button = $('button#proceed');
                button.html('<i class="uk-icon-spinner uk-icon-spin"></i> Checking Card').prop('disabled',true);
                $.ajax({
                    type: 'POST',
                    url: "?option=com_zoo&controller=store&task=authorizeCard&format=json",
                    data: $('form#ttop-checkout').serialize(),
                    success: function(data){
                        console.log(data);
                        ccImg.addClass(data.card_type);
                        ccImg.fadeIn();
                        if(data.approved) {
                            button.html('Proceed').prop('disabled',false);
                        } else {
                            $('.ttop-checkout-validation-errors').html(data.response.response_reason_text)
                            ccImg.addClass('none');
                            button.html('Proceed');
                        }
                        $('[name="payment[creditCard][cardNumber]"]').val(data.response.account_number);
                        $('[name="payment[creditCard][card_name]"]').val(data.card_name);
                        $('[name="payment[creditCard][card_type]"]').val(data.card_type);
                        $('[name="payment[creditCard][auth_code]"]').val(data.response.transaction_id);
                        var transfer = data.transfer.substring(1, data.transfer.length-1);     
                        $('[name="transfer"]').val(transfer.replace(/\\/g, ""));
                    },
                    error: function(data, status, error) {
                        console.log(status);
                        console.log(error);
                    },
                    dataType: 'json'
                });
        }
        function processPayment() {
                ProcessingModal('show', true);
                return $.ajax({
                    type: 'POST',
                    url: "?option=com_zoo&controller=checkout&task=processPayment&format=json",
                    data: $('form#ttop-checkout').serialize(),
                    dataType: 'json'
                }).promise();
        }
        
        $(document).ready(function(){

            console.log(validator);

            $('#ttop-checkout').FormHandler({
                form: '#ttop-checkout',
                validate: true,
                confirm: true,
                debug: true,
                events: {
                    onInit: [
                        function (e) {
                            var page = $('#page').val();
                            switch(page) {
                                case 'customer':
                                    $('.ttop-checkout-progress li div#customer').addClass('inProgress');
                                    $('.ttop-checkout-progress li div#payment').addClass('incomplete');
                                    $('.ttop-checkout-progress li div#confirm').addClass('incomplete');
                                    $('.ttop-checkout-progress li div#reciept').addClass('incomplete');
                                    break;
                                case 'payment':
                                    $('.ttop-checkout-progress li div#customer').addClass('complete');
                                    $('.ttop-checkout-progress li div#payment').addClass('inProgress');
                                    $('.ttop-checkout-progress li div#confirm').addClass('incomplete');
                                    $('.ttop-checkout-progress li div#reciept').addClass('incomplete');
                                    break;
                                case 'confirm':
                                    $('.ttop-checkout-progress li div#customer').addClass('complete');
                                    $('.ttop-checkout-progress li div#payment').addClass('complete');
                                    $('.ttop-checkout-progress li div#confirm').addClass('inProgress');
                                    $('.ttop-checkout-progress li div#reciept').addClass('incomplete');
                                    break;
                                case 'reciept':
                                    $('.ttop-checkout-progress li div#customer').addClass('complete');
                                    $('.ttop-checkout-progress li div#payment').addClass('complete');
                                    $('.ttop-checkout-progress li div#confirm').addClass('complete');
                                    $('.ttop-checkout-progress li div#reciept').addClass('inProgress');
                                    break;
                            }
                            this.validation = validator;
                            var self = this;
                            $('#proceed.ttop-checkout-step-button').unbind("click").on('click',$.proxy(this,'_submit'));
                            $('[name="same_as_billing"]').on('click',function(e) {
                                var target = $(e.target);
                                if(target.is(':checked')) {
                                    copyToShipping();
                                } else {
                                    clearShipping();
                                }
                                $('fieldset#shipping').find('input, select').each(function (k, v) {
                                    validator.element($(this));
                                })

                            });
                            $('#back.ttop-checkout-step-button').unbind("click").on("click",function(e){
                                e.preventDefault();
                                $('[name="process"]').val(false);
                                $('input[name="task"]').val($(e.target).data('next'));
                                $('input[name="next"]').val($(e.target).data('next'));
                                self.$element.find('input, select').addClass('ignore');
                                $(this).closest('form').submit();
                            });

                            $('#add_coupon.ttop-checkout-button').unbind("click").on("click",function(e){
                                e.preventDefault();
                                $('input[name="task"]').val($(e.target).data('task'));
                                $('input[name="next"]').val($(e.target).data('next'));
                                self.$element.find('input, select').addClass('ignore');
                                $(this).closest('form').submit();
                            });

                            $('.update-qty').on('click',function(e){
                                var elem = $(this), sku = $(this).closest('tr').prop('id'), qty = $(this).closest('tr').find('input[name="qty"]').val();
                                e.preventDefault();
                                ProcessingModal();
                                $.ajax({
                                    type: 'POST',
                                    url: "?option=com_zoo&controller=cart&task=updateQty&format=json",
                                    data: {job: 'updateQty', sku: sku, qty: qty},
                                    success: function(data){
                                        console.log(data);
                                        $('input[name="next"]').val('payment');
                                        self.$element.find('input, select').addClass('ignore');
                                        elem.closest('form').submit();
                                    },
                                    error: function(data, status, error) {
                                        console.log(status);
                                        console.log(error);
                                    },
                                    dataType: 'json'
                                });
                            })

                            $('#shipping_method').on('change', function (e) {
                                console.log($(this).val());
                                if($(this).val() !== '' && $(this).val() !== 'LP') {
                                    $('fieldset#shipping').find('input, select').each(function () {
                                        if($(this).prop('id') !== 'shipping.altNumber' && $(this).prop('id') !== 'shipping.street2') {
                                            $(this).rules('add', 'required');
                                        }
                                    })
                                } else {
                                    $('fieldset#shipping').find('input, select').each(function () {
                                        $(this).rules('remove', 'required');
                                        self.validation.element( $(this) );
                                    })
                                }
                                self.validation.form();
                            })

                            $('.trash-item').on('click',function(e){
                                var elem = $(this), sku = $(this).closest('tr').prop('id');
                                e.preventDefault();
                                ProcessingModal();
                                $.ajax({
                                    type: 'POST',
                                    url: "?option=com_zoo&controller=store&task=cart&format=json",
                                    data: {job: 'remove', sku: sku},
                                    success: function(data){
                                        console.log(data);
                                        $('input[name="step"]').val('payment');
                                        elem.closest('form').submit();
                                    },
                                    error: function(data, status, error) {
                                        console.log(status);
                                        console.log(error);
                                    },
                                    dataType: 'json'
                                });
                                
                                
                            });
                            $('button.ttop-checkout-printbutton').on('click',function(e){
                                e.preventDefault();
                                console.log($(this).data('id'));
                                $.ajax({
                                    type: 'POST',
                                    url: "?option=com_zoo&controller=store&task=getReceipt",
                                    data: {id: $(this).data('id')},
                                    success: function(data){
                                        console.log(data);
                                        window.open(data.url);
                                    },
                                    error: function(data, status, error) {
                                        console.log(status);
                                        console.log(error);
                                    },
                                    dataType: 'json'
                                });
                                
                                
                            });

                            $('#localPickup').on('click',function(e){
                            });
                            //localPickup();
                            return true;
                        }
                    ],
                    beforeSubmit: [
                        function (e) {
                            var dfd = $.Deferred();
                            if ($(e.target).data('next') === 'processPayment') {
                                if (!$('[name="TC_Agree"]').prop('checked')) {
                                    alert('Please read and agree to the terms and conditions.');
                                    return false;
                                }
                                $.when(processPayment()).done(function(data){   
                                    if (data.approved) {
//                                        sendTransactionToGoogle(data);
                                        $('input[name="task"]').val('receipt');
                                        $('input[name="orderID"]').val(data.orderID);
                                        ProcessingModal('hide');
                                        thankYouModal('show');
                                        setTimeout(function(){
                                            dfd.resolve(true);
                                        },5000);
                                    } else {
                                        $( ".ttop-checkout-validation-errors" ).html( data.message );
                                        ProcessingModal('hide');
                                        alert(data.message);
                                        dfd.resolve(false);
                                    }
                                });
                            } else {
                                $('input[name="next"]').val($(e.target).data('next'));
                                console.log($(e.target).data('next'));
                                return true;
                            }
                            return dfd.promise();
                            
                            
                        }
                    ],
                    onChanged: [
                        function(e) {
                            var target = $(e.target);
                            switch (target.prop('name')) {

                            }
                            return true;
                        }
                    ]
                }
            });
        });
        
    });
    
    
</script>
