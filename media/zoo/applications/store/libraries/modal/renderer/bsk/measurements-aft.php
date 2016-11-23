
<?php

//var_dump($config['args']['measurements']);
$product = $config['args']['product'];
$product = $this->app->product->create($product);


?>


<div class="uk-grid">
    <div class="uk-width-1-1">
        <label>1) From Rod Holder to Rod Holder</label>
        <div class="uk-grid">
            <div class="uk-width-2-6">
               <input type="number" id="beam" name="beam-width-in" class="required" data-location="beam" data-unit="in" value="<?php echo $product->getOption('beam')->get('value'); ?>"/>
            </div>
            <div class="uk-width-1-6">
                in
            </div>
        </div>
    </div>
    <div class="uk-width-1-1">
        <label>2) T-Top Width Measurement</label>
        <div class="uk-grid">
            <div class="uk-width-2-6">
               <input type="number" id="ttop" name="ttop-width-in" class="required" data-location="ttop" data-unit="in" value="<?php echo $product->getOption('ttop')->get('value'); ?>"/>
            </div>
            <div class="uk-width-1-6">
                in
            </div>
        </div>
    </div>
    <div class="uk-width-1-1">
        <label>3) T-Top to Rod Holders Measurement</label>
        <div class="uk-grid">
            <div class="uk-width-2-6">
               <input type="number" id="ttop2rod" name="ttop2rod-in" class="required" data-location="ttop2rod" data-unit="in" value="<?php echo $product->getOption('ttop2rod')->get('value'); ?>" />
            </div>
            <div class="uk-width-1-6">
                in
            </div>
        </div>
    </div>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
        $('#bsk-measurements-aft-modal input').on('change', function(e) {
            var name = $(this).prop('id');
            var p = products['bsk-aft'];
            p.options[name].value = $(this).val();
            $('#OrderForm-bsk').trigger('measure', {item: products['bsk-aft'], type: 'aft'});
        })
        $('#bsk-measurements-aft-modal').on('save', function(e, data){
            $('#OrderForm-bsk').trigger('measure', {item: products['bsk-aft'], type: 'aft'});
            data.result = true;
        }); 
        $('#bsk-measurements-modal').on('cancel', function(e, data){
            console.log(data);
            data.result = true;
        }); 
    });

})

</script>