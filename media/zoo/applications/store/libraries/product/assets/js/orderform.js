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
        this.item = typeof options.item !== 'undefined' ? options.item : items[this.$element.data('id')];
        this.$atc = this.$element.find('#atc-'+this.item.id);
        this.$qty = this.$element.find('#qty-'+this.item.id);
        this.init();

        
//         Set the event handlers
        this.$atc.on('click', $.proxy(this, 'addToCart'));
        this.$qty.on('change', $.proxy(this, '_updateQuantity'));
        this.$element.on('input','input.item-option', $.proxy(this, '_refresh'));
        this.$element.on('change','select.item-option, textarea.item-option', $.proxy(this, '_refresh'));
        this.trigger('onComplete');
    };

    OrderForm.prototype = {
        type: null,
        current_items: {},
        fields: {},
        cart: lpiCart,
        modal: lpiModal,
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
            this.$element.find('#price').remove();
            this.trigger('onInit', {item: this.item});
            $.each(this.$qty, function (k, v) {
                var id = $(v).data('id');
                self.item.qty = $('#qty-'+id).val();
            });
            
            
        },
        setMarkup: function(args) {
            var id = args[0];
            var markup = args[1];
            this.item.markup = markup;
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
                    var self = this;
                    $.each(data.args.items, function(k, item) {
                        self._clearConfirm(item);
                    })
                    
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
                    if(this._isPriceOption(option) || this._isBaseOption(option)) {
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
            console.log(args);
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
            var items = [this.item], proceed = true;
            var triggerData = this.trigger('beforeAddToCart', {items: items});
            if(!triggerData.triggerResult) {
                return;
            }
            items = triggerData.args.items;
            console.log(items);
            var self = this;
            if(!this._validate(items)) {
                return;
            }
            $.each(items, function(k, item) {
                console.log(item);
                if(self.settings.confirm && !item.params.confirmed) {
                    self._confirmation(item);
                    proceed = false
                    return false;
                }
            })
            if(!proceed) {
                console.log('Cannot Add to Cart');
                return;
            }
            
            console.log(items);
            this.cart.add(items);
            var triggerData = this.trigger('afterAddToCart', {items: items});
        },
        clearCart: function() {
            this.cart.id = null;
            this.cart.items = {};
            this.cart.validated = false;
            this.cart.confirmed = false;
        },
        getItem: function() {
            return this.item;
        },
        setItemConfirmation: function(confirm) {
            this.item.params.confirmed = confirm;
            console.log(this.item);
        },
        _isConfirmed: function() {
            return this.item.params.confirmed;
        },
        _confirmation: function (item) {
            this._debug('Starting Confirmation on ' + item.name); 
            var data = {
                type: 'default',
                name: 'confirm',
                args: {item: item},
                cache: false
            };
            lpiModal.getModal(data);
        },
        _clearConfirm: function(item) {
            item.params.confirmed = false;
        },
        _isPriceOption: function(option) {
            var haystack = option.type.split('|');
            var needle = 'price';
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) return true;
            }
            return false;
        },
        _isBaseOption: function(option) {
            var haystack = option.type.split('|');
            var needle = 'base';
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle) return true;
            }
            return false;
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
        _publishPrice: function (args) {
            this._debug('Publishing Price');

            var triggerData = this.trigger('beforePublishPrice', {item: args.item, type: args.type});
            product = triggerData.args.item;
            var self = this;
            var elem = typeof triggerData.args.elem === 'undefined' ? $('#'+product.id+'-price span') : triggerData.args.elem;
            elem.html('<i class="uk-icon-refresh uk-icon-spin"></i>');
            $.ajax({
                type: 'POST',
                url: "?option=com_zoo&controller=price&task=getPrice&format=json",
                data: {product: product},
                success: function(data){
                    console.log(elem);
                    var price = data.price;
                    elem.html(price.toFixed(2));
                    self.trigger('afterPublishPrice', {price: price, item: product, type: args.type});
                    $('#patternID').html(data.product.pattern);
                },
                error: function(data, status, error) {
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
        _updateOptionValue: function (elem) {
            var options = this.item.options;
            var name = elem.prop('name');
            var value = elem.val();
            var text = $(elem).children('option:selected').text();
            options[name].value = value;
            options[name].text = text ? text : value;
            console.log(options[name]);
        },
        _getFields: function() {
            var elems = this.$element.find('input.item-option, select.item-option, textarea.item-option'), self = this;
            var fields = {};
            $.each(elems, function(k, field) {
                fields[$(this).prop('name')] = $(field);
            });
            this.fields = fields;
        },
        _getPrices: function () {
            this.prices = this.$element.data('prices');
        },
        _updateQuantity: function (e) {
            this._debug('Updating Quantity');
            var elem = $(e.target);
            var item = this.item;
            if(elem.val() === item.qty) {
                this._debug('Quantity Not Changed');
                return;
            }
            var triggerData = this.trigger('beforeUpdateQuantity', {event: e, item: item});
            item = triggerData.args.item;
            item.qty = elem.val();
            triggerData = this.trigger('afterUpdateQuantity', {event: e, item: item});
            item = triggerData.args.item;
            console.log(item);
            this._publishPrice(triggerData.args);
        },
        _refresh: function (e) {
            var self = this;
            console.log(this.item);
            triggerData = this.trigger('beforeChange', {event: e, item: this.item});
            console.log(triggerData);
            if(!triggerData.triggerResult) {
                return;
            }
            this._updateOptionValue($(e.target));
            var publishPrice = typeof triggerData.publishPrice === 'undefined' ? true : triggerData.publishPrice;
            if(publishPrice) {
                self._publishPrice(triggerData.args);
            }
            if (this.validation.status === 'failed') {
                this._validate([this.item]);
            }
            this.trigger('afterChange', {event: e, item: this.item});
            
        },
        _validate: function (items) {
            this._debug('Starting Validation');
            if(!this.settings.validate) {
                return true;
            }
            var self = this, validated = true;
            self.$element.find('.validation-fail').removeClass('validation-fail');

            $.each(this.item.options, function(name, option) {
                console.log(option);
                if(typeof option.value === 'undefined' || !option.value || option.value === '' || option.value === '0' || option.value === 0) {
                    var elem = $('[name="'+name+'"]');
                    if(elem.hasClass('required')) {
                        elem.addClass('validation-fail');
                        self._debug(name + 'Failed Validation');
                        validated = false;
                    }
                    
                }
            });

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