<?php
/**
* @package   com_zoo
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
var_dump($this->item);
?>
<div id="storeOrderForm" class="ccbc" >
	<div class="uk-form">
		<div class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-2-3 title-container">
				<div class="uk-article-title">
					Center Console Boat Cover
				</div>
			</div>
			<div class="uk-width-1-3 back-buttons-container uk-text-right">
				<a id="button1" href="#" class="uk-button uk-button-danger">Button 1</a>
				<a id="button2" href="#" class="uk-button uk-button-danger">Button 2</a>
			</div>
			<div class="uk-width-1-1 make-model-container">
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Make:</span><span><?php echo $this->item->get('text'); ?></span></p>
				<p><span class="uk-article-lead uk-text-bold uk-margin-right">Model:</span><span><?php echo $this->item->models->get('24')->get('text'); ?></span></p>
			</div>
			<div class="uk-width-2-3 media-container">
			</div>
			<div class="uk-width-1-3 pricing-container">
			</div>
			<div class="uk-width-2-3 order-form-container">
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
</div>

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
//     jQuery(function($) {
//         $(document).ready(function(){
//             $('#storeOrderForm').StoreItem({
//                 name: 'T-Top Boat Cover',
//                 validate: true,
//                 debug: true,
//                 events: {
//                     ttopboatcover: {
//                         onInit: [
//                             function (data) {
//                                 console.log(data);
//                                 var item;
//                                 $.each(data.args.items, function (k, v) {
//                                     if(this.type == 'ttopboatcover') {
//                                         item = this;
//                                     }
//                                 })
//                                 this.trigger('changeColor', {item: item, fabric: item.options.fabric.value});
//                                 return data;
//                             }
//                         ],
//                         beforeChange: [
//                             function(data) { 
//                                 var e = data.args.event, item = data.args.item, elem = $(e.target), self = this;
//                                 switch(elem.prop('name')) {
//                                     case 'storage': //Check the storage value and if "IW" show the modal
//                                         if(elem.val() === 'IW') {
//                                             var modal = $.UIkit.modal("#inwater-modal");
//                                             modal.options.bgclose = false;
//                                             modal.show();
//                                         }
//                                         break;
//                                     case 'trolling_motor': // Check if the trolling motor is "yes" and show the modal for the photo upload
//                                         if(elem.val() === 'y') {
//                                             var modal = $.UIkit.modal("#tm-temp-modal");
//                                             modal.options.bgclose = false;
//                                             modal.show();
//                                         }
//                                         break;
//                                     case 'fabric':
//                                         self.trigger('changeColor', {item: item, fabric: elem.val()});
//                                         break;
//                                     case 'color':
//                                         //changeColor(elem.val());
//                                         break;
//                                     case 'ttop_type':
//                                         if(elem.val() === 'hard-top') {
//                                             var modal = $.UIkit.modal("#hthsk-modal");
//                                             modal.options.bgclose = false;
//                                             modal.show();
//                                         }
//                                 }
//                                 return data;
//                             }
//                         ],
//                         changeColor: [
//                             function (data) {
//                                 var fabric = data.args.fabric;
//                                 var colorSelect = $('.item-option[name="color"]');
//                                 var colors = {
//                                         '9oz': ['navy','black','gray','tan'],
//                                         '8oz': ['navy','black'],
//                                         '7oz': ['navy','black']
//                                     }
//                                 colorSelect.find('option').each(function(k,v){
//                                     $(this).find('span').html('');
//                                     if ($(this).prop('value') !== 'X') {
//                                         if($.inArray($(this).prop('value'), colors[fabric]) === -1) {
//                                             $(this).prop('disabled',true);
//                                             $(this).append('<span>- 9oz Fabric Only</span>');
//                                         } else {
//                                             $(this).prop('disabled',false);
//                                         }
//                                     }
//                                 });
//                                 if($.inArray(colorSelect.val(), colors[fabric]) === -1) {
//                                     colorSelect.val('X').trigger('input');
//                                 }
//                                 return data;
//                             }
//                         ],
//                         beforeAddToCart: [
//                             function(data) {
//                                 var items = data.args.items
//                                 $.each(items, function(key, item){
//                                     console.log(item);
//                                     item.name = item.name+' for a '+item.options.year.text+' '+item.attributes.oem.name+' '+item.attributes.boat_model.text;
//                                 })

//                                 return data;
//                             }
//                         ],
//                         onPublishPrice: []
//                     }
//                 },
//                 removeValues: true
//             });
//         });
        
//     });
    
    
</script>