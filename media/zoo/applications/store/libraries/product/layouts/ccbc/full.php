<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
$this->app->document->addScript('library.modal:assets/js/lpi_modal.js');
$this->app->document->addScript('library.product:assets/js/orderform.js');
$this->app->document->addScript('assets:/jquery-ui-1.12.1/jquery-ui.min.js');
$this->app->document->addStyleSheet('assets:/jquery-ui-1.12.1/jquery-ui.min.css');
$make = $this->product->getParam('boat.manufacturer');
$model = $make->getModel();
?>
TEst
<div id="OrderForm" class="ccbc ttop" >
	<div class="uk-form">
		<div id="ccbc" class="uk-grid orderForm" data-id="ccbc" data-item='[{"id": "ccbc", "type": "ccbc", "make": "<?php echo $make->name; ?>", "model": "<?php echo $model->name; ?>", "qty": 1}]' data-uk-grid-margin>
			<div class="uk-width-1-1">
				<a class="uk-text-large" href="<?php echo $this->url.$make->name; ?>"><i class="uk-icon uk-icon-caret-left uk-margin-right"></i>Back to <?php echo $make->label; ?></a>
			</div>
			<div class="uk-width-1-1 title-container">
				<div class="uk-article-title">
					Center Console Boat Cover
				</div>
			</div>
			<div class="uk-width-1-1 make-model-container">
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Make:</span><span><?php echo $make->label; ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Model:</span><span><?php echo $model->label; ?></span></p>
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
// jQuery(function($){

//     var progressbar = $("#progressbar"),
//         bar         = progressbar.find('.uk-progress-bar'),
//         settings    = {

//         action: '?option=com_zoo&controller=store&task=photoUpload&format=json', // upload url

//         allow : '*.(jpg|jpeg|gif|png)', // allow only images
//         params: {'id': uniqID},
//         type: 'JSON',

//         loadstart: function() {
//             bar.css("width", "0%").text("0%");
//             progressbar.removeClass("uk-hidden");
//         },
//         beforeAll: function(files) {
//             console.log(files);
//         },
//         beforeSend: function(xhr) {
//             console.log(xhr);
//         },
//         progress: function(percent) {
//             percent = Math.ceil(percent);
//             bar.css("width", percent+"%").text(percent+"%");
//         },

//         allcomplete: function(response) {
//             bar.css("width", "100%").text("100%");

//             setTimeout(function(){
//                 progressbar.addClass("uk-hidden");
//             }, 250);
//             console.log(response);
//             response = JSON.parse(response);
//             if(response) {
//                 var img = '<img class="uk-thumbnail" src="'+response.data.path+'" />';
//                 uniqID = response.data.uniqID;
//                 $('#upload-drop-'+drop).html(img);
//                 alert("Upload Completed");
//             }
//         }
//     };
//     var drop;
//     var uniqID = null;
//     $('.uk-placeholder').on('drop', function(e){
//         drop = $(e.target).closest('.uk-placeholder').data('drop');
//     })
//     $.UIkit.uploadDrop($("#upload-drop-1"), settings);
//     $.UIkit.uploadDrop($("#upload-drop-2"), settings);
//     $.UIkit.uploadDrop($("#upload-drop-3"), settings);
//     $(document).ready(function() {
//         $('.tm-upload-cancel').on('click', function() {
//             $('[name="trolling_motor"]').val('X').trigger('input');
//             $('.uk-placeholder').html('<i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-vertical-align-middle"></i>');
//         });
//     })
// });
</script>
<script>
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
                                        if(elem.val() === 'y') {
                                            data = {
												type: 'ccbc.trolling_motor'
											};
											lpiModal.getModal(data);
                                        }
                                        break;
                                    case 'casting_platform':
                                    	if(elem.val() === 'y') {
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