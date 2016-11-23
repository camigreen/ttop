<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');
defined('_JEXEC') or die('Restricted access');
$class = $item->type.'-full';
$product = $this->app->product->create($item);
$this->template = $this->app->zoo->getApplication()->getTemplate()->getPath().'/renderer/item/boat-shade-kit/';
$type = 'orderform';
$this->form = $this->app->form->create(array($this->template.'config.xml', compact('type')));
$this->form->setValue('template', $this->template);
var_dump($product->price->debug());
?>
<article>
    <span class="uk-article-title"><?php echo $product->name; ?></span>
</article>
<div id="OrderForm-bsk" class="uk-form" data-id="<?php echo $product->id; ?>">
        <div class="uk-grid">
                <div class="uk-width-2-3">
                    <div class="uk-width-1-1 options-container" data-id="bsk">
                        <div class="uk-grid uk-text-center bsk-chooser">
                            <div class="uk-width-1-1">
                                <ul class="uk-list full-pic">
                                    <li class="active"><img src="<?php echo JURI::root(); ?>images/bsk/order_form/aft.jpg" /></li>
                                    <li><img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow.jpg" /></li>
                                    <li><img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow_aft.jpg" /></li>
                                </ul>  
                            </div>
                            <div class="uk-width-1-1 uk-text-center">
                                <p>Please choose how you will be using your T-Top Covers Boat Shade Kit by clicking on one of the pictures below.</p>
                            </div>
                            <div class="uk-width-1-1">
                                <ul class="uk-grid uk-grid-width-1-4 bsk-chooser-buttons">
                                    <li class="active" data-value="aft">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/aft.jpg" />
                                            <p>Aft Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="bow">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow.jpg" />
                                            <p>Bow Only<br/>(One Shade)</p>
                                        </div>
                                    </li>
                                    <li data-value="bow|aft">
                                        <div class="bsk-button">
                                            <img src="<?php echo JURI::root(); ?>images/bsk/order_form/bow_aft.jpg" />
                                            <p>Bow and Aft<br/>(Two Shades)</p>
                                        </div>
                                    </li>
                                </ul> 
                            </div> 
                        </div>
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

                                    <div class="uk-width-1-1 uk-margin-top">
                                        <fieldset> 
                                            <legend>
                                                <?php echo JText::_('Boat Information'); ?>
                                            </legend>
                                            <div class="uk-grid options-container" data-id="<?php echo $product->id; ?>">
                                                <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                            </div>
                                        </fieldset>
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
                                <?php endif; ?>
                                <p class="uk-text-danger">Please refer to the note and maintenance section in the Info and Video Tab above.</p>
                                <div class="uk-grid aft-container">
                                    <?php if ($this->checkPosition('aft_measurements')) : ?>
                                    <div class="uk-width-1-2">
                                        <div class="uk-width-1-1">
                                            <div class="uk-margin-top">
                                                <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" data-lightbox title="">
                                                    <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/aft_diagram.png" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2">
                                        <div class="uk-width-1-1 price-main" data-id="bsk-aft">
                                            <div class="uk-width-1-1 uk-grid price-container">
                                                <?php if ($this->checkPosition('pricing')) : ?>
                                                        <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <label>Quantity</label>
                                            <input id="qty-bsk-aft" type="number" class="uk-width-1-3 qty" name="qty" data-id="bsk-aft" min="1" value ="1" />
                                        </div>
                                        <div class="uk-width-1-1">
                                            <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
                                             <label><input type="checkbox" id="use_on_bow" name="use_on_bow" /> I want to use this shade on my bow also.<a href="#multipositional-modal" class="uk-icon-button uk-icon-info-circle" data-uk-tooltip="" title="Click here for more info!" data-uk-modal=""></a></label>
                                        </div>
                                        <div class="uk-width-1-1 uk-margin-top boat_chooser">
                                            <p>We may have the measurements for your boat.  Click below to see if we have your boat in our database.</p>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <div class="chosen_boat uk-text-primary uk-text-large"></div>
                                        </div>
                                        <div class="uk-width-1-1 uk-margin">
                                            <button id="btn_find_my_boat" class="uk-width-1-1 uk-button uk-button-danger" data-mode='CYB'>Choose My Boat</button>
                                        </div>
                                        <div class="uk-width-1-1 uk-margin-top">
                                            <button id="measurements-aft" class="uk-width-1-1 uk-button uk-button-danger" data-mode="EMM">Enter My Own Measurements</button>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="uk-grid bow-container">
                                    <?php if ($this->checkPosition('bow_measurements')) : ?>
                                    <div class="uk-width-1-2 ">
                                        <div class="uk-margin-top">
                                            <a href="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" data-lightbox title="">
                                                <img src="<?php echo JURI::root(); ?>/images/bsk/order_form/bow_diagram.png" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2 price-main" data-id="bsk-bow">
                                        <div class="uk-width-1-1 price-container">
                                            <?php if ($this->checkPosition('pricing')) : ?>
                                                    <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="uk-width-1-1">
                                            <label>Quantity</label>
                                            <input id="qty-bsk-bow" type="number" class="uk-width-1-3 qty" name="qty" data-id="bsk-bow" min="1" value ="1" />
                                        </div>
                                        <div class="uk-width-1-1 uk-margin-top">
                                            <button id="measurements-bow" class="uk-width-1-1 uk-button uk-button-danger" data-mode="EMM">Enter My Own Measurements</button>
                                        </div>
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
                    <div class="uk-width-1-3">
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div id="bsk-total-price"class="uk-width-1-1">
                        <i class="currency"></i>
                        <span class="price">0.00</span>
                    </div>
                    <div class="uk-width-1-1">
                        <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
                    </div>
                    <div class="uk-width-1-1 addtocart-container uk-margin-top">
                        <div class="uk-margin-top">
                            <button id="atc-bsk" class="uk-button uk-button-danger atc" data-id="bsk"><i class="uk-icon-shopping-cart" style="margin-right:5px;"></i>Add to Cart</button>
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
            <div id="toUBSK" class="uk-modal">
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
</div>
<script>
    if(typeof items === 'undefined') {items = {}};
    items['bsk'] = <?php echo $product->toJson(true); ?>;
    var products = {};
    var types = ['aft'];
    var mode = 'CYB';
    var defaults = {
        class: [
            {
                name: 'A',
                min: 24,
                max: 48
            },
            {
                name: 'B',
                min: 49,
                max: 65
            },
            {
                name: 'C',
                min: 66,
                max: 83
            },
            {
                name: 'D',
                min: 84,
                max: 96
            },
            {
                name: 'E'
            }
        ],
        aft: {
            changed: false,
            beam: {
                min: 72,
                max: 114,
                default: 72
            },
            ttop: {
                min: 54,
                max: 90,
                default: 54
            },
            ttop2rod: {
                min: 24,
                max: 83,
                default: 49
            },
            tapered: {
                min: 54,
                max: 59
            }
        },
        bow: {
            changed: false,
            beam: {
                min: 72,
                max: 114
            },
            ttop: {
                min: 54,
                max: 90
            },
            ttop2rod: {
                min: 24,
                max: 96
            },
            tapered: {
                min: 54,
                max: 59
            }
        }, 
        
    } 
    jQuery(document).ready(function($){

        lpiModal.init('.modals');
        $('#OrderForm-bsk').OrderForm({
            name: 'BoatShadeKit',
            validate: true,
            confirm: true,
            debug: true,
            events: {
                bsk: {
                    onInit: [
                        function (data) {
                            var self = this;

                            $(this.$element).on('measure', function(e, data){
                                self.trigger('measure', {item: data.item, type: data.type});
                            })

                            $('#use_on_bow').on('change', function() {
                                self.trigger('measure', {item: products['bsk-aft'], type: 'aft'});
                            })
                            // Create Items
                            products['bsk-aft'] = $.extend(true, {}, this.item);
                            products['bsk-bow'] = $.extend(true, {}, this.item);

                            $('.bsk-chooser .bsk-chooser-buttons li').on('click',function(e){
                                    var index = $(this).index();
                                    var type = $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').data('value');
                                    $('.bsk-chooser .bsk-chooser-buttons li').removeClass('active');
                                    $('.bsk-chooser .bsk-chooser-buttons li:eq('+index+')').addClass('active');
                                    $('.bsk-chooser .full-pic li').removeClass('active');
                                    $('.bsk-chooser .full-pic li:eq('+index+')').addClass('active');
                                    $('.bsk-type').removeClass('active');

                                    if(type === 'bow|aft') {
                                        $('.aft-container, .bow-container').removeClass('uk-hidden');
                                        types = ['aft', 'bow'];
                                    } else if(type === 'aft') {
                                        $('.aft-container').removeClass('uk-hidden');
                                        $('.bow-container').addClass('uk-hidden');
                                        types = [type];
                                    } else {
                                        $('.bow-container').removeClass('uk-hidden');
                                        $('.aft-container').addClass('uk-hidden');
                                        types = [type];
                                    }
                            });



                            $('button#measurements-aft').on('click', function(e) {
                                data = {
                                    type: 'bsk',
                                    name: 'measurements-aft',
                                    cache: false,
                                    args: {
                                        measurements: defaults.aft,
                                        product: products['bsk-aft']
                                    }
                                };
                                lpiModal.getModal(data);
                            });

                            $('button#measurements-bow').on('click', function(e) {
                                data = {
                                    type: 'bsk',
                                    name: 'measurements-bow',
                                    cache: false,
                                    args: {
                                        measurements: defaults.bow,
                                        product: products['bsk-bow']
                                    }
                                };
                                lpiModal.getModal(data);
                            });
                            $.each(types, function(k,type) {
                                self._debug('Measuring the '+type);
                                self.trigger('measure', {item: products['bsk-'+type], type: type});
                            })
                            
                            
                            return data;

                            
                        }
                            
                            
                    ],
                    backToDefaults: [
                        function (data) {
                            m = measurements.aft.location;
                            measurements.changed = false;
                            $('.chosen_boat').text('');
                            $('#startPage select').val(0).trigger('change');
                            $('#beam-width-in').val(m.beam.default);
                            $('#ttop-width-in').val(m.ttop.default);
                            $('#ttop2rod-in').val(m.ttop2rod.default);
                            $('.options-container input').val('');

                            return data;
                        }
                    ],
                    measure: [
                        function (data) {
                            var self = this;
                            var item = data.args.item;
                            var type = data.args.type;
                            var m = defaults[type];
                                if (checkMinAndMax(type)) {
                                    $('.bsk-type-'+type+' input').prop('disabled', false);
                                } else {
                                    data.triggerResult = false;
                                    return false;
                                };
                                getBSKClass(type);
                            
                            function checkMinAndMax() {
                                var result = true;
                                $.each(m, function(k,v){
                                    if(k !== 'changed' && k !== 'tapered') {
                                        var total = item.options[k].value;
                                        if (total < v.min) {
                                            console.log(k+'TooSmall');
                                            self.trigger(k+'TooSmall',data.args);
                                            result =  false;
                                        }
                                        if(total > v.max) {
                                            console.log(k+'TooLarge');
                                            self.trigger(k+'TooLarge',data.args);
                                            result = false;
                                        }
                                    }
                                });

                                item.options.tapered.value = (item.options.ttop.value >= m.tapered.min && item.options.ttop.value <= m.tapered.max);
                                return result;
                            }
                            
                            function getBSKClass(type) {
                                console.log('Getting Class');
                                var kit_class;
                                var old_class = item.options.class.value;
                                var ttop2rod = item.options.ttop2rod.value;
                                console.log(ttop2rod);
                                var cls = null;
                                $.each(defaults.class, function(k,v) {
                                    if(ttop2rod >= v.min && ttop2rod <= v.max) {
                                        cls = k;
                                    }
                                })
                                if($('#use_on_bow').is(':checked')) {
                                    cls++;
                                }
                                kit_class = cls ? defaults.class[cls].name : 'Unknown';

                                item.options.class.value = kit_class;
                                console.log('BSK '+type+' Class is '+kit_class);
                                if(old_class !== kit_class) { 
                                    self._publishPrice(item);
                                }
                            }
                            return data;
                        }
                    ],
                    beforeUpdateQuantity: [],
                    beforeChange: [
                        function (data) {
                            console.log(data);
                            var self = this;
                            if($(data.args.event.target).closest('.options-container').data('id') === 'bsk') {
                                data.publishPrice = false;
                                var name = $(data.args.event.target).prop('name');
                                var value = $(data.args.event.target).val();
                                this.trigger('measure', {item: {type: 'bsk'}, type: measurements.types});
                            }
                            return data;
                        }
                    ],
                    afterChange: [
                        function (data) {
                            var types = measurements.types, self = this;
                            $.each(types, function (k, v) {
                                var bsk = measurements[v];
                                var item = products['bsk-'+v];
                                item.id = 'bsk-'+v;
                                item.price_group = 'bsk.'+bsk.kit.class;
                                self._publishPrice(item);
                            })
                            return data;
                        }
                    ],
                    beforePublishPrice: [
                        function (data) {
                            var type = data.args.type;
                            data.args.elem = $('.'+type+'-container #bsk-price span.price');
                            return data;
                        }
                    ],
                    afterPublishPrice: [
                        function (data) {
                            return data;
                        }
                    ],
                    beamTooSmall: [
                        function (data) {
                            console.log(data);
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'beamtoosmall',
                                value: defaults[type].beam.min
                            });
                            products['bsk-'+type].options.beam.value = defaults[type].beam.min;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    beamTooLarge: [
                        function (data) {
                           var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'beamtoolarge',
                                value: defaults[type].beam.max
                            });
                            products['bsk-'+type].options.beam.value = defaults[type].beam.max;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    ttopTooSmall: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'ttoptoosmall',
                                value: defaults[type].ttop.min
                            });
                            products['bsk-'+type].options.ttop.value = defaults[type].ttop.min;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    ttopTooLarge: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'ttoptoolarge',
                                value: defaults[type].ttop.max
                            });
                            products['bsk-'+type].options.ttop.value = defaults[type].ttop.max;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    ttop2rodTooSmall: [
                        function(data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'ttop2rodtoosmall',
                                value: defaults[type].ttop2rod.min
                            });
                            products['bsk-'+type].options.ttop2rod.value = defaults[type].ttop2rod.min;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    ttop2rodTooLarge: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'ttop2rodtoolarge',
                                value: defaults[type].ttop2rod.max
                            });
                            products['bsk-'+type].options.ttop2rod.value = defaults[type].ttop2rod.max;
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    measurementsNotChanged: [
                        function (data) {
                            var type = data.args.type;
                            lpiModal.getModal({
                                type: 'bsk',
                                name: 'nochange'
                            });
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    beforeAddToCart: [
                        function (data) {
                            var boat_options = this._getOptions();
                            var m = measurements, types = m.types, self = this;
                            var items = {};

                            if(!m.changed) {
                                self.trigger('measurementsNotChanged', {item: {type: 'bsk'}});
                                data.triggerResult = false
                                return data;
                            }

                            $.each(types, function(k,v){

                                var kit = m[v];
                                var item = self.items['bsk-'+v];
                                item.name = 'Boat Shade Kit - '+v;
                                item.price_group = 'bsk.'+kit.kit.class;
                                item.fromCart = true;
                                item.options.tapered = {
                                        name: 'Tapered',
                                        value: 'y',
                                        text: (kit.kit.tapered ? 'Yes' : 'No'),
                                        visible: false
                                    };
                                item.options.kit_type = {
                                        name: 'Kit Type',
                                        value: v,
                                        text: v
                                    };
                                item.options.kit_class = {
                                        name: 'Class',
                                        value: kit.kit.class,
                                        text: kit.kit.class,
                                        visible: false
                                    };
                                item.options.beam_width = {
                                        name: 'Beam Width',
                                        value: kit.location.beam.total,
                                        text: kit.location.beam.total+' in'
                                    };
                                item.options.ttop_width = {
                                        name: 'T-Top Width',
                                        value: kit.location.ttop.total,
                                        text: kit.location.ttop.total+' in'
                                    };
                                item.options.ttop2rod = {
                                        name: 'T-Top to Rod Holders',
                                        value: kit.location.ttop2rod.total,
                                        text: kit.location.ttop2rod.total+' in'
                                    };
                                if(v === 'aft') {
                                    item.options.measurement_source = {
                                            name: 'Measurements Provided By',
                                            value: !m.changed ? 'Default': m.changed,
                                            text: !m.changed ? 'Default': m.changed
                                    };
                                }
                                items[item.id] = item;
                            });
                            data.args.items = items;
                            return data;
                        }
                    ]
                }
            },
            removeValues: true,
            pricePoints: {
                item: ['aft_kit_class']
            }
            
            
            
            
        });

    })
</script>