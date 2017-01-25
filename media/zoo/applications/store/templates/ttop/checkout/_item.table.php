<?php
    if(isset($this->items)) {
        $items = $this->items;
    } else {
        $items = $order->elements->get('items.');
    }
?>
<table class="uk-table uk-hidden-small">
    <thead>
        <tr>
            <th class="uk-width-7-10">Item Name</th>
            <th class="uk-width-2-10">Quantity</th>
            <th class="uk-width-1-10">Price</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $hash => $item) : ?>
            <tr id="<?php echo $hash; ?>">
                <td>
                    <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                    <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                    <?php if(count($item->getOptions()) > 0) : ?>
                    <span class="options-closed uk-text-small" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-plus-square-o"></i> View Options</span>
                    <span class="options-open uk-text-small uk-hidden" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-minus-square-o"></i> Hide Options</span>
                    <div class="options-container uk-width-2-3 uk-hidden">
                        <table class="uk-table uk-table-condensed uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-3">
                                        Option
                                    </th>
                                    <th class="uk-width-2-3">
                                        Value
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach($item->getOptions() as $option) : ?>
                        <?php if($option->get('visible')) : ?>
                            <tr>
                                <td class="uk-text-small"><?php echo $option->get('label'); ?></td>
                                <td class="uk-text-small <?php echo $option->get('name') == 'add_info' ? 'uk-text-left' : ''; ?>"><?php echo $option->get('text'); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                    <?php endif; ?>
                </td>
                <?php if($page != 'payment') : ?>
                    <td class="ttop-checkout-item-total">
                        <div><?php echo $item->qty ?></div>             
                    </td>
                <?php else : ?>
                    <td class="ttop-checkout-item-total">
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <input type="number" class="uk-width-medium-1-3 uk-width-small-1-1 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                                <button class="uk-button uk-button-primary update-qty">Update</button> 
                            </div>
                        </div>               
                    </td>
                <?php endif; ?>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('display', true); ?>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Subtotal:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getSubTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Shipping:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getShippingTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Sales Tax:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getTaxTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="uk-text-right">
                    Total Balance Due:
                </td>
                <td>
                    <?php echo $this->app->number->currency($order->getTotal(),array('currency' => 'USD')); ?>
                </td>
            </tr>
        </tfoot>
</table>

<div class="uk-grid-small uk-visible-small checkout-small" data-uk-grid-margin>
    <?php foreach ($items as $hash => $item) : ?>
        <div class="uk-width-1-1">
            <div id="<?php echo $hash; ?>" class="uk-panel uk-panel-box checkout-item">
                <div class="uk-grid">
                    <div class="uk-width-1-2 checkout-item-name"><?php echo $item->name; ?></div>
                    <div class="uk-width-1-2 checkout-item-price uk-text-right"><?php echo $this->app->number->currency($item->getTotalPrice(), array('currency' => 'USD')); ?></div>
                    <div class="uk-width-1-1 checkout-item-description"><?php echo $item->description; ?></div>
                    <?php if(count($item->getOptions()) > 0) : ?>
                    <div class="uk-width-1-1">
                        <span class="options-closed uk-text-small" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-plus-square-o"></i> View Options</span>
                        <span class="options-open uk-text-small uk-hidden" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-minus-square-o"></i> Hide Options</span>
                        <div class="options-container uk-width-1-1 uk-hidden">
                            <div class="uk-grid">
                                <?php foreach($item->getOptions() as $option) : ?>
                                <?php if($option->get('visible')) : ?>
                                    <span class="uk-width-1-2 checkout-item-option"><?php echo $option->get('label'); ?>:</span>
                                    <span class="uk-width-1-2 checkout-item-option-value <?php echo $option->get('name') == 'add_info' ? 'uk-text-left' : ''; ?>"><?php echo $option->get('text'); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($page == 'payment') : ?>
                        <div class="uk-width-2-3 checkout-item-qty">Qty: <input type="number" name="item-qty" inputmode="numeric" pattern="[0-9]*" title="Non-negative integral number" value="<?php echo $item->getQty(); ?>" min="0" /></div>
                    <?php else : ?>
                        <div class="uk-width-2-3 checkout-item-qty">Qty: <?php echo $item->getQty(); ?></div>
                    <?php endif; ?>
                    <div class="uk-width-1-3 checkout-item-remove uk-text-right"><span class="uk-icon uk-icon-trash"></span></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="uk-width-1-1">
        <div class="uk-grid checkout-totals">
            <div class="uk-width-2-3 uk-text-right">Subtotal:</div>
            <div class="uk-width-1-3 uk-text-right checkout-currency"><?php echo $this->app->number->currency($order->getSubTotal(),array('currency' => 'USD')); ?></div>
            <div class="uk-width-2-3 uk-text-right">Tax:</div>
            <div class="uk-width-1-3 uk-text-right checkout-currency"><?php echo $this->app->number->currency($order->getTaxTotal(),array('currency' => 'USD')); ?></div>
            <div class="uk-width-2-3 uk-text-right">Total:</div>
            <div class="uk-width-1-3 uk-text-right checkout-currency checkout-total"><?php echo $this->app->number->currency($order->getTotal(),array('currency' => 'USD')); ?></div>
        </div>
    </div>
</div>
