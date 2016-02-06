<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$class = $item->type.'-full';
$data_item = array('id' => $item->id, 'name' => $item->name);
$prices = $this->app->prices->create($item->alias);
?>
<div class="uk-modal-dialog uk-modal-dialog-large ttop-related-modal ">
    <a class="uk-modal-close uk-close uk-close-alt"></a>
<div id="<?php echo $item->id ?>" class="uk-form  <?php echo $item->type; ?> sub-item" data-item='<?php echo json_encode($data_item); ?>'>
    
            <div class="ttop-related-modal-header">
                    <?php if ($this->checkPosition('title')) : ?>
                        <h2><?php echo $this->renderPosition('title'); ?></h2>
                    <?php endif; ?>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 media-container">
                        <?php if ($this->checkPosition('media')) : ?>
                            <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 description-container">
                        <?php if ($this->checkPosition('description')) : ?>
                            <h3><?php echo JText::_('Description'); ?></h3>
                            <?php echo $this->renderPosition('description', array('style' => 'blank')); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-3 uk-margin-top">
                    <div class="uk-width-1-1 price-container">
                        <span class="price"><i class="currency"></i><span id="price" data-price='<?php echo json_encode($prices); ?>'>0.00</span></span>
                    </div>
                    <div class="uk-width-1-1 options-container uk-margin-top">
                        <?php if ($this->checkPosition('options')) : ?>
                            <div class="uk-panel uk-panel-box">
                                <h3><?php echo JText::_('Options'); ?></h3>
                                <div class="validation-errors"></div>
                                <?php echo $this->renderPosition('options', array('style' => 'user_options')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="uk-width-1-1 addtocart-container uk-margin-top">
                        <label>Quantity</label>
                        <input id="qty-<?php echo $item->id; ?>" type="number" class="uk-width-1-1" name="qty" min="1" value ="1" />
                        <div class="uk-margin-top">
                            <button id="atc-<?php echo $item->id; ?>" class="uk-button uk-button-danger"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ttop-related-modal-footer uk-text-right">
            </div>
    </div>
</div>
<div class="modals">
    <?php if ($this->checkPosition('modals')) : ?> 
        <?php echo $this->renderPosition('modals'); ?>
    <?php endif; ?>
</div>
<?php
$pp = '{}';
if (isset($item->params['content.price_point']) && $item->params['content.price_point'] != '') {
    $pp = array(
        'item' => array($item->params['content.price_point']),
        'shipping' => array()
    );
    $pp = json_encode($pp);
}
//echo json_encode($storeItem->getPrices()); 
//echo $pp;
?>

<script>
    jQuery(function($) {
        
        $(document).ready(function($){

            $('#<?php echo $item->id; ?>').not('.main-item').StoreItem({
                name: 'Accessories',
                validate: true,
                confirm: false,
                debug: false,
                events: {
                    onInit: []
                },
                pricePoints: <?php echo $pp; ?>




            });
        });
        
    });
    
    
</script>

