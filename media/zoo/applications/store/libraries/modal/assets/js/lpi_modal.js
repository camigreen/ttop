(function(window, $) {
    //Slider Scope
    var lpiModal = {};
    window.lpiModal = lpiModal;

    lpiModal.storage = {};
    
    lpiModal.init = function(container) {

        if(container instanceof jQuery) {
            lpiModal.container = container;
        } else {
            lpiModal.container = $(container);
        }

        lpiModal.container.on('click', '.modal-save', function() {
            console.log('save test');
            var elem = $(this);
            lpiModal.save(elem);
            
        })
        lpiModal.container.on('click', '.modal-cancel', function() {
            var elem = $(this);
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
        var modal, elem = $('#'+config.type+'-'+config.name);
        console.log(config);
        if(elem.length === 0) {
            config.cache = (typeof config.cache === 'undefined' ? true : config.cache);
            lpiModal.createModal(config).done(function(mElem){

                $('.modals').append(mElem);
                modal = UIkit.modal(mElem);
                console.log(UIkit.modal(mElem));
                modal.on({
                    'hide.uk.modal': function(){
                        console.log("Element is not visible.");
                        var config = $(this).data('config');
                        
                        // if(config.cache === 'false' || !config.cache) {
                        //     console.log(config.cache);
                            $(this).remove();
                        // }

                    }
                });
                modal.options.bgclose = false;
                modal.options.center = true;
                modal.options.minScrollHeight = 150;
                console.log(modal.options);
                modal.show();
            });
        } else {

            modal = lpiModal.modals[config.type];
            console.log(config);
            modal.show();
        }
    };

    lpiModal.save = function(elem) {
        console.log('Saving');
        var config = elem.closest('.uk-modal').data('config');
        var modalId = elem.closest('.uk-modal').prop('id');

        lpiModal.storage.triggerResult[modalId] = config;
        $('#'+modalId).trigger('save', lpiModal.storage.triggerResult[modalId]);
        console.log(lpiModal.storage.triggerResult[modalId]);
        if(lpiModal.storage.triggerResult[modalId].result === true) {
            lpiModal.hide(modalId);
        } else if(lpiModal.storage.triggerResult[modalId].result === 'break') {

        } else {
            lpiModal.hide(modalId);
        }
        
    }

    lpiModal.cancel = function (elem) {
        console.log('Canceling');
        var config = elem.closest('.uk-modal').data('config');
        var modalId = elem.closest('.uk-modal').prop('id');

        lpiModal.storage.triggerResult[modalId] = config;
        $('#'+modalId).trigger('cancel', lpiModal.storage.triggerResult[modalId]);
        console.log(lpiModal.storage.triggerResult[modalId]);
        if(lpiModal.storage.triggerResult[modalId].result === true) {
            lpiModal.hide(modalId);
        } else if(lpiModal.storage.triggerResult[modalId].result === 'break') {

        } else {
            lpiModal.hide(modalId);
        }
    }

    lpiModal.container = null;

    lpiModal.show = function(name) {
        var modal = UIkit.modal($('#'+name));
        console.log(modal);
        modal.show();
    };

    lpiModal.hide = function(name) {
        UIkit.modal($('#'+name)).hide();
    };

    lpiModal.createModal = function(config) {
        var dfd = $.Deferred(); 

        console.log('creating modal');

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
                console.log(data);
            },
            error: function(data, status, error) {
                console.log(error);
            }
        }).promise();
    };
    
})(window, jQuery);