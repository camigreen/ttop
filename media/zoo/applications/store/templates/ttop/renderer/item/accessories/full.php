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
$data_item = array('id' => $item->id, 'name' => $item->name);
$product = $this->app->product->create($item, $item->type);
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');
$product->price->debug(true);
?>
<div id="OrderForm" class="<?php echo $item->type; ?>" data-id="<?php echo $product->id; ?>">
    <div id="<?php echo $product->id; ?>" class="uk-form uk-grid ttop storeItem" >
        <div class="uk-width-1-1 top-container">
            <?php if ($this->checkPosition('top')) : ?>
            <?php echo $this->renderPosition('top', array('style' => 'block')); ?>
            <?php endif; ?>
        </div>
        <div class="uk-width-1-1 title title-container uk-margin-top">
            <?php if ($this->checkPosition('title')) : ?>
            <p class="uk-article-title"><?php echo $this->renderPosition('title'); ?></p>
            <?php endif; ?>
        </div>
        
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
</div>
<div class="modals">
</div>

<script>
    var items = {};
    items[<?php echo $product->id; ?>] = <?php echo $product->toJson(true); ?>;
    jQuery(function($) {
        
        $(document).ready(function(){

            $('#OrderForm').OrderForm({
                name: 'Accessories',
                validate: true,
                confirm: false,
                debug: true,
                events: {}
            });
        });
        
    });
    
    
</script>

