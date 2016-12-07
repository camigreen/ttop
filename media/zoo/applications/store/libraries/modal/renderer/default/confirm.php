<?php 
if(isset($config['args']['item'])) {
    $product = $this->app->product->create($config['args']['item']);
} else {
    $product = null;
}
$uID = uniqid();
?>
<div class="uk-grid uk-form" data-uk-grid-margin="">
    <div class="uk-width-1-1">
        <span>By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that a <?php echo $product->name; ?> is a custom made product and that if I have chosen an option incorrectly it may lead to the <?php echo $product->name; ?> not fitting my boat correctly.</span>
    </div>
    <div class="uk-width-1-1"> 
        <div class="item uk-grid">
            <div class="uk-width-1-1">
                <?php if(!$product) : ?>
                <h4>No Product Found!</h4>
                <?php else : ?> 
                <h4><?php echo $product->name . ' - ' . $product->description; ?></h4>
                <table class="uk-table uk-table-striped uk-table-condensed">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2">Option</th>
                            <th class="uk-width-1-2">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($product->getOptions() as $option) : ?>
                            <?php if($option->get('visible', true)) : ?>
                            <tr>
                                <td><?php echo $option->get('label'); ?>
                                <td <?php echo $option->get('name') == 'add_info' ? 'class="uk-text-left"' : ''; ?>><?php echo $option->get('text'); ?>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?> 
                    
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="uk-width-1-1">
        <span>Type "yes" in the box below to confirm that your options have been chosen correctly.</span><br />
        <span id="confirm-error" class="confirm-error uk-text-danger uk-text-small"></span><br />
        <input type="text" class="uk-width-1-1" name="accept" />
    </div>
    <div class="uk-width-1-1">
        <input type="hidden" name="cart_id" value="" />
    </div>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
        function validate() {
            var value = $('[name="accept"]').val();
            value = value.toLowerCase();
            if( value === 'yes') {
                return true;
            } else {
                $('span.confirm-error').html('You must type "yes" to confirm your order.');
                location.href = "#";
                location.href = "#confirm-error";
                alert('Please type "yes" in the box to confirm your order.');
                return false;
            }
        }

        $('#default-confirm-modal').on('save', function(e, data){
            var item = data.args.item;
            if(validate()) {
                console.log('Saving Confirm Modal');
                item.params.confirmed = true;
                data.triggerResult = true;
                data.callback = function() {
                    $('#atc-'+item.id).trigger('click');
                }
            } else {
                item.params.confirmed = false;
                data.triggerResult = 'break';
            }
        });

        $('#default-confirm-modal').on('cancel', function(e, data){
            var item = data.args.item;
            item.params.confirmed = false;
            data.result = true;
        });
    });
});
</script>