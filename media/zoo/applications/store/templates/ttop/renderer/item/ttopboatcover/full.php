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
$mobile = $this->app->browser->isMobile();

?>
<div id="OrderForm-<?php echo $product->id; ?>" class="t-top-boat-cover uk-form" data-id="<?php echo $product->id; ?>">
    <div id="<?php echo $product->id ?>" class="storeItem" >
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
                <ul class="uk-breadcrumb">
                    <li class="uk-hidden-small"><a href="/">Home</a></li>
                    <li class="uk-hidden-small"><span>T-Top Boat Covers</span></li>
                    <li><a href="/store/t-top-boat-covers">All Boats</a></li>
                    <li><a href="<?php echo $this->app->route->category($item->getPrimaryCategory()); ?>"><?php echo $item->getPrimaryCategory()->name; ?></a></li>
                    <li><span><?php echo $product->params->get('model'); ?></span></li>
                </ul>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-article-title"><?php echo $product->name; ?></p>
            </div>
            <?php if ($this->checkPosition('title')) : ?>
                <div class="uk-width-large-1-1 uk-width-small-1-1 uk-margin-top">
                    <?php echo $this->renderPosition('title', array('style' => 'uikit_list')); ?>
                </div>
            <?php endif; ?>
            <div class="uk-width-large-2-3 uk-width-small-1-1">
                <div class="uk-width-1-1 media-container">
                    <div class="uk-grid">
                        <?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "left") : ?>
                            <div class="uk-width-large-1-1 uk-margin">
                                    <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-3 uk-width-small-1-1">
                <div class="uk-grid" >
                    <div class="price-container uk-width-1-1">
                        <?php if ($this->checkPosition('pricing')) : ?>
                                <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($this->checkPosition('options')) : ?>
                    <div class="options-container uk-width-1-1" data-id="<?php echo $product->id; ?>">
                            <div class="uk-panel uk-panel-box">
                                <h3><?php echo JText::_('Options'); ?></h3>
                                <div class="validation-errors"></div>
                                <?php echo $this->renderPosition('options', array('style' => 'options')); ?>
                            </div>
                    </div>
                    <?php endif; ?>
                    <div class="addtocart-container uk-width-1-1">
                        <label>Quantity</label>
                        <input id="qty-<?php echo $product->id; ?>" type="number" inputmode="numeric" pattern="[0-9]*" title="Non-negative integral number" class="uk-width-1-1 qty" name="qty" data-id="<?php echo $product->id; ?>" min="1" value ="1" />
                        <div class="uk-margin-top">
                            <button id="atc-<?php echo $product->id; ?>" class="uk-button uk-button-danger atc uk-width-small-1-1" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-2-3 uk-width-small-1-1">
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="uk-accordion" data-uk-accordion="{showfirst: false}">
                            <?php if($category->description) : ?>
                            <h3 class="uk-accordion-title"><div class="uk-width-1-1">Description<span class="uk-icon uk-icon-caret uk-align-right" style="line-height: 1.4"></span></div></h3>
                            <div class="uk-accordion-content">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-2-3 uk-width-small-1-1">
                                        <p>T-top Boat Covers are designed to be custom fit for each specific boat model. They are very durable and lightweight when compared to traditional canvas covers. This makes installation for one person very easy. Watch the installation video to see how easy it really is.</p>
                                        <p>Our unique cover design does not trap water or moisture, which could lead to mold and mildew growth on the boat. Take a look at the ventilation video to see the "chimney effect" in action.</p>
                                        <p>Our cover design utilizes 1\ wide webbing straps with plastic side release buckles to allow the cover to hang under the T-top. We install a port or starboard side zipper entry on each cover and it is located in-line with the helm seat. We utilize a 3/8 diameter Nylon rope which is hemmed into the bottom of the cover to secure your cover to your boat around the hull and motor(s). We also provide tie down loops installed every 4&rsquo; around the perimeter. This gives you the option to secure your cover to the trailer or if you&rsquo;re on a lift, you can hang our sandbags from them. Click the accessories tab to see our sandbags and all of our other accessories.</p>
                                    </div>
                                        <div class="uk-width-medium-1-3 uk-width-small-1-1 uk-text-center">
                                            <div class="uk-panel uk-panel-box">
                                                <h3 class="uk-panel-title-center">Media</h3>
                                                <a href="https://www.youtube.com/watch?v=BuYtm1D-xdI" class="uk-button uk-button-danger uk-width-1-1" data-lightbox="width:800;height:450;">Installation Video</a>
                                                <a href="https://www.youtube.com/watch?v=C6gDlCC1eX8" class="uk-button uk-button-danger uk-width-1-1" data-lightbox="width:800;height:450;">Ventilation Video </a>
                                                <a href="gallery/photo-galleries/t-top-boat-covers-gallery" target="_blank" class="uk-button uk-button-danger uk-width-1-1">T-Top Gallery </a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('accessories')) : ?>
                            <h3 class="uk-accordion-title"><div class="uk-width-1-1">Essential Accessories<span class="uk-icon uk-icon-caret uk-align-right" style="line-height: 1.4"></span></div></h3>
                            <div class="uk-accordion-content"><?php echo $this->renderPosition('accessories', array('style' => 'related')); ?></div>
                            <?php endif; ?>
                        
                        </div>
                    </div>
                    <div class="uk-width-1-1 options-container">
                        <div class="uk-grid">
                            <?php if ($this->checkPosition('cover_options')) : ?>
                            <div class="uk-width-large-1-2 uk-width-small-1-1 uk-margin-top">
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

                            <?php if ($this->checkPosition('boat_options')) : ?>
                            <div class="uk-width-large-1-2 uk-width-small-1-1 uk-margin-top">
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
                            <div class="uk-width-large-1-2 uk-width-small-1-1 uk-margin-top">
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

                            <?php if ($this->checkPosition('bow_options')) : ?>
                            <div class="uk-width-large-1-2 uk-width-small-1-1 uk-margin-top">
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
                            <div class="uk-width-large-1-1 uk-width-small-1-1 uk-margin-top">
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
                            <div class="uk-width-large-1-1 uk-width-small-1-1 uk-margin-top">
                                <fieldset>
                                    <legend>Additional Information<span class="uk-text-small uk-margin-left">(other)</span></legend>
                                        <textarea class="uk-width-1-1 item-option" style="height:120px;" name="add_info" data-name="Additional Information"></textarea>
                                </fieldset>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-3 uk-width-small-1-1">
                
            </div>
            <div class="uk-width-1-1">
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
                debug: false,
                confirm: true,
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
                                            lpiModal.getModal({type: 'ttbc', name: 'inwater'});
                                        }
                                        break;
                                    case 'trolling_motor': // Check if the trolling motor is "yes" and show the modal for the photo upload
                                        if(elem.val() === 'Y' && !this.item.options.trolling_motor.confirmed) {
                                            data = {
                                                type: 'ttbc',
                                                name: 'trolling_motor',
                                                value: 'Y',
                                                field: elem.prop('id'),
                                                item: this.item
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