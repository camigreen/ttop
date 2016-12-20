<?php 
    $items = $order->elements->get('items.');
?>
<table id="item-default-table" class="uk-table">
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
                    <div class="table-item-name"><?php echo $item->name ?></div>
                    <div class="table-item-description"><?php echo $item->description ?></div>
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
                <td class="ttop-checkout-item-total">
                    <div><?php echo $item->qty ?></div>             
                </td>
                <td class="ttop-checkout-item-total">
                    <?php echo $item->getTotalPrice('charge', true); ?>
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
                    <?php echo $this->app->number->currency($order->getSubtotal('charge'),array('currency' => 'USD')); ?>
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