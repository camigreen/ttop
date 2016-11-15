<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.cart:assets/js/cart.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');
// var_dump($this->product);
$make = $this->product->getParam('boat.manufacturer');
$model = $this->product->getParam('boat.model');
// Price Options
//$this->product->setOptionValue('trolling_motor', 'N');
// Pattern Options
// $this->product->setOptionValue('year', '2016');
// $this->product->setOptionValue('motors', '1');
// $this->product->setOptionValue('bow_rails', 'L');
// $this->product->setOptionValue('jack_plate', 'N');
// $this->product->setOptionValue('poling_platform', '45');
// $this->product->setOptionValue('boat_style', 'CC');
// $this->product->setOptionValue('ski_tow_bar', 'N');
// $this->product->setOptionValue('power_poles', 'N');
// $this->product->setOptionValue('swim_ladder', 'N');

// Variable Options
//$this->product->setOptionValue('color', 'N');
//$this->product->setOptionValue('zipper', 'ZP');
// $this->product->setOptionValue('storage', 'T');
 $this->product->setOptionValue('motor_make', 'yamaha');
// $this->product->setOptionValue('motor_size', '150');
// $this->product->setOptionValue('casting_platform', 'N');

$pattern = $this->product->getPatternID();
$pattern = $pattern ? $pattern : 'No Pattern Found.';
//var_dump($this->product->options);

//var_dump($this->product->toJson());

?>
<div id="OrderForm" class="ccbc ttop" >
	<div class="uk-form">
		<div id="ccbc" class="uk-grid orderForm" data-id="ccbc" data-item='[<?php echo $this->product->toJson(true); ?>]' data-uk-grid-margin>
			<div class="uk-width-1-1">
				<a class="uk-text-large" href="<?php echo $this->url.$make->name; ?>"><i class="uk-icon uk-icon-caret-left uk-margin-right"></i>Back to <?php echo $make->label; ?></a>
			</div>
			<div class="uk-width-1-1 title-container">
				<div class="uk-article-title">
					Center Console Boat Cover
				</div>
			</div>
			<div class="uk-width-1-1 make-model-container">
				<p><span class="uk-article-lead uk-text-bold uk-margin-right" data-uk-tooltip title="test">Make:</span><span><?php echo $make->label; ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Model:</span><span><?php echo $model->label; ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Pattern:</span><span id="patternID"><?php echo $pattern; ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Product SKU:</span><span><?php echo $this->product->getSKU(); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Boat Length:</span><span><?php echo $this->product->getOption('boat_length')->getText(); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Price Group:</span><span><?php echo $this->product->getPriceRule(); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Base Price:</span><span><?php echo $this->product->getPrice('base', 0.00, true); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">MSRP Price:</span><span><?php echo $this->product->getPrice('msrp', 0.00, true); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Display Retail Price:</span><span><?php echo $this->product->getPrice('display', 0.00, true); ?></span></p>
			</div>
			<div class="uk-width-medium-2-3 uk-width-small-1-1 slideshow-container">
				<?php if($this->form->checkGroup('slideshow')) : ?>
		        	<?php echo $this->form->render('slideshow')?>
				<?php endif; ?>
			</div>
			<div class="uk-width-medium-1-3 uk-width-small-1-1 pricing-container">
				<?php if($this->form->checkGroup('pricing')) : ?>
		        	<?php echo $this->form->render('pricing')?>
				<?php endif; ?>
			</div>
			<div class="uk-width-medium-2-3 uk-width-small-1-1 order-form-container options-container" data-id="ccbc">
				<div class="uk-grid" data-uk-grid-margin>
					<?php if($this->form->checkGroup('cover_options')) : ?>
			        	<?php echo $this->form->render('cover_options')?>
					<?php endif; ?>
					<?php if($this->form->checkGroup('boat_options')) : ?>
			        	<?php echo $this->form->render('boat_options')?>
					<?php endif; ?>
					<?php if($this->form->checkGroup('motor_options')) : ?>
			        	<?php echo $this->form->render('motor_options')?>
					<?php endif; ?>
					<?php if($this->form->checkGroup('aft_options')) : ?>
			        	<?php echo $this->form->render('aft_options')?>
					<?php endif; ?>
					<?php if($this->form->checkGroup('bow_options')) : ?>
			        	<?php echo $this->form->render('bow_options')?>
					<?php endif; ?>
				</div>
			</div>
			<div class="uk-width-1-3 accessories-container">
			</div>
		</div>
	</div>
	<div class='modals'></div>
</div>

<script>
jQuery(function($){
	$(document).ready(function(){
		lpiModal.init('.modals');
	})
})
</script>

<script>
//     jQuery(document).ready(function($) { 
//         $('button.tm-yes').on('click', function() {
//             $('[name="trolling_motor"]').val('y');
//             $('[name="trolling_motor"]').trigger('change');
//         });
//         $('button.tm-r').on('click', function() {
//             $('[name="trolling_motor"]').val('r');
//             $('[name="trolling_motor"]').trigger('change');
//         });
       
//     });
</script>
<script>
	var item = <?php echo $this->product->toJson(true); ?>;
	console.log(item);
    jQuery(function($) {
        $(document).ready(function(){
            $('#OrderForm').OrderForm({
                name: 'Center Console Boat Cover',
                validate: false,
                debug: true,
                events: {
                    ccbc: {
                        onInit: [
                        	function(data) {
                        		
                        		return data;
                        	}
                        ],
                        beforeChange: [
                            function(data) { 
                                var e = data.args.event, item = data.args.item, elem = $(e.target), self = this;
                                console.log(elem.prop('name'));
                                switch(elem.prop('name')) {
                                    case 'storage': //Check the storage value and if "IW" show the modal
                                        if(elem.val() === 'IW') {
											lpiModal.getModal({type: 'ccbc.inwater'});
                                        }
                                        break;
                                    case 'trolling_motor': // Check if the trolling motor is "yes" and show the modal for the photo upload
                                        if(elem.val() === 'Y') {
                                            data = {
												type: 'ccbc.trolling_motor',
												value: 'Y',
												field: elem.prop('id')
											};
											lpiModal.getModal(data);
                                        }
                                        break;
                                    case 'casting_platform':
                                    	if(elem.val() === 'Y') {
											lpiModal.getModal({type: 'ccbc.cast_platform'});
                                        }
                                        //changeColor(elem.val());
                                        break;
                                }
                                return data;
                            }
                        ],
                        beforeAddToCart: [],
                        onPublishPrice: []
                    }
                },
                removeValues: true
            });
        });
        
    });
    
    
</script>