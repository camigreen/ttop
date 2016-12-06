<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
$embed = $this->app->request->get('embed','bool');
// no direct access
defined('_JEXEC') or die('Restricted access');
$product = $this->app->product->create($item);
$category = $item->getPrimaryCategory()->getParent();
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');


?>
<div id="OrderForm-<?php echo $product->id; ?>" class="t-top-boat-cover" data-id="<?php echo $product->id; ?>">
    <div id="<?php echo $product->id ?>" class="storeItem" >
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <p class="uk-article-title"><?php echo $product->name; ?></p>
        </div>

        <div class="uk-width-1-2 uk-text-right">
            <a href="<?php echo $this->app->route->category($item->getPrimaryCategory()); ?>" class="uk-button uk-button-danger">Back to <?php echo $item->getPrimaryCategory()->name; ?></a>
            <a href="/store/t-top-boat-covers" class="uk-button uk-button-danger">Back to Manufactures</a>
        </div>
        <?php if ($this->checkPosition('title')) : ?>
            <div class="uk-width-1-1 uk-margin-top">
                <?php echo $this->renderPosition('title', array('style' => 'uikit_list')); ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="uk-form uk-margin">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-2-3">
                    <?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "left") : ?>
                        <div class="uk-width-1-1 uk-margin">
                                <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                        </div>
                    <?php endif; ?>
                    <div class="uk-width-1-1">
                        <ul class="uk-tab" data-uk-tab="{connect:'#tabs'}">
                            <li>
                                <a href="#">Order Form</a>
                            </li>
                            <?php if($category->description) : ?>
                            <li>
                                <a href="#">Description</a>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('tabs')) : ?>
                                <?php echo $this->renderPosition('tabs', array('style' => 'tab')); ?>
                            <?php endif; ?>
                        </ul>

                        <ul id="tabs" style="min-height:150px;" class="uk-width-1-1 uk-switcher uk-margin options-container" data-id="<?php echo $product->id; ?>">
                            <li class="uk-grid">


                                <?php if ($this->checkPosition('boat_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Boat Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('motor_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Motor Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('motor_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('cover_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Cover Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('cover_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('bow_options')) : ?>
                                <?php $width = 'uk-width-1-2'; ?>
                                <div class="<?php echo $width; ?> uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Bow Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('bow_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('special_accessories')) : ?>
                                <?php $width = 'uk-width-1-1'; ?>
                                <div class="<?php echo $width; ?> uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Special Accessories'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('special_accessories', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>
                                <div class="uk-width-1-1 uk-margin-top">
                                    <fieldset>
                                        <legend>Additional Information<span class="uk-text-small uk-margin-left">(other)</span></legend>
                                            <textarea class="uk-width-1-1 item-option" style="height:120px;" name="add_info" data-name="Additional Information"></textarea>
                                    </fieldset>
                                </div>
                            </li>
                            <?php if($category->description) : ?> 
                                <li>
                                    <article class="uk-article">
                                        <?php echo $category->getText($category->description); ?>
                                    </article>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('tabs')) : ?>
                                <?php echo $this->renderPosition('tabs', array('style' => 'tab_content')); ?>
                            <?php endif; ?>
                        </ul>
                </div>
            </div>
            <div class="uk-width-1-3">
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
                            <?php echo $this->renderPosition('options', array('style' => 'options')); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="uk-width-1-1 addtocart-container uk-margin-top">
                    <label>Quantity</label>
                    <input id="qty-<?php echo $product->id; ?>" type="number" class="uk-width-1-1 qty" name="qty" data-id="<?php echo $product->id; ?>" min="1" value ="1" />
                    <div class="uk-margin-top">
                        <button id="atc-<?php echo $product->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                    </div>
                </div>
                <?php if ($this->checkPosition('accessories')) : ?>
                <div class="uk-width-1-1 uk-margin-top">
                        <fieldset>
                            <legend>Essential Accessories</legend>
                                <ul class="uk-list" data-uk-grid-margin>
                                <?php echo $this->renderPosition('accessories', array('style' => 'related')); ?>
                                </ul>
                        </fieldset>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($this->checkPosition('bottom')) : ?>
                    <?php echo $this->renderPosition('bottom', array('style' => 'block')); ?>
            <?php endif; ?>
            
            <?php if ($this->checkPosition('modals')) : ?>
                <div class="modals">
                    <?php echo $this->renderPosition('modals'); ?>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>
<script>
    if(typeof items === 'undefined') { var items = {} };
    items[<?php echo $product->id; ?>] = <?php echo $product->toJson(true); ?>;
    jQuery(function($) {

        lpiModal.init('.modals');

        $(document).ready(function(){
            $('#OrderForm-<?php echo $product->id; ?>').OrderForm({
                name: 'T-Top Boat Cover',
                validate: true,
                debug: true,
                confirm: false,
                events: {
                    ttbc: {
                        onInit: [
                            function (data) {
                                var item = data.args.item;

                                this.trigger('changeColor', {item: item, fabric: item.options.fabric.value});
                                return data;
                            }
                        ],
                        beforeChange: [
                            function(data) { 
                                var e = data.args.event, item = data.args.item, elem = $(e.target), self = this;
                                switch(elem.prop('name')) {
                                    case 'storage': //Check the storage value and if "IW" show the modal
                                        if(elem.val() === 'IW') {
                                            lpiModal.getModal({type: 'ccbc', name: 'inwater'});
                                        }
                                        break;
                                    case 'trolling_motor': // Check if the trolling motor is "yes" and show the modal for the photo upload
                                        if(elem.val() === 'Y' && !this.item.options.trolling_motor.confirmed) {
                                            data = {
                                                type: 'ttbc',
                                                name: 'trolling_motor',
                                                value: 'Y',
                                                field: elem.prop('id')
                                            };
                                            lpiModal.getModal(data);
                                        } else {
                                            this.item.options.trolling_motor.confirmed = false;
                                        }
                                        break;
                                    case 'fabric':
                                        self.trigger('changeColor', {item: item, fabric: elem.val()});
                                        break;
                                    case 'color':
                                        //changeColor(elem.val());
                                        break;
                                    case 'ttop_type':
                                        if(elem.val() === 'hard-top') {
                                            var modal = $.UIkit.modal("#hthsk-modal");
                                            modal.options.bgclose = false;
                                            modal.show();
                                        }
                                }
                                return data;
                            }
                        ],
                        changeColor: [
                            function (data) {
                                var fabric = data.args.fabric;
                                console.log(fabric);
                                var colorSelect = $('.item-option[name="color"]');
                                var colors = {
                                        '9oz': ['N','B','G','T'],
                                        '8oz': ['N','B'],
                                        '7oz': ['N','B']
                                    }
                                colorSelect.find('option').each(function(k,v){
                                    $(this).find('span').html('');
                                    if ($(this).prop('value') !== 'X') {
                                        if($.inArray($(this).prop('value'), colors[fabric]) === -1) {
                                            $(this).prop('disabled',true);
                                            $(this).append('<span>- 9oz Fabric Only</span>');
                                        } else {
                                            $(this).prop('disabled',false);
                                        }
                                    }
                                });
                                if($.inArray(colorSelect.val(), colors[fabric]) === -1) {
                                    colorSelect.val('X').trigger('input');
                                }
                                return data;
                            }
                        ],
                        beforeAddToCart: [
                            function(data) {

                                return data;
                            }
                        ],
                        onPublishPrice: []
                    }
                },
                removeValues: true
            });
        });
        
    });
    
    
</script>