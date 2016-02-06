<?php 

	$available = array();
	$selected = array();

	if($id = $parent->getValue('id')) {
		$account = $this->app->account->get($id);
		$available = $this->app->table->account->getAccountsByType('oem');
		$selected = $account->getAllOEMs();
	}

	$name = $control_name."[$name][]";
	// echo 'Available:';
	// var_dump($available);
	// echo 'Selected:';
	// var_dump($selected);
?>
<div class="uk-width-1-1">

	<ul class="uk-list uk-list-striped selected-oem-list">
	<?php if(empty($selected)) : ?>
		<li class="empty uk-text-small">There are no OEMs assigned to this account.</li>
	<?php endif; ?>
	<?php foreach($selected as $id => $oem) : ?>
		
		<li id="<?php echo $oem->id; ?>" data-name="<?php echo $oem->name; ?>">
			<input type="text" name="<?php echo $name; ?>" value="<?php echo $oem->id; ?>" />
			<?php echo $oem->name.'<a href="#" class="uk-close uk-float-right uk-text-muted"></a>'; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

<!-- This is a button toggling the modal -->
<a href="#" class="uk-button" data-uk-modal="{target:'#oem-modal'}">Add OEM(s)</a>

<!-- This is the modal -->
<div id="oem-modal" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <p>Select OEMs to add to the account.</p>
        	<ul class="uk-list available-oem-list">
        	<?php if(empty($available)) : ?>
        		<li class="empty uk-text-small">No Available OEMs Found!</li>
        	<?php endif; ?>
        	<?php foreach($available as $oem) : ?>
        	<li id="<?php echo $oem->id; ?>" data-name="<?php echo $oem->name; ?>">
	        	<label>
	    			<input type="checkbox">
	    			<?php echo $oem->name; ?>
	    		</label>
    		</li>
    		<?php endforeach; ?>
    		</ul>
    		<button type="button" class="uk-button add-button">Add OEM(s)</button>
    		<button type="button" class="uk-button uk-modal-close">Cancel</button>
    </div>
</div>

<script type="text/javascript">
	jQuery(function($) {
		var selected = {}, available = {};
		function getValues() {
			var _selected = $('.selected-oem-list li');
			var _available = $('.available-oem-list li');
			$.each(_selected, function(k,v) {
				var elem = $(v);
				if(!elem.hasClass('empty')) {
					var id = elem.prop('id');
					var name = elem.data('name');
					console.log(elem);
					selected[id] = name;
				}
			})
			console.log(selected);
			$('button.add-button').prop('disabled',true);
			$.each(_available, function(k,v) {
				var elem = $(v);
				if(!elem.hasClass('empty')) {
					var id = elem.prop('id');
					var name = elem.data('name');
					console.log(elem);
					available[id] = name;
				}
				if(elem.find('input').is(':checked')) {
					$('button.add-button').prop('disabled',false);
				}
			})
			_available.find('input').each(function(k,v){
					if($(v).is(':checked')) {
						console.log('its checked');
						$('button.add-button').prop('disabled', false);
					}

				})
			console.log(available);

		}
		function populateElements() {
			var _selected = $('.selected-oem-list');
			var _available = $('.available-oem-list');
			_selected.find('li').remove();
			_available.find('li').remove();
			if ($.isEmptyObject(selected)) {
				_selected.append('<li class="empty uk-text-small">There are no OEMs assigned to this account.</li>');
			}
			$.each(selected, function(k,v) {
				var li = $('<li></li>').prop('id', k).data('name', v).html(v+'<a href="#" class="uk-close uk-float-right uk-text-muted"></a>');
				var input = $('<input type="hidden" />').val(k).prop('name', '<?php echo $name ?>');
				li.append(input);
				_selected.append(li);
			})
			$.each(available, function(k,v) {
				if(!selected.hasOwnProperty(k)) {
					var li = $('<li></li>').prop('id', k).data('name', v);
					var input = $('<input type="checkbox" />');	
					var label = $('<label></label>').append(input).append(v);
					li.append(label);
					_available.append(li);
				}
			})
			if (_available.find('li').length < 1) {
				_available.append('<li class="empty uk-text-small">No Available OEMs Found!</li>');
			}
			$('button.add-button').prop('disabled', true);
			_available.find('input').on('click', function() {
				
				_available.find('input').each(function(k,v){
					if($(v).is(':checked')) {
						console.log('its checked');
						$('button.add-button').prop('disabled', false);
					}

				})
			})
			
			$('button.add-button').on('click', function(e) {
				e.preventDefault();
				var values = {};

				$('.available-oem-list li').not('.empty').each(function(k,v) {
					var elem = $(v);
					var chkbox = $(v).find('input');
					var id = elem.prop('id');
					if(chkbox.is(':checked')) {
						selected[id] = elem.data('name');
					} else {
						values[id] = elem.data('name')
					}
				})
				UIkit.modal("#oem-modal").hide();
				available = values;
				console.log(available);
				populateElements();
			})
			$('.selected-oem-list li a').on('click',function(e) {
				e.preventDefault();
				var id = $(e.target).closest('li').prop('id');
				console.log(id);
				var values = {};
				$.each(selected, function(k,v) {
					if(k != id) {
						values[k] = v;
					} else {
						available[k] = v
					}
				})
				selected = values;
				console.log(selected);
				populateElements();
			})
		}
		$(document).ready(function() {

			getValues();

			populateElements();
			
		});
	})
</script>