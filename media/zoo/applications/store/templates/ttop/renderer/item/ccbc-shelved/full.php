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
$product = $this->app->product->create($item);
$category = $item->getPrimaryCategory()->getParent();
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');

?>
<div id="OrderForm-<?php echo $product->id; ?>" class="ttop uk-form ccbc clearance-full uk-panel uk-panel-box" data-id="<?php echo $product->id; ?>">
    <div id="<?php echo $product->id ?>" class="storeItem" >
        <div class="uk-grid uk-margin">
            <div class="uk-width-1-1">
                <div class="title">
                    <?php if ($this->checkPosition('title')) : ?>
                        <?php echo $this->renderPosition('title'); ?>
                    <?php endif; ?>
                </div>
                <div class="category">
                    <?php if ($this->checkPosition('category')) : ?>
                        <?php echo $this->renderPosition('category'); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="uk-width-2-3">
                <?php if ($this->checkPosition('media')) : ?>
                    <?php echo $this->renderPosition('media'); ?>
                <?php endif; ?>
            </div>
            <div class="uk-width-1-3">
                <div class="price-full uk-text-right">
                    <?php if ($this->checkPosition('pricing')) : ?>
                        <?php echo $this->renderPosition('pricing', array('item' => $product, 'layout' => 'overstock')); ?>
                    <?php endif; ?>
                </div>
                <div class="uk-width-1-1 addtocart-container uk-margin-top uk-text-right">
                    <div class="uk-margin-top">
                        <button id="atc" class="uk-button uk-button-danger atc" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                    </div>
                </div>
            </div>
            <div class="uk-width-2-3 options">
                <div class="uk-grid" data-uk-grid-margin>
                    <?php if ($this->checkPosition('boat-options')) : ?>
                        <div class="uk-width-1-1">
                            <fieldset id="boat-options">
                                <legend>Boat Specs</legend>
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                    <?php echo $this->renderPosition('boat-options', array('style' => 'full-options')); ?>
                                </div>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('cover-options')) : ?>
                        <div class="uk-width-1-1">
                            <fieldset id="cover-options">
                                <legend>Cover Specs</legend>
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                    <?php echo $this->renderPosition('cover-options', array('style' => 'full-options')); ?>
                                </div>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('bow-options')) : ?>
                        <div class="uk-width-1-1">
                            <fieldset id="bow-options">
                                <legend>Bow</legend>
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                    <?php echo $this->renderPosition('bow-options', array('style' => 'full-options')); ?>
                                </div>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->checkPosition('aft-options')) : ?>
                        <div class="uk-width-1-1">
                            <fieldset id="aft-options">
                                <legend>Aft</legend>
                                <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                    <?php echo $this->renderPosition('aft-options', array('style' => 'full-options')); ?>
                                </div>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="uk-width-1-3">
            </div>
        </div>
    </div>
</div>
<div class="modals"></div>
<script>
    if(typeof items === 'undefined') { var items = {} };
    item = <?php echo $product->toJson(true); ?>;
    console.log(item);
    jQuery(function($) {

        function toggleATCStatus(elem) {
            if(item.qty >= 1) {
                elem.prop('disabled', false);
            } else {
                elem.prop('disabled', true);
            }
        }

        lpiModal.init('.modals');

        $(document).ready(function(){
            toggleATCStatus($('#atc'));
            // lpiModal.getModal({
            //     type: 'default',
            //     name: 'message',
            //     message: 'Test'
            // })
            $('#atc').on('click', function(){
                lpiCart.add([item]);
                item.qty--;
                toggleATCStatus($(this));
            });
        //     $('#OrderForm-<?php echo $product->id; ?>').OrderForm({
        //         name: 'T-Top Boat Cover - Overstock',
        //         validate: false,
        //         debug: true,
        //         confirm: false,
        //         events: {
        //             ttbc: {
        //                 onInit: [
        //                     function (data) {
        //                         var item = data.args.item;

        //                         this.trigger('changeColor', {item: item, fabric: item.options.fabric.value});
        //                         return data;
        //                     }
        //                 ],
        //                 beforeChange: [],
        //                 changeColor: [],
        //                 beforeAddToCart: [],
        //                 onPublishPrice: []
        //             }
        //         }
        //     });
        });
        
    });
    
    
</script>