<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');
$class = $item->type.'-full';
$product = $this->app->product->create($item);
?>
<article>
    <span class="uk-article-title"><?php echo $product->name; ?></span>
</article>
<div id="OrderForm-<?php echo $product->id; ?>" data-id="<?php echo $product->id; ?>">
    <div id="" class="uk-grid uk-form">
        <div class="uk-width-2-3 ubsk-slideshow">
            <div class="uk-width-1-1 uk-margin">
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
                            <div class="uk-width-1-1 uk-margin-top options-container" data-id="<?php echo $product->id; ?>">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Boat Information'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        <div class="uk-width-1-1 options-container uk-margin-top" data-id="<?php echo $product->id; ?>">
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
                            <div class="uk-width-1-2 uk-grid price-container">
                                <?php if ($this->checkPosition('pricing')) : ?>
                                        <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                                <?php endif; ?>
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
                                                   <input type="number" id="beam" name="beam" data-location="beam" min="<?php echo $product->getOption('beam')->get('min')-1; ?>" value="<?php echo $product->getOption('beam')->get('value'); ?>" />
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
                                                   <input type="number" id="bridge" name="bridge" data-location="bridge_width" min="<?php echo $product->getOption('bridge')->get('min')-1; ?>" value="<?php echo $product->getOption('bridge')->get('value'); ?>" />
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
                                                   <input type="number" id="depth" name="depth" data-location="depth" min="<?php echo $product->getOption('depth')->get('min')-1; ?>" value="<?php echo $product->getOption('depth')->get('value'); ?>" />
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
                <input id="qty-<?php echo $product->id; ?>" type="number" class="uk-width-1-1 qty" data-id="<?php echo $product->id; ?>" name="qty" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-<?php echo $product->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
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
                            <?php //echo $this->renderPosition('accessories', array('style' => 'related')); ?>
                            </ul>
                    </fieldset>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="modals">
        <?php if ($this->checkPosition('modals')) : ?>        
            <?php echo $this->renderPosition('modals'); ?>
        <?php endif; ?>
    </div>
</div>



<script>
    if(typeof items === 'undefined') { var items = {} };
    var classes = [0,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W'];
    var measurements_changed = false;
    var defaults = {
            beam: {
                min: 84,
                max: 221
            },
            bridge: {
                min: 1,
                max: 200
            },
            depth: {
                min: 46,
                max: 105
            }
        };
    jQuery(document).ready(function($){
        items['ubsk'] = <?php echo $product->toJson(true); ?>;
        lpiModal.init('.modals');
        $('#OrderForm-<?php echo $product->id; ?>').OrderForm({
            name: 'UltimateBoatShadeKit',
            validate: true,
            confirm: true,
            debug: false,
            events: {
                ubsk: {
                    onInit: [
                        function (data) {
                            var self = this;
                            this.trigger('measure', {item: this.item});
       
                            $('.ubsk-measurement input').on('change', function(e){
                                var name = $(this).prop('name');
                                var value = $(this).val();
                                self.item.options[name].value = value;
                                measurements_changed = true;
                                self.trigger('measure', {item: self.item});
                            });
                            this._publishPrice({item: this.item});
                            return data;
                        }
                    ],
                    onChanged: [
                        function (data) {
                            this.trigger('measure', {item: self.item});
                            return data;
                        }
                    ],
                    measure: [
                        function (data) {
                            var self = this;
                            var item = this.item;
                            var old_class = item.options.kit_class.value;
                            checkMinandMax();
                            getClass();
                            
                            function checkMinandMax() {
                                var beam = item.options.beam, bridge = item.options.bridge, depth = item.options.depth, shade_type = item.options.shade_type;
                                var args = {item: item};

                                // Checking Beam Width
                                switch (true) {
                                    case beam.value < defaults.beam.min:
                                        self.trigger('beamTooSmall', args);
                                        break;
                                    case beam.value > defaults.beam.max:
                                        self.trigger('beamTooLarge', args);
                                }

                                // Checking Bridge Width
                                switch (true) {
                                    case bridge.value < defaults.bridge.min:
                                        self.trigger('bridgeTooSmall', args);
                                        break;
                                    case bridge.value > defaults.bridge.max:
                                        self.trigger('bridgeTooLarge', args);
                                }

                                // Checking Depth
                                switch (true) {
                                    case depth.value < defaults.depth.min:
                                        self.trigger('depthTooSmall', args);
                                        break;
                                    case depth.value > defaults.depth.max:
                                        self.trigger('depthTooLarge', args);
                                }

                                // Checking depth and determine if it is an exended shade.
                                if (depth.value >= 46 && depth.value <= 80) {
                                    shade_type.value = 'regular';
                                } else if (depth.value >= 81 ) {
                                    shade_type.value = 'extended';
                                } 

                            }

                            function getClass() {
                                var cls = (item.options.beam.value - 84);
                                cls = (cls + 1)/6;
                                cls = Math.ceil(cls) > 23 ? 23 : Math.ceil(cls);
                                console.log(cls);
                                cls = classes[cls];
                                item.options.kit_class.value = cls;
                                console.log('USBK Class: '+cls);
                            }
                            if(old_class !== item.options.kit_class.value) {
                                this._publishPrice({item: item});
                            }
                            
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
                            console.log(data);
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'beamtoosmall',
                                value: defaults.beam.min
                            });
                            this.item.options.beam.value = defaults.beam.min;
                            $('[name="beam"]').val(defaults.beam.min);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    beamTooLarge: [
                        function (data) {
                            console.log(data);
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'beamtoolarge',
                                value: defaults.beam.max
                            });
                            this.item.options.beam.value = defaults.beam.max;
                            $('[name="beam"]').val(defaults.beam.max);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    bridgeTooSmall: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'bridgetoosmall',
                                value: defaults.bridge.min
                            });
                            this.item.options.bridge.value = defaults.bridge.min;
                            $('[name="bridge"]').val(defaults.bridge.min);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    bridgeTooLarge: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'bridgetoolarge',
                                value: defaults.bridge.max
                            });
                            this.item.options.bridge.value = defaults.bridge.max;
                            $('[name="bridge"]').val(defaults.bridge.max);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    depthTooSmall: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'depthtoosmall',
                                value: defaults.depth.min
                            });
                            this.item.options.depth.value = defaults.depth.min;
                            $('[name="depth"]').val(defaults.depth.min);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    depthTooLarge: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'depthtoolarge',
                                value: defaults.depth.max
                            });
                            this.item.options.depth.value = defaults.depth.max;
                            $('[name="depth"]').val(defaults.depth.max);
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    measurementsNotChanged: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'ubsk',
                                name: 'nochange'
                            });
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    beforeAddToCart: [
                        function (data) {
                            if (!measurements_changed) {
                                this.trigger('measurementsNotChanged', {item: this.item});
                                data.triggerResult = false;
                                return data;
                            }
                            return data;
                        }
                    ]
                }
            } 
        });
    })
</script>