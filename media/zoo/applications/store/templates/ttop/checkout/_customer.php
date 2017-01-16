<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$elements = $this->order->elements;
?>
<div class="uk-width-1-1"> 
    <div class="uk-grid">
        <div class="uk-width-medium-1-2 uk-width-small-1-1">
            <?php $this->form->setValues($elements); ?>
            <?php if($this->form->checkGroup('billing')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('billing')?>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-medium-1-2 uk-width-small-1-1">
            <?php if($this->form->checkGroup('shipping')) : ?>
                <div class="uk-form-row">
                    <legend>Shipping Address<label class="uk-text-small uk-margin-left uk-hidden-small"><input type="checkbox" class="ttop-checkout-field same_as_billing" name="same_as_billing" style="height:15px; width:15px;" />Same as billing</label></legend>
                    <div class="uk-visible-small">
                        <label class="uk-text-small"><input type="checkbox" class="ttop-checkout-field same_as_billing" name="same_as_billing" style="height:15px; width:15px;" />Same as billing</label>
                    </div>
                    <?php echo $this->form->render('shipping')?>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-width-medium-1-2 uk-width-small-1-1">
        <?php if(!$this->user->isReseller()) : ?>
            <?php if($this->form->checkGroup('email-address')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('email-address')?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        </div>
        <div class="uk-width-medium-1-2 uk-width-small-1-1">    
            <?php if($this->form->checkGroup('shipping_selection')) : ?>
                <div class="uk-form-row">
                    <?php echo $this->form->render('shipping_selection')?>
                </div>
            <?php endif; ?>
        </div> 
    </div>
</div>
<input type="hidden" name="elements[referral]" value="<?php echo $order->elements->get('referral'); ?>"/>
<script>
jQuery(function($){
    $(document).ready(function(){})
})
</script>