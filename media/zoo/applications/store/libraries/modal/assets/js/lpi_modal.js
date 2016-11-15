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
            var elem = $(this);
            lpiModal.save(elem);
            
        })
        lpiModal.container.on('click', '.modal-cancel', function() {
            var elem = $(this);
            lpiModal.cancel(elem);
        })

        $('.modal-button').on('click', function(e){
            var elem = $(e.target);
            var data = {
                type: elem.data('modal'),
                field: elem.data('modal-field-id'),
                value: $('#'+elem.data('modal-field-id')).val()
            };
            lpiModal.getModal(data);
        });

        console.log('LPI Modal Initialized');
        console.log(lpiModal.modals);
        
    };

    lpiModal.getModal = function(data) {
        var modal;
        if(typeof lpiModal.modals[data.type] === 'undefined') {
            lpiModal.createModal(data).done(function(elem){
                $('.modals').append(elem);
                modal = UIkit.modal(elem);
                elem.data('modal', data);
                elem.data('modal').cache = (typeof data.cache === 'undefined' ? true : data.cache);
                modal.on({
                    'hide.uk.modal': function(){
                        console.log("Element is not visible.");
                        if(!$(this).data('modal').cache) {
                            console.log($(this).data('modal'));
                            var type = $(this).data('modal').type;
                            delete lpiModal.modals[type];
                            $(this).remove();
                        }

                    }
                });
                modal.cache = typeof data.cache === 'undefined' ? true : data.cache;
                lpiModal.modals[data.type] = modal;
                
                console.log(data);
                modal.show();
            });
        } else {

            modal = lpiModal.modals[data.type];
            console.log(data);
            modal.find('[name="'+data.type+'_modal_helper"][value="'+data.value+'"]').prop('checked', true);
            modal.find('[name="'+data.type+'_modal_value"]').val(data.value);
            modal.show();
        }
    };

    lpiModal.save = function(elem) {
        var type = elem.data('modal').type;
        var values = elem.data('modal').values;
        var args = elem.data('modal').args;
        var modal_field = $('[name="'+type+'_modal_value"]');
        console.log(modal_field);
        var field = $('#'+modal_field.data('field-id'));
        var val = modal_field.val() ? modal_field.val() : 0;
        data = {
            type: type,
            modal_field: modal_field,
            field: field,
            val: val,
            args: args
        }
        
        field.val(val).trigger('change');
        $('#'+type+'-modal').trigger('save', data);
        lpiModal.hide(type);
        
    }

    lpiModal.cancel = function (elem) {
        var type = elem.data('modal').type;
        lpiModal.hide(type);
    }

    lpiModal.container = null;

    lpiModal.show = function(name) {
        lpiModal.modals[name].show();
    };

    lpiModal.hide = function(name) {
        var modal = lpiModal.modals[name];
        modal.hide();
    };

    lpiModal.createModal = function(modal) {
        var dfd = $.Deferred();
        if(typeof lpiModal.modals[modal.type] === 'undefined') {  

            console.log('creating modal');

            lpiModal.load(modal).done(function(data){
                var elem = $('<div class="uk-modal ttop"><div class="uk-modal-dialog"> <div class="contents"></div></div></div>');
                elem.prop('id', modal.type+'-modal');
                elem.find('.contents').append(data.content);
                dfd.resolve(elem);
            });

        } else {
            console.log('Modal Exists');
            dfd.resolve(lpiModal.modals[modal.type]);
        }
        
        return dfd.promise();
    };

    lpiModal.modals = {};

    lpiModal.setDefaultContent = function(modal) {
        lpiModal.modals[modal].find('.contents').html('<i class="uk-icon-spinner uk-icon-spin"></i>')
    }

    lpiModal.load = function(modal) {
        return $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=modal&task=getModal&format=json",
            data: {modal: modal},
            dataType: 'json'
        }).promise();
    };
    
})(window, jQuery);