(function(window, $) {
    //Slider Scope
    var lpiCart = {};
    window.lpiCart = lpiCart;

    lpiCart.init = function(container) {

        console.log('LPI Cart Initialized');

        lpiCart.initModal();

        $(".cart a").on('click', function(e) {
            console.log('cart open');
            lpiCart.show(true);
        });

    };

    lpiCart.refresh = function(data) {

        var count = data.count;
        $('.cart-module span[data-cart="quantity"]').html(count);
        $('.cart-module span[data-cart="total"]').html(data.total);

        if(typeof data.render === 'undefined') {
            $.when(lpiCart.load()).done(function(data) {
                lpiCart.updateEvents();
            })
        } else {
            $('#cart-modal').html(data.render);
            lpiCart.updateEvents();
        }

    };

    lpiCart.initModal = function() {
        lpiCart.modal = UIkit.modal('#cart-modal');
        lpiCart.modal.on({
            'show.uk.modal': function(){
                console.log("Modal is visible.");
                lpiCart.updateEvents();
            },

            'hide.uk.modal': function(){
                console.log("Element is not visible.");
                $('#cart-modal').html();
            }
        });
    };

    lpiCart.load = function() {
        return $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=cart&task=load&format=json",
            data: {},
            success: function(data){
                $('#cart-modal').html(data.render);
            },
            error: function(data, status, error) {
                console.log(error);
            },
            dataType: 'json'
        }).promise();
    };

    lpiCart.updateEvents = function() {
        $('.updateQty').on('click', function(e) {
            var row = $(e.target).closest('tr');
            var qty = row.children('td.qty').children('input').val();
            var hash = row.prop('id');
            if(qty === 0) {
                lpiCart.remove(hash);
            } else {
                lpiCart.updateQty(hash, qty);
            }
        });

        $('.trash').on('click', function(e) {
            var hash = $(e.target).closest('tr').prop('id');
            lpiCart.remove(hash);
            console.log('Delete ' + hash);
        });

        $('#cart-modal .clear').on('click', function(e) {
            lpiCart.clear();
        });

        $('#cart-modal .continue').on('click', function(e) {
            lpiCart.hide();
        });

        $('#cart-modal .checkout').on('click', function(e) {
            console.log('Checking out');
            window.location.href = '/checkout/customer-info';
        });

        $('.options-toggle').on('click', function(e){
            console.log('toggle');
            $('.options-container').show();
        })

        
    }

    lpiCart.show = function(reload) {
        reload = (typeof reload === 'undefined' ? false : reload);
        console.log(reload);
        if(reload) {
            $.when(lpiCart.load()).done(function(data) {
                lpiCart.modal.show();
            })
        } else {
            lpiCart.modal.show();
        }
        
        
    };

    lpiCart.hide = function() {
        lpiCart.modal.hide();
    };

    lpiCart.add = function(items) {
        $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=cart&task=add&format=json",
            data: {items: items},
            success: function(data){
                console.log(data);
                lpiCart.refresh(data);
                lpiCart.show();
            },
            error: function(data, status, error) {
                console.log(data);
                console.log(status);
                console.log(error);
            },
            dataType: 'json'
        });
    };

    lpiCart.remove = function(hash) {
        console.log('Removing item: '+ hash);
        $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=cart&task=remove&format=json",
            data: {hash: hash},
            success: function(data){
                console.log(data);
                lpiCart.refresh(data);
            },
            error: function(data, status, error) {
                console.log(error);
            },
            dataType: 'json'
        });
    };

    lpiCart.clear = function() {
        console.log('Clearing the Cart');
        $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=cart&task=clear&format=json",
            data: {},
            success: function(data){
                lpiCart.refresh(data);
            },
            error: function(data, status, error) {
                console.log(error);
            },
            dataType: 'json'
        });
    };

    lpiCart.updateQty = function(hash, qty) {
        console.log('Updating Qty: '+ hash + ' to ' + qty);
        $.ajax({
            type: 'POST',
            url: "?option=com_zoo&controller=cart&task=updateQty&format=json",
            data: {hash: hash, qty: qty},
            success: function(data){
                lpiCart.refresh(data);
            },
            error: function(data, status, error) {
                console.log(error);
            },
            dataType: 'json'
        });
    };
    
})(window, jQuery);