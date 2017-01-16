
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$page = $this->page;
$order = $this->order;
?>

<?php if($this->user->isReseller()) : ?>
    <div class="uk-width-1-1">
        <button class="uk-button uk-button-primary uk-width-1-3 uk-margin-bottom items-table uk-hidden" data-uk-toggle="{target:'.items-table'}">Hide Full Invoice</button>
        <button class="uk-button uk-button-primary uk-width-1-3 uk-margin-bottom items-table" data-uk-toggle="{target:'.items-table'}">View Full Invoice</button>
    </div>
    <div class='uk-width-1-1 items-table uk-hidden'>
        <?php echo $this->partial('item.table.reseller',compact('order', 'page')); ?>
    </div>
     <div class='uk-width-1-1 items-table'>
        <?php echo $this->partial('item.table',compact('order', 'page')); ?>
    </div>
    <script>
        jQuery(function($) {
            $('button.items-table').on('click', function(e){
                e.preventDefault();
            })
        })
    </script>
<?php else : ?>
    <div class='uk-width-1-1 items-table retail'>
        <?php echo $this->partial('item.table',compact('order', 'page')); ?>
    </div>
<?php endif; ?>