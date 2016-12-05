<ul class="uk-grid" data-uk-grid-margin>
	<li class="uk-width-medium-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<div>
					<label><input name="bowrails_modal_helper" type="radio" value="N" /> No Bow Rail</label>
				</div>
				<div>
					<span>(Pictured Below)</span>
				</div>
			</div>
			<img src="/images/helpers/bowaccessories/CleanerBow.png" alt="CleanerBow" vspace="10" />
		</div>
	</li>
	<li class="uk-width-medium-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<div>
					<label><input name="bowrails_modal_helper" type="radio" value="L" /> Low Bow Rail (Less than 8")</label>
				</div>
				<div>
					(Pictured Below)
				</div>
			</div>
				<img src="/images/helpers/LowBR.png" alt="LowBR" vspace="10" />
		</div>
	</li>
	<li class="uk-width-medium-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<div>
					<label><input name="bowrails_modal_helper" type="radio" value="R" /> Reccessed Bow Rail</label>
				</div>
				<div>
					<span>(Pictured Below)</span>
				</div>
			</div>
			<img src="/images/helpers/RecessedBowRail.png" alt="RecessedBowRail" vspace="10" />
		</div>
	</li>
	<li class="uk-width-medium-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<div>
					<label><input name="bowrails_modal_helper" type="radio" value="H" /> High Bow Rail (More than 9")</label>
				</div>
				<div>
					<span>(Pictured Below)</span>
				</div>
			</div>
			<img src="/images/helpers/HighBR.png" alt="HighBR" vspace="10" />
		</div>
	</li>
	<li class="uk-width-medium-1-2">
		<div class="uk-thumbnail">
			<div class="uk-thumbnail-caption">
				<div>
					<label><input name="bowrails_modal_helper" type="radio" value="WT" /> Walkthrough Bow Rail</label>
				</div>
				<div>
					<span style="font-size: 10pt;">(Pictured Below)</span>
				</div>
			</div>
			<img src="/images/helpers/WalkThrough.png" alt="WalkThrough" vspace="10" />
		</div>
	</li>
</ul>
<div class="uk-width-1-1">
	<label>
		<input name="bowrails_modal_helper" type="radio" value="other" />
		Other<span class="uk-text-danger">(Please leave a description of your bow rails in the additional infomation box on the order page)</span>
	</label>
</div>
<script>
jQuery(function($){
	$(document).ready(function(){
		var value = $('[name="bow_rails"]').val();
		$('input[name="bowrails_modal_helper"][value="'+value+'"]').prop('checked', 'checked');
		
		$('#default-bowrails-modal').on('save', function(e, data){
			var name = data.name;
            var elem = $('[name="bow_rails"]');
            console.log(elem);
            var value = $('[name="bowrails_modal_helper"]:checked').val()
            data.result = true;
            elem.val(value).trigger('change');
        });
	})
})
</script>