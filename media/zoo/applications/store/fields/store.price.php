<?php
$product = $parent->getValue('product');
?>
<div id="<?php echo $parent->getValue('product')->id; ?>-price">
	<i class="currency"></i>
	<span class="price"><?php echo $this->app->number->format($product->getPrice(), 2); ?></span>
</div>