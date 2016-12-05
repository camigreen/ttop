<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$class = $item->type.'-full';
$product = $this->app->product->create($item);
?>
<div class="uk-modal-dialog uk-modal-dialog-large ttop-related-modal ">
    <a class="uk-modal-close uk-close uk-close-alt"></a>
        <div id="OrderForm-<?php echo $item->id ?>" class="storeItem" data-id="<?php echo $item->id ?>">
            <div class="ttop-related-modal-header">
                    <?php if ($this->checkPosition('title')) : ?>
                        <h2><?php echo $this->renderPosition('title'); ?></h2>
                    <?php endif; ?>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 media-container">
                        <?php if ($this->checkPosition('media')) : ?>
                            <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 description-container">
                        <?php if ($this->checkPosition('description')) : ?>
                            <h3><?php echo JText::_('Description'); ?></h3>
                            <?php echo $this->renderPosition('description', array('style' => 'blank')); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 uk-grid price-container">
                    <?php if ($this->checkPosition('pricing')) : ?>
                            <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                    <?php endif; ?>
                </div>
                    <div class="uk-width-1-1 options-container uk-margin-top" data-id="<?php echo $product->id; ?>">
                        <?php if ($this->checkPosition('options')) : ?>
                            <div class="uk-panel uk-panel-box">
                                <h3><?php echo JText::_('Options'); ?></h3>
                                <div class="validation-errors"></div>
                                <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="uk-width-1-1 addtocart-container uk-margin-top">
                        <label>Quantity</label>
                        <input id="qty-<?php echo $product->id; ?>" type="number" class="uk-width-1-1 qty" data-id="<?php echo $product->id; ?>" name="qty" min="1" value ="1" />
                        <div class="uk-margin-top">
                            <button id="atc-<?php echo $product->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ttop-related-modal-footer uk-text-right">
            </div>
        </div>
</div>
<script>
if(typeof items === 'undefined') { var items = {} };
items[<?php echo $product->id; ?>] = <?php echo $product->toJson(true); ?>;
jQuery(function($) {

    $(document).ready(function(){
        $('#OrderForm-<?php echo $item->id ?>').OrderForm({
            name: 'Accessories',
            validate: false,
            debug: true,
            confirm: false,
            events: {
                accessories: {
                    beforeAddToCart: [
                        function(data) {
                            UIkit.modal($(this.$element).closest('.uk-modal')).hide();
                            return data;
                        }
                    ]
                }
            }
        });
    });
});
</script>

