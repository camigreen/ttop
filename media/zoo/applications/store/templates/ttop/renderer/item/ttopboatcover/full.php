<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
$embed = $this->app->request->get('embed','bool');
// no direct access
defined('_JEXEC') or die('Restricted access');
$storeItem = $this->app->item->create($item, 'ttopboatcover');
$category = $item->getPrimaryCategory()->getParent();

?>
<div id="storeOrderForm" class="t-top-boat-cover" >
    <div id="<?php echo $storeItem->id ?>" class="storeItem" data-item="<?php echo $storeItem->getItemsJSON(); ?>">
    <div class="uk-grid <?php echo $storeItem->getPriceGroup(); ?>">
        <div class="uk-width-1-2">
            <p class="uk-article-title"><?php echo $storeItem->name; ?></p>
        </div>

        <div class="uk-width-1-2 uk-text-right">
            <a href="<?php echo $this->app->route->category($item->getPrimaryCategory()); ?>" class="uk-button uk-button-danger">Back to <?php echo $item->getPrimaryCategory()->name; ?></a>
            <a href="/store/t-top-boat-covers" class="uk-button uk-button-danger">Back to Manufactures</a>
        </div>
        <?php if ($this->checkPosition('title')) : ?>
            <div class="uk-width-1-1 uk-margin-top">
                <?php echo $this->renderPosition('title', array('style' => 'uikit_list')); ?>
            </div>
        <?php endif; ?>

    </div>


    <div class="uk-form uk-margin">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-2-3">
                    <?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "left") : ?>
                        <div class="uk-width-1-1 uk-margin">
                            <div class="uk-container">
                                <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="uk-width-1-1">
                        <ul class="uk-tab" data-uk-tab="{connect:'#tabs'}">
                            <li>
                                <a href="#">Order Form</a>
                            </li>
                            <?php if($category->description) : ?>
                            <li>
                                <a href="#">Description</a>
                            </li>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('tabs')) : ?>
                                <?php echo $this->renderPosition('tabs', array('style' => 'tab')); ?>
                            <?php endif; ?>
                        </ul>

                        <ul id="tabs" style="min-height:150px;" class="uk-width-1-1 uk-switcher uk-margin options-container" data-id="<?php echo $storeItem->id; ?>">
                            <li class="uk-grid">


                                <?php if ($this->checkPosition('boat_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Boat Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('boat_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('motor_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Motor Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('motor_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('cover_options')) : ?>
                                <div class="uk-width-1-2 uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Cover Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('cover_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('bow_options')) : ?>
                                <?php $width = 'uk-width-1-2'; ?>
                                <div class="<?php echo $width; ?> uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Bow Options'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('bow_options', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>

                                <?php if ($this->checkPosition('special_accessories')) : ?>
                                <?php $width = 'uk-width-1-1'; ?>
                                <div class="<?php echo $width; ?> uk-margin-top">
                                    <fieldset> 
                                        <legend>
                                            <?php echo JText::_('Special Accessories'); ?>
                                        </legend>
                                        <div class="uk-grid">
                                            <?php echo $this->renderPosition('special_accessories', array('style' => 'options')); ?>
                                        </div>
                                    </fieldset>
                                </div>
                                <?php endif; ?>
                                <div class="uk-width-1-1 uk-margin-top">
                                    <fieldset>
                                        <legend>Additional Information<span class="uk-text-small uk-margin-left">(other)</span></legend>
                                            <textarea class="uk-width-1-1 item-option" style="height:120px;" name="add_info" data-name="Additional Information"></textarea>
                                    </fieldset>
                                </div>
                            </li>
                            <?php if($category->description) : ?> 
                                <li>
                                    <article class="uk-article">
                                        <?php echo $category->getText($category->description); ?>
                                    </article>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('tabs')) : ?>
                                <?php echo $this->renderPosition('tabs', array('style' => 'tab_content')); ?>
                            <?php endif; ?>
                        </ul>
                </div>
            </div>
            <div class="uk-width-1-3">
                <div class="uk-width-1-1 uk-grid price-container">
                    <?php if ($this->checkPosition('pricing')) : ?>
                            <?php echo $this->renderPosition('pricing', array('item' => $storeItem)); ?>
                    <?php endif; ?>
                </div>
                <div class="uk-width-1-1 options-container uk-margin-top" data-id="<?php echo $storeItem->id; ?>">
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
                    <input id="qty-<?php echo $storeItem->id; ?>" type="number" class="uk-width-1-1 qty" name="qty" data-id="<?php echo $storeItem->id; ?>" min="1" value ="1" />
                    <div class="uk-margin-top">
                        <button id="atc-<?php echo $storeItem->id; ?>" class="uk-button uk-button-danger atc" data-id="<?php echo $storeItem->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                    </div>
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

            <?php if ($this->checkPosition('bottom')) : ?>
                    <?php echo $this->renderPosition('bottom', array('style' => 'block')); ?>
            <?php endif; ?>
            
            <?php if ($this->checkPosition('modals')) : ?>
                <div class="modals">
                    <div id="confirm-modal" class="uk-modal">
                        <div class="uk-modal-dialog">
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-1-1">
                                    <div class="uk-article-title uk-text-center">Confirmation</div>
                                    <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that a T-Top Boat Cover is a custom made product and that if I have chosen an option incorrectly it may lead to the T-Top Boat Cover not fitting my boat correctly.</div>
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
                    <?php echo $this->renderPosition('modals'); ?>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) { 
        $('button.tm-yes').on('click', function() {
            $('[name="trolling_motor"]').val('y');
            $('[name="trolling_motor"]').trigger('change');
        });
        $('button.tm-r').on('click', function() {
            $('[name="trolling_motor"]').val('r');
            $('[name="trolling_motor"]').trigger('change');
        });
       
    });
    
</script>
<script>   
jQuery(function($){

    var progressbar = $("#progressbar"),
        bar         = progressbar.find('.uk-progress-bar'),
        settings    = {

        action: '?option=com_zoo&controller=store&task=photoUpload&format=json', // upload url

        allow : '*.(jpg|jpeg|gif|png)', // allow only images
        params: {'id': uniqID},
        type: 'JSON',

        loadstart: function() {
            bar.css("width", "0%").text("0%");
            progressbar.removeClass("uk-hidden");
        },
        beforeAll: function(files) {
            console.log(files);
        },
        beforeSend: function(xhr) {
            console.log(xhr);
        },
        progress: function(percent) {
            percent = Math.ceil(percent);
            bar.css("width", percent+"%").text(percent+"%");
        },

        allcomplete: function(response) {
            bar.css("width", "100%").text("100%");

            setTimeout(function(){
                progressbar.addClass("uk-hidden");
            }, 250);
            console.log(response);
            response = JSON.parse(response);
            if(response) {
                var img = '<img class="uk-thumbnail" src="'+response.data.path+'" />';
                uniqID = response.data.uniqID;
                $('#upload-drop-'+drop).html(img);
                alert("Upload Completed");
            }
        }
    };
    var drop;
    var uniqID = null;
    $('.uk-placeholder').on('drop', function(e){
        drop = $(e.target).closest('.uk-placeholder').data('drop');
    })
    $.UIkit.uploadDrop($("#upload-drop-1"), settings);
    $.UIkit.uploadDrop($("#upload-drop-2"), settings);
    $.UIkit.uploadDrop($("#upload-drop-3"), settings);
    $(document).ready(function() {
        $('.tm-upload-cancel').on('click', function() {
            $('[name="trolling_motor"]').val('X').trigger('input');
            $('.uk-placeholder').html('<i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-vertical-align-middle"></i>');
        });
    })
});
</script>
<script>
    jQuery(function($) {
        
        function changeColor (w) {
            var swatch = $('.swatch div');
            var colorSelect = $('.item-option[name="color"]');
            var colors = {
                    '9oz': ['navy','black','gray','tan'],
                    '8oz': ['navy','black'],
                    '7oz': ['navy','black']
                }
            colorSelect.find('option').each(function(k,v){
                $(this).find('span').html('');
                if ($(this).prop('value') !== 'X') {
                    if($.inArray($(this).prop('value'), colors[w]) === -1) {
                        $(this).prop('disabled',true);
                        $(this).append('<span>- 9oz Fabric Only</span>');
                    } else {
                        $(this).prop('disabled',false);
                    }
                }
            });
            // if ($('[name="color"] [value="'+colorValue+'"]').prop('disabled')) {
            //     $('.item-option[name="color"]').val('navy').trigger('input');
            // }

            swatch.removeAttr('class');
            swatch.addClass($('.color-chooser [name="color"]').val())
        }
        $(document).ready(function(){

            $('#storeOrderForm').StoreItem({
                name: 'T-Top Boat Cover',
                validate: true,
                debug: true,
                events: {
                    ttopboatcover: {
                        onInit: [
                            function () {
                                var f = this._getOptionValue(<?php echo $storeItem->id; ?>,'fabric');
                                changeColor(f);
                            }
                        ],
                        beforeChange: [
                            function(data) { 
                                var e = data.args.event, item = data.args.item, elem = $(e.target);
                                switch($(e.target).prop('name')) {
                                    case 'storage': //Check the storage value and if "IW" show the modal
                                        if(elem.val() === 'IW') {
                                            var modal = $.UIkit.modal("#inwater-modal");
                                            modal.options.bgclose = false;
                                            modal.show();
                                        }
                                        break;
                                    case 'trolling_motor': // Check if the trolling motor is "yes" and show the modal for the photo upload
                                        if(elem.val() === 'y') {
                                            var modal = $.UIkit.modal("#tm-temp-modal");
                                            modal.options.bgclose = false;
                                            modal.show();
                                        }
                                        break;
                                    case 'fabric':
                                        changeColor(elem.val());
                                        break;
                                    case 'color':
                                        changeColor(elem.val());
                                        break;
                                    case 'ttop_type':
                                        if(elem.val() === 'hard-top') {
                                            var modal = $.UIkit.modal("#hthsk-modal");
                                            modal.options.bgclose = false;
                                            modal.show();
                                        }
                                }
                                return data;
                            }
                        ],
                        beforeAddToCart: [
                            function(data) {
                                var items = data.args.items
                                $.each(items, function(key, item){
                                    console.log(item);
                                    item.title = '';
                                    item.title = item.name+' for a '+item.options.year.text+' '+item.attributes.oem.name+' '+item.attributes.boat_model.text;
                                })

                                return data;
                            }
                        ],
                        onPublishPrice: []
                    }
                },
                removeValues: true
            });
        });
        
    });
    
    
</script>