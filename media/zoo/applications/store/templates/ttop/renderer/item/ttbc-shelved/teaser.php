<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$product = $this->app->product->create($item);
$link = $this->app->route->item($item);
//$product->price->debug(true);
?>
<a href="<?php echo $link; ?>">
    <div class="uk-form ttop">
        <div class="clearance-teaser uk-panel uk-panel-box">
            <div class="uk-grid uk-grid-small uk-margin">
                <div class="uk-width-2-3">
                    <div class="clearance-title uk-article-title">
                        <?php if ($this->checkPosition('title')) : ?>
                            <?php echo $this->renderPosition('title'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-3">
                    <div class="price-teaser uk-text-right">
                        <?php if ($this->checkPosition('pricing')) : ?>
                            <?php echo $this->renderPosition('pricing', array('item' => $product, 'layout' => 'overstock')); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="uk-width-1-3">
                    <?php if ($this->checkPosition('media')) : ?>
                        <?php echo $this->renderPosition('media', array('style' => 'teaser_image')); ?>
                    <?php endif; ?>
                </div>
                <div class="uk-width-2-3">
                    <div class="uk-width-1-1 teaser-options">
                        <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                            <?php if ($this->checkPosition('boat-options')) : ?>
                            <div class="uk-width-1-1">
                                <fieldset id="boat-options">
                                    <legend>Boat Specs</legend>
                                    <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                        <?php echo $this->renderPosition('boat-options', array('style' => 'teaser_option')); ?>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('cover-options')) : ?>
                            <div class="uk-width-1-1">
                                <fieldset id="cover-options">
                                    <legend>Cover Specs</legend>
                                    <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                        <?php echo $this->renderPosition('cover-options', array('style' => 'teaser_option')); ?>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('bow-options')) : ?>
                            <div class="uk-width-1-1">
                                <fieldset id="bow-options">
                                    <legend>Bow</legend>
                                    <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                        <?php echo $this->renderPosition('bow-options', array('style' => 'teaser_option')); ?>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>
                            <?php if ($this->checkPosition('aft-options')) : ?>
                            <div class="uk-width-1-1">
                                <fieldset id="aft-options">
                                    <legend>Aft</legend>
                                    <div class="uk-grid uk-grid-small" data-uk-grid-margin>
                                        <?php echo $this->renderPosition('aft-options', array('style' => 'teaser_option')); ?>
                                    </div>
                                </fieldset>
                            </div>
                            <?php endif; ?>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>