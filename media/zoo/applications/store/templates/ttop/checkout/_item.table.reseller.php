<?php 
    $items = $order->elements->get('items.');
?>
<table id="item-reseller-table" class="uk-table">
    <thead>
        <tr>
            <th class="uk-width-4-10">Item Name</th>
            <th>Quantity</th>
            <th class="uk-width-1-10">MSRP</th>
            <th class="uk-width-1-10">Customer Retail Price</th>
            <th class="uk-width-1-10">Dealer's Price</th>
            <th class="uk-width-1-10">Dealer Profit</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $hash => $item) : ?>
            <?php $price = $item->getPrice(); ?>
            <tr id="<?php echo $hash; ?>">
                <td>
                    <div class="ttop-checkout-item-name"><?php echo $item->name ?></div>
                    <div class="ttop-checkout-item-description"><?php echo $item->description ?></div>
                    <?php if(count($item->getOptions()) > 0) : ?>
                    <span class="options-closed uk-text-small" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-plus-square-o"></i> View Options</span>
                    <span class="options-open uk-text-small uk-hidden" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-minus-square-o"></i> Hide Options</span>
                    <div class="options-container uk-width-1-1 uk-hidden">
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
                        <?php if($option->get('visible') == 'true') : ?>
                            <tr>
                                <td class="uk-text-small"><?php echo $option->get('label'); ?></td>
                                <td class="uk-text-small <?php echo $option->get('name') == 'add_info' ? 'uk-text-left' : ''; ?>"><?php echo $option->get('text', 'Empty'); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                    <?php endif; ?>
                </td>
                <?php if($this->page != 'payment') : ?>
                    <td class="ttop-checkout-item-total uk-width-1-10">
                        <?php echo $item->qty ?>         
                    </td>
                <?php else : ?>
                    <td class="ttop-checkout-item-total uk-width-2-10">
                        <input type="number" class="uk-width-1-3 uk-text-center" name="qty" value="<?php echo $item->qty ?>" min="1"/>
                        <button class="uk-button uk-button-primary update-qty">Update</button>                
                    </td>
                <?php endif; ?>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('msrp', true); ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('customer', true); ?>
                    <?php echo '<p class="uk-text-small">('.$this->app->number->toPercentage($item->getMarkupRate('reseller'),0).' Markup)</p>'; ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('reseller', true); ?>
                    <?php echo '<p class="uk-text-small">('.$this->app->number->toPercentage($item->getDiscountRate(), 0).' Discount)</p>'; ?>
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('profit', true); ?>
                    <?php echo '<p class="uk-text-small">('.$this->app->number->toPercentage($item->getPrice('profitRate')*100, 0).' Profit)</p>'; ?>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="uk-text-right">
                Subtotal:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getSubtotal('reseller'),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Shipping:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getShippingTotal(),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Sales Tax:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getTaxTotal(),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Total:
            </td>
            <td>
                <?php echo $this->app->number->currency($order->getTotal('reseller'),array('currency' => 'USD')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="uk-text-right">
                Dealer's Balance Due:
            </td>
            <td>
                <?php 
                    $balance = $order->params->get('payment.status') >= 3 ? 0 : $order->getTotal('reseller');
                    echo $this->app->number->currency($balance,array('currency' => 'USD')); 
                ?>
            </td>
        </tr>
    </tfoot>
</table>