<div class="uk-width-medium-2-3 uk-width-small-1-1">
	<div class="uk-width-1-1 media-container">
        <div class="uk-grid">
            <?php if ($this->checkPosition('media') && $view->params->get('template.item_media_alignment') == "left") : ?>
                <div class="uk-width-medium-1-1 uk-margin">
                        <?php echo $this->renderPosition('media', array('style' => 'blank')); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="uk-width-medium-1-3 uk-width-small-1-1">
	<div class="price-container uk-width-1-1">
        <?php if ($this->checkPosition('pricing')) : ?>
                <?php echo $this->renderPosition('pricing', array('item' => $product)); ?>
        <?php endif; ?>
    </div>
    <?php if ($this->checkPosition('options')) : ?>
    <div class="options-container uk-width-1-1" data-id="<?php echo $product->id; ?>">
            <div class="uk-panel uk-panel-box">
                <h3><?php echo JText::_('Options'); ?></h3>
                <div class="validation-errors"></div>
                <?php echo $this->renderPosition('options', array('style' => 'options')); ?>
            </div>
    </div>
    <?php endif; ?>
    <div class="addtocart-container uk-width-1-1">
        <label>Quantity</label>
        <input id="qty-<?php echo $product->id; ?>" type="number" inputmode="numeric" pattern="[0-9]*" title="Non-negative integral number" class="uk-width-1-1 qty" name="qty" data-id="<?php echo $product->id; ?>" min="1" value ="1" />
        <div class="uk-margin-top">
            <button id="atc-<?php echo $product->id; ?>" class="uk-button uk-button-danger atc uk-width-small-1-1" data-id="<?php echo $product->id; ?>"><i class="uk-icon-shopping-cart" data-store-cart style="margin-right:5px;"></i>Add to Cart</button>
        </div>
    </div>
</div>
<div class="uk-width-medium-2-3 uk-width-small-1-1">
	<div class="uk-width-1-1 uk-visible-small">
        <div class="uk-accordion" data-uk-accordion="{showfirst: false}">
            <?php if($category->description) : ?>
            <h3 class="uk-accordion-title">Description</h3>
            <div class="uk-accordion-content"><?php echo $category->getText($category->description); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="uk-width-medium-1-3 uk-width-small-1-1">
	accessories
</div>