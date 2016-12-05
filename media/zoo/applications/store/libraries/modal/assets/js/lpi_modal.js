(function(window, $) {
    //Slider Scope
    var lpiModal = {};
    window.lpiModal = lpiModal;

    lpiModal.storage = {};

    lpiModal.storage.data = {};
    
    lpiModal.init = function(container) {

        if(container instanceof jQuery) {
            lpiModal.container = container;
        } else {
            lpiModal.container = $(container);
        }

        lpiModal.container.on('click', '.modal-save', function() {
            console.log('save test');
            var elem = $(this).closest('.uk-modal');
            lpiModal.save(elem);
            
        })
        lpiModal.container.on('click', '.modal-cancel', function() {
            var elem = $(this).closest('.uk-modal');
            lpiModal.cancel(elem);
        })

        $('.modal-button').on('click', function(e){
            var elem = $(e.target);
            var config = elem.data('config');
            lpiModal.getModal(config);
        });

        lpiModal.storage.triggerResult = {};

        console.log('LPI Modal Initialized');
        
    };

    lpiModal.getModal = function(config) {
        var modal, elem = $('#'+config.type+'-'+config.name+'-modal');
        if(elem.length === 0) {
            config.cache = (typeof config.cache === 'undefined' ? true : config.cache);
            lpiModal.createModal(config).done(function(mElem){

                $('.modals').append(mElem);
                modal = UIkit.modal(mElem);
                modal.on({
                    'hide.uk.modal': function(){
                        console.log(mElem);
                        mElem.remove();
                    }
                });
                modal.options.bgclose = false;
                modal.options.center = true;
                modal.options.minScrollHeight = 150;
                modal.show();
                lpiModal.storage.data[mElem.prop('id')] = config;
            });
            console.log(lpiModal);
        } else {
            modal = lpiModal.storage.modals[config.type];
            console.log(config);
            modal.show();
        }
    };

    lpiModal.save = function(elem) {
        console.log('Saving');
        var modalId = elem.prop('id');
        console.log(modalId);
        var config = lpiModal.storage.data[modalId];
        config.triggerResult = true;
        $('#'+modalId).trigger('save', config);
        if(config.triggerResult === true) {
            $.when(lpiModal.hide(modalId)).done(function() {
                if(typeof config.callback !== 'undefined') {
                    config.callback();
                }
            });
        } else if(config.triggerResult === 'break') {
            $('#'+modalId).trigger('save.break', config);
        } else {
            $('#'+modalId).trigger('save.false', config);
        }
        
    }

    lpiModal.cancel = function (elem) {
        console.log('Cancelling');
        var modalId = elem.prop('id');
        var config = lpiModal.storage.data[modalId];
        config.triggerResult = true;

        $('#'+modalId).trigger('cancel', config);

        if(config.triggerResult === true) {
            $('#'+modalId).trigger('cancel.true', config);
        } else if(config.triggerResult === 'break') {
            $('#'+modalId).trigger('cancel.break', config);
        } else {
            $('#'+modalId).trigger('cancel.false', config);
        }
        lpiModal.hide(modalId);
    }

    lpiModal.container = null;

    lpiModal.show = function(name) {
        var modal = UIkit.modal($('#'+name));
        console.log(modal);
        modal.show();
    };

    lpiModal.hide = function(name) {
        var dfd = $.Deferred();

        UIkit.modal($('#'+name)).hide();

        setTimeout(function working() {
            if ( $('#'+name).length ) {
                setTimeout( working, 1 );
            } else {
                dfd.resolve();
            }
        }, 1 );

        return dfd.promise();

    };

    lpiModal.createModal = function(config) {
        var dfd = $.Deferred(); 


        lpiModal.load(config).done(function(data){
            var elem = $(data.content);
            dfd.resolve(elem);
        });
        
        return dfd.promise();
    };

    lpiModal.modals = {};

    lpiModal.setDefaultContent = function(modal) {
        lpiModal.modals[modal].find('.contents').html('<i class="uk-icon-spinner uk-icon-spin"></i>')
    }

    lpiModal.load = function(config) {
        return $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=modal&task=getModal&format=json",
            data: {config: config},
            dataType: 'json', 
            success: function(data) {
            },
            error: function(data, status, error) {
                console.log(error);
            }
        }).promise();
    };
    
})(window, jQuery);