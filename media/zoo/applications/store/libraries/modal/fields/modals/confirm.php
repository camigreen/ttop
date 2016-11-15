<?php 
if(isset($args['product'])) {
    $product = $this->app->product->create($args['product']);
} else {
    $product = null;
}

?>

<div class="uk-grid" data-uk-grid-margin="">
    <div class="uk-width-1-1">
        <div class="uk-text-center uk-margin">By typing "yes" in the box below, I certify that the options that I have chosen are correct. I understand that a T-Top Boat Cover is a custom made product and that if I have chosen an option incorrectly it may lead to the T-Top Boat Cover not fitting my boat correctly.</div>
    </div>
    <div class="uk-width-1-1"> 
        <div class="item uk-grid">
            <div class="uk-width-1-1">
                <?php if(!$product) : ?>
                <h4>No Product Found!</h4>
                <?php else : ?> 
                <h4><?php echo $product->name; ?></h4>
                <table class="uk-table uk-table-striped uk-table-condensed">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2">Option</th>
                            <th class="uk-width-1-2">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($product->getOptions() as $option) : ?>
                            <tr>
                                <td><?php echo $option->get('label'); ?>
                                <td><?php echo $option->get('text'); ?>
                            </tr>
                        <?php endforeach; ?> 
                    
                    </tbody>
                </table>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="uk-width-1-1">
        <span>Type "yes" in the box below to confirm that your options have been chosen correctly.</span><br />
        <span class="confirm-error uk-text-danger uk-text-small"></span><br />
        <input type="text" class="uk-width-1-1" name="accept" />
    </div>
    <div class="uk-width-1-1">
        <input type="hidden" name="cart_id" value="" />
    </div>
</div>

<script>
jQuery(function($){
    $(document).ready(function(){
        $('#confirm-modal').on('save', function(e, data){
            var id = data.args.product.id;
            console.log('Saving Confirm Modal');
            console.log(data);
            $('#OrderForm').OrderForm('setItemConfirmation', data.args.product.id, true);
            $('#atc-'+id).trigger('click');
        });
    });
});
</script>