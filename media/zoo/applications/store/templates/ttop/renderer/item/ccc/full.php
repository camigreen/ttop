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

$this->template = $this->app->zoo->getApplication()->getTemplate()->getPath().'/renderer/item/ccc/';
$type = 'orderform';
$this->form = $this->app->form->create(array($this->template.'config.xml', compact('type')));
$this->form->setValue('template', $this->template);
var_dump($product);
?>
<article>
    <span class="uk-article-title"><?php echo $item->name; ?></span>
</article>
<div id="OrderForm-ccc" class="uk-form uk-margin" data-id='<?php echo $product->id; ?>'>
    <div class="uk-grid">
        <div class="uk-width-2-3 ccc-slideshow">
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
                            <div class="uk-width-1-1 uk-margin-top options-container" data-id="ccc">
                                <fieldset> 
                                    <legend>
                                        <?php echo JText::_('Boat Information'); ?>
                                    </legend>
                                    <div class="uk-grid">
                                        <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        
                                    </div>
                                </fieldset>
                            </div>
                        <?php endif; ?>
                        <p class="uk-text-danger">Please refer to the maintenance section in the Info & Video Tab above.</p>
                        <div class="uk-grid ccc-measurements">
                            <div class="uk-width-1-2">
                                <div class="uk-width-1-1">
                                    <div class="uk-margin-top">
                                        <a href="<?php echo JURI::root(); ?>/images/curtain/order_form/diagram1.png" data-lightbox title="">
                                            <img src="<?php echo JURI::root(); ?>/images/curtain/order_form/diagram1.png" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-width-1-1">
                                    <div class="uk-width-1-1 uk-grid price-container">
                                        <?php if ($this->checkPosition('pricing')) : ?>
                                                <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="uk-width-1-1">
                                    <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
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
                                    <button id="btn_my_measurements" class="uk-width-1-1 uk-button uk-button-danger" data-mode="EMM">Enter My Own Measurements</button>
                                </div>
                                <div class="uk-width-1-1 uk-margin-top ccc-measurement">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Measurements'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <div class="uk-width-1-1 ">
                                                <label>1) Height from T-Top to the Deck</label>
                                                <div class="uk-grid">
                                                    <div class="uk-width-2-6">
                                                       <input type="number" id="ttop2deck" name="ttop2deck" class="required" min="0" value="76" />
                                                    </div>
                                                    <div class="uk-width-1-6">
                                                        in
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1 1 ccc-measurement">
                                                <label>2) Rear of Helm Seat to Front of Console Seat</label>
                                                <div class="uk-grid">
                                                    <div class="uk-width-2-6">
                                                       <input type="number" id="helm2console" name="helm2console" class="required" min="0" value="75" />
                                                    </div>
                                                    <div class="uk-width-1-6">
                                                        in
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-width-1-1 1 ccc-measurement">
                                                <label>3) Width of the Helm Seat</label>
                                                <div class="uk-grid">
                                                    <div class="uk-width-2-6">
                                                       <input type="number" id="helmSeatWidth" name="helmSeatWidth" class="required" min="0" value="38" />
                                                    </div>
                                                    <div class="uk-width-1-6">
                                                        in
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="uk-width-1-1 options-container" data-id="ccc">
                                <label>Additional Information<span class="uk-text-small uk-margin-left">(other)</span></label>
                                <textarea class="uk-width-1-1 item-option" style="height:120px;" name="add_info" ></textarea>
                            </div>
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
        </div>
        <div class="uk-width-1-3 uk-margin-top">
            <div class="uk-width-1-1 uk-grid price-container">
                <div id="ccc-price" class="uk-width-1-1">
                    <i class="currency"></i>
                        <span class="price">0.00</span>
                </div>
            </div>
            <div class="uk-width-1-1">
                <p class="uk-text-danger" style="font-size:18px">Fill out the measurements below for your custom price.</p>
            </div>
            <div class="uk-width-1-1 options-container uk-margin-top" data-id="ccc">
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
                <input id="qty-ccc" type="number" class="uk-width-1-1 qty" name="qty" data-id="ccc" min="1" value ="1" />
                <div class="uk-margin-top">
                    <button id="atc-ccc" class="uk-button uk-button-danger atc" data-id="ccc"><i class="uk-icon-shopping-cart" style="margin-right:5px;"></i>Add to Cart</button>
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
                        <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that the Center Console Curtain is a custom made product and that if I have chosen an option incorrectly it may lead to the Curtain not fitting my boat correctly.</div>
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

    if(typeof items === 'undefined') { var items = {} };
    items['<?php echo $product->id; ?>'] = <?php echo $product->toJson(true); ?>;
    var info_modal = jQuery.UIkit.modal('#info_modal');
    var startPageModal = jQuery.UIkit.modal('#startPage');
    var CCC = {
        price: 0.00,
        type: null,
        measurements_changed: false,
        mode: 'CYB',
        area: 0,
        classes: {
            A: 3888,
            B: 5243,
            C: 6720,
            D: 8512
        },
        options: {
            ttop2deck: {
                name: 'T-Top to Deck Measurement',
                text: null,
                value: 0,
                min: 76,
                max: 88,
                default: 76
            }, 
            helm2console: {
                name: 'Rear of Helm Seat to Front of Console Seat Measurement',
                text: null,
                value: 0,
                min: 75,
                max: 133,
                default: 95
            },
            helmSeatWidth: {
                name: 'Width of Helm Seat Measurement',
                text: null,
                value: 0,
                min: 38,
                max: 62,
                default: 50
            }   
        },
        class: {
            name: 'Curtain Class',
            text: null,
            value: null,
            visible: false
        }
        
    };

    jQuery(document).ready(function($){
        lpiModal.init('.modals');
        $('#OrderForm-ccc').OrderForm({
            name: 'CenterConsoleCurtain',
            validate: true,
            confirm: false,
            debug: true,
            events: {
                ccc: {
                    onInit: [
                        function (data) {
                            var self = this;
                            this.$element.on('measure', function(e, data){
                                return self.trigger('measure', {item: self.item, location: data.location}).triggerResult;
                            });
                            this.$element.on('backToDefaults', function(e, data){
                                return self.trigger('backToDefaults', {item: self.item, action: 'measurements'}).triggerResult;
                            });
                            this.trigger('backToDefaults', {item: this.item});
                            this.trigger('measure', {item: this.item});
                            //this.trigger('measure2', {});
                            $('.ccc-measurement').hide();
                            $('.ccc-measurement input').on('change', function(e){
                                CCC.measurements_changed = 'customer';
                                var adjust = false;
                                if($(e.target).prop('name') === 'helm2console') {
                                    adjust = true;
                                }
                                self.trigger('measure',{item: self.item});

                            });
                            $('[name="fabric"]').on('change',function (e) {
                                console.log('Color Change');
                                self.trigger('changeColor', {item: self.item, fabric: $(e.target).val()});
                            });

                            $('#startPage #btn_continue').on('click', function() {
                                startPageModal.hide();
                            });

                            $('#startPage #btn_enter_my_own').on('click', function() {
                                self.trigger('backToDefaults', {item: self.item});
                                startPageModal.hide();
                            });

                            $('#btn_find_my_boat').on('click', function(e) {
                                var elem = $(e.target);
                                self.trigger('startPage', {item: self.item, mode: elem.data('mode')});
                                CCC.mode = elem.data('mode');
                                console.log(CCC.mode);
                            });

                            $('#btn_my_measurements').on('click', function(e) {
                                $('.ccc-measurement').show();
                                var elem = $(e.target);
                                self.trigger('backToDefaults', {item: self.item, mode: elem.data('mode')});
                                CCC.mode = elem.data('mode') ? elem.data('mode') : CCC.mode;
                                self.trigger('measure', {item: self.item});
                                console.log(CCC.mode);
                            });

                            this._publishPrice(this.item);
                            return data;
                        }
                           
                    ],
                    beforeChange: [],
                    startPage: [
                        function (data) {
                            var data = {
                                type: 'default',
                                name: 'boatchooser',
                                args: {product: this.item, kind: 'ccc'},
                                cache: false
                            };
                            lpiModal.getModal(data);

                            return data;
                        }
                    ],
                    backToDefaults: [
                        function (data) {
                            if(CCC.mode === data.args.mode) {
                                return data;
                            }
                            console.log(data);
                            var m = CCC.options, action = 'all';
                            $('.chosen_boat').text('');
                            $('#ttop2deck').val(m.ttop2deck.default);
                            $('#helm2console').val(m.helm2console.default);
                            $('#helmSeatWidth').val(m.helmSeatWidth.default);
                            $('#startPage select').val(0).trigger('change');
                            $('.options-container input').val('');

                            CCC.measurements_changed = false;
                            
                            return data;
                        }
                    ],
                    measure2: [
                        function(data) {
                            console.log('Running Measure 2');

                            return data;
                        }
                    ],
                    measure: [
                        function (data) {
                            var self = this, location = data.args.location;
                            getMeasurements();
                            
                            var adjust = typeof data.args.adjustHSW === 'undefined' ? false : data.args.adjustHSW;
                            if(checkMinandMax(location)) {
                                getCCCClass();
                                if(adjust) {
                                    adjustHelmSeatWidth();
                                };
                                this.item.options.ttop2deck.value = CCC.options.ttop2deck.value;
                                this.item.options.ttop2deck.text = CCC.options.ttop2deck.value + ' inches';
                                this.item.options.helm2console.value = CCC.options.helm2console.value;
                                this.item.options.helm2console.text = CCC.options.helm2console.value + ' inches';
                                this.item.options.helmSeatWidth.value = CCC.options.helmSeatWidth.value;
                                this.item.options.helmSeatWidth.text = CCC.options.helmSeatWidth.value + ' inches';
                                this.item.options.measurement_source.value = !CCC.measurements_changed ? 'default': CCC.measurements_changed;
                                if(this.item.options.class.value != CCC.class.value) {
                                    this.item.options.class.value = CCC.class.value;
                                    this._publishPrice(this.item);
                                }
                                
                            } else {
                                data.triggerResult = false;
                            }

                            return data;
                            

                            function getMeasurements() {
                                var measurements = $('.ccc-measurement input[type="number"]'), length = {};
                                
                                measurements.each(function(k,v){
                                    var name = $(this).prop('name');
                                    value = parseInt($(v).val());
                                    CCC.options[name].value = value;
                                    CCC.options[name].text = value+' inches';
                                });
                                CCC.area = CCC.options.helm2console.value*CCC.options.helmSeatWidth.value;
                                console.log(CCC);
                            };
                            
                            function checkMinandMax(location) {
                                var ttop2deck = CCC.options.ttop2deck, helm2console = CCC.options.helm2console, helmSeatWidth = CCC.options.helmSeatWidth, proceed = true;
                                self._debug('Checking Mins and Maxs');
                                var data = {item: self.item};
                                // Checking ttop2deck Width

                                if(typeof location === 'undefined') {
                                    $.each(CCC.options, function(k,v) {
                                        self._debug('Checking Min and Max on '+k+ ' ('+v.value+')');
                                        if(v.value < v.min) {
                                            self.trigger(k+'TooSmall', data);
                                            return false;
                                        }
                                        if(v.value > v.max) {
                                            self.trigger(k+'TooLarge', data);
                                            return false;
                                        }
                                        self._debug(k+' measurement fit criteria');
                                    })
                                    return true;
                                }

                                entry = CCC.options[location];
                                self._debug('Checking Min and Max on '+location + ' ('+entry.value+')');
                                if(entry.value < entry.min) {
                                    self.trigger(location+'TooSmall', data);
                                    return false;
                                }

                                if(entry.value > entry.max) {
                                    self.trigger(location+'TooLarge', data);
                                    return false;
                                }
                                self._debug(location+' measurement fit criteria');
                                return true;
                                
                            };

                            function getCCCClass() {
                                var area = CCC.area;
                                console.log(area);

                                if(area <= CCC.classes.A) {
                                    CCC.type = 'A';
                                }
                                if(area > CCC.classes.A && area <= CCC.classes.B) {
                                    CCC.type = 'B';
                                }
                                if(area > CCC.classes.B && area <= CCC.classes.C) {
                                    CCC.type = 'C';
                                }
                                if(area > CCC.classes.C && area <= CCC.classes.D) {
                                    CCC.type = 'D';
                                }
                                if(area > CCC.classes.D) {
                                    CCC.type = 'E';
                                }
                                CCC.class.value = CCC.type;
                                CCC.class.text = CCC.type + ' Class';
                                self.item.price_group = 'ccc.'+CCC.type;
                                self._debug('CCC class is '+CCC.type);

                                        
                            };
                            function adjustHelmSeatWidth() {
                                self._debug('Adjusting Helm Seat Width');
                                var elem = $('[name="helmSeatWidth"]');
                                switch(CCC.type) {
                                    case 'A':
                                    case 'B':
                                        CCC.options.helmSeatWidth.min = 38;
                                        CCC.options.helmSeatWidth.max = 50;
                                        CCC.options.helmSeatWidth.default = 38;
                                        CCC.options.helmSeatWidth.value = 38;
                                        elem.val(38);
                                        break;
                                    case 'C':
                                        CCC.options.helmSeatWidth.min = 44;
                                        CCC.options.helmSeatWidth.max = 56;
                                        CCC.options.helmSeatWidth.default = 44;
                                        CCC.options.helmSeatWidth.value = 44;
                                        elem.val(44);
                                        break;
                                    case 'D':
                                        CCC.options.helmSeatWidth.min = 45;
                                        CCC.options.helmSeatWidth.max = 62;
                                        CCC.options.helmSeatWidth.default = 45;
                                        CCC.options.helmSeatWidth.value = 45;
                                        elem.val(45);
                                        break;

                                };
                                console.log(CCC);
                            };
                        }
                    ],
                    changeColor: [
                        function (data) {
                            var fabric = data.args.fabric;
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
                                colorSelect.val('N').trigger('input');
                            }
                            return data;
                        }
                    ],
                    beforePublishPrice: [],
                    afterPublishPrice: [],
                    ttop2deckTooSmall: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.ttop2deck.name+' under '+CCC.options.ttop2deck.min+' inches are too small for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                            
                            $('.ccc-measurement #ttop2deck').val(CCC.options.ttop2deck.min);
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Contact Us');
                            
                            $('#info_modal button.cancel').click(function(){
                                $('#info_modal button').off();
                                info_modal.hide();

                            });
                            this.trigger('measure');
                            info_modal.options.bgclose = false;
                            info_modal.show();
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    ttop2deckTooLarge: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.ttop2deck.name+' over '+CCC.options.ttop2deck.max+' inches are too large for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                            
                            
                            $('.ccc-measurement #ttop2deck').val(CCC.options.ttop2deck.max);
                            
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Contact Us');
                            
                            $('#info_modal button.cancel').click(function(){
                                $('#info_modal button').off();
                                info_modal.hide();
                            });

                            this.trigger('measure');
                            info_modal.options.bgclose = false;
                            info_modal.show();
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    helm2consoleTooSmall: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.helm2console.name+' under '+CCC.options.helm2console.min+' inches are too small for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us and we may be able to make a custom curtain for your boat.  Click the contact us button below to send us an email.');
                            
                            $('.ccc-measurement #helm2console').val(CCC.options.helm2console.min);
                            
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Contact Us');
                            
                            $('#info_modal button.cancel').click(function(){
                                $('#info_modal button').off();
                                info_modal.hide();

                            });
                            this.trigger('measure');
                            info_modal.options.bgclose = false;
                            info_modal.show();
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    helm2consoleTooLarge: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.helm2console.name+' over '+CCC.options.helm2console.max+' inches are too large for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                            
                            $('.ccc-measurement #helm2console').val(CCC.options.helm2console.max);
                            
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Contact Us');
                            
                            $('#info_modal button.cancel').click(function(){  
                                $('#info_modal button').off();
                                info_modal.hide();
                            });
                            
                            this.trigger('measure');
                            info_modal.options.bgclose = false;
                            info_modal.show();
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    helmSeatWidthTooSmall: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.helmSeatWidth.name+' under '+CCC.options.helmSeatWidth.min+' inches are too small for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                            
                            $('.ccc-measurement #helmSeatWidth').val(CCC.options.helmSeatWidth.min);
                            
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Boat Shade Kit');

                            $('#info_modal button.cancel').click(function(){
                                $('#info_modal button').off();
                                info_modal.hide();
                            });
                            this.trigger('measure');
                            info_modal.options.bgclose = false;
                            info_modal.show();
                            data.triggerResult = false;
                            return data;
                        }
                    ],
                    helmSeatWidthTooLarge: [
                        function (data) {
                            $('#info_modal').find('.ttop-modal-title').html('Boats with a '+CCC.options.helmSeatWidth.name+' over '+CCC.options.helmSeatWidth.max+' inches are too large for our Center Console Curtain.');
                            $('#info_modal').find('.ttop-modal-subtitle').html('Contact us for a modified custom Center Console Curtain.  Click the contact us button below to send us an email.');
                            
                            $('.ccc-measurement #helmSeatWidth').val(CCC.options.helmSeatWidth.max);
                            
                            $('#info_modal button.confirm').click(function(){
                                window.location = '/about-us/contact-us';
                            }).html('Contact Us');
                                
                            $('#info_modal button.cancel').click(function(){
                                
                                $('#info_modal button').off();
                                info_modal.hide();

                            });

                            this.trigger('measure');
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
                            $('#info_modal').find('.ttop-modal-subtitle').html('The measurements on the order form are initially set to the lowest sizes that will work with the Center Console Curtain. Please make sure that the measurements entered match the measurements of your boat.  If the measurements in the order form are correct click Continue or click Back to correct them.');
                            
                            $('#info_modal button.confirm').click(function(){
                                CCC.measurements_changed = true;
                                info_modal.hide();
                                $('#atc-ccc').trigger('click');
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
                            
                            if (!CCC.measurements_changed) {
                                this.trigger('measurementsNotChanged', {item: this.item});
                                data.triggerResult = false;
                                console.log(data);
                                return data;
                            }
                            var item = data.args.item;
                            data.args.item = item;

                            console.log(data);
                            return data;
                        }
                    ],
                    afterAddToCart: [
                        function (data) {
                            CCC.measurements_changed = false;
                            return data;
                        }
                    ]
                }
            }
        });
    })
</script>