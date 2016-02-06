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
$storeItem = $this->app->item->create($item, 'ubsk');
?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="storeItemForm" class="uk-form uk-margin">
    <div id="<?php echo $storeItem->id; ?>" class="uk-grid storeItem" data-item="<?php echo $storeItem->getItemsJSON(); ?>">
        <div class="uk-width-2-3 ubsk-slideshow">
            <div class="uk-width-5-6 uk-container-center uk-margin">
                <?php if ($this->checkPosition('media')) : ?>
                    <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                <?php endif; ?>
            </div>
            <div class="uk-width-1-1">
                <ul class="uk-tab" data-uk-tab="{connect:'#tabs'}">
                    <li>
                        <a href="#">Order Form</a>
                    </li>
                    <?php if ($this->checkPosition('measurement_info')) : ?>
                    <li>
                        <a href="#">Measurements</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('tabs')) : ?>
                        <?php echo $this->renderPosition('tabs', array('style' => 'tab')); ?>
                    <?php endif; ?>
                </ul>
                <ul id="tabs" style="min-height:150px;" class="uk-width-1-1 uk-switcher uk-margin">
                    <li>
                        <?php if ($this->checkPosition('boat_options')) : ?>
                            <div class="uk-width-1-1 uk-margin-top options-container" data-id="<?php echo $storeItem->id; ?>">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Boat Information'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        <div class="uk-width-1-1 options-container uk-margin-top" data-id="<?php echo $storeItem->id; ?>">
                                            <?php if ($this->checkPosition('options')) : ?>
                                                <div class="uk-panel uk-panel-box">
                                                    <h3><?php echo JText::_('Options'); ?></h3>
                                                    <div class="validation-errors"></div>
                                                    <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        <?php endif; ?>
                        <p class="uk-text-danger">Please refer to important instructions in the measurement info tab above.</p>
                        <div class="uk-grid ubsk-measurements">
                            <?php if ($this->checkPosition('aft_measurements')) : ?>
                            <div class="uk-width-1-2">
                                <div class="uk-margin-top">
                                    <a href="<?php echo JURI::root(); ?>/images/ubs/order_form/diagram.png" data-lightbox title="">
                                        <img src="<?php echo JURI::root(); ?>/images/ubs/order_form/diagram.png" />
                                    </a>
                                </div>
                            </div>
                            <div id="ubsk-price"class="uk-width-1-2">
                                <i class="currency"></i>
                                <span class="price">0.00</span>
                            </div>
                            <div class="uk-width-1-2">
                                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
                            </div>
                            <div class="uk-width-1-2 uk-margin-top">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Measurements'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>1) From Rod Holder to Rod Holder</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="beam-width" name="beam-width" class="required" data-location="beam" min="0" value="84" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>2) Bridge Width Measurement</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="ttop-width" name="bridge-width" class="required" data-location="bridge_width" min="0" value="0" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 ubsk-measurement">
                                            <label>3) Bridge to Rod Holders Measurement</label>
                                            <div class="uk-grid">
                                                <div class="uk-width-2-6">
                                                   <input type="number" id="depth" name="depth" class="required" data-location="depth" min="0" value="46" />
                                                </div>
                                                <div class="uk-width-1-6">
                                                    in
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php if ($this->checkPosition('measurement_info')) : ?>
                    <li>
                        <?php echo $this->renderPosition('measurement_info', array('style' => 'bsk-measure-info')); ?>
                    </li>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('tabs')) : ?>
                        <?php echo $this->renderPosition('tabs', array('style' => 'tab_content')); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="uk-width-1-1 ubsk-results">

            </div>
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div id="ubsk-total-price"class="uk-width-1-1">
                <i class="currency"></i>
                <span class="price">0.00</span>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
            </div>
            <div class="uk-width-1-1 addtocart-container uk-margin-top">
                <label>Quantity</label>
                <input id="qty-<?php echo $storeItem->id; ?>" type="number" class="uk-width-1-1 qty" data-id="<?php echo $storeItem->id; ?>" name="qty" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-<?php echo $storeItem->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $storeItem->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                </div>
            </div>
            <div class="uk-width-1-1 uk-container-center uk-margin-top">
                <?php if ($this->checkPosition('product_info')) : ?>
                        <?php echo $this->renderPosition('product_info', array('style' => 'blank')); ?>
                <?php endif; ?>
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
    </div>
    <div class="modals">
        <div id="confirm-modal" class="uk-modal">
            <div class="uk-modal-dialog">
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-1-1">
                        <div class="uk-article-title uk-text-center">Confirmation</div>
                        <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that a Boat Shade is a custom made product and that if I have chosen an option incorrectly it may lead to the Boat Shade not fitting my boat correctly.</div>
                        <div class="uk-text-center uk-margin">Your measurement will calculate the proper size of shade, because of the stretch of the fabric your shade will be sized down. This will allow tension on the shade to prevent any sag and to give your BSK a custom fit.</div>
                    </div>
                    <div class="uk-width-1-1"> 
                        <div class="item"></div>
                    </div>
                    <div class="uk-width-1-1">
                        <span>Type "yes" in the box below to confirm that your options have been chosen correctly.</span><br />
                        <span class="confirm-error uk-text-danger uk-text-small"></span><br />
                        <input type="text" name="accept" />
                    </div>
                    <div class="uk-width-1-1">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger confirm">Confirm</button>
                            </div>
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="hidden" name="cart_id" value="" />
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->checkPosition('modals')) : ?>        
            <?php echo $this->renderPosition('modals'); ?>
        <?php endif; ?>
        <div id="info_modal" class="uk-modal">
            <div class="uk-modal-dialog">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1">
                        <div class="uk-article-title uk-text-center uk-text-danger">Attention</div>
                        <p class="uk-text-center uk-margin ttop-modal-title"></p><p class="uk-text-center ttop-modal-subtitle" ></p>
                    </div>
                    <div class="uk-width-1-1">
<!--                        <img src="/images/ubs/ubs2.png" />-->
                    </div>
                    <div class="uk-width-1-1">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger confirm">Show Me</button>
                            </div>
                            <div class="uk-width-1-2">
                                <button class="uk-width-1-1 uk-button uk-button-danger cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var info_modal = jQuery.UIkit.modal('#info_modal');
    var UBSK = {
        cls: [0,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W'],
        measurements_changed: false,
        params: {
            beam: {
                min: 84,
                max: 221
            },
            bridge_width: {
                min: 0,
                max: 200
            },
            depth: {
                min: 46,
                max: 105
            }
        },
        options: {
            shade_type: {
                name: 'Shade Type',
                text: 'Regular',
                value: 'regular',
                visible: false
            },
            beam: {
                name: 'Rod Holder to Rod Holder Measurement',
                text: null,
                value: 0
            }, 
            bridge_width: {
                name: 'Bridge Width Measurement',
                text: null,
                value: 0
            },
            depth: {
                name: 'Bridge to Rod Holder Measurement',
                text: null,
                value: 0
            },
            kit_class: {
                name: 'Shade Class',
                text: 'A',
                value: 'A',
                visible: false

            }
            
        }
        
    };
    jQuery(document).ready(function($){
        $('#storeItemForm').StoreItem({
            name: 'UltimateBoatShadeKit',
            validate: true,
            confirm: true,
            debug: true,
            events: {
                onInit: [
                    function (data) {
                        var self = this;
                        this.trigger('measure');
   
                        $('.ubsk-measurement input').on('change', function(){
                            UBSK.measurements_changed = true;
                            self.trigger('measure');
                        });
                        return data;
                    }
                ],
                onChanged: [
                    function (data) {
                        this.trigger('measure');
                        return data;
                    }
                ],
                measure: [
                    function (data) {
                        var self = this;
                        getMeasurements();
                        checkMinandMax();

                        function getMeasurements() {
                            var measurements = $('.ubsk-measurement input[type="number"]'), length = {};
                            
                            measurements.each(function(k,v){
                                length[$(this).data('location')] = parseInt($(this).val());
                                
                                
                                $.each(length, function(k,v){
                                    UBSK.options[k].value = v;
                                    UBSK.options[k].text = v+' inches';
                                });
                            });
                            var cls = (UBSK.options.beam.value - 84);
                            var kit_class = UBSK.options.kit_class;
                            cls = (cls + 1)/6;
                            cls = Math.ceil(cls) > 23 ? 23 : Math.ceil(cls);
                            cls = UBSK.cls[cls];
                            kit_class.name = 'Kit Class';
                            kit_class.text =  cls;
                            kit_class.value = cls;
                            self.items['ubsk'].options.kit_class = kit_class;
                        }
                        
                        function checkMinandMax() {
                            var beam = UBSK.options.beam, bridge_width = UBSK.options.bridge_width, depth = UBSK.options.depth, shade_type = UBSK.options.shade_type, params = UBSK.params;
                            // Checking depth and determine if it is an exended shade.
                            if (depth.value >= 46 && depth.value <= 80) {
                                shade_type.text = 'Regular';
                                shade_type.value = 'regular';
                            } else if (depth.value >= 81 ) {
                                shade_type.text = 'Extended';
                                shade_type.value = 'extended';
                            } 
                            self.items['ubsk'].options.shade_type = shade_type;
                            // Checking Beam Width
                            switch (true) {
                                case beam.value < params.beam.min:
                                    self.trigger('beamTooSmall');
                                    break;
                                case beam.value > params.beam.max:
                                    self.trigger('beamTooLarge');
                            }
                            
                            // Checking Depth
                            switch (true) {
                                case depth.value < params.depth.min:
                                    self.trigger('depthTooSmall');
                                    break;
                                case depth.value > params.depth.max:
                                    self.trigger('depthTooLarge');
                            }

                            
                        }
                        var item = this.items['ubsk'];
                        var type = item.options.shade_type.value === 'regular' ? '' : '.'+item.options.shade_type.value;
                        item.price_group = 'ubsk.'+item.options.kit_class.value+type;
                        this._publishPrice(item);
                        return data;
                    }
                ],
                afterPublishPrice: [
                    function (data) {
                        $('#ubsk-total-price span.price').html(data.args.price.toFixed(2));
                        return data;
                    }
                ],
                beamTooSmall: [
                    function (data) {
                        var type = data.args.type;
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Boat Shade Kit for smaller boats.');
                        
                        $('.ubsk-measurements #beam-width-ft').val(7);
                        $('.ubsk-measurements #beam-width-in').val(0).trigger('input');
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                beamTooLarge: [
                    function (data) {
                        var type = data.args.type, params = UBSK.params;
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Ultimate Boat Shade Kit.  Click the contact us button below for send us an email.');
                        
                        $('.ubsk-measurements #beam-width').val(params.beam.max);

                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                bridgeTooSmall: [
                    function (data) {
                        var type = data.args.type;
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom shade kit for your boat.  Click the contact us button below for send us an email.');
                        
                        $('.ubsk-measurements #bridge-width-ft').val(4);
                        $('.ubsk-measurements #bridge-width-in').val(6).trigger('input');
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                bridgeTooLarge: [
                    function (data) {
                        var type = data.args.type;
                        $('#info_modal').find('.ttop-modal-title').html('Boats with a T-Top width measurement over 7\' 6" are too big for our Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Ultimate Boat Shade Kit for larger boats.');
                        
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/products/ultimate-boat-shade';
                        }).html('Ultimate Boat Shade Kit');
                        
                        $('#info_modal button.cancel').click(function(){
                            $('.bsk-type-'+type+' #ttop-width-ft').val(7);
                            $('.bsk-type-'+type+' #ttop-width-in').val(6).trigger('input');
                            $('#info_modal button').off();
                            info_modal.hide();

                        });
                        
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                depthTooSmall: [
                    function(data) {
                        var type = data.args.type, params = UBSK.params;
                        $('#info_modal').find('.ttop-modal-title').html('We are sorry, but the measurements that you have entered are too small for our Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Please check out our Boat Shade Kit for smaller boats.');

                        $('.ubsk-measurements #depth').val(params.depth.min);
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/store/boat-shade-kit';
                        }).html('Boat Shade Kit');

                        $('#info_modal button.cancel').click(function(){
                            $('#info_modal button').off();
                            info_modal.hide();

                        });

                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                depthTooLarge: [
                    function (data) {
                        var type = data.args.type, params = UBSK.params;
                        $('#info_modal').find('.ttop-modal-title').html('The measurements you have selected falls outside of our standard Ultimate Boat Shade Kit.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Ultimate Boat Shade Kit.  Click the contact us button below for send us an email.');

                        $('.ubsk-measurements #depth').val(params.depth.max);
                        $('#info_modal button.confirm').click(function(){
                            window.location = '/contact-us';
                        }).html('Contact Us');
                        
                        $('#info_modal button.cancel').on('click', function(e){
                            $('#info_modal button').off();
                            info_modal.hide();
                        });
                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                measurementsNotChanged: [
                    function (data) {
                        var self = this;
                        $('#info_modal').find('.ttop-modal-title').html('The order form measurements have not been changed.');
                        $('#info_modal').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Ultimate Boat Shade Kit. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                        
                        $('#info_modal button.confirm').click(function(){
                            UBSK.measurements_changed = true;
                            info_modal.hide();
                            $('#atc-ubsk').trigger('click');
                        }).html('Continue');
                            
                        $('#info_modal button.cancel').click(function(){
                            
                            $('#info_modal button').off();
                            info_modal.hide();
                            $(this).html('Cancel');

                        }).html('Back');

                        info_modal.options.bgclose = false;
                        info_modal.show();
                        data.triggerResult = false;
                        return data;
                    }
                ],
                beforeAddToCart: [
                    function (data) {
                        if (!UBSK.measurements_changed) {
                            this.trigger('measurementsNotChanged');
                            data.triggerResult = false;
                            return data;
                        }
                        var item = $.extend(true,{},data.args.items['ubsk']);
                        item.name = 'Ultimate Boat Shade - '+item.options.kit_options.text;
                        item.options = $.extend(true, item.options, UBSK.options);
                        data.args.items['ubsk'] = item;
                        return data;
                    }
                ]
            } 
        });
    })
</script>