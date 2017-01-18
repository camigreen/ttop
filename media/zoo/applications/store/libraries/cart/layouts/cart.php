<?php 
?>
<div class="uk-hidden-small">
    <div class="uk-modal-dialog uk-modal-dialog-large">
        <div class="uk-panel uk-panel-box">
            <h3 class="uk-panel-title">Shopping Cart</h3>
                <table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
                    <thead>
                        <tr>
                            <th class="uk-width-5-10">Item</th>
                            <th class="uk-width-2-10">Quantity</th>
                            <th class="uk-width-2-10">Price</th>
                            <th class="uk-width-1-10"></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if($data['count'] === 0) : ?>
                    		<tr>
                    			<td colspan="4" class="uk-text-center">You have no items in your cart!</td>
                    		</tr>
                    	<?php else : ?>
    	                	<?php foreach($data['items'] as $hash => $item) : ?>
    	                	<tr id="<?php echo $hash; ?>">
    	                		<td class="product">
                                    <div class="name">
                                        <?php echo $item->get('name'); ?>
                                    </div>
    	                			<div class="description">
                                        <?php echo $item->get('description'); ?>
                                    </div>
    	                			<div class="uk-margin-left">
    	                			<?php if(count($item->get('options.', array())) > 0) : ?>
    	                				<span class="options-closed uk-text-small" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-plus-square-o"></i> View Options</span>
    	                				<span class="options-open uk-text-small uk-hidden" data-uk-toggle="{target:'#<?php echo $hash; ?> .options-container,#<?php echo $hash; ?> .options-closed,#<?php echo $hash; ?> .options-open'}"><i class="uk-icon uk-icon-minus-square-o"></i> Hide Options</span>
    	                				<div class="options-container uk-width-1-1 uk-grid uk-hidden">
    	                				<?php foreach($item->get('options.', array()) as $label => $value) : ?>
    										<div class="uk-width-1-2 uk-text-small"><?php echo $label; ?></div>
    		                				<div class="uk-width-1-2 uk-text-small"><?php echo $value ? $value : 'Empty'; ?></div>
    	                				<?php endforeach; ?>
    	                				</div>
    	                			<?php endif; ?>
    	                			</div>
    	                		</td>
    	                		<td class="qty">
    	                			<input type="number" class="uk-text-center" value="<?php echo $item->get('qty'); ?>" min="0" style="width:70px;" /><button class="uk-button uk-button-small uk-button-primary uk-margin-left updateQty">Update</span>
    	                		</td>
    	                		<td class="price">
    	                			<?php echo $this->app->number->currency($item->get('price'), array('currency' => 'USD')); ?>
    	                		</td>
    	                		<td>
    	                			<i class="uk-icon uk-icon-trash trash" data-uk-tooltip title="Remove this item"></i>
    	                		</td>
    	                	</tr>
    	                	<?php endforeach; ?>
    	                <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="uk-text-right" colspan="2">Total</td>
                            <td class="item-total uk-text-bold uk-text-large"><?php echo $this->app->number->currency($data['total'], array('currency' => 'USD')); ?></td>
                        </tr>
                    </tfoot>
                </table>
            <div class="uk-width-medium-1-1">
                <div class="uk-align-right uk-visible-large">
                    <button class="uk-button uk-button-primary continue"><?php echo JText::_('CART_CONTINUE_SHOPPING_BUTTON'); ?></button>
                    <button class="uk-button uk-button-primary checkout" <?php echo $data['count'] === 0 ? 'disabled' : '' ?> ><?php echo JText::_('CART_CHECKOUT_BUTTON'); ?></button>
                    <button class="uk-button uk-button-primary clear" <?php echo $data['count'] === 0 ? 'disabled' : '' ?> ><?php echo JText::_('CART_EMPTY_CART_BUTTON'); ?></button>
                </div>
                <div class="uk-visible-small uk-text-center">
                    <button class="uk-button uk-button-primary continue"><?php echo JText::_('CART_CONTINUE_SHOPPING_BUTTON'); ?></button>
                    <button class="uk-button uk-button-primary checkout" <?php echo $data['count'] === 0 ? 'disabled' : '' ?> ><?php echo JText::_('CART_CHECKOUT_BUTTON'); ?></button>
                    <button class="uk-button uk-button-primary clear" <?php echo $data['count'] === 0 ? 'disabled' : '' ?> ><?php echo JText::_('CART_EMPTY_CART_BUTTON'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="uk-visible-small ttop cart-small">
    <div class="uk-modal-dialog uk-modal-dialog-large">
        <div class="uk-grid uk-grid-small" data-uk-grid-margin>
            <div class="uk-width-1-1">
                <div class="cart-title">Your Cart</div>
            </div>
            <?php if($data['count'] === 0) : ?>
                <div class="uk-width-1-1">
                    <div class="uk-panel uk-panel-box">
                        <div class="cart-message">You have no items in your cart!</div>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach($data['items'] as $hash => $item) : ?>
                <div class="uk-width-1-1">
                    <div id="<?php echo $hash; ?>" class="uk-panel uk-panel-box">
                        <div class="cart-item-name"><?php echo $item->get('name'); ?></div>
                        <div class="cart-item-description"><?php echo $item->get('description'); ?></div>
                        <div class="cart-item-price"><?php echo $this->app->number->currency($item->get('price'), array('currency' => 'USD')); ?></div>
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-1-3">
                                <input type="number" name="qty" inputmode="numeric" pattern="[0-9]*" title="Non-negative integral number" class="uk-width-1-1" min="0" value="<?php echo $item->get('qty'); ?>" />
                            </div>
                            <div class="uk-width-1-3">
                                <button class="uk-button uk-button-primary uk-button-small updateQty uk-width-1-1">Update</button>
                            </div>
                            <div class="uk-width-1-3"> 
                                <button class="uk-button uk-button-primary uk-button-small uk-width-1-1">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="uk-width-1-1 uk-text-right">
                <div class="cart-subtotal-text">Your Cart Subtotal: <span class="cart-subtotal-price"><?php echo $this->app->number->currency($data['total'], array('currency' => 'USD')); ?></span></div>
            </div>
            <div class="uk-width-1-1">
                <button class="uk-button uk-button-checkout uk-button-small uk-button-text-large checkout uk-width-1-1" <?php echo $data['count'] === 0 ? 'disabled' : '' ?> >Proceed to Checkout</button>
            </div>
            <div class="uk-width-1-1">
                <button class="uk-button uk-button-primary uk-button-small uk-button-text-large continue uk-width-1-1">Continue Shopping</button>
            </div>
        </div>
    </div>
</div>
