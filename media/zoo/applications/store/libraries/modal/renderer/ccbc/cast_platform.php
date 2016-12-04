<div class="uk-grid" data-uk-grid-margin>
	<div class="uk-width-5-6 uk-container-center">	
		<img src="/images/helpers/casting_platform/diagram.png" alt="" vspace="10" />
	</div>
	<div class="uk-width-1-1">
		<p>The casting platform is located on the bow of the boat and in most cases is removeable.  If your boat has a casting
			platform, it must be removed for the cover to fit properly.</p>
	</div>

</div>
<script>
jQuery(function($){
	$(document).ready(function(){
		
		$('#ccbc-cast_platform-modal').on('save', function(e, data){
            var elem = $('[name="casting_platform"]');
            data.result = true;
            elem.val('R').trigger('change');
        });
        $('#ccbc-cast_platform-modal').on('cancel', function(e, data){
			var elem = $('[name="casting_platform"]');
            data.result = true;
            elem.val('0').trigger('change');
        });
	})
})
</script>
