// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;
(function ($, window, document, undefined) {

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).


    // The actual plugin constructor
    var OrderForm = function (element, options) {
        this.$element = $(element);
        this.defaults = {
            validate: true,
            debug: true,
            events: {}
        };
        this.settings = $.extend(true, this.defaults, options);
        // Initialize the Plugin
        this.name = options.name;
        this.confirm = {
            elem: null,
            modal: null,
            button: null,
            cancel: null,
            id: null
        };
        this.items = {};
        this.$atc = this.$element.find('.atc');
        this.$qty = this.$element.find('.qty');
        this.init();

        
//         Set the event handlers
        this.$atc.on('click', $.proxy(this, 'addToCart'));
        this.$qty.on('change', $.proxy(this, '_updateQuantity'));
        this.$element.on('input','input.item-option', $.proxy(this, '_refresh'));
        this.$element.on('change','select.item-option', $.proxy(this, '_refresh'));
        this.$element.on('change','textarea.item-option', $.proxy(this, '_refresh'));
        this.trigger('onComplete');

    };

    OrderForm.prototype = {
        type: null,
        current_items: {},
        fields: {},
        cart: {
            validated: false,
            items: {},
            id: null,
            confirmed: false
        },
        validation: {
            message: null,
            messageData: {
                    message : '<span>Please complete the fields in red!</span><i class="uk-icon-arrow-down uk-margin-left" />',
                    status  : 'danger',
                    timeout : 5000,
                    pos     : 'top-center'
            },
            sendMessage: function () {
                if (!this.message) {
                    this.message = UIkit.notify(this.messageData);
                }
                    
            },
            closeMessage: function () {
                if(this.message) {
                    this.message.close();
                    this.message = null;
                }
            }
        },
        init: function () {
            var self = this;
            this.loadItems();
            this.$element.find('#price').remove();
            this._createConfirmModal();
            this.trigger('onInit', {items: this.items});
            $.each(this.$qty, function (k, v) {
                var id = $(v).data('id');
                self.items[id].qty = $('#qty-'+id).val();
            });
            
            
        },
        loadItems: function() {
            var elems = this.$element.find('.orderForm'), self = this;
            $.each(elems, function(k, v) {
                var elem = $(v);
                var id = elem.prop('id');
                var items = elem.data('item');
                
                $.each(items, function(key, item) {
                    self.items[id] = item;
                }); 
            });
            console.log(self.items);
            this._getFields();
            //this._getOptions();
        },
        setMarkup: function(args) {
            var id = args[0];
            var markup = args[1];
            this.items[id].markup = markup;
        },
        _createConfirmModal: function () {
            this.confirm.elem = this.$element.find('#confirm-modal');
            this.confirm.button = this.confirm.elem.find('button.confirm');
            this.confirm.cancel = this.confirm.elem.find('button.cancel');
            this.confirm.modal = $.UIkit.modal(this.confirm.elem);
            this.confirm.modal.options.bgclose = false;
            this.confirm.button.on('click', $.proxy(this, '_confirm'));
            this.confirm.cancel.on('click', $.proxy(this, '_clearConfirm'));
        },
        getEvents: function (id, types) {
            
            var self = this, events = [];
            if (typeof this._events[id] !== 'undefined') {
                $.each(self._events[id], function(k,v) {
                        events.push(v);
                });
            }
            if (typeof this.settings.events[id] !== 'undefined') {
                $.each(self.settings.events[id], function(k,v) {
                        events.push(v);
                });
                
            }
            $.each(types, function (k,type) {
                if (typeof self.settings.events[type] !== 'undefined' && typeof self.settings.events[type][id] !== 'undefined') {
                    $.each(self.settings.events[type][id], function(k,v) {
                        events.push(v);
                    });
                }
            });
            return events;
        },
        _events: {
            onInit: [
                function (data) {
                    this._debug('OrderForm Plugin Initialized.', false);
                    return data;
                }
            ],
            beforeAddToCart: [
                function (data) {
                    // The beforeAddToCart must return an array of item objects
                    this._debug('beforeAddToCart Callback');
                    return data;
                }
            ],
            afterAddToCart: [
                function (data) {
                    this._clearConfirm();
                    this.$qty.val(1);
                    this.validation.status = null;
                    return data;
                }
            ],
            beforeChange: [
                function (data) {
                    var elem = $(data.args.event.target),
                    name = elem.prop('name'),
                    option = data.args.item.options[name];
                    if(this._isPriceOption(option.type) || this._isBaseOption(option.type)) {
                        data.publishPrice = true;
                    } else {
                        data.publishPrice = false;
                    }
                                  
                    return data;
                }
            ],
            afterchange: [],
            beforeUpdateQuantity: [],
            afterUpdateQuantity: [],
            onComplete: [
                function (data) {
                    this._debug('OrderForm Plugin Complete.', true);
                    return data;
                }
            ],
            beforeValidation: [],
            afterValidation: [],
            beforeConfirmation: [],
            afterConfirmation: [],
            validation_pass: [
                function (data) {
                    this._debug('Validation Passed!');
                    this.validation.complete = true;
                    this.validation.closeMessage();
                    return data;
                }
            ],
            validation_fail: [
                function (data) {
                    this._debug('Validation Failed!');
                    this.validation.status = 'failed';
                    this.validation.sendMessage();
                    return data;
                }
            ],
            confirmation: [],
            beforePublishPrice: [],
            afterPublishPrice: []
        },
        trigger: function (event, args) {
            
            var self = this, types = [];

            
            if(typeof args === 'undefined') {
                args = {};
            }

            if(args.item) {
                types.push(args.item.type);
            }
            if(args.items) {
                $.each(args.items, function (k,v) {
                    types.push(v.type);
                });
            }
            
            result = {};
            result.args = args;
            result.triggerResult = true;
            var events = this.getEvents(event, types);
            $.each(events, function (k, v) {
                self._debug('Starting ' + event + ' ['+k+']');
                result = v.call(self,result);
                if (result.triggerResult === 'break') {
                    self._debug('Breaking from '+event+' event.');
                    return false;
                }
                self._debug(event + ' Complete. ['+k+']');
            });
            return result;
        },
        addToCart: function (e) {
            this._debug('Adding To Cart');
            var triggerData = this.trigger('beforeAddToCart', {item: item});
            product = triggerData.args.item;
            var self = this;
            // var elem = $('#'+item.id+'-price span');
            // elem.html('<i class="uk-icon-refresh uk-icon-spin"></i>');
            $.ajax({
                type: 'POST',
                url: "?option=com_zoo&controller=cart&task=add&format=json",
                data: {product: product},
                success: function(data){
                    console.log(data);
                },
                error: function(data, status, error) {
                    var elem = $('#'+item.id+'-price span');
                    elem.html('ERROR');
                    self._debug('Error');
                    self._debug(status);
                    self._debug(error);
                },
                dataType: 'json'
            });
        },
        clearCart: function() {
            this.cart.id = null;
            this.cart.items = {};
            this.cart.validated = false;
            this.cart.confirmed = false;
        },
        getItem: function(id) {
            console.log(id);
            return this.items[id];
        },
        _confirmation: function (items, cart_id) { 
            var result = false;
            $.each(items, function (k,item) {
                if(item.confirm) {
                    result = true;
                }
            })                   

            if (this.cart.confirmed) {
                return true;
            }

            if (!result) {
                return true;
            }

            this._debug('Starting Confirmation');
            var triggerData = this.trigger('beforeConfirmation', {items: items});
            items = triggerData.args.items;
            var result = false;
            $.each(items, function (k,item) {
                if(item.confirm) {
                    result = true;
                }
            })

            var self = this, container;
            this.confirm.elem.find('[name="cart_id"]').val(cart_id);
            $.each(items, function(k,item) {
                var title = typeof item.title === 'undefined' ? item.name : item.title;
                container = $('<div id="'+item.id+'" class="uk-width-1-1"></div>').append('<div class="item-name uk-width-1-1 uk-margin-top uk-text-large">'+title+'</div>').append('<div class="item-options uk-width-1-1 uk-margin-top"><table class="uk-width-1-1"></table></div>');
                
                $.each(item.options, function(k, option){
                    if (typeof option.visible === 'undefined' || option.visible) {
                        container.find('.item-options table').append('<tr><td class="item-options-name">'+option.name+'</td><td class="item-options-text">'+option.text+'</td></tr>');
                    }
                });
                self.confirm.elem.find('.item').append(container);
            
            });
            this.confirm.modal.show();
            return false;
        },
        _isPriceOption: function(type) {
            var haystack = type.split('|');
            var needle = 'price';
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) return true;
            }
            return false;
        },
        _isBaseOption: function(type) {
            var haystack = type.split('|');
            var needle = 'base';
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) return true;
            }
            return false;
        },
        _confirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            if (accept.val().toLowerCase() === 'yes') {
                modal.hide();
                this._clearConfirm();
                this.cart.confirmed = true;
                var id = this.confirm.elem.find('[name="cart_id"]').val();
                $('#atc-'+id).trigger('click');
            } else {
                error.html('You must type "yes" or press cancel.');            
            }
        },

        _clearConfirm: function() {
            var modal = this.confirm.elem;
            var accept = modal.find('[name="accept"]');
            var error = modal.find('.confirm-error');
            
            modal.find('.item-name').html('');
            modal.find('.item-options').html('');
            accept.val('');
            error.html('');
            this.confirm.modal.hide();
            this.clearCart();
        },
        _cartItemID: function () {
            return $.md5(JSON.stringify(this.item));
        },
        _getPricing: function() {
            var pricing = {}, options = '';
            var opts = this._getOptions();
            var attributes = this._getAttributes();
            pricing.group = this.settings.pricePoints.group;
            var markup = $('input[name="markup"]').val();
            $.each(this.settings.pricePoints.options, function(k,v) {
                if($.type(opts[v]) !== 'undefined') {
                    options += '.'+opts[v].value;
                    return false;
                }
                if($.type(attributes[v]) !== 'undefined') {
                    options += '.'+attributes[v].value;
                    return false;
                }
            });
            pricing.group += options;
            pricing.markup = markup;
            return pricing;
        },
        _publishPrice: function (item) {
            this._debug('Publishing Price');
            var triggerData = this.trigger('beforePublishPrice', {item: item});
            product = triggerData.args.item;
            var self = this;
            var elem = $('#'+item.id+'-price span');
            elem.html('<i class="uk-icon-refresh uk-icon-spin"></i>');
            $.ajax({
                type: 'POST',
                url: "?option=com_zoo&controller=price&task=getPrice&format=json",
                data: {product: product},
                success: function(data){
                    
                    var price = data.price;
                    elem.html(price.toFixed(2));
                    self.trigger('afterPublishPrice', {price: price, item: item});
                    $('#patternID').html(data.product.pattern);
                },
                error: function(data, status, error) {
                    var elem = $('#'+item.id+'-price span');
                    elem.html('ERROR');
                    self._debug('Error');
                    self._debug(status);
                    self._debug(error);
                },
                dataType: 'json'
            });

            
        },
        _getOptionValue: function (key, name) {
            return this.items[key].options[name].value;
        },
        _updateOptionValue: function (id, elem) {
            var options = this.items[id].options;
            var name = elem.prop('name');
            var value = elem.val();
            var text = $(elem).children('option:selected').text();
            options[name].value = value;
            options[name].text = text;
            console.log(options[name]);
        },
        _getFields: function() {
            var elems = this.$element.find('input.item-option, select.item-option, textarea.item-option'), self = this;
            var fields = {};
            $.each(elems, function(k, field) {
                var id = $(this).closest('.options-container').data('id');
                if(typeof fields[id] === 'undefined') {
                    fields[id] = {};
                }
                fields[id][$(this).prop('name')] = $(field);
            });
            this.fields = fields;
        },
        _getPrices: function () {
            this.prices = this.$element.data('prices');
        },
        _updateQuantity: function (e) {
            this._debug('Updating Quantity');
            var elem = $(e.target);
            var id = elem.data('id');
            var item = this.items[id];
            var triggerData = this.trigger('beforeUpdateQuantity', {event: e, item: item});
            item = triggerData.args.item;
            item.qty = elem.val();
            triggerData = this.trigger('afterUpdateQuantity', {event: e, item: item});
            item = triggerData.args.item;
            this._publishPrice(item);
        },
        _refresh: function (e) {
            var id = $(e.target).closest('.options-container').data('id'), self = this;
            triggerData = this.trigger('beforeChange', {event: e, item: this.items[id]});
            console.log(triggerData);
            this._updateOptionValue(id, $(e.target));
            var publishPrice = typeof triggerData.publishPrice === 'undefined' ? true : triggerData.publishPrice;
            if(publishPrice) {
                self._publishPrice(this.items[id]);
            }
            if (this.validation.status === 'failed') {
                this._validate([this.items[id]]);
            }
            this.trigger('afterChange', {event: e, item: this.items[id]});
            
        },
        _validate: function (items) {

            if(!this.settings.validate || this.cart.validated) {
                return true;
            }

            var self = this, validated = true;
            self.$element.find('.validation-fail').removeClass('validation-fail');
            $.each(items, function (key, item) {
                var fields = !self.fields[item.id] ? {} : self.fields[item.id];
                $.each(fields, function (k, v) {
                    if($(this).hasClass('required') && ($(this).val() === 'X' || $(this).val() === '')) {
                        $(this).addClass('validation-fail');
                        self._debug($(this).prop('name') + 'Failed Validation');
                        validated = false;
                    };
                });
            })

            if(validated) {
                this.trigger('validation_pass');
            } else {
                this.trigger('validation_fail');
            }
            return validated;
        },
        _debug: function (status, showThis) {
            if (!this.settings.debug) {
                return false;
            }
            console.log(status);
            if (showThis) {
                console.log(this);
            }
            

        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn.OrderForm = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;
        var plugin = 'OrderForm';
        var $set = this.each(function () {
            var $this = $(this);
            var data = $this.data(plugin);
            var options = typeof option === 'object' && option;
            if (!data)
                $this.data(plugin, (data = new OrderForm(this, options)));
                if (typeof option === 'string') {
                    methodReturn = data[ option ].apply(data, args);
                }
                
        });
        return (methodReturn === undefined) ? $set : methodReturn;
    };
})(jQuery, window, document);